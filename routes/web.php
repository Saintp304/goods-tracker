<?php

use Illuminate\Support\Facades\Route;

Route::livewire("/", "pages::home");
Route::livewire("/tracking", "pages::tracking-page") ->name('tracking');