<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--  Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!--  Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('head-content')
    <title>{{ config('app.name', 'Online drug shop') }}</title>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css">
</head>


<body>
    <div id="app">
        <header class="mb-auto">
            <nav class="navbar navbar-expand-md navbar-light fixed-top border-bottom" style="background-color: white ">
                <div class="container-fluid">
                    <a class="navbar-brand" href={{route('main.index')}}><img src="{{ asset('img/logo.png') }}" width="200" height="35" alt="logo"></a>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav  mb-2 mb-md-0 mr-auto" >
                            <li class="nav-item">
                                <a class="nav-link inks" href="{{route('main.pharmacies')}}">{{__('head.pharmacy')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link inks" href="{{route('main.contacts')}}">{{__('head.contacts')}}</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link inks" href="{{route('main.about')}}">{{__('head.about_us')}}</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav ml-auto">
                            <li class="nav-item dropdown ">
                                <a class="nav-link dropdown-toggle inks" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @if(App::getLocale() == 'en')
                                        English
                                    @elseif(App::getLocale() == 'ru')
                                        Русский
                                    @elseif(App::getLocale() == 'kz')
                                        Казакша
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
                                    <a class="dropdown-item main-dropdown" href="{{ route('main.language',['lang' => 1]) }}">English</a>
                                    <a class="dropdown-item main-dropdown" href="{{ route('main.language',['lang' => 2]) }}">Русский</a>
                                    <a class="dropdown-item main-dropdown" href="{{ route('main.language',['lang' => 3]) }}">Казакша</a>
                                </div>
                            </li>

                            @guest
                                @if (Route::has('login'))
                                    <li class="nav-item">
                                        <a class="nav-link inks" href="{{ route('login') }}">{{__('head.login')}}</a>
                                    </li>
                                @endif

                                @if (Route::has('register'))
                                    <li class="nav-item">
                                        <a class="nav-link inks" href="{{ route('register') }}">{{__('head.register')}}</a>
                                    </li>
                                @endif

                            @else
                                <li class="nav-item dropdown ">
                                    <a class="nav-link dropdown-toggle inks" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>

                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
                                        <a class="dropdown-item main-dropdown" href="{{ route('profile') }}">{{__('head.profile')}}</a>
                                        <a class="dropdown-item main-dropdown" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">{{__('head.logout')}}</a>
                                    </div>
                                </li>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @endguest
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

      <main class="py-4 page-container">
            @yield('content')
          <div class="push"></div>
      </main>

        <footer class="container py-5">
            <div class="row">
                <div class="col-12 col-md">
                    <a class="navbar-brand" href="#"><img src="{{ asset('img/logo.png') }}" width="150" height="25" alt="logo"></a>
                    <small class="d-block mb-3 text-muted">©2021</small>
                </div>
                <div class="col-6 col-md">
                    <h5>{{__('head.about_us')}}</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="link-secondary" href="{{route('main.about')}}">{{__('head.about_us')}}</a></li>
                        <li><a class="link-secondary" href="#">VK Yeszhanov Madi</a></li>
                        <li><a class="link-secondary" href="#">VK Aripov Rasul</a></li>
                    </ul>
                </div>
                <div class="col-6 col-md">
                    <h5>{{__('head.navigation')}}</h5>
                    <ul class="list-unstyled text-small">
                        <li><a class="link-secondary" href="{{route('main.pharmacies')}}">{{__('head.pharmacy')}}</a></li>
                        <li><a class="link-secondary" href="{{route('main.contacts')}}">{{__('head.contacts')}}</a></li>
                        <li><a class="link-secondary" href="{{route('main.index')}}">{{__('head.return')}}</a></li>
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
