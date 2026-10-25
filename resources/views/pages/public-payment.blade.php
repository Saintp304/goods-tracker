<?php

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\PaymentSetting;
use App\Services\FinancialService;
use Illuminate\Support\Facades\Storage;

new class extends Component 
{
use WithFileUploads;

  public string $trackingNumber;
  public ?Shipment $shipment = null;
  public ?Invoice $invoice = null;
  public float $paidAmount = 0;
  public float $balance = 0;
  public ?int $selectedSettingId = null;
  public array $availableMethods = [];
  public bool $notFound = false;
  public bool $paymentSubmitted = false;
  public array $payment_details = [
    'payment_method' => '',
    'amount' => '',
    'transaction_reference' => '',
    'payment_date' => '',
    'customer_email' => '',
  ];
  public $payment_proof;

  public function mount($trackingNumber): void
  {
    $this->trackingNumber = strtoupper(trim($trackingNumber));
    $this->shipment = Shipment::where('tracking_number', $this->trackingNumber)
    ->with('invoice')
    ->first();

    if (!$this->shipment || !$this->shipment->invoice) {
      $this->notFound = true;
      return;
    }

    $this->invoice = $this->shipment->invoice;
    $this->paidAmount = app(FinancialService::class)->getTotalCompletedPayments($this->invoice);
    $this->balance = app(FinancialService::class)->calculateRemainingBalance($this->invoice);

    if ($this->invoice->payment_type === 'pay_on_delivery') {
      $this->notFound = true; // Or a specific "Pay on Delivery" state
      return;
    }

    $this->availableMethods = PaymentSetting::where('enabled', true)->get()->toArray();
    if (!empty($this->availableMethods)) {
      $this->selectedSettingId = $this->availableMethods[0]['id'];
    }
  }

  public function submitPayment() {
    $this->validate([
    'payment_details.payment_method' => 'required|in:cash,card,bank_transfer,paypal,crypto',
    'payment_details.amount' => 'required|numeric|min:0.01',
    'payment_details.transaction_reference' => 'required|string|max:255',
    'payment_details.payment_date' => 'required|date',
    'payment_details.customer_email' => 'required|email',
    'payment_proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    if ($this->invoice->status === 'PAID') {
      session()->flash('error', 'This invoice is already paid.');
      return;
    }

    if ($this->invoice->status === 'CANCELLED') {
      session()->flash('error', 'This invoice has been cancelled.');
      return;
    }

    $amount = (float)$this->payment_details['amount'];
    if ($amount > $this->balance + 0.01) {
      session()->flash('error', 'The payment amount exceeds the remaining balance.');
      return;
    }

    $path = null;
    if ($this->payment_proof) {
      $path = $this->payment_proof->store('payment_proofs', 'public');
    }

    $paymentData = [
      'payment_type' => $this->invoice->payment_type,
      'amount' => $amount,
      'payment_date' => $this->payment_details['payment_date'],
      'payment_method' => $this->payment_details['payment_method'],
      'transaction_reference' => $this->payment_details['transaction_reference'],
      'payment_proof' => $path,
    ];

    app(FinancialService::class)->recordPayment($this->invoice, $paymentData);

    $this->paymentSubmitted = true;
    session()->flash('message', 'Payment notification submitted successfully. It will be reviewed by our admin.');
  }

  public function getSelectedSettingProperty() {
    if (!$this->selectedSettingId) {
      return null;
    }
    return PaymentSetting::find($this->selectedSettingId);
  }
};
?>

<div class="min-h-screen py-20 sm:py-12 px-4 sm:px-6 lg:px-8 bg-gray-50" style="font-family: 'Sora', sans-serif;">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  @if ($notFound)
  <div class="max-w-md mx-auto text-center py-16 sm:py-20">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 bg-red-50">
      <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
      </svg>
    </div>
    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Payment Unavailable</h2>
    <p class="text-gray-500 mt-2 text-sm sm:text-base">
      Online payment is not available for this shipment. It may be a "Pay on Delivery" order or the tracking number is invalid.
    </p>
    <a href="/track?trackingNumber={{ $trackingNumber }}" class="mt-6 inline-block text-indigo-600 font-semibold hover:text-indigo-500">← Back to Tracking</a>
  </div>
  @elseif ($paymentSubmitted)
  <div class="max-w-md mx-auto text-center py-16 sm:py-20">
    <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6 bg-green-50">
      <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
      </svg>
    </div>
    <h2 class="text-xl sm:text-2xl font-bold text-gray-900">Notification Sent</h2>
    <p class="text-gray-500 mt-2 text-sm sm:text-base">
      Your payment proof has been submitted successfully. Our team will review it and update your invoice status shortly.
    </p>
    <a href="/track/invoice/{{ $trackingNumber }}" class="mt-6 inline-block text-indigo-600 font-semibold hover:text-indigo-500">View Invoice</a>
  </div>
  @else
  <div class="max-w-5xl mx-auto">
    <div class="grid lg:grid-cols-3 gap-6 sm:gap-8">
      <!-- Invoice Summary -->
      <div class="lg:col-span-1 space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 sm:p-6">
          <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Payment Summary
          </h3>
          <div class="space-y-4">
            <div class="flex justify-between text-sm gap-2">
              <span class="text-gray-500">Invoice Number</span>
              <span class="font-mono font-semibold text-gray-900 truncate">#{{ $invoice->invoice_number }}</span>
            </div>
            <div class="flex justify-between text-sm gap-2">
              <span class="text-gray-500">Tracking Number</span>
              <span class="font-mono font-semibold text-gray-900 truncate">{{ $shipment->tracking_number }}</span>
            </div>
            <div class="pt-4 border-t border-gray-100">
              <div class="flex justify-between items-center mb-2 gap-2">
                <span class="text-gray-500 text-sm">Total Amount</span>
                <span class="text-lg font-bold text-gray-900">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
              </div>
              <div class="flex justify-between items-center mb-2 gap-2">
                <span class="text-gray-500 text-sm">Amount Paid</span>
                <span class="text-sm font-semibold text-green-600">{{ $invoice->currency }} {{ number_format($paidAmount, 2) }}</span>
              </div>
              <div class="flex justify-between items-center gap-2">
                <span class="text-gray-900 font-bold text-sm">Remaining Balance</span>
                <span class="text-lg sm:text-xl font-extrabold text-indigo-600">{{ $invoice->currency }} {{ number_format($balance, 2) }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Payment Methods & Instructions -->
      <div class="lg:col-span-2 space-y-6">
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 sm:p-6 md:p-8">
          <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-6">Payment Instructions</h3>

          <div class="flex flex-wrap gap-2 sm:gap-3 mb-8">
            @foreach ($availableMethods as $method)
            <button
              wire:click="$set('selectedSettingId', {{ $method['id'] }})"
              class="px-4 py-2 rounded-full text-sm font-semibold transition {{ (int) $selectedSettingId === (int) $method['id'] ? 'bg-indigo-600 text-white shadow-md' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
              @if ($method['method'] === 'crypto')
              {{ $method['crypto_currency'] }} ({{ $method['crypto_network'] }})
              @else
              {{ ucfirst(str_replace('_', ' ', $method['method'])) }}
              @endif
            </button>
            @endforeach
          </div>

          @php $setting = $this->selectedSetting; @endphp
          @if ($setting)
          <div class="bg-indigo-50 rounded-2xl p-4 sm:p-6 border border-indigo-100">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
              <h4 class="text-base sm:text-lg font-bold text-indigo-900 uppercase tracking-wide">{{ str_replace('_', ' ', $setting->method) }}</h4>
              <div class="self-start sm:self-auto px-3 py-1 bg-indigo-200 text-indigo-700 rounded-full text-xs font-bold whitespace-nowrap">
                Amount Due: {{ $invoice->currency }} {{ number_format($balance, 2) }}
              </div>
            </div>

            <div class="space-y-4">
              @if ($setting->method === 'bank_transfer')
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <p class="text-xs text-indigo-400 font-bold uppercase">
                    Bank Name
                  </p>
                  <p class="font-semibold text-indigo-900">
                    {{ $setting->bank_name }}
                  </p>
                </div>
                <div>
                  <p class="text-xs text-indigo-400 font-bold uppercase">
                    Account Name
                  </p>
                  <p class="font-semibold text-indigo-900">
                    {{ $setting->account_name }}
                  </p>
                </div>
                <div>
                  <p class="text-xs text-indigo-400 font-bold uppercase">
                    Account Number / IBAN
                  </p>
                  <div class="flex items-center gap-2">
                    <p class="font-mono font-bold text-indigo-900 break-all">
                      {{ $setting->account_number }} {{ $setting->iban }}
                    </p>
                    <button onclick="navigator.clipboard.writeText('{{ $setting->account_number }} {{ $setting->iban }}')" class="shrink-0 text-indigo-500 hover:text-indigo-700">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                    </button>
                  </div>
                </div>
                <div>
                  <p class="text-xs text-indigo-400 font-bold uppercase">
                    SWIFT/BIC
                  </p>
                  <p class="font-mono font-bold text-indigo-900">
                    {{ $setting->swift_bic }}
                  </p>
                </div>
              </div>
              @elseif ($setting->method === 'paypal')
              <div class="flex items-center justify-between gap-3">
                <div class="min-w-0">
                  <p class="text-xs text-indigo-400 font-bold uppercase">
                    PayPal Email
                  </p>
                  <p class="text-base sm:text-lg font-bold text-indigo-900 font-mono truncate">
                    {{ $setting->paypal_email }}
                  </p>
                </div>
                <button onclick="navigator.clipboard.writeText('{{ $setting->paypal_email }}')" class="shrink-0 p-2 bg-white rounded-lg text-indigo-600 hover:bg-indigo-50 shadow-sm transition">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                </button>
              </div>
              @elseif ($setting->method === 'crypto')
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <p class="text-xs text-indigo-400 font-bold uppercase">
                    Currency / Network
                  </p>
                  <p class="font-bold text-indigo-900">
                    {{ $setting->crypto_currency }} ({{ $setting->crypto_network }})
                  </p>
                </div>
                <div>
                  <p class="text-xs text-indigo-400 font-bold uppercase">
                    Wallet Address
                  </p>
                  <div class="flex items-center gap-2">
                    <p class="font-mono text-xs break-all font-bold text-indigo-900">
                      {{ $setting->wallet_address }}
                    </p>
                    <button onclick="navigator.clipboard.writeText('{{ $setting->wallet_address }}')" class="shrink-0 text-indigo-500 hover:text-indigo-700">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
                    </button>
                  </div>
                </div>
              </div>
              @endif

              @if ($setting->instructions)
              <div class="mt-6 p-4 bg-white/50 rounded-xl border border-indigo-100">
                <p class="text-xs text-indigo-400 font-bold uppercase mb-2">
                  Instructions
                </p>
                <p class="text-sm text-indigo-800 leading-relaxed">
                  {{ $setting->instructions }}
                </p>
              </div>
              @endif
            </div>
          </div>
          @else
          <div class="text-center py-10 sm:py-12 px-4 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
            <p class="text-gray-400">
              No payment methods currently available. Please contact support.
            </p>
          </div>
          @endif
        </div>

        <!-- Submission Form -->
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-5 sm:p-6 md:p-8">
          <h3 class="text-lg sm:text-xl font-bold text-gray-900 mb-6">Notify Us of Payment</h3>
          <p class="text-sm text-gray-500 mb-8">
            After completing your payment externally, please provide the details below to speed up the verification process.
          </p>

          <form wire:submit.prevent="submitPayment" class="text-black grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Method</label>
              <select wire:model="payment_details.payment_method" class="w-full p-3 border border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Select Method</option>
                @foreach (App\Models\Payment::getPaymentMethods() as $key => $label)
                <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
              </select>
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Amount Paid ({{ $invoice->currency }})</label>
              <input type="number" step="0.01" wire:model="payment_details.amount" class="w-full p-3 border border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="0.00">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Transaction Reference</label>
              <input type="text" wire:model="payment_details.transaction_reference" class="w-full p-3 border border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Reference number">
            </div>
            <div>
              <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Date</label>
              <input type="date" wire:model="payment_details.payment_date" class="w-full p-3 border border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-gray-700 mb-2">Your Email</label>
              <input type="email" wire:model="payment_details.customer_email" class="w-full p-3 border border-gray-200 rounded-xl text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="email@example.com">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-semibold text-gray-700 mb-2">Payment Proof (Image/PDF)</label>
              <input type="file" wire:model="payment_proof" class="w-full p-2 text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
              @error('payment_proof') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div class="md:col-span-2 flex justify-end mt-4">
              <button type="submit" wire:loading.attr="disabled" class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-xl text-sm transition flex items-center justify-center gap-2">
                <span wire:loading.remove>Submit Payment Notification</span>
                <span wire:loading>Processing...</span>
              </button>
            </div>
          </form>
          @if (session()->has('error'))
          <div class="mt-6 p-4 bg-red-50 border border-red-100 text-red-700 rounded-xl text-sm font-medium">
            {{ session('error') }}
          </div>
          @endif
          @if (session()->has('message'))
          <div class="mt-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl text-sm font-medium">
            {{ session('message') }}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
  @endif
</div>