@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="mt-5">Search results for drugs
                    <a href="{{route('main.index')}}" class="ml-4" style="font-size: 14px">Back to main</a>
                    <a class="ml-4" style="font-size: 14px">Back to drugs section</a>
                </h1>
                <form action="{{route('searchText')}}" method="get">
                    <section class="w-100 m-auto main-search">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search_drug" style="border-radius: 10px;" placeholder="Поиск лекарств" value="{{$search}}" >
                            <button type="submit" class="btn btn-success ml-1" style="border-radius: 10px">Поиск</button>
                        </div>
                    </section>
                </form>

                @if(sizeof($results) > 0)
                    @foreach($results as $result)
                        <div class="clearfix search-result overflow-hidden">
                            <h4><a href="#">  {{$result->title}}</a></h4>
                            <p>@if($result->description != null){{$result->description}}) @else There is no description for this drug on picked language @endif</p>
                        </div>
                        <br>
                    @endforeach
                    @if ($results->lastPage() > 1)
                            <ul class="pagination">
                                @if(!$results->onFirstPage())
                                <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $results->url(1)}}&search_drug={{$search}}">First</a>
                                </li>
                                <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $results->url($results->currentPage()-1)}}&search_drug={{$search}}">Previous</a>
                                </li>
                                @endif
                                    @for ($i = 1; $i <= $results->currentPage()-1; $i++)
                                        @if(!($i < ($results->currentPage()-3)))
                                         <li class="page-item {{ ($results->currentPage() == $i) ? ' active' : '' }}">
                                              <a class="page-link" href="{{ $results->url($i) }}&search_drug={{$search}}">{{ $i }}</a>
                                         </li>
                                        @endif
                                    @endfor
                                @for ($i = $results->currentPage(); $i <= $results->lastPage(); $i++)
                                    @if(!($i > ($results->currentPage() + 3)))
                                    <li class="page-item {{ ($results->currentPage() == $i) ? ' active' : '' }}">
                                        <a class="page-link" href="{{ $results->url($i) }}&search_drug={{$search}}">{{ $i }}</a>
                                    </li>
                                    @endif
                                @endfor
                                @if($results->lastPage() != $results->currentPage())
                                <li class="page-item {{ ($results->currentPage() == $results->lastPage()) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $results->url($results->currentPage()+1) }}&search_drug={{$search}}" >Next</a>
                                </li>
                                <li class="page-item {{ ($results->currentPage() == 1)}}">
                                    <a class="page-link" href="{{ $results->url($results->lastPage())}}&search_drug={{$search}}">Last</a>
                                </li>
                                @endif
                            </ul>
                    @endif
                @else
                    <h2>No result found</h2>
                @endif
            </div>
        </div>
    </div>
    <div style="height: 15vw"></div>
@endsection
