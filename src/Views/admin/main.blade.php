@extends('main-blog::base')

@section("body-class", "font-sans antialiased")
@section('style-head')
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    {{-- <link href="{{ asset("css/bootstrap.min.css")}}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset("libs/blogs/css/blog.app.css") }}" >


@endsection
@section('content')
<div class="min-h-screen bg-gray-100">

    <header class="bg-white shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @yield("header")
        </div>
    </header>


    <main role="main" class="container">
        @yield('content-admin')
    </main>
</div>
@endsection

@section('script-end')
    @parent
    <script src="{{ asset("libs/blogs/js/blog.app.js")}}"></script>
    <script src="{{ asset("libs/blogs/js/blog.js")}}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script> --}}
@endsection

