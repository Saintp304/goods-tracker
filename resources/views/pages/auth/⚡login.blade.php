<?php

use Livewire\Attributes\Title;
use App\Models\SiteSetting;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

new #[Title('Admin Login')] class extends Component
{
  public $settings;
  public string $email = '';
  public string $password = '';
  public bool $remember = false;

  public function mount(): void
  {
    $this->settings = SiteSetting::current();
  }

  public function login() {
    $this->validate([
    'email'    => 'required|email',
    'password' => 'required|min:6',
    ]);

    if (!Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
      $this->addError('email', 'Invalid credentials. Try again.');
      return;
    }

    if (!auth()->user()->is_admin) {
      Auth::logout();
      $this->addError('email', 'You are not authorized to access this area.');
      return;
    }

    session()->regenerate();
    return redirect()->intended(route('admin.dashboard'));
  }
};
?>

<div class="min-h-screen flex items-center justify-center px-4" style="background:#f8f7ff; font-family: 'Sora', sans-serif;">
  <link href="https://fonts.googleapis.com/css2?family=Sora:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <style>
    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    .fade-up {
      animation: fadeUp 0.55s ease both;
    }
    .login-btn {
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    }
    .login-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 8px 24px rgba(79,70,229,0.35);
    }
    .input-field:focus {
      outline: none;
      border-color: #4f46e5;
      box-shadow: 0 0 0 3px rgba(79,70,229,0.12);
    }
  </style>

  <div class="fade-up w-full max-w-md">

    <!-- Logo / Brand -->
    <div class="text-center mb-8">
      <div class="inline-flex items-center gap-2 mb-4">
        <img src="{{ Storage::url($settings->logo_path) }}" alt="{{ $settings->site_name }}" class="h-20 w-auto">
      </div>
      <h1 class="text-3xl font-extrabold text-gray-900">Admin Portal</h1>
      <p class="mt-2 text-gray-400 font-light">
        Restricted access. Authorized personnel only.
      </p>
    </div>

    <!-- Card -->
    <div class="bg-white rounded-3xl shadow-xl border border-indigo-50 p-8">

      <!-- Error -->
      @error('email')
      <div class="mb-6 flex items-center gap-3 bg-red-50 border border-red-100 text-red-600 text-sm rounded-xl px-4 py-3">
        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10A8 8 0 1 1 2 10a8 8 0 0 1 16 0zm-7 4a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm-1-9a1 1 0 0 0-1 1v4a1 1 0 1 0 2 0V6a1 1 0 0 0-1-1z" clip-rule="evenodd" />
        </svg>
        {{ $message }}
      </div>
      @enderror

      <div class="space-y-5">
        <!-- Email -->
        <div>
          <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
          <div class="relative">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
              </svg>
            </div>
            <input
            type="email"
            wire:model.defer="email"
            placeholder="admin@trackgoods.com"
            class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 text-gray-800 text-sm transition-all"
            />
        </div>
      </div>

      <!-- Password -->
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-2">Password</label>
        <div class="relative">
          <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
          </div>
          <input
          type="password"
          wire:model.defer="password"
          placeholder="••••••••"
          class="input-field w-full pl-11 pr-4 py-3.5 rounded-xl border border-gray-200 text-gray-800 text-sm transition-all"
          />
      </div>
    </div>

    <!-- Remember me -->
    <div class="flex items-center gap-3">
      <input
      type="checkbox"
      wire:model.defer="remember"
      id="remember"
      class="w-4 h-4 rounded accent-indigo-600 cursor-pointer"
      />
    <label for="remember" class="text-sm text-gray-500 cursor-pointer select-none">
      Keep me signed in
    </label>
  </div>

  <!-- Submit -->
  <button
    wire:click="login"
    wire:loading.attr="disabled"
    class="login-btn w-full py-4 rounded-xl text-white font-bold text-sm mt-2"
    style="background: linear-gradient(135deg, #4f46e5, #3730a3);">
    <span wire:loading.remove>Sign In to Dashboard</span>
    <span wire:loading class="flex items-center justify-center gap-2">
    <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"/>
    </svg>
    Signing in...
    </span>
    </button>
    </div>
    </div>

    <!-- Footer note -->
    <p class="text-center text-xs text-gray-400 mt-6">
    Not an admin? <a href="/" class="text-indigo-500 font-semibold hover:underline">Return to site →</a>
    </p>
    </div>
    </div>