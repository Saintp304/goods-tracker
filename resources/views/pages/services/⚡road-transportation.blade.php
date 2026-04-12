<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Road Transport')] class extends Component 
{
//
};
?>

<div class="min-h-screen bg-gray-50">

<section class="relative h-[60vh] flex items-center justify-center text-white">
<div class="absolute inset-0 bg-cover bg-center"
style="background-image: url('/img/road.jpg');"></div>
<div class="absolute inset-0 bg-green-900/70"></div>

<div class="relative text-center">
<h1 class="text-5xl font-extrabold">Road Transport</h1>
<p class="mt-4 text-xl">
Reliable local and regional delivery
</p>
</div>
</section>

<section class="py-20 max-w-7xl mx-auto px-4">

<div class="text-center max-w-3xl mx-auto">
<h2 class="text-3xl font-bold">Efficient Ground Logistics</h2>
<p class="mt-4 text-gray-600">
Perfect for last-mile and regional delivery solutions.
</p>
</div>

<div class="mt-16 grid md:grid-cols-3 gap-8">
<div class="card">
Door Delivery
</div>
<div class="card">
Fleet Tracking
</div>
<div class="card">
Fast Dispatch
</div>
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