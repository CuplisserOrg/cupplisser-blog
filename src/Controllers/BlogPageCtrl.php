<?php namespace Cupplisser\Blog\Controllers;

use Cupplisser\Blog\Models\CPage;
use Cupplisser\Blog\Models\CPosts;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BlogPageCtrl extends Controller{
    public function index()
    {
        $posts = CPage::orderBy("created_at", "DESC")->paginate();
        return view($this->viewPath."pages.index")
          ->with(['pages'=>$posts]);
    }
    public function create(){
        return view($this->viewPath."pages.form")
            ->with("action", route("cblog::pages.store"));
    }
    public function edit($page){
        $page = CPage::find($page);
        return view($this->viewPath."pages.form")
        ->with("page",$page)
            ->with("action", route("cblog::pages.update",[$page]));
    }
    public function store(Request $request)
    {
        $slug = Str::slug($request->title);
        $data = $request->except("_token");
        $data["slug"] = $slug;
        $page = CPage::create($data);

        if ($page) {
            return redirect($this->routePrefix."pages")
            ->with("success", "Page created successfully");
        }
        return redirect()->back()->withError("Data Gagal di simpan");


    }
    public function update(Request $request, CPage $page): RedirectResponse{
        $page->update($request->only(['title', 'content']));

        return redirect()->route('cblog::pages.edit', $page)->withSuccess(__('pages.updated'));
    }
    public function destroy(CPage $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')->withSuccess(__('pages.deleted'));
    }
}
