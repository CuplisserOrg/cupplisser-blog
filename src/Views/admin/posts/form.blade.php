@extends('admin-blog::main')


@section("header")
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Page') }}
</h2>
@endsection
@section('content-admin')
    <div class="py-10">
        <div class="col-md-12">
            <form method="post" action="{{ route('cblog::posts.store') }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" id="title" class="form-control" value="{{ isset($post) ? $post->title : null }}" />
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category" id="categories" class="form-control" data-value="{{ isset($post) ? $post->categories: null }}">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tag">Tag</label>
                            <select name="tags" id="tags" class="form-control" multiple data-value="{{ isset($post) ? $post->tags:null }}">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control">{{ isset($post) ? $post->content : null }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="comments_enabled">Bisa di Komentari</label>
                            <input type="checkbox" name="comments_enabled" value="1" id="comments_enabled" {{ (isset($post) && $post->comments_enabled) ? "checked": null }}/>
                        </div>
                        <div class="form-group">
                            <label for="is_featured">Feature Post</label>
                            <input type="checkbox" name="is_featured" value="1" id="is_featured" {{ (isset($post) && $post->is_featured) ? "checked": null }} />
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" data-value="{{ isset($post) ? $post->status:null }}">>
                              <option value="D">Draft</option>
                              <option value="A">Aktif</option>

                            </select>
                        </div>


                        <div class="form-group">
                            <button class="btn btn-primary">
                                Simpan
                            </button>
                        </div>

                    </div>
                </div>
            </form>
        </div>

    </div>
@endsection

@section('script-end')
    @parent
    <script src="{{ config('cblog.ckeditor.path') }}"></script>
    <script>
            Blog.init_ckeditor();
            Blog.loadCategories();
            Blog.loadTags();
            CKEDITOR.replace('content');
    </script>
@endsection
