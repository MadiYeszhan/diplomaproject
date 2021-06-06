@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/druginfo.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <section class="w-75 m-auto pt-5 mt-5">
        </section>
        @if($comments->first() != null)
            <div class="container w-50"><a href="{{route('profile')}}">Back to profile </a></div>
        <div style="width:91%" class="d-flex justify-content-center row w-75 m-auto">
            @foreach($comments as $comment)
            <div class="col-md-8">
                <div class="d-flex flex-column comment-section">
                    <div class="bg-white p-2">
                        <h4><a href="{{route('main.drugs.details',$comment->drug_id)}}">
                                @if(\App\Models\DrugTitle::where('drug_id','=',$comment->drug_id)->orderBy('weight')->first() != null)
                                    {{\App\Models\DrugTitle::where('drug_id','=',$comment->drug_id)->orderBy('weight')->first()->title}}
                                @else
                                    There is no title
                                @endif
                            </a></h4>
                        <div class="d-flex flex-row user-info">
                            <div class="d-flex flex-column justify-content-start"><span class="d-block font-weight-bold name">{{\App\Models\User::find($comment->user_id)->name}}</span><span class="date text-black-50"></span></div>
                            <div class="d-flex flex-column justify-content-start ml-2">Rating: {{$comment->rating}} </div>
                        </div>
                        <div class="mt-2">
                            <p class="comment-text">{{$comment->comment}}</p>
                            @if(!Auth::guest())
                                @if($comment->user_id == Auth::user()->id or Auth::user()->roles->contains(2))
                                    <a href="{{route('main.drugs.deleteComment',$comment->id)}}" class="text-danger">Delete</a>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
            <div class="container"><h2>You have not made any drug reviews</h2> <a href="{{route('profile')}}">Back to profile </a></div>
            <div style="height: 10vw"></div>

        @endif
    </div>
    <div style="height: 10vw"></div>
@endsection
