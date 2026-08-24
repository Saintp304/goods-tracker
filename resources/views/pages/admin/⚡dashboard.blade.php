<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use Illuminate\Support\Facades\DB;

new #[Title('Dashboard')]
#[Layout('layouts.admin')]
class extends Component
{
    public int $total = 0;
    public array $stats = [];
    public $recent;
    public $held;
    public $upcoming;

    public function mount(): void
    {
        // Optimize: Single query for all status counts
        $statusCounts = Shipment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $this->stats = $statusCounts->pluck('total', 'status')->toArray();
        $this->total = $statusCounts->sum('total');

        // Action Required: Held Shipments
        $this->held = Shipment::where('status', 'held')
            ->latest()
            ->take(5)
            ->get();

        // Upcoming Deliveries (Next 7 days, not terminal statuses)
        $this->upcoming = Shipment::whereNotIn('status', ['delivered', 'cancelled'])
            ->whereNotNull('eta')
            ->where('eta', '>=', now()->startOfDay())
            ->where('eta', '<=', now()->addDays(7)->endOfDay())
            ->orderBy('eta', 'asc')
            ->take(5)
            ->get();

        // Recent Shipments
        $this->recent = Shipment::latest()->take(6)->get();
    }
};
?>

<div class="space-y-6 md:space-y-8">
    {{-- Stat Cards --}}
    <div class="space-y-4 md:space-y-6">
        {{-- Primary Vitals --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 md:gap-6">
            @foreach ([
                ['label' => 'Total Shipments', 'value' => $total,     'color' => '#4f46e5', 'key' => null],
                ['label' => 'Pending',         'value' => $stats['pending'] ?? 0, 'color' => '#6366f1', 'key' => 'pending'],
                ['label' => 'In Transit',      'value' => ($stats['in_transit'] ?? 0) + ($stats['picked_up'] ?? 0), 'color' => '#f59e0b', 'key' => 'in_transit'],
                ['label' => 'Held',            'value' => $stats['held'] ?? 0, 'color' => '#ef4444', 'key' => 'held'],
            ] as $stat)
                <div class="bg-white rounded-2xl p-4 sm:p-5 md:p-6 border border-gray-100 shadow-sm hover:shadow-md transition-shadow">
                    <p class="text-[10px] sm:text-xs font-semibold text-gray-400 uppercase tracking-widest">
                        {{ $stat['label'] }}
                    </p>
                    <p class="text-2xl sm:text-3xl font-extrabold text-gray-900 mt-2">
                        {{ $stat['value'] }}
                    </p>
                    <div class="mt-3 h-1 w-10 rounded-full" style="background: {{ $stat['color'] }};"></div>
                </div>
            @endforeach
        </div>

        {{-- Secondary Stats --}}
        <div class="grid grid-cols-3 gap-3 sm:gap-4 md:gap-6">
            @foreach ([
                ['label' => 'Picked Up', 'value' => $stats['picked_up'] ?? 0, 'color' => '#818cf8'],
                ['label' => 'Delivered',  'value' => $stats['delivered'] ?? 0, 'color' => '#10b981'],
                ['label' => 'Cancelled',  'value' => $stats['cancelled'] ?? 0, 'color' => '#9ca3af'],
            ] as $stat)
                <div class="bg-white/60 rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-sm">
                    <p class="text-[9px] sm:text-[10px] font-bold text-gray-400 uppercase tracking-wider">
                        {{ $stat['label'] }}
                    </p>
                    <p class="text-lg sm:text-xl font-bold text-gray-700 mt-1">
                        {{ $stat['value'] }}
                    </p>
                    <div class="mt-2 h-0.5 w-6 rounded-full" style="background: {{ $stat['color'] }};"></div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Operational Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-8">
        {{-- Action Required: Held --}}
        <div class="bg-white rounded-2xl border-l-4 border-l-red-500 border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-red-50/30">
                <h2 class="font-bold text-gray-900 flex items-center gap-2 text-sm sm:text-base">
                    <svg class="w-5 h-5 text-red-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.876c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 15c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Action Required: Held Shipments
                </h2>
            </div>
            <div class="p-4">
                @if($held->count() > 0)
                    <div class="space-y-3">
                        @foreach($held as $shipment)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-white transition-colors group">
                                <div class="min-w-0">
                                    <p class="text-sm font-bold text-indigo-600 font-mono truncate">{{ $shipment->tracking_number }}</p>
                                    <p class="text-xs text-gray-600 truncate">{{ $shipment->receiver_name }} • {{ $shipment->destination }}</p>
                                </div>
                                <a href="{{ route('admin.shipments.edit', $shipment) }}" class="shrink-0 p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center py-8 text-sm text-gray-400 italic">No shipments currently held.</p>
                @endif
            </div>
        </div>

        {{-- Upcoming Deliveries --}}
        <div class="bg-white rounded-2xl border-l-4 border-l-indigo-500 border border-gray-100 shadow-sm overflow-hidden">
            <div class="px-4 sm:px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-indigo-50/30">
                <h2 class="font-bold text-gray-900 flex items-center gap-2 text-sm sm:text-base">
                    <svg class="w-5 h-5 text-indigo-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M4 11h16M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Upcoming Deliveries (7 Days)
                </h2>
            </div>
            <div class="p-4">
                @if($upcoming->count() > 0)
                    <div class="space-y-3">
                        @foreach($upcoming as $shipment)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-xl bg-gray-50 border border-gray-100 hover:bg-white transition-colors group">
                                <div class="min-w-0">
                                    <p class="text-xs font-bold text-gray-400 uppercase tracking-tighter">ETA: {{ $shipment->eta?->format('M d, Y') }}</p>
                                    <p class="text-sm font-bold text-gray-700 truncate">{{ $shipment->tracking_number }} • {{ $shipment->receiver_name }}</p>
                                </div>
                                <a href="{{ route('admin.shipments.edit', $shipment) }}" class="shrink-0 p-2 rounded-lg text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center py-8 text-sm text-gray-400 italic">No upcoming deliveries.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Recent Shipments --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-4 sm:px-6 py-4 sm:py-5 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-bold text-gray-900 text-sm sm:text-base">Recent Shipments</h2>
            <a href="{{ route('admin.shipmentsPage') }}" class="text-sm font-semibold hover:underline" style="color:#4f46e5;">
                View all →
            </a>
        </div>

        {{-- MOBILE: Card list --}}
        <div class="sm:hidden divide-y divide-gray-50">
            @forelse ($recent as $shipment)
                @php
                    $colors = [
                        'pending'    => 'bg-yellow-50 text-yellow-700',
                        'picked_up'  => 'bg-indigo-50 text-indigo-700',
                        'in_transit' => 'bg-blue-50 text-blue-700',
                        'delivered'  => 'bg-green-50 text-green-700',
                        'held'       => 'bg-red-50 text-red-700',
                        'cancelled'  => 'bg-gray-100 text-gray-500',
                    ];
                @endphp
                <div class="p-4 space-y-2">
                    <div class="flex items-start justify-between gap-2">
                        <p class="font-mono font-semibold text-indigo-600 text-xs truncate">{{ $shipment->tracking_number }}</p>
                        <span class="shrink-0 px-3 py-1 rounded-full text-[10px] font-bold {{ $colors[$shipment->status] ?? '' }}">
                            {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-700 font-medium">{{ $shipment->receiver_name }}</p>
                    <div class="flex items-center justify-between text-xs text-gray-500">
                        <span>{{ $shipment->origin }} → {{ $shipment->destination }}</span>
                        <span>{{ $shipment->eta?->format('M d, Y') ?? '—' }}</span>
                    </div>
                </div>
            @empty
                <p class="px-6 py-12 text-center text-gray-400 text-sm">No shipments yet.</p>
            @endforelse
        </div>

        {{-- DESKTOP: Table --}}
        <div class="hidden sm:block overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 text-left">
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Tracking #</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Receiver</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Route</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-400 uppercase tracking-widest">ETA</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse ($recent as $shipment)
                        @php
                            $colors = [
                                'pending'    => 'bg-yellow-50 text-yellow-700',
                                'picked_up'  => 'bg-indigo-50 text-indigo-700',
                                'in_transit' => 'bg-blue-50 text-blue-700',
                                'delivered'  => 'bg-green-50 text-green-700',
                                'held'       => 'bg-red-50 text-red-700',
                                'cancelled'  => 'bg-gray-100 text-gray-500',
                            ];
                        @endphp
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 font-mono font-semibold text-indigo-600 text-xs">{{ $shipment->tracking_number }}</td>
                            <td class="px-6 py-4 text-gray-700 font-medium">{{ $shipment->receiver_name }}</td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $shipment->origin }} → {{ $shipment->destination }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $colors[$shipment->status] ?? '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $shipment->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 text-xs">{{ $shipment->eta?->format('M d, Y') ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-400">No shipments yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>