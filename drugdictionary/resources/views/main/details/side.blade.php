@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/druginfo.css') }}" rel="stylesheet" type="text/css">
    <div class="content">
        <section class="w-75 m-auto pt-5">
        </section>
        <div class="container">
            <div class="row align-items-start">
                <div class="container"><h2>{{$drug->title}}</h2></div>
                <div class="col-md-7">
                    <div class="mt-3">
                        <p class="lead font-weight-bold">{{__('details.side_general')}}</p>
                        <p class="lead fw-normal">
                            @if($side_effect->first() != null)
                                {{$side_effect->first()->general}}
                            @else
                                {{__('details.description_no')}}
                            @endif
                        </p>
                        <p class="lead font-weight-bold">{{__('details.side_doctor')}}</p>
                        <p class="lead fw-normal">
                            @if($side_effect->first() != null)
                                {{$side_effect->first()->doctor_attention}}
                            @else
                                {{__('details.description_no')}}
                            @endif
                        </p>
@endsection
