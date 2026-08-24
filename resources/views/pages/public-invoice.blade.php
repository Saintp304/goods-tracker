<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use App\Services\FinancialService;

new #[Title('Invoice - TrackGoods')] #[Layout('layouts.reciept')] class extends Component
{
  public ?Shipment $shipment = null;
  public ?\App\Models\Invoice $invoice = null;
  public float $paidAmount = 0;
  public float $balance = 0;
  public bool $notFound = false;
  public ?string $receiptNumber = null;

  public function mount($trackingNumber): void
  {
    $this->shipment = Shipment::where('tracking_number', strtoupper(trim($trackingNumber)))
    ->with('invoice')
    ->first();

    if (!$this->shipment || !$this->shipment->invoice) {
      $this->notFound = true;
      return;
    }

    $this->invoice = $this->shipment->invoice;
    $this->paidAmount = app(FinancialService::class)->getTotalCompletedPayments($this->invoice);
    $this->balance = app(FinancialService::class)->calculateRemainingBalance($this->invoice);

    $completedPayment = $this->invoice->payments()
    ->where('status', 'COMPLETED')
    ->whereHas('receipt')
    ->with('receipt')
    ->first();

    $this->receiptNumber = $completedPayment?->receipt?->receipt_number;
  }
};
?>

<div class="min-h-screen py-8 px-4 sm:px-6 lg:px-8 bg-gray-50" style="font-family: 'Sora', sans-serif;">
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
    <h2 class="text-2xl font-bold text-gray-900">Invoice Not Found</h2>
    <p class="text-gray-500 mt-2">
      The requested invoice could not be found for this tracking number.
    </p>
    <a href="/track" class="mt-6 inline-block text-indigo-600 font-semibold hover:text-indigo-500">← Back to Tracking</a>
  </div>
  @else
  <div class="max-w-4xl mx-auto">
    <!-- Action Bar -->
    <div class="no-print flex justify-between items-center mb-8">
      <a href="/track?trackingNumber={{ $shipment->tracking_number }}" class="flex items-center gap-2 text-gray-500 hover:text-gray-700 transition text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
        Back to Tracking
      </a>
      <button onclick="window.print()" class="bg-white border border-gray-200 text-gray-700 hover:bg-gray-50 px-4 py-2 rounded-lg text-sm font-semibold flex items-center gap-2 transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
        Print Invoice
      </button>
    </div>

    <!-- Invoice Card -->
    <div class="invoice-container bg-white shadow-xl border border-gray-100 rounded-3xl overflow-hidden">
      <!-- Header -->
      <div class="bg-indigo-600 p-8 md:p-12 text-white">
        <div class="flex flex-col md:flex-row justify-between gap-8">
          <div>
            <h1 class="text-3xl font-extrabold tracking-tight">TrackGoods</h1>
            <p class="text-indigo-100 text-sm mt-1 opacity-80">
              Global Logistics & Shipping Solutions
            </p>
          </div>
          <div class="text-left md:text-right">
            <p class="text-xs uppercase tracking-widest text-indigo-200 font-bold mb-1">
              Tax Invoice
            </p>
            <p class="text-2xl font-mono font-bold">
              #{{ $invoice->invoice_number }}
            </p>
          </div>
        </div>
      </div>

      <div class="p-8 md:p-12">
        <!-- Meta Info -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
          <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">
              Issue Date
            </p>
            <p class="text-gray-900 font-semibold">
              {{ $invoice->issue_date->format('M d, Y') }}
            </p>
          </div>
          <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">
              Due Date
            </p>
            <p class="text-gray-900 font-semibold">
              {{ $invoice->due_date?->format('M d, Y') ?? 'N/A' }}
            </p>
          </div>
          <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">
              Tracking Number
            </p>
            <p class="text-indigo-600 font-mono font-bold">
              {{ $shipment->tracking_number }}
            </p>
          </div>
        </div>

        <!-- Parties -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 mb-12">
          <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">
              Sender
            </p>
            <div class="text-gray-900">
              <p class="font-bold text-lg">
                {{ $shipment->sender_name }}
              </p>
              <p class="text-sm text-gray-500 mt-1">
                {{ $shipment->sender_phone }}
              </p>
              <p class="text-sm text-gray-500">
                {{ $shipment->sender_country }}
              </p>
            </div>
          </div>
          <div>
            <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">
              Receiver
            </p>
            <div class="text-gray-900">
              <p class="font-bold text-lg">
                {{ $shipment->receiver_name }}
              </p>
              <p class="text-sm text-gray-500 mt-1">
                {{ $shipment->receiver_email }}
              </p>
              <p class="text-sm text-gray-500">
                {{ $shipment->receiver_phone }}
              </p>
              <p class="text-sm text-gray-500">
                {{ $shipment->receiver_country }}
              </p>
            </div>
          </div>
        </div>

        <!-- Package Info -->
        <div class="bg-gray-50 rounded-2xl p-6 mb-12 border border-gray-100">
          <p class="text-xs uppercase tracking-widest text-gray-400 font-bold mb-3">
            Shipment Details
          </p>
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div>
              <p class="text-xs text-gray-500">
                Type
              </p>
              <p class="font-semibold text-gray-900 text-sm">
                {{ $shipment->package_type ?? 'Standard' }}
              </p>
            </div>
            <div>
              <p class="text-xs text-gray-500">
                Weight
              </p>
              <p class="font-semibold text-gray-900 text-sm">
                {{ $shipment->package_weight }} kg
              </p>
            </div>
            <div>
              <p class="text-xs text-gray-500">
                Quantity
              </p>
              <p class="font-semibold text-gray-900 text-sm">
                {{ $shipment->package_quantity }} unit(s)
              </p>
            </div>
            <div>
              <p class="text-xs text-gray-500">
                Route
              </p>
              <p class="font-semibold text-gray-900 text-sm">
                {{ $shipment->origin }} → {{ $shipment->destination }}
              </p>
            </div>
          </div>
        </div>

        <!-- Charges Table -->
        <div class="mb-12">
          <table class="w-full text-left">
            <thead>
              <tr class="border-b border-gray-100">
                <th class="py-4 text-xs uppercase tracking-widest text-gray-400 font-bold">Description</th>
                <th class="py-4 text-right text-xs uppercase tracking-widest text-gray-400 font-bold">Amount</th>
              </tr>
            </thead>
            <tbody class="text-gray-700">
              <tr class="border-b border-gray-50">
                <td class="py-4 font-medium">Shipping & Handling</td>
                <td class="py-4 text-right font-mono">{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</td>
              </tr>
              <tr class="border-b border-gray-50">
                <td class="py-4 font-medium">Taxes & Duties</td>
                <td class="py-4 text-right font-mono">{{ $invoice->currency }} {{ number_format($invoice->tax, 2) }}</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Totals -->
        <div class="flex flex-col md:flex-row justify-end gap-8">
          <div class="w-full md:w-64 space-y-3">
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Subtotal</span>
              <span class="font-mono font-medium">{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</span>
            </div>
            <div class="flex justify-between text-sm">
              <span class="text-gray-500">Tax</span>
              <span class="font-mono font-medium">{{ $invoice->currency }} {{ number_format($invoice->tax, 2) }}</span>
            </div>
            <div class="flex justify-between text-lg font-bold border-t border-gray-100 pt-3">
              <span class="text-gray-900">Total</span>
              <span class="font-mono text-indigo-600">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
            </div>
          </div>
        </div>

        <!-- Payment Status Section -->
        <div class="mt-12 pt-12 border-t border-gray-100">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
              <p class="text-xs text-gray-500 mb-1">
                Amount Paid
              </p>
              <p class="text-lg font-bold text-green-600 font-mono">
                {{ $invoice->currency }} {{ number_format($paidAmount, 2) }}
              </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
              <p class="text-xs text-gray-500 mb-1">
                Balance Due
              </p>
              <p class="text-lg font-bold {{ $balance > 0 ? 'text-red-600' : 'text-green-600' }} font-mono">
                {{ $invoice->currency }} {{ number_format($balance, 2) }}
              </p>
            </div>
            <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
              <p class="text-xs text-gray-500 mb-1">
                Invoice Status
              </p>
              <span class="inline-block mt-1 px-2 py-0.5 rounded text-xs font-bold uppercase tracking-wider
                {{ $invoice->status === 'PAID' ? 'bg-green-100 text-green-700' : '' }}
                {{ $invoice->status === 'OPEN' ? 'bg-blue-100 text-blue-700' : '' }}
                {{ $invoice->status === 'PARTIALLY_PAID' ? 'bg-yellow-100 text-yellow-700' : '' }}
                {{ $invoice->status === 'CANCELLED' ? 'bg-gray-200 text-gray-700' : '' }}">
                {{ $invoice->getStatusLabel() }}
              </span>
            </div>
          </div>

          @if ($receiptNumber)
          <div class="mt-6 text-center">
            <a href="{{ route('track.receipt', $receiptNumber) }}" class="inline-flex items-center gap-2 text-indigo-600 font-semibold hover:text-indigo-500 text-sm">
              View Receipt
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
            </a>
          </div>
          @elseif ($invoice->payment_type === 'instant' && $balance > 0)
          <div class="mt-6 text-center">
            <a href="{{ route('track.payment', $shipment->tracking_number) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl transition shadow-md">
              Pay Now
            </a>
          </div>
          @elseif ($invoice->payment_type === 'pay_on_delivery')
          <div class="mt-6 text-center">
            <p class="text-sm text-gray-500 font-medium">
              Payment due on delivery
            </p>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endif
</div>