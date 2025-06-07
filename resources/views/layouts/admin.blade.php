<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{$title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.bunny.net"> -->
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- CSS Rules -->
    <style>
/* Navbar links */
.navbar-nav .nav-item a {
    color: white; /* Default text color */
    text-decoration: none;
    padding: 7px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

/* Hover effect for regular navbar links */
.navbar-nav .nav-item a:hover {
    background-color: white;
    color: green;
}

    </style>


</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md bg-success text-white">
            <div class="container" >
                <a class="navbar-brand" href="{{ url('/') }}">
                    <!-- {{ config('app.name', 'Laravel') }} -->
                    <img src="/img/logo.png" alt="logo" style="height: 40px; filter: brightness(0) invert(1); padding-left: 10px">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent" >
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto d-flex align-items-baseline" >
                        <li class ="nav-item me-4 p-1 ">
                            <a href="{{ url('/')}}">Tableau de Bord</a>
                        </li>
                        <li class="nav-item dropdown me-3" >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    Gestion
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                                    <a style="color: black;" class="dropdown-item" href="{{route('user.index')}}">Professeurs</a>
                                    <a style="color: black;" class="dropdown-item" href="{{route('module.index')}}">Modules</a>
                                    <a style="color: black;" class="dropdown-item" href="{{route('filiere.index')}}">Filières</a>
                                    <a style="color: black;" class="dropdown-item" href="{{route('groupe.index')}}">Groupes</a>
                                    <a style="color: black;" class="dropdown-item" href="">Cahiers de texte</a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>


                        <!-- <li class ="nav-item me-4 p-1 ">
                            <a style="text-decoration:none;color: white;" href="{{ url('/')}}">Rechercher</a>
                        </li> -->
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto"  style="color: white;">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown" >
                                <a id="navbarDropdown" class="nav-link dropdown-toggle text-uppercase" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{Auth::user()->firstname . " " .  Auth::user()->lastname }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" >
                                <a style="color: black;" class="dropdown-item" href="{{ route('user.show', Auth::id()) }}">Mon Profil</a>
                                <a style="color: black;" class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Déconnexion') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
