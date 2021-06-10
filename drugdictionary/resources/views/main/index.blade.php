@extends('layouts.app')
@section('content')
<link href="{{ asset('css/index.css') }}" rel="stylesheet" type="text/css">

<div class="content">
    <form action="{{route('searchText')}}" method="get">
    <section class="w-50 m-auto main-search">
        <div class="input-group mb-3 pb-5">
            <input type="text" class="form-control" name="search_drug" style="border-radius: 10px;" placeholder="{{__('main.search')}}" >
            <button type="submit" class="btn btn-success ml-1" style="border-radius: 10px">{{__('main.search')}}</button>
        </div>
    </section>
    </form>



    <div class="container">
        <div class="row mx-md-n5 justify-content-center">
            <div class="col-6 m-auto pt-1">
            <div class="row g-0 border rounded  mb-4 shadow-sm h-md-250 position-relative ">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-secondary">{{__('main.alphabet_search')}}</strong>
                        <div class="mb-2">
                            @for($i = 0; $i < sizeof($alphabetArr); $i++)
                                <a href="{{route('searchDrugAlphabet',$alphabetArr[$i])}}"> <button type="button" class="btn btn-secondary alphabet-button">{{$alphabetArr[$i]}}</button></a>
                            @endfor
                            <a href="{{route('searchDrugNumber')}}"><button type="button" class="btn btn-secondary alphabet-button">0-9</button></a>
                        </div>
                    </div>
                </div>
        </div>
            {{--*/Find by categories--}}
            <div class="col-4 m-auto pt-1">
                <div class="row border rounded mb-4 pt-2  pb-4 position-relative">
                    <div class="col p-4 d-flex flex-column">
                      <strong class="d-inline-flex mb-2 text-secondary">{{__('main.category_search')}}</strong>
                        <div class="container justify-content-center">
                    <div class="pb-2">
                        <a href="{{route('main.drugs')}}"><button type="button" class="btn btn-outline-secondary button" >{{__('main.drug_section')}}</button></a>
                        <a href="{{route('main.side_effects')}}"><button type="button" class="btn btn-outline-secondary button">{{__('main.side_section')}}</button></a>
                    </div>
                    <div>
                        <a href="{{route('main.diseases')}}"><button type="button" class="btn btn-outline-secondary button">{{__('main.disease_section')}}</button></a>
                        <a href="{{route('main.manufacturers')}}"><button type="button" class="btn btn-outline-secondary button">{{__('main.manufacturer_section')}}</button></a>
                    </div>

                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--*/Project titles--}}
    <div class="container py-5" id="featured-3">
        <div class="row g-5 py-5">
            <div class="feature col-md-4">
                <h3>{{__('main.main_safety')}}</h3>
                <p class="lead fw-normal">{{__('main.main_holder')}}</p>
            </div>

            <div class="feature col-md-4">
                <h3>{{__('main.main_privacy')}}</h3>
                <p class="lead fw-normal">{{__('main.main_holder')}}</p>
            </div>

            <div class="feature col-md-4">
                <h3>{{__('main.main_reliability')}}</h3>
                <p class="lead fw-normal">{{__('main.main_holder')}}</p>
            </div>
        </div>
    </div>

    {{--*/About project--}}
    <div class="container">
            <h1 class="display-4 fw-normal">{{__('main.main_about')}}</h1>
            <p class="lead fw-normal">{{__('main.main_about_text')}}</p>
            <a class="btn btn-outline-secondary" href="{{route('main.about')}}">{{__('main.main_about_more')}}</a>
    </div>
@endsection
