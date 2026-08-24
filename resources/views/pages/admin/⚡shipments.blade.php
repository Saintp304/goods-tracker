<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Shipment;

new #[Title('Shipments')]
#[Layout('layouts.admin')]
class extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public function updatingSearch(): void {
        $this->resetPage();
    }
    public function updatingStatusFilter(): void {
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->reset(['search', 'statusFilter']);
        $this->resetPage();
    }

    public function delete(int $id): void
    {
        Shipment::findOrFail($id)->delete();
        session()->flash('success', 'Shipment deleted.');
    }

    public function with(): array
    {
        return [
            'shipments' => Shipment::query()
                ->when($this->search, fn($q) =>
                    $q->where(fn($sub) =>
                        $sub->where('tracking_number', 'like', "%{$this->search}%")
                            ->orWhere('receiver_name', 'like', "%{$this->search}%")
                            ->orWhere('sender_name', 'like', "%{$this->search}%")
                            ->orWhere('origin', 'like', "%{$this->search}%")
                            ->orWhere('destination', 'like', "%{$this->search}%")
                    ))
                ->when($this->statusFilter, fn($q) =>
                    $q->where('status', $this->statusFilter)
                )
                ->latest()
                ->paginate(10),
        ];
    }
};
?>

<div class="space-y-6">

    @if (session('success'))
        <div class="bg-green-50 border border-green-100 text-green-700 text-sm font-semibold px-5 py-3 rounded-xl flex items-center gap-2">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Toolbar --}}
    <div class="flex flex-col sm:flex-row gap-4 items-stretch sm:items-center justify-between">
        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
            <input
                type="text"
                wire:model.live.debounce.300ms="search"
                placeholder="Search tracking, name, city..."
                class="text-black pl-4 pr-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm placeholder-gray-600 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 w-full sm:w-64"
            />
            <select wire:model.live="statusFilter"
                class="px-4 py-2.5 rounded-xl border border-gray-200 bg-white text-sm text-gray-600 focus:outline-none focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 w-full sm:w-auto">
                <option value="">All Statuses</option>
                <option value="pending">Pending</option>
                <option value="picked_up">Picked by Courier</option>
                <option value="in_transit">In Transit</option>
                <option value="delivered">Delivered</option>
                <option value="held">Held</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <a href="{{ route('admin.shipments.create') }}"
            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl text-white text-sm font-semibold whitespace-nowrap w-full sm:w-auto"
            style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
            + New Shipment
        </a>
    </div>

    {{-- MOBILE: Card List (hidden on sm and up) --}}
    <div class="sm:hidden space-y-3">
        @forelse ($shipments as $shipment)
            @php
                $colors = [
                    'pending'    => 'bg-yellow-100 text-yellow-800',
                    'picked_up'  => 'bg-indigo-100 text-indigo-800',
                    'in_transit' => 'bg-blue-100 text-blue-800',
                    'delivered'  => 'bg-green-100 text-green-800',
                    'held'       => 'bg-red-600 text-white shadow-sm',
                    'cancelled'  => 'bg-gray-200 text-gray-600',
                ];
            @endphp
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 space-y-3">
                <div class="flex items-start justify-between gap-2">
                    <div class="min-w-0">
                        <p class="font-mono font-semibold text-indigo-600 text-xs truncate">{{ $shipment->tracking_number }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ $shipment->updated_at->format('M d, H:i') }}</p>
                    </div>
                    <span class="shrink-0 px-3 py-1 rounded-full text-[10px] font-bold {{ $colors[$shipment->status] ?? '' }}">
                        {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div>
                        <p class="text-gray-400 font-bold uppercase text-[10px] mb-0.5">Sender</p>
                        <p class="text-gray-700 truncate">{{ $shipment->sender_name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-400 font-bold uppercase text-[10px] mb-0.5">Receiver</p>
                        <p class="text-gray-700 truncate">{{ $shipment->receiver_name }}</p>
                    </div>
                </div>

                <div class="text-xs">
                    <p class="text-gray-400 font-bold uppercase text-[10px] mb-0.5">Route</p>
                    <p class="text-gray-600">{{ $shipment->origin }} → {{ $shipment->destination }}</p>
                </div>

                <div class="flex items-center justify-between text-xs pt-1">
                    <p class="text-gray-500">ETA: <span class="font-semibold text-gray-700">{{ $shipment->eta?->format('M d') ?? '—' }}</span></p>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.shipments.edit', $shipment) }}"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                            Edit
                        </a>
                        <button
                            wire:click="delete({{ $shipment->id }})"
                            wire:confirm="Delete this shipment? This cannot be undone."
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm px-6 py-14 text-center">
                @if($search || $statusFilter)
                    <div class="flex flex-col items-center gap-3">
                        <p class="text-gray-400 text-sm">No shipments match your search or filter criteria.</p>
                        <button wire:click="clearFilters" class="text-indigo-600 text-xs font-bold hover:underline">
                            Clear all filters
                        </button>
                    </div>
                @else
                    <p class="text-gray-400 text-sm">No shipments found. Start by creating your first shipment.</p>
                @endif
            </div>
        @endforelse

        @if ($shipments->hasPages())
            <div class="pt-2">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>

    {{-- DESKTOP: Table (hidden below sm) --}}
    <div class="hidden sm:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Tracking #</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Sender</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Receiver</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Route</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Updated</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">ETA</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($shipments as $shipment)
                        @php
                            $colors = [
                                'pending'    => 'bg-yellow-100 text-yellow-800',
                                'picked_up'  => 'bg-indigo-100 text-indigo-800',
                                'in_transit' => 'bg-blue-100 text-blue-800',
                                'delivered'  => 'bg-green-100 text-green-800',
                                'held'       => 'bg-red-600 text-white shadow-sm',
                                'cancelled'  => 'bg-gray-200 text-gray-600',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono font-semibold text-indigo-600 text-xs">{{ $shipment->tracking_number }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $shipment->sender_name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $shipment->receiver_name }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $shipment->origin }} → {{ $shipment->destination }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colors[$shipment->status] ?? '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $shipment->updated_at->format('M d, H:i') }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $shipment->eta?->format('M d') ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.shipments.edit', $shipment) }}"
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition">
                                        Edit
                                    </a>
                                    <button
                                        wire:click="delete({{ $shipment->id }})"
                                        wire:confirm="Delete this shipment? This cannot be undone."
                                        class="px-3 py-1.5 rounded-lg text-xs font-semibold text-red-600 bg-red-50 hover:bg-red-100 transition">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-14 text-center">
                                @if($search || $statusFilter)
                                    <div class="flex flex-col items-center gap-3">
                                        <p class="text-gray-400 text-sm">No shipments match your search or filter criteria.</p>
                                        <button wire:click="clearFilters" class="text-indigo-600 text-xs font-bold hover:underline">
                                            Clear all filters
                                        </button>
                                    </div>
                                @else
                                    <p class="text-gray-400 text-sm">No shipments found. Start by creating your first shipment.</p>
                                @endif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($shipments->hasPages())
            <div class="px-6 py-4 border-t border-gray-50">
                {{ $shipments->links() }}
            </div>
        @endif
    </div>
</div>