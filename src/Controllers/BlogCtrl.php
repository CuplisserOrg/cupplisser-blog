<?php

namespace Cupplisser\Blog\Controllers;

use Cupplisser\Blog\Models\CCategory;
use Cupplisser\Blog\Models\CComment;
use Cupplisser\Blog\Models\CPosts;
use Cupplisser\Blog\Models\CTag;
use Illuminate\Http\Request;

class BlogCtrl extends Controller{
    public function index(){
        return view('admin-blog:index');
    }

    public function show($slug)
    {
        # code...
    }

    public function postComment(CPosts $post, Request $request)
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
            'status' => config("cblog.comments.requires_approval")
                ? CComment::STATUS_PENDING_APPROVAL : CComment::STATUS_APPROVED,
        ]);

        return redirect(blogUrl("$post->id/$post->slug" . "#post-comments", true));
    }


    public function loadCategories(Request $request)
    {
        return CCategory::get();
    }
    public function loadTags(Request $request)
    {
        return CTag::get();
    }
}
