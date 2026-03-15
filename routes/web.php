<?php

use App\Http\Controllers\Auth\SsoController;
use App\Http\Controllers\Public\LandingPageController;
use Illuminate\Support\Facades\Route;


// Halaman Landing Utama (Publik)
Route::get('/', [LandingPageController::class, 'index'])->name('landing');
Route::get('/dokumen/download/{id}', [LandingPageController::class, 'downloadDocument'])->name('public.document.download');
Route::get('/struktur-organisasi/image', [LandingPageController::class, 'showOrgStructureImage'])->name('public.org.image');
Route::get('/akreditasi/download/{id}', [LandingPageController::class, 'downloadAccreditation'])->name('public.accreditation.download');
Route::get('/berita/{slug}', [LandingPageController::class, 'showPost'])->name('public.post.show');
Route::get('/hero-image/file', [LandingPageController::class, 'showHeroImage'])->name('public.hero.image');
Route::get('/berita/image/{id}', [App\Http\Controllers\Public\LandingPageController::class, 'showPostImage'])->name('public.post.image');
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [SsoController::class, 'login']);
Route::post('/logout', [SsoController::class, 'logout'])->name('logout');
