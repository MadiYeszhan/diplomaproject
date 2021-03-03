@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <h1 class="mt-4">Search</h1>
                <div class="btn-group" id ="letters">
                </div>
                @foreach($results as $result)
                    <a href="{{route('main.drugs.details',$result->drug_id)}}"> {{$result->title}} </a>
                    <br>
                @endforeach
            </div>
        </div>
    </div>
    @isset($two_letters)
        <script>
            var alphabet = ['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
            var arr = @json($two_letters);
            var letter = "{{$letter}}";
            var alpha_second = [];
            alphabet.forEach(obj => {
                alpha_second.push(letter+obj);
            });

            html_letters = $("#letters");
            alpha_second.forEach(obj => {
                if (arr.some(item => item.letter === obj))
                html_letters.append('<a href="{{route('searchDrugAlphabet','')}}/'+obj+'" class="btn btn-light"> '+obj+'</a>');
                else
                html_letters.append('<a  class="btn btn-light disabled" > '+obj+'</a>');
            });
        </script>
    @endisset
@endsection
