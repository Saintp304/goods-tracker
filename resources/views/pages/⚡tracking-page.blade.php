<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\Shipment;
use App\Services\FinancialService;

new #[Title('Track Shipment')] class extends Component
{
  public string $trackingNumber = '';
  public bool $searched = false;
  public bool $notFound = false;
  public ?Shipment $shipment = null;
  public ?\App\Models\Invoice $invoice = null;
  public float $paidAmount = 0;
  public float $balance = 0;
  public array $paymentStats = [];

  protected $queryString = ['trackingNumber'];

  public function mount(): void
  {
    if ($this->trackingNumber) {
      $this->track();
    }
  }

  public function track(): void
  {
    $this->validate([
    'trackingNumber' => 'required|min:6',
    ]);

    $this->shipment = Shipment::with('histories')
    ->where('tracking_number', strtoupper(trim($this->trackingNumber)))
    ->first();

    $this->notFound = !$this->shipment;
    $this->searched = true;

    if ($this->shipment && $this->shipment->invoice) {
      $this->invoice = $this->shipment->invoice;
      $this->paidAmount = app(FinancialService::class)->getTotalCompletedPayments($this->invoice);
      $this->balance = app(FinancialService::class)->calculateRemainingBalance($this->invoice);
      $this->paymentStats = [
        'type' => $this->invoice->payment_type ?? 'pay_on_delivery',
        'hasPendingPayment' => $this->invoice->payments()->where('status', '!=', 'COMPLETED')->exists(),
      ];
    }
  }
};
?>

<div class="min-h-screen pt-24 pb-20" style="background:#f8f7ff; font-family: 'Sora', sans-serif;">
  @script
  <script>

    window.initShipmentMap = function (el, addresses) {
      if (!window.L) return;
      const map = L.map(el);
      L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '&copy; OpenStreetMap contributors',
      maxZoom: 19,
      }).addTo(map);

      async function geocode(addr) {
        const url = `https://nominatim.openstreetmap.org/search?format=json&limit=1&q=${encodeURIComponent(addr)}`;
        try {
          const res = await fetch(url, {
            headers: {
              'Accept': 'application/json'
            }
          });
          const data = await res.json();
          if (data && data.length > 0) {
            return {
              address: addr,
              lat: parseFloat(data[0].lat),
              lng: parseFloat(data[0].lon)
            };
          }
        } catch (e) {
          console.error('Geocode error for', addr, e);
        }
        return null;
      }

      async function fetchRoadRoute(a, b) {
        const url = `https://router.project-osrm.org/route/v1/driving/${a.lng},${a.lat};${b.lng},${b.lat}?overview=full&geometries=geojson`;
        try {
          const res = await fetch(url);
          const data = await res.json();
          if (data && data.routes && data.routes.length > 0) {
            return data.routes[0].geometry.coordinates.map(c => [c[1], c[0]]);
          }
        } catch (e) {
          console.error('OSRM route error:', e);
        }
        return null;
      }

      function iconFor(idx, total) {
        let iconUrl = 'https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-2x-blue.png';
        if (idx === 0) {
          iconUrl = 'https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-2x-green.png';
        } else if (idx === total - 1) {
          iconUrl = 'https://cdn.jsdelivr.net/gh/pointhi/leaflet-color-markers@master/img/marker-icon-2x-red.png';
        }
        return L.icon({
        iconUrl,
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/images/marker-shadow.png',
        iconSize: [25,41], iconAnchor: [12,41], popupAnchor: [1,-34]
        });
      }

      async function build() {
        const cleanAddrs = addresses.filter(Boolean);
        const results = await Promise.all(cleanAddrs.map(geocode));
        const points = results.filter(Boolean);

        if (points.length === 0) return;

        const markers = points.map((pt, idx) =>
        L.marker([pt.lat, pt.lng], { icon: iconFor(idx, points.length) })
        .addTo(map)
        .bindPopup(pt.address)
        );

        const legs = [];
        for (let i = 0; i < points.length - 1; i++) {
          legs.push(fetchRoadRoute(points[i], points[i + 1]));
        }
        const legResults = await Promise.all(legs);

        legResults.forEach((roadCoords, i) => {
        if (roadCoords) {
        L.polyline(roadCoords, { color: '#4f46e5', weight: 5, opacity: 0.8 }).addTo(map);
        } else {
        L.polyline(
        [[points[i].lat, points[i].lng], [points[i+1].lat, points[i+1].lng]],
        { color: '#4f46e5', weight: 5, opacity: 0.8, dashArray: '6,6' }
        ).addTo(map);
        }
        });

        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds(), { padding: [20,20] });
      }

      build().catch(err => console.error('Map build error:', err));
    };
  </script>
  @endscript
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .fade-up {
      animation: fadeUp 0.55s ease both;
    }
    .fade-up-1 {
      animation-delay: 0.05s;
    }
    .fade-up-2 {
      animation-delay: 0.15s;
    }
    .fade-up-3 {
      animation-delay: 0.28s;
    }
    .history-card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .history-card:hover {
      transform: translateX(4px);
      box-shadow: 0 4px 20px rgba(79,70,229,0.10);
    }
    .track-btn {
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .track-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(79,70,229,0.3);
    }
  </style>

  <div class="max-w-6xl mx-auto px-4 sm:px-6">

    <!-- Page Header -->
    <div class="text-center mb-10 fade-up fade-up-1">
      <span class="inline-block px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-4"
        style="background:#e0e7ff; color:#4f46e5;">Shipment Tracker</span>
      <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900">Track Your Package</h1>
      <p class="mt-3 text-gray-400 font-light text-lg">
        Enter your tracking number for live shipment updates
      </p>
    </div>

    <!-- Search Form -->
    <div class="fade-up fade-up-2 max-w-2xl mx-auto mb-12">
      <form wire:submit.prevent="track"
        class="bg-white rounded-2xl shadow-lg border border-indigo-50 p-3 flex flex-col sm:flex-row gap-3">
        <div class="flex-1 flex items-center gap-3 bg-gray-50 rounded-xl px-4 border border-gray-100">
          <svg class="w-5 h-5 flex-shrink-0" style="color:#4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
          </svg>
          <input
          type="text"
          wire:model="trackingNumber"
          placeholder="Enter tracking number (e.g. TG-123456)"
          class="w-full bg-transparent py-3.5 text-gray-700 placeholder-gray-400 focus:outline-none text-sm uppercase"
          />
      </div>
      <button type="submit"
        wire:loading.attr="disabled"
        class="track-btn bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3.5 rounded-xl text-sm whitespace-nowrap">
        <span wire:loading.remove>Track Now</span>
        <span wire:loading>Searching...</span>
      </button>
    </form>

    @error('trackingNumber')
    <p class="text-red-500 text-sm mt-3 text-center flex items-center justify-center gap-1">
      <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M18 10A8 8 0 1 1 2 10a8 8 0 0 1 16 0zm-7 4a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1-9a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1z" clip-rule="evenodd" />
      </svg>
      {{ $message }}
    </p>
    @enderror
  </div>

  @if ($searched)
  <div class="fade-up fade-up-3">

    {{-- NOT FOUND --}}
    @if ($notFound)
    <div class="max-w-md mx-auto text-center py-16">
      <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5"
        style="background:#fef2f2;">
        <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
      </div>
      <h2 class="text-xl font-bold text-gray-800">Shipment Not Found</h2>
      <p class="text-gray-400 mt-2 text-sm">
        No shipment matched <span class="font-mono font-semibold text-gray-600">{{ $trackingNumber }}</span>.
        Please check the number and try again.
      </p>
    </div>

    @else

    {{-- STATUS BANNER --}}
    @php
    $statusColors = [
    'pending'         => ['bg' => 'linear-gradient(135deg,#f59e0b,#d97706)', 'badge' => 'bg-white/20 text-white'],
    'picked_up'       => ['bg' => 'linear-gradient(135deg,#3b82f6,#2563eb)', 'badge' => 'bg-white/20 text-white'],
    'in_transit'      => ['bg' => 'linear-gradient(135deg,#4f46e5,#3730a3)', 'badge' => 'bg-white/20 text-white'],
    'cleared_transit' => ['bg' => 'linear-gradient(135deg,#4f46e5,#3730a3)', 'badge' => 'bg-white/20 text-white'],
    'delivered'       => ['bg' => 'linear-gradient(135deg,#10b981,#059669)', 'badge' => 'bg-white/20 text-white'],
    'held'            => ['bg' => 'linear-gradient(135deg,#ef4444,#dc2626)', 'badge' => 'bg-white/20 text-white'],
    'cancelled'       => ['bg' => 'linear-gradient(135deg,#6b7280,#4b5563)', 'badge' => 'bg-white/20 text-white'],
    ];
    $sc = $statusColors[$shipment->status] ?? $statusColors['pending'];
    $statusLabels = [
    'pending' => 'Pending',
    'picked_up' => 'Picked Up',
    'in_transit' => 'In Transit',
    'held' => 'Customs Hold',
    'cleared_transit' => 'Cleared — In Transit',
    'delivered' => 'Delivered',
    'cancelled' => 'Cancelled',
    ];
    @endphp

    <div class="max-w-2xl mx-auto mb-6">
    <div class="rounded-2xl p-5 flex items-center gap-4" style="background: {{ $sc['bg'] }};">
    <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center flex-shrink-0">
    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 10V11"/>
    </svg>
    </div>
    <div class="flex-1 min-w-0">
    <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">Tracking Number</p>
    <p class="text-white font-bold text-lg truncate font-mono">{{ $shipment->tracking_number }}</p>
    </div>
    <div class="text-right flex-shrink-0">
    <p class="text-white/70 text-xs font-semibold uppercase tracking-widest">Status</p>
    <span class="inline-block mt-1 {{ $sc['badge'] }} text-sm font-bold px-3 py-1 rounded-full bg-white/20">
    {{ $statusLabels[$shipment->status] ?? ucfirst(str_replace('_', ' ', $shipment->status)) }}
    </span>
    </div>
    </div>
    </div>

    {{-- CUSTOMS HOLD WARNING BANNER --}}
    @if($shipment->status === 'held')
    <div class="max-w-2xl mx-auto mb-10">
    <div class="rounded-2xl p-5 bg-red-50 border-2 border-red-200 flex items-start gap-4">
    <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
    </svg>
    </div>
    <div class="flex-1">
    <p class="text-sm font-bold text-red-700">Your shipment is on Customs Hold</p>
    @if($invoice)
    <p class="text-sm text-red-600 mt-1">
    A payment of <strong>{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</strong> is required to release this package for delivery.
    </p>
    @if($balance > 0)
    <a href="/track/payment/{{ $shipment->tracking_number }}"
    class="inline-block mt-3 bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-2 rounded-xl text-sm transition">
    Pay Now to Release
    </a>
    @else
    <p class="text-sm text-green-600 font-semibold mt-2">Payment received — awaiting release confirmation.</p>
    @endif
    @else
    <p class="text-sm text-red-600 mt-1">Payment details are being finalized. Please check back shortly.</p>
    @endif
    </div>
    </div>
    </div>
    @endif

    {{-- MAIN GRID --}}
    <div class="grid md:grid-cols-2 gap-6 mb-6">

    {{-- Details + Timeline --}}
    <div class="bg-white rounded-2xl shadow-md border border-indigo-50 p-6 md:p-8">
    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
    <span class="w-2 h-5 rounded-full inline-block" style="background:#4f46e5;"></span>
    Shipment Details
    </h2>

    {{-- Shipment Image --}}
    @if($shipment->shipment_image)
    <div class="mb-6 rounded-2xl overflow-hidden border border-gray-100 relative group">
    <img src="{{ Storage::url($shipment->shipment_image) }}" class="w-full h-48 object-cover" />
    <div class="absolute bottom-0 left-0 right-0 p-3 bg-gradient-to-t from-black/60 to-transparent">
    <p class="text-white text-xs font-medium">Package Preview</p>
    </div>
    </div>
    @endif

    <div class="space-y-0 mb-8">
    <div class="flex justify-between items-start py-3 border-b border-gray-50">
    <span class="text-gray-400 text-sm">Sender</span>
    <div class="text-right">
    <p class="font-semibold text-gray-800 text-sm">{{ $shipment->sender_name }}</p>
    <p class="text-xs text-gray-500">{{ $shipment->sender_phone }}</p>
    <p class="text-xs text-gray-400">{{ $shipment->sender_country }}</p>
    </div>
    </div>
    <div class="flex justify-between items-start py-3 border-b border-gray-50">
    <span class="text-gray-400 text-sm">Receiver</span>
    <div class="text-right">
    <p class="font-semibold text-gray-800 text-sm">{{ $shipment->receiver_name }}</p>
    <p class="text-xs text-gray-500">{{ $shipment->receiver_phone }}</p>
    <p class="text-xs text-gray-400">{{ $shipment->receiver_email }}</p>
    <p class="text-xs text-gray-400">{{ $shipment->receiver_country }}</p>
    </div>
    </div>
    <div class="flex justify-between items-center py-3 border-b border-gray-50">
    <span class="text-gray-400 text-sm">Route</span>
    <span class="font-semibold text-gray-800 text-sm">{{ $shipment->origin }} → {{ $shipment->destination }}</span>
    </div>
    <div class="flex justify-between items-center py-3 border-b border-gray-50">
    <span class="text-gray-400 text-sm">Package</span>
    <div class="text-right">
    <p class="font-semibold text-gray-800 text-sm">{{ $shipment->package_type ?? 'Standard' }}
    </p>
    <p class="text-xs text-gray-400">
    {{ $shipment->package_weight ?? 'N/A' }} • {{ $shipment->package_quantity ?? '1' }} unit(s)
    </p>
    </div>
    </div>
    <div class="flex justify-between items-center py-3">
    <span class="text-gray-400 text-sm">Estimated Arrival</span>
    <span class="font-semibold text-sm" style="color:#4f46e5;">
    {{ $shipment->eta?->format('M d, Y') ?? 'TBD' }}
    </span>
    </div>
    </div>

    {{-- Progress Steps --}}
    <h3 class="text-sm font-bold text-gray-700 uppercase tracking-widest mb-5">Progress</h3>
    <div class="space-y-0">
    @foreach ($shipment->steps as $step)
    <div class="flex items-start gap-4">
    <div class="flex flex-col items-center">
    <div class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 z-10"
    style="{{ !empty($step['flag']) ? 'background:#ef4444;' : ($step['done'] ? 'background:#4f46e5;' : 'background:#e5e7eb;') }}">
    @if($step['done'])
    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
    </svg>
    @else
    <div class="w-2 h-2 rounded-full bg-gray-400"></div>
    @endif
    </div>
    @if(!$loop->last)
    <div class="w-px my-1" style="{{ $step['done'] ? 'background:#c7d2fe; min-height:24px;' : 'background:#e5e7eb; min-height:24px;' }}"></div>
    @endif
    </div>
    <div class="pb-5 pt-1.5">
<p class="text-sm font-semibold {{ !empty($step['flag']) ? 'text-red-600' : ($step['done'] ? 'text-gray-900' : 'text-gray-400') }}">
    {{ $step['label'] }}
    </p>
    </div>
    </div>
    @endforeach

    @if($shipment->status === 'held')
    <div class="mt-2 flex items-center gap-2 bg-red-50 border border-red-100 rounded-lg px-3 py-2">
    <span class="w-2 h-2 rounded-full bg-red-500"></span>
    <p class="text-xs font-bold text-red-700">Currently paused on Customs Hold</p>
    </div>
    @endif
    </div>
    </div>

    {{-- Tracking History --}}
    <div class="bg-white rounded-2xl shadow-md border border-indigo-50 p-6 md:p-8">
    <h2 class="text-lg font-bold text-gray-900 mb-5 flex items-center gap-2">
    <span class="w-2 h-5 rounded-full inline-block" style="background:#4f46e5;"></span>
    Tracking History
    </h2>

    <div class="space-y-3">
    @forelse ($shipment->histories as $event)
    <div class="history-card bg-gray-50 rounded-xl p-4 border border-gray-100 cursor-default">
    <div class="flex items-start justify-between gap-3">
    <div class="flex items-start gap-3">
    <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5"
    style="background:#e0e7ff;">
    <svg class="w-4 h-4" style="color:#4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
    </svg>
    </div>
    <div>
    <p class="font-bold text-gray-800 text-sm">
    {{ $event->location }}
    </p>
    <p class="text-gray-500 text-sm mt-0.5">
    {{ $event->info }}
    </p>
    </div>
    </div>
    <span class="text-xs text-gray-400 font-medium whitespace-nowrap flex-shrink-0 mt-1">
    {{ $event->created_at->format('M d • h:i A') }}
    </span>
    </div>
    </div>
    @empty
    <div class="text-center py-8 text-gray-400 text-sm">
    No tracking updates yet.
    </div>
    @endforelse
    </div>

    @if($shipment->eta)
    <div class="mt-6 rounded-xl p-4 flex items-center gap-3" style="background:#e0e7ff;">
    <svg class="w-5 h-5 flex-shrink-0" style="color:#4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
    </svg>
    <div>
    <p class="text-xs font-bold uppercase tracking-widest" style="color:#4f46e5;">
    Estimated Delivery
    </p>
    <p class="font-bold text-gray-800 text-sm">
    {{ $shipment->eta->format('F d, Y') }}
    </p>
    </div>
    </div>
    @endif
    </div>
    </div>

    {{-- Map --}}
    <div class="bg-white rounded-2xl shadow-md border border-indigo-50 overflow-hidden" style="height: 340px;">
    <div class="flex items-center gap-2 px-6 py-3 border-b border-gray-50">
    <svg class="w-4 h-4" style="color:#4f46e5;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
    </svg>
    <span class="text-sm font-semibold text-gray-700">
    Last Known Location — {{ $shipment->histories->first()?->location ?? $shipment->origin }}
    </span>
    </div>
    <div
    id="shipment-map"
    x-data
    x-init='initShipmentMap($el, [
    @if($shipment->origin) @json($shipment->origin), @endif
    @foreach($shipment->histories->reverse() as $h)
    @json($h->location),
    @endforeach
    ])'
    style="height: calc(100% - 45px); width: 100%;"
    ></div>
    </div>

    @endif

    {{-- FINANCIAL SECTION --}}
    @if ($shipment && $invoice)
    <div class="mt-8 fade-up fade-up-3 bg-gradient-to-r from-indigo-50 to-purple-50 rounded-2xl p-6 border border-indigo-100">
    <h2 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-2">
    <span class="w-2 h-5 rounded-full inline-block" style="background:#4f46e5;"></span>
    Payment &amp; Invoice
    </h2>

    <div class="grid md:grid-cols-3 gap-6">
    <div class="md:col-span-2">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-indigo-50">
    <div class="flex justify-between items-start mb-4">
    <div>
    <p class="text-sm text-gray-500 mb-1">Invoice</p>
    <p class="font-mono font-bold text-gray-900">#{{ $invoice->invoice_number }}</p>
    <p class="text-xs text-gray-400 mt-1">Tracking: {{ $shipment->tracking_number }}</p>
    </div>
    <div class="text-right">
    <p class="text-sm text-gray-500 mb-1">Status</p>
    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
    {{ $invoice->status === 'PAID' ? 'bg-green-100 text-green-700' : '' }}
    {{ $invoice->status === 'OPEN' ? 'bg-blue-100 text-blue-700' : '' }}
    {{ $invoice->status === 'PARTIALLY_PAID' ? 'bg-yellow-100 text-yellow-700' : '' }}
    {{ $invoice->status === 'CANCELLED' ? 'bg-gray-200 text-gray-700' : '' }}">
    {{ $invoice->getStatusLabel() }}
    </span>
    </div>
    </div>

    <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-4">
    <div class="min-w-0">
    <p class="text-xs text-gray-500 mb-1">Total</p>
    <p class="text-sm sm:text-lg font-bold text-gray-900 break-words">{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</p>
    </div>
    <div class="min-w-0">
    <p class="text-xs text-gray-500 mb-1">Paid</p>
    <p class="text-sm sm:text-lg font-bold text-green-600 break-words">{{ $invoice->currency }} {{ number_format($paidAmount, 2) }}</p>
    </div>
    <div class="min-w-0">
    <p class="text-xs text-gray-500 mb-1">Balance</p>
    <p class="text-sm sm:text-lg font-bold {{ $balance > 0 ? 'text-red-600' : 'text-green-600' }} break-words">{{ $invoice->currency }} {{ number_format($balance, 2) }}</p>
    </div>
    </div>

    <div class="flex flex-col sm:flex-row gap-3 mt-6">
    <a href="/track/invoice/{{ $shipment->tracking_number }}" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-4 rounded-xl text-sm transition text-center">
    View Invoice
    </a>
    @if ($shipment->status === 'held' && $paymentStats['type'] === 'instant' && $balance > 0)
    <a href="/track/payment/{{ $shipment->tracking_number }}" class="flex-1 bg-white border border-indigo-600 text-indigo-600 hover:bg-indigo-50 font-semibold py-3 px-4 rounded-xl text-sm transition text-center">
    Pay Now
    </a>
    @endif
    </div>

    @if ($shipment->status !== 'held' && $balance > 0)
    <div class="mt-4 bg-gray-50 border border-gray-100 rounded-lg p-3 flex items-center gap-2">
    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <p class="text-xs text-gray-600 font-medium">Payment is only accepted while this shipment is on Customs Hold.</p>
    </div>
    @endif

    @if ($paymentStats['hasPendingPayment'])
    <div class="mt-4 bg-amber-50 border border-amber-100 rounded-lg p-3 flex items-center gap-2">
    <svg class="w-4 h-4 text-amber-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
    </svg>
    <p class="text-xs text-amber-800 font-medium">A payment is awaiting admin verification.</p>
    </div>
    @endif
    </div>
    </div>

    <div class="bg-white rounded-xl p-5 shadow-sm border border-indigo-50">
    <p class="text-sm text-gray-500 mb-2">Payment Type</p>
    <p class="font-semibold text-gray-900 mb-4">
    @if ($paymentStats['type'] === 'pay_on_delivery')
    Pay on Delivery
    @else
    Instant Payment
    @endif
    </p>

    @if ($shipment->status !== 'held' && $balance > 0)
    <div class="bg-gray-50 border border-gray-100 rounded-lg p-3">
    <p class="text-xs text-gray-700 font-medium">Payment Locked</p>
    <p class="text-sm text-gray-600">Available only during Customs Hold</p>
    </div>
    @elseif ($paymentStats['type'] === 'pay_on_delivery')
    <div class="bg-yellow-50 border border-yellow-100 rounded-lg p-3">
    <p class="text-xs text-yellow-800 font-medium">Due on Delivery</p>
    <p class="text-sm text-yellow-700">Payment collected at destination</p>
    </div>
    @elseif ($balance <= 0)
    <div class="bg-green-50 border border-green-100 rounded-lg p-3">
    <p class="text-xs text-green-800 font-medium">Paid in Full</p>
    <p class="text-sm text-green-700">No balance remaining</p>
    </div>
    @elseif ($paymentStats['hasPendingPayment'])
    <div class="bg-amber-50 border border-amber-100 rounded-lg p-3">
    <p class="text-xs text-amber-800 font-medium">Awaiting Verification</p>
    <p class="text-sm text-amber-700">A submitted payment is under review</p>
    </div>
    @else
    <div class="bg-red-50 border border-red-100 rounded-lg p-3">
    <p class="text-xs text-red-800 font-medium">Payment Required</p>
    <p class="text-sm text-red-700">Pay now to release from Customs Hold</p>
    </div>
    @endif
    </div>
    </div>
    </div>
    @endif

    </div>
    @endif
    </div>
    </div>
    </div>