@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/druginfo.css') }}" rel="stylesheet" type="text/css">
    <div class="content">
        <section class="w-75 m-auto pt-5">
        </section>
        <div class="container">
            <div class="row align-items-start">
                @if($disease != null)
                <div class="container"><h2>{{$disease->title}}</h2>  <a href="{{route('main.diseases')}}">Back to diseases</a></div>
                <div class="col-md-7">
                    <div class="mt-3">
                        <p class="lead font-weight-bold">Description:</p>
                        <p class="lead fw-normal">
                            {{$disease->description}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
            <div class="container"><h2>No language for disease</h2>  <a href="{{route('main.diseases')}}">Back to diseases</a></div>
    @endif
@endsection
