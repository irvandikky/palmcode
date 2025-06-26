<?php

use App\Livewire\CategoryList;
use App\Livewire\MediaList;
use App\Livewire\PageList;
use App\Livewire\PostList;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('profile', 'profile')->middleware(['auth'])->name('profile');
    Route::get('/posts', PostList::class)->name('posts');
    Route::get('/categories', CategoryList::class)->name('categories');
    Route::get('/pages', PageList::class)->name('pages');
    Route::get('/media', MediaList::class)->name('media');
});


require __DIR__ . '/auth.php';
