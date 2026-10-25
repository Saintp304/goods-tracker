<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\Invoice;
use App\Services\FinancialService;

new #[Title('Invoice Management')]
#[Layout('layouts.admin')]
class extends Component
{
    public Shipment $shipment;
    public ?Invoice $invoice = null;

    public string $issue_date = '';
    public string $due_date = '';
    public string $currency = 'USD';
    public float $subtotal = 0;
    public float $tax = 0;

    public function mount(Shipment $shipment, FinancialService $financialService): void
    {
        $this->shipment = $shipment;
        $this->invoice = $shipment->invoice;

        if ($this->invoice) {
            $this->issue_date = $this->invoice->issue_date->format('Y-m-d');
            $this->due_date = $this->invoice->due_date->format('Y-m-d');
            $this->currency = $this->invoice->currency;
            $this->subtotal = (float) $this->invoice->subtotal;
            $this->tax = (float) $this->invoice->tax;
        } else {
            $this->issue_date = now()->toDateString();
            $this->due_date = now()->addDays(14)->toDateString();
        }
    }

    public function save(FinancialService $financialService): void
    {
        $this->validate([
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
            'currency' => 'required|string|max:3',
            'subtotal' => 'required|numeric|min:0',
            'tax' => 'required|numeric|min:0',
        ]);

        $data = [
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'currency' => $this->currency,
            'subtotal' => $this->subtotal,
            'tax' => $this->tax,
        ];

        if ($this->invoice) {
            // Update existing invoice
            $this->invoice->update($data);
            $this->invoice->total = round($this->subtotal + $this->tax, 2);
            $this->invoice->save();
        } else {
            // Create new invoice using service
            $this->invoice = $financialService->createInvoice($this->shipment, $data);
        }

        session()->flash('success', 'Invoice saved successfully.');
        $this->redirect(route('admin.shipments.edit', $this->shipment->id), navigate: true);
    }
};
?>

<div class="max-w-3xl mx-auto space-y-6 pb-28 lg:pb-12">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="p-4 sm:p-6 border-b border-gray-100 flex flex-row justify-between items-start gap-3">
            <div class="min-w-0">
                <h1 class="text-lg sm:text-2xl font-bold text-gray-900">
                    {{ $invoice ? 'Edit Invoice' : 'Create Invoice' }}
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 font-mono truncate">Shipment: {{ $shipment->tracking_number }}</p>
            </div>
            <a href="{{ route('admin.shipments.edit', $shipment->id) }}" wire:navigate
                class="shrink-0 text-sm font-semibold text-gray-600 hover:text-gray-900 transition px-3 py-1.5 rounded-lg hover:bg-gray-50">
                Cancel
            </a>
        </div>

        <div class="p-4 sm:p-6 space-y-6">
            <div class="grid sm:grid-cols-2 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Issue Date</label>
                    <input type="date" wire:model="issue_date"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    @error('issue_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Due Date</label>
                    <input type="date" wire:model="due_date"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    @error('due_date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-3 gap-4 sm:gap-6">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Currency</label>
                    <select wire:model="currency"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100">
                        <option value="USD">USD - US Dollar</option>
                        <option value="EUR">EUR - Euro</option>
                        <option value="GBP">GBP - British Pound</option>
                        <option value="CAD">CAD - Canadian Dollar</option>
                        <option value="AUD">AUD - Australian Dollar</option>
                        <option value="JPY">JPY - Japanese Yen</option>
                        <option value="CNY">CNY - Chinese Yuan</option>
                        <option value="INR">INR - Indian Rupee</option>
                        <option value="AED">AED - UAE Dirham</option>
                        <option value="SGD">SGD - Singapore Dollar</option>
                        <option value="ZAR">ZAR - South African Rand</option>
                        <option value="NGN">NGN - Nigerian Naira</option>
                        <option value="BRL">BRL - Brazilian Real</option>
                    </select>
                    @error('currency') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Subtotal</label>
                    <input type="number" step="0.01" wire:model.live="subtotal"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    @error('subtotal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Tax</label>
                    <input type="number" step="0.01" wire:model.live="tax"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none text-black placeholder-gray-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100" />
                    @error('tax') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- Total + Save: stacked full-width on mobile, side-by-side on desktop --}}
            <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                <div class="text-left sm:text-right">
                    <p class="text-xs text-gray-500 uppercase font-bold">Total Amount</p>
                    <p class="text-xl sm:text-2xl font-bold text-gray-900">{{ $currency }} {{ number_format(round($subtotal + $tax, 2), 2) }}</p>
                </div>
                <button wire:click="save" wire:loading.attr="disabled"
                    class="hidden sm:inline-flex px-8 py-3 rounded-xl text-white text-sm font-bold transition hover:-translate-y-0.5 shadow-md"
                    style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
                    <span wire:loading.remove wire:target="save">Save Invoice</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Sticky mobile save bar --}}
    <div class="sm:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 shadow-[0_-4px_12px_rgba(0,0,0,0.05)] p-3 z-30">
        <button wire:click="save" wire:loading.attr="disabled"
            class="w-full py-3 rounded-xl text-white text-sm font-bold transition shadow-md"
            style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
            <span wire:loading.remove wire:target="save">Save Invoice</span>
            <span wire:loading wire:target="save">Saving...</span>
        </button>
    </div>
</div>