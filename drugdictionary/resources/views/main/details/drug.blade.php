@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="mt-4">Details</h1>
                <h2>{{$drug->id}}</h2>
                <h2>{{$drug->drug_titles()->where('language',$lang)->first()->title}}</h2>
                @if($drugLanguage != null)
                <ul>
                    <li>Description: {{$drugLanguage->description != null ? $drugLanguage->first()->description : 'There is no information about description'}}</li>
                    <li>Composition: {{$drugLanguage->composition != null ? $drugLanguage->first()->composition : 'There is no information about composition'}}</li>
                    <li>Dosage: {{$drugLanguage->dosage != null ? $drugLanguage->dosage : 'There is no information about dosage'}}</li>
                    <li>Dosage: {{$drugLanguage->dosage != null ? $drugLanguage->dosage : 'There is no information about dosage'}}</li>
                </ul>
                    <h2>Pharmacies</h2>
                    @if(sizeof($pharmacies) > 0)
                        @foreach($pharmacies as $pharmacy)
                            <p>{{$pharmacy['pharmacy']}} {{$pharmacy['count']}} {{$pharmacy['available']}} {{$pharmacy['price']}} </p>
                        @endforeach
                    @endif

                    <h2>Comments</h2>
                    @if(!Auth::guest())
                        @if(Auth::user()->mute == null)
                            <a class="btn btn-primary" href="{{route('main.drugs.createComment',$drug->id)}}">Add review</a>
                        @else
                            <p>You have been muted until {{Auth::user()->mute->mute_time}}</p>
                        @endif
                    @else
                        <p>Only authorized users can add an review. </p>
                    @endif


                    @if(sizeof($drug->drug_reviews) > 0)
                        @foreach($drug->drug_reviews as $review)
                            <p>{{$review->comment}} {{$review->rating}} {{$review->user_id}}
                                @if(!Auth::guest())
                                    @if($review->user_id == Auth::user()->id or Auth::user()->roles->contains(2))
                                            <a href="{{route('main.drugs.deleteComment',$review->id)}}" class="text-danger">Delete</a>
                                    @endif
                                    @if(Auth::user()->roles->contains(2))
                                           <a></a> <button data-id="{{$review->user_id}}" data-toggle="modal" data-target="#modal" title="Mute" class="button-link d-inline pb-2 modal-button text-secondary">
                                                Mute
                                            </button>
                                    @endif
                                @endif
                            </p>
                        @endforeach
                    @endif

                @else
                    <h2>No information in the selected language.</h2>
                @endif
            </div>
        </div>
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
