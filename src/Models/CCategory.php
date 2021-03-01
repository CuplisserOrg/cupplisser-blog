<?php

namespace Cupplisser\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description'
    ];

    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, "blog_post_categories",
            "blog_category_id", "blog_post_id");
    }

    /**
     * Generates and returns the SEO friendly URL for the category archive page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return url("blog/category/{$this->id}-") . strtolower(str_replace(" ", "-", $this->name));
    }
}