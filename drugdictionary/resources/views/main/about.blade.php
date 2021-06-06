@extends('layouts.app')
@section('content')
    <div class="content">
        <div class="container pt-5">

            <h1 class="display-4 fw-normal">{{__('main.about_about_us')}}</h1>
            <p class="lead fw-normal">{{__('main.about_about_us_text')}}</p>

        </div>

        <div class="container">
            <h1 class="display-4 fw-normal">{{__('main.about_about_project')}}</h1>
            <p class="lead fw-normal">{{__('main.about_about_project_text')}}
            </p>
        </div>
    </div>
@endsection
