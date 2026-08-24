<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\ShipmentHistory;

new #[Title('Update Tracking Journey')]
#[Layout('layouts.admin')]
class extends Component
{
    public Shipment $shipment;

    public string $history_location = '';
    public string $history_info = '';

    public function mount(Shipment $shipment): void
    {
        $this->shipment = $shipment;
    }

    public function addHistory(): void
    {
        $this->validate([
            'history_location' => 'required|string|max:255',
            'history_info'     => 'required|string|max:500',
        ]);

        $history = ShipmentHistory::create([
            'shipment_id' => $this->shipment->id,
            'location'    => $this->history_location,
            'info'        => $this->history_info,
        ]);

        // Send email notification to receiver
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

        session()->flash('success', 'Tracking update added.');
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

<div class="max-w-4xl mx-auto space-y-6 pb-12">
    {{-- Header --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tracking Journey</h1>
            <p class="text-sm font-mono text-indigo-600 font-medium">
                Shipment: {{ $shipment->tracking_number }}
            </p>
        </div>
        <a href="{{ route('admin.shipments.edit', $shipment->id) }}" wire:navigate
            class="px-6 py-2.5 rounded-xl text-sm font-semibold text-gray-500 bg-gray-100 hover:bg-gray-200 transition">
            ← Back to Workspace
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- LEFT: Update Form --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sticky top-6">
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
                    <button wire:click="addHistory" wire:loading.attr="disabled"
                        class="w-full py-2.5 rounded-xl text-white text-sm font-bold transition hover:-translate-y-0.5 shadow-sm"
                        style="background:#4f46e5;">
                        <span wire:loading.remove wire:target="addHistory">Post Update</span>
                        <span wire:loading wire:target="addHistory">Posting...</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- RIGHT: Journey Timeline --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                    Journey Timeline
                </h2>

                <div class="space-y-4 relative">
                    {{-- Vertical Line --}}
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
                                class="text-gray-300 hover:text-red-500 transition">
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
    </div>
</div>
