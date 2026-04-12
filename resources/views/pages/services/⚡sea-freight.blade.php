<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Sea Freight')] class extends Component
{
  //
  };
  ?>

  <div class="min-h-screen bg-gray-50">

    <section class="relative h-[60vh] flex items-center justify-center text-white">
      <div class="absolute inset-0 bg-cover bg-center"
        style="background-image: url('/img/sea-freight.jpg');"></div>
      <div class="absolute inset-0 bg-blue-900/70"></div>

      <div class="relative text-center">
        <h1 class="text-5xl font-extrabold">Sea Freight</h1>
        <p class="mt-4 text-xl">
          Cost-effective shipping for bulk goods
        </p>
      </div>
    </section>

    <section class="py-20 max-w-7xl mx-auto px-4">

      <div class="text-center max-w-3xl mx-auto">
        <h2 class="text-3xl font-bold">Affordable Global Shipping</h2>
        <p class="mt-4 text-gray-600">
          Best for heavy and large shipments across continents.
        </p>
      </div>

      <div class="mt-16 grid md:grid-cols-3 gap-8">
        <div class="card">
          Container Shipping
        </div>
        <div class="card">
          Bulk Cargo
        </div>
        <div class="card">
          Port Handling
        </div>
      </div>

      <div class="mt-20 text-center">
        <a href="/track" class="btn-primary">Track Shipment →</a>
      </div>

    </section>

  </div>
  
  <style>
.card {
  @apply bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition text-center font-semibold;
}

.btn-primary {
  @apply bg-indigo-600 text-white px-8 py-4 rounded-full hover:bg-indigo-700 transition;
}
</style>