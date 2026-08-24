<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\SiteSetting;

new #[Title('Site Settings')]
#[Layout('layouts.admin')]
class extends Component
{
    public string $whatsapp_number = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';

    public function mount(): void
    {
        $settings = SiteSetting::current();
        $this->whatsapp_number = $settings->whatsapp_number ?? '';
        $this->phone = $settings->phone ?? '';
        $this->email = $settings->email ?? '';
        $this->address = $settings->address ?? '';
    }

    public function save(): void
    {
        $validated = $this->validate([
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
        ]);

        SiteSetting::current()->update($validated);

        session()->flash('success', 'Site settings updated.');
    }
};
?>

<div class="max-w-2xl space-y-6">
    <div>
        <h2 class="text-xl font-bold text-gray-900">Site Contact Settings</h2>
        <p class="text-sm text-gray-500 mt-1">Used across the public site — WhatsApp CTA, contact info, and receipts.</p>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="save" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">WhatsApp Number</label>
            <input type="text" wire:model="whatsapp_number" placeholder="Digits only, no + or spaces — e.g. 15551234567"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition text-sm">
            @error('whatsapp_number') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Phone Number</label>
            <input type="text" wire:model="phone" placeholder="+1 (555) 000-1111"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition text-sm">
            @error('phone') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Contact Email</label>
            <input type="email" wire:model="email" placeholder="contact@goodstracker.com"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition text-sm">
            @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Address</label>
            <input type="text" wire:model="address" placeholder="123 Logistics Way, Shipping City"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition text-sm">
            @error('address') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="pt-2">
            <button type="submit" wire:loading.attr="disabled"
                class="px-6 py-3 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white text-sm font-semibold transition disabled:opacity-60">
                <span wire:loading.remove>Save Settings</span>
                <span wire:loading>Saving...</span>
            </button>
        </div>
    </form>
</div>
