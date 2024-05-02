<?php

use App\Livewire\Home;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Livewire\Info\About;
use App\Livewire\Post\Index as PostIndex;
use App\Livewire\PostShow;
use App\Livewire\Privacy;
use App\Livewire\Profile\Edit;
use App\Livewire\Section\Index as SectionIndex;
use App\Livewire\Tag\Index;
use App\Livewire\TagShow;
use App\Livewire\Term;
use App\Livewire\Topic;
use App\Livewire\Topic\Create;

Route::get('/', Home::class)->name('home');
Route::get('/topic/{slug}', Topic::class)->name('topic');
Route::get('/tag/{slug}', TagShow::class)->name('tag');
Route::get('/{slug}/post', PostShow::class)->name('post');

// info
Route::get('/about', About::class)->name('about');
Route::get('/privacy-policy', Privacy::class)->name('privacy');
Route::get('/terms', Term::class)->name('term');

Route::middleware('auth')->group(function () {
    Route::get('/profile', Edit::class)->name('profile.edit');

    Route::middleware('isBlogger')->group(function () {
        Route::get('/topics', Create::class)->name('topics.create');

        Route::get('/blogger/tags', Index::class)->name('tags.index');

        Route::get('/blogger/posts', PostIndex::class)->name('posts.index');
        Route::get('/blogger/posts/{post}/sections', SectionIndex::class)->name('sections.index');
    });
});

require __DIR__.'/auth.php';
