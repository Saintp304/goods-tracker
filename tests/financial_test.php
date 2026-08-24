<?php

use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Receipt;
use App\Services\FinancialService;
use Carbon\Carbon;
use Illuminate\Support\Str;

$service = new FinancialService();

// Clear previous test data
App\Models\Receipt::query()->delete();
App\Models\Payment::query()->delete();
App\Models\Invoice::query()->delete();
App\Models\Shipment::query()->delete();

// Setup
$shipment = new Shipment();
$shipment->tracking_number = 'TEST-SHIP-' . strtoupper(Str::random(5));
$shipment->sender_name = 'S1';
$shipment->receiver_name = 'R1';
$shipment->origin = 'O1';
$shipment->destination = 'D1';
$shipment->save();

echo "--- Testing Basic Invoice and Payments ---\n";
$invoice = $service->createInvoice($shipment, [
    'subtotal' => 1000,
    'tax' => 100,
    'currency' => 'USD'
]);
echo "Invoice created: " . $invoice->invoice_number . " Total: " . $invoice->total . " Status: " . $invoice->status . "\n";

echo "--- Testing Combination: Pay on Delivery + Cash ---\n";
$p1 = $service->recordPayment($invoice, [
    'payment_type' => 'pay_on_delivery',
    'payment_method' => 'cash',
    'amount' => 200,
]);
$receipt1 = $service->completePayment($p1);
echo "POD+Cash: " . $p1->payment_type . "/" . $p1->payment_method . " Status: " . $p1->status . " Receipt: " . $receipt1->receipt_number . "\n";

echo "--- Testing Combination: Pay on Delivery + Bank Transfer ---\n";
$p2 = $service->recordPayment($invoice, [
    'payment_type' => 'pay_on_delivery',
    'payment_method' => 'bank_transfer',
    'amount' => 300,
]);
$receipt2 = $service->completePayment($p2);
echo "POD+Bank: " . $p2->payment_type . "/" . $p2->payment_method . " Status: " . $p2->status . " Receipt: " . $receipt2->receipt_number . "\n";

echo "--- Testing Combination: Instant + Card ---\n";
$p3 = $service->recordPayment($invoice, [
    'payment_type' => 'instant',
    'payment_method' => 'card',
    'amount' => 200,
]);
$receipt3 = $service->completePayment($p3);
echo "Instant+Card: " . $p3->payment_type . "/" . $p3->payment_method . " Status: " . $p3->status . " Receipt: " . $receipt3->receipt_number . "\n";

echo "--- Testing Combination: Instant + PayPal ---\n";
$p4 = $service->recordPayment($invoice, [
    'payment_type' => 'instant',
    'payment_method' => 'paypal',
    'amount' => 200,
]);
$receipt4 = $service->completePayment($p4);
echo "Instant+PayPal: " . $p4->payment_type . "/" . $p4->payment_method . " Status: " . $p4->status . " Receipt: " . $receipt4->receipt_number . "\n";

echo "--- Testing Combination: Instant + Crypto ---\n";
$p5 = $service->recordPayment($invoice, [
    'payment_type' => 'instant',
    'payment_method' => 'crypto',
    'amount' => 200,
]);
$receipt5 = $service->completePayment($p5);
echo "Instant+Crypto: " . $p5->payment_type . "/" . $p5->payment_method . " Status: " . $p5->status . " Receipt: " . $receipt5->receipt_number . "\n";

echo "--- Testing Final Invoice Status ---\n";
$invoice->refresh();
echo "Final Invoice Status: " . $invoice->status . " Total Collected: " . $service->getTotalCompletedPayments($invoice) . "\n";
if ($invoice->status == 'PAID') echo "PASS: Invoice is PAID\n"; else echo "FAIL: Invoice status is " . $invoice->status . "\n";

echo "--- Testing Overpayment Rejection ---\n";
try {
    $pOver = $service->recordPayment($invoice, [
        'payment_type' => 'instant',
        'payment_method' => 'card',
        'amount' => 1,
    ]);
    $service->completePayment($pOver);
    echo "FAIL: Overpayment accepted\n";
} catch (\Exception $e) {
    echo "PASS: Overpayment rejected: " . $e->getMessage() . "\n";
}

echo "--- Testing Refund and Recalculation ---\n";
$service->refundPayment($p1);
echo "Refunded p1. Invoice status: " . $invoice->fresh()->status . "\n";
if ($invoice->fresh()->status == 'PARTIALLY_PAID') echo "PASS: Status is PARTIALLY_PAID\n"; else echo "FAIL: Status is " . $invoice->status . "\n";

echo "--- Testing Overdue Calculation ---\n";
$invoiceOverdue = $service->createInvoice($shipment, [
    'subtotal' => 100,
    'currency' => 'USD',
    'due_date' => Carbon::now()->subDays(1)->toDateString()
]);
if ($invoiceOverdue->isOverdue()) echo "PASS: Invoice is overdue\n"; else echo "FAIL: Invoice not overdue\n";
