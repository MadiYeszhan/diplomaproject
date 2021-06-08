@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-9">
                <h1 class="mt-4">Admin Panel</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Admin panel</li>
                </ol>
                <h2>Welcome to admin panel</h2>
                <h2 style="color: red">Unauthorized access is denied</h2>
            </div>
        </div>
    </div>
@endsection
