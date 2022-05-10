@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-sm-6">
            <h2>List All Categories</h2>
        </div>
        <div class="col-sm-6">
            <a href="/categories/create" class="btn btn-success float-end"><i class="bi-file-earmark-plus"
                    style="padding-right:5px; font-size: 1rem"></i><span>New category</span></a>
        </div>
    </div>
    <div class="table-responsive-lg">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>User</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category->user->name }}</td>
                        <td>
                            <ul class="d-flex list-inline m-0">
                                <li class="list-inline-item">
                                    <a href="/categories/{{ $category->id }}/edit" class="badge bg-warning mx-0-5"><span><i class="bi-pencil-square"></i></span></a></i></button>
                                </li>
                                <li class="list-inline-item">
                                    <form action="/categories/{{ $category->id }}" method="post" class="d-inline">
                                        @method('delete')
                                        @csrf
                                        <button href="/categories/{{ $category->id }}" class="badge bg-danger border-0 mx-0-5" onclick="return confirm('Delete data no. {{ $loop->iteration }}?')"><span><i class="bi-trash-fill"></i></span></button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {!! $categories->links() !!}
        </div>
    </div>
@endsection
