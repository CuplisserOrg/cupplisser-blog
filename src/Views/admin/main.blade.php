@extends('main-blog::base')

@section('content')
    @yield('content-admin')
@endsection

@section('script-end')
    @parent
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@endsection

