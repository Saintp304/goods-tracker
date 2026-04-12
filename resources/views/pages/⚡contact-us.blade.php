<?php

use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Contact Us')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $message = '';

    public bool $sent = false;

    public function send()
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'message' => 'required|min:10',
        ]);

        // 🔹 Later: save to DB or send mail

        $this->reset(['name', 'email', 'message']);
        $this->sent = true;
    }
};
?>

<div class="min-h-screen bg-gray-50 pt-28 pb-16">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-3xl md:text-5xl font-extrabold text-gray-900">
                Contact Us
            </h1>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Have questions, need help tracking a shipment, or want to partner with us?
                Reach out — we’re here 24/7.
            </p>
        </div>

        <!-- Grid -->
        <div class="grid md:grid-cols-2 gap-10">

            <!-- Contact Info -->
            <div class="space-y-6">

                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">
                        Contact Information
                    </h2>

                    <p class="text-gray-600">
                        We respond quickly to all inquiries.
                    </p>

                    <div class="mt-6 space-y-4">

                        <div>
                            <p class="font-semibold text-gray-800">Email</p>
                            <p class="text-gray-600">support@trackgoods.com</p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-800">Phone</p>
                            <p class="text-gray-600">+234 XXX XXX XXXX</p>
                        </div>

                        <div>
                            <p class="font-semibold text-gray-800">Location</p>
                            <p class="text-gray-600">Nigeria (Nationwide Service)</p>
                        </div>

                    </div>
                </div>

                <!-- WhatsApp CTA -->
                <a href="https://wa.me/234yourphonenumber"
                   class="block text-center bg-green-500 hover:bg-green-600 text-white font-semibold py-4 rounded-2xl shadow-lg transition">
                    Chat on WhatsApp
                </a>

            </div>

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-xl p-8">

                <h2 class="text-2xl font-bold text-gray-900 mb-6">
                    Send a Message
                </h2>

                @if ($sent)
                    <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700">
                        ✅ Message sent successfully! We'll get back to you shortly.
                    </div>
                @endif

                <form wire:submit.prevent="send" class="space-y-5">

                    <!-- Name -->
                    <div>
                        <input type="text"
                            wire:model.defer="name"
                            placeholder="Your Name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('name') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <input type="email"
                            wire:model.defer="email"
                            placeholder="Your Email"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none">
                        @error('email') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Message -->
                    <div>
                        <textarea
                            wire:model.defer="message"
                            rows="5"
                            placeholder="Your Message"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 outline-none"></textarea>
                        @error('message') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 rounded-xl transition shadow-lg">
                        Send Message
                    </button>

                </form>

            </div>

        </div>

        <!-- Optional Map -->
        <div class="mt-16 bg-gray-200 rounded-2xl h-80 flex items-center justify-center">
            <p class="text-gray-500">
                Map (optional – add Google Maps or Leaflet later)
            </p>
        </div>

    </div>
</div>