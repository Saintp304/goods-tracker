<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Shipment;
use App\Models\Invoice;
use App\Models\Payment;
use App\Services\FinancialService;
use Illuminate\Support\Facades\Storage;

new #[Title('Shipment Management Workspace')]
#[Layout('layouts.admin')]
class extends Component
{
  use WithFileUploads;

  public Shipment $shipment;
  public ?Invoice $invoice = null;

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
  public $shipment_image; // For upload

  // General (status is intentionally NOT editable here anymore —
  // see Tracking tab, which is the only place status changes happen now)
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
    'eta' => 'nullable|date',
    'origin' => 'required|string|max:255',
    'destination' => 'required|string|max:255',
    'payment_type' => 'required|in:instant,pay_on_delivery',
  ];

  public function mount(Shipment $shipment): void
  {
    $this->shipment = $shipment;

    $this->sender_name = $shipment->sender_name;
    $this->sender_phone = $shipment->sender_phone;
    $this->sender_address = $shipment->sender_address;
    $this->sender_country = $shipment->sender_country;

    $this->receiver_name = $shipment->receiver_name;
    $this->receiver_email = $shipment->receiver_email;
    $this->receiver_phone = $shipment->receiver_phone;
    $this->receiver_address = $shipment->receiver_address;
    $this->receiver_country = $shipment->receiver_country;

    $this->package_description = $shipment->package_description;
    $this->package_type = $shipment->package_type;
    $this->package_weight = $shipment->package_weight;
    $this->package_quantity = $shipment->package_quantity;

    $this->eta = $shipment->eta?->format('Y-m-d') ?? '';

    $this->origin = $shipment->origin;
    $this->destination = $shipment->destination;
    $this->payment_type = $shipment->payment_type ?? 'instant';

    $this->invoice = $shipment->invoice;
  }

  public function save(): void
  {
    $this->validate();

    $data = $this->only([
      'sender_name', 'sender_phone', 'sender_address', 'sender_country',
      'receiver_name', 'receiver_email', 'receiver_phone', 'receiver_address', 'receiver_country',
      'package_description', 'package_type', 'package_weight', 'package_quantity',
      'eta', 'origin', 'payment_type', 'destination'
    ]);

    if ($this->shipment->shipment_image && !$this->shipment_image) {
      $data['shipment_image'] = $this->shipment->shipment_image;
    }

    if ($this->shipment_image) {
      if ($this->shipment->shipment_image) {
        Storage::disk('public')->delete($this->shipment->shipment_image);
      }
      $data['shipment_image'] = $this->shipment_image->store('shipments', 'public');
    }

    $this->shipment->update($data);

    session()->flash('success', 'Shipment updated successfully.');
    $this->redirect(route('admin.shipmentsPage'), navigate: true);
  }

  public function removeImage(): void
  {
    if ($this->shipment->shipment_image) {
      Storage::disk('public')->delete($this->shipment->shipment_image);
      $this->shipment->update(['shipment_image' => null]);
    }
    $this->shipment_image = null;
  }

  public function deleteShipment(): void
  {
    if ($this->shipment->shipment_image) {
      Storage::disk('public')->delete($this->shipment->shipment_image);
    }
    $this->shipment->delete();

    session()->flash('success', 'Shipment deleted successfully.');
    $this->redirect(route('admin.shipmentsPage'), navigate: true);
  }
};
?>

<div class="max-w-6xl mx-auto space-y-6 pb-28 lg:pb-12">
  {{-- A. SHIPMENT HEADER --}}
  <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-4 sm:p-6 space-y-4">
      <div class="flex flex-row items-start justify-between gap-3">
        <div class="flex flex-col gap-1 min-w-0">
          <div class="flex flex-wrap items-center gap-2">
            <h1 class="text-lg sm:text-2xl font-bold text-gray-900 truncate">Shipment Management</h1>
            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider whitespace-nowrap
              {{ $shipment->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
              {{ $shipment->status === 'pending' ? 'bg-gray-100 text-gray-700' : '' }}
              {{ $shipment->status === 'picked_up' ? 'bg-blue-100 text-blue-700' : '' }}
              {{ $shipment->status === 'in_transit' ? 'bg-indigo-100 text-indigo-700' : '' }}
              {{ $shipment->status === 'cleared_transit' ? 'bg-indigo-100 text-indigo-700' : '' }}
              {{ $shipment->status === 'held' ? 'bg-red-100 text-red-700' : '' }}
              {{ $shipment->status === 'cancelled' ? 'bg-gray-200 text-gray-700' : '' }}">
              @if($shipment->status === 'held') 🔒 Customs Hold
              @elseif($shipment->status === 'cleared_transit') Cleared — In Transit
              @else {{ str_replace('_', ' ', $shipment->status) }}
              @endif
            </span>
            @if($invoice)
            <span class="flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 border border-gray-200 whitespace-nowrap">
              <span class="w-2 h-2 rounded-full {{ $invoice->status === 'PAID' ? 'bg-green-500' : ($invoice->isOverdue() ? 'bg-red-500' : 'bg-yellow-500') }}"></span>
              <span class="text-xs font-bold text-gray-600 uppercase tracking-wider">
                {{ $invoice->getStatusLabel() }} {{ $invoice->isOverdue() ? '(Overdue)' : '' }}
              </span>
            </span>
            @endif
          </div>
          <p class="text-xs sm:text-sm font-mono text-indigo-600 font-medium truncate">
            Tracking: {{ $shipment->tracking_number }}
          </p>
        </div>

        <div class="flex items-center gap-2 shrink-0">
          <button wire:click="save" wire:loading.attr="disabled"
            class="hidden lg:inline-flex px-6 py-2.5 rounded-xl text-white text-sm font-bold transition hover:-translate-y-0.5 shadow-md"
            style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
            <span wire:loading.remove wire:target="save">Save Workspace</span>
            <span wire:loading wire:target="save">Saving...</span>
          </button>

          <div class="relative" x-data="{ menuOpen: false }" @click.outside="menuOpen = false">
            <button @click="menuOpen = !menuOpen" type="button"
              class="p-2.5 rounded-xl border border-gray-200 text-gray-500 hover:bg-gray-50 transition">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01"/>
              </svg>
            </button>
            <div x-show="menuOpen" x-cloak x-transition
              class="absolute right-0 mt-2 w-48 bg-white rounded-xl border border-gray-100 shadow-lg z-20 overflow-hidden">
              <button wire:click="deleteShipment"
                wire:confirm="Are you absolutely sure you want to delete this shipment? This action cannot be undone."
                class="w-full text-left px-4 py-3 text-sm font-semibold text-red-600 hover:bg-red-50 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                Delete Shipment
              </button>
            </div>
          </div>
        </div>
      </div>

      <x-shipment-tabs :shipment="$shipment" active="details" />
    </div>

    <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-100 grid grid-cols-2 md:grid-cols-4 gap-4">
      <div>
        <p class="text-xs text-gray-500 uppercase font-bold">Estimated Arrival</p>
        <p class="text-sm font-semibold text-gray-900">{{ $shipment->eta?->format('M d, Y') ?? 'Not set' }}</p>
      </div>
      <div>
        <p class="text-xs text-gray-500 uppercase font-bold">Created</p>
        <p class="text-sm font-semibold text-gray-900">{{ $shipment->created_at->format('M d, Y') }}</p>
      </div>
      <div>
        <p class="text-xs text-gray-500 uppercase font-bold">Last Updated</p>
        <p class="text-sm font-semibold text-gray-900">{{ $shipment->updated_at->format('M d, Y • h:i A') }}</p>
      </div>
      <div class="text-left md:text-right">
        <a href="{{ route('admin.shipmentsPage') }}" wire:navigate
          class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 transition">
          ← Back to List
        </a>
      </div>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">

      {{-- B. SENDER DETAILS --}}
      <details open class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <summary class="p-4 sm:p-6 cursor-pointer list-none flex items-center justify-between select-none">
          <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Sender Details
          </h2>
          <svg class="w-5 h-5 text-gray-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </summary>
        <div class="px-4 sm:px-6 pb-6">
          <div class="grid sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full Name</label>
              <input type="text" wire:model="sender_name"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('sender_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone Number</label>
              <input type="text" wire:model="sender_phone"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('sender_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Country</label>
              <input type="text" wire:model="sender_country"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('sender_country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full Address</label>
              <textarea wire:model="sender_address" rows="2"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"></textarea>
              @error('sender_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>
      </details>

      {{-- C. RECEIVER DETAILS --}}
      <details open class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <summary class="p-4 sm:p-6 cursor-pointer list-none flex items-center justify-between select-none">
          <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Receiver Details
          </h2>
          <svg class="w-5 h-5 text-gray-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </summary>
        <div class="px-4 sm:px-6 pb-6">
          <div class="grid sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full Name</label>
              <input type="text" wire:model="receiver_name"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('receiver_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email Address</label>
              <input type="email" wire:model="receiver_email"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('receiver_email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Phone Number</label>
              <input type="text" wire:model="receiver_phone"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('receiver_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Country</label>
              <input type="text" wire:model="receiver_country"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('receiver_country') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Full Address</label>
              <textarea wire:model="receiver_address" rows="2"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"></textarea>
              @error('receiver_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>
      </details>

      {{-- D. PACKAGE DETAILS --}}
      <details open class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <summary class="p-4 sm:p-6 cursor-pointer list-none flex items-center justify-between select-none">
          <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Package Details
          </h2>
          <svg class="w-5 h-5 text-gray-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </summary>
        <div class="px-4 sm:px-6 pb-6">
          <div class="grid sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Description</label>
              <textarea wire:model="package_description" rows="2" placeholder="e.g. Electronics, Clothing, etc."
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"></textarea>
              @error('package_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Package Type</label>
              <input type="text" wire:model="package_type" placeholder="e.g. Box, Pallet, Envelope"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('package_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Weight</label>
              <input type="text" wire:model="package_weight" placeholder="e.g. 2.5kg"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('package_weight') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Quantity</label>
              <input type="number" wire:model="package_quantity"
                class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('package_quantity') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="sm:col-span-2 pt-4">
              <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Shipment Image</label>
              <div class="flex flex-row items-start gap-4 sm:gap-6">
                <div class="w-32 h-32 shrink-0 rounded-2xl border-2 border-dashed border-gray-200 bg-gray-50 flex items-center justify-center overflow-hidden relative group">
                  @if($shipment->shipment_image)
                  <img src="{{ Storage::url($shipment->shipment_image) }}" class="w-full h-full object-cover" />
                  @elseif($shipment_image)
                  <img src="{{ $shipment_image->temporaryUrl() }}" class="w-full h-full object-cover" />
                  @else
                  <div class="text-center p-2">
                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="text-[10px] text-gray-400 font-medium">No Image</p>
                  </div>
                  @endif
                </div>
                <div class="flex-1 w-full space-y-3">
                  <div class="flex flex-wrap gap-3">
                    <label class="cursor-pointer px-4 py-2 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold hover:bg-indigo-100 transition flex items-center gap-2">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                      </svg>
                      Upload Image
                      <input type="file" wire:model="shipment_image" class="hidden" accept="image/*" />
                    </label>
                    @if($shipment->shipment_image || $shipment_image)
                    <button wire:click="removeImage" class="px-4 py-2 rounded-lg bg-red-50 text-red-600 text-xs font-bold hover:bg-red-100 transition flex items-center gap-2">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                      Remove Image
                    </button>
                    @endif
                  </div>
                  @error('shipment_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                  <p class="text-xs text-gray-400">Supported formats: JPG, PNG. Max size: 2MB.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </details>

      {{-- E. FINANCIALS SECTION --}}
      <details open class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <summary class="p-4 sm:p-6 cursor-pointer list-none flex items-center justify-between select-none">
          <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Financials
          </h2>
          <svg class="w-5 h-5 text-gray-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </summary>
        <div class="px-4 sm:px-6 pb-6">
          @if(!$invoice)
          <div class="text-center py-8 px-4 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
            <svg class="w-10 h-10 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            <p class="text-sm text-gray-500 mb-1">No invoice yet.</p>
            <p class="text-xs text-gray-400 max-w-xs mx-auto">
              An invoice is created automatically when this shipment is marked
              <span class="font-semibold text-red-500">Held</span> from the
              <a href="{{ route('admin.shipments.tracking', $shipment->id) }}" wire:navigate class="text-indigo-600 font-semibold hover:underline">Tracking tab</a>.
            </p>
          </div>
          @else
          @php
          $financialService = app(FinancialService::class);
          $totalPaid = $financialService->getTotalCompletedPayments($invoice);
          $balance = $financialService->calculateRemainingBalance($invoice);
          @endphp
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm">
              <p class="text-[10px] text-gray-400 uppercase font-bold mb-1">Hold Amount</p>
              <p class="text-xl font-black text-gray-900">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</p>
            </div>
            <div class="p-4 rounded-2xl bg-green-50 border border-green-100 shadow-sm">
              <p class="text-[10px] text-green-600 uppercase font-bold mb-1">Amount Paid</p>
              <p class="text-xl font-black text-green-700">{{ $invoice->currency }} {{ number_format($totalPaid, 2) }}</p>
            </div>
            <div class="p-4 rounded-2xl {{ $balance > 0 ? 'bg-red-50 border-red-100' : 'bg-gray-50 border-gray-100' }} border shadow-sm">
              <p class="text-[10px] {{ $balance > 0 ? 'text-red-500' : 'text-gray-500' }} uppercase font-bold mb-1">Remaining Balance</p>
              <p class="text-xl font-black {{ $balance > 0 ? 'text-red-700' : 'text-gray-900' }}">
                {{ $invoice->currency }} {{ number_format($balance, 2) }}
              </p>
            </div>
          </div>

          <div class="flex flex-wrap gap-3 mb-8">
            <a href="{{ route('admin.shipments.invoice', $shipment->id) }}" wire:navigate
              class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 text-xs font-bold hover:bg-gray-50 transition flex items-center gap-2">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
              </svg>
              View Invoice
            </a>
            @if($shipment->status === 'held')
            <a href="{{ route('admin.shipments.payments', $shipment->id) }}" wire:navigate
              class="px-4 py-2 rounded-lg bg-indigo-600 text-white text-xs font-bold hover:bg-indigo-700 transition flex items-center gap-2 shadow-sm">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
              </svg>
              Record Payment
            </a>
            @else
            <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-xs font-bold flex items-center gap-2 cursor-not-allowed" title="Only available while shipment is on Customs Hold">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
              </svg>
              Record Payment (Held only)
            </span>
            @endif
          </div>

          <div class="border-t border-gray-100 pt-6">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Payment History</h3>

            <div class="hidden sm:block overflow-x-auto">
              <table class="w-full text-left text-xs">
                <thead>
                  <tr class="text-gray-400 uppercase font-bold">
                    <th class="pb-3 font-medium">Date</th>
                    <th class="pb-3 font-medium">Method</th>
                    <th class="pb-3 font-medium">Amount</th>
                    <th class="pb-3 font-medium">Status</th>
                    <th class="pb-3 font-medium text-right">Receipt</th>
                  </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                  @forelse($invoice->payments()->latest()->get() as $payment)
                  <tr class="hover:bg-gray-50 transition-colors">
                    <td class="py-3 text-gray-600">{{ $payment->payment_date->format('M d, Y') }}</td>
                    <td class="py-3">
                      <div class="flex flex-col">
                        <span class="text-gray-900 font-medium">{{ $payment->getPaymentMethodLabel() }}</span>
                        <span class="text-[10px] text-gray-400 uppercase">{{ $payment->getPaymentTypeLabel() }}</span>
                      </div>
                    </td>
                    <td class="py-3 text-gray-900 font-bold">{{ $invoice->currency }} {{ number_format($payment->amount, 2) }}</td>
                    <td class="py-3">
                      <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase
                        {{ $payment->status === 'COMPLETED' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $payment->status === 'PENDING' ? 'bg-gray-100 text-gray-700' : '' }}
                        {{ $payment->status === 'FAILED' ? 'bg-red-100 text-red-700' : '' }}
                        {{ $payment->status === 'REFUNDED' ? 'bg-orange-100 text-orange-700' : '' }}">
                        {{ $payment->status }}
                      </span>
                    </td>
                    <td class="py-3 text-right">
                      @if($payment->status === 'COMPLETED' && $payment->receipt)
                      <a href="{{ route('admin.payments.receipt', $payment->id) }}" wire:navigate
                        class="text-indigo-600 hover:text-indigo-800 font-bold">View</a>
                      @else
                      <span class="text-gray-300">—</span>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="5" class="py-6 text-center text-gray-400 italic">No payments recorded yet.</td>
                  </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="sm:hidden space-y-3">
              @forelse($invoice->payments()->latest()->get() as $payment)
              <div class="rounded-xl border border-gray-100 p-4 space-y-2">
                <div class="flex justify-between items-start gap-3">
                  <div>
                    <p class="text-sm font-semibold text-gray-900">{{ $payment->getPaymentMethodLabel() }}</p>
                    <p class="text-[10px] text-gray-400 uppercase">{{ $payment->getPaymentTypeLabel() }}</p>
                  </div>
                  <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase shrink-0
                    {{ $payment->status === 'COMPLETED' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $payment->status === 'PENDING' ? 'bg-gray-100 text-gray-700' : '' }}
                    {{ $payment->status === 'FAILED' ? 'bg-red-100 text-red-700' : '' }}
                    {{ $payment->status === 'REFUNDED' ? 'bg-orange-100 text-orange-700' : '' }}">
                    {{ $payment->status }}
                  </span>
                </div>
                <div class="flex justify-between items-end pt-1 border-t border-gray-50">
                  <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">{{ $payment->payment_date->format('M d, Y') }}</p>
                    @if($payment->status === 'COMPLETED' && $payment->receipt)
                    <a href="{{ route('admin.payments.receipt', $payment->id) }}" wire:navigate
                      class="text-xs text-indigo-600 font-bold">View Receipt</a>
                    @endif
                  </div>
                  <p class="text-base font-bold text-gray-900">{{ $invoice->currency }} {{ number_format($payment->amount, 2) }}</p>
                </div>
              </div>
              @empty
              <div class="text-center py-8 text-gray-400 italic text-sm border border-dashed border-gray-200 rounded-xl">
                No payments recorded yet.
              </div>
              @endforelse
            </div>
          </div>
          @endif
        </div>
      </details>

      {{-- F. LOGISTICS --}}
      <details open class="group bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <summary class="p-4 sm:p-6 cursor-pointer list-none flex items-center justify-between select-none">
          <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Logistics
          </h2>
          <svg class="w-5 h-5 text-gray-400 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
          </svg>
        </summary>
        <div class="px-4 sm:px-6 pb-6">
          <div class="grid sm:grid-cols-2 gap-4 mb-6">
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Origin City/Country *</label>
              <input type="text" wire:model="origin"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 font-semibold" />
              @error('origin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Destination City/Country *</label>
              <input type="text" wire:model="destination"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 font-semibold" />
              @error('destination') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
          </div>

          <div class="mb-6">
            <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Payment Type</label>
            <select wire:model="payment_type"
              class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 font-semibold">
              <option value="instant">Instant Payment</option>
              <option value="pay_on_delivery">Pay on Delivery</option>
            </select>
            @error('payment_type') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
          </div>

          <div class="grid sm:grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Current Status</label>
              <div class="flex items-center gap-2 px-4 py-3 rounded-xl border border-gray-100 bg-gray-50">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                  {{ $shipment->status === 'delivered' ? 'bg-green-100 text-green-700' : '' }}
                  {{ $shipment->status === 'pending' ? 'bg-gray-200 text-gray-700' : '' }}
                  {{ $shipment->status === 'picked_up' ? 'bg-blue-100 text-blue-700' : '' }}
                  {{ $shipment->status === 'in_transit' ? 'bg-indigo-100 text-indigo-700' : '' }}
                  {{ $shipment->status === 'cleared_transit' ? 'bg-indigo-100 text-indigo-700' : '' }}
                  {{ $shipment->status === 'held' ? 'bg-red-100 text-red-700' : '' }}
                  {{ $shipment->status === 'cancelled' ? 'bg-gray-300 text-gray-700' : '' }}">
                  {{ str_replace('_', ' ', $shipment->status) }}
                </span>
              </div>
              <p class="text-[11px] text-gray-400 mt-1">
                Status is managed from the <a href="{{ route('admin.shipments.tracking', $shipment->id) }}" wire:navigate class="text-indigo-600 font-semibold hover:underline">Tracking tab</a> — that's where hold amounts and history entries stay in sync.
              </p>
            </div>
            <div>
              <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Estimated Arrival (ETA)</label>
              <input type="date" wire:model="eta"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm text-gray-700 focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
              @error('eta') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
          </div>
        </div>
      </details>
    </div>
  </div>

  <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] p-3 z-30">
    <button wire:click="save" wire:loading.attr="disabled"
      class="w-full py-3 rounded-xl text-white text-sm font-bold transition shadow-md"
      style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
      <span wire:loading.remove wire:target="save">Save Workspace</span>
      <span wire:loading wire:target="save">Saving...</span>
    </button>
  </div>
</div>