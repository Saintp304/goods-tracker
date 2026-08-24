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
  <section class="relative h-[70vh] flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
      style="background-image: url('https://images.unsplash.com/photo-1569154941061-e2779179689a?auto=format&fit=crop&w=1920&q=80');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/70 to-indigo-900/60"></div>
    <div class="relative text-center px-4 max-w-4xl mx-auto">
      <p class="text-sm font-semibold uppercase tracking-widest text-indigo-400 mb-4">
        Global Logistics Solutions
      </p>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">Air Freight <span class="text-indigo-400">Redefined</span></h1>
      <p class="mt-4 text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
        Experience the pinnacle of speed and reliability. We connect your business to every corner of the globe with precision air cargo solutions.
      </p>
      <div class="mt-10 flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#" class="bg-indigo-500 hover:bg-indigo-600 text-white font-bold px-8 py-4 rounded-xl transition shadow-lg shadow-indigo-500/30">
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
        <p class="text-4xl font-black text-indigo-400 mb-1">180+</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">Countries Reached</p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-indigo-400 mb-1">24hr</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">Avg. Transit Time</p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-indigo-400 mb-1">99.6%</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">On-Time Delivery</p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-indigo-400 mb-1">50K+</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">Annual Shipments</p>
      </div>
    </div>
  </div>

  <!-- WHY AIR FREIGHT -->
  <section class="py-24 px-4 max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <div class="absolute -top-4 -left-4 w-24 h-24 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white">
          <img src="https://images.unsplash.com/photo-1436491865332-7a61a109c0f3?auto=format&fit=crop&w=800&q=80" alt="Air Freight Logistics" class="w-full h-full object-cover" />
        </div>
      </div>
      <div>
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-4">The Ultimate Speed</p>
        <h2 class="text-4xl font-bold text-slate-900 leading-tight mb-6">Move Your Cargo at the Speed of Thought</h2>
        <p class="text-lg text-slate-600 leading-relaxed mb-8">
          When time is your most valuable asset, air freight is the only choice. We bridge the gap between continents in hours, not weeks, ensuring your supply chain remains agile and responsive.
        </p>
        <div class="grid sm:grid-cols-2 gap-6">
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Express International Shipping</span>
          </div>
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Real-time GPS Tracking</span>
          </div>
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Priority Customs Handling</span>
          </div>
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Full Cargo Insurance</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CAPABILITIES (THE BULK) -->
  <section class="bg-slate-50 py-24 px-4">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-16">
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">Specialized Solutions</p>
        <h2 class="text-4xl font-bold text-slate-900 mb-4">Our Air Cargo Capabilities</h2>
        <p class="text-slate-600 max-w-2xl mx-auto">From temperature-sensitive pharmaceuticals to oversized machinery, we have the expertise to handle any cargo requirement.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Cap 1 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1580674285054-755f97706643?auto=format&fit=crop&w=400&q=80" alt="Express Shipping" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Express Shipping</h3>
            <p class="text-slate-600 leading-relaxed">
              Ultra-fast transit for time-critical shipments. We utilize next-flight-out (NFO) services to ensure your goods arrive within 24-48 hours globally.
            </p>
          </div>
        </div>
        <!-- Cap 2 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8de9c27d6c?auto=format&fit=crop&w=400&q=80" alt="Perishable Cargo" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Perishable Cargo</h3>
            <p class="text-slate-600 leading-relaxed">
              Cold-chain logistics for food, flowers, and pharmaceuticals. Strict temperature control and priority boarding for maximum freshness.
            </p>
          </div>
        </div>
        <!-- Cap 3 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1530587191325-37a775796d63?auto=format&fit=crop&w=400&q=80" alt="Dangerous Goods" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Dangerous Goods</h3>
            <p class="text-slate-600 leading-relaxed">
              Certified handling of hazardous materials. We ensure full IATA compliance, professional packaging, and specialized safety protocols.
            </p>
          </div>
        </div>
        <!-- Cap 4 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1544016665-6760556971c6?auto=format&fit=crop&w=400&q=80" alt="Charter Flights" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Charter Flights</h3>
            <p class="text-slate-600 leading-relaxed">
              Dedicated aircraft for oversized cargo or urgent bulk shipments. Complete control over scheduling and routing for maximum efficiency.
            </p>
          </div>
        </div>
        <!-- Cap 5 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1566577739647-667977162ec8?auto=format&fit=crop&w=400&q=80" alt="Customs Clearance" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Customs Clearance</h3>
            <p class="text-slate-600 leading-relaxed">
              Seamless import/export documentation. Our in-house brokers handle all tariffs and compliance to prevent costly delays.
            </p>
          </div>
        </div>
        <!-- Cap 6 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8de9c27d6c?auto=format&fit=crop&w=400&q=80" alt="Airport-to-Door" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Airport-to-Door</h3>
            <p class="text-slate-600 leading-relaxed">
              Integrated last-mile delivery. We don't just fly your cargo; we ensure it reaches the final destination with precision.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="py-24 px-4 max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">The Edge</p>
      <h2 class="text-4xl font-bold text-slate-900">Why We Outperform</h2>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
      <div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-3">Global Network</h3>
        <p class="text-slate-600 leading-relaxed">
          Partnerships with every major airline worldwide, providing redundant routes and guaranteed space even during peak seasons.
        </p>
      </div>
      <div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-3">Rapid Transit</h3>
        <p class="text-slate-600 leading-relaxed">
          Optimized routing algorithms that minimize layovers and maximize speed, reducing total transit time by up to 20%.
        </p>
      </div>
      <div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-3">Maximum Security</h3>
        <p class="text-slate-600 leading-relaxed">
          Military-grade handling for high-value cargo, including tamper-evident seals and constant surveillance.
        </p>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="bg-slate-50 py-24 px-4">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-16">
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">Questions?</p>
        <h2 class="text-4xl font-bold text-slate-900">Air Freight FAQ</h2>
      </div>
      <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">What is the average transit time for international air freight?</h4>
          <p class="text-slate-600">Typically, shipments arrive within 3 to 7 business days, depending on the destination and chosen service level (Express vs Standard).</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">Do you handle dangerous goods (DG)?</h4>
          <p class="text-slate-600">Yes, we are fully certified to handle and transport dangerous goods in compliance with IATA regulations. All DG shipments require specific documentation.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">Is insurance included in the quote?</h4>
          <p class="text-slate-600">Standard carrier liability is included, but we strongly recommend our comprehensive cargo insurance for high-value items.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">Can I track my air shipment in real-time?</h4>
          <p class="text-slate-600">Absolutely. You will receive a unique tracking ID that provides milestone updates from pickup, through customs, to final delivery.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="py-24 px-4 max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">Seamless Process</p>
      <h2 class="text-4xl font-bold text-slate-900">How It Works</h2>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-12">
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">1</div>
        <h4 class="font-bold text-slate-900 mb-2">Book Online</h4>
        <p class="text-sm text-slate-500">Submit details via our platform and get an instant, transparent quote.</p>
      </div>
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">2</div>
        <h4 class="font-bold text-slate-900 mb-2">Secure Pickup</h4>
        <p class="text-sm text-slate-500">Our team collects your cargo and prepares it for air transit.</p>
      </div>
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">3</div>
        <h4 class="font-bold text-slate-900 mb-2">Global Transit</h4>
        <p class="text-sm text-slate-500">Your shipment flies via partner carriers with real-time tracking.</p>
      </div>
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">4</div>
        <h4 class="font-bold text-slate-900 mb-2">Final Delivery</h4>
        <p class="text-sm text-slate-500">Last-mile delivery with proof of delivery and instant notification.</p>
      </div>
    </div>
  </section>

  <!-- OTHER SERVICES -->
  <section class="bg-slate-50 py-24 px-4">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-16">
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">Explore More</p>
        <h2 class="text-4xl font-bold text-slate-900">Our Other Services</h2>
      </div>
      <div class="grid sm:grid-cols-2 gap-8">
        <a href="/services/3" class="group flex items-center gap-6 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:border-indigo-300 transition-all">
          <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 transition-colors">
            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
            </svg>
          </div>
          <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition">Sea Freight</h3>
            <p class="text-slate-500 mt-1">Cost-effective ocean shipping for large or heavy cargo.</p>
          </div>
          <svg class="w-6 h-6 text-slate-300 group-hover:text-indigo-500 ml-auto transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
        <a href="/services/2" class="group flex items-center gap-6 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:border-indigo-300 transition-all">
          <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 transition-colors">
            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4zM1 1h2l2.68 13.39a2 2 0 001.97 1.61H17a2 2 0 001.95-1.55L21 7H6" />
            </svg>
          </div>
          <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition">Road Transportation</h3>
            <p class="text-slate-500 mt-1">Reliable ground freight for local and regional deliveries.</p>
          </div>
          <svg class="w-6 h-6 text-slate-300 group-hover:text-indigo-500 ml-auto transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="bg-indigo-600 py-24 px-4 text-white text-center relative overflow-hidden">
    <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none">
       <svg width="100%" height="100%"><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/></pattern><rect width="100%" height="100%" fill="url(#grid)" /></svg>
    </div>
    <div class="max-w-3xl mx-auto relative z-10">
      <h2 class="text-4xl md:text-5xl font-black mb-6">Ready to scale your logistics?</h2>
      <p class="text-xl text-indigo-100 mb-10 leading-relaxed">
        Join thousands of businesses that trust our air freight network for their most critical shipments. Fast, transparent, and globally connected.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#" class="bg-white text-indigo-600 font-bold px-10 py-4 rounded-xl hover:bg-indigo-50 transition shadow-xl">
          Get a Free Quote
        </a>
        <a href="#" class="bg-indigo-700 text-white font-bold px-10 py-4 rounded-xl hover:bg-indigo-800 transition border border-indigo-400/30">
          Contact an Expert
        </a>
      </div>
    </div>
  </section>

</div>