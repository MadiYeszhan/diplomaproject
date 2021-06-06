@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/druginfo.css') }}" rel="stylesheet" type="text/css">
    <div class="content">
        <section class="w-75 m-auto pt-5">
        </section>
        <div class="container">
            <div class="row align-items-start">
                @if($manufacturer != null)
                <div class="container"><h2>{{$manufacturer->title}}</h2>  <a href="{{route('main.manufacturers')}}">Back to manufacturers</a></div>
                <div class="col-md-7">
                    <div class="mt-3">
                        <p class="lead font-weight-bold">Year foundation:</p>
                        <p class="lead fw-normal">
                            {{$manufacturer->year_foundation}}
                        </p>

                        @if($manufacturer->year_termination != null)
                        <p class="lead font-weight-bold">Year termination:</p>
                        <p class="lead fw-normal">
                            {{$manufacturer->year_termination}}
                        </p>
                        @endif

                        <p class="lead font-weight-bold">Description:</p>
                        <p class="lead fw-normal">
                            @if($manufacturerLang != null)
                            {{$manufacturerLang->description}}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
            <div class="container"><h2>No language for disease</h2>  <a href="{{route('main.manufacturers')}}">Back to diseases</a></div>
    @endif
@endsection
