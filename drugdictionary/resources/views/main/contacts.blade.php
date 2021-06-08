@extends('layouts.app')
@section('content')

    <div class="content mb-5 pb-5">
        <div class="container pt-5">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2906.776266918831!2d76.90755611573412!3d43.235150287379746!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3883692f027581ad%3A0x2426740f56437e63!2z0JzQtdC20LTRg9C90LDRgNC-0LTQvdGL0Lkg0YPQvdC40LLQtdGA0YHQuNGC0LXRgiDQuNC90YTQvtGA0LzQsNGG0LjQvtC90L3Ri9GFINGC0LXRhdC90L7Qu9C-0LPQuNC5!5e0!3m2!1sru!2skz!4v1623140594658!5m2!1sru!2skz" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
        </div>
    </div>
        <div class="container mt-5">
            <div class="row align-items-start">
                <div class="col">
                    <h5>{{__('main.contacts_softdev')}}</h5>
                    <ul class="list-unstyled">
                        <li><a class="link text-secondary" href="#">Вконтакте</a></li>
                        <li><a class="link text-secondary" href="#">Instagram</a></li>
                        <li><a class="link text-secondary" href="#">+7(777)777-77-77</a></li>
                        <li><a class="link text-secondary" href="#">madi.yeszhanov@gmail.com</a></li>
                    </ul>
                </div>
                <div class="col">
                    <h5>{{__('main.contacts_front')}}</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="link text-secondary" href="#">Вконтакте</a></li>
                        <li><a class="link text-secondary" href="#">Instagram</a></li>
                        <li><a class="link text-secondary" href="#">+7(707)707-70-07</a></li>
                        <li><a class="link text-secondary" href="#">rasul.aripov@gmail.com</a></li>
                    </ul>
                </div>

            </div>
@endsection
