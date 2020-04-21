<!doctype html>
<html lang="fr">
<head>
    <title>Drive 'N' Cook Corporate</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="/css/app.css" rel="stylesheet">
    @yield('style')
    <style>

        .sidebar-sticky {
            position: -webkit-sticky;
            position: sticky;
            top: 54px; /* Height of navbar */
            height: calc(100vh - 54px);
            padding-top: .5rem;
            overflow-x: hidden;
            overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }
    </style>
</head>
<body>
<nav class="navbar navbar-dark sticky-top bg-dark2 text-light justify-content-between">
    <a class="navbar-brand" href="{{route('corporate_dashboard')}}">Administration Drive 'N' Cook</a>

    <div class="nav-item dropdown" style="margin-right: 10em;">
        <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdownMenuButton" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-user"></i>
        </button>
        <div class="dropdown-menu bg-dark" aria-labelledby="userDropdownMenuButton">
            <a class="dropdown-item text-light" href="#">Mon compte</a>
            <a class="dropdown-item text-light" href="#">Paramètres</a>
            <a class="dropdown-item text-light" href="#">Se déconnecter</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <nav class="col-2 d-block bg-dark sidebar">
            <div class="sidebar-sticky">
                <ul class="nav flex-column text-light">
                    @switch(url()->current())
                        @case(route('corporate_dashboard'))
                        <li class="nav-item">
                            <a class="nav-link text-light2" href="#">
                                <i class="fa fa-warehouse"></i>&nbsp;&nbsp;&nbsp;Entrepôts
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
                        @default
                        @break
                    @endswitch
                    @if (strpos(url()->current(),route('franchisee_update',['id'=>''])) !== false)
                        <li class="nav-item">
                            <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                                <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des franchisés
                            </a>
                        </li>
                    @endif
                    @if (strpos(url()->current(),route('franchisee_view',['id'=>''])) !== false)
                        <li class="nav-item">
                            <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                                <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des franchisés
                            </a>
                        </li>
                    @endif
                    @if (strpos(url()->current(),route('truck_update',['id'=>''])) !== false)
                            <li class="nav-item">
                                <a class="nav-link text-light2" href="{{route('truck_list')}}">
                                    <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des camions
                                </a>
                            </li>
                    @endif
                </ul>
            </div>
        </nav>
        <div class="col-10 pt-3 px-4">

            <h1 class="mb-3">@yield('title', 'DriveNCook.fr')</h1>


            @yield('content')
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/app.js"></script>
@yield('script')
</body>
</html>