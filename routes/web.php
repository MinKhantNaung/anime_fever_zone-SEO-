<?php

use App\Livewire\Home;
use App\Livewire\Term;
use App\Livewire\Topic;
use Livewire\Volt\Volt;
use App\Livewire\Contact;
use App\Livewire\Privacy;
use App\Livewire\TagShow;
use App\Livewire\PostShow;
use App\Livewire\Tag\Index;
use App\Livewire\Info\About;
use App\Livewire\Profile\Edit;
use App\Livewire\Topic\Create;
use Illuminate\Support\Facades\Route;
use App\Livewire\Post\Index as PostIndex;
use App\Http\Controllers\SubscriberController;
use App\Livewire\Section\Index as SectionIndex;
use App\Livewire\Section\Create as SectionCreate;
use App\Livewire\Section\Edit as SectionEdit;
use App\Livewire\Tag\Edit as TagEdit;

Route::get('/', Home::class)->name('home');
Route::get('/topic/{slug}', Topic::class)->name('topic');
Route::get('/tag/{slug}', TagShow::class)->name('tag');
Route::get('/blog/{slug}', PostShow::class)->name('post');

// Email Subscribe
Route::get('/subscriber/verify/{token}/{email}', SubscriberController::class)->name('subscriber_verify');

// info
Route::middleware('cache.headers:public;max_age=2628000;etag')->group(function () {
    Route::get('/about', About::class)->name('about');
    Route::get('/privacy-policy', Privacy::class)->name('privacy');
    Route::get('/terms', Term::class)->name('term');
    Route::get('/contact/us', Contact::class)->name('contact');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', Edit::class)->name('profile.edit');

    Route::middleware('isBlogger')->group(function () {
        Route::get('/topics', Create::class)->name('topics.create');

        Route::prefix('/blogger')->group(function () {
            Route::get('/tags', Index::class)->name('tags.index');
            Volt::route('/tags/create', 'tags.create')->name('tags.create');
            Route::get('/tags/{tag}/edit', TagEdit::class)->name('tags.edit');

            Route::get('/posts', PostIndex::class)->name('posts.index');
            Route::get('/posts/{post}/sections', SectionIndex::class)->name('sections.index');
            Route::get('/posts/{post}/sections/create', SectionCreate::class)->name('sections.create');
            Route::get('/posts/sections/{section}/edit', SectionEdit::class)->name('sections.edit');
        });
    });
});

require __DIR__.'/auth.php';
