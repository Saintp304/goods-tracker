<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Sea Freight')] class extends Component
{
  //
};
?>

<div class="min-h-screen bg-white">

  <!-- HERO -->
  <section class="relative min-h-[92vh] md:min-h-[700px] pt-20 pb-10 flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
      style="background-image: url('https://images.unsplash.com/photo-1494412574643-ffcd0d67f5f8?auto=format&fit=crop&w=1920&q=80');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/70 to-blue-900/60"></div>
    <div class="relative text-center px-4 max-w-4xl mx-auto">
      <p class="text-sm font-semibold uppercase tracking-widest text-blue-400 mb-4">
        Maritime Logistics Solutions
      </p>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">Sea Freight <span class="text-blue-400">Simplified</span></h1>
      <p class="mt-4 text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
        Cost-effective, large-scale ocean shipping for bulk goods. We connect global ports with unmatched efficiency and safety.
      </p>
      <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-bold px-8 py-4 rounded-xl transition shadow-lg shadow-blue-500/30">
          Request a Quote
        </a>
        <a href="#" class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-bold px-8 py-4 rounded-xl transition border border-white/30">
          Learn More
        </a>
      </div>
    </div>
  </section>

  <!-- STATS -->
  <div class="bg-slate-900 text-white py-12 border-y border-slate-800">
    <div class="max-w-6xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 px-4">
      <div class="text-center">
        <p class="text-4xl font-black text-blue-400 mb-1">
          45+
        </p>
        <p class="text-sm uppercase tracking-wide text-slate-400">
          Major Ports
        </p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-blue-400 mb-1">
          Low-Cost
        </p>
        <p class="text-sm uppercase tracking-wide text-slate-400">
          Shipping Rates
        </p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-blue-400 mb-1">
          100%
        </p>
        <p class="text-sm uppercase tracking-wide text-slate-400">
          Cargo Safety
        </p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-blue-400 mb-1">
          Global
        </p>
        <p class="text-sm uppercase tracking-wide text-slate-400">
          Reach
        </p>
      </div>
    </div>
  </div>

  <!-- WHY SEA FREIGHT -->
  <section class="py-24 px-4 max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <div class="absolute -top-4 -left-4 w-24 h-24 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white">
          <img src="https://images.unsplash.com/photo-1577705965362-7d7349327160?auto=format&fit=crop&w=800&q=80" alt="Sea Freight Logistics" class="w-full h-full object-cover" />
      </div>
    </div>
    <div>
      <p class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-4">
        The Economical Giant
      </p>
      <h2 class="text-4xl font-bold text-slate-900 leading-tight mb-6">Move Bulk Cargo with Unmatched Economy</h2>
      <p class="text-lg text-slate-600 leading-relaxed mb-8">
        When volume and cost are the primary concerns, sea freight is the ideal choice. We provide comprehensive ocean shipping solutions that maximize capacity while minimizing expense.
      </p>
      <div class="grid sm:grid-cols-2 gap-6">
        <div class="flex items-start gap-3">
          <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
          <span class="text-slate-700 font-medium">FCL and LCL Options</span>
        </div>
        <div class="flex items-start gap-3">
          <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
          <span class="text-slate-700 font-medium">Port-to-Port Excellence</span>
        </div>
        <div class="flex items-start gap-3">
          <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
          <span class="text-slate-700 font-medium">Customs Brokerage</span>
        </div>
        <div class="flex items-start gap-3">
          <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
          <span class="text-slate-700 font-medium">Marine Insurance</span>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CAPABILITIES (THE BULK) -->
<section class="bg-slate-50 py-24 px-4">
  <div class="max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <p class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-3">
        Maritime Expertise
      </p>
      <h2 class="text-4xl font-bold text-slate-900 mb-4">Our Ocean Freight Capabilities</h2>
      <p class="text-slate-600 max-w-2xl mx-auto">
        From single pallets to entire fleets of containers, we manage the complexities of maritime law and logistics.
      </p>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <!-- Cap 1 -->
      <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
        <div class="h-48 overflow-hidden">
          <img src="https://images.unsplash.com/photo-1577705965362-7d7349327160?auto=format&fit=crop&w=400&q=80" alt="FCL Shipping" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
      </div>
      <div class="p-8">
        <h3 class="text-xl font-bold text-slate-900 mb-3">Full Container Load (FCL)</h3>
        <p class="text-slate-600 leading-relaxed">
          Your cargo has the entire container to itself. This is the fastest and most secure ocean option for large volumes.
        </p>
      </div>
    </div>
    <!-- Cap 2 -->
    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
      <div class="h-48 overflow-hidden">
        <img src="https://images.unsplash.com/photo-1494412574643-ffcd0d67f5f8?auto=format&fit=crop&w=400&q=80" alt="LCL Shipping" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
    </div>
    <div class="p-8">
      <h3 class="text-xl font-bold text-slate-900 mb-3">Less-than-Container Load (LCL)</h3>
      <p class="text-slate-600 leading-relaxed">
        Share container space with other shippers. A highly economical choice for smaller shipments that don't fill a whole container.
      </p>
    </div>
  </div>
  <!-- Cap 3 -->
  <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
    <div class="h-48 overflow-hidden">
      <img src="https://images.unsplash.com/photo-1566577739647-667977162ec8?auto=format&fit=crop&w=400&q=80" alt="RoRo" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
  </div>
  <div class="p-8">
    <h3 class="text-xl font-bold text-slate-900 mb-3">RoRo (Roll-on/Roll-off)</h3>
    <p class="text-slate-600 leading-relaxed">
      Specialized shipping for wheeled cargo like cars, trucks, and heavy machinery. Easy loading and unloading via ramps.
    </p>
  </div>
</div>
<!-- Cap 4 -->
<div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
  <div class="h-48 overflow-hidden">
    <img src="https://images.unsplash.com/photo-1577705965362-7d7349327160?auto=format&fit=crop&w=400&q=80" alt="Breakbulk" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
</div>
<div class="p-8">
  <h3 class="text-xl font-bold text-slate-900 mb-3">Breakbulk Cargo</h3>
  <p class="text-slate-600 leading-relaxed">
    Handling for oversized or unconventional cargo that doesn't fit in containers, such as turbines or large pipes.
  </p>
</div>
</div>
<!-- Cap 5 -->
<div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
<div class="h-48 overflow-hidden">
<img src="https://images.unsplash.com/photo-1494412574643-ffcd0d67f5f8?auto=format&fit=crop&w=400&q=80" alt="Port Logistics" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
</div>
<div class="p-8">
<h3 class="text-xl font-bold text-slate-900 mb-3">Port-to-Port Logistics</h3>
<p class="text-slate-600 leading-relaxed">
End-to-end management from the origin port to the destination port, including all handling and loading fees.
</p>
</div>
</div>
<!-- Cap 6 -->
<div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
<div class="h-48 overflow-hidden">
<img src="https://images.unsplash.com/photo-1577705965362-7d7349327160?auto=format&fit=crop&w=400&q=80" alt="Marine Assurance" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
</div>
<div class="p-8">
<h3 class="text-xl font-bold text-slate-900 mb-3">Marine Assurance</h3>
<p class="text-slate-600 leading-relaxed">
Comprehensive coverage against maritime perils, ensuring your investment is protected across the ocean.
</p>
</div>
</div>
</div>
</div>
</section>

<!-- FEATURES -->
<section class="py-24 px-4 max-w-6xl mx-auto">
<div class="text-center mb-16">
<p class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-3">
The Maritime Edge
</p>
<h2 class="text-4xl font-bold text-slate-900">Ocean Logistics Excellence</h2>
</div>
<div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
<div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
<div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
<path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
</svg>
</div>
<h3 class="text-xl font-bold text-slate-900 mb-3">Global Port Network</h3>
<p class="text-slate-600 leading-relaxed">
Direct access to the world's busiest ports through our global alliance of shipping lines and port operators.
</p>
</div>
<div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
<div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
</svg>
</div>
<h3 class="text-xl font-bold text-slate-900 mb-3">Cargo Optimization</h3>
<p class="text-slate-600 leading-relaxed">
Expert advice on containerization to maximize space and minimize tariffs, reducing your overhead significantly.
</p>
</div>
<div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
<div class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center mb-6">
<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
</svg>
</div>
<h3 class="text-xl font-bold text-slate-900 mb-3">Marine Insurance</h3>
<p class="text-slate-600 leading-relaxed">
Comprehensive coverage against all maritime risks, from weather events to vessel incidents, for total security.
</p>
</div>
</div>
</section>

<!-- FAQ -->
<section class="bg-slate-50 py-24 px-4">
<div class="max-w-4xl mx-auto">
<div class="text-center mb-16">
<p class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-3">
Maritime Insights
</p>
<h2 class="text-4xl font-bold text-slate-900">Sea Freight FAQ</h2>
</div>
<div class="space-y-6">
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
<h4 class="text-lg font-bold text-slate-900 mb-2">What is the typical transit time for ocean freight?</h4>
<p class="text-slate-600">
Depending on the route, ocean transit typically takes between 20 to 45 days. We provide precise schedules for all major trade lanes.
</p>
</div>
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
<h4 class="text-lg font-bold text-slate-900 mb-2">Do you handle oversized cargo?</h4>
<p class="text-slate-600">
Yes, we specialize in breakbulk and RoRo services for machinery, vehicles, and industrial equipment that exceed standard container sizes.
</p>
</div>
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
<h4 class="text-lg font-bold text-slate-900 mb-2">What is LCL and is it right for me?</h4>
<p class="text-slate-600">
LCL (Less-than-Container Load) is for shipments that don't require a full container. It's the most cost-effective option for smaller volumes.
</p>
</div>
<div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
<h4 class="text-lg font-bold text-slate-900 mb-2">Can I track my container across the ocean?</h4>
<p class="text-slate-600">
Yes, we provide vessel tracking and container status updates via our digital portal, giving you visibility from port to port.
</p>
</div>
</div>
</div>
</section>

<!-- HOW IT WORKS -->
<section class="py-24 px-4 max-w-6xl mx-auto">
<div class="text-center mb-16">
<p class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-3">
The Voyage
</p>
<h2 class="text-4xl font-bold text-slate-900">How It Works</h2>
</div>
<div class="grid sm:grid-cols-2 md:grid-cols-4 gap-12">
<div class="text-center group">
<div class="w-20 h-20 rounded-3xl bg-blue-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">
1
</div>
<h4 class="font-bold text-slate-900 mb-2">Cargo Booking</h4>
<p class="text-sm text-slate-500">
Reserve space on the next available vessel via our portal.
</p>
</div>
<div class="text-center group">
<div class="w-20 h-20 rounded-3xl bg-blue-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">
2
</div>
<h4 class="font-bold text-slate-900 mb-2">Port Delivery</h4>
<p class="text-sm text-slate-500">
Your cargo is delivered to the port and loaded onto the vessel.
</p>
</div>
<div class="text-center group">
<div class="w-20 h-20 rounded-3xl bg-blue-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">
3
</div>
<h4 class="font-bold text-slate-900 mb-2">Ocean Transit</h4>
<p class="text-sm text-slate-500">
Global transport via shipping lines with live vessel tracking.
</p>
</div>
<div class="text-center group">
<div class="w-20 h-20 rounded-3xl bg-blue-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">
4
</div>
<h4 class="font-bold text-slate-900 mb-2">Port Clearance</h4>
<p class="text-sm text-slate-500">
Unloading and customs clearance at the destination port.
</p>
</div>
</div>
</section>

<!-- OTHER SERVICES -->
<section class="bg-slate-50 py-24 px-4">
<div class="max-w-6xl mx-auto">
<div class="text-center mb-16">
<p class="text-sm font-bold uppercase tracking-widest text-blue-600 mb-3">
Explore More
</p>
<h2 class="text-4xl font-bold text-slate-900">Our Other Services</h2>
</div>
<div class="grid sm:grid-cols-2 gap-8">
<a href="/services/1" class="group flex items-center gap-6 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all">
<div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors">
<svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
</svg>
</div>
<div class="flex-1">
<h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition">Air Freight</h3>
<p class="text-slate-500 mt-1">
Ultra-fast international shipping for time-critical cargo.
</p>
</div>
<svg class="w-6 h-6 text-slate-300 group-hover:text-blue-500 ml-auto transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
</svg>
</a>
<a href="/services/2" class="group flex items-center gap-6 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:border-blue-300 transition-all">
<div class="w-16 h-16 bg-blue-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-blue-600 transition-colors">
<svg class="w-8 h-8 text-blue-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4zM1 1h2l2.68 13.39a2 2 0 001.97 1.61H17a2 2 0 001.95-1.55L21 7H6" />
</svg>
</div>
<div class="flex-1">
<h3 class="text-xl font-bold text-slate-900 group-hover:text-blue-600 transition">Road Transportation</h3>
<p class="text-slate-500 mt-1">
Reliable ground freight for local and regional deliveries.
</p>
</div>
<svg class="w-6 h-6 text-slate-300 group-hover:text-blue-500 ml-auto transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
</svg>
</a>
</div>
</div>
</section>

<!-- CTA -->
<section class="bg-blue-600 py-24 px-4 text-white text-center relative overflow-hidden">
<div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
<svg width="100%" height="100%"><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" /></pattern><rect width="100%" height="100%" fill="url(#grid)" /></svg>
</div>
<div class="max-w-3xl mx-auto relative z-10">
<h2 class="text-4xl md:text-5xl font-black mb-6">Ready for global shipping?</h2>
<p class="text-xl text-blue-100 mb-10 leading-relaxed">
Join the elite network of businesses moving cargo globally with confidence. Cost-effective, secure, and scalable.
</p>
<div class="flex flex-col sm:flex-row gap-4 justify-center">
<a href="#" class="bg-white text-blue-600 font-bold px-10 py-4 rounded-xl hover:bg-blue-50 transition shadow-xl">
Get a Free Quote
</a>
<a href="/contactUs" class="bg-blue-700 text-white font-bold px-10 py-4 rounded-xl hover:bg-blue-800 transition border border-blue-400/30">
Contact an Expert
</a>
</div>
</div>
</section>

</div>