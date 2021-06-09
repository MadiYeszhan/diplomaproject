@extends('layouts.admin')
@section('head-content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/amsify.suggestags.css') }}">
    <script type="text/javascript" src="{{ asset('js/jquery.amsify.suggestags.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h2>Add new Link</h2>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{route('pharmacy_links.store')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="drug_id">Drug related to</label>
                                <select class="form-control" name="drug_id" id="drug_id" data-live-search="true" required>
                                    @foreach($drugs as $drug)
                                        <option value="{{$drug->id}}">
                                            @if($drug->drug_titles()->first() == null)
                                                {{$drug->id}}
                                            @else
                                                {{$drug->drug_titles->sortBy(['language','weight'])->first()->title}}
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="pharmacy_number">Pharmacy</label>
                                <select class="form-control" name="pharmacy_number" id="pharmacy_number" required>
                                    <option value="1">Аптека Плюс</option>
                                    <option value="2">Биосфера</option>
                                    <option value="3">Europharma</option>
                                    <option value="4">Талап</option>
                                    <option value="5">Evcalyptus</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <p>Link</p>
                                <textarea name="link" rows="4" cols="100" required></textarea>
                            </div>

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
    <script>$('#drug_id').selectpicker('render');</script>
@endsection

