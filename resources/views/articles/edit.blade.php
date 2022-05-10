@extends('layouts.app')

@section('content')
    <div class="row">
        <h2 class="mb-3 border-bottom">Edit Article</h2>
        <div class="col-lg-9">
            <form action="/articles/{{ $article->id }}" method="post" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" class="form-control  @error('title') is-invalid @enderror" id="title" value="{{ old('title', $article->title) }}" maxlength="255" required autofocus>
                    @error('title')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" id="content" cols="30" rows="5" class="form-control  @error('content') is-invalid @enderror" required>{{ old('content', $article->content) }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="hidden" name="oldImage" value="{{ $article->image }}">
                    @if ($article->image)
                        <img class="d-block mb-3 img-fluid" src="{{ asset("storage/". $article->image) }}" alt="{{ $article->title }}">
                    @endif
                    <input type="file" name="image" id="image" aria-describedby="imageDescription" accept=".jpg,.png,.jpeg,.svg"  class="form-control @error('image') is-invalid @enderror">
                    <div id="imageDescription" class="form-text">It will use the old image if you leave it empty.</div>
                    @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Author -->
                <div class="mb-3">
                    <label for="author" class="form-label">Author</label>
                    <input type="text" class="form-control" id="author" value="{{ auth()->user()->name }}" disabled readonly>
                </div>

                <!-- Category -->
                <div class="mb-3">
                    <label for="category_id" class="form-label">Category Name</label>
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary mb-3">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection
