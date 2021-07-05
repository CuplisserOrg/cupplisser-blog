<?php namespace Cupplisser\Blog\Controllers;

use Cupplisser\Blog\Models\CTag;

class BlogTagCtrl extends Controller{
    public function index()
    {
        $tags = CTag::paginate(config("cblog.tags.per_page"));

        return view($this->viewPath."tags.index", [
            'tags' => $tags
        ]);
    }

    public function store()
    {
        # code...
    }

    public function update()
    {
        # code...
    }

    public function destroy()
    {
        # code...
    }
}
