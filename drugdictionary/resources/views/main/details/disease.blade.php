@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/druginfo.css') }}" rel="stylesheet" type="text/css">
    <div class="content">
        <section class="w-75 m-auto pt-5">
        </section>
        <div class="container">
            <div class="row align-items-start">
                @if($disease != null)
                <div class="container"><h2>{{$disease->title}}</h2></div>
                <div class="col-md-7">
                    <div class="mt-3">
                        <p class="lead font-weight-bold">{{__('details.disease_cat')}}</p>
                        <p class="lead fw-normal">
                            @if($diseaseCat != null)
                                {{$diseaseCat->title}}
                            @else
                                {{__('details.disease_cat_no')}}
                            @endif
                        </p>

                        <p class="lead font-weight-bold">{{__('details.description')}}</p>
                        <p class="lead fw-normal">
                            {{$disease->description}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    @else
            <div class="container"><h2>{{__('details.description_no')}}</h2></div>
    @endif
@endsection
