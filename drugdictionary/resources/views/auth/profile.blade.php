@extends('layouts.app')
@section('head-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
@section('content')
    <div class="content">
        <section class="w-50 m-auto">
            <h1>Profile</h1>
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h2>Diseases</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if(Auth::user()->diseases->first())
                        @foreach(Auth::user()->diseases as $disease)
                            <form action="{{route('removeDisease',$disease->id)}}" method="post">@csrf @method('DELETE')
                            <div class="row mb-3">
                                <div class="col-5">{{$disease->id}}</div>
                                <div class="col-7">
                                        <button title="Detach disease" type="submit" class="close text-danger " aria-label="Close"><span  aria-hidden="true">&times;</span></button>
                                </div>
                                </div>
                            </form>
                        @endforeach
                    @else
                        <h2>You did not add any diseases</h2>
                    @endif
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">Add</button>
                </div>
                <p>{{Auth::user()->role}}</p>



                <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">
                                    Add disease
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            <form action="{{route('addDisease')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <h3>Disease</h3>
                                <div class="form-group">
                                    <label>Disease</label>
                                    <select class="form-control"  name="disease_id" id="disease_id"  data-live-search="true">
                                        @foreach($diseases as $disease)
                                            @if($disease->disease_languages->first())
                                            <option value="{{$disease->id}}">
                                                {{$disease->disease_languages->first()->title}}
                                            </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $('#disease_id').selectpicker('render');
    </script>
@endsection
