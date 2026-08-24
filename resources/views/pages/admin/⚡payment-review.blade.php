<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Payment;
use App\Services\FinancialService;
use Illuminate\Support\Facades\Storage;

new #[Layout('layouts.admin')] class extends Component {
    public function approvePayment($paymentId) {
        $payment = Payment::findOrFail($paymentId);
        $invoice = $payment->invoice;

        try {
            $financialService = app(FinancialService::class);
            $financialService->completePayment($payment);

            session()->flash('message', "Payment approved and invoice updated.");
        } catch (\Exception $e) {
            session()->flash('error', "Failed to approve payment: " . $e->getMessage());
        }
    }

    public function rejectPayment($paymentId) {
        $payment = Payment::findOrFail($paymentId);
        $payment->update(['status' => 'FAILED']);

        session()->flash('message', "Payment rejected.");
    }

    public function viewProof($path) {
        return Storage::url($path);
    }
};
?>

<div class="p-4 sm:p-6">
    <div class="mb-6 sm:mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Pending Payments</h1>
        <p class="text-sm sm:text-base text-gray-500">
            Review and approve manual payment notifications from customers.
        </p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl text-sm font-medium">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl text-sm font-medium">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-4 sm:gap-6">
        @php
            $pendingPayments = \App\Models\Payment::with(['invoice.shipment'])
                ->where('status', 'PENDING')
                ->latest()
                ->get();
        @endphp

        @if ($pendingPayments->isEmpty())
            <div class="text-center py-16 sm:py-20 px-4 bg-white rounded-3xl border border-dashed border-gray-300">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-900">No Pending Payments</h3>
                <p class="text-gray-500 mt-1">
                    All caught up! No payments awaiting review.
                </p>
            </div>
        @else
            @foreach ($pendingPayments as $payment)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-4 sm:p-6">
                        <div class="flex flex-col md:flex-row justify-between gap-6">
                            <div class="space-y-4 min-w-0">
                                <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                                    <div class="px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold uppercase tracking-wider">
                                        Pending Review
                                    </div>
                                    <span class="text-xs text-gray-400 font-mono truncate">Ref: {{ $payment->transaction_reference }}</span>
                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 md:gap-x-12 gap-y-4">
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase">
                                            Invoice / Tracking
                                        </p>
                                        <p class="text-sm font-semibold text-gray-900 break-words">
                                            #{{ $payment->invoice->invoice_number }} / {{ $payment->invoice->shipment->tracking_number }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase">
                                            Customer
                                        </p>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $payment->invoice->shipment->receiver_name }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase">
                                            Method
                                        </p>
                                        <p class="text-sm font-semibold text-gray-900">
                                            {{ $payment->getPaymentMethodLabel() }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase">
                                            Amount Submitted
                                        </p>
                                        <p class="text-lg font-extrabold text-indigo-600">
                                            {{ $payment->invoice->currency }} {{ number_format($payment->amount, 2) }}
                                        </p>
                                    </div>
                                </div>

                                @if ($payment->payment_proof)
                                    <div class="pt-4">
                                        <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-semibold text-indigo-600 hover:text-indigo-700 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                            View Payment Proof
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-row md:flex-col gap-3 md:justify-center">
                                <button wire:click="approvePayment({{ $payment->id }})"
                                    wire:confirm="Approve this payment of {{ $payment->invoice->currency }} {{ number_format($payment->amount, 2) }}? This will mark the invoice as paid/partially paid and generate a receipt."
                                    wire:loading.attr="disabled"
                                    wire:target="approvePayment({{ $payment->id }})"
                                    class="flex-1 md:flex-none bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-xl text-sm transition disabled:opacity-50">
                                    <span wire:loading.remove wire:target="approvePayment({{ $payment->id }})">Approve Payment</span>
                                    <span wire:loading wire:target="approvePayment({{ $payment->id }})">Approving...</span>
                                </button>
                                <button wire:click="rejectPayment({{ $payment->id }})"
                                    wire:confirm="Reject this payment? This cannot be undone and the customer will need to resubmit."
                                    wire:loading.attr="disabled"
                                    wire:target="rejectPayment({{ $payment->id }})"
                                    class="flex-1 md:flex-none bg-white border border-red-200 text-red-600 hover:bg-red-50 font-bold py-2 px-6 rounded-xl text-sm transition disabled:opacity-50">
                                    <span wire:loading.remove wire:target="rejectPayment({{ $payment->id }})">Reject Payment</span>
                                    <span wire:loading wire:target="rejectPayment({{ $payment->id }})">Rejecting...</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>