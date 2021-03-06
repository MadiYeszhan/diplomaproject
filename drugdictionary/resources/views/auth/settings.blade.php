@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/profile.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <div class="container mt-5">
            <h3>Your account</h3>
            <div class="container">
                <div class="row g-0 border rounded  mb-4 position-relative p-3">
                    <div>
                        <h4 class="">User name: {{Auth::user()->name}}</h4>
                        <h4 class="">E-mail: {{Auth::user()->email}}</h4>
                        <h4 class="">Account creation date: {{Auth::user()->created_at}}</h4>
                        @if(Auth::user()->roles->contains(2))
                            <h4 class="">Ваши роли: @foreach(Auth::user()->roles as $role) {{$role->title}}@if($loop->iteration != $loop->count), @else @endif @endforeach</h4>
                        @endif
                    </div>
                </div>
            </div>
            <hr class="hr">
                <h3>Settings</h3>
                <form action="{{route('profile.saveSettings')}}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="panel row g-0 border rounded  mb-4  position-relative p-3">
                    <div class="container">
                        <p class="text lead fw-normal" style="font-size: 18px">Enter the current password!</p>
                        <input name="password_actual" type="password" class="input" autocomplete="off" class="form-control" placeholder="Current password" aria-label="Current password" aria-describedby="button-addon2" style="width: 150px;">
                    </div>
                    <div class="container">
                    <div class="row g-5 py-5">
                        <div class="col-xs-6 col-sm-3">
                            <p class="text lead fw-normal" style="font-size: 18px">Change password</p>
                            <div class="pb-2">
                            <input name="password_new" type="password" autocomplete="new-password" class="input" class="form-control" placeholder="New password" aria-label="New password" aria-describedby="button-addon2">
                            </div>
                            <input name="password_repeat" type="password" autocomplete="off" class="input" class="form-control" placeholder="Confirm password" aria-label="Confirm password" aria-describedby="button-addon2">
                        </div>
                        <div class="col-xs-6 col-sm-3">
                            <p class="text lead fw-normal" style="font-size: 18px">Change user name</p>
                            <div class="pb-2">
                            <input name="new_name" class="input" type="text" class="form-control" placeholder="New user name" aria-label="New Username" aria-describedby="button-addon2">
                            </div>
                        </div>
                    </div>
                        <div class="container">
                            <input type="submit" class="btn btn-outline-success" value="Save">
                            <a href="{{route('profile')}}" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </div>
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
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            </div>
        </div>
    </div>
    <div class="profile-footer"></div>
@endsection
