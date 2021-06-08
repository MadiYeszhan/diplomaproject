@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="mt-5">{{__('search.drug_search')}}
                    <br>
                    <a href="{{route('main.index')}}" class="ml-4" style="font-size: 14px">{{__('search.main_back')}}</a>
                    <a href="{{route('main.drugs')}}" class="ml-4" style="font-size: 14px">{{__('search.drug_back')}}</a>
                </h1>
                <form action="{{route('searchText')}}" method="get">
                    <section class="w-100 m-auto main-search">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="search_drug" style="border-radius: 10px;" placeholder="{{__('search.search_button')}}" value="{{$search}}" >
                            <button type="submit" class="btn btn-success ml-1" style="border-radius: 10px">{{__('search.search_button')}}</button>
                        </div>
                    </section>
                </form>

                @if(sizeof($results) > 0)
                    @foreach($results as $result)
                        <div class="clearfix  search-result overflow-hidden">
                            <h4>
                                <a href="{{route('main.drugs.details',$result->drug_id)}}">  {{$result->title}}
                                </a>
                                @if($user_disease != null)
                                    @if(App\Models\Contradiction::where('drug_id','=',$result->drug_id)->get()->first()->diseases->first())
                                        @foreach($user_disease as $disease)
                                            @if(App\Models\Contradiction::where('drug_id','=',$result->drug_id)->get()->first()->diseases->contains($disease))
                                                <span style="color: red">{{__('search.drug_contr')}}</span>
                                                @break
                                            @endif
                                        @endforeach
                                    @endif
                                @endif
                            </h4>
                            <p>@if($result->description != null){{$result->description}}) @else  {{__('search.drug_no_lang')}} @endif</p>
                        </div>
                        <br>
                    @endforeach
                    @if ($results->lastPage() > 1)
                            <ul class="pagination">
                                @if(!$results->onFirstPage())
                                <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                                        <a class="page-link" href="{{ $results->url(1)}}&search_drug={{$search}}"><<</a>
                                </li>
                                <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                                    <a class="page-link" href="{{ $results->url($results->currentPage()-1)}}&search_drug={{$search}}"><</a>
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
                                    <a class="page-link" href="{{ $results->url($results->currentPage()+1) }}&search_drug={{$search}}" >></a>
                                </li>
                                <li class="page-item {{ ($results->currentPage() == 1)}}">
                                    <a class="page-link" href="{{ $results->url($results->lastPage())}}&search_drug={{$search}}">>></a>
                                </li>
                                @endif
                            </ul>
                    @endif
                @else
                    <h2>{{__('search.no_results')}}</h2>
                @endif
            </div>
        </div>
    </div>
    <div style="height: 15vw"></div>
@endsection
