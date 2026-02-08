<?php

use Illuminate\Support\Facades\Route;

Route::livewire("/", "pages::home")->name('home');
Route::livewire("/about", "pages::about")->name('about');
Route::livewire("/tracking", "pages::tracking-page")->name('tracking');