<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home.index');

Route::get('/auth/{provider}/redirect', [App\Http\Controllers\SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [App\Http\Controllers\SocialiteController::class, 'callback'])->name('socialite.callback');
Route::get('/auth/create-password', [App\Http\Controllers\SocialiteController::class, 'create_password'])->name('create-password');
Route::post('/auth/create-password/update', [App\Http\Controllers\SocialiteController::class, 'create_password_update'])->name('create-password.update');
Route::get('/auth/create-password/skip', [App\Http\Controllers\SocialiteController::class, 'create_password_skip'])->name('create-password.skip');

Route::post('/loadMorePost', [App\Http\Controllers\HomeController::class, 'loadMorePost'])->name('home.loadMorePost');
Route::post('/send-message', [App\Http\Controllers\HomeController::class, 'sendMessage'])->name('home.sendMessage');

Route::get('/image-to-pdf', [App\Http\Controllers\ImageToPdfConverterController::class, 'index'])->name('image-to-pdf.index');
Route::post('/image-to-pdf', [App\Http\Controllers\ImageToPdfConverterController::class, 'convert'])->name('image-to-pdf.convert');

Route::get('/tiktok-saver', [App\Http\Controllers\TikTokSaverController::class, 'index'])->name('tiktok-saver.index');
Route::post('/tiktok-saver', [App\Http\Controllers\TikTokSaverController::class, 'download'])->name('tiktok-saver.download');
