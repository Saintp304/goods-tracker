
<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Air Freight')] class extends Component
{
  //
};
?>

<div class="min-h-screen bg-white">

  <!-- HERO -->
  <section class="relative h-[55vh] flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
      style="background-image: url('/img/air-freight.jpg');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900/90 to-slate-700/70"></div>
    <div class="relative text-center px-4 max-w-3xl mx-auto">
      <p class="text-sm font-semibold uppercase tracking-widest text-sky-400 mb-3">
        Our Services
      </p>
      <h1 class="text-4xl md:text-5xl font-bold leading-tight">Air Freight</h1>
      <p class="mt-4 text-lg text-slate-300 max-w-xl mx-auto">
        Fast, reliable air cargo solutions connecting your business to the world.
      </p>
      <a href="#" class="mt-6 inline-block bg-sky-500 hover:bg-sky-600 text-white font-semibold px-7 py-3 rounded-lg transition">
        Request a Quote
      </a>
    </div>
  </section>

  <!-- STATS -->
  <div class="bg-slate-800 text-white">
    <div class="max-w-5xl mx-auto grid grid-cols-2 md:grid-cols-4 divide-x divide-slate-700">
      <div class="text-center py-6 px-4">
        <p class="text-2xl font-bold text-sky-400">
          180+
        </p>
        <p class="text-sm text-slate-400 mt-1">
          Countries
        </p>
      </div>
      <div class="text-center py-6 px-4">
        <p class="text-2xl font-bold text-sky-400">
          24hr
        </p>
        <p class="text-sm text-slate-400 mt-1">
          Avg. Transit
        </p>
      </div>
      <div class="text-center py-6 px-4">
        <p class="text-2xl font-bold text-sky-400">
          99.6%
        </p>
        <p class="text-sm text-slate-400 mt-1">
          On-Time Rate
        </p>
      </div>
      <div class="text-center py-6 px-4">
        <p class="text-2xl font-bold text-sky-400">
          50K+
        </p>
        <p class="text-sm text-slate-400 mt-1">
          Shipments/yr
        </p>
      </div>
    </div>
  </div>

  <!-- INTRO -->
  <section class="py-16 px-4 max-w-5xl mx-auto">
    <div class="grid md:grid-cols-2 gap-12 items-center">
      <div>
        <p class="text-sm font-semibold uppercase tracking-widest text-sky-500 mb-2">
          Why Air Freight
        </p>
        <h2 class="text-3xl font-bold text-slate-800 leading-snug">
          The fastest way to move your cargo globally
        </h2>
        <p class="mt-4 text-slate-500 leading-relaxed">
          When speed and reliability matter most, air freight is the ideal solution. We provide
          end-to-end air cargo services with real-time tracking, full customs support, and
          flexible scheduling to meet your deadlines every time.
        </p>
        <ul class="mt-6 space-y-3">
          <li class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-600">Express and standard air freight options</span>
          </li>
          <li class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-600">Full cargo insurance and tamper-proof packaging</span>
          </li>
          <li class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-600">Dedicated customs clearance team</span>
          </li>
          <li class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-5 h-5 rounded-full bg-sky-100 text-sky-600 flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-600">Live tracking from pickup to delivery</span>
          </li>
        </ul>
      </div>
      <div class="rounded-2xl overflow-hidden shadow-lg">
        <img src="/img/air-freight.jpg" alt="Air Freight" class="w-full h-72 object-cover" />
    </div>
  </div>
</section>

<!-- FEATURES -->
<section class="bg-slate-50 py-16 px-4">
  <div class="max-w-5xl mx-auto">
    <div class="text-center mb-10">
      <p class="text-sm font-semibold uppercase tracking-widest text-sky-500 mb-2">
        What We Offer
      </p>
      <h2 class="text-3xl font-bold text-slate-800">Key Features</h2>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
      <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
          </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Global Reach</h3>
        <p class="text-sm text-slate-500 leading-relaxed">
          Access to 180+ countries through our international airline partner network.
        </p>
      </div>

      <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Fast Delivery</h3>
        <p class="text-sm text-slate-500 leading-relaxed">
          Next-flight-out options and standard 1–3 business day international transit.
        </p>
      </div>

      <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Secure Cargo</h3>
        <p class="text-sm text-slate-500 leading-relaxed">
          Full insurance coverage and tamper-evident packaging for peace of mind.
        </p>
      </div>

      <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
          </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Live Tracking</h3>
        <p class="text-sm text-slate-500 leading-relaxed">
          Real-time shipment visibility with milestone alerts at every stage.
        </p>
      </div>

      <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
          </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">Customs Clearance</h3>
        <p class="text-sm text-slate-500 leading-relaxed">
          In-house customs brokers handle all documentation and compliance requirements.
        </p>
      </div>

      <div class="bg-white rounded-xl p-6 border border-slate-100 shadow-sm hover:shadow-md transition">
        <div class="w-10 h-10 bg-sky-100 rounded-lg flex items-center justify-center mb-4">
          <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z" />
          </svg>
        </div>
        <h3 class="font-semibold text-slate-800 mb-2">24/7 Support</h3>
        <p class="text-sm text-slate-500 leading-relaxed">
          Round-the-clock customer support to assist you at any point in your shipment.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="py-16 px-4 max-w-5xl mx-auto">
  <div class="text-center mb-10">
    <p class="text-sm font-semibold uppercase tracking-widest text-sky-500 mb-2">
      The Process
    </p>
    <h2 class="text-3xl font-bold text-slate-800">How It Works</h2>
  </div>
  <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
    <div class="text-center">
      <div class="w-12 h-12 rounded-full bg-sky-500 text-white flex items-center justify-center text-lg font-bold mx-auto mb-4">
        1
      </div>
      <h4 class="font-semibold text-slate-800 mb-1">Book Online</h4>
      <p class="text-sm text-slate-500">
        Submit shipment details and get an instant quote through our platform.
      </p>
    </div>
    <div class="text-center">
      <div class="w-12 h-12 rounded-full bg-sky-500 text-white flex items-center justify-center text-lg font-bold mx-auto mb-4">
        2
      </div>
      <h4 class="font-semibold text-slate-800 mb-1">We Pick Up</h4>
      <p class="text-sm text-slate-500">
        Our team collects and prepares your cargo for air transit.
      </p>
    </div>
    <div class="text-center">
      <div class="w-12 h-12 rounded-full bg-sky-500 text-white flex items-center justify-center text-lg font-bold mx-auto mb-4">
        3
      </div>
      <h4 class="font-semibold text-slate-800 mb-1">In the Air</h4>
      <p class="text-sm text-slate-500">
        Your shipment flies via our partner carriers. Track every leg live.
      </p>
    </div>
    <div class="text-center">
      <div class="w-12 h-12 rounded-full bg-sky-500 text-white flex items-center justify-center text-lg font-bold mx-auto mb-4">
        4
      </div>
      <h4 class="font-semibold text-slate-800 mb-1">Delivered</h4>
      <p class="text-sm text-slate-500">
        Last-mile delivery with proof of delivery and instant notification.
      </p>
    </div>
  </div>
</section>

<!-- OTHER SERVICES -->
<section class="bg-slate-50 py-16 px-4">
  <div class="max-w-5xl mx-auto">
    <div class="text-center mb-10">
      <p class="text-sm font-semibold uppercase tracking-widest text-sky-500 mb-2">
        Explore More
      </p>
      <h2 class="text-3xl font-bold text-slate-800">Our Other Services</h2>
    </div>
    <div class="grid sm:grid-cols-2 gap-6">
      <a href="#" class="group flex items-center gap-5 bg-white border border-slate-100 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-sky-200 transition">
        <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
          </svg>
        </div>
        <div>
          <h3 class="font-semibold text-slate-800 group-hover:text-sky-600 transition">Sea Freight</h3>
          <p class="text-sm text-slate-500 mt-1">
            Cost-effective ocean shipping for large or heavy cargo.
          </p>
        </div>
        <svg class="w-4 h-4 text-slate-300 group-hover:text-sky-500 ml-auto transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>

      <a href="#" class="group flex items-center gap-5 bg-white border border-slate-100 rounded-xl p-6 shadow-sm hover:shadow-md hover:border-sky-200 transition">
        <div class="w-12 h-12 bg-sky-100 rounded-lg flex items-center justify-center flex-shrink-0">
          <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4zM1 1h2l2.68 13.39a2 2 0 001.97 1.61H17a2 2 0 001.95-1.55L21 7H6" />
          </svg>
        </div>
        <div>
          <h3 class="font-semibold text-slate-800 group-hover:text-sky-600 transition">Road Transportation</h3>
          <p class="text-sm text-slate-500 mt-1">
            Reliable ground freight for local and regional deliveries.
          </p>
        </div>
        <svg class="w-4 h-4 text-slate-300 group-hover:text-sky-500 ml-auto transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
      </a>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="bg-sky-600 py-16 px-4 text-white text-center">
  <div class="max-w-2xl mx-auto">
    <h2 class="text-3xl font-bold">Ready to ship your cargo?</h2>
    <p class="mt-3 text-sky-100">
      Get a free quote from our team today. Fast, transparent pricing with no hidden fees.
    </p>
    <div class="mt-8 flex flex-col sm:flex-row gap-3 justify-center">
      <a href="#" class="bg-white text-sky-600 font-semibold px-7 py-3 rounded-lg hover:bg-sky-50 transition">
        Get a Free Quote
      </a>
      <a href="#" class="border border-white/40 text-white font-semibold px-7 py-3 rounded-lg hover:bg-white/10 transition">
        Contact Us
      </a>
    </div>
  </div>
</section>

</div>