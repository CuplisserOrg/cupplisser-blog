<?php

namespace Cupplisser\Blog\Controllers;
use Illuminate\Http\Request;

class BlogCtrl extends Controller{
    public function index(){
        return 
    }

    public function show($slug)
    {
        # code...
    }

    public function postComment(BlogPost $post, Request $request)
    {
        $this->validate($request, [
            'name' => 'sometimes|string|max:200',
            'email' => 'sometimes|email|max:150',
            'comment' => 'required|string|max:65000',
            'parent_id' => 'sometimes',
        ]);

        $post->comments()->create([
            'name' => $request->name,
            'email' => $request->email,
            'parent_id' => $request->parent_id,
            'user_id' => auth()->id(),
            'body' => $request->comment,
            'status' => config("laravel-blog.comments.requires_approval")
                ? Comment::STATUS_PENDING_APPROVAL : Comment::STATUS_APPROVED,
        ]);

        return redirect(blogUrl("$post->id/$post->slug" . "#post-comments", true));
    }
}