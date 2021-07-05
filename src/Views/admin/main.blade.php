@extends('main-blog::base')

@section('body-class', 'font-sans antialiased')
@section('style-head')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- <link href="{{ asset("css/bootstrap.min.css")}}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('libs/blogs/css/blog.app.css') }}">
    <link rel="stylesheet" href="https://coreui.io/demo/3.4.0/css/style.css">


@endsection
@section('content')

    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-md-down-none">
           Administrasi
        </div>
        @isset($admin_sidebar)
        {!! $admin_sidebar->asUl( ['class' => 'c-sidebar-nav'], ['class' => 'c-sidebar-nav-dropdown-items'] ) !!}
        @endisset
    </div>
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">

        </header>

        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    @yield("content-admin")
                </div>
            </main>
        </div>
        <footer class="c-footer"></footer>
    </div>
@endsection

@section('script-end')
    @parent
    <script src="{{ asset('libs/blogs/js/blog.app.js') }}"></script>
    <script src="{{ asset('libs/blogs/js/blog.js') }}"></script>
    @foreach (config("cblog.assets.js") as $item)
        <script src="{{ $item }}"></script>
    @endforeach
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script> --}}
@endsection
