<!doctype html>
<html lang="{{ config('app.locale') }}">
<head>
    <title>Drive'N'Cook</title>
    <script src="{{asset('js/trad.js')}}"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="{{asset('css/app.css')}}" rel="stylesheet">
    @yield('style')
    <style>
        .parallax {
            /* The image used */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{asset('img/food_truck.jpg')}});
            /* Set a specific height */
            height: 860px;

            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="/">
        <img src="{{asset('img/logo_transparent_3.png')}}" height="60" class="d-inline-block align-top" alt="">
    </a>

    <div class="mx-auto order-0">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="navbar-collapse collapse w-100 order-1 order-md-1 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{url()->current() == route('homepage')?"active":""}}">
                <a class="nav-link" href="{{route('homepage')}}">
                    <i class="fa fa-home"></i> {{ trans('homepage.home') }}
                </a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}">
                    <i class="fa fa-map-marker-alt"></i> {{ trans('homepage.find_truck') }}
                </a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}">
                    <i class="fa fa-newspaper"></i> {{ trans('homepage.news') }}
                </a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}">
                    <i class="fa fa-info-circle"></i> {{ trans('homepage.about') }}
                </a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}">
                    <i class="fa fa-address-book"></i> {{ trans('homepage.contact') }}
                </a>
            </li>
        </ul>
    </div>

    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <div class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <img src="{{ asset('img/'.App::getLocale().'_icon.png') }}" height="20">&nbsp;&nbsp;{{ trans('homepage.'. App::getLocale()) }}
                </a>
                <div class="dropdown-menu bg-dark">
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
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user"></i>&nbsp;&nbsp;{{ trans('homepage.login') }}
                </a>
                <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-light d-flex align-items-baseline" href="#">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;{{ trans('homepage.login_client') }}
                    </a>
                    <a class="dropdown-item text-light d-flex align-items-baseline" href="{{route('franchise.login')}}">
                        <i class="fa fa-truck"></i>&nbsp;&nbsp;{{ trans('homepage.login_franchisee') }}
                    </a>
                </div>
            </li>

        </div>
    </div>

</nav>

<div class="container-fluid parallax">
    @yield('content')
</div>

<footer class="page-footer font-small bg-dark text-light">
    <div class="container-fluid text-center text-md-left">
        <div class="row">
            <div class="col-lg-3 mx-auto d-flex align-items-center">
                <a class="navbar-brand" href="/">
                    <img src="{{asset('img/logo_transparent_3.png')}}" height="60" class="d-inline-block align-top"
                         alt="">
                </a>
            </div>

            <hr class="clearfix w-100 d-md-none">

            <div class="col-lg-3 mx-auto">
                <h5 class="font-weight-bold text-uppercase mt-3 mb-4">{{ trans('homepage.find_us') }}</h5>
                <ul class="list-unstyled">
                    <li>242 Rue du Faubourg Saint-Antoine</li>
                    <li>75012 Paris</li>
                    <li>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2625.474051746215!2d2.3875456158435933!3d48.849170109309576!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47e6720d9c7af387%3A0x5891d8d62e8535c7!2sESGI%2C%20%C3%89cole%20Sup%C3%A9rieure%20de%20G%C3%A9nie%20Informatique!5e0!3m2!1sfr!2sfr!4v1589730931040!5m2!1sfr!2sfr"
                                width="250" height="150" style="border:0;" allowfullscreen=""
                                aria-hidden="false" tabindex="0"></iframe>
                    </li>
                </ul>
            </div>

            <hr class="clearfix w-100 d-md-none">

            <div class="col-lg-3 mx-auto">
                <h5 class="font-weight-bold text-uppercase mt-3 mb-4">{{ trans('homepage.menu') }}</h5>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{route('homepage')}}">
                            <i class="fa fa-home"></i> {{ trans('homepage.home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link  text-light" href="{{route('homepage')}}">
                            <i class="fa fa-map-marker-alt"></i> {{ trans('homepage.find_truck') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{route('homepage')}}">
                            <i class="fa fa-newspaper"></i> {{ trans('homepage.news') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{route('homepage')}}">
                            <i class="fa fa-info-circle"></i> {{ trans('homepage.about') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{route('homepage')}}">
                            <i class="fa fa-address-book"></i> {{ trans('homepage.contact') }}</a>
                    </li>
                </ul>
            </div>

            <hr class="clearfix w-100 d-md-none">

            <div class="col-lg-3 mx-auto">
                <h5 class="font-weight-bold text-uppercase mt-3 mb-3">{{ trans('homepage.become_franchisee') }}</h5>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">{{ trans('homepage.concept') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">{{ trans('homepage.form') }}</a>
                    </li>
                </ul>

                <h5 class="font-weight-bold text-uppercase mt-3 mb-3">{{ trans('homepage.contact_info') }}</h5>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="tel:0606060606"><i class="fa fa-phone"></i> 01 56 06 90 41</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="mailto:contact@drivencook.fr"><i class="fa fa-envelope"></i> contact@drivencook.fr</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<script type="text/javascript" src="/js/app.js"></script>
</body>
</html>