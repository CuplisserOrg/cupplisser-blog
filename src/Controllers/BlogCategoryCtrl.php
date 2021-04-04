<?php namespace Cupplisser\Blog\Controllers;
use Cupplisser\Blog\Models\CCategory;
use Cupplisser\Blog\Requests\BlogCategoryRequest;
use Illuminate\Http\Client\Request;

class BlogCategoryCtrl extends Controller{
    public function index()
    {
        # code...
        if(auth()->user()->cannot("view", CCategory::class)) {
            abort(403);
        }

        $categories = CCategory::paginate(config("laravel-blog.categories.per_page"));

        return view($this->viewPath."categories.index", [
            'categories' => $categories
        ]);
    }

    public function create()
    {
        if(auth()->user()->cannot("create", CCategory::class)) {
            abort(403);
        }

        return view($this->viewPath."categories.create");
    }

    public function store(BlogCategoryRequest $request)
    {
        if(auth()->user()->cannot("create", CCategory::class)) {
            abort(403);
        }

        // If the category has previously been deleted, we'll restore it
        $trashed = CCategory::where("name", $request->name)
            ->withTrashed()
            ->first();

        if($trashed){
            $trashed->restore();
        }else{
            CCategory::create([
                'site_id'       => getBlogSiteID(),
                'name'          => $request->name,
                'description'   => $request->description
            ]);
        }

        return redirect($this->routePrefix."categories")
            ->with("success", "Category created successfully");
    }

    public function edit(CCategory $category)
    {
        if(auth()->user()->cannot("edit", $category)) {
            abort(403);
        }

        return view($this->viewPath."categories.edit", compact("category"));

    }

    public function update(BlogCategoryRequest $request, CCategory $category)
    {
        if(auth()->user()->cannot("edit", $category)) {
            abort(403);
        }

        $siteId = getBlogSiteID();

        $category->update($request->only(['name', 'description']));

        return redirect($this->routePrefix."categories")
            ->with("success", "Category updated successfully");
    }

    public function destroy(CCategory $category)
    {
        if(auth()->user()->cannot("delete", $category)) {
            abort(403);
        }

        $category->delete();

        return redirect($this->routePrefix."categories")
            ->with("success", "Category deleted successfully");
    }
}