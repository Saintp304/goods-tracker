<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\FinancialService;

new #[Title('Record Payment')]
#[Layout('layouts.admin')]
class extends Component
{
    public Shipment $shipment;
    public ?Invoice $invoice = null;

    public float $amount = 0;
    public string $payment_date = '';
    public string $payment_type = 'instant';
    public string $payment_method = 'cash';
    public ?string $transaction_reference = null;
    public string $status = 'PENDING';

    public function mount(Shipment $shipment, FinancialService $financialService): void
    {
        $this->shipment = $shipment;
        $this->invoice = $shipment->invoice;

        if (!$this->invoice) {
            session()->flash('error', 'No invoice exists for this shipment. An invoice is created automatically when the shipment is marked as Held.');
            $this->redirect(route('admin.shipments.edit', $shipment->id), navigate: true);
            return;
        }

        if ($this->shipment->status !== 'held') {
            session()->flash('error', 'Payments can only be recorded while the shipment is on Customs Hold. Change the status to Held from the Tracking tab first.');
            $this->redirect(route('admin.shipments.edit', $shipment->id), navigate: true);
            return;
        }

        $this->payment_date = now()->toDateString();
        $this->amount = $this->invoice->total - $financialService->getTotalCompletedPayments($this->invoice);
    }

    public function save(FinancialService $financialService): void
    {
        // Re-check on submit too — status could have changed between page load and save
        if ($this->shipment->fresh()->status !== 'held') {
            session()->flash('error', 'This shipment is no longer on Customs Hold. Payment was not recorded.');
            $this->redirect(route('admin.shipments.edit', $this->shipment->id), navigate: true);
            return;
        }

        $this->validate([
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_type' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'transaction_reference' => 'nullable|string|max:255',
            'status' => 'required|in:PENDING,COMPLETED,FAILED,REFUNDED',
        ]);

        $data = [
            'amount' => $this->amount,
            'payment_date' => \Carbon\Carbon::parse($this->payment_date),
            'payment_type' => $this->payment_type,
            'payment_method' => $this->payment_method,
            'transaction_reference' => $this->transaction_reference,
        ];

        $payment = $financialService->recordPayment($this->invoice, $data);

        if ($this->status === 'COMPLETED') {
            try {
                $financialService->completePayment($payment);
            } catch (\Exception $e) {
                session()->flash('error', 'Could not complete payment: ' . $e->getMessage());
                return;
            }
        } else {
            $payment->status = $this->status;
            $payment->save();
            $financialService->updateInvoicePaymentStatus($this->invoice);
        }

        session()->flash('success', 'Payment recorded successfully.');
        $this->redirect(route('admin.shipments.edit', $this->shipment->id), navigate: true);
    }
};
?>

<div class="max-w-3xl mx-auto space-y-6 pb-12">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-row justify-between items-start gap-3">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl font-bold text-gray-900">Record Payment</h1>
                <p class="text-xs sm:text-sm text-gray-500 font-mono truncate">Shipment: {{ $shipment->tracking_number }} | Invoice: {{ $invoice->invoice_number }}</p>
            </div>
            <a href="{{ route('admin.shipments.edit', $shipment->id) }}" wire:navigate
                class="shrink-0 text-sm font-semibold text-gray-600 hover:text-gray-900 transition px-3 py-1.5 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
        </div>

        <div class="p-4 sm:p-6 space-y-6">
            <div class="bg-red-50 p-4 rounded-xl border border-red-100 flex items-center gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                </svg>
                <p class="text-xs text-red-700 font-semibold">This shipment is on Customs Hold — recording a payment here reflects toward its release.</p>
            </div>

            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2">
                <span class="text-sm font-medium text-indigo-600">Invoice Total: {{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
                <span class="text-sm font-bold text-indigo-700">Balance: {{ $invoice->currency }} {{ number_format($invoice->total - $invoice->payments()->where('status', 'COMPLETED')->sum('amount'), 2) }}</span>
            </div>

            <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Amount to Pay</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 font-medium">{{ $invoice->currency }}</span>
                        <input type="number" step="0.01" wire:model="amount"
                            class="w-full pl-14 pr-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    </div>
                    @error('amount') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Payment Date</label>
                    <input type="date" wire:model="payment_date"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    @error('payment_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Payment Status</label>
                    <select wire:model="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 font-semibold">
                        <option value="PENDING">Pending</option>
                        <option value="COMPLETED">Completed</option>
                        <option value="FAILED">Failed</option>
                        <option value="REFUNDED">Refunded</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2 grid sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Payment Type</label>
                        <select wire:model="payment_type"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">
                            <option value="instant">Instant Payment</option>
                            <option value="pay_on_delivery">Pay on Delivery</option>
                        </select>
                        @error('payment_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Payment Method</label>
                        <select wire:model="payment_method"
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">
                            <option value="cash">Cash</option>
                            <option value="bank_transfer">Bank Transfer</option>
                            <option value="card">Card</option>
                            <option value="paypal">PayPal</option>
                            <option value="crypto">Crypto</option>
                        </select>
                        @error('payment_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Transaction / Reference Number</label>
                    <input type="text" wire:model="transaction_reference" placeholder="e.g. TXN-123456789"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                </div>
            </div>

            <div class="pt-6 border-t border-gray-100 flex justify-end">
                <button wire:click="save" wire:loading.attr="disabled"
                    class="w-full sm:w-auto px-8 py-3 rounded-xl text-white text-sm font-bold transition hover:-translate-y-0.5 shadow-md"
                    style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
                    <span wire:loading.remove wire:target="save">Record Payment</span>
                    <span wire:loading wire:target="save">Processing...</span>
                </button>
            </div>
        </div>
    </div>
</div>