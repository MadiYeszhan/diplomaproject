@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/drug.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <section class="w-75 m-auto pt-5 pb-5">
        </section>

        <div class="container">
            <h3 class=" fw-normal">{{__('search.drug_cat')}} <a href="{{route('main.drugs')}}" class="ml-4" style="font-size: 14px">{{__('search.drug_back')}}</a></h3>
            <p class="lead fw-normal">
                {{__('section.drug_search_text')}}
            </p>
            <div class="">
                <div class="d-flex flex-column position-static">
                    <div class="">
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="btn-group" id ="letters">
            </div>
            @if($results->first() != null)
            <div class="row">
                @php $i = 0; @endphp
                @foreach($results as $drug)
                    @if(($i % 5 == 0) or $i == 0)
                        @if($i != 0)</div>@endif
            <div class="col-3">
                @endif
                <h3 class="overflow-hidden"><a href="{{route('main.drugs.details',$drug->id)}}">{{$drug->title}}</a></h3>
                @php $i++; @endphp
                @endforeach
            </div>
            @else
                <h2>There are no drugs in this category.</h2>
            @endif


        </div>

        @if ($results->lastPage() > 1)
            <div>
                <ul class="pagination">
                    @if(!$results->onFirstPage())
                        <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $results->url(1)}}"> << </a>
                        </li>
                        <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $results->url($results->currentPage()-1)}}"> < </a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $results->currentPage()-1; $i++)
                        @if(!($i < ($results->currentPage()-3)))
                            <li class="page-item {{ ($results->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $results->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @for ($i = $results->currentPage(); $i <= $results->lastPage(); $i++)
                        @if(!($i > ($results->currentPage() + 3)))
                            <li class="page-item {{ ($results->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $results->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @if($results->lastPage() != $results->currentPage())
                        <li class="page-item {{ ($results->currentPage() == $results->lastPage()) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $results->url($results->currentPage()+1) }}" > > </a>
                        </li>
                        <li class="page-item {{ ($results->currentPage() == 1)}}">
                            <a class="page-link" href="{{ $results->url($results->lastPage())}}"> >> </a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
    <div class="container py-5" id="featured-3">
        <div class="row g-5 py-5">
            <div class="feature col-md-4">
                <h3>{{__('section.drug_search_category')}}</h3>
                <ul class="list-unstyled">
                    @foreach($drugCats as $cat)
                        <li><a class="text-secondary links" href="{{route('searchDrugCategory',$cat->id)}}">{{$cat->title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div style="height: 15vw"></div>

@endsection
