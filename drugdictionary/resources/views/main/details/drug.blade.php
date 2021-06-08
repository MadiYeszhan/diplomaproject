@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/druginfo.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <section class="w-75 m-auto pt-5">
        </section>
        <div class="container">
            <div class="row align-items-start">
                <div class="container"><h2>{{$drug->drug_titles()->orderBy('weight')->where('language',$lang)->first()->title}}</h2></div>
                @if($drugLanguage != null)
                <div class="col-md-7">
                    <div class="mt-3">
                        <p class="lead font-weight-bold">{{__('details.case')}}</p>
                        @if($disease->first() != null)
                            <p class="lead fw-normal"><a href="{{route('main.diseases.details',$disease->first()->disease_id)}}">{{$disease->first()->title}}</a></p>
                        @else
                            <p class="lead fw-normal">{{__('Disease')}}</p>
                        @endif
                        <p class="lead font-weight-bold">{{__('details.avail')}}</p>
                        <p class="lead fw-normal">{{$drugLanguage->availability}}</p>
                        <p class="lead font-weight-bold">{{__('details.dosage')}}</p>
                        <p class="lead fw-normal">{{$drugLanguage->dosage}}</p>
                        <p class="lead font-weight-bold">{{__('details.comp')}}</p>
                        <p class="lead fw-normal">{{$drugLanguage->composition}}</p>
                        <p class="lead font-weight-bold">{{__('details.description')}}</p>
                        <p class="lead fw-normal">{{$drugLanguage->description}}</p>
                        <p class="lead font-weight-bold">{{__('details.side')}}</p>
                        <p class="lead fw-normal">
                            @if($side_effect->first() != null)
                                {{$side_effect->first()->general}}
                                <a href="{{route('main.side_effects.details',$drug->id)}}">{{__('details.side_more')}}</a>
                            @else
                                {{__('details.side_no')}}
                            @endif
                        </p>

                        <p class="lead font-weight-bold">{{__('details.cont')}}</p>
                        <p class="lead fw-normal">
                            @if($contradiction->first() != null)
                                {{$contradiction->first()->description}}
                            @else
                                {{__('details.cont_no')}}
                            @endif
                        </p>

                        <p class="lead fw-normal">
                            @if($drug->child_contradiction)
                                {{__('details.child_cont')}}
                            @endif
                        </p>

                        <p class="lead fw-normal">
                            @if($drug->pregnancy_contradiction)
                                {{__('details.pregnancy_cont')}}
                            @endif
                        </p>


                        @if($contradiction_diseases->first() != null)
                        <p class="lead fw-normal">
                            {{__('details.cont_list')}}
                        </p>
                        <p class="lead fw-normal">
                            @foreach($contradiction_diseases as $disease)
                                @if($disease->disease_languages->where('language','=',$lang)->first() != null)
                                {{$disease->disease_languages->where('language','=',$lang)->first()->title}}
                                <br>
                                @endif
                            @endforeach
                        </p>
                        @endif





                        <p class="lead font-weight-bold">{{__('details.inter')}}</p>
                        <p class="lead fw-normal">{{$drugLanguage->drug_interaction}}</p>

                        <p class="lead font-weight-bold">{{__('details.special')}}</p>
                        <p class="lead fw-normal">{{$drugLanguage->special_instructions}}</p>

                        @if($related_drug != null)
                            @if($related_drug->first() != null)
                            <p class="lead font-weight-bold">{{__('details.drug_group')}}</p>
                            @foreach($related_drug as $d)
                                <a href="{{route('main.drugs.details',$d->drug_id)}}">{{$d->title}}</a>
                            @endforeach
                            @endif
                        @endif
                    </div>
                </div>
                @else

                    <div class="col-md-7" style="height: 10vw">
                        <div class="mt-3"  >
                            <p class="lead font-weight-bold">{{__('details.description_no')}}</p>
                        </div>
                    </div>

                @endif
                <div class="col">
                    <div class="text-center">
                        <div class="rating-area">
                            <h3>{{__('details.rating')}}</h3>
                            @if($rating != null)
                            <div class="progress position-relative">
                                <div class="progress-bar bg-success" role="progressbar" style="width: {{(number_format($rating, 1, '.', '')/10)*100}}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                <p style="font-size: 14px" class="justify-content-center d-flex position-absolute w-100">{{number_format($rating, 1, '.', '')}}</p>
                            </div>
                            @else
                                {{__('details.rating_no')}}
                            @endif
                        </div>

                        @if($images->first() != null)
                            <h4>{{__('details.image')}}</h4>
                            <div>
                            @foreach($images as $image)
                                @php
                                    $plo = explode('/',$image->image_name)[2];
                                @endphp
                                <a href="{{asset('images/'.$plo)}}" target="_blank"><img src="{{asset('images/'.$plo)}}"  class="rounded mt-2" alt="" style="width: 180px; height: 110px"> </a>
                            @endforeach
                            </div>
                        @endif
                    </div>
                    @if($lang >= 2)
                    @if(sizeof($pharmacies) > 0)
                    <div class="content pt-5">
                        <h4>Лекарство в аптеках</h4>
                        <table class="table table-white table-striped" style="border-radius: 10px">
                            <thead>
                            <tr>
                                <th scope="col">Название аптеки</th>
                                <th scope="col">Доступность</th>
                                <th scope="col">Количество</th>
                                <th scope="col">Цена</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pharmacies as $pharmacy)
                            <tr>
                                <td><a href="{{$pharmacy['pharmacy_link']}}" target="_blank">{{$pharmacy['pharmacy']}} </a></td>
                                <td>{{$pharmacy['available']}}</td>
                                <td>{{$pharmacy['count']}}</td>
                                <td>{{$pharmacy['price']}}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    @endif
                </div>
            </div>
        </div>


        <div class="container mt-5">
            <div class="input-group mb-3">
                @if(!Auth::guest())
                    @if(Auth::user()->mute == null)
                        <a class="btn btn-primary" href="{{route('main.drugs.createComment',$drug->id)}}">{{__('details.add_review')}}</a>
                    @else
                        <p>{{__('details.mute')}} {{Auth::user()->mute->mute_time}}</p>
                    @endif
                @else
                    <p>{{__('details.review_no')}}</p>
                @endif
            </div>
        </div>

        @if($comments->first() != null)
        <div style="width:91%" class="d-flex justify-content-center row  m-auto">
            @foreach($comments as $comment)
            <div class="col-md-8">
                <div class="d-flex flex-column comment-section">
                    <div class="bg-white p-2">
                        <div class="d-flex flex-row user-info">
                            <div class="d-flex flex-column justify-content-start"><span class="d-block font-weight-bold name">{{\App\Models\User::find($comment->user_id)->name}}</span><span class="date text-black-50"></span></div>
                            <div class="d-flex flex-column justify-content-start ml-2">{{__('details.rating')}}: {{$comment->rating}} </div>
                        </div>
                        <div class="mt-2">
                            <p class="comment-text">{{$comment->comment}}</p>
                            @if(!Auth::guest())
                                @if($comment->user_id == Auth::user()->id or Auth::user()->roles->contains(2))
                                    <a href="{{route('main.drugs.deleteComment',$comment->id)}}" class="text-danger">{{__('details.delete_review')}}</a>
                                @endif
                                @if(Auth::user()->roles->contains(2))
                                    <a></a> <button data-id="{{$comment->user_id}}" data-toggle="modal" data-target="#modal" title="Mute" class="button-link d-inline pb-2 modal-button text-secondary">
                                        Mute
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>

    @if(!Auth::guest())
        @if(Auth::user()->roles->contains(2))
            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                Mute user
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('admin.users.mute')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <h3>Mute</h3>
                                <div class="form-group">
                                    <label>Mute until</label>
                                </div>
                                <input type="datetime-local" required name="datetime" id="datetime"/>
                                <input type="hidden" name="user_id" id="user_id" />
                                <button type="submit" class="btn btn-primary">Mute</button>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                $(".modal-button").click(function () {
                    $('#user_id').val($(this).data('id'));
                });
            </script>
        @endif
    @endif
@endsection
