<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="{{ asset('js/app.js') }}"></script>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <script src="{{ asset('js/jquery.mask.js') }}"></script>

</head>
<body>
<div id="app">
    <nav class="navbar navbar-tc navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                        data-target="#app-navbar-collapse" aria-expanded="false">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    &nbsp;
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @guest
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    @else
                        <li class="dropdown">
                            <button type="button" class="btn btn-tc dropdown-toggle" data-toggle="dropdown"
                               aria-expanded="false" aria-haspopup="true" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        Выход
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
                
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-sm-3 left-menu">

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>
        
                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-left" style="width: 100%">
        
                            <li style="width: 100%" name="news"><a href="{{ route('auth.news.index') }}">Новости</a></li>

                            <li style="width: 100%" name="clients"><a href="{{ route('auth.clients.index') }}">Клиенты</a></li>

                            <li style="width: 100%" name="cabinets"><a href="{{ route('auth.cabinets.index') }}">Кабинеты</a></li>

                            <li style="width: 100%" name="calendar"><a href="{{ route('auth.calendar.index') }}">Календарь</a></li>

                            <li style="width: 100%" name="notifications"><a href="{{ route('auth.pushes.index') }}">Уведомления</a></li>

                            <li style="width: 100%" name="reservations"><a href="{{ route('auth.reservations.create') }}">Бронирования</a></li>

                            <li style="width: 100%" name="reservations_cancel"><a href="{{ route('auth.reservationcancels') }}">Отмены бронирования</a></li>
        
                        </ul>
                    </div>
            </div>
            <div class="col-sm-9 tabs-content">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    $(document).ready(function() {

        let pathname = window.location.pathname;

        switch(pathname.split('/')[1]) {
        case '':
            $( "li[name='news']" ).addClass( "active" );
            break;

        case 'news':
            $( "li[name='news']" ).addClass( "active" );
            break;

        case 'clients':
            $( "li[name='clients']" ).addClass( "active" );
            break;

        case 'cabinets':
            $( "li[name='cabinets']" ).addClass( "active" );
            break;

        case 'calendar':
            $( "li[name='calendar']" ).addClass( "active" );
            break;

        case 'notifications':
            $( "li[name='notifications']" ).addClass( "active" );
            break;

        case 'reservations':
            $( "li[name='reservations']" ).addClass( "active" );
            break;

        case 'reservations_cancel':
            $( "li[name='reservations_cancel']" ).addClass( "active" );
            break;
        }
    })
</script>
</body>
</html>
