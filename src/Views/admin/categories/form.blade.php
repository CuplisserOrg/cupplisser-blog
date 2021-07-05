@extends('admin-blog::main')


@section("header")
<h2 class="font-semibold text-xl text-gray-800 leading-tight">
    {{ __('Page') }}
</h2>
@endsection
@section('content-admin')
    <div class="py-10">
        <div class="col-md-12">
            <form method="post" action="{{ route('cblog::categories.store') }}">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Category Namae</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ isset($category) ? $category->name : null }}" />
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <input type="text" name="description" id="description" class="form-control" value="{{ isset($category) ? $category->description : null }}" />
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
