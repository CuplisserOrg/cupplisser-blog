<?php namespace Cupplisser\Blog;

use Illuminate\Support\Facades\Facade;

class CupplisserBlogFacade extends Facade{
    protected static function LaravelBlogFacade()
    {
        return 'cupplisser-blog';
    }
}