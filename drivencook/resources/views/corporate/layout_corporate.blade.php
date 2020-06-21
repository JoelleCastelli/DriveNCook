<!doctype html>
<html lang="{{ App::getLocale() }}">
<head>
    <title>Drive'N'Cook Corporate</title>
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
{{--<nav class="navbar navbar-dark sticky-top bg-dark2 text-light justify-content-between">--}}
{{--    <span class="d-flex align-items-center">--}}
{{--        <button href="#menu-toggle" class="btn text-light" id="menu-toggle"><i class="fa fa-bars"></i></button>--}}
{{--        <a class="navbar-brand"--}}
{{--           href="{{route('corporate_dashboard')}}">&nbsp;&nbsp;&nbsp;{{ trans('corporate.admin') }}</a>--}}
{{--    </span>--}}

{{--    @if (!auth()->guest())--}}
{{--        <div class="row">--}}
{{--            <div class="nav-item dropdown">--}}
{{--                <button class="btn btn-dark dropdown-toggle" type="button" data-toggle="dropdown">--}}
{{--                    <img src="{{ asset('img/'.App::getLocale().'_icon.png') }}" height="20">&nbsp;&nbsp;{{ trans('corporate.'. App::getLocale()) }}--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu bg-dark" aria-labelledby="userDropdownMenuButton">--}}
{{--                    @foreach (Config::get('app.languages') as $language)--}}
{{--                        @if ($language != App::getLocale())--}}
{{--                            <a class="dropdown-item text-light" href="{{ route('set_locale', $language) }}">--}}
{{--                                <img src="{{ asset('img/'.$language.'_icon.png') }}" height="20">&nbsp;&nbsp;{{ trans('corporate.'.$language) }}--}}
{{--                            </a>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="nav-item dropdown ml-4" style="margin-right: 10em;">--}}
{{--                <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdownMenuButton"--}}
{{--                        data-toggle="dropdown"--}}
{{--                        aria-haspopup="true" aria-expanded="false">--}}
{{--                    <i class="fa fa-user"></i>--}}
{{--                </button>--}}
{{--                <div class="dropdown-menu bg-dark" aria-labelledby="userDropdownMenuButton">--}}
{{--                    <a class="dropdown-item text-light" href="{{route('corporate.update_account')}}">{{ trans('corporate.account') }}</a>--}}
{{--                    <a class="dropdown-item text-light" href="{{route('corporate_logout')}}">{{ trans('corporate.logout') }}</a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}
{{--</nav>--}}

<nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark2">
    <button href="#menu-toggle" class="btn text-light" id="menu-toggle"><i class="fa fa-bars"></i></button>
    <a class="navbar-brand"
       href="{{route('corporate_dashboard')}}">&nbsp;&nbsp;&nbsp;{{trans('corporate.admin')}}</a>


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
                           href="{{route('corporate.update_account')}}">
                            <i class="fa fa-user"></i>&nbsp;&nbsp;{{ trans('corporate.my_account') }}
                        </a>
                        <a class="dropdown-item text-light d-flex align-items-baseline"
                           href="{{route('corporate_logout')}}">
                            <i class="fa fa-sign-out-alt"></i>&nbsp;&nbsp;{{ trans('corporate.logout') }}
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
                @case(route('corporate_dashboard'))
                @if(auth()->user()->role == 'Administrateur')
                    <li class="nav-item">
                        <a class="nav-link text-light2" href="{{ route('admin_list') }}">
                            <i class="fa fa-lock"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.admin_page') }}
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('warehouse_list') }}">
                        <i class="fa fa-warehouse"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.warehouses') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('dish_list') }}">
                        <i class="fa fa-pizza-slice"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.catalogue') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-user-tie"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.franchisees') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('client_list')}}">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.clients') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_list')}}">
                        <i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.trucks') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-chart-line"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.income_stats') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate.event_list')}}">
                        <i class="fa fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.events') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('country_list')}}">
                        <i class="fa fa-globe"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.countries_cities') }}
                    </a>
                </li>
                @break

                @case(route('franchisee_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_creation')}}">
                        <i class="fa fa-user-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.add_franchisees') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-headset"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.tickets_gestion') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_obligation_update')}}">
                        <i class="fa fa-cogs"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.update_obligations') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_pseudo')}}">
                        <i class="fa fa-address-card"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.pseudo_gestion') }}
                    </a>
                </li>
                @break

                @case(route('franchisee_creation'))
                @case(route('franchisee_obligation_update'))
                @case(route('franchisee_pseudo'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_franchisees_list') }}
                    </a>
                </li>
                @break

                @case(route('truck_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_creation')}}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.add_truck') }}
                    </a>
                </li>
                @break

                @case(route('truck_creation'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_trucks_list') }}
                    </a>
                </li>
                @break

                @case(route('warehouse_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('warehouse_creation')}}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.add_warehouse') }}
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

                @case(route('country_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('location_list')}}">
                        <i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.trucks_locations') }}
                    </a>
                </li>
                @break

                @case(route('location_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('country_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_countries_list') }}
                    </a>
                </li>
                @break

                @case(route('client_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('client_create')}}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.add_client') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="#">
                        <i class="fa fa-credit-card"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.loyalty_gestion') }}
                    </a>
                </li>
                @break

                @case(route('dish_list'))
                @case(route('dish_creation'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('corporate_dashboard') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('dish_creation') }}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.add_product') }}
                    </a>
                </li>
                @break

                @case(route('corporate.update_account'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('corporate_dashboard') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                @break

                @case(route('admin_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('corporate_dashboard') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('admin_creation') }}">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('administrator/user.add_admin') }}
                    </a>
                </li>
                @break

                @case(route('admin_creation'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('admin_list') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('administrator/creation.back_admin_list') }}
                    </a>
                </li>
                @break

                @case(route('corporate.event_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate_dashboard')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate.event_creation')}}">
                        <i class="fa fa-calendar-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.add_event') }}
                    </a>
                </li>
                @break
                @case(route('corporate.event_creation'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate.event_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_event_list') }}
                    </a>
                </li>
                @break


                @default
                @break
            @endswitch

            @if (strpos(url()->current(), route('franchisee_update', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_franchisees_list') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('franchisee_view', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('franchisee_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_franchisees_list') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2"
                       href="{{ route('franchisee_stocks_order', ['id' => collect(request()->segments())->last()]) }}">
                        <i class="fa fa-box-open"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.stocks_orders') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2"
                       href="{{ route('franchisee_invoices_list', ['id' => collect(request()->segments())->last()]) }}">
                        <i class="fa fa-file-invoice"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.invoices') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2"
                       href="{{ route('franchisee_sales_stats', ['id' => collect(request()->segments())->last()]) }}">
                        <i class="fa fa-chart-line"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.sales_stats') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('corporate.event_view', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('corporate.event_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_event_list') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('franchisee_stocks_order', ['id'=>''])) !== false
                    || strpos(url()->current(), route('franchisee_invoices_list', ['id'=>''])) !== false
                    || strpos(url()->current(), route('franchisee_sales_stats', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2"
                       href="{{route('franchisee_view', ['id' => collect(request()->segments())->last()])}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_franchisees_view') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('truck_update', ['id'=>''])) !== false ||
                 strpos(url()->current(), route('truck_view',['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('truck_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_trucks_list') }}
                    </a>
                </li>
            @endif



            @if (strpos(url()->current(), route('update_breakdown', ['truckId'=>'', 'breakdownId' => ''])) !== false ||
                 strpos(url()->current(), route('update_safety_inspection', ['truckId'=>'', 'safetyInspectionId' => ''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2"
                       href="{{ route('truck_view', ['id' => request()->segments()[2]]) }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_to_truck') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('add_breakdown', ['truckId'=>''])) !== false ||
             strpos(url()->current(), route('add_safety_inspection', ['truckId'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2"
                       href="{{ route('truck_view', ['id' => collect(request()->segments())->last()]) }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_to_truck') }}
                    </a>
                </li>
            @endif

            @if (strpos(url()->current(), route('dish_update', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('dish_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_products_list') }}
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
                    <a class="nav-link text-light2" href="{{ route('warehouse_dishes',['id'=>$warehouse['id']]) }}">
                        <i class="fa fa-hamburger"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.warehouse_dishes_view') }}
                    </a>
                    <a class="nav-link text-light2" href="{{ url()->current() . '#orders' }}">
                        <i class="fa fa-box-open"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.warehouse_orders') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('warehouse_dishes',['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('warehouse_view',['id'=> $warehouse['id']]) }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_warehouse_view') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" data-toggle="modal" data-target="#addDishModal">
                        <i class="fa fa-plus"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.add_product') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('warehouse_order',['warehouse_id'=>'', 'id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2"
                       href="{{ route('warehouse_view',['id'=> $order['warehouse_id']]) }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_warehouse_view') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('city_list',['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('country_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('corporate.back_countries_list') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('client_view',['id'=>''])) !== false ||
                 strpos(url()->current(), route('client_update',['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('client_list')}}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{trans('corporate.back_clients_list')}}
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
<script>
    $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    })
</script>
@yield('script')
</body>
</html>