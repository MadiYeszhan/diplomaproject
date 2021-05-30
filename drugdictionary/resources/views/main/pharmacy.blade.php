@extends('layouts.app')
@section('content')
    <link href="{{ asset('css/drug.css') }}" rel="stylesheet" type="text/css">

    <div class="content">
        <div class="container pt-5">
            <h2 class="lead fw-normal" >Ближайшие аптеки в городе Алматы</h2>
        <iframe src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d32884.07421932657!2d76.88953042392566!3d43.23949567201266!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1z0LDQv9GC0LXQutCw!5e0!3m2!1sru!2skz!4v1616822475123!5m2!1sru!2skz" width="800" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
        @endsection
