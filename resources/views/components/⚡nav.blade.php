<?php

use Livewire\Component;

new class extends Component
{
  //
};
?>
<div>
  <!-- Navbar -->
  <nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-lg border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex justify-between items-center h-16">
        <!-- Logo -->
        <a href="/" class="flex items-center">
          <img src="" alt="TrackGoods" class="h-10 w-auto">
        </a>

        <!-- Desktop Nav -->
        <div class="hidden md:flex items-center space-x-10">
          <a href="/" class="relative group text-gray-700 hover:text-indigo-700 font-medium transition {{ request()->Is('/') ? 'active-link' : '' }}">Home <span
            class="absolute left-0 bottom-[-4px] h-[4px] bg-indigo-700 rounded-lg w-0 group-hover:w-full transition-all duration-300"></span>
          </a>
          <!-- Services Dropdown (Desktop) -->
          <div class="relative group">
            <button class="relative group text-gray-700 hover:text-indigo-700 font-medium transition flex items-center gap-1">
              Services
              <svg class="w-4 h-4 transition-transform group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
              <span class="absolute left-0 bottom-[-4px] h-[4px] bg-indigo-700 rounded-lg w-0 group-hover:w-full transition-all duration-300"></span>
            </button>

            <!-- Dropdown Menu -->
            <div class="absolute left-0 top-full mt-2 w-48 bg-white rounded-xl shadow-xl border border-gray-200 py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 transform scale-95 group-hover:scale-100 origin-top">
              <a href="/services/1" class="block px-5 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">Air Freight</a>
              <a href="/services/2" class="block px-5 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">Road Transportation</a>
              <a href="/services/3" class="block px-5 py-3 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition">Sea Freight</a>
            </div>
          </div>
          <a href="/about" class="relative group text-gray-700 hover:text-indigo-700 font-medium transition {{ request()->Is('about') ? 'active-link' : '' }}">About<span
            class="absolute left-0 bottom-[-4px] h-[4px] bg-indigo-700 rounded-lg w-0 group-hover:w-full transition-all duration-300"></span>
          </a>
          <a href="#support" class="relative group text-gray-700 hover:text-indigo-700 font-medium transition {{ request()->Is('/contact') ? 'active-link' : '' }}">Contact
            <span
              class="absolute left-0 bottom-[-4px] h-[4px] bg-indigo-700 rounded-lg w-0 group-hover:w-full transition-all duration-300"></span>
          </a>
        </div>

        <!-- Desktop Auth -->
        <div class="hidden md:flex items-center space-x-6">
          <a href="/tracking"
            class="bg-indigo-700 text-white px-6 py-2.5 rounded-full font-semibold hover:bg-indigo-600 transition shadow-md">
            Track
          </a>
        </div>

        <!-- Mobile Hamburger -->
        <label for="mobile-drawer" class="sm:hidden cursor-pointer text-gray-700">
          <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M4 6h16M4 12h16M4 18h16" />
          </svg>
        </label>

      </div>
    </div>

  </nav>

  <div x-data="drawer()" class="drawer drawer-end md:hidden z-100" x-init="initDrawer()">
    <input id="mobile-drawer" type="checkbox" class="drawer-toggle" x-ref="checkbox" />

  <div class="drawer-side">
    <label for="mobile-drawer" class="drawer-overlay"></label>
    <div class="backdrop-blur-lg min-h-full relative w-[70vw] flex flex-col justify-start items-end relative max-w-sm">

      <!-- Close Button -->
      <label for="mobile-drawer" class="absolute top-4 right-4 cursor-pointer hover:text-black">
        <svg class="w-7 h-7" fill="none" stroke="white" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </label>

      <!-- Menu -->
      <ul class="menu p-0 mt-15 space-y-3">
        <li>
          <a href="/" x-ref="link1"
            class="{{ request()->is('/') ? 'border border-white font-bold text-white' : '' }} w-50 ml-auto text-white p-4 rounded-none rounded-l-3xl">Home
          </a>
        </li>
        <!-- Services Dropdown -->
        <li>
          <details x-ref="link2" class="group">
            <summary
              class="flex items-center gap-2 text-white p-4 rounded-none rounded-l-3xl cursor-pointer
              {{ request()->is('services*') ? 'border border-white font-bold' : '' }}">
              <span>Services</span>
            </summary>

            <!-- Dropdown -->
            <ul class="pl-6 mt-2 space-y-2">
              <li class="border-b border-gray-300/10">
                <a href="/services/1" class="block text-white/90 hover:text-white transition">
                  Air Freight
                </a>
              </li>
              <li class="border-b border-gray-300/10">
                <a href="/services/2" class="block text-white/90 hover:text-white transition">
                  Road Transportation
                </a>
              </li>
             <li class="border-b border-gray-300/10">
                <a href="/services/3" class="block text-white/90 hover:text-white transition">
                  Sea Freight
                </a>
              </li>
            </ul>
          </details>
        </li>
        <li>
          <a href="/about" x-ref="link3"
            class="{{ request()->is('about') ? 'border border-white font-bold text-white' : '' }} text-white p-4 rounded-none rounded-l-3xl">About
          </a>
        </li>
        <li>
          <a href="/contactUs" x-ref="link4"
            class="{{ request()->is('contactUs') ? 'border border-white font-bold text-white' : '' }} text-white p-4 rounded-none rounded-l-3xl">Contact
          </a>
        </li>
      </ul>
      <div class="flex w-[90%] mx-auto my-4 items-center space-x-6">
        <a href="/track"
          class="bg-indigo-600 w-full text-white text-center  px-6 py-2.5 rounded-full font-semibold hover:bg-indigo-600 transition shadow-md">
          Track
        </a>
      </div>
    </div>
  </div>
</div>

<style>
  .active-link span {
    width: 100% !important;
  }
</style>


<script>
  function drawer() {
    return {
      linkDelays: [100,
        150,
        200,
        250],
      // top-to-bottom stagger

      initDrawer() {
        const checkbox = this.$refs.checkbox;
        checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
        // Animate links in sequence
        for (let i = 1; i <= 4; i++) {
        const el = this.$refs['link'+i];
        el.classList.remove('animate-elastic-pop', `delay-${this.linkDelays[i-1]}`);
        void el.offsetWidth; // force reflow
        el.classList.add('animate-elastic-pop', `delay-${this.linkDelays[i-1]}`);
        }
        }
        });
      }
    }
  }
</script>




<script>
  function drawer() {
    return {
      open: false,
      linkDelays: [100,
        150,
        200,
        250],
      linkClass(index) {
        // Only animate if drawer is open
        return this.open ? `animate-elastic-pop delay-${this.linkDelays[index-1]}`: '';
      },
      // Watch for open changes to reset animation
      init() {
        this.$watch('open', (value) => {
        if (value) {
        // Remove animation first to reset
        for (let i = 1; i <= 4; i++) {
        const el = this.$refs['link'+i];
        el.classList.remove('animate-elastic-pop', `delay-${this.linkDelays[i-1]}`);
        // Force reflow so animation can retrigger
        void el.offsetWidth;
        el.classList.add('animate-elastic-pop', `delay-${this.linkDelays[i-1]}`);
        }
        }
        });
      }
    }
  }
</script>