@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/drug.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <section class="w-75 m-auto pt-5 pb-5">
        </section>

        <div class="container">
            <h3 class=" fw-normal">Поиск лекарств от А до Я <a href="{{route('main.drugs')}}" class="ml-4" style="font-size: 14px">Back to drugs section</a></h3>
            <p class="lead fw-normal">
                Приведенные ниже ресурсы помогут сузить поиск до конкретной целевой информации о лекарствах.
                Информация доступна как потребителям, так и специалистам в области здравоохранения.
            </p>
            <div class="">
                <div class="d-flex flex-column position-static">
                    <div class="">
                        @for($i = 0; $i < sizeof($alphabetArr); $i++)
                            <a href="{{route('searchDrugAlphabet',$alphabetArr[$i])}}"><button type="button" class="btn btn-secondary alphabet-button mb-1">{{$alphabetArr[$i]}}</button></a>
                        @endfor
                        <a href="{{route('searchDrugNumber')}}"><button type="button" class="btn btn-secondary alphabet-button mb-1">0-9</button></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="btn-group" id ="letters">
            </div>


            <div class="row">
                @php $i = 0; @endphp
                @foreach($results as $drug)
                    @if(($i % 5 == 0) or $i == 0)
                        @if($i != 0)</div>@endif
            <div class="col-3">
                @endif
                <h3 class="overflow-hidden"><a href="">{{$drug->title}}</a></h3>
                @php $i++; @endphp
                @endforeach
            </div>
        </div>

        @if ($results->lastPage() > 1)
            <div>
                <ul class="pagination">
                    @if(!$results->onFirstPage())
                        <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $results->url(1)}}">First</a>
                        </li>
                        <li class="page-item {{ ($results->currentPage() == 1) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $results->url($results->currentPage()-1)}}">Previous</a>
                        </li>
                    @endif
                    @for ($i = 1; $i <= $results->currentPage()-1; $i++)
                        @if(!($i < ($results->currentPage()-3)))
                            <li class="page-item {{ ($results->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $results->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @for ($i = $results->currentPage(); $i <= $results->lastPage(); $i++)
                        @if(!($i > ($results->currentPage() + 3)))
                            <li class="page-item {{ ($results->currentPage() == $i) ? ' active' : '' }}">
                                <a class="page-link" href="{{ $results->url($i) }}">{{ $i }}</a>
                            </li>
                        @endif
                    @endfor
                    @if($results->lastPage() != $results->currentPage())
                        <li class="page-item {{ ($results->currentPage() == $results->lastPage()) ? ' disabled' : '' }}">
                            <a class="page-link" href="{{ $results->url($results->currentPage()+1) }}" >Next</a>
                        </li>
                        <li class="page-item {{ ($results->currentPage() == 1)}}">
                            <a class="page-link" href="{{ $results->url($results->lastPage())}}">Last</a>
                        </li>
                    @endif
                </ul>
            </div>
        @endif
    </div>
    <div style="height: 15vw"></div>

    @isset($two_letters)
        <script>
            var lang = {{$lang}}
            var alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];

            if (lang === 2) {
                alphabet = ['А','Б','В','Г','Д','Е','Ж','З','И','Й','К','Л','М','Н','О','П','Р','С','Т','У','Ф','Х','Ц','Ч','Ш','Щ','Э','Ю','Я'];
            }
            else if (lang === 3) {
                alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
            }
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
                    html_letters.append('<a  class="btn btn-secondary disabled" > '+obj+'</a>');
            });
        </script>
    @endisset
@endsection
