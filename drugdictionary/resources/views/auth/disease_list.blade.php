@extends('layouts.app')
@section('head-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
@section('content')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <div class="container mt-5">
            <h3>Ваш аккаунт</h3>
            <div class="container">
                <div class="row g-0 border rounded  mb-4 position-relative p-3">
                    <div>
                        <h4 class="">Имя пользователя: {{Auth::user()->name}}</h4>
                        <h4 class="">E-mail: {{Auth::user()->email}}</h4>
                        <h4 class="">Дата создания аккаунта: {{Auth::user()->created_at}}</h4>
                        @if(Auth::user()->roles->contains(2))
                            <h4 class="">Ваши роли: @foreach(Auth::user()->roles as $role) {{$role->title}}@if($loop->iteration != $loop->count), @else @endif @endforeach</h4>
                        @endif
                    </div>
                </div>
            </div>
            <hr class="hr">
            <h3>Список противопоказаний</h3>
            <div class="row g-0 border rounded  mb-4 shadow-sm h-md-250 position-relative">
                <div class="container p-3">
                    @if(Auth::user()->diseases->first())
                    <div class="card w-100">
                    <div class="table-responsive">
                        <table class="table" id="disease_table">
                            <thead>
                            <tr>
                                <th class="table-danger">Disease title</th>
                                <th class="w-15 table-danger">Operation</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach(Auth::user()->diseases as $disease)

                            <tr>
                                <td scope="col" class="table-active">
                                    @if($disease->disease_languages->where('language', '=',$lang)->first())
                                        {{$disease->disease_languages->where('language', '=',$lang)->first()->title}}
                                    @else
                                        Disease has no name in picked language
                                    @endif
                                </td>
                                <td scope="col" class="table-active"><form action="{{route('removeDisease',$disease->id)}}" method="post">@csrf @method('DELETE')
                                        <button title="Detach disease" type="submit" class="close text-danger float-left ml-4"><span  aria-hidden="true">&times;</span></button>
                                    </form>
                                </td>
                            </tr>

                            </tbody>
                            @endforeach
                        </table>
                    </div>
                    </div>
                    <br>
                    @else
                        <h2>You have no any disease</h2>
                    @endif
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal">Add</button>
                    <a href="{{route('profile')}}" class="btn btn-outline-secondary">Назад</a>
            </div>
            </div>
        </div>
    </div>
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
                                    @if(!Auth::user()->diseases->contains($disease->disease_id))
                                        <option value="{{$disease->disease_id}}">
                                            {{$disease->title}}
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
    <div class="profile-footer mh-100"></div>
    <script>
        $('#disease_id').selectpicker('render');
    </script>
@endsection
