<?php

use Livewire\Attributes\Title;
use Livewire\Component;
use App\Models\ContactMessage;

new #[Title('Contact Us')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $subject = '';
    public string $message = '';

    public bool $sent = false;

    public function send()
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10',
        ]);

        ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'is_read' => false,
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);
        $this->sent = true;
    }
};
?>

<div class="min-h-screen bg-slate-50 overflow-x-hidden">
    <!-- HERO SECTION -->
    <section class="relative pt-32 pb-20 overflow-hidden bg-slate-900 text-white">
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-20 w-96 h-96 bg-indigo-500 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 -right-20 w-96 h-96 bg-blue-500 rounded-full blur-3xl"></div>
        </div>

        <div class="relative max-w-6xl mx-auto px-4 text-center">
            <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-500/20 text-indigo-300 text-xs font-bold uppercase tracking-widest mb-6 border border-indigo-500/30">
                Get in Touch
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-extrabold leading-tight mb-6">
                We're Here to Help You <span class="text-indigo-400">Navigate</span>
            </h1>
            <p class="text-base md:text-lg text-slate-400 max-w-2xl mx-auto leading-relaxed">
                Whether you have a question about a shipment, need a custom quote, or want to discuss a partnership, our global team is ready to assist.
            </p>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 md:-mt-12 pb-24 relative z-10">
        <div class="grid lg:grid-cols-12 gap-8 md:gap-12">

            <!-- LEFT COLUMN: CONTACT INFO -->
            <div class="lg:col-span-5 space-y-6 md:space-y-8">
                <!-- Main Contact Card -->
                <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-6 md:p-8 border border-slate-100">
                    <h2 class="text-xl md:text-2xl font-bold text-slate-900 mb-6 flex items-center justify-center md:justify-start gap-3">
                        <span class="w-2 h-8 bg-indigo-600 rounded-full"></span>
                        Contact Information
                    </h2>

                    <div class="space-y-6">
                        <!-- Email -->
                        <div class="group flex flex-col md:flex-row items-center md:items-start text-center md:text-left gap-3 md:gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs md:text-sm font-semibold text-slate-500 uppercase tracking-wider">Email Address</p>
                                <p class="text-base md:text-lg font-bold text-slate-900 truncate">support@trackgoods.com</p>
                            </div>
                        </div>

                        <!-- Phone -->
                        <div class="group flex flex-col md:flex-row items-center md:items-start text-center md:text-left gap-3 md:gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs md:text-sm font-semibold text-slate-500 uppercase tracking-wider">Phone Line</p>
                                <p class="text-base md:text-lg font-bold text-slate-900 truncate">+1 XXX XXX XXXX</p>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="group flex flex-col md:flex-row items-center md:items-start text-center md:text-left gap-3 md:gap-4 p-4 rounded-2xl hover:bg-slate-50 transition-colors border border-transparent hover:border-slate-100">
                            <div class="w-10 h-10 md:w-12 md:h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs md:text-sm font-semibold text-slate-500 uppercase tracking-wider">Service Area</p>
                                <p class="text-base md:text-lg font-bold text-slate-900 truncate">Global Operations</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- WhatsApp CTA -->
                <a href="https://wa.me/yourphonenumber"
                   class="flex items-center justify-center gap-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-4 md:py-5 rounded-3xl shadow-lg shadow-emerald-200 transition-all hover:-translate-y-1 w-full">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.198-.347.223-.644.075-.297-.149-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.297-.497.099-.198.05-.371-.025-.52-.074-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L0 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Chat on WhatsApp
                </a>
            </div>
        </div>

        <!-- RIGHT COLUMN: CONTACT FORM -->
        <div class="lg:col-span-7">
            <div class="bg-white rounded-3xl shadow-2xl shadow-slate-200/60 p-6 md:p-12 border border-slate-100">
                <div class="mb-10 text-center md:text-left">
                    <h2 class="text-2xl md:text-3xl font-bold text-slate-900 mb-3">Send a Message</h2>
                    <p class="text-slate-500 text-sm md:text-base">Fill out the form below and our team will get back to you as soon as possible.</p>
                </div>

                @if ($sent)
                    <div class="mb-8 p-5 rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-700 flex items-center gap-3 animate-bounce-in">
                        <svg class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span class="font-medium">Message sent successfully! We'll get back to you shortly.</span>
                    </div>
                @endif

                <form wire:submit.prevent="send" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Name -->
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Full Name</label>
                        <input type="text"
                            wire:model.defer="name"
                            placeholder="John Doe"
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        @error('name') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Email -->
                    <div class="md:col-span-1">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Email Address</label>
                        <input type="email"
                            wire:model.defer="email"
                            placeholder="john@example.com"
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        @error('email') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Subject -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Subject</label>
                        <input type="text"
                            wire:model.defer="subject"
                            placeholder="How can we help you?"
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        @error('subject') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Message -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-slate-700 mb-2 ml-1">Message</label>
                        <textarea
                            wire:model.defer="message"
                            rows="6"
                            placeholder="Tell us more about your request..."
                            class="w-full px-5 py-3.5 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-slate-50 focus:bg-white"></textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1 ml-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Submit -->
                    <div class="md:col-span-2 pt-4">
                        <button type="submit"
                            class="w-full md:w-auto px-12 py-4 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-indigo-200 hover:shadow-indigo-300 hover:-translate-y-1 flex items-center justify-center gap-3">
                            <span>Send Message</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MAP PLACEHOLDER -->
        <div class="mt-16 relative rounded-3xl overflow-hidden h-96 shadow-inner border-4 border-white">
            <div class="absolute inset-0 bg-slate-200 flex items-center justify-center">
                <div class="text-center p-8">
                    <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-6 shadow-sm">
                        <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894l5.447 2.724a1 1 0 001.106 0l5.447-2.724A1 1 0 0118 5.618v10.764a1 1 0 01-1.447.894l-5.447-2.724a1 1 0 00-1.106 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">Interactive Map Coming Soon</h3>
                    <p class="text-slate-500 max-w-md mx-auto">We are currently updating our global office locations to provide you with the best possible experience.</p>
                </div>
            </div>
            <!-- Overlay effect -->
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900/20 to-transparent pointer-events-none"></div>
        </div>
    </div>
</div>