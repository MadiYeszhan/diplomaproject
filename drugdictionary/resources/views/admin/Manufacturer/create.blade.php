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
                            <h2>Add new Manufacturer</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('manufacturers.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" name="title" id="title" placeholder="Title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Year foundation</label>
                                <input type="number" name="year_foundation" id="year_foundation" placeholder="Year foundation" class="form-control">
                            </div>

                            <div class="form-group">
                                <label>Year termination</label>
                                <input type="number" name="year_termination" id="year_termination" placeholder="Year termination" class="form-control">
                            </div>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_1">Add English Translation</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_2">Add Russian Translation</button>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_3">Add Kazakh Translation</button>
                            @for($i = 1; $i < 4; $i++)
                                @php
                                $langTitle = '';
                                if ($i == 1){
                                    $langTitle = 'English';
                                 }
                                elseif ($i == 2){
                                    $langTitle = 'Russian';
                                }
                                else{
                                   $langTitle = 'Kazakh';
                                }
                                @endphp
                                <div class="modal fade" id="modal_{{$i}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">{{$langTitle}} translation </h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label class="col-form-label">Description:</label>
                                                    <textarea class="form-control" name="description_{{$i}}"  rows="4" cols="50"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            <div class="form-group mt-2">
                                <button type="submit" class="btn btn-outline-primary btn-lg">Create</button>
                            </div>
                        </form>
                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
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

