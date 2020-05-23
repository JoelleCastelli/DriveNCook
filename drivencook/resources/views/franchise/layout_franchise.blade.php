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
<nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark2">
    <button href="#menu-toggle" class="btn text-light" id="menu-toggle"><i class="fa fa-bars"></i></button>
    <a class="navbar-brand"
       href="{{route('franchise.dashboard')}}">&nbsp;&nbsp;&nbsp;{{trans('franchisee.franchise')}} Drive 'N' Cook</a>


    <div class="mx-auto order-0">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <div class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <img src="{{ asset('img/'.App::getLocale().'_icon.png') }}"
                         height="20">&nbsp;&nbsp;{{ trans('homepage.'. App::getLocale()) }}
                </a>
                <div class="dropdown-menu dropdown-menu-right bg-dark">
                    @foreach (Config::get('app.languages') as $language)
                        @if ($language != App::getLocale())
                            <a class="dropdown-item text-light" href="{{ route('set_locale', $language) }}">
                                <img src="{{ asset('img/'.$language.'_icon.png') }}"
                                     height="20">&nbsp;&nbsp;{{ trans('homepage.'.$language) }}
                            </a>
                        @endif
                    @endforeach
                </div>
            </li>
            @if (!auth()->guest())
                <li class="nav-item dropdown ml-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-light d-flex align-items-baseline"
                           href="{{route('franchise.update_account')}}">
                            <i class="fa fa-user"></i>&nbsp;&nbsp;{{ trans('franchisee.update_account') }}
                        </a>
                        <a class="dropdown-item text-light d-flex align-items-baseline"
                           href="{{route('franchise.logout')}}">
                            <i class="fa fa-sign-out-alt"></i>&nbsp;&nbsp;{{ trans('franchisee.logout') }}
                        </a>
                    </div>
                </li>
            @endif
        </div>
    </div>

</nav>


<div id="wrapper">

    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            @switch(url()->current())
                @case(route('franchise.dashboard'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.truck_view')}}">
                        <i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.truck')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-shopping-basket"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.client_orders')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.stock_dashboard')}}">
                        <i class="fa fa-cubes"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.stock_warehouses_orders')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-file-invoice"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.invoices')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.events')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-chart-line"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.revenues_and_statistics')}}
                    </a>
                </li>

                @break
                @case(route('franchise.truck_view'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.back_to_dashboard')}}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.truck_location_update')}}">
                        <i class="fa fa-map-pin"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.update_truck_position')}}
                    </a>
                </li>
                @break
                @case(route('franchise.truck_location_update'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.truck_view')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.back_to_truck_management')}}
                    </a>
                </li>
                @break
                @case(route('franchise.stock_dashboard'))
                @case(route('franchise.update_account'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.back_to_dashboard')}}
                    </a>
                </li>
                @break
                @default
                @break
            @endswitch
            @if (strpos(url()->current(), route('franchise.truck_safety_inspection_update', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.truck_view')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.back_to_truck_management')}}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('franchise.stock_new_order')) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.stock_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.back_to_stock_warehouse_management')}}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('franchise.stock_order_view',['order_id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchise.stock_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{trans('franchisee.back_to_stock_warehouse_management')}}
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

<script type="text/javascript" src="{{asset('js/app.js')}}"></script>
<script type="text/javascript" src="{{asset('js/trad.js')}}"></script>
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    })
</script>
@yield('script')
</body>
</html>