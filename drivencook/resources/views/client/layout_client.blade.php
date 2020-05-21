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

    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/sidebar.css" rel="stylesheet">
    @yield('style')
</head>
<body class="parallax">
<nav class="navbar navbar-dark sticky-top bg-dark2 text-light justify-content-between">
    <span class="d-flex align-items-center">
        <button href="#menu-toggle" class="btn text-light" id="menu-toggle"><i class="fa fa-bars"></i></button>
        <a class="navbar-brand"
           href="{{ route('client_dashboard') }}">&nbsp;&nbsp;&nbsp;Drive 'N' Cook</a>
    </span>

    @if (!auth()->guest())
        <div class="nav-item dropdown" style="margin-right: 10em;">
            <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-user"></i>
            </button>
            <div class="dropdown-menu bg-dark" aria-labelledby="userDropdownMenuButton">
                <a class="dropdown-item text-light" href="{{route('corporate.update_account')}}">{{ trans('auth.my_account') }}</a>
                <a class="dropdown-item text-light" href="{{route('client_logout')}}">{{ trans('auth.logout') }}</a>
            </div>
        </div>
    @endif
</nav>

<div id="wrapper">

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            @switch(url()->current())
                @case(route('client_dashboard'))
                <!--<li class="nav-item">
                    <a class="nav-link text-light2" href="{/{ route('warehouse_list') }}">
                        <i class="fa fa-warehouse"></i>&nbsp;&nbsp;&nbsp;{/{ trans('corporate.warehouse') }}
                    </a>
                </li>-->
                @break
                @default
                @break
            @endswitch
            <!--@/if (strpos(url()->current(), route('franchisee_update', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{/{route('franchisee_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;Revenir à la liste des franchisés
                    </a>
                </li>
            @/endif-->
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
</body>
</html>