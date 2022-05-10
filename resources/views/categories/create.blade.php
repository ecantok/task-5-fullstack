@extends('layouts.app')

@section('content')
    <div class="row">
        <h2 class="mb-3 border-bottom">Create New Category</h2>
        <div class="col-lg-9">
            <form action="/categories" method="post">
                @csrf
                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" maxlength="255" required autofocus>
                    @error('name')
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

                <!-- Submit -->
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary mb-3">Submit</button>
                </div>
            </form>
        </div>
    </div>
@endsection
