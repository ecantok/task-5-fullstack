@extends('layouts.app')

@section('content')
    <div class="col-lg-8 mt-3">
        <h1 class="mb-3">{{ $article->title }}</h1>
        <div class="d-flex">
            <a href="/articles" class="btn btn-info mx-1"><span><i class="bi-arrow-left"></i></span> Back to article</a>
            <a href="/articles/{{ $article->id }}/edit" class="btn btn-warning mx-1"><span><i class="bi-pencil-square"></i></span> Edit</a>
            <form action="/articles/{{ $article->id }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger mx-1" onclick="return confirm('Delete this article?')"><span><i class="bi-trash-fill"></i></span> Delete</button>
            </form>
        </div>
        <img src="{{ asset('storage/' . $article->image) }}" alt="{{ $article->title }}" class="img-fluid mt-3 mb-3">
        <h6>By: {{ $article->user->name }}</h6>
        <h6>Category: {{ $article->category->name }}</h6>

        <article class="my-3 fs-6">
            {!! $article->content !!}
        </article>
    </div>
@endsection
