@extends('layouts.app')
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
                <h3>Настройки</h3>
                <div class="panel row g-0 border rounded  mb-4  position-relative p-3">
                    <div class="container">
                        <p class="text lead fw-normal" style="font-size: 18px">Введите актуальный пароль!</p>
                        <input type="password" class="input" autocomplete="off" class="form-control" placeholder="Актуальный пароль" aria-label="Current password" aria-describedby="button-addon2" style="width: 150px;">
                    </div>
                    <div class="container">
                    <div class="row g-5 py-5">
                        <div class="col-xs-6 col-sm-3">
                            <p class="text lead fw-normal" style="font-size: 18px">Изменить пароль</p>
                            <div class="pb-2">
                            <input type="password" autocomplete="new-password" class="input" class="form-control" placeholder="Новый пароль" aria-label="New password" aria-describedby="button-addon2">
                            </div>
                            <input type="password" autocomplete="off" class="input" class="form-control" placeholder="Подтвердите пароль" aria-label="Confirm password" aria-describedby="button-addon2">
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <p class="text lead fw-normal" style="font-size: 18px">Изменить имя пользователя</p>
                            <div class="pb-2">
                            <input class="input" type="text" class="form-control" placeholder="Новое имя пользователя" aria-label="New Username" aria-describedby="button-addon2">
                            </div>
                        </div>
                    </div>
                        <div class="container">
                            <a href="#" class="btn btn-outline-success">Подтвердить</a>
                            <a href="{{route('profile')}}" class="btn btn-outline-secondary">Назад</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="profile-footer"></div>
@endsection
