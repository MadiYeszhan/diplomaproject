@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/druginfo.css') }}" rel="stylesheet" type="text/css">
    <div class="content">
        <section class="w-75 m-auto pt-5">
        </section>
        <div class="container">
            <div class="row align-items-start">
                <div class="container"><h2>{{$drug->title}}</h2> <a href="{{route('main.drugs.details',$drug->drug_id)}}">Back to drug</a> &nbsp;&nbsp; <a href="{{route('main.side_effects')}}">Back to side effects</a></div>
                <div class="col-md-7">
                    <div class="mt-3">
                        <p class="lead font-weight-bold">General side effects:</p>
                        <p class="lead fw-normal">
                            @if($side_effect->first() != null)
                                {{$side_effect->first()->general}}
                            @else
                                Sorry, side effect is unavailable in your language
                            @endif
                        </p>
                        <p class="lead font-weight-bold">Doctor attention side effects:</p>
                        <p class="lead fw-normal">
                            @if($side_effect->first() != null)
                                {{$side_effect->first()->doctor_attention}}
                            @else
                                Sorry, side effect is unavailable in your language
                            @endif
                        </p>
@endsection
