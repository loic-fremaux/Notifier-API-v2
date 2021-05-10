<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app" class="container-lg">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('profile*') ? 'active' : '' }}"
                               href="{{ route('profile') }}">{{ __('nav.profile') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('services*') ? 'active' : '' }}"
                               href="{{ route('services') }}">{{ __('nav.services') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('api*') ? 'active' : '' }}"
                               href="{{ route('user.api') }}">{{ __('nav.api') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('firebase*') ? 'active' : '' }}"
                               href="{{ route('firebase') }}">{{ __('nav.firebase') }}</a>
                        </li>
                    @endauth
                </ul>

                <ul class="navbar-nav ml-md-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('auth.login') }}</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('auth.create') }}</a>
                        </li>
                    @else
                        <li class="nav-item dropdown active">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    {{ __('auth.logout') }}
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

    @include('layouts.notifications')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <nav>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('home') }}">{{ config('app.name') }}</a>
                        </li>

                        @if(request()->route()->uri() !== '/')
                            @php
                                $uri = explode('/', request()->route()->uri());
                                $parts = count($uri);
                                $c = 0;
                            @endphp

                            @while($c++ < $parts -1)
                                <li class="breadcrumb-item">
                                    <a href="{{ route($uri[$c - 1]) }}">{{ __('nav.' . $uri[$c - 1]) }}</a>
                                </li>
                            @endwhile

                            <li class="breadcrumb-item active">
                                {{ __('nav.' . $uri[$c - 1]) }}
                            </li>
                        @endif
                    </ol>
                </nav>
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>
