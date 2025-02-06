<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\MarkdownConverter;

class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton('markdown', function () {
            $environment = new Environment([
                'allow_unsafe_links' => false,
                'html_input' => 'strip'
            ]);

            $environment->addExtension(new CommonMarkCoreExtension);

            return new MarkdownConverter($environment);
        });
    }


    /**
     * @return void
     */
    public function boot(): void {}
}
