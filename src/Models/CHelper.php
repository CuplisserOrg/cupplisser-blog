<?php
namespace Cupplisser\Blog\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class CHelper{
    public function hasPosts(){
        return self::getPublishedPosts()->exists();
    }
    public static function isEmbeddedView()
    {
        return Request::get("embed", false);
    }
    private static function getPublishedPosts()
    {
        $currentDate = date("I") == "0"
            ? date("Y-m-d H:i:s", time() + 3600)
            : date("Y-m-d H:i:s");

        return CPosts::where('status', CPosts::STATUS_ACTIVE)
            ->where('site_id', getBlogSiteID())
            ->where('published_at', '<=', $currentDate);
    }

    public static function posts($count = null, $excludeFeatured = false)
    {
        if (!$count) {
            $count = config("cupplisser-blog.frontend.posts_per_page");
        }

        $query = self::getPublishedPosts();

        if ($excludeFeatured) {
            $query->where('is_featured', false);
        }

        return $query->orderBy("published_at", "desc")
            ->paginate($count);

    }
    
    public static function latestFeatured()
    {
        return self::featuredPosts(1)->first();
    }

    public static function featuredPosts($count = 3, $featuredOnly = false)
    {
        $featured = self::getPublishedPosts()
            ->orderBy('is_featured', 'desc')
            ->orderBy("published_at", "desc");

        if($featuredOnly) {
            $featured = $featured->where('is_featured', true);
        }

        return $featured->limit($count)->get();
    }

    public static function recentPosts($count = 3, $excludeFeatured = false)
    {
        $recent = self::getPublishedPosts()
            ->orderBy("published_at", "desc");

        if ($excludeFeatured) {
            $recent = $recent->where("is_featured", false);
        }

        return $recent->limit($count)->get();
    }

    public static function categories($count = 5)
    {
        $currentDate = date("I") == "0"
            ? date("Y-m-d H:i:s", time() + 3600)
            : date("Y-m-d H:i:s");

        return CCategory::whereHas("posts", function($query) use ($currentDate) {
            $query->where("status", CPosts::STATUS_ACTIVE)
                ->where('site_id', getBlogSiteID())
                ->where('published_at', '<', $currentDate);
        })
            ->limit($count)
            ->get();
    }

    public static function tags($count = 20)
    {
        $currentDate = date("I") == "0" ? date("Y-m-d H:i:s", time() + 3600)
            : date("Y-m-d H:i:s");

        return CTag::whereHas("posts", function($query) use ($currentDate) {
            $query->where("status", CPosts::STATUS_ACTIVE)
                ->where('site_id', getBlogSiteID())
                ->where('published_at', '<', $currentDate);
        })
            ->limit($count)
            ->get();
    }

    public static function archives($count = 12)
    {
        $archive = self::getPublishedPosts()
            ->orderBy('published_at', 'desc')
            ->groupBy(DB::raw('MONTH(published_at), YEAR(published_at)'))
            ->selectRaw('DATE_FORMAT(published_at, "%Y") as year, DATE_FORMAT(published_at, "%M") as month, DATE_FORMAT(published_at, "%m") as url_month, COUNT(id) as articles')
            ->get();

        return $archive->slice(0, $count);
    }

    public static function postsByCategory(CCategory $category, $count = 15)
    {
        return self::getPublishedPosts()
            ->whereHas("categories", function($query) use($category) {
                $query->where("blog_categories.id", $category->id);
            })
            ->orderBy("published_at", "desc")
            ->paginate($count);
    }

    public static function postsByTag(CTag $tag, $count = 15)
    {
        return self::getPublishedPosts()
            ->whereHas("tags", function($query) use($tag) {
                $query->where("blog_tags.id", $tag->id);
            })
            ->orderBy("published_at", "desc")
            ->paginate($count);
    }

    public static function postsByArchive($year, $month = null, $count = 15)
    {
        return self::postsByArchiveWithoutPagination($year, $month)->paginate($count);
    }

    public static function postsByArchiveWithoutPagination($year, $month = null)
    {
        $posts = CPosts::where("status", CPosts::STATUS_ACTIVE)
            ->where('site_id', getBlogSiteID())
            ->whereRaw("YEAR(published_at) = $year");

        if($month) {
            $posts = $posts->whereRaw("MONTH(published_at) = $month");
        }

        $posts = $posts->orderBy("published_at", "desc");

        return $posts;
    }

    public static function postsByAuthor($author, $count = 15)
    {
        return self::getPublishedPosts()
            ->where("author_id", $author->id)
            ->orderBy("published_at", "desc")
            ->paginate($count);
    }

    public static function scheduledPosts()
    {
        $currentDate = date("I") == "0"
            ? date("Y-m-d H:i:s", time() + 3600)
            : date("Y-m-d H:i:s");

        $siteId = getBlogSiteID();

        return CPosts::where("status", CPosts::STATUS_ACTIVE)
            ->where('site_id', $siteId)
            ->where('published_at', '>', $currentDate)
            ->get();
    }

    public function initCKEditor()
    {
        $script = "<script src='".config("cupplisser-blog.posts.ckeditor.path", "")."'></script>
        <script>
            var ckOptions = {}";

        if (config("cupplisser-blog.posts.ckeditor.file_browser_url", null))
        {
            $script .= "
            ckOptions.filebrowserImageBrowseUrl = '". blogUrl(config("cupplisser-blog.posts.ckeditor.file_browser_url")) ."';";
        }

        if (config("cupplisser-blog.posts.ckeditor.image_upload_url", null))
        {
            $script .= "
            ckOptions.filebrowserImageUploadUrl = '". blogUrl(config("cupplisser-blog.posts.ckeditor.image_upload_url") . "?_token=".csrf_token()) ."';";
        }

        if (config("cupplisser-blog.posts.ckeditor.custom_config", null))
        {
            $script .= "
            ckOptions.customConfig = '". config("cupplisser-blog.posts.ckeditor.custom_config") ."';";
        }

        $script .= "
            CKEDITOR.replace(\"post_content\", ckOptions);
        </script>";

        echo $script;
    }
}