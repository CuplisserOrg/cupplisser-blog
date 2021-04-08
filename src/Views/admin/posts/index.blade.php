@extends('admin-blog::layout')

@section('content-admin')
    <div class="">

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table table-auto w-full">
                    <thead>
                        <tr>
                            <td class="p-4 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">#</td>
                            <td class="p-4 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Title</td>
                            <td class="p-4 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Category</td>
                            <td class="p-4 font-bold uppercase bg-gray-200 text-gray-600 border border-gray-300 hidden lg:table-cell">Comments</td>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($posts as $k => $v)
                    <tr class="bg-white lg:hover:bg-gray-100 flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static"></td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $v->title }}</td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $v->categories }}</td>
                        <td class="w-full lg:w-auto p-3 text-gray-800 text-center border border-b block lg:table-cell relative lg:static">{{ $v->comments }}</td>
                    </tr>
                    @empty
                        Artikel tidak di temukan
                    @endforelse
                    </tbody>

                </table>

            </div>
        </div>

    </div>
</div>

    </div>
@endsection
