<?php

namespace Cupplisser\Blog;

use Illuminate\Support\ServiceProvider;

class CupplisserBlogServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function register()
    {
        if ($this->app['config']->get('cupplisser-blog') === null) {
            $this->app['config']->set('cupplisser-blog', require __DIR__.'/../config/cupplisser-blog.php');
        }
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/cupplisser-blog.php',
            'permission'
        );
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'main-blog');
        $this->loadViewsFrom(__DIR__ . "/Views/admin", "admin_blog");

        // Publish config files
        $this->publishes([
            __DIR__.'/../config/blog.php' => config_path('blog.php'),
        ], 'blog/config');
        
        // Publish config migration files
        $this->publishes([
            __DIR__.'/../database/migrations' => app_path('database/migrations'),
        ], 'laravel-blog/migrations');
        
        // Publish Static Files
        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/lnch/laravel-blog'),
        ], 'laravel-blog/public');
    }
}
