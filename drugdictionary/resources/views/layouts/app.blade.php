<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
     <nav class="navbar navbar-expand-md navbar-dark bg-dark">
        <div class="d-flex w-navbar order-0">
            <a class="navbar-brand mr-1" href="{{ url('/') }}">{{ config('app.name', 'Online drug dictionary') }}</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsingNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
        <div class="navbar-collapse collapse justify-content-center order-2" id="collapsingNavbar">

        <!-- <ul class="navbar-nav">
                <li class="nav-item  active">
                    <a class="nav-link" href="{{route('drugs.index')}}">Products</a>
                </li>
            </ul> -->
            <ul class="navbar-nav ml-auto">
            	@guest
            	@if (Route::has('login'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                </li>
                @endif

                @if (Route::has('register'))
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                </li>
                @endif

                @else
                <li class="nav-item dropdown ">
                 <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                 {{ Auth::user()->name }}
                 </a>

               <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown" >
                 <a class="dropdown-item " href="{{ route('profile') }}">Profile</a>
{{--                   @if (Auth::user()->roles->contains(3))--}}
{{--                 <a class="dropdown-item " href="{{ route('admin.index') }}">Back as admin</a>--}}
{{--                   @endif--}}

{{--                   @if (Auth::user()->roles->contains(2))--}}
{{--                       <a class="dropdown-item " href="{{ route('moderator.index') }}">Enter as moderator</a>--}}
{{--                   @endif--}}

                 <a class="dropdown-item " href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
               </div>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
                </form>
                @endguest
            </ul>
        </div>
     </nav>
      <main class="py-4">
            @yield('content')
      </main>
    </div>
</body>
</html>
