@props(['shipment', 'active'])

<div class="flex gap-1 bg-gray-100 p-1 rounded-xl w-full sm:w-fit overflow-x-auto">
    <a href="{{ route('admin.shipments.edit', $shipment->id) }}" wire:navigate
        class="flex-1 sm:flex-none text-center px-4 py-2 rounded-lg text-sm font-bold transition whitespace-nowrap
        {{ $active === 'details' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
        Details
    </a>
    <a href="{{ route('admin.shipments.tracking', $shipment->id) }}" wire:navigate
        class="flex-1 sm:flex-none text-center px-4 py-2 rounded-lg text-sm font-bold transition whitespace-nowrap
        {{ $active === 'tracking' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
        Tracking
    </a>
    @if($shipment->invoice)
    <a href="{{ route('admin.shipments.invoice', $shipment->id) }}" wire:navigate
        class="flex-1 sm:flex-none text-center px-4 py-2 rounded-lg text-sm font-bold transition whitespace-nowrap
        {{ $active === 'invoice' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-500 hover:text-gray-700' }}">
        Invoice
    </a>
    @endif
</div>
