@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="mt-4">Search</h1>
                <form action="{{route('searchText')}}" method="get">
                <div class="input-group mb-3">
                        <input type="text" name="search_drug" class="form-control" placeholder="Search" >
                        <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
                </form>

                @foreach($results as $result)
                    {{$result->title}} {{$result->description}}
                    <br>
                @endforeach
            </div>
        </div>
    </div>
@endsection
