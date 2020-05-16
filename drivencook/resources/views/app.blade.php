<!doctype html>
<html lang="fr">
<head>
    <title>Drive 'N' Cook</title>
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
            height: 820px;

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
                <a class="nav-link" href="{{route('homepage')}}"><i class="fa fa-home"></i> Accueil</a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}"><i class="fa fa-map-marker-alt"></i> Trouver un camion</a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}"><i class="fa fa-newspaper"></i> Actualités</a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}"><i class="fa fa-info-circle"></i> A propos</a>
            </li>
            <li class="nav-item {{url()->current() == route('homepage')?"":""}}">
                <a class="nav-link" href="{{route('homepage')}}"><i class="fa fa-address-book"></i> Nous contacter</a>
            </li>
        </ul>
    </div>

    <
    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                   aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item text-light d-flex align-items-baseline" href="#">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;Accès client
                    </a>
                    <a class="dropdown-item text-light d-flex align-items-baseline" href="{{route('franchise.login')}}">
                        <i class="fa fa-truck"></i>&nbsp;&nbsp;Accès franchisé
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>

<div class="container-fluid parallax">
    @yield('content')

</div>

<script type="text/javascript" src="/js/app.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

<script type="text/javascript" src="/js/franchisee_update.js"></script>
</body>
</html>