<?php namespace Cupplisser\Blog\Controllers;

use Cupplisser\Blog\Models\CPosts;
use Cupplisser\Blog\Requests\BlogPostRequest;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class BlogPostCtrl extends Controller{
    public function index()
    {
        $posts = CPosts::orderBy("is_featured", "desc")
            ->orderBy("published_at", "desc");

        $posts = $posts->paginate(config("cblog.posts.per_page"));
        $context = array('posts'=> $posts);
        return view($this->viewPath."posts.index", $context);
    }

    public function store(BlogPostRequest $request)
    {
        $published_at = $request->published_at
            ? date("Y-m-d H:i:s", strtotime($request->published_at))
            : date("Y-m-d H:i:s", time() - 60);
        $slug = Str::slug($request->title);
        $post = CPosts::create([
            'author_id' => auth()->user() ? auth()->user()->id : null,
            'blog_image_id' => $request->blog_image_id,
            'title' => $request->title,
            'slug' =>  $slug,
            'fb_slug' =>  $slug,
            'content' => $request->post_content,
            'status' => $request->status,
            'format' => CPosts::FORMAT_STANDARD,
            'is_approved' => 1,
            'comments_enabled' => boolval($request->comments_enabled),
            'published_at' => $published_at,
            'is_featured' => boolval($request->get("is_featured", 0))
        ]);

        if($request->category) {
            $post->categories()->sync($request->category);
        }

        if($request->tags) {
            $tags = explode(",", $request->tags);
            $post->syncTags($tags);
        }

        return redirect($this->routePrefix."posts")
            ->with("success", "Blog post created successfully");
    }
    public function update(BlogPostRequest $request, CPosts $post): RedirectResponse{
        $post->update($request->only(['title', 'content', 'posted_at', 'author_id', 'thumbnail_id']));

        return redirect()->route('admin.posts.edit', $post)->withSuccess(__('posts.updated'));
    }

    public function destroy(CPosts $post)
    {
        $post->delete();

        return redirect()->route('admin.posts.index')->withSuccess(__('posts.deleted'));
    }
}