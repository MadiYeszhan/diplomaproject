@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/drug.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <section class="w-75 m-auto pt-5 pb-5">
        </section>

        <div class="container">
            <h3 class=" fw-normal">Производители</h3>
            <p class="lead fw-normal">
                Приведенные ниже ресурсы помогут сузить поиск до конкретной целевой информации о производителях.
                Информация доступна как потребителям, так и специалистам в области здравоохранения.
            </p>
        </div>

        <div class="container">
            <div class="row">
                @php $i = 0; @endphp
                @foreach($manuf as $man)
                    @if(($i % 5 == 0) or $i == 0)
                     @if($i != 0)</div>@endif
                    <div class="col-3">
                    @endif
                 <h3 class="overflow-hidden"><a href="{{route('main.manufacturers.details',$man->id)}}">{{$man->title}}</a></h3>
                @php $i++; @endphp
                @endforeach
            </div>
            </div>

            @if ($manuf->lastPage() > 1)
                <div>
                <ul class="pagination">
                    @if(!$manuf->onFirstPage())
                        <li class="page-item {{ ($manuf->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $manuf->url(1)}}">First</a>
                        </li>
                        <li class="page-item {{ ($manuf->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $manuf->url($manuf->currentPage()-1)}}">Previous</a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $manuf->currentPage()-1; $i++)
                        @if(!($i < ($manuf->currentPage()-3)))
                            <li class="page-item {{ ($manuf->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $manuf->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @for ($i = $manuf->currentPage(); $i <= $manuf->lastPage(); $i++)
                        @if(!($i > ($manuf->currentPage() + 3)))
                            <li class="page-item {{ ($manuf->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $manuf->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @if($manuf->lastPage() != $manuf->currentPage())
                        <li class="page-item {{ ($manuf->currentPage() == $manuf->lastPage()) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $manuf->url($manuf->currentPage()+1) }}" >Next</a>
                        </li>
                        <li class="page-item {{ ($manuf->currentPage() == 1)}}">
                            <a class="page-link" href="{{ $manuf->url($manuf->lastPage())}}">Last</a>
                        </li>
                    @endif
                </ul>
                </div>
            @endif
        </div>
    <div style="height: 15vw"></div>
@endsection
