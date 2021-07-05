<?php namespace Cupplisser\Blog\Controllers;

use Cupplisser\Blog\Models\CPosts;
use Cupplisser\Blog\Requests\BlogPostRequest;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogPostCtrl extends Controller{
    public function index()
    {
        $posts = CPosts::paginate();
        return view($this->viewPath."posts.index")
          ->with(['posts'=>$posts]);
    }
    public function create(){
        return view($this->viewPath."posts.form")
        ->with("action","create")
        ->with("action_url", route("cblog::posts.store"))
        ;
    }
    public function edit(CPosts $post){
      return view($this->viewPath."posts.form")
        ->with("action","edit")
      ->with("action_url", route("cblog::posts.update",[$post->id]))
      ->with("post",$post);
    }
    public function store(BlogPostRequest $request)
    {
        $published_at = $request->published_at
            ? date("Y-m-d H:i:s", strtotime($request->published_at))
            : date("Y-m-d H:i:s", time() - 60);
        $slug = Str::slug($request->title);
        $post = CPosts::create([
            'author_id' => auth()->user()->id ?? null,
            'title' => $request->title,
            'slug' =>  $slug,
            'content' => $request->post('content'),
            'status' => $request->status,
            'format' => CPosts::FORMAT_STANDARD,
            'is_approved' => 0,
            'comments_enabled' => boolval($request->comments_enabled),
            'published_at' => $published_at,
            'is_featured' => boolval($request->post("is_featured", 0))
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
        $result = $post->update($request->only(['title', 'content', 'posted_at', 'author_id', 'status']));
        // dd($result);

        return redirect()->route('cblog::posts.edit', $post)->withSuccess(__('posts.updated'));
    }
    public function destroy(CPosts $post)
    {
        $post->delete();

        return redirect()->route('cblog::posts.index')->withSuccess(__('posts.deleted'));
    }
}
