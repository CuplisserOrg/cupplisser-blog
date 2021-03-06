<?php

namespace Cupplisser\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CCategory extends Model
{
    use SoftDeletes;
    protected $table = 'blog_categories';
    protected $fillable = [
        'name',
        'description'
    ];

    public function posts()
    {
        return $this->morphedByMany(CPosts::class, "blog_categoryables");
    }

    /**
     * Generates and returns the SEO friendly URL for the category archive page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        return blogUrl("blog/category/{$this->id}-") . strtolower(str_replace(" ", "-", $this->name));
    }
}
