<!doctype html>
<html lang="fr">
<head>
    <title>Drive 'N' Cook Corporate</title>
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
        <a class="navbar-brand" href="{{route('corporate_dashboard')}}">&nbsp;&nbsp;&nbsp;Administration Drive 'N' Cook</a>
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
                <a class="dropdown-item text-light" href="{{route('corporate_logout')}}">Se déconnecter</a>
            </div>
        </div>
    @endif
</nav>

<div id="wrapper">

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            @switch(url()->current())
                @case(route('corporate_dashboard'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('warehouse_list') }}">
                        <i class="fa fa-warehouse"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.warehouse') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-user-tie"></i>&nbsp;&nbsp;&nbsp;Franchisés
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Clients
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_list')}}">
                        <i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;Camions
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-chart-line"></i>&nbsp;&nbsp;&nbsp;Revenus & Statistiques
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;Evenements
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-globe"></i>&nbsp;&nbsp;&nbsp;Pays & Villes
                    </a>
                </li>
                @break
                @case(route('franchisee_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Retour au tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_creation')}}">
                        <i class="fa fa-user-plus"></i>&nbsp;&nbsp;&nbsp;Ajouter un franchisé
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-headset"></i>&nbsp;&nbsp;&nbsp;Gestion des tickets
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_obligation_update')}}">
                        <i class="fa fa-cogs"></i>&nbsp;&nbsp;&nbsp;Modifier les obligations des franchisés
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_pseudo')}}">
                        <i class="fa fa-address-card"></i>&nbsp;&nbsp;&nbsp;Gestion des pseudo
                    </a>
                </li>
                @break
                @case(route('franchisee_creation'))
                @case(route('franchisee_obligation_update'))
                @case(route('franchisee_pseudo'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des franchisés
                    </a>
                </li>
                @break
                @case(route('truck_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir au tableau de bord
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_creation')}}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;Ajouter un camion
                    </a>
                </li>

                @break
                @case(route('truck_creation'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des camions
                    </a>
                </li>
                @break
                @case(route('warehouse_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ 'corporate.back_dashboard' }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('warehouse_creation')}}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ 'corporate.add_warehouse' }}
                    </a>
                </li>

                @break
                @case(route('warehouse_creation'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('warehouse_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_warehouse_list') }}
                    </a>
                </li>
                @break
                @default
                @break
            @endswitch
            @if (strpos(url()->current(), route('franchisee_update', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des franchisés
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('franchisee_view', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des franchisés
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('truck_update', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des camions
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('truck_view',['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des camions
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('warehouse_update', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('warehouse_list') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_warehouse_list') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(),route('warehouse_view',['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('warehouse_list') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_warehouse_list') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('warehouse_dishes',['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('warehouse_view',['id'=> $warehouse['id']]) }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_warehouse_list') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" id="addDish" data-toggle="modal" data-target="#addDishModal">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ 'corporate.add_dish' }}
                    </a>
                </li>
            @endif
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