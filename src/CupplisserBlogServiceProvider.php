<?php

namespace Cupplisser\Blog;

use Illuminate\Support\ServiceProvider;

class CupplisserBlogServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . "/Views/admin", "admin_blog")
    }
}
