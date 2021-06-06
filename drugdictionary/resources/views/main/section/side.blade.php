@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/drug.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <section class="w-75 m-auto pt-5 pb-5">
        </section>

        <div class="container">
            <h3 class=" fw-normal">Поиск побочных эффектов</h3>
            <p class="lead fw-normal">
                Приведенные ниже ресурсы помогут сузить поиск до конкретной целевой информации о побочных эффектов.
                Информация доступна как потребителям, так и специалистам в области здравоохранения.
            </p>
        </div>

        <div class="container">
            <form action="{{route('searchTextSide')}}" method="get">
                <section class="w-100 m-auto main-search">
                    <div class="input-group mb-3 mt-3">
                        <input type="text" class="form-control" name="search_side" style="border-radius: 10px;" placeholder="Поиск побочных эффектов">
                        <button type="submit" class="btn btn-success ml-1" style="border-radius: 10px">Поиск</button>
                    </div>
                </section>
            </form>

            <div class="row">
                @php $i = 0; @endphp
                @foreach($drugs as $drug)
                    @if(($i % 5 == 0) or $i == 0)
                     @if($i != 0)</div>@endif
                    <div class="col-3">
                    @endif
                 <h3 class="overflow-hidden"><a href="{{route('main.side_effects.details',$drug->drug_id)}}">{{$drug->title}}</a></h3>
                @php $i++; @endphp
                @endforeach
            </div>
            </div>

            @if ($drugs->lastPage() > 1)
                <div>
                <ul class="pagination">
                    @if(!$drugs->onFirstPage())
                        <li class="page-item {{ ($drugs->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $drugs->url(1)}}">First</a>
                        </li>
                        <li class="page-item {{ ($drugs->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $drugs->url($drugs->currentPage()-1)}}">Previous</a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $drugs->currentPage()-1; $i++)
                        @if(!($i < ($drugs->currentPage()-3)))
                            <li class="page-item {{ ($drugs->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $drugs->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @for ($i = $drugs->currentPage(); $i <= $drugs->lastPage(); $i++)
                        @if(!($i > ($drugs->currentPage() + 3)))
                            <li class="page-item {{ ($drugs->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $drugs->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @if($drugs->lastPage() != $drugs->currentPage())
                        <li class="page-item {{ ($drugs->currentPage() == $drugs->lastPage()) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $drugs->url($drugs->currentPage()+1) }}" >Next</a>
                        </li>
                        <li class="page-item {{ ($drugs->currentPage() == 1)}}">
                            <a class="page-link" href="{{ $drugs->url($drugs->lastPage())}}">Last</a>
                        </li>
                    @endif
                </ul>
                </div>
            @endif
        </div>
    <div style="height: 15vw"></div>
@endsection
