<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::livewire("/", "pages::home")->name('home');
Route::livewire("/about", "pages::about")->name('about');
Route::livewire("/track", "pages::tracking-page")->name('track');
Route::livewire("/track/invoice/{trackingNumber}", "pages::public-invoice")->name('track.invoice');
Route::livewire("/track/payment/{trackingNumber}", "pages::public-payment")->name('track.payment');
Route::livewire("/track/receipt/{receiptNumber}", "pages::public-receipt")->name('track.receipt');
Route::livewire("/contactUs", "pages::contact-us")->name('contactUs');
Route::livewire("/services/1", "pages::services.air-freight")->name('airFreight');
Route::livewire("/services/2", "pages::services.road-transportation")->name('roadTransport');
Route::livewire("/services/3", "pages::services.sea-freight")->name('seaFreight');


Route::post('/logout', function () {
  Auth::logout();
  request()->session()->invalidate();
  request()->session()->regenerateToken();
  return redirect('/admin/login');
})->name('logout');

// Admin login (guests only)
Route::middleware('guest')->group(function () {
  Route::livewire('/admin/login', 'pages::auth.login')->name('admin.login');
});

// Protected admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
  Route::livewire('/dashboard', 'pages::admin.dashboard')->name('dashboard');
  Route::livewire('/shipments', 'pages::admin.shipments')->name('shipmentsPage');
  Route::livewire('/shipments/create', 'pages::admin.shipments-create')->name('shipments.create');
  Route::livewire('/shipments/{shipment}/edit', 'pages::admin.shipments-edit')->name('shipments.edit');
  Route::livewire('/shipments/{shipment}/tracking', 'pages::admin.shipments-tracking')->name('shipments.tracking');
  Route::livewire('/messages', 'pages::admin.contact-messages')->name('messages');

  // Financial Management
  Route::livewire('/payments/settings', 'pages::admin.payment-settings')->name('payments.settings');
  Route::livewire('/payments/review', 'pages::admin.payment-review')->name('payments.review');
  Route::livewire('/shipments/{shipment}/invoice', 'pages::admin.shipments.invoice-view')->name('shipments.invoice');
  Route::livewire('/shipments/{shipment}/invoice/create', 'pages::admin.shipments.invoice-form')->name('shipments.invoice.create');

  // General
  Route::livewire('/settings/site', 'pages::admin.site-settings')->name('site-settings');
  Route::livewire('/shipments/{shipment}/payments', 'pages::admin.shipments.payment-form')->name('shipments.payments');
  Route::livewire('/payments/{payment}/receipt', 'pages::admin.payments.receipt-view')->name('payments.receipt');
});