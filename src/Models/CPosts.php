<?php namespace Cupplisser\Blog\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
class CPosts extends Model{
    use SoftDeletes;

    const STATUS_DRAFT = "D";
    const STATUS_ACTIVE = "A";

    const FORMAT_STANDARD = "S";
    const FORMAT_VIDEO = "V";


    protected $fillable = ['author_id','title','slug','content','status','is_approved','approved_by','comments_enabled','published_at','is_featured'];

    public $dates = [
        'published_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function __construct($attributes = array())
    {
        parent::__construct($attributes);
        $this->table = config('cblog.table.posts');
    }

    public function categories()
    {
        return $this->morphToMany(CCategory::class, "blog_categoryable", "blog_categoryable", "blog_categoryable_id", "category_id");
    }

    public function tags()
    {
        return $this->morphToMany(CTag::class, "blog_taggables", "blog_taggables", "blog_taggables_id", "blog_tag_id");
    }

    public function author()
    {
        return $this->belongsTo(User::class, "author_id");
    }

    public function featuredImage()
    {
        return $this->morphOne(CImage::class, "imageable");
    }

    public function comments()
    {
        return $this->morphMany(CComment::class, "commentable");
    }

    public function syncTags($tags)
    {
        // Create tags if needs be
        $ids = CTag::createMany($tags);

        // Sync relations
        $this->tags()->sync($ids);
    }

    public function availableCategories()
    {
        return CCategory::whereNotIn(
            "blog_categories.id",
            $this->categories()->pluck("blog_categories.id")->toArray()
        )->get();
    }

    public function hasCategory(CCategory $category)
    {
        return in_array($category->id, $this->categories()->pluck("blog_categories.id")->toArray());
    }

    public static function processSlug($value)
    {
        $patterns = [
            '/[^a-zA-Z0-9 -]/',
            '/(\s){2,}/',
            '/\s/',
            '/-{2,}/',
        ];

        $replacements = [
            '',
            ' ',
            '-',
            '-',
        ];

        $slug = strtolower(preg_replace($patterns, $replacements, $value));

        if (strlen($slug) > 50) {
            $slug = substr($slug, 0, 50);
        }

        return $slug;
    }

    public function getBriefContent($length = 150)
    {
        $content = substr(strip_tags($this->content), 0, $length);

        if (strlen(strip_tags($this->content)) > $length) {
            $content .= "...";
        }

        return html_entity_decode(trim($content), ENT_COMPAT | ENT_HTML401 | ENT_QUOTES);
    }

    public function getUrlAttribute(){}

    public function getPublishedAttribute()
    {
        return $this->published_at->format("jS F, Y");
    }

    public function getPublishedAtTimestampAttribute()
    {
        return $this->published_at->format("Y-m-d") . "T"
            . $this->published_at->format("H:i");
    }

    public function getAuthorUrlAttribute()
    {
        return blogUrl("blog/author/{$this->author->id}-" . strtolower(str_replace(" ", "-", $this->author->name)));
    }

    public function getStatusNameAttributte()
    {
        return $this->status;
    }

    public function getCategoryPostAttribute(){
      return implode(" ", $this->categories->pluck("name")->toArray());
    }
    public function getTagPostAttribute(){
      return implode(" ,", $this->tags->pluck("name")->toArray());
    }

    public function getCommentsCountAttribute()
    {
        return count($this->comments);
    }

    public function isWithinDays($days = 7)
    {
        $date = strtotime("-$days days");
        $postDate = strtotime($this->published_at);

        return $postDate > $date;
    }

    public function isDraft()
    {
        return $this->status == self::STATUS_DRAFT;
    }

    public function isActive()
    {
        return $this->status == self::STATUS_ACTIVE;
    }
}

