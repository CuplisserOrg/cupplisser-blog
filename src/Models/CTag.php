<?php

namespace Cupplisser\Blog\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class CTag extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name'
    ];
    protected $guard = [];

    public function __construct(array $attributes = [])
    {
        $this->table = config('cblog.table.tags');
        parent::__construct($attributes);
    }

    /**
     * Related post records
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->morphedByMany(CPosts::class, "blog_taggables");
    }

    /**
     * Creates a number of tag records from an array of tag names,
     * ignoring any duplicate tags.
     *
     * @param $tags
     * @return array
     */
    public static function createMany($tags)
    {
        $ids = [];

        foreach($tags as $tag)
        {
            // Capitalise the words
            $name = ucwords(strtolower(trim($tag)));
            $tag = self::where("name", $name)->first();

            $siteId = getBlogSiteID();

            // If the tag doesn't exist, create it
            if(!$tag) {
                $tag = self::create([
                    'site_id' => $siteId,
                    'name' => $name
                ]);
            }

            // Add to list
            $ids[] = $tag->id;
        }

        return $ids;
    }

    /**
     * Generates and returns the SEO friendly URL for the tag archive page.
     *
     * @return string
     */
    public function getUrlAttribute()
    {
        $name = str_replace(" ", "-", str_replace("#", "", $this->name));
        return blogUrl("blog/tag/{$this->id}-") . strtolower($name);
    }
}
