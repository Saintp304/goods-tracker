<?php

use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Component;
use App\Models\ContactMessage;

new #[Title('Contact Messages')]
#[Layout('layouts.admin')]
class extends Component
{
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => true]);
    }

    public function markAsUnread($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->update(['is_read' => false]);
    }

    public function delete($id)
    {
        ContactMessage::findOrFail($id)->delete();
    }

    public function with(): array
    {
        return [
            'messages' => ContactMessage::orderBy('created_at', 'desc')->get(),
        ];
    }
};
?>

<div class="space-y-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-8">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900">Contact Messages</h1>
        <div class="flex items-center gap-4">
            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-sm font-semibold">
                {{ ContactMessage::where('is_read', false)->count() }} Unread
            </span>
        </div>
    </div>

    @if(ContactMessage::count() === 0)
        <div class="bg-white rounded-3xl p-8 sm:p-12 text-center border border-dashed border-gray-300">
            <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8"/>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900">No messages yet</h3>
            <p class="text-gray-500 mt-2">When customers reach out, their messages will appear here.</p>
        </div>
    @else
        {{-- MOBILE: Card List (hidden on sm and up) --}}
        <div class="sm:hidden space-y-3">
            @foreach($messages as $message)
                <div class="rounded-2xl border border-gray-200 shadow-sm p-4 space-y-3 {{ $message->is_read ? 'bg-white' : 'bg-indigo-50/50' }}">
                    <div class="flex items-start justify-between gap-2">
                        <div class="min-w-0">
                            <p class="font-bold text-gray-900 truncate">{{ $message->name }}</p>
                            <p class="text-xs text-gray-500 truncate">{{ $message->email }}</p>
                        </div>
                        @if(!$message->is_read)
                            <span class="shrink-0 w-2.5 h-2.5 rounded-full bg-indigo-600 mt-1.5"></span>
                        @endif
                    </div>

                    <div x-data="{ open: false }">
                        <button type="button" @click="open = !open" class="text-left w-full">
                            <p class="text-sm font-medium text-gray-900">{{ $message->subject }}</p>
                            <p class="text-xs text-gray-500 mt-0.5" x-show="!open">{{ Str::limit($message->message, 80) }}</p>
                            <p class="text-xs text-gray-600 mt-0.5 whitespace-pre-line" x-show="open" x-cloak>{{ $message->message }}</p>
                        </button>
                        <button type="button" @click="open = !open" class="text-[10px] font-bold text-indigo-600 mt-1" x-text="open ? 'Show less' : 'Show full message'"></button>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <p class="text-xs text-gray-400">{{ $message->created_at->format('M d, Y H:i') }}</p>
                        <div class="flex items-center gap-1">
                            <button wire:click="markAs{{ $message->is_read ? 'Unread' : 'Read' }}({{ $message->id }})"
                                    class="p-2 rounded-lg hover:bg-gray-200 transition" title="{{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}">
                                <svg class="w-5 h-5 {{ $message->is_read ? 'text-gray-400' : 'text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </button>
                            <button wire:click="delete({{ $message->id }})"
                                    wire:confirm="Are you sure you want to delete this message?"
                                    class="p-2 rounded-lg hover:bg-red-100 text-red-500 transition" title="Delete">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- DESKTOP: Table (hidden below sm) --}}
        <div class="hidden sm:block bg-white rounded-3xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Sender</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Subject</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-sm font-bold text-gray-600 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($messages as $message)
                            <tr class="{{ $message->is_read ? 'bg-white' : 'bg-indigo-50/50' }} hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $message->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $message->email }}</div>
                                </td>
                                <td class="px-6 py-4 max-w-xs" x-data="{ open: false }">
                                    <button type="button" @click="open = !open" class="text-left w-full">
                                        <div class="text-sm font-medium text-gray-900">{{ $message->subject }}</div>
                                        <div class="text-xs text-gray-500 truncate" x-show="!open">{{ Str::limit($message->message, 50) }}</div>
                                        <div class="text-xs text-gray-600 whitespace-pre-line" x-show="open" x-cloak>{{ $message->message }}</div>
                                    </button>
                                    <button type="button" @click="open = !open" class="text-[10px] font-bold text-indigo-600 mt-0.5" x-text="open ? 'Show less' : 'Show full'"></button>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    {{ $message->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <button wire:click="markAs{{ $message->is_read ? 'Unread' : 'Read' }}({{ $message->id }})"
                                            class="p-2 rounded-lg hover:bg-gray-200 transition" title="{{ $message->is_read ? 'Mark as Unread' : 'Mark as Read' }}">
                                        <svg class="w-5 h-5 {{ $message->is_read ? 'text-gray-400' : 'text-indigo-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $message->id }})"
                                            wire:confirm="Are you sure you want to delete this message?"
                                            class="p-2 rounded-lg hover:bg-red-100 text-red-500 transition" title="Delete">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>