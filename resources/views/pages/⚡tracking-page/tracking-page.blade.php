<div class="min-h-screen bg-gray-50 pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl font-extrabold text-gray-900">
                Track Your Shipment
            </h1>
            <p class="mt-2 text-gray-600">
                Enter your tracking number to view shipment progress
            </p>
        </div>

        <!-- Form -->
        <form wire:submit.prevent="track"
              class="bg-white rounded-2xl shadow-lg p-6 flex flex-col sm:flex-row gap-4 max-w-2xl mx-auto">
            <input
                type="text"
                wire:model.defer="trackingNumber"
                placeholder="Enter tracking number"
                class="flex-1 rounded-xl border border-gray-300 px-4 py-3 focus:ring-2 focus:ring-indigo-500"
            />

            <button class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-8 py-3 rounded-xl">
                Track
            </button>
        </form>

        @error('trackingNumber')
            <p class="text-red-500 text-sm mt-3 text-center">{{ $message }}</p>
        @enderror

        @if ($searched)

        <!-- RESULTS GRID -->
        <div class="mt-16 grid md:grid-cols-2 gap-10">

            <!-- LEFT: DETAILS + STATUS TIMELINE -->
            <div class="bg-white rounded-2xl shadow-xl p-8 space-y-6">
                <h2 class="text-2xl font-bold">Shipment Details</h2>

                <p><strong>Tracking Number:</strong> {{ $shipment['tracking_number'] }}</p>
                <p><strong>Status:</strong>
                    <span class="text-indigo-600 font-bold">{{ $shipment['status'] }}</span>
                </p>
                <p><strong>Current Location:</strong> {{ $shipment['current_location'] }}</p>
                <p><strong>ETA:</strong> {{ $shipment['eta'] }}</p>

                <!-- STATUS TIMELINE -->
                <div class="mt-8">
                    <h3 class="text-lg font-semibold mb-4">Shipment Progress</h3>

                    <ol class="relative border-l border-gray-300">
                        @foreach ($shipment['steps'] as $step)
                            <li class="mb-6 ml-6">
                                <span
                                    class="absolute -left-3 flex h-6 w-6 items-center justify-center rounded-full
                                    {{ $step['done'] ? 'bg-indigo-600' : 'bg-gray-300' }}">
                                </span>

                                <p class="font-medium
                                    {{ $step['done'] ? 'text-gray-900' : 'text-gray-400' }}">
                                    {{ $step['label'] }}
                                </p>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>

            <!-- RIGHT: DETAILED HISTORY -->
            <div class="bg-white rounded-2xl shadow-xl p-8">
                <h3 class="text-xl font-semibold mb-6">Tracking History</h3>

                <div class="space-y-4">
                    @foreach ($shipment['history'] as $event)
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="font-semibold">{{ $event['location'] }}</p>
                            <p class="text-sm text-gray-600">{{ $event['info'] }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $event['date'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <!-- MAP FULL WIDTH -->
        <div class="mt-16 bg-gray-100 rounded-2xl shadow-lg p-10 text-center">
            <p class="text-gray-500">
                Map integration goes here (Google Maps / Leaflet)
            </p>
        </div>

        @endif
    </div>
</div>