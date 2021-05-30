@extends('layouts.app')
@section('content')
<link href="{{ asset('css/index.css') }}" rel="stylesheet" type="text/css">

<div class="content">
    <form action="{{route('searchText')}}" method="get">
    <section class="w-50 m-auto main-search">
        <div class="input-group mb-3 pb-5">
            <input type="text" class="form-control" name="search_drug" style="border-radius: 10px;" placeholder="Поиск" >
            <button type="submit" class="btn btn-success ml-1" style="border-radius: 10px">Поиск</button>
        </div>
    </section>
    </form>

    <div class="container">
        <div class="row mx-md-n5 justify-content-center">
            <div class="col-6 m-auto pt-1">
            <div class="row g-0 border rounded  mb-4 shadow-sm h-md-250 position-relative ">
                    <div class="col p-4 d-flex flex-column position-static">
                        <strong class="d-inline-block mb-2 text-secondary">Алфавитный поиск</strong>
                        <div class="mb-2">
                            @for($i = 0; $i < sizeof($alphabetArr); $i++)
                                <a href="{{route('searchDrugAlphabet',$alphabetArr[$i])}}"> <button type="button" class="btn btn-secondary alphabet-button">{{$alphabetArr[$i]}}</button></a>
                            @endfor
                            <a href="{{route('searchDrugNumber')}}"><button type="button" class="btn btn-secondary alphabet-button">0-9</button></a>
                        </div>
                    </div>
                </div>
        </div>
            {{--*/Find by categories--}}
            <div class="col-4 m-auto pt-1">
                <div class="row border rounded mb-4 pt-2  pb-4 position-relative">
                    <div class="col p-4 d-flex flex-column">
                      <strong class="d-inline-flex mb-2 text-secondary">Поиск по категориям</strong>
                        <div class="container justify-content-center">
                    <div class="pb-2">
                        <a href="{{route('main.drugs')}}"><button type="button" class="btn btn-outline-secondary button" >Лекарства</button></a>
                        <a href="{{route('main.side_effects')}}"><button type="button" class="btn btn-outline-secondary button">Побочные эффекты</button></a>
                    </div>
                    <div>
                        <a href="{{route('main.diseases')}}"><button type="button" class="btn btn-outline-secondary button">Болезни</button></a>
                        <a href="{{route('main.manufacturers')}}"><button type="button" class="btn btn-outline-secondary button">Производители лекарств</button></a>
                    </div>

                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{--*/Slider--}}
    <div class="container">
    <div class="row justify-content-center pb-5 mt-5">
        <div class="col-xs-6 col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Аспирин</h5>
                    <img src="../../../public/img/flooop.png" alt="..." class="img-thumbnail">
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-outline-secondary">Подробнее</a>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Парацетомол</h5>
                    <img src="../../../public/img/flooop.png" alt="..." class="img-thumbnail">
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-outline-secondary">Подробнее</a>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Солодковый корень</h5>
                    <img src="../../../public/img/flooop.png" alt="..." class="img-thumbnail">
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-outline-secondary">Подробнее</a>
                </div>
            </div>
        </div>
        <div class="col-xs-6 col-sm-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Терафлю</h5>
                    <img src="../../../public/img/flooop.png" alt="..." class="img-thumbnail">
                    <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                    <a href="#" class="btn btn-outline-secondary">Подробнее</a>
                </div>
            </div>
        </div>
    </div>
    </div>

    {{--*/Project titles--}}
    <div class="container py-5" id="featured-3">
        <div class="row g-5 py-5">
            <div class="feature col-md-4">
                <h3>Безопасность</h3>
                <p class="lead fw-normal">Абзац текста под заголовком, поясняющий заголовок. Мы добавим к нему еще одно предложение и, вероятно, продолжим, пока у нас не закончатся слова.</p>
            </div>

            <div class="feature col-md-4">
                <h3>Приватность</h3>
                <p class="lead fw-normal">Абзац текста под заголовком, поясняющий заголовок. Мы добавим к нему еще одно предложение и, вероятно, продолжим, пока у нас не закончатся слова.</p>
            </div>

            <div class="feature col-md-4">
                <h3>Надежность</h3>
                <p class="lead fw-normal">Абзац текста под заголовком, поясняющий заголовок. Мы добавим к нему еще одно предложение и, вероятно, продолжим, пока у нас не закончатся слова.</p>
            </div>
        </div>
    </div>

    {{--*/About project--}}
    <div class="container">
            <h1 class="display-4 fw-normal">О проекте</h1>
            <p class="lead fw-normal">Проект представляет собой веб-приложение, в котором люди могут найти информацию о различных медицинских препаратах, а также возможность поиска по различным критериям. Пользователь может зарегистрироваться и авторизоваться, проверить наличие определенных препаратов в интернет-магазинах Казахстана. Кроме того, проект будет включать подпроект, представляющий собой интернет-магазин, где пользователи могут покупать различные товары, и он будет иметь ту же базу данных, что и словарь.</p>
            <a class="btn btn-outline-secondary" href="{{route('main.about')}}">Больше</a>

    </div>
@endsection
