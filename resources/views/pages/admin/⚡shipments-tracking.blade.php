<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\ShipmentHistory;
use App\Services\FinancialService;

new #[Title('Update Tracking Journey')]
#[Layout('layouts.admin')]
class extends Component
{
    public Shipment $shipment;

    public string $history_location = '';
    public string $history_info = '';
    public string $new_status = '';
    public ?float $hold_amount = null;
    public string $hold_currency = 'USD';

    public function mount(Shipment $shipment): void
    {
        $this->shipment = $shipment;
        $this->new_status = $shipment->status;
        $this->hold_currency = $shipment->currency ?? 'USD';
        $this->hold_amount = $shipment->invoice?->subtotal;
    }

    public function addHistory(FinancialService $financialService): void
    {
        $rules = [
            'history_location' => 'required|string|max:255',
            'history_info'     => 'required|string|max:500',
            'new_status'       => 'required|in:pending,picked_up,in_transit,held,cleared_transit,delivered,cancelled',
        ];

        if ($this->new_status === 'held') {
            $rules['hold_amount'] = 'required|numeric|min:0.01';
            $rules['hold_currency'] = 'required|string|max:3';
        }

        $this->validate($rules);

        $history = ShipmentHistory::create([
            'shipment_id' => $this->shipment->id,
            'location'    => $this->history_location,
            'info'        => $this->history_info,
        ]);

        $statusChanged = $this->new_status !== $this->shipment->status;

        if ($this->new_status === 'held') {
            // Creates the invoice at this point — this is the only place
            // an invoice gets created now.
            $financialService->createOrUpdateHoldInvoice(
                $this->shipment,
                $this->hold_amount,
                $this->hold_currency
            );
        }

        if ($statusChanged) {
            $this->shipment->update(['status' => $this->new_status]);
        }

        try {
            if ($this->shipment->receiver_email) {
                \Illuminate\Support\Facades\Mail::to($this->shipment->receiver_email)
                    ->send(new \App\Mail\ShipmentUpdated($this->shipment, $history));
            }
        } catch (\Exception $e) {
            error_log("Shipment update email failed: " . $e->getMessage());
        }

        $this->history_location = '';
        $this->history_info = '';
        $this->shipment->refresh();
        $this->new_status = $this->shipment->status;
        $this->hold_amount = $this->shipment->invoice?->subtotal;

        session()->flash('success', $this->new_status === 'held'
            ? 'Tracking update added and hold amount saved.'
            : 'Tracking update added.');
    }

    public function deleteHistory(int $id): void
    {
        ShipmentHistory::findOrFail($id)->delete();
        $this->shipment->refresh();
    }

    public function with(): array
    {
        return [
            'histories' => $this->shipment->histories,
        ];
    }
};
?>

<div class="max-w-4xl mx-auto space-y-6 pb-24 lg:pb-12">
    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6 space-y-4">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Tracking Journey</h1>
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
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
                </div>
                <p class="text-sm font-mono text-indigo-600 font-medium mt-1">
                    Shipment: {{ $shipment->tracking_number }}
                </p>
            </div>
        </div>

        <x-shipment-tabs :shipment="$shipment" active="tracking" />

        @if($shipment->status === 'held' && $shipment->invoice)
        <div class="rounded-xl bg-red-50 border border-red-100 p-4 flex items-start gap-3">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
            <div>
                <p class="text-sm font-bold text-red-700">On Customs Hold</p>
                <p class="text-xs text-red-600 mt-0.5">
                    {{ $shipment->invoice->currency }} {{ number_format($shipment->invoice->subtotal, 2) }} is required to release this shipment.
                    Customer sees a payment prompt on the tracking page while status stays Held.
                </p>
            </div>
        </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Timeline shows first on mobile --}}
        <div class="order-1 lg:order-2 lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Journey Timeline
                </h2>

                <div class="space-y-4 relative">
                    <div class="absolute left-4 top-2 bottom-2 w-0.5 bg-gray-100"></div>

                    @forelse ($histories as $history)
                    <div class="relative pl-10 group">
                        <div class="absolute left-0 top-1 w-8 h-8 rounded-full bg-white border-2 border-indigo-500 flex items-center justify-center z-10">
                            <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 group-hover:border-indigo-200 transition flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <p class="font-bold text-gray-800 text-sm">{{ $history->location }}</p>
                                <p class="text-gray-600 text-sm mt-0.5">{{ $history->info }}</p>
                                <p class="text-[10px] text-gray-400 mt-2 font-medium uppercase tracking-wider">
                                    {{ $history->created_at->format('M d, Y • h:i A') }}
                                </p>
                            </div>
                            <button wire:click="deleteHistory({{ $history->id }})"
                                wire:confirm="Remove this history entry?"
                                class="text-gray-300 hover:text-red-500 transition shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10 border-2 border-dashed border-gray-100 rounded-2xl">
                        <p class="text-gray-400 text-sm">No tracking history yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Update Form --}}
        <div class="order-2 lg:order-1 lg:col-span-1" x-data="{ open: false }">
            <button @click="open = !open" type="button"
                class="lg:hidden w-full mb-4 py-3 rounded-xl bg-indigo-600 text-white text-sm font-bold shadow-sm flex items-center justify-center gap-2">
                <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-45' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                </svg>
                <span x-text="open ? 'Close Form' : 'Add Update'"></span>
            </button>

            <div :class="open ? 'block' : 'hidden lg:block'"
                class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 lg:sticky lg:top-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Add Update
                </h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Location</label>
                        <input type="text" wire:model="history_location" placeholder="e.g. Lagos Hub"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"/>
                        @error('history_location') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Update Info</label>
                        <textarea wire:model="history_info" placeholder="e.g. Arrived at destination hub" rows="3"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100"></textarea>
                        @error('history_info') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Update Status</label>
                        <select wire:model.live="new_status"
                            class="w-full px-4 py-2 rounded-xl border border-gray-200 text-sm text-black focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 font-semibold">
                            <option value="pending">Pending</option>
                            <option value="picked_up">Picked Up</option>
                            <option value="in_transit">In Transit</option>
                            <option value="held">Held — Customs Hold</option>
                            <option value="cleared_transit">Cleared — In Transit</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <p class="text-[11px] text-gray-400 mt-1">Defaults to current status — change it only if this update is a milestone.</p>
                        @error('new_status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    @if($new_status === 'held')
                    <div class="rounded-xl bg-red-50 border border-red-100 p-4 space-y-3">
                        <p class="text-xs font-bold text-red-700 uppercase tracking-wider">Amount Required to Release</p>
                        <div class="grid grid-cols-3 gap-2">
                            <div>
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Currency</label>
                                <select wire:model="hold_currency"
                                    class="w-full px-2 py-2 rounded-lg border border-gray-200 text-xs text-black focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 font-semibold">
                                    <option value="USD">USD</option>
                                    <option value="EUR">EUR</option>
                                    <option value="GBP">GBP</option>
                                    <option value="NGN">NGN</option>
                                    <option value="CAD">CAD</option>
                                    <option value="AUD">AUD</option>
                                </select>
                            </div>
                            <div class="col-span-2">
                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Amount</label>
                                <input type="number" step="0.01" wire:model="hold_amount" placeholder="0.00"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm text-black focus:outline-none focus:border-red-400 focus:ring-2 focus:ring-red-100 font-semibold" />
                            </div>
                        </div>
                        @error('hold_amount') <p class="text-red-500 text-xs">{{ $message }}</p> @enderror
                        <p class="text-[11px] text-red-500">This creates (or updates) the invoice and unlocks payment on the customer's tracking page.</p>
                    </div>
                    @endif

                    <button wire:click="addHistory" wire:loading.attr="disabled"
                        class="w-full py-2.5 rounded-xl text-white text-sm font-bold transition hover:-translate-y-0.5 shadow-sm"
                        style="background:#4f46e5;">
                        <span wire:loading.remove wire:target="addHistory">Post Update</span>
                        <span wire:loading wire:target="addHistory">Posting...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>