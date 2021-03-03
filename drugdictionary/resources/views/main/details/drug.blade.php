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
                @else
                    <h2>No information in the selected language.</h2>
                @endif
            </div>
        </div>
    </div>
@endsection
