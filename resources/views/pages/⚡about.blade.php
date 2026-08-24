<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<div class="min-h-screen bg-[#f8f7ff]" style="font-family: 'Sora', sans-serif;">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    .stat-pill { transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .stat-pill:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(79,70,229,0.15); }
    .value-card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .value-card:hover { transform: translateY(-4px); box-shadow: 0 20px 48px rgba(79,70,229,0.12); }
    .milestone-card { transition: transform 0.25s ease, box-shadow 0.25s ease; }
    .milestone-card:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(79,70,229,0.10); }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.7s ease both; }
    .fade-up-1 { animation-delay: 0.1s; }
    .fade-up-2 { animation-delay: 0.25s; }
    .fade-up-3 { animation-delay: 0.4s; }
  </style>

  <!-- Hero -->
  <section class="relative pt-32 pb-28 overflow-hidden">
    <div class="absolute inset-0" style="background: radial-gradient(ellipse 80% 60% at 50% 0%, #e0e7ff 0%, #f8f7ff 70%);"></div>
    <!-- Decorative blob -->
    <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full opacity-20" style="background: radial-gradient(circle, #6366f1, transparent);"></div>
    <div class="absolute -bottom-12 -left-12 w-64 h-64 rounded-full opacity-10" style="background: radial-gradient(circle, #4f46e5, transparent);"></div>

    <div class="relative max-w-6xl mx-auto px-6 lg:px-8 text-center">
      <span class="fade-up fade-up-1 inline-block px-5 py-2 rounded-full text-sm font-semibold tracking-widest uppercase mb-6"
        style="background: #e0e7ff; color: #4f46e5; letter-spacing: 0.12em;">
        About TrackGoods
      </span>

      <h1 class="fade-up fade-up-2 text-5xl md:text-7xl font-extrabold text-gray-900 leading-[1.08] tracking-tight">
        Building the Global<br>
        <span style="color: #4f46e5;">Logistics Future</span>
      </h1>

      <p class="fade-up fade-up-3 mt-7 text-lg md:text-xl text-gray-500 max-w-3xl mx-auto leading-relaxed font-light">
        TrackGoods is more than a tracking platform — we're a movement to bring transparency, speed, and trust to every shipment across the globe.
      </p>

      <!-- Stats row -->
      <div class="fade-up fade-up-3 mt-12 flex flex-wrap justify-center gap-4">
        <div class="stat-pill flex items-center gap-3 bg-white px-7 py-4 rounded-2xl shadow-sm border border-indigo-100">
          <span class="text-3xl font-extrabold" style="color:#4f46e5;">10k+</span>
          <span class="text-gray-500 text-sm font-medium">Packages Tracked</span>
        </div>
        <div class="stat-pill flex items-center gap-3 bg-white px-7 py-4 rounded-2xl shadow-sm border border-indigo-100">
          <span class="text-3xl font-extrabold" style="color:#4f46e5;">5+</span>
          <span class="text-gray-500 text-sm font-medium">Years of Innovation</span>
        </div>
        <div class="stat-pill flex items-center gap-3 bg-white px-7 py-4 rounded-2xl shadow-sm border border-indigo-100">
          <span class="text-3xl font-extrabold" style="color:#4f46e5;">24/7</span>
          <span class="text-gray-500 text-sm font-medium">Support Team</span>
        </div>
      </div>
    </div>
  </section>

  <!-- Mission & Story -->
  <section class="py-24 bg-white">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
      <div class="grid lg:grid-cols-2 gap-16 items-center">
        <div>
          <span class="inline-block px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-6"
            style="background:#e0e7ff; color:#4f46e5;">Our Mission</span>
          <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900 leading-tight">
            Every shipment — visible, secure, and stress-free.
          </h2>
          <p class="mt-6 text-gray-500 text-lg leading-relaxed">
            In a world where logistics is the backbone of commerce, too many shipments still disappear into black holes. We built TrackGoods to change that — one real-time update at a time.
          </p>
          <p class="mt-5 text-gray-400 leading-relaxed">
            Founded with a global vision, we started with one goal: give businesses and individuals the same world-class tracking experience that global leaders enjoy.
          </p>
          <div class="mt-8 flex items-center gap-3">
            <div class="w-10 h-10 rounded-full flex items-center justify-center" style="background:#e0e7ff;">
              <svg class="w-5 h-5" style="color:#4f46e5;" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/></svg>
            </div>
            <span class="text-gray-500 font-medium">Global Headquarters</span>
          </div>
        </div>

        <div class="relative rounded-3xl overflow-hidden shadow-2xl group" style="aspect-ratio: 4/3;">
          <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&q=80&w=2070"
            alt="Logistics team" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
          <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(17,7,60,0.65) 0%, rgba(17,7,60,0.1) 60%, transparent 100%);"></div>
          <div class="absolute bottom-8 left-8 right-8 flex items-end justify-between">
            <p class="text-white font-semibold text-lg">Corporate HQ</p>            <span class="px-3 py-1 rounded-full text-xs font-bold text-white" style="background: rgba(79,70,229,0.75); backdrop-filter: blur(4px);">Since 2021</span>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Core Values -->
  <section class="py-24" style="background:#f8f7ff;">
    <div class="max-w-6xl mx-auto px-6 lg:px-8">
      <div class="text-center mb-16">
        <span class="inline-block px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-4"
          style="background:#e0e7ff; color:#4f46e5;">What We Stand For</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900">Our Core Values</h2>
        <p class="mt-4 text-gray-500 max-w-2xl mx-auto text-lg font-light">
          These principles guide every decision — from code to customer support.
        </p>
      </div>

      <div class="grid md:grid-cols-3 gap-6">
        <!-- Card 1 -->
        <div class="value-card bg-white rounded-3xl p-8 border border-indigo-50 shadow-md">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 text-2xl font-extrabold text-white"
            style="background: linear-gradient(135deg, #6366f1, #4f46e5);">1</div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Transparency First</h3>
          <p class="text-gray-500 leading-relaxed text-sm">No hidden fees. No vague statuses. You always know exactly where your package is and why.</p>
          <div class="mt-6 h-1 w-12 rounded-full" style="background:#4f46e5;"></div>
        </div>

        <!-- Card 2 -->
        <div class="value-card bg-white rounded-3xl p-8 border border-indigo-50 shadow-md" style="margin-top: 1.5rem;">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 text-2xl font-extrabold text-white"
            style="background: linear-gradient(135deg, #6366f1, #4f46e5);">2</div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">Speed & Reliability</h3>
          <p class="text-gray-500 leading-relaxed text-sm">Real-time updates every few minutes. Built on modern infrastructure that never sleeps.</p>
          <div class="mt-6 h-1 w-12 rounded-full" style="background:#4f46e5;"></div>
        </div>

        <!-- Card 3 -->
        <div class="value-card bg-white rounded-3xl p-8 border border-indigo-50 shadow-md">
          <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 text-2xl font-extrabold text-white"
            style="background: linear-gradient(135deg, #6366f1, #4f46e5);">3</div>
          <h3 class="text-xl font-bold text-gray-900 mb-3">People-Centric</h3>
          <p class="text-gray-500 leading-relaxed text-sm">From SMEs to individuals — everyone deserves enterprise-grade tracking at zero friction.</p>
          <div class="mt-6 h-1 w-12 rounded-full" style="background:#4f46e5;"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- Journey / Milestones -->
  <section class="py-24 bg-white">
    <div class="max-w-4xl mx-auto px-6 lg:px-8">
      <div class="text-center mb-16">
        <span class="inline-block px-4 py-2 rounded-full text-xs font-bold uppercase tracking-widest mb-4"
          style="background:#e0e7ff; color:#4f46e5;">Timeline</span>
        <h2 class="text-4xl md:text-5xl font-extrabold text-gray-900">Our Journey</h2>
        <p class="mt-4 text-gray-500 max-w-xl mx-auto font-light">From a small idea to a trusted platform worldwide.</p>
      </div>

      <div class="relative">
        <!-- Center line desktop -->
        <div class="absolute left-1/2 top-0 bottom-0 w-px hidden md:block" style="background: linear-gradient(to bottom, #e0e7ff, #c7d2fe, #e0e7ff); transform: translateX(-50%);"></div>

        <div class="space-y-10 md:space-y-14">
          <!-- Milestone 1 -->
          <div class="relative flex flex-col md:flex-row items-center gap-6 md:gap-0">
            <div class="md:w-5/12 md:pr-10 md:text-right">
              <div class="milestone-card bg-white rounded-2xl p-6 border border-indigo-50 shadow-md inline-block text-left md:text-right w-full">
                <h3 class="text-lg font-bold text-gray-900">The Beginning</h3>
                <p class="mt-2 text-gray-500 text-sm">Started as a simple tracking tool for businesses across the region.</p>
              </div>
            </div>
            <div class="z-10 flex-shrink-0 md:mx-auto relative md:absolute md:left-1/2 md:-translate-x-1/2">
              <div class="w-16 h-16 rounded-full flex items-center justify-center text-xl font-extrabold text-white shadow-lg"
                style="background: linear-gradient(135deg, #6366f1, #4338ca);">2021</div>
            </div>
            <div class="hidden md:block md:w-5/12"></div>
          </div>

          <!-- Milestone 2 -->
          <div class="relative flex flex-col md:flex-row-reverse items-center gap-6 md:gap-0">
            <div class="md:w-5/12 md:pl-10">
              <div class="milestone-card bg-white rounded-2xl p-6 border border-indigo-50 shadow-md inline-block w-full">
                <h3 class="text-lg font-bold text-gray-900">Nationwide Expansion</h3>
                <p class="mt-2 text-gray-500 text-sm">Expanded to major international regions with real-time GPS and carrier partnerships.</p>
              </div>
            </div>
            <div class="z-10 flex-shrink-0 md:absolute md:left-1/2 md:-translate-x-1/2">
              <div class="w-16 h-16 rounded-full flex items-center justify-center text-xl font-extrabold text-white shadow-lg"
                style="background: linear-gradient(135deg, #6366f1, #4338ca);">2023</div>
            </div>
            <div class="hidden md:block md:w-5/12"></div>
          </div>

          <!-- Milestone 3 -->
          <div class="relative flex flex-col md:flex-row items-center gap-6 md:gap-0">
            <div class="md:w-5/12 md:pr-10 md:text-right">
              <div class="milestone-card bg-white rounded-2xl p-6 border border-indigo-50 shadow-md inline-block text-left md:text-right w-full">
                <h3 class="text-lg font-bold text-gray-900">Today</h3>
                <p class="mt-2 text-gray-500 text-sm">Trusted by thousands — delivering transparency globally every day.</p>
              </div>
            </div>
            <div class="z-10 flex-shrink-0 md:absolute md:left-1/2 md:-translate-x-1/2">
              <div class="w-16 h-16 rounded-full flex items-center justify-center text-xl font-extrabold text-white shadow-lg"
                style="background: linear-gradient(135deg, #6366f1, #4338ca);">2025</div>
            </div>
            <div class="hidden md:block md:w-5/12"></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="py-24" style="background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <!-- Decorative -->
      <div class="w-16 h-1 rounded-full bg-indigo-300 mx-auto mb-8"></div>
      <h2 class="text-4xl md:text-5xl font-extrabold text-white leading-tight">
        Ready for Real Tracking?
      </h2>
      <p class="mt-5 text-indigo-200 text-lg md:text-xl max-w-2xl mx-auto font-light">
        Join thousands of businesses and individuals who trust TrackGoods every day.
      </p>
      <div class="mt-10">
        <a href="/tracking"
          class="inline-flex items-center gap-3 bg-white text-indigo-700 px-10 py-5 rounded-2xl text-lg font-bold hover:bg-indigo-50 transition-all shadow-2xl group">
          Get Started
          <span class="group-hover:translate-x-1 transition-transform inline-block">→</span>
        </a>
      </div>
    </div>
  </section>
</div>