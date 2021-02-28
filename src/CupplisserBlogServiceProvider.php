<?php

namespace Cupplisser\Blog;

use Illuminate\Support\ServiceProvider;

class CupplisserBlogServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function register()
    {
        if ($this->app['config']->get('cupplisser-blog') === null) {
            $this->app['config']->set('cupplisser-blog', require __DIR__.'/../config/config.php');
        }
        // Merge config
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            'permission'
        );

        $this->app->bind('cupplisser-blog', function() {
            return new Models\CHelper;
        });

        include __DIR__.'/Routes/web.php';
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'main-blog');
        $this->loadViewsFrom(__DIR__ . "/Views/admin", "admin_blog");

        // Publish config files
        $this->publishes([
            __DIR__.'/../config/config.php' => config_path('cblog.php'),
        ], 'cblog-config');
        
        // Publish config migration files
        $this->publishes([
            __DIR__.'/../database/migrations' => base_path('database/migrations'),
        ], 'cblog-migrations');
        
        // Publish Static Files
        $this->publishes([
            __DIR__.'/../public' => public_path(),
        ], 'cblog-public');
    }
}
