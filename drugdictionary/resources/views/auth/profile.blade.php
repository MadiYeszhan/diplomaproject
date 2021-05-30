@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet" type="text/css">

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
        <div class="row justify-content-between pb-5 mt-5 ml-2">
            <div class="col-sm-4">
                <a class="profile-link" href="{{route('profile.settings')}}">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Настройки</h5>
                        <p class="card-text card-profile">Изменение пароля, почтового адресса, имени пользователя.</p>
                    </div>
                </div>
                </a>
            </div>
            <div class="col-sm-4">
                <a class="profile-link" href="{{route('profile.disease_list')}}">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Противопоказания</h5>
                        <p class="card-text card-profile">Выбор противопоказаний для выделения в составах.</p>
                    </div>
                </div>
                </a>
            </div>

            <div class="col-sm-4">
                <a class="profile-link" href="#">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Ваши рецензий</h5>
                        <p class="card-text card-profile">Список рецензий оставленных вами под различными лекарствами.</p>
                    </div>
                </div>
                </a>
            </div>
        </div>
    </div>
    <div class="profile-footer"></div>
@endsection
