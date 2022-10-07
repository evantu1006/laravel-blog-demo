@extends('layouts.app')

@section('content')
    <div class="container pb-1">

        <div class="mb-5 pb-5">
            <div class="d-flex justify-content-between">
                <a href="{{ route('blogs.index') }}" class="btn btn-dark">Back</a>
                <div class="d-flex">
                    @if (auth()->check() && auth()->id() == $post->user_id)
                        <a href="{{ route('blogs.edit', ['blog' => $post->id]) }}" class="btn btn-primary me-2">Edit</a>
                        <form action="{{ route('blogs.destroy', ['blog' => $post->id]) }}" method="post">
                            @method('delete')
                            @csrf
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    @endif
                </div>
            </div>
            <h1 class="fs-5 text-center fw-bold">{{ $post->title }}</h1>
            <div class="mt-3 d-flex justify-content-between">
                <div>
                    Author:{{ $post->user->name }}
                </div>
                <div>
                    {{ $post->created_at }}
                </div>
            </div>

            <div class="mt-2">
                <p>{!!$post->body!!}</p>
            </div>


        </div>


    </div>
@endsection
