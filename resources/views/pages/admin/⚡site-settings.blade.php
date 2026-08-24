<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;

new #[Title('Site Settings')]
#[Layout('layouts.admin')]
class extends Component
{
    use WithFileUploads;

    public string $site_name = '';
    public string $whatsapp_number = '';
    public string $phone = '';
    public string $email = '';
    public string $address = '';
    public $logo; // for upload
    public ?string $existingLogoPath = null;

    public function mount(): void
    {
        $settings = SiteSetting::current();
        $this->site_name = $settings->site_name ?? '';
        $this->whatsapp_number = $settings->whatsapp_number ?? '';
        $this->phone = $settings->phone ?? '';
        $this->email = $settings->email ?? '';
        $this->address = $settings->address ?? '';
        $this->existingLogoPath = $settings->logo_path;
    }

    public function save(): void
    {
        $validated = $this->validate([
            'site_name' => ['nullable', 'string', 'max:100'],
            'whatsapp_number' => ['nullable', 'string', 'max:20'],
            'phone' => ['nullable', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'max:5024'],
        ]);

        unset($validated['logo']);

        if ($this->logo) {
            if ($this->existingLogoPath) {
                Storage::disk('public')->delete($this->existingLogoPath);
            }
            $validated['logo_path'] = $this->logo->store('site', 'public');
        }

        SiteSetting::current()->update($validated);

        session()->flash('success', 'Site settings updated.');
        $this->existingLogoPath = SiteSetting::current()->logo_path;
        $this->logo = null;
    }

    public function removeLogo(): void
    {
        if ($this->existingLogoPath) {
            Storage::disk('public')->delete($this->existingLogoPath);
            SiteSetting::current()->update(['logo_path' => null]);
            $this->existingLogoPath = null;
        }
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
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Site Logo</label>
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-xl border border-gray-200 bg-gray-50 flex items-center justify-center overflow-hidden shrink-0">
                    @if($logo)
                        <img src="{{ $logo->temporaryUrl() }}" class="w-full h-full object-contain" />
                    @elseif($existingLogoPath)
                        <img src="{{ Storage::url($existingLogoPath) }}" class="w-full h-full object-contain" />
                    @else
                        <span class="text-[10px] text-gray-400 text-center px-1">No Logo</span>
                    @endif
                </div>
                <div class="flex-1 space-y-2">
                    <label class="cursor-pointer inline-block px-4 py-2 rounded-lg bg-indigo-50 text-indigo-600 text-xs font-bold hover:bg-indigo-100 transition">
                        Upload Logo
                        <input type="file" wire:model="logo" class="hidden" accept="image/*">
                    </label>
                    @if($existingLogoPath)
                        <button type="button" wire:click="removeLogo" class="ml-2 px-4 py-2 rounded-lg bg-red-50 text-red-600 text-xs font-bold hover:bg-red-100 transition">
                            Remove
                        </button>
                    @endif
                    <p class="text-xs text-gray-400">PNG or JPG, max 1MB.</p>
                    @error('logo') <p class="text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Site Name</label>
            <input type="text" wire:model="site_name" placeholder="TrackGoods"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition text-sm">
            @error('site_name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
        </div>

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