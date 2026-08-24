<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shipment;

new #[Title('New Shipment')]
#[Layout('layouts.admin')]
class extends Component
{
  use WithFileUploads;

  // Sender
  public string $sender_name = '';
  public ?string $sender_phone = null;
  public ?string $sender_address = null;
  public ?string $sender_country = null;

  // Receiver
  public string $receiver_name = '';
  public ?string $receiver_email = null;
  public ?string $receiver_phone = null;
  public ?string $receiver_address = null;
  public ?string $receiver_country = null;

  // Package
  public ?string $package_description = null;
  public ?string $package_type = null;
  public ?string $package_weight = null;
  public ?int $package_quantity = null;
  public $shipment_image;

  // General
  public string $status = 'pending';
  public string $eta = '';
  public string $origin = '';
  public string $destination = '';
    public string $payment_type = 'instant';

  protected array $rules = [
    'sender_name' => 'required|string|max:255',
    'sender_phone' => 'nullable|string|max:50',
    'sender_address' => 'nullable|string|max:1000',
    'sender_country' => 'nullable|string|max:100',
    'receiver_name' => 'required|string|max:255',
    'receiver_email' => 'nullable|email|max:255',
    'receiver_phone' => 'nullable|string|max:50',
    'receiver_address' => 'nullable|string|max:1000',
    'receiver_country' => 'nullable|string|max:100',
    'package_description' => 'nullable|string|max:1000',
    'package_type' => 'nullable|string|max:100',
    'package_weight' => 'nullable|string|max:50',
    'package_quantity' => 'nullable|integer',
    'shipment_image' => 'nullable|image|max:2048',
    'status' => 'required|in:pending,picked_up,in_transit,delivered,held,cancelled',
    'eta' => 'nullable|date',
    'origin' => 'required|string|max:255',
        'payment_type' => 'required|in:instant,pay_on_delivery',
    'destination' => 'required|string|max:255',
  ];

  public function save() {
    $this->validate();

    $data = $this->only([
    'sender_name', 'sender_phone', 'sender_address', 'sender_country',
    'receiver_name', 'receiver_email', 'receiver_phone', 'receiver_address', 'receiver_country',
    'package_description', 'package_type', 'package_weight', 'package_quantity',
    'status', 'eta', 'origin', 'payment_type', 'destination'
    ]);

    if ($this->shipment_image) {
      $path = $this->shipment_image->store('shipments', 'public');
      $data['shipment_image'] = $path;
    }

    Shipment::create($data);

    session()->flash('success', 'Shipment created successfully.');
    $this->redirect(route('admin.shipmentsPage'), navigate: true);
  }
};
?>

<div class="max-w-4xl mx-auto pb-12">
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-4 sm:p-6 border-b border-gray-100">
      <h2 class="text-lg sm:text-xl font-bold text-gray-900">Create New Shipment</h2>
      <p class="text-sm text-gray-500">
        Enter all shipment and package details to begin tracking.
      </p>
    </div>

    <div class="p-4 sm:p-6 space-y-8">
      {{-- 1. SENDER --}}
      <div class="space-y-4">
        <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
          <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">1</span>
          Sender Information
        </h3>
        <div class="grid sm:grid-cols-2 gap-4">
          <div class="sm:col-span-2">
            <label class="block text-xs font-semibold text-gray-600 mb-1">Full Name *</label>
            <input type="text" wire:model="sender_name" placeholder="Full name"
            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
          @error('sender_name') <p class="text-red-500 text-xs mt-1">
            {{ $message }}
          </p>
          @enderror
        </div>
        <div>
          <label class="block text-xs font-semibold text-gray-600 mb-1">Phone Number</label>
          <input type="text" wire:model="sender_phone" placeholder="+234 xxx xxx xxxx"
          class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
        @error('sender_phone') <p class="text-red-500 text-xs mt-1">
          {{ $message }}
        </p>
        @enderror
      </div>
      <div>
        <label class="block text-xs font-semibold text-gray-600 mb-1">Country</label>
        <input type="text" wire:model="sender_country" placeholder="e.g. USA"
        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
      @error('sender_country') <p class="text-red-500 text-xs mt-1">
        {{ $message }}
      </p>
      @enderror
    </div>
    <div class="sm:col-span-2">
      <label class="block text-xs font-semibold text-gray-600 mb-1">Full Address</label>
      <textarea wire:model="sender_address" placeholder="e.g. No 1 ......" rows="2"
        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"></textarea>
      @error('sender_address') <p class="text-red-500 text-xs mt-1">
        {{ $message }}
      </p>
      @enderror
    </div>
  </div>
</div>

{{-- 2. RECEIVER --}}
<div class="space-y-4">
  <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
    <span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">2</span>
    Receiver Information
  </h3>
  <div class="grid sm:grid-cols-2 gap-4">
    <div class="sm:col-span-2">
      <label class="block text-xs font-semibold text-gray-600 mb-1">Full Name *</label>
      <input type="text" wire:model="receiver_name" placeholder="Full name"
      class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
    @error('receiver_name') <p class="text-red-500 text-xs mt-1">
      {{ $message }}
    </p>
    @enderror
  </div>
  <div>
    <label class="block text-xs font-semibold text-gray-600 mb-1">Email Address</label>
    <input type="email" wire:model="receiver_email" placeholder="email@example.com"
    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
  @error('receiver_email') <p class="text-red-500 text-xs mt-1">
    {{ $message }}
  </p>
  @enderror
</div>
<div>
  <label class="block text-xs font-semibold text-gray-600 mb-1">Phone Number</label>
  <input type="text" wire:model="receiver_phone" placeholder="+234 xxx xxx xxxx"
  class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('receiver_phone') <p class="text-red-500 text-xs mt-1">
  {{ $message }}
</p>
@enderror
</div>
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Country</label>
<input type="text" wire:model="receiver_country" placeholder="e.g. United King..."
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('receiver_country') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
<div class="sm:col-span-2">
<label class="block text-xs font-semibold text-gray-600 mb-1">Full Address</label>
<textarea wire:model="receiver_address" placeholder="e.g. No 1 ......" rows="2"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"></textarea>
@error('receiver_address') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
</div>
</div>

{{-- 3. PACKAGE --}}
<div class="space-y-4">
<h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
<span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">3</span>
Package Details
</h3>
<div class="grid sm:grid-cols-2 gap-4">
<div class="sm:col-span-2">
<label class="block text-xs font-semibold text-gray-600 mb-1">Description</label>
<textarea wire:model="package_description" rows="2" placeholder="What is inside the package?"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"></textarea>
@error('package_description') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Package Type</label>
<input type="text" wire:model="package_type" placeholder="e.g. Box, Pallet"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('package_type') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
<div class="grid grid-cols-2 gap-2">
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Weight</label>
<input type="text" wire:model="package_weight" placeholder="e.g. 5kg"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('package_weight') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Quantity</label>
<input type="number"placeholder="0" wire:model="package_quantity"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('package_quantity') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
</div>
<div class="sm:col-span-2">
<label class="block text-xs font-semibold text-gray-600 mb-2">Shipment Image</label>
<div class="flex flex-row items-center sm:items-center gap-4">
<div class="w-24 h-24 shrink-0 rounded-xl border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center overflow-hidden relative">
@if($shipment_image)
<img src="{{ $shipment_image->temporaryUrl() }}" class="w-full h-full object-cover" />
@else
<svg class="w-6 h-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
</svg>
@endif
</div>
<div class="flex-1 w-full">
<label class="cursor-pointer px-4 py-2 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold hover:bg-indigo-100 transition inline-flex items-center gap-2">
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
</svg>
Select Image
<input type="file" wire:model="shipment_image" class="hidden" accept="image/*" />
</label>
@error('shipment_image') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
</div>
</div>
</div>
</div>

{{-- 4. STATUS & ETA --}}
<div class="space-y-4">
<h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider flex items-center gap-2">
<span class="w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs">4</span>
Status & Logistics
</h3>
<div class="grid sm:grid-cols-2 gap-4">
<div class="sm:col-span-2 grid sm:grid-cols-2 gap-4">
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Origin City/Country *</label>
<input type="text" wire:model="origin" placeholder="e.g. New York, USA"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('origin') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Destination City/Country *</label>
<input type="text" wire:model="destination" placeholder="e.g. London, UK"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('destination') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
</div>
<div class="mt-4">
    <label class="block text-xs font-semibold text-gray-600 mb-1">Payment Type</label>
    <select wire:model="payment_type"
        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 font-semibold">
        <option value="instant">Instant Payment</option>
        <option value="pay_on_delivery">Pay on Delivery</option>
    </select>
    @error('payment_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
</div>
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Initial Status</label>
<select wire:model="status"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">
<option value="pending">Pending</option>
<option value="picked_up">Picked Up</option>
<option value="in_transit">In Transit</option>
<option value="delivered">Delivered</option>
<option value="held">Held</option>
<option value="cancelled">Cancelled</option>
</select>
@error('status') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
<div>
<label class="block text-xs font-semibold text-gray-600 mb-1">Expected Arrival (ETA)</label>
<input type="date" wire:model="eta"
class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm text-gray-700 text-black placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
@error('eta') <p class="text-red-500 text-xs mt-1">
{{ $message }}
</p>
@enderror
</div>
</div>
</div>
</div>

<div class="p-4 sm:p-6 bg-gray-50 border-t border-gray-100 flex flex-col-reverse sm:flex-row items-center sm:justify-between gap-3">
<a href="{{ route('admin.shipmentsPage') }}" wire:navigate
class="w-full sm:w-auto text-center px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-500 bg-white border border-gray-200 hover:bg-gray-50 transition">
Cancel
</a>
<button wire:click="save" wire:loading.attr="disabled"
class="w-full sm:w-auto px-8 py-3 rounded-xl text-white text-sm font-bold transition hover:-translate-y-0.5 shadow-md"
style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
<span wire:loading.remove>Create Shipment</span>
<span wire:loading>Saving...</span>
</button>
</div>
</div>
</div>