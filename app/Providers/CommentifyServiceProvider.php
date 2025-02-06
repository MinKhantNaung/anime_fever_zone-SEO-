<?php

namespace App\Providers;


use Livewire\Livewire;
use App\Models\Comment;
use App\Policies\CommentPolicy;
use Illuminate\Support\Facades\Gate;
use App\Livewire\CommentFeature\Like;
use Illuminate\Support\ServiceProvider;
use App\Livewire\CommentFeature\Comments;
use App\Providers\MarkdownServiceProvider;

class CommentifyServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(CommentPolicy::class, function ($app) {
            return new CommentPolicy;
        });

        Gate::policy(Comment::class, CommentPolicy::class);

        $this->app->register(MarkdownServiceProvider::class);
    }


    /**
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            // Publish config file
            $this->publishes([
                __DIR__ . '/../../config/commentify.php' => config_path('commentify.php'),
            ], 'commentify-config');

            $this->publishes([
                __DIR__ . '/../../tailwind.config.js' => base_path('tailwind.config.js'),
            ], 'commentify-tailwind-config');

            // Add this line to publish your views
            $this->publishes([
                __DIR__ . '/../../resources/views' => resource_path('views/vendor/commentify'),
            ], 'commentify-views');
        }
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'commentify');
        Livewire::component('comments', Comments::class);
        Livewire::component('comment', Comment::class);
        Livewire::component('like', Like::class);
    }
}
