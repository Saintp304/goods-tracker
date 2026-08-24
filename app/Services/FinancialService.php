<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Receipt;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class FinancialService
{
    /**
     * Create a new invoice for a shipment.
     */
    public function createInvoice(Shipment $shipment, array $data): Invoice
    {
        return DB::transaction(function () use ($shipment, $data) {
            $invoice = new Invoice();
            $invoice->invoice_number = 'INV-' . strtoupper(Str::random(10));
            $invoice->shipment_id = $shipment->id;
            $invoice->issue_date = $data['issue_date'] ?? Carbon::now()->toDateString();
            $invoice->due_date = $data['due_date'] ?? Carbon::now()->addDays(14)->toDateString();
            $invoice->currency = $data['currency'] ?? 'USD';
            $invoice->subtotal = $data['subtotal'];
            $invoice->tax = $data['tax'] ?? 0;
            $invoice->total = $data['subtotal'] + ($data['tax'] ?? 0);
            $invoice->status = 'OPEN';
            $invoice->save();

            return $invoice;
        });
    }

    /**
     * Record a new payment against an invoice.
     */
    public function recordPayment(Invoice $invoice, array $data): Payment
    {
        if (!isset($data['payment_type']) || !array_key_exists($data['payment_type'], Payment::getPaymentTypes())) {
            throw new \InvalidArgumentException("Invalid payment type provided.");
        }

        if (!isset($data['payment_method']) || !array_key_exists($data['payment_method'], Payment::getPaymentMethods())) {
            throw new \InvalidArgumentException("Invalid payment method provided.");
        }

        return DB::transaction(function () use ($invoice, $data) {
            $payment = new Payment();
            $payment->invoice_id = $invoice->id;
            $payment->payment_type = $data['payment_type'];
            $payment->amount = $data['amount'];
            $payment->payment_date = $data['payment_date'] ?? Carbon::now();
            $payment->payment_method = $data['payment_method'];
            $payment->transaction_reference = $data['transaction_reference'] ?? null;
            $payment->payment_proof = $data['payment_proof'] ?? null;
            $payment->status = 'PENDING';
            $payment->save();

            return $payment;
        });
    }

    /**
     * Mark a payment as completed and update invoice status.
     */
    public function completePayment(Payment $payment): Receipt
    {
        return DB::transaction(function () use ($payment) {
            $payment->refresh();
            if ($payment->status === 'COMPLETED') {
                if (!$payment->receipt) {
                    throw new \Exception("Payment is marked as COMPLETED but no receipt was found.");
                }
                return $payment->receipt;
            }

            $invoice = $payment->invoice;
            $amount = $payment->amount;

            // Check for overpayment
            $remainingBalance = $this->calculateRemainingBalance($invoice);
            if ($amount > $remainingBalance) {
                throw new \Exception("Payment amount exceeds remaining balance of {$invoice->currency} {$remainingBalance}");
            }

            // Mark payment as completed
            $payment->status = 'COMPLETED';
            $payment->save();

            // Generate receipt
            $receipt = $this->generateReceipt($payment);

            // Update invoice status
            $this->updateInvoicePaymentStatus($invoice);

            // Send confirmation email
            try {
                if ($invoice->shipment->receiver_email) {
                    \Illuminate\Support\Facades\Mail::to($invoice->shipment->receiver_email)
                        ->send(new \App\Mail\PaymentConfirmed($payment, $invoice->shipment));
                }
            } catch (\Exception $e) {
                // Log email failure but don't roll back transaction
                error_log("Payment confirmation email failed: " . $e->getMessage());
            }

            return $receipt;
        });
    }

    /**
     * Handle payment refund.
     */
    public function refundPayment(Payment $payment): void
    {
        DB::transaction(function () use ($payment) {
            $payment->status = 'REFUNDED';
            $payment->save();

            $this->updateInvoicePaymentStatus($payment->invoice);
        });
    }

    /**
     * Update the invoice payment status based on completed payments.
     */
    public function updateInvoicePaymentStatus(Invoice $invoice): void
    {
        $invoice->refresh();
        if ($invoice->status === 'CANCELLED') {
            return;
        }

        $completedTotal = $this->getTotalCompletedPayments($invoice);
        $total = $invoice->total;

        if ($completedTotal <= 0) {
            $invoice->status = 'OPEN';
        } elseif ($completedTotal < $total) {
            $invoice->status = 'PARTIALLY_PAID';
        } else {
            $invoice->status = 'PAID';
        }

        $invoice->save();
    }

    /**
     * Generate a unique receipt for a completed payment.
     */
    protected function generateReceipt(Payment $payment): Receipt
    {
        if ($payment->receipt) {
            return $payment->receipt;
        }

        if ($payment->status !== 'COMPLETED') {
            throw new \Exception("Receipts can only be generated for COMPLETED payments.");
        }

        $receipt = new Receipt();
        $receipt->payment_id = $payment->id;
        $receipt->receipt_number = 'REC-' . strtoupper(Str::random(12));
        $receipt->issued_at = Carbon::now();
        $receipt->save();

        return $receipt;
    }

    /**
     * Calculate total of all COMPLETED payments for an invoice.
     */
    public function getTotalCompletedPayments(Invoice $invoice): float
    {
        return (float) $invoice->payments()
            ->where('status', 'COMPLETED')
            ->sum('amount');
    }

    /**
     * Calculate remaining balance for an invoice.
     */
    public function calculateRemainingBalance(Invoice $invoice): float
    {
        return (float) ($invoice->total - $this->getTotalCompletedPayments($invoice));
    }
}
