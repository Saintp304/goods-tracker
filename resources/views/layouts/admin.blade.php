<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>{{ $title ?? 'Admin' }} — TrackGoods</title>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet" />
@vite(['resources/css/app.css', 'resources/js/app.js'])
@livewireStyles
</head>
<body style="font-family:'Sora',sans-serif; background:#f8f7ff;">

<div x-cloak x-data="{ sidebarOpen: false }" class="flex min-h-screen">

<!-- ===== MOBILE OVERLAY ===== -->
<div
x-show="sidebarOpen"
x-transition:enter="transition-opacity ease-out duration-200"
x-transition:enter-start="opacity-0"
x-transition:enter-end="opacity-100"
x-transition:leave="transition-opacity ease-in duration-150"
x-transition:leave-start="opacity-100"
x-transition:leave-end="opacity-0"
@click="sidebarOpen = false"
class="fixed inset-0 z-30 bg-black/50 md:hidden"
x-cloak>
</div>

<!-- ===== SIDEBAR ===== -->
<aside
:class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
class="fixed top-0 left-0 h-full w-72 z-40 flex flex-col transform transition-transform duration-200 ease-out
md:translate-x-0 md:w-64"
style="background: linear-gradient(180deg, #4f46e5 0%, #3730a3 100%);">

<!-- Brand -->
<div class="px-6 py-5 border-b border-white/10 flex items-center justify-between">
<div class="flex items-center gap-3">
<div class="w-9 h-9 bg-white/20 rounded-xl flex items-center justify-center">
<svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 10V11"/>
</svg>
</div>
<div>
<p class="text-white font-extrabold text-base leading-tight">TrackGoods</p>
<p class="text-indigo-300 text-xs font-light">Admin Panel</p>
</div>
</div>
<!-- Close button (mobile only) -->
<button @click="sidebarOpen = false" class="md:hidden text-indigo-300 hover:text-white transition">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
</svg>
</button>
</div>

<!-- Admin info -->
<div class="px-6 py-4 border-b border-white/10">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0 bg-white/20">
{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
</div>
<div class="min-w-0">
<p class="text-white text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
<p class="text-indigo-300 text-xs truncate">{{ auth()->user()->email }}</p>
</div>
</div>
</div>

<!-- Nav Links -->
<nav class="flex-1 px-4 py-5 space-y-1 overflow-y-auto">

<p class="text-indigo-400 text-xs font-bold uppercase tracking-widest px-3 mb-3">Main</p>

<a href="{{ route('admin.dashboard') }}" @click="sidebarOpen = false"
class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
{{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white shadow-sm' : 'text-indigo-200 hover:bg-white/10 hover:text-white' }}">
<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
</svg>
Dashboard
@if(request()->routeIs('admin.dashboard'))
<span class="ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
@endif
</a>

<a href="{{ route('admin.shipmentsPage') }}" @click="sidebarOpen = false"
class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
{{ request()->routeIs('admin.shipmentsPage') ? 'bg-white/20 text-white shadow-sm' : 'text-indigo-200 hover:bg-white/10 hover:text-white' }}">
<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 10V11"/>
</svg>
Shipments
@if(request()->routeIs('admin.shipmentsPage'))
<span class="ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
@endif
</a>

<p class="text-indigo-400 text-xs font-bold uppercase tracking-widest px-3 mb-3 mt-6">Communication</p>

<a href="{{ route('admin.messages') }}" @click="sidebarOpen = false"
class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
{{ request()->routeIs('admin.messages') ? 'bg-white/20 text-white shadow-sm' : 'text-indigo-200 hover:bg-white/10 hover:text-white' }}">
<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0l-8 8-8-8"/>
</svg>
Messages
@if(request()->routeIs('admin.messages'))
<span class="ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
@endif
</a>
	<p class="text-indigo-400 text-xs font-bold uppercase tracking-widest px-3 mb-3 mt-6">Finance</p>
	<a href="{{ route("admin.payments.settings") }}" @click="sidebarOpen = false"
	class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
	{{ request()->routeIs("admin.payments.settings") ? "bg-white/20 text-white shadow-sm" : "text-indigo-200 hover:bg-white/10 hover:text-white" }}">
	<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
	<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
	</svg>
	Payment Settings
	@if(request()->routeIs("admin.payments.settings"))
	<span class="ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
	@endif
	</a>
	<a href="{{ route("admin.payments.review") }}" @click="sidebarOpen = false"
	class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
	{{ request()->routeIs("admin.payments.review") ? "bg-white/20 text-white shadow-sm" : "text-indigo-200 hover:bg-white/10 hover:text-white" }}">
	<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
	<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
	</svg>
	Payment Review
	@if(request()->routeIs("admin.payments.review"))
	<span class="ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
	@endif
	</a>


    <p class="text-indigo-400 text-xs font-bold uppercase tracking-widest px-3 mb-3 mt-6">General</p>

    <a href="{{ route('admin.site-settings') }}" @click="sidebarOpen = false"
    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all
    {{ request()->routeIs('admin.site-settings') ? 'bg-white/20 text-white shadow-sm' : 'text-indigo-200 hover:bg-white/10 hover:text-white' }}">
    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
    </svg>
    Site Settings
    @if(request()->routeIs('admin.site-settings'))
    <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white"></span>
    @endif
    </a>

</nav>

<!-- Logout -->
<div class="px-4 py-5 border-t border-white/10">
<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit"
class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-indigo-200 hover:bg-red-500/20 hover:text-red-200 text-sm font-medium transition-all group">
<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
</svg>
Sign Out
</button>
</form>
</div>
</aside>

<!-- ===== MAIN CONTENT ===== -->
<div class="flex-1 flex flex-col min-w-0 md:ml-64">

<!-- Top bar -->
<header class="bg-white border-b border-gray-100 px-4 md:px-6 py-4 flex items-center gap-4 sticky top-0 z-20">

<!-- Hamburger (mobile only) -->
<button @click="sidebarOpen = true"
class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl text-gray-500 hover:bg-gray-100 transition flex-shrink-0">
<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
</svg>
</button>

<div class="flex-1 min-w-0">
<h1 class="text-base md:text-lg font-bold text-gray-900 truncate">{{ $title ?? 'Dashboard' }}</h1>
<p class="text-xs text-gray-400 hidden sm:block">
{{ now()->format('l, F j Y') }}
</p>
</div>

<!-- Avatar (desktop) -->
<div class="hidden md:flex items-center gap-3">
<div class="text-right">
<p class="text-sm font-semibold text-gray-700">{{ auth()->user()->name }}</p>
<p class="text-xs text-gray-400">Administrator</p>
</div>
<div class="w-9 h-9 rounded-full flex items-center justify-center text-white text-sm font-bold flex-shrink-0"
style="background:#4f46e5;">
{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
</div>
</div>
</header>

<!-- Page content -->
<main class="flex-1 p-4 md:p-8">
{{ $slot }}
</main>
</div>

</div>

@livewireScripts
</body>
</html>