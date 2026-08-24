<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Payment;
use App\Models\Receipt;

new #[Title('View Receipt')]
#[Layout('layouts.admin')]
class extends Component
{
    public Payment $payment;
    public ?Receipt $receipt = null;

    public function mount(Payment $payment): void
    {
        $this->payment = $payment;
        $this->receipt = $payment->receipt;

        if (!$this->receipt || $this->payment->status !== 'COMPLETED') {
            session()->flash('error', 'A receipt is only available for completed payments.');
            $this->redirect(route('admin.shipments.edit', $this->payment->invoice->shipment_id), navigate: true);
            return;
        }
    }
};
?>

<div class="max-w-4xl mx-auto space-y-6 pb-12">
    <div class="flex justify-between items-center no-print">
        <a href="{{ route('admin.shipments.edit', $payment->invoice->shipment_id) }}" wire:navigate
            class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition">
            ← Back to Shipment
        </a>
        <button onclick="window.print()"
            class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gray-900 hover:bg-black transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4m8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4m4 0h4"/>
            </svg>
            Print Receipt
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 md:p-12 print:border-0 print:shadow-none" id="receipt-document">
        {{-- Receipt Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-12">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-black text-gray-900 uppercase tracking-tighter">Payment Receipt</h1>
                    <p class="text-sm font-mono text-gray-500"># {{ $receipt->receipt_number }}</p>
                </div>
            </div>
            <div class="text-left md:text-right">
                <h2 class="text-xl font-bold text-gray-900">Goods Tracker Ltd.</h2>
                <p class="text-sm text-gray-500">123 Logistics Way, Shipping City</p>
                <p class="text-sm text-gray-500">contact@goodstracker.com</p>
                <p class="text-sm text-gray-500">+1 (555) 000-1111</p>
            </div>
        </div>

        <div class="grid md:grid-cols-2 gap-12 mb-12">
            <div class="space-y-4">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Payment For</p>
                    <p class="text-lg font-bold text-gray-900">{{ $payment->invoice->shipment->receiver_name }}</p>
                    <p class="text-sm text-gray-600">Shipment: {{ $payment->invoice->shipment->tracking_number }}</p>
                    <p class="text-sm text-gray-600">Invoice: {{ $payment->invoice->invoice_number }}</p>
                </div>
            </div>
            <div class="md:text-right space-y-2">
                <div class="flex md:justify-end gap-2 text-sm">
                    <span class="text-gray-400 font-medium">Date:</span>
                    <span class="text-gray-900 font-semibold">{{ $receipt->issued_at->format('M d, Y • h:i A') }}</span>
                </div>
                <div class="flex md:justify-end gap-2 text-sm">
                    <span class="text-gray-400 font-medium">Type:</span>
                    <span class="text-gray-900 font-semibold">{{ $payment->getPaymentTypeLabel() }}</span>
                </div>
                <div class="flex md:justify-end gap-2 text-sm">
                    <span class="text-gray-400 font-medium">Method:</span>
                    <span class="text-gray-900 font-semibold">{{ $payment->getPaymentMethodLabel() }}</span>
                </div>
                <div class="flex md:justify-end gap-2 text-sm">
                    <span class="text-gray-400 font-medium">Reference:</span>
                    <span class="text-gray-900 font-mono font-semibold">{{ $payment->transaction_reference ?? 'N/A' }}</span>
                </div>
            </div>
        </div>

        {{-- Amount Section --}}
        <div class="bg-gray-50 rounded-2xl p-8 text-center border border-gray-100 mb-12">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Amount Received</p>
            <p class="text-5xl font-black text-gray-900">
                {{ $payment->invoice->currency }} {{ number_format($payment->amount, 2) }}
            </p>
            <div class="flex items-center justify-center gap-2 mt-2">
                <span class="text-sm text-gray-500">Payment status:</span>
                <span class="text-sm font-bold uppercase text-green-600">Completed</span>
            </div>
        </div>

        <div class="text-center space-y-4">
            <div class="w-32 h-32 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 opacity-50">
                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-sm text-gray-500 italic">This is a computer-generated receipt and does not require a physical signature.</p>
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .max-w-4xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        #receipt-document { border: 0 !important; box-shadow: none !important; padding: 0 !important; }
    }
</style>
