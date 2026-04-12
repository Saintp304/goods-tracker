<?php

use Illuminate\Support\Facades\Route;

Route::livewire("/", "pages::home")->name('home');
Route::livewire("/about", "pages::about")->name('about');
Route::livewire("/track", "pages::tracking-page")->name('track');
Route::livewire("/contactUs", "pages::contact-us")->name('contactUs');
Route::livewire("/services/1", "pages::services.air-freight")->name('airFreight');
Route::livewire("/services/2", "pages::services.road-transportation")->name('roadTransport');
Route::livewire("/services/3", "pages::services.sea-freight")->name('seaFreight');