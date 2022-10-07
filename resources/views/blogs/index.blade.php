@extends('layouts.app')

@section('content')
    <div class="container pb-1">
        @auth
            <div class="mb-2 text-end">
                <a href="{{ route('blogs.create') }}" class="btn btn-success">Create</a>
            </div>
        @endauth
        <div>
            @foreach ($posts as $post)
                <div class="list-group">
                    <div class="list-group-item mb-2">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">
                                <a class="text-decoration-none" href="{{ route('blogs.show', ['blog' => $post->id]) }}">{{ $post->title }}</a>
                            </h5>
                            <small class="text-muted"> {{ $post->created_at }}</small>
                        </div>
                        <p class="mb-1">{!!\Illuminate\Support\Str::limit($post->body,100,'....')!!}</p>
                        <small class="text-muted"> Author : {{ $post->user->name }}</small>
                    </div>
                </div>
                {{-- <div class="mb-3 p-2 border rounded">
                    <H3 class="fs-5">{{ $post->title }}</H3>
                    <div class="mt-3 d-flex justify-content-between">
                        <div>
                            {{ $post->created_at }}
                        </div>
                        <div>
                            <a href="{{ route('blogs.show', ['blog' => $post->id]) }}" class="text-decoration-none">Detail</a>
                        </div>
                    </div>
                </div> --}}
            @endforeach
        </div>
    </div>
    <div class="container">
        {{ $posts->links() }}
    </div>
@endsection
