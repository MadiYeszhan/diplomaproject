@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-9">
                <h1 class="mt-4">Admin Panel</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Database editor</li>
                </ol>
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Success!</strong> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="card mb-4">
                    <div class="card-header">
                        Table Categories
                    </div>
                    <div class="card-body ">
                        <a href="{{route('categories.create')}}" class="btn btn-success mb-3">Add</a>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Operation</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cats as $cat)
                                    <tr class="dd">
                                        <td >{{$cat->id}}</td>
                                        <td >{{$cat->name}}</td>
                                        <td><a href="{{route('categories.edit',$cat->id)}}" class="btn btn-info mb-2">Edit</a>

                                            <form action="{{route('categories.destroy',$cat->id)}}"  method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button  type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
