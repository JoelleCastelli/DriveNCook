<!doctype html>
<html lang="fr">
<head>
    <title>Drive 'N' Cook Franchisé</title>
    <script src="{{asset('js/trad.js')}}"></script>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/sidebar.css" rel="stylesheet">
    @yield('style')
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark2 text-light justify-content-between">
    <span class="d-flex align-items-center">
        <button href="#menu-toggle" class="btn text-light" id="menu-toggle"><i class="fa fa-bars"></i></button>
        <a class="navbar-brand"
           href="{{route('franchise.dashboard')}}">&nbsp;&nbsp;&nbsp;Franchisé Drive 'N' Cook</a>
    </span>

    @if (!auth()->guest())
        <div class="nav-item dropdown" style="margin-right: 10em;">
            <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i>
            </button>
            <div class="dropdown-menu bg-dark" aria-labelledby="userDropdownMenuButton">
                <a class="dropdown-item text-light" href="#">Mon compte</a>
                <a class="dropdown-item text-light" href="#">Paramètres</a>
                <a class="dropdown-item text-light" href="{{route('franchise.logout')}}">Se déconnecter</a>
            </div>
        </div>
    @endif
</nav>

<div id="wrapper">

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            @switch(url()->current())
                @case(route('franchise.dashboard'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.truck_view')}}">
                        <i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;Camion
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-chart-line"></i>&nbsp;&nbsp;&nbsp;Revenus & Statistiques
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-file-invoice"></i>&nbsp;&nbsp;&nbsp;Factures
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-shopping-basket"></i>&nbsp;&nbsp;&nbsp;Commandes
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-cubes"></i>&nbsp;&nbsp;&nbsp;Stocks
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;Evenements
                    </a>
                </li>
                @break
            @case(route('franchise.truck_view'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir au tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.truck_location_update')}}">
                        <i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;Mettre à jour la position du camion
                    </a>
                </li>
                @break
            @case(route('franchise.truck_location_update'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.truck_view')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la gestion du camion
                    </a>
                </li>
                @break
                @default
                @break
            @endswitch
        </ul>
    </div>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-3">@yield('title', 'DriveNCook.fr')</h1>
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
</body>
</html>