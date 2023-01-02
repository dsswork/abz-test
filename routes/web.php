<?php

use App\Http\Controllers\Front\SiteController;
use App\Http\Controllers\Front\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::resource('users', UserController::class);
