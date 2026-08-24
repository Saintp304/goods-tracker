<?php

use Livewire\Component;
use App\Models\SiteSetting;

new class extends Component
{
  public $settings;

  public function mount(): void
  {
    $this->settings = SiteSetting::current();
  }
};
?>

<div>
  <footer class="bg-gray-900 text-gray-300 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid md:grid-cols-4 gap-12">
        <div>
          <h3 class="text-white text-2xl font-bold">{{ $settings->site_name}}</h3>
          <p class="mt-6 text-sm">
            Next-generation real-time tracking platform — secure, fast, and built for global logistics.
          </p>
          <ul class="mt-6 space-y-2 text-sm">
            @if($settings->email)
            <li><a href="mailto:{{ $settings->email }}" class="hover:text-white transition">Email: {{ $settings->email }}</a></li>
            @endif
            @if($settings->phone)
            <li><a href="tel:{{ $settings->phone }}" class="hover:text-white transition">Phone: {{ $settings->phone }}</a></li>
            @endif
            @if($settings->address)
            <li>Address: {{ $settings->address }}</li>
            @endif
            @if($settings->whatsapp_number)
            <li><a href="https://wa.me/{{ preg_replace('/\D/', '', $settings->whatsapp_number) }}" class="hover:text-white transition">WhatsApp: {{ $settings->whatsapp_number }}</a></li>
            @endif
          </ul>
        </div>
        <div>
          <h4 class="text-white font-semibold mb-6">Product</h4>
          <ul class="space-y-4 text-sm">
            <li><a href="#" class="hover:text-white transition">Features</a></li>
            <li><a href="#" class="hover:text-white transition">Pricing</a></li>
            <li><a href="#" class="hover:text-white transition">API & Integrations</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-white font-semibold mb-6">Company</h4>
          <ul class="space-y-4 text-sm">
            <li><a href="#" class="hover:text-white transition">About Us</a></li>
            <li><a href="#" class="hover:text-white transition">Blog</a></li>
            <li><a href="#" class="hover:text-white transition">Careers</a></li>
          </ul>
        </div>
        <div>
          <h4 class="text-white font-semibold mb-6">Support</h4>
          <ul class="space-y-4 text-sm">
            <li><a href="#" class="hover:text-white transition">Help Center</a></li>
            <li><a href="#" class="hover:text-white transition">Contact</a></li>
            <li><a href="#" class="hover:text-white transition">Privacy Policy</a></li>
          </ul>
        </div>
      </div>
      <div class="mt-16 pt-10 border-t border-gray-800 text-center text-sm">
        &copy {{ date('Y') }} {{$settings->site_name}}. Built for the global market. All rights reserved.
      </div>
    </div>
  </footer>
</div>