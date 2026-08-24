<?php

use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\SiteSetting;

new #[Layout('layouts.main')]
class extends Component {
    public string $whatsappNumber = '';

    public function mount(): void
    {
        $this->whatsappNumber = SiteSetting::current()->whatsapp_number ?? '';
    }
};
?>

<div class="bg-slate-50 antialiased" style="font-family: 'DM Sans', sans-serif;">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;0,9..40,800;1,9..40,400&family=Sora:wght@600;700;800&display=swap" rel="stylesheet">

  <style>
    .font-display { font-family: 'Sora', sans-serif; }
    .hero-text-shadow { text-shadow: 0 2px 24px rgba(0,0,0,0.35); }
    .card-shine { position: relative; overflow: hidden; }
    .card-shine::before {
      content: '';
      position: absolute;
      inset: 0;
      background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, transparent 60%);
      pointer-events: none;
      border-radius: inherit;
    }
    .stat-glow { box-shadow: 0 0 0 1px rgba(99,102,241,0.15), 0 4px 32px rgba(99,102,241,0.10); }
    .track-input:focus { box-shadow: 0 0 0 4px rgba(99,102,241,0.12); }
    .noise-overlay {
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='noise'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23noise)' opacity='0.04'/%3E%3C/svg%3E");
    }
    /* GSAP-driven reveal targets start hidden to avoid a flash-of-visible-content before JS runs */
    .gsap-feature-card,
    .gsap-step-card,
    .gsap-stat-card,
    .gsap-metric-card,
    .gsap-testimonial,
    .gsap-cta-content {
      opacity: 0;
    }

  </style>

  <!-- ===================== HERO ===================== -->
  <section id="hero" class="relative min-h-[92vh] md:min-h-[700px] flex flex-col justify-center pt-20 pb-10 text-white overflow-hidden">
    <div class="absolute inset-0">
      <div id="hero-bg-1" class="absolute inset-0 bg-cover bg-center transition-opacity duration-[2000ms] opacity-100 scale-105"></div>
      <div id="hero-bg-2" class="absolute inset-0 bg-cover bg-center transition-opacity duration-[2000ms] opacity-0 scale-105"></div>
      <div class="absolute inset-0 bg-gradient-to-b from-indigo-950/80 via-indigo-900/65 to-indigo-950/80"></div>
      <div class="noise-overlay absolute inset-0 pointer-events-none"></div>
    </div>

    <div class="absolute top-20 right-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>

    <div id="hero-content" class="relative max-w-6xl mx-auto px-5 sm:px-8 lg:px-10 w-full">
      <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full px-4 py-1.5 text-sm font-medium mb-6 motion-opacity-in-0 motion-translate-y-in-100 motion-duration-700">
        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
        Live Tracking — Updated Every Minute
      </div>

      <h1 class="font-display text-5xl sm:text-6xl lg:text-7xl xl:text-[82px] font-extrabold hero-text-shadow leading-[1.05] max-w-4xl motion-opacity-in-0 motion-translate-y-in-150 motion-blur-in-lg motion-duration-1000">
        Track Any Shipment,<br>
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-300 via-blue-200 to-indigo-400">
          Anywhere, Anytime.
        </span>
      </h1>

      <p class="mt-6 text-lg sm:text-xl text-white/80 max-w-2xl leading-relaxed motion-opacity-in-0 motion-translate-x-in-100 motion-duration-1000 motion-delay-200">
        Real-time visibility for goods, cargo & parcels — trusted by businesses and individuals worldwide.
      </p>

      <div class="mt-10 max-w-3xl motion-opacity-in-0 motion-translate-y-in-100 motion-duration-1000 motion-delay-300">
        <form action="{{ route('track') }}" method="GET"
          class="flex flex-col sm:flex-row gap-3 bg-white/10 backdrop-blur-lg p-2.5 rounded-2xl border border-white/20 shadow-2xl">
          <input
            type="text"
            name="trackingNumber"
            placeholder="Enter tracking number — e.g. TG-987654321-GL"
            class="track-input flex-1 px-6 py-4 placeholder-white text-white text-base rounded-xl bg-white/10 border border-white/15 focus:border-indigo-300 focus:bg-white/15 outline-none transition"
            required
          />
          <button type="submit"
            class="bg-indigo-500 hover:bg-indigo-400 text-white px-8 py-4 text-base font-semibold rounded-xl transition shadow-lg flex items-center justify-center gap-2 sm:min-w-[170px] whitespace-nowrap">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
            Track Now
          </button>
        </form>
        <p class="mt-3 text-xs text-white/45 pl-1">No account needed for basic tracking. Supports 2,400+ carriers.</p>
      </div>

      <div class="mt-14 flex flex-wrap gap-6 sm:gap-10">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div>
            <p class="text-xl font-bold font-display">99.9%</p>
            <p class="text-xs text-white/55">Accuracy</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
          </div>
          <div>
            <p class="text-xl font-bold font-display">2,400+</p>
            <p class="text-xs text-white/55">Carriers</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <div>
            <p class="text-xl font-bold font-display">24/7</p>
            <p class="text-xs text-white/55">Live Support</p>
          </div>
        </div>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
          </div>
          <div>
            <p class="text-xl font-bold font-display">160+</p>
            <p class="text-xs text-white/55">Countries</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== TRUST BAND ===================== -->
  <section class="py-12 bg-white border-y border-slate-100 overflow-hidden">
    <p class="text-center text-xs font-semibold uppercase tracking-wider text-gray-400 mb-6">Trusted partners & carriers worldwide</p>
    <div class="relative w-full overflow-hidden">
      <div class="trust-track flex w-max">
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">DHL</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">Maersk</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">FedEx</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">UPS</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">CMA CGM</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">Kuehne+Nagel</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">DHL</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">Maersk</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">FedEx</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">UPS</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">CMA CGM</span></div>
        <div class="shrink-0 px-8 flex items-center"><span class="text-xl font-display font-bold text-gray-400 whitespace-nowrap">Kuehne+Nagel</span></div>
      </div>
    </div>
  </section>
  <!-- ===================== FEATURES ===================== -->
  <section id="features" class="py-24 sm:py-32 bg-white">
    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10">
      <div class="text-center max-w-3xl mx-auto">
        <p class="text-indigo-600 font-semibold text-sm uppercase tracking-widest mb-4">Why TrackGoods</p>
        <h2 class="font-display text-4xl sm:text-5xl font-extrabold text-gray-900 leading-tight">Built for Reliability.<br>Designed for Speed.</h2>
        <p class="mt-5 text-lg text-gray-500 leading-relaxed">
          Enterprise-grade tracking made simple — built for the modern supply chain.
        </p>
      </div>

      <div class="mt-16 grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="gsap-feature-card group bg-white border border-gray-100 p-9 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">
          <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition duration-300">
            <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 font-display">Real-Time GPS & Status</h3>
          <p class="mt-3 text-gray-500 text-[15px] leading-relaxed">Live location pins, instant alerts, and detailed milestone updates — refreshed every few minutes.</p>
        </div>
        <div class="gsap-feature-card group bg-white border border-gray-100 p-9 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300">
          <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition duration-300">
            <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 font-display">Lightning-Fast & Secure</h3>
          <p class="mt-3 text-gray-500 text-[15px] leading-relaxed">Laravel-powered backend — blazing performance, end-to-end encryption, scalable for high volume.</p>
        </div>
        <div class="gsap-feature-card group bg-white border border-gray-100 p-9 rounded-3xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 sm:col-span-2 lg:col-span-1">
          <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:border-indigo-600 transition duration-300">
            <svg class="w-7 h-7 text-indigo-600 group-hover:text-white transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM6 5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          </div>
          <h3 class="text-xl font-bold text-gray-900 font-display">Business & Personal Tools</h3>
          <p class="mt-3 text-gray-500 text-[15px] leading-relaxed">Dashboard analytics, notifications, multi-parcel management — perfect for SMEs and individuals.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== SERVICES SHOWCASE ===================== -->
  <section id="services" class="py-24 sm:py-32 bg-slate-50">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">
      <div class="text-center mb-14">
        <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">What we move, and how</span>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mt-3">Freight, your way</h2>
      </div>
      <div class="grid md:grid-cols-3 gap-6">

        <a href="{{ route('airFreight') }}" class="gsap-service-card group relative rounded-3xl overflow-hidden h-96 block">
          <img src="https://picsum.photos/seed/airfreight/600/800" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="Air freight" loading="lazy">
          <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/90 via-indigo-950/30 to-transparent"></div>
          <div class="absolute bottom-0 left-0 right-0 p-7">
            <span class="text-indigo-300 font-semibold text-xs uppercase tracking-wider">Fastest</span>
            <h3 class="font-display text-2xl font-bold text-white mt-2 mb-2">Air Freight</h3>
            <p class="text-indigo-100/80 text-sm leading-relaxed">Time-sensitive shipments delivered across continents in days, not weeks.</p>
          </div>
        </a>

        <a href="{{ route('roadTransport') }}" class="gsap-service-card group relative rounded-3xl overflow-hidden h-96 block">
          <img src="https://picsum.photos/seed/roadfreight/600/800" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="Road freight" loading="lazy">
          <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/90 via-indigo-950/30 to-transparent"></div>
          <div class="absolute bottom-0 left-0 right-0 p-7">
            <span class="text-indigo-300 font-semibold text-xs uppercase tracking-wider">Most flexible</span>
            <h3 class="font-display text-2xl font-bold text-white mt-2 mb-2">Road Freight</h3>
            <p class="text-indigo-100/80 text-sm leading-relaxed">Door-to-door delivery with live GPS tracking on every leg of the route.</p>
          </div>
        </a>

        <a href="{{ route('seaFreight') }}" class="gsap-service-card group relative rounded-3xl overflow-hidden h-96 block">
          <img src="https://picsum.photos/seed/seafreight/600/800" class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-700" alt="Sea freight" loading="lazy">
          <div class="absolute inset-0 bg-gradient-to-t from-indigo-950/90 via-indigo-950/30 to-transparent"></div>
          <div class="absolute bottom-0 left-0 right-0 p-7">
            <span class="text-indigo-300 font-semibold text-xs uppercase tracking-wider">Best value</span>
            <h3 class="font-display text-2xl font-bold text-white mt-2 mb-2">Sea Freight</h3>
            <p class="text-indigo-100/80 text-sm leading-relaxed">Bulk and container shipping tracked from port to port, worldwide.</p>
          </div>
        </a>

      </div>
    </div>
  </section>
  <!-- ===================== HOW IT WORKS (pinned scrollytelling) ===================== -->
  <section id="how" class="py-24 sm:py-32 bg-slate-50 relative">
    <div class="max-w-6xl mx-auto px-5 sm:px-8 lg:px-10">
      <div class="text-center max-w-2xl mx-auto">
        <p class="text-indigo-600 font-semibold text-sm uppercase tracking-widest mb-4">Simple Process</p>
        <h2 class="font-display text-4xl sm:text-5xl font-extrabold text-gray-900">Track in 3 Steps</h2>
        <p class="mt-4 text-lg text-gray-500">Full visibility without the complexity.</p>
      </div>

      <div class="mt-16 relative">
        <div class="hidden md:block absolute top-10 left-[22%] right-[22%] h-px bg-gradient-to-r from-indigo-200 via-indigo-400 to-indigo-200"></div>

        <div class="grid md:grid-cols-3 gap-10">
          <div class="gsap-step-card bg-white p-9 rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 text-center transition duration-300">
            <div class="mx-auto w-20 h-20 bg-gradient-to-br from-indigo-600 to-indigo-500 text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold shadow-lg font-display mb-6">1</div>
            <h3 class="text-xl font-bold font-display text-gray-900">Enter Number</h3>
            <p class="mt-3 text-gray-500 text-[15px] leading-relaxed">Input your tracking ID — instant lookup, no account needed for basics.</p>
          </div>
          <div class="gsap-step-card bg-white p-9 rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 text-center transition duration-300">
            <div class="mx-auto w-20 h-20 bg-gradient-to-br from-indigo-600 to-indigo-500 text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold shadow-lg font-display mb-6">2</div>
            <h3 class="text-xl font-bold font-display text-gray-900">View Live Map</h3>
            <p class="mt-3 text-gray-500 text-[15px] leading-relaxed">Interactive map, timeline, ETA and status — all in one clean view.</p>
          </div>
          <div class="gsap-step-card bg-white p-9 rounded-3xl border border-gray-100 shadow-sm hover:shadow-lg hover:border-indigo-200 text-center transition duration-300">
            <div class="mx-auto w-20 h-20 bg-gradient-to-br from-indigo-600 to-indigo-500 text-white rounded-2xl flex items-center justify-center text-3xl font-extrabold shadow-lg font-display mb-6">3</div>
            <h3 class="text-xl font-bold font-display text-gray-900">Stay Informed</h3>
            <p class="mt-3 text-gray-500 text-[15px] leading-relaxed">Email/SMS alerts, full history, analytics — upgrade for full control.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ===================== IMPACT & STATS ===================== -->
  <section id="impact" class="py-24 sm:py-32 bg-gradient-to-br from-indigo-950 via-indigo-800 to-indigo-900 text-white overflow-hidden relative">
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-indigo-400/30 to-transparent"></div>
    <div class="impact-orb absolute -top-20 left-1/2 -translate-x-1/2 w-[500px] h-[500px] bg-indigo-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-5 sm:px-8 lg:px-10 relative">
      <div class="text-center mb-16">
        <p class="text-indigo-300 font-semibold text-sm uppercase tracking-widest mb-4">Our Impact</p>
        <h2 class="font-display text-4xl sm:text-5xl font-extrabold leading-tight">
          Numbers That Speak<br class="hidden sm:block"> for Themselves
        </h2>
        <p class="mt-5 text-lg text-white/65 max-w-2xl mx-auto">
          Powering reliable real-time goods tracking — delivering precision, speed, and trust worldwide.
        </p>
      </div>

      <div class="grid grid-cols-2 md:grid-cols-4 gap-5 sm:gap-6">
        <div class="gsap-stat-card card-shine stat-glow bg-white/8 backdrop-blur-lg rounded-2xl p-6 sm:p-8 text-center border border-indigo-400/15 hover:border-indigo-400/30 hover:bg-white/12 transition-all duration-300"
          x-data="{ count: 0, showPlus: false }">
          <div class="mx-auto w-11 h-11 bg-indigo-600/40 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
          </div>
          <div class="flex items-end justify-center gap-0.5">
            <p class="font-display text-3xl sm:text-4xl font-extrabold leading-none"
              x-init="$nextTick(()=>{const o=new IntersectionObserver((e)=>{if(e[0].isIntersecting){gsap.to({val:0},{val:101273,duration:2.5,ease:'power2.out',onUpdate:function(){count=Math.round(this.targets()[0].val);},onStart:()=>{showPlus=true}});o.disconnect();}},{threshold:0,rootMargin:'0px 0px -50px 0px'});o.observe($el);})"
              x-text="count.toLocaleString()">0</p>
            <span x-show="showPlus" x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="text-xl sm:text-2xl font-bold text-indigo-300 pb-0.5">+</span>
          </div>
          <p class="mt-2 text-sm sm:text-base text-white/65 font-medium">Packages Tracked</p>
        </div>

        <div class="gsap-stat-card card-shine stat-glow bg-white/8 backdrop-blur-lg rounded-2xl p-6 sm:p-8 text-center border border-indigo-400/15 hover:border-indigo-400/30 hover:bg-white/12 transition-all duration-300"
          x-data="{ count: 0, showPlus: false }">
          <div class="mx-auto w-11 h-11 bg-indigo-600/40 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
          </div>
          <div class="flex items-end justify-center gap-0.5">
            <p class="font-display text-3xl sm:text-4xl font-extrabold leading-none"
              x-init="$nextTick(()=>{const o=new IntersectionObserver((e)=>{if(e[0].isIntersecting){gsap.to({val:0},{val:673754,duration:2.5,ease:'power2.out',onUpdate:function(){count=Math.round(this.targets()[0].val);},onStart:()=>{showPlus=true}});o.disconnect();}},{threshold:0,rootMargin:'0px 0px -50px 0px'});o.observe($el);})"
              x-text="count.toLocaleString()">0</p>
            <span x-show="showPlus" x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="text-xl sm:text-2xl font-bold text-indigo-300 pb-0.5">+</span>
          </div>
          <p class="mt-2 text-sm sm:text-base text-white/65 font-medium">KM Covered Yearly</p>
        </div>

        <div class="gsap-stat-card card-shine stat-glow bg-white/8 backdrop-blur-lg rounded-2xl p-6 sm:p-8 text-center border border-indigo-400/15 hover:border-indigo-400/30 hover:bg-white/12 transition-all duration-300"
          x-data="{ count: 0, showPlus: false }">
          <div class="mx-auto w-11 h-11 bg-indigo-600/40 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM6 5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
          </div>
          <div class="flex items-end justify-center gap-0.5">
            <p class="font-display text-3xl sm:text-4xl font-extrabold leading-none"
              x-init="$nextTick(()=>{const o=new IntersectionObserver((e)=>{if(e[0].isIntersecting){gsap.to({val:0},{val:16714,duration:2.5,ease:'power2.out',onUpdate:function(){count=Math.round(this.targets()[0].val);},onStart:()=>{showPlus=true}});o.disconnect();}},{threshold:0,rootMargin:'0px 0px -50px 0px'});o.observe($el);})"
              x-text="count.toLocaleString()">0</p>
            <span x-show="showPlus" x-transition:enter="transition duration-500 ease-out" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="text-xl sm:text-2xl font-bold text-indigo-300 pb-0.5">+</span>
          </div>
          <p class="mt-2 text-sm sm:text-base text-white/65 font-medium">Satisfied Users</p>
        </div>

        <div class="gsap-stat-card card-shine stat-glow bg-white/8 backdrop-blur-lg rounded-2xl p-6 sm:p-8 text-center border border-indigo-400/15 hover:border-indigo-400/30 hover:bg-white/12 transition-all duration-300"
          x-data="{ count: 0, showPlus: false }">
          <div class="mx-auto w-11 h-11 bg-indigo-600/40 rounded-xl flex items-center justify-center mb-4">
            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064"/></svg>
          </div>
          <div class="flex items-end justify-center gap-0.5">
            <p class="font-display text-3xl sm:text-4xl font-extrabold leading-none"
              x-init="$nextTick(()=>{const o=new IntersectionObserver((e)=>{if(e[0].isIntersecting){gsap.to({val:0},{val:160,duration:2.5,ease:'power2.out',onUpdate:function(){count=Math.round(this.targets()[0].val);},onStart:()=>{showPlus=true}});o.disconnect();}},{threshold:0,rootMargin:'0px 0px -50px 0px'});o.observe($el);})"
              x-text="count.toLocaleString()">0</p>
            <span x-show="showPlus" x-transition:enter="transition duration-2000 ease-out" x-transition:enter-start="opacity-0 translate-x-2" x-transition:enter-end="opacity-100 translate-x-0" class="text-xl sm:text-2xl font-bold text-indigo-300 pb-0.5">+</span>
          </div>
          <p class="mt-2 text-sm sm:text-base text-white/65 font-medium">Countries Reached</p>
        </div>
      </div>

      <div class="mt-8 sm:mt-10 grid sm:grid-cols-3 gap-5 sm:gap-6">
        <div class="gsap-metric-card bg-white/5 rounded-2xl p-7 border border-indigo-400/10 hover:border-indigo-400/20 text-center transition duration-300">
          <p class="font-display text-4xl sm:text-5xl font-bold text-indigo-300 mb-3">99.8%</p>
          <h3 class="text-lg font-semibold mb-2">On-Time Performance</h3>
          <p class="text-sm text-white/55 leading-relaxed">Industry-leading accuracy in shipment status updates and delivery timelines.</p>
        </div>
        <div class="gsap-metric-card bg-white/5 rounded-2xl p-7 border border-indigo-400/10 hover:border-indigo-400/20 text-center transition duration-300">
          <p class="font-display text-4xl sm:text-5xl font-bold text-indigo-300 mb-3">Live</p>
          <h3 class="text-lg font-semibold mb-2">GPS Precision</h3>
          <p class="text-sm text-white/55 leading-relaxed">Minute-by-minute location tracking with reliable GPS for complete visibility.</p>
        </div>
        <div class="gsap-metric-card bg-white/5 rounded-2xl p-7 border border-indigo-400/10 hover:border-indigo-400/20 text-center transition duration-300">
          <p class="font-display text-4xl sm:text-5xl font-bold text-indigo-300 mb-3">4.9/5</p>
          <h3 class="text-lg font-semibold mb-2">User Satisfaction</h3>
          <p class="text-sm text-white/55 leading-relaxed">Exceptional ratings from thousands of users relying on TrackGoods daily.</p>
        </div>
      </div>

      <div class="mt-12 text-center">
        <a href="https://wa.me/{{ $whatsappNumber }}?text=Hello%20TrackGoods%2C%20I%20need%20help%20tracking%20my%20shipment" target="_blank"
          class="inline-flex items-center gap-3 bg-emerald-500 hover:bg-emerald-400 text-white px-7 py-4 rounded-full font-semibold text-base transition shadow-lg hover:shadow-xl">
          <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.198-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.297-.497.099-.198.05-.371-.025-.52-.074-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          Chat with Us on WhatsApp
        </a>
      </div>
    </div>
  </section>

  <!-- ===================== TESTIMONIALS GRID ===================== -->
  <section class="py-20 sm:py-24 bg-white">
    <div class="max-w-6xl mx-auto px-5 sm:px-8">
      <div class="text-center mb-14">
        <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">Trusted by businesses</span>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mt-3">What our customers say</h2>
      </div>
      <div class="grid sm:grid-cols-2 gap-6">

        <div class="gsap-testimonial-card bg-slate-50 rounded-3xl p-8 border border-slate-100">
          <div class="inline-flex gap-0.5 mb-4">@for ($i = 0; $i < 5; $i++)<svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor</div>
          <blockquote class="font-display text-lg font-semibold text-gray-900 leading-snug mb-6">"TrackGoods changed how we handle deliveries. Our customers love the real-time updates."</blockquote>
          <div class="flex items-center gap-3">
            <img src="https://picsum.photos/seed/customer1/100/100" class="w-11 h-11 rounded-full object-cover" alt="Logistics Manager" loading="lazy">
            <div class="text-left">
              <p class="text-sm font-semibold text-gray-800">Logistics Manager</p>
              <p class="text-sm text-gray-400">Verified Business Customer</p>
            </div>
          </div>
        </div>

        <div class="gsap-testimonial-card bg-slate-50 rounded-3xl p-8 border border-slate-100">
          <div class="inline-flex gap-0.5 mb-4">@for ($i = 0; $i < 5; $i++)<svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor</div>
          <blockquote class="font-display text-lg font-semibold text-gray-900 leading-snug mb-6">"Customs used to be our biggest headache. Now we get notified before it even becomes a problem."</blockquote>
          <div class="flex items-center gap-3">
            <img src="https://picsum.photos/seed/customer2/100/100" class="w-11 h-11 rounded-full object-cover" alt="Operations Lead" loading="lazy">
            <div class="text-left">
              <p class="text-sm font-semibold text-gray-800">Operations Lead</p>
              <p class="text-sm text-gray-400">Freight Forwarding Client</p>
            </div>
          </div>
        </div>

        <div class="gsap-testimonial-card bg-slate-50 rounded-3xl p-8 border border-slate-100">
          <div class="inline-flex gap-0.5 mb-4">@for ($i = 0; $i < 5; $i++)<svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor</div>
          <blockquote class="font-display text-lg font-semibold text-gray-900 leading-snug mb-6">"The dashboard alone saved us hours a week we used to spend chasing carriers for updates."</blockquote>
          <div class="flex items-center gap-3">
            <img src="https://picsum.photos/seed/customer3/100/100" class="w-11 h-11 rounded-full object-cover" alt="Warehouse Supervisor" loading="lazy">
            <div class="text-left">
              <p class="text-sm font-semibold text-gray-800">Warehouse Supervisor</p>
              <p class="text-sm text-gray-400">E-commerce Retailer</p>
            </div>
          </div>
        </div>

        <div class="gsap-testimonial-card bg-slate-50 rounded-3xl p-8 border border-slate-100">
          <div class="inline-flex gap-0.5 mb-4">@for ($i = 0; $i < 5; $i++)<svg class="w-4 h-4 text-amber-400 fill-amber-400" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>@endfor</div>
          <blockquote class="font-display text-lg font-semibold text-gray-900 leading-snug mb-6">"Reliable sea freight tracking was hard to find until TrackGoods. It just works, every shipment."</blockquote>
          <div class="flex items-center gap-3">
            <img src="https://picsum.photos/seed/customer4/100/100" class="w-11 h-11 rounded-full object-cover" alt="Import Coordinator" loading="lazy">
            <div class="text-left">
              <p class="text-sm font-semibold text-gray-800">Import Coordinator</p>
              <p class="text-sm text-gray-400">Manufacturing Client</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </section>

  <!-- ===================== PROCESS TIMELINE (horizontal scroll) ===================== -->
  <section id="process" class="relative bg-indigo-950 overflow-hidden">
    <div class="process-pin-wrap h-screen flex flex-col justify-center overflow-hidden">
      <div class="px-5 sm:px-8 mb-10 text-center">
        <span class="text-indigo-300 font-semibold text-sm uppercase tracking-wider">How your shipment moves</span>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-white mt-3">From pickup to your doorstep</h2>
      </div>
      <div class="process-track flex gap-8 px-[10vw] items-stretch will-change-transform">

        <div class="process-card shrink-0 w-[80vw] sm:w-[420px] bg-white/5 backdrop-blur rounded-3xl p-8 border border-white/10">
          <img src="https://picsum.photos/seed/pickup/600/400" class="rounded-2xl mb-6 w-full h-48 object-cover" alt="Pickup" loading="lazy">
          <span class="text-indigo-300 font-semibold text-sm">Step 01</span>
          <h3 class="font-display text-2xl font-bold text-white mt-2 mb-3">Pickup</h3>
          <p class="text-indigo-200/80 text-sm leading-relaxed">Your shipment is collected from origin and scanned into our system, starting real-time tracking instantly.</p>
        </div>

        <div class="process-card shrink-0 w-[80vw] sm:w-[420px] bg-white/5 backdrop-blur rounded-3xl p-8 border border-white/10">
          <img src="https://picsum.photos/seed/transit/600/400" class="rounded-2xl mb-6 w-full h-48 object-cover" alt="In transit" loading="lazy">
          <span class="text-indigo-300 font-semibold text-sm">Step 02</span>
          <h3 class="font-display text-2xl font-bold text-white mt-2 mb-3">In Transit</h3>
          <p class="text-indigo-200/80 text-sm leading-relaxed">Live location updates as your goods move by air, road, or sea — visible on your dashboard at every step.</p>
        </div>

        <div class="process-card shrink-0 w-[80vw] sm:w-[420px] bg-white/5 backdrop-blur rounded-3xl p-8 border border-white/10">
          <img src="https://picsum.photos/seed/customs/600/400" class="rounded-2xl mb-6 w-full h-48 object-cover" alt="Customs clearance" loading="lazy">
          <span class="text-indigo-300 font-semibold text-sm">Step 03</span>
          <h3 class="font-display text-2xl font-bold text-white mt-2 mb-3">Customs Clearance</h3>
          <p class="text-indigo-200/80 text-sm leading-relaxed">We handle documentation and clearance, keeping you notified so there are no surprises at the border.</p>
        </div>

        <div class="process-card shrink-0 w-[80vw] sm:w-[420px] bg-white/5 backdrop-blur rounded-3xl p-8 border border-white/10">
          <img src="https://picsum.photos/seed/delivery/600/400" class="rounded-2xl mb-6 w-full h-48 object-cover" alt="Out for delivery" loading="lazy">
          <span class="text-indigo-300 font-semibold text-sm">Step 04</span>
          <h3 class="font-display text-2xl font-bold text-white mt-2 mb-3">Out for Delivery</h3>
          <p class="text-indigo-200/80 text-sm leading-relaxed">Final leg to your address, with delivery windows and driver updates sent straight to your phone.</p>
        </div>

        <div class="process-card shrink-0 w-[80vw] sm:w-[420px] bg-indigo-600 rounded-3xl p-8 border border-indigo-400/30 flex flex-col justify-center">
          <span class="text-indigo-200 font-semibold text-sm">Step 05</span>
          <h3 class="font-display text-2xl font-bold text-white mt-2 mb-3">Delivered</h3>
          <p class="text-indigo-100/90 text-sm leading-relaxed">Signed, sealed, delivered — with a full timeline of your shipment's journey saved to your account.</p>
        </div>

      </div>
    </div>
  </section>

  <!-- ===================== FAQ ===================== -->
  <section id="faq" class="py-24 sm:py-32 bg-white">
    <div class="max-w-3xl mx-auto px-5 sm:px-8">
      <div class="text-center mb-14">
        <span class="text-indigo-600 font-semibold text-sm uppercase tracking-wider">Got questions?</span>
        <h2 class="font-display text-3xl sm:text-4xl font-bold text-gray-900 mt-3">Frequently asked questions</h2>
      </div>
      <div class="space-y-3">

        <div x-data="{ open: false }" class="border border-slate-200 rounded-2xl overflow-hidden">
          <button @click="open = !open" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
            <span class="font-semibold text-gray-900">How do I track my shipment?</span>
            <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-5 text-gray-500 text-sm leading-relaxed">
            Enter your tracking number in the search bar at the top of the page. You'll see live status updates from pickup through to delivery.
          </div>
        </div>

        <div x-data="{ open: false }" class="border border-slate-200 rounded-2xl overflow-hidden">
          <button @click="open = !open" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
            <span class="font-semibold text-gray-900">Which shipping methods do you support?</span>
            <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-5 text-gray-500 text-sm leading-relaxed">
            We track shipments across air, road, and sea freight — from single parcels to bulk container shipping.
          </div>
        </div>

        <div x-data="{ open: false }" class="border border-slate-200 rounded-2xl overflow-hidden">
          <button @click="open = !open" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
            <span class="font-semibold text-gray-900">What happens during customs clearance?</span>
            <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-5 text-gray-500 text-sm leading-relaxed">
            We handle documentation and liaise with customs on your behalf, sending you updates so there are no surprises at the border.
          </div>
        </div>

        <div x-data="{ open: false }" class="border border-slate-200 rounded-2xl overflow-hidden">
          <button @click="open = !open" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
            <span class="font-semibold text-gray-900">Can I get delivery notifications?</span>
            <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-5 text-gray-500 text-sm leading-relaxed">
            Yes — you can opt in to updates via WhatsApp or email at each stage of your shipment's journey.
          </div>
        </div>

        <div x-data="{ open: false }" class="border border-slate-200 rounded-2xl overflow-hidden">
          <button @click="open = !open" class="w-full flex items-center justify-between gap-4 px-6 py-5 text-left">
            <span class="font-semibold text-gray-900">Do you support international shipping?</span>
            <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
          </button>
          <div x-show="open" x-collapse class="px-6 pb-5 text-gray-500 text-sm leading-relaxed">
            Yes, we support shipments to and from most countries worldwide across all three freight types.
          </div>
        </div>

      </div>
    </div>
  </section>
  <!-- ===================== FINAL CTA ===================== -->
  <section id="final-cta" class="relative py-20 sm:py-28 bg-gradient-to-br from-indigo-700 via-indigo-600 to-indigo-800 text-white overflow-hidden">
    <div class="gsap-cta-orb-1 absolute -top-32 -right-32 w-80 h-80 bg-white/8 rounded-full blur-3xl pointer-events-none"></div>
    <div class="gsap-cta-orb-2 absolute -bottom-32 -left-32 w-80 h-80 bg-indigo-400/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-0 left-0 w-full h-px bg-gradient-to-r from-transparent via-indigo-300/30 to-transparent"></div>

    <div class="gsap-cta-content relative max-w-4xl mx-auto px-5 sm:px-8 text-center">
      <p class="text-indigo-200 font-semibold text-sm uppercase tracking-widest mb-4">Get Started</p>
      <h2 class="font-display text-4xl sm:text-5xl font-extrabold tracking-tight">
        Ready for Smarter Tracking?
      </h2>
      <p class="mt-5 text-lg text-white/75 max-w-2xl mx-auto leading-relaxed">
        Enter your tracking number below for instant, real-time shipment updates.
      </p>

      <div class="mt-10">
        <form action="{{ route('track') }}" method="GET"
          class="flex flex-col sm:flex-row items-center gap-3 max-w-2xl mx-auto">
          <input
            type="text"
            name="trackingNumber"
            placeholder="e.g. TG-987654321-GL"
            class="w-full sm:flex-1 px-6 py-4 text-base rounded-full border border-white/25 bg-white/10 placeholder-white/50 text-white focus:outline-none focus:border-white focus:bg-white/15 transition"
            required
          />
          <button type="submit"
            class="w-full sm:w-auto bg-white text-indigo-700 px-8 py-4 rounded-full font-bold text-base hover:bg-indigo-50 shadow-xl transition flex items-center justify-center gap-2 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-4.35-4.35M17 11A6 6 0 115 11a6 6 0 0112 0z"/></svg>
            Track Shipment
          </button>
        </form>
      </div>
    </div>
  </section>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    if (!window.gsap || !window.ScrollTrigger) return;

    gsap.to('#hero-bg-1, #hero-bg-2', {
      yPercent: 20,
      ease: 'none',
      scrollTrigger: { trigger: '#hero', start: 'top top', end: 'bottom top', scrub: true }
    });
    gsap.to('#hero-content', {
      yPercent: -15,
      opacity: 0.35,
      ease: 'none',
      scrollTrigger: { trigger: '#hero', start: 'top top', end: 'bottom top', scrub: true }
    });

        document.querySelectorAll('.gsap-service-card').forEach((card) => {
      gsap.fromTo(card,
        { clipPath: 'polygon(0% 0%, 0% 0%, 0% 100%, 0% 100%)' },
        {
          clipPath: 'polygon(0% 0%, 100% 0%, 100% 100%, 0% 100%)',
          duration: 0.9, ease: 'power3.inOut',
          scrollTrigger: { trigger: card, start: 'top 80%' }
        }
      );
    });

    gsap.fromTo('.gsap-feature-card',
      { opacity: 0, y: 60, scale: 0.9 },
      {
        opacity: 1, y: 0, scale: 1, stagger: 0.15, duration: 0.9, ease: 'back.out(1.4)',
        scrollTrigger: { trigger: '#features', start: 'top 75%' }
      }
    );

    document.querySelectorAll('.gsap-step-card').forEach((card) => {
      gsap.fromTo(card,
        { clipPath: 'circle(0% at 50% 50%)', opacity: 0 },
        {
          clipPath: 'circle(75% at 50% 50%)', opacity: 1,
          duration: 0.9, ease: 'power3.inOut',
          scrollTrigger: { trigger: card, start: 'top 80%' }
        }
      );
    });

    gsap.to('.impact-orb', {
      y: -100,
      ease: 'none',
      scrollTrigger: { trigger: '#impact', start: 'top bottom', end: 'bottom top', scrub: true }
    });
    gsap.fromTo('.gsap-stat-card',
      { opacity: 0, y: 50, scale: 0.85 },
      {
        opacity: 1, y: 0, scale: 1, stagger: 0.12, duration: 0.8, ease: 'back.out(1.5)',
        scrollTrigger: { trigger: '#impact', start: 'top 70%' }
      }
    );
    gsap.fromTo('.gsap-metric-card',
      { opacity: 0, y: 40 },
      {
        opacity: 1, y: 0, stagger: 0.15, duration: 0.7, ease: 'power2.out',
        scrollTrigger: { trigger: '.gsap-metric-card', start: 'top 85%' }
      }
    );

    document.querySelectorAll('.gsap-testimonial-card').forEach((card, i) => {
      const fromLeft = i % 2 === 0;
      gsap.fromTo(card,
        { opacity: 0, x: fromLeft ? -60 : 60, y: 30 },
        {
          opacity: 1, x: 0, y: 0, duration: 0.9, ease: 'power3.out',
          scrollTrigger: { trigger: card, start: 'top 85%' }
        }
      );
    });

    gsap.to('.gsap-cta-orb-1', {
      y: -60, x: 30, ease: 'none',
      scrollTrigger: { trigger: '#final-cta', start: 'top bottom', end: 'bottom top', scrub: true }
    });
    gsap.to('.gsap-cta-orb-2', {
      y: 60, x: -30, ease: 'none',
      scrollTrigger: { trigger: '#final-cta', start: 'top bottom', end: 'bottom top', scrub: true }
    });
    gsap.fromTo('.gsap-cta-content',
      { opacity: 0, y: 50, scale: 0.95 },
      {
        opacity: 1, y: 0, scale: 1, duration: 1, ease: 'power3.out',
        scrollTrigger: { trigger: '#final-cta', start: 'top 70%' }
      }
    );

    const processTrack = document.querySelector('.process-track');
    if (processTrack) {
      let scrollAmount = () => processTrack.scrollWidth - window.innerWidth;
      gsap.to(processTrack, {
        x: () => -scrollAmount(),
        ease: 'none',
        scrollTrigger: {
          trigger: '#process',
          start: 'top top',
          end: () => '+=' + scrollAmount(),
          scrub: 1,
          pin: true,
          invalidateOnRefresh: true
        }
      });
    }
  });
</script>

<script>
  // Hero background crossfade (unchanged, working)
  const isMobile = window.matchMedia('(max-width: 767px)').matches;
  const heroImages = isMobile
    ? ['/img/mobile1.jpg','/img/mobile2.jpg','/img/mobile3.jpg','/img/mobile4.jpg','/img/mobile5.jpg','/img/mobile6.jpg']
    : ['/img/desktop1.jpg','/img/desktop2.jpg','/img/desktop3.jpg','/img/desktop4.jpg','/img/desktop5.jpg'];

  let heroIndex = 0;
  let showingFirst = true;
  const bg1 = document.getElementById('hero-bg-1');
  const bg2 = document.getElementById('hero-bg-2');

  if (bg1 && bg2) {
    bg1.style.backgroundImage = `url(${heroImages[0]})`;
    setInterval(() => {
      heroIndex = (heroIndex + 1) % heroImages.length;
      const fadeOut = showingFirst ? bg1 : bg2;
      const fadeIn  = showingFirst ? bg2 : bg1;
      fadeIn.style.backgroundImage = `url(${heroImages[heroIndex]})`;
      fadeOut.classList.replace('opacity-100', 'opacity-0');
      fadeIn.classList.replace('opacity-0', 'opacity-100');
      showingFirst = !showingFirst;
    }, 7000);
  }
</script>
</div>