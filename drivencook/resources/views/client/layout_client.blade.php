<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>Drive 'N' Cook</title>
    <script src="{{asset('js/trad.js')}}"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/sidebar.css" rel="stylesheet">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    @yield('style')
    <style>
        .parallax {
            /* The image used */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{ asset('img/client_homepage.jpg') }});
            /* Set a specific height */
            height: 100%;

            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body class="parallax">
<nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
    <span class="d-flex align-items-center">
        <button href="#menu-toggle" class="btn text-light" id="menu-toggle"><i class="fa fa-bars"></i></button>
        <a class="navbar-brand"
           href="{{ route('client_dashboard') }}">&nbsp;&nbsp;&nbsp;Drive 'N' Cook</a>
    </span>

    <div class="mx-auto order-0">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <div class="navbar-nav ml-auto">
            <li class="nav-item dropdown ml-4">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <img src="{{ asset('img/'.App::getLocale().'_icon.png') }}" height="20">&nbsp;&nbsp;{{ trans('homepage.'. App::getLocale()) }}
                </a>
                <div class="dropdown-menu dropdown-menu-right bg-dark">
                    @foreach (Config::get('app.languages') as $language)
                        @if ($language != App::getLocale())
                            <a class="dropdown-item text-light" href="{{ route('set_locale', $language) }}">
                                <img src="{{ asset('img/'.$language.'_icon.png') }}" height="20">&nbsp;&nbsp;{{ trans('homepage.'.$language) }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </li>
            <li class="nav-item dropdown ml-4">
                @if (!auth()->guest())
                    <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="userDropdownMenuButton">
                        <a class="dropdown-item text-light" href="{{route('client_account')}}">{{ trans('auth.my_account') }}</a>
                        <a class="dropdown-item text-light" href="{{route('client_logout')}}">{{ trans('auth.logout') }}</a>
                    </div>
                @endif
            </li>
        </div>
    </div>

</nav>

<div id="wrapper">

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            @switch(url()->current())
                @case(route('registration'))
                    <li class="nav-item">
                        <a class="nav-link text-light2" href="{{ route('client_login') }}">
                            <i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;{{ trans('auth.connection_btn') }}
                        </a>
                    </li>
                @break
                @case(route('client_dashboard'))
                    <li class="nav-item">
                        <a class="nav-link text-light2" href="{{ route('truck_location_list') }}">
                            <i class="fa fa-hamburger"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.order') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light2" href="{{ route('client_sales_history') }}">
                            <i class="fa fa-history"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.history') }}
                        </a>
                    </li>
                @break
                @case(route('client_account'))
                    <li class="nav-item">
                        <a class="nav-link text-light2" id="deleteAccount">
                            <i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.delete_account') }}
                        </a>
                    </li>
                @break
                @case(route('truck_location_list'))
                    <li class="nav-item">
                        <a class="nav-link text-light2" href="{{route('client_dashboard')}}">
                            <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.back_dashboard') }}
                        </a>
                    </li>
                @break
                @case(route('client_sales_history'))
                    <li class="nav-item">
                        <a class="nav-link text-light2" href="{{route('client_dashboard')}}">
                            <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.back_dashboard') }}
                        </a>
                    </li>
                @break
                @default
                @break
            @endswitch
            @if (strpos(url()->current(), route('client_order', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_location_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/order.back_trucks') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-3 clientTitle">@yield('title', 'DriveNCook.fr')</h1>
                    @include('flash::message')

                    @yield('content')
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript" src="/js/app.js"></script>
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    })
</script>
@yield('script')
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
</body>
</html>