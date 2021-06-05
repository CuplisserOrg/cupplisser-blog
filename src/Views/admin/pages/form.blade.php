@extends("layouts.app")

@section('content')
    <form class="theme-form" action="{{ $action }}" method="post">
        @csrf
        @isset($page)
            @method("PUT")
        @endisset
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Default Form Layout</h5><span>Using the <a href="#">card</a> component, you can extend the
                            default
                            collapse behavior to create an accordion.</span>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="title">Title</label>
                            <input class="form-control" id="title" name="title" type="text" placeholder="Judul" value="{{ isset($page) ? $page->title : null }}">

                            <small class="form-text text-muted" id="emailHelp">
                                We'll never
                                share your email with anyone else.
                            </small>
                        </div>
                        <div class="mb-3">
                            <label class="col-form-label pt-0" for="content">Content</label>
                            <textarea class="form-control" id="content" name="content">{{ isset($page) ? $page->content : null }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button class="btn btn-primary">Simpan</button>
                        <button class="btn btn-secondary">Cancel</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
@endsection

@section('script-end')
    @parent
    <script src="{{ config('cblog.ckeditor.path') }}"></script>
    <script src="{{ asset(config('cblog.ckeditor.custom_config')) }}"></script>
    <script>
        Blog.init_ckeditor();
        CKEDITOR.replace("content")

    </script>

@endsection
