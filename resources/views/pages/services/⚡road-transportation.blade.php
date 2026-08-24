<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Road Transportation')] class extends Component
{
  //
};
?>

<div class="min-h-screen bg-white">

  <!-- HERO -->
  <section class="relative min-h-[92vh] md:min-h-[700px] pt-20 pb-10 flex items-center justify-center text-white overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
      style="background-image: url('https://images.unsplash.com/photo-1519003722875-7736bb275c6d?auto=format&fit=crop&w=1920&q=80');"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-950/90 via-slate-900/70 to-indigo-900/60"></div>
    <div class="relative text-center px-4 max-w-4xl mx-auto">
      <p class="text-sm font-semibold uppercase tracking-widest text-indigo-400 mb-4">
        Ground Logistics Solutions
      </p>
      <h1 class="text-5xl md:text-7xl font-extrabold leading-tight mb-6">Road Transport <span class="text-indigo-400">Optimized</span></h1>
      <p class="mt-4 text-xl text-slate-300 max-w-2xl mx-auto leading-relaxed">
        Reliable, secure, and lightning-fast ground freight. From last-mile delivery to regional haulage, we keep your business moving.
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
        <p class="text-4xl font-black text-indigo-400 mb-1">1,200+</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">Modern Vehicles</p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-indigo-400 mb-1">24hr</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">Local Delivery</p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-indigo-400 mb-1">98.5%</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">On-Time Rate</p>
      </div>
      <div class="text-center">
        <p class="text-4xl font-black text-indigo-400 mb-1">50+</p>
        <p class="text-sm uppercase tracking-wide text-slate-400">Cities Covered</p>
      </div>
    </div>
  </div>

  <!-- WHY ROAD TRANSPORT -->
  <section class="py-24 px-4 max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-16 items-center">
      <div class="relative">
        <div class="absolute -top-4 -left-4 w-24 h-24 bg-indigo-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
        <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
        <div class="relative rounded-3xl overflow-hidden shadow-2xl border-8 border-white">
          <img src="https://images.unsplash.com/photo-1586528116311-ad8de9c27d6c?auto=format&fit=crop&w=800&q=80" alt="Road Transport Logistics" class="w-full h-full object-cover" />
        </div>
      </div>
      <div>
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-4">The Backbone of Commerce</p>
        <h2 class="text-4xl font-bold text-slate-900 leading-tight mb-6">Precision Ground Logistics for Every Scale</h2>
        <p class="text-lg text-slate-600 leading-relaxed mb-8">
          Our road network is the vital link between your warehouse and your customer. We combine cutting-edge GPS routing with an experienced driver fleet to ensure every shipment is secure and on time.
        </p>
        <div class="grid sm:grid-cols-2 gap-6">
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Door-to-Door Service</span>
          </div>
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Diverse Fleet Options</span>
          </div>
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Real-time GPS Tracking</span>
          </div>
          <div class="flex items-start gap-3">
            <span class="mt-1 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-600 text-white flex items-center justify-center text-xs font-bold">✓</span>
            <span class="text-slate-700 font-medium">Secure Handling Protocols</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CAPABILITIES (THE BULK) -->
  <section class="bg-slate-50 py-24 px-4">
    <div class="max-w-6xl mx-auto">
      <div class="text-center mb-16">
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">Comprehensive Reach</p>
        <h2 class="text-4xl font-bold text-slate-900 mb-4">Our Road Logistics Capabilities</h2>
        <p class="text-slate-600 max-w-2xl mx-auto">From small parcels to massive industrial loads, our fleet is equipped to handle any challenge on the road.</p>
      </div>
      <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <!-- Cap 1 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1519003722875-7736bb275c6d?auto=format&fit=crop&w=400&q=80" alt="FTL Shipping" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Full Truckload (FTL)</h3>
            <p class="text-slate-600 leading-relaxed">
              Dedicated trucks for large shipments. Faster transit and reduced handling risks, ideal for bulk movements between hubs.
            </p>
          </div>
        </div>
        <!-- Cap 2 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8de9c27d6c?auto=format&fit=crop&w=400&q=80" alt="LTL Shipping" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Less-than-Truckload (LTL)</h3>
            <p class="text-slate-600 leading-relaxed">
              Cost-effective shipping for smaller loads. We consolidate shipments to reduce your costs while maintaining speed.
            </p>
          </div>
        </div>
        <!-- Cap 3 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1580674285054-755f97706643?auto=format&fit=crop&w=400&q=80" alt="Last Mile" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Last-Mile Delivery</h3>
            <p class="text-slate-600 leading-relaxed">
              The final, most critical leg of the journey. We ensure a professional and timely delivery directly to the end-customer.
            </p>
          </div>
        </div>
        <!-- Cap 4 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8de9c27d6c?auto=format&fit=crop&w=400&q=80" alt="Cold Chain" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Cold Chain Logistics</h3>
            <p class="text-slate-600 leading-relaxed">
              Temperature-controlled transport for perishables and medical supplies. Constant monitoring to ensure cargo integrity.
            </p>
          </div>
        </div>
        <!-- Cap 5 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1519003722875-7736bb275c6d?auto=format&fit=crop&w=400&q=80" alt="Regional Distribution" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Regional Distribution</h3>
            <p class="text-slate-600 leading-relaxed">
              Strategic routing across the country, connecting major cities and rural areas with optimized transit schedules.
            </p>
          </div>
        </div>
        <!-- Cap 6 -->
        <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all group border border-slate-200">
          <div class="h-48 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1586528116311-ad8de9c27d6c?auto=format&fit=crop&w=400&q=80" alt="Secure Haulage" class="w-full h-full object-cover group-hover:scale-110 transition duration-500" />
          </div>
          <div class="p-8">
            <h3 class="text-xl font-bold text-slate-900 mb-3">Secure Haulage</h3>
            <p class="text-slate-600 leading-relaxed">
              High-security transport for valuable goods, including escort services and advanced tracking for maximum safety.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FEATURES -->
  <section class="py-24 px-4 max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">The Advantage</p>
      <h2 class="text-4xl font-bold text-slate-900">Ground Logistics Excellence</h2>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-8">
      <div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-3">Regional Hubs</h3>
        <p class="text-slate-600 leading-relaxed">
          Strategic locations across the country ensure faster transit and optimized routing for every single shipment.
        </p>
      </div>
      <div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-3">Express Dispatch</h3>
        <p class="text-slate-600 leading-relaxed">
          Priority shipping options for urgent deliveries with guaranteed arrival times and dedicated courier slots.
        </p>
      </div>
      <div class="p-8 rounded-3xl border border-slate-100 bg-white shadow-sm hover:shadow-md transition">
        <div class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center mb-6">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
          </svg>
        </div>
        <h3 class="text-xl font-bold text-slate-900 mb-3">Secure Transport</h3>
        <p class="text-slate-600 leading-relaxed">
          Full cargo insurance and specialized handling for fragile or high-value items, ensuring total peace of mind.
        </p>
      </div>
    </div>
  </section>

  <!-- FAQ -->
  <section class="bg-slate-50 py-24 px-4">
    <div class="max-w-4xl mx-auto">
      <div class="text-center mb-16">
        <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">Common Questions</p>
        <h2 class="text-4xl font-bold text-slate-900">Road Freight FAQ</h2>
      </div>
      <div class="space-y-6">
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">What is the difference between FTL and LTL?</h4>
          <p class="text-slate-600">FTL (Full Truckload) means your cargo takes up the entire truck, while LTL (Less-than-Truckload) means your cargo shares space with other shipments, reducing costs.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">Do you provide refrigerated transport?</h4>
          <p class="text-slate-600">Yes, we offer a specialized Cold Chain fleet for temperature-sensitive goods like food and medicine.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">How do I track my ground shipment?</h4>
          <p class="text-slate-600">Every shipment is equipped with real-time GPS tracking. You can monitor your cargo's precise location through our client portal.</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
          <h4 class="text-lg font-bold text-slate-900 mb-2">What areas do you cover?</h4>
          <p class="text-slate-600">We provide comprehensive coverage across all major regional hubs and offer last-mile delivery to almost any address in the country.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- HOW IT WORKS -->
  <section class="py-24 px-4 max-w-6xl mx-auto">
    <div class="text-center mb-16">
      <p class="text-sm font-bold uppercase tracking-widest text-indigo-600 mb-3">Simple Workflow</p>
      <h2 class="text-4xl font-bold text-slate-900">How It Works</h2>
    </div>
    <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-12">
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">1</div>
        <h4 class="font-bold text-slate-900 mb-2">Book Pickup</h4>
        <p class="text-sm text-slate-500">Request a pickup via our system and get an instant quote.</p>
      </div>
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">2</div>
        <h4 class="font-bold text-slate-900 mb-2">Secure Collection</h4>
        <p class="text-sm text-slate-500">Our courier collects your shipment from the origin point.</p>
      </div>
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">3</div>
        <h4 class="font-bold text-slate-900 mb-2">Regional Transit</h4>
        <p class="text-sm text-slate-500">Goods move via our optimized road network to the destination.</p>
      </div>
      <div class="text-center group">
        <div class="w-20 h-20 rounded-3xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-black mx-auto mb-6 group-hover:rotate-6 transition">4</div>
        <h4 class="font-bold text-slate-900 mb-2">Final Delivery</h4>
        <p class="text-sm text-slate-500">Successful delivery to the receiver with instant notification.</p>
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
        <a href="/services/1" class="group flex items-center gap-6 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:border-indigo-300 transition-all">
          <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 transition-colors">
            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10" />
            </svg>
          </div>
          <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition">Air Freight</h3>
            <p class="text-slate-500 mt-1">Ultra-fast international shipping for time-critical cargo.</p>
          </div>
          <svg class="w-6 h-6 text-slate-300 group-hover:text-indigo-500 ml-auto transition" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
          </svg>
        </a>
        <a href="/services/3" class="group flex items-center gap-6 bg-white border border-slate-200 rounded-3xl p-8 shadow-sm hover:shadow-xl hover:border-indigo-300 transition-all">
          <div class="w-16 h-16 bg-indigo-100 rounded-2xl flex items-center justify-center flex-shrink-0 group-hover:bg-indigo-600 transition-colors">
            <svg class="w-8 h-8 text-indigo-600 group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M8 17a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4zM1 1h2l2.68 13.39a2 2 0 001.97 1.61H17a2 2 0 001.95-1.55L21 7H6" />
            </svg>
          </div>
          <div class="flex-1">
            <h3 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition">Sea Freight</h3>
            <p class="text-slate-500 mt-1">Cost-effective ocean shipping for heavy or bulk cargo.</p>
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
      <h2 class="text-4xl md:text-5xl font-black mb-6">Ready to move your cargo?</h2>
      <p class="text-xl text-indigo-100 mb-10 leading-relaxed">
        Get a free quote from our team today. Fast, transparent pricing with no hidden fees, and guaranteed reliability.
      </p>
      <div class="flex flex-col sm:flex-row gap-4 justify-center">
        <a href="#" class="bg-white text-indigo-600 font-bold px-10 py-4 rounded-xl hover:bg-indigo-50 transition shadow-xl">
          Get a Free Quote
        </a>
        <a href="/contactUs" class="bg-indigo-700 text-white font-bold px-10 py-4 rounded-xl hover:bg-indigo-800 transition border border-indigo-400/30">
          Contact an Expert
        </a>
      </div>
    </div>
  </section>

</div>