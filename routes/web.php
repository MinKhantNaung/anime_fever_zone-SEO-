<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\Tag\Index;
use App\Livewire\Topic\Create;

Route::get('/', Home::class)->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('isBlogger')->group(function () {
        Route::get('/topics', Create::class)->name('topics.create');

        Route::get('/blogger/tags', Index::class)->name('tags.index');
    });
});

require __DIR__.'/auth.php';
