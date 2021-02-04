@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('admin.sidebar')
            <div class="col-md-9">
                <h1 class="mt-4">Admin Panel</h1>
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item active">Admin statistics</li>
                </ol>
                <h2>Welcome</h2>
            </div>
        </div>
    </div>
@endsection
