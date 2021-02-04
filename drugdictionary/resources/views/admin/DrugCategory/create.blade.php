@extends('layouts.admin')
@section('head-content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/amsify.suggestags.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery.amsify.suggestags.js') }}"></script>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Add new Drug Category</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('drug_categories.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Title on English</label>
                                <input type="text" name="title_eng" id="title_eng" placeholder="English" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Title on Russian</label>
                                <input type="text" name="title_rus" id="title_rus" placeholder="Russian" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Title on Kazakh</label>
                                <input type="text" name="title_kaz" id="title_kaz" placeholder="Kazakh" class="form-control">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-outline-primary btn-lg">Create</button>
                            </div>
                        </form>
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!!!</strong> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

