<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\PaymentSetting;
use Illuminate\Support\Facades\DB;

new #[Layout('layouts.admin')] class extends Component {
    public array $settings = [];
    public array $errors = [];

    public function mount() {
        $this->loadSettings();
    }

    public function loadSettings() {
        $methods = ['bank_transfer', 'paypal', 'crypto', 'cash', 'card'];

        $this->settings = [];
        foreach ($methods as $method) {
            $setting = PaymentSetting::where('method', $method)->first();
            $this->settings[$method] = $setting ? $setting->toArray() : [
                'method' => $method,
                'enabled' => false,
                'bank_name' => '',
                'account_name' => '',
                'account_number' => '',
                'iban' => '',
                'swift_bic' => '',
                'paypal_email' => '',
                'crypto_currency' => '',
                'crypto_network' => '',
                'wallet_address' => '',
                'instructions' => '',
            ];
        }
    }

    public function save($method) {
        $this->validate([
            "settings.{$method}.enabled" => 'boolean',
            "settings.{$method}.paypal_email" => 'nullable|email',
        ]);

        PaymentSetting::updateOrCreate(
            ['method' => $method],
            $this->settings[$method]
        );

        session()->flash('message', "Settings for " . ucfirst(str_replace('_', ' ', $method)) . " updated successfully.");
    }
};
?>

<div class="p-4 sm:p-6">
    <div class="mb-6 sm:mb-8">
        <h1 class="text-xl sm:text-2xl font-bold text-gray-900">Payment Instructions</h1>
        <p class="text-sm sm:text-base text-gray-500">
            Configure the manual payment details shown to customers.
        </p>
    </div>

    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 text-green-700 rounded-xl text-sm font-medium">
            {{ session('message') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 sm:gap-8">
        @foreach ($settings as $method => $setting)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-wrap justify-between items-center gap-3 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 shrink-0 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center font-bold uppercase">
                            {{ substr($method, 0, 1) }}
                        </div>
                        <h3 class="text-base sm:text-lg font-bold text-gray-900 uppercase tracking-wide">
                            {{ str_replace('_', ' ', $method) }}
                        </h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-gray-500">Enabled</span>
                        <input type="checkbox" wire:model="settings.{{ $method }}.enabled" class="w-4 h-4 text-indigo-600 rounded focus:ring-indigo-500">
                    </div>
                </div>

                <div class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
                    @if ($method === 'bank_transfer')
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Bank Name</label>
                            <input type="text" wire:model="settings.{{ $method }}.bank_name" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Account Name</label>
                            <input type="text" wire:model="settings.{{ $method }}.account_name" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Account Number</label>
                            <input type="text" wire:model="settings.{{ $method }}.account_number" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">IBAN</label>
                            <input type="text" wire:model="settings.{{ $method }}.iban" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">SWIFT/BIC</label>
                            <input type="text" wire:model="settings.{{ $method }}.swift_bic" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    @elseif ($method === 'paypal')
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">PayPal Email</label>
                            <input type="email" wire:model="settings.{{ $method }}.paypal_email" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    @elseif ($method === 'crypto')
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Cryptocurrency</label>
                            <input type="text" wire:model="settings.{{ $method }}.crypto_currency" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. USDT">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Network</label>
                            <input type="text" wire:model="settings.{{ $method }}.crypto_network" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="e.g. TRC20">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Wallet Address</label>
                            <input type="text" wire:model="settings.{{ $method }}.wallet_address" class="w-full p-2 border border-gray-200 rounded-lg text-sm font-mono focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    @endif

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Additional Instructions</label>
                        <textarea wire:model="settings.{{ $method }}.instructions" rows="3" class="w-full p-2 border border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                </div>

                <div class="p-4 bg-gray-50 border-t border-gray-100 text-right">
                    <button wire:click="save('{{ $method }}')" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-lg text-sm font-bold transition">
                        Save Settings
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>