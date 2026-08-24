<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Receipt;
use App\Models\Payment;

new #[Layout('layouts.reciept')] class extends Component {
public ?Receipt $receipt = null;
public ?Payment $payment = null;
public bool $notFound = false;

public function mount($receiptNumber): void
{
  $this->receipt = Receipt::where('receipt_number', $receiptNumber)->first();

  if (!$this->receipt) {
    $this->notFound = true;
    return;
  }

  $this->payment = $this->receipt->payment;
}
};
?>

<div class="min-h-screen py-12 px-4 sm:px-6 lg:px-8 bg-gray-50" style="font-family: 'Sora', sans-serif;">
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
@media print {
.no-print {
display: none !important;
}
body {
background: white !important;
}
.invoice-container {
box-shadow: none !important;
border: none !important;
width: 100% !important;
max-width: none !important;
margin: 0 !important;
padding: 0 !important;
}
}
</style>

@if ($notFound)
<div class="max-w-md mx-auto text-center py-20">
<div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 bg-red-50">
<svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>
</div>
<h2 class="text-2xl font-bold text-gray-900">Receipt Not Found</h2>
<p class="text-gray-500 mt-2">
The requested receipt could not be found.
</p>
<a href="/track" class="mt-6 inline-block text-indigo-600 font-semibold hover:text-indigo-500">← Back to Tracking</a>
</div>
@else
<div class="max-w-3xl mx-auto">
<div class="no-print flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
<a href="/track?trackingNumber={{ $payment->invoice->shipment->tracking_number }}" class="flex items-center gap-2 text-gray-500 hover:text-gray-700 transition text-sm font-medium">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
Back to Tracking
</a>
<button onclick="window.print()" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 transition shadow-sm">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
Print Receipt
</button>
</div>

<div class="bg-white shadow-xl border border-gray-100 rounded-3xl overflow-hidden invoice-container">
<div class="bg-indigo-600 p-6 sm:p-8 text-white flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 sm:gap-0">
<div>
<h1 class="text-2xl sm:text-3xl font-extrabold">TrackGoods</h1>
<p class="text-indigo-100 text-sm opacity-80">
Payment Receipt
</p>
</div>
<div class="text-left sm:text-right">
<p class="text-xs uppercase tracking-widest text-indigo-200 font-bold mb-1">
Receipt No
</p>
<p class="text-2xl font-mono font-bold">
{{ $receipt->receipt_number }}
</p>
</div>
</div>

<div class="p-6 sm:p-8 md:p-12">
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 mb-12">
<div>
<p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">
Payment Details
</p>
<div class="space-y-2 text-sm">
<div class="flex flex-wrap justify-between gap-x-2 gap-y-0.5">
<span class="text-gray-500">Date:</span>
<span class="font-semibold text-gray-900 text-right break-words">{{ $payment->payment_date->format('M d, Y h:i A') }}</span>
</div>
<div class="flex flex-wrap justify-between gap-x-2 gap-y-0.5">
<span class="text-gray-500">Invoice:</span>
<span class="font-mono font-semibold text-gray-900 text-right break-all">#{{ $payment->invoice->invoice_number }}</span>
</div>
<div class="flex flex-wrap justify-between gap-x-2 gap-y-0.5">
<span class="text-gray-500">Tracking:</span>
<span class="font-mono font-semibold text-gray-900 text-right break-all">{{ $payment->invoice->shipment->tracking_number }}</span>
</div>
<div class="flex flex-wrap justify-between gap-x-2 gap-y-0.5">
<span class="text-gray-500">Method:</span>
<span class="font-semibold text-gray-900 text-right">{{ $payment->getPaymentMethodLabel() }}</span>
</div>
<div class="flex flex-wrap justify-between gap-x-2 gap-y-0.5">
<span class="text-gray-500">Payment Type:</span>
<span class="font-semibold text-gray-900 text-right">{{ $payment->payment_type === 'pay_on_delivery' ? 'Pay on Delivery' : 'Instant' }}</span>
</div>
<div class="flex flex-wrap justify-between gap-x-2 gap-y-0.5">
<span class="text-gray-500">Reference:</span>
<span class="font-mono font-semibold text-gray-900 text-right break-all">{{ $payment->transaction_reference }}</span>
</div>
</div>
</div>

<div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 text-center">
<p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-2">
Amount Paid
</p>
<p class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-indigo-600 font-mono break-all">
{{ $payment->invoice->currency }} {{ number_format($payment->amount, 2) }}
</p>
<div class="mt-4 inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold uppercase tracking-wider">
Payment Completed
</div>
</div>
</div>

<div class="text-center border-t border-gray-100 pt-8">
<p class="text-gray-400 text-sm mb-1">
Thank you for your payment!
</p>
<p class="text-gray-500 text-xs">
This is an electronically generated receipt and does not require a physical signature.
</p>
</div>
</div>
</div>
</div>
@endif
</div>