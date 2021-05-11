@extends('layouts.app')
@section('head-content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="mt-4">Add review</h1>
                <h3>{{$drug->drug_titles()->where('language',$lang)->first()->title}}</h3>
                <form action="{{route('main.drugs.storeComment')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Disease or condition</label>
                        <select class="form-control"  name="disease_id" id="disease_id"  data-live-search="true" required>
                            @foreach($diseases as $disease)
                                @if($disease->disease_languages->first())
                                    <option value="{{$disease->id}}">
                                        {{$disease->disease_languages->first()->title}}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Comment:</label>
                        <textarea class="form-control" name="comment"  rows="4" cols="50" required></textarea>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label">Rating:</label>
                        <input  class="form-control" value="0" step="0.5" max="10" min="0" type="number" name="rating" required>
                    </div>
                    <input type="hidden" name="drug_id" value="{{$drug->id}}">
                    <input type="hidden" name="lang" value="{{$lang}}">
                    <div class="input-group">
                    <button type="submit" class="btn btn-primary">Add review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $('#disease_id').selectpicker('render');
    </script>
@endsection
