@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="mt-4">Main page</h1>
                <h2>Welcome</h2>
                <form action="{{route('searchText')}}" method="get">
                <div class="input-group mb-1">
                        <input type="text" name="search_drug" class="form-control" placeholder="Search">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
                <div class="input-group mb-3">
                    <p>
                    @foreach($alphabetArr as $letter)
                    <a href="{{route('searchDrugAlphabet',$letter)}}">{{$letter}}</a>
                    @endforeach
                    <a href="{{route('searchDrugNumber')}}">0-9</a>
                    </p>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
