@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/drug.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <section class="w-75 m-auto pt-5 pb-5">
        </section>

        <div class="container">
            <h3 class=" fw-normal">{{__('section.disease_search_title')}}</h3>
            <p class="lead fw-normal">
                {{__('section.disease_search_text')}}
            </p>
        </div>

        <div class="container">
            <form action="{{route('searchDiseaseText')}}" method="get">
                <section class="w-100 m-auto main-search">
                    <div class="input-group mb-3 mt-3">
                        <input type="text" class="form-control" name="search_disease" style="border-radius: 10px;" placeholder="{{__('section.disease_search_title')}}">
                        <button type="submit" class="btn btn-success ml-1" style="border-radius: 10px">{{__('section.search_button')}}</button>
                    </div>
                </section>
            </form>

            <div class="row">
                @php $i = 0; @endphp
                @foreach($diseases as $disease)
                    @if(($i % 5 == 0) or $i == 0)
                     @if($i != 0)</div>@endif
                    <div class="col-3">
                    @endif
                 <h3 class="overflow-hidden"><a href="{{route('main.diseases.details',$disease->disease_id)}}">{{$disease->title}}</a></h3>
                @php $i++; @endphp
                @endforeach
            </div>
            </div>

            @if ($diseases->lastPage() > 1)
                <div>
                <ul class="pagination">
                    @if(!$diseases->onFirstPage())
                        <li class="page-item {{ ($diseases->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $diseases->url(1)}}">{{__('section.pag_first')}}</a>
                        </li>
                        <li class="page-item {{ ($diseases->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $diseases->url($diseases->currentPage()-1)}}">{{__('section.pag_previous')}}</a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $diseases->currentPage()-1; $i++)
                        @if(!($i < ($diseases->currentPage()-3)))
                            <li class="page-item {{ ($diseases->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $diseases->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @for ($i = $diseases->currentPage(); $i <= $diseases->lastPage(); $i++)
                        @if(!($i > ($diseases->currentPage() + 3)))
                            <li class="page-item {{ ($diseases->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $diseases->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @if($diseases->lastPage() != $diseases->currentPage())
                        <li class="page-item {{ ($diseases->currentPage() == $diseases->lastPage()) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $diseases->url($diseases->currentPage()+1) }}" >{{__('section.pag_next')}}</a>
                        </li>
                        <li class="page-item {{ ($diseases->currentPage() == 1)}}">
                            <a class="page-link" href="{{ $diseases->url($diseases->lastPage())}}">{{__('section.pag_last')}}</a>
                        </li>
                    @endif
                </ul>
                </div>
            @endif
        </div>
    <div style="height: 15vw"></div>
@endsection
