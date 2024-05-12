<?php

use App\Livewire\Home;
use App\Livewire\Term;
use App\Livewire\Topic;
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
use App\Livewire\Contact;
use App\Livewire\Section\Index as SectionIndex;

Route::get('/', Home::class)->name('home');
Route::get('/topic/{slug}', Topic::class)->name('topic');
Route::get('/tag/{slug}', TagShow::class)->name('tag');
Route::get('/{slug}/post', PostShow::class)->name('post');
Route::get('/contact/us', Contact::class)->name('contact');

// Email Subscribe
Route::get('/subscriber/verify/{token}/{email}', SubscriberController::class)->name('subscriber_verify');

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
