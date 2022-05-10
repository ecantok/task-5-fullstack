@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h2>List All Articles</h2>
        </div>
        <div class="col-sm-6">
            <a href="/articles/create" class="btn btn-success float-end"><i class="bi-file-earmark-plus"
                    style="padding-right:5px; font-size: 1rem"></i><span>New article</span></a>
        </div>
    </div>
    <div class="table-responsive-lg">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articles as $article)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $article->title }}</td>
                        <td>{{ $article->user->name }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td>
                            <ul class="d-flex list-inline m-0">
                                <li class="list-inline-item">
                                    <a href="/articles/{{ $article->id }}" class="badge bg-info mx-0-5"><span><i class="bi-eye-fill"></i></span></a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="/articles/{{ $article->id }}/edit" class="badge bg-warning mx-0-5"><span><i class="bi-pencil-square"></i></span></a></i></button>
                                </li>
                                <li class="list-inline-item">
                                    <form action="/articles/{{ $article->id }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button href="/articles/{{ $article->id }}" class="badge bg-danger border-0 mx-0-5" onclick="return confirm('Delete data no. {{ $loop->iteration }}?')"><span><i class="bi-trash-fill"></i></span></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $articles->links() !!}
        </div>
    </div>
@endsection
