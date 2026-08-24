<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\Shipment;
use App\Models\Invoice;
use App\Services\FinancialService;

new #[Title('View Invoice')]
#[Layout('layouts.admin')]
class extends Component
{
    public Shipment $shipment;
    public ?Invoice $invoice = null;
    public float $paidAmount = 0;
    public float $balance = 0;

    public function mount(Shipment $shipment, FinancialService $financialService): void
    {
        $this->shipment = $shipment;
        $this->invoice = $shipment->invoice;

        if ($this->invoice) {
            $this->paidAmount = $financialService->getTotalCompletedPayments($this->invoice);
            $this->balance = $financialService->calculateRemainingBalance($this->invoice);
        }
    }
};
?>

<div class="max-w-4xl mx-auto space-y-6 pb-12">
    <div class="flex justify-between items-center no-print">
        <a href="{{ route('admin.shipments.edit', $shipment->id) }}" wire:navigate
            class="px-4 py-2 rounded-xl text-sm font-semibold text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 transition">
            ← Back to Shipment
        </a>
        <div class="flex gap-3">
            <a href="{{ route('admin.shipments.invoice.create', $shipment->id) }}" wire:navigate
                class="px-4 py-2 rounded-xl text-sm font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 transition border border-indigo-100">
                Edit Invoice
            </a>
            <button onclick="window.print()"
                class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gray-900 hover:bg-black transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4m8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4m4 0h4"/>
                </svg>
                Print Invoice
            </button>
        </div>
    </div>

    @if(!$invoice)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">No Invoice Found</h2>
            <p class="text-gray-500 mb-6">An invoice has not been created for this shipment yet.</p>
            <a href="{{ route('admin.shipments.invoice.create', $shipment->id) }}" wire:navigate
                class="px-6 py-3 rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 text-sm font-bold transition">
                Create Invoice Now
            </a>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 md:p-12 print:border-0 print:shadow-none" id="invoice-document">
            {{-- Invoice Header --}}
            <div class="flex flex-col md:flex-row justify-between items-start gap-8 mb-12">
                <div class="flex flex-col gap-2">
                    <h1 class="text-4xl font-black text-gray-900 uppercase tracking-tighter mb-2">Invoice</h1>
                    <div class="flex items-center gap-3">
                        <p class="text-sm font-mono text-gray-500"># {{ $invoice->invoice_number }}</p>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider
                            {{ $invoice->status === 'PAID' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $invoice->status === 'OPEN' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $invoice->status === 'PARTIALLY_PAID' ? 'bg-yellow-100 text-yellow-700' : '' }}
                            {{ $invoice->status === 'CANCELLED' ? 'bg-gray-200 text-gray-700' : '' }}">
                            {{ $invoice->getStatusLabel() }}
                        </span>
                        @if($invoice->isOverdue())
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-red-100 text-red-700">
                                Overdue
                            </span>
                        @endif
                    </div>
                </div>
                <div class="text-left md:text-right">
                    <h2 class="text-xl font-bold text-gray-900">Goods Tracker Ltd.</h2>
                    <p class="text-sm text-gray-500">123 Logistics Way, Shipping City</p>
                    <p class="text-sm text-gray-500">contact@goodstracker.com</p>
                    <p class="text-sm text-gray-500">+1 (555) 000-1111</p>
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-12 mb-12">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Bill To</p>
                    <p class="text-lg font-bold text-gray-900">{{ $shipment->receiver_name }}</p>
                    <p class="text-sm text-gray-600 leading-relaxed">
                        {{ $shipment->receiver_address }}<br>
                        {{ $shipment->receiver_country }}<br>
                        Phone: {{ $shipment->receiver_phone }}
                    </p>
                </div>
                <div class="md:text-right">
                    <div class="grid grid-cols-2 gap-x-4 text-sm">
                        <p class="text-gray-400 font-medium">Issue Date:</p>
                        <p class="text-gray-900 font-semibold">{{ $invoice->issue_date->format('M d, Y') }}</p>
                        <p class="text-gray-400 font-medium">Due Date:</p>
                        <p class="text-gray-900 font-semibold">{{ $invoice->due_date->format('M d, Y') }}</p>
                        <p class="text-gray-400 font-medium">Tracking #:</p>
                        <p class="text-gray-900 font-mono font-bold">{{ $shipment->tracking_number }}</p>
                    </div>
                </div>
            </div>

            {{-- Shipment Details --}}
            <div class="mb-12">
                <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-4 border-b pb-2">Shipment Details</h3>
                <div class="grid grid-cols-2 gap-y-4 text-sm">
                    <div class="text-gray-400">Origin</div>
                    <div class="text-gray-900 font-semibold">{{ $shipment->origin }}</div>
                    <div class="text-gray-400">Destination</div>
                    <div class="text-gray-900 font-semibold">{{ $shipment->destination }}</div>
                    <div class="text-gray-400">Package</div>
                    <div class="text-gray-900 font-semibold">{{ $shipment->package_description }} ({{ $shipment->package_type }})</div>
                    <div class="text-gray-400">Weight/Qty</div>
                    <div class="text-gray-900 font-semibold">{{ $shipment->package_weight }} / {{ $shipment->package_quantity }}</div>
                </div>
            </div>

            {{-- Financial Table --}}
            <div class="mb-12">
                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b-2 border-gray-900">
                            <th class="py-3 text-sm font-bold text-gray-900 uppercase">Description</th>
                            <th class="py-3 text-sm font-bold text-gray-900 uppercase text-right">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        <tr class="border-b border-gray-100">
                            <td class="py-4 text-gray-600">Shipping & Handling Services</td>
                            <td class="py-4 text-right text-gray-900 font-medium">{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</td>
                        </tr>
                        <tr class="border-b border-gray-100">
                            <td class="py-4 text-gray-600">Taxes & Duties</td>
                            <td class="py-4 text-right text-gray-900 font-medium">{{ $invoice->currency }} {{ number_format($invoice->tax, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="flex justify-end">
                <div class="w-full md:w-64 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-gray-900 font-medium">{{ $invoice->currency }} {{ number_format($invoice->subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-500">Tax</span>
                        <span class="text-gray-900 font-medium">{{ $invoice->currency }} {{ number_format($invoice->tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-xl font-bold border-t-2 border-gray-900 pt-3 text-gray-900">
                        <span>Total</span>
                        <span>{{ $invoice->currency }} {{ number_format($invoice->total, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm pt-2">
                        <span class="text-gray-500">Amount Paid</span>
                        <span class="text-green-600 font-semibold">{{ $invoice->currency }} {{ number_format($paidAmount, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-lg font-bold border-t border-gray-200 pt-2 text-gray-900">
                        <span>Balance Due</span>
                        <span class="{{ $balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $invoice->currency }} {{ number_format($balance, 2) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Payment Status Footer --}}
            <div class="mt-16 p-6 rounded-2xl {{ $invoice->status === 'PAID' ? 'bg-green-50 border border-green-100' : 'bg-gray-50 border border-gray-100' }}">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Payment Status</p>
                        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                            {{ $invoice->status === 'PAID' ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
                            {{ $invoice->getStatusLabel() }}
                        </span>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Remaining Balance</p>
                        <p class="text-lg font-bold {{ $balance > 0 ? 'text-red-600' : 'text-green-600' }}">
                            {{ $invoice->currency }} {{ number_format($balance, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<style>
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .max-w-4xl { max-width: 100% !important; width: 100% !important; margin: 0 !important; padding: 0 !important; }
        #invoice-document { border: 0 !important; box-shadow: none !important; padding: 0 !important; }
    }
</style>
