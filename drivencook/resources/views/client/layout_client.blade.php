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
            @if(!empty($client['loyalty_point']))
            <li class="nav-item ml-4">
                <span class="navbar-brand">{{ $client['loyalty_point'] . ' ' . trans('client/global.loyalty_point') }}</span>
            </li>
            @endif
            <li class="nav-item dropdown ml-4">
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
            <li class="nav-item dropdown ml-4">
                @if (!auth()->guest())
                    <button class="btn btn-dark dropdown-toggle" type="button" id="userDropdownMenuButton"
                            data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="userDropdownMenuButton">
                        <a class="dropdown-item text-light"
                           href="{{ route('client_account') }}">{{ trans('auth.my_account') }}</a>
                        <a class="dropdown-item text-light"
                           href="{{ route('client_logout') }}">{{ trans('auth.logout') }}</a>
                    </div>
                @else
                    <a class="nav-link" href="#" data-toggle="modal" data-target="#formModal_client">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;{{ trans('client/global.login_client') }}
                    </a>
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
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{route('client.event_list')}}">
                        <i class="fa fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;{{trans('client/global.event_list')}}
                    </a>
                </li>
                @break
                @case(route('client_account'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('client_dashboard') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.back_dashboard') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light2" id="deleteAccount">
                        <i class="fa fa-trash"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.delete_account') }}
                    </a>
                </li>
                @break
                @case(route('truck_location_list'))
                @if(!auth()->guest())
                    <li class="nav-item">
                        <a class="nav-link text-light2" href="{{ route('client_dashboard') }}">
                            <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.back_dashboard') }}
                        </a>
                    </li>
                @endif
                @break
                @case(route('client_sales_history'))
                @case(route('client.event_list'))
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('client_dashboard') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/global.back_dashboard') }}
                    </a>
                </li>
                @break
                @default
                @break
            @endswitch
            @if (strpos(url()->current(), route('client_order', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('truck_location_list') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/order.back_trucks') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('client_sale_display', ['id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('client_sales_history') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('client/sale.back_sales_history') }}
                    </a>
                </li>
            @endif
            @if (strpos(url()->current(), route('client.event_view', ['event_id'=>''])) !== false)
                <li class="nav-item">
                    <a class="nav-link text-light2" href="{{ route('client.event_list') }}">
                        <i class="fa fa-chevron-left"></i>&nbsp;&nbsp;&nbsp;{{ trans('event.back_event_list') }}
                    </a>
                </li>
            @endif
        </ul>
    </div>
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="mb-3 clientTitle text-light">@yield('title', 'DriveNCook.fr')</h1>
                    @include('flash::message')

                    @yield('content')
                </div>
            </div>

        </div>
    </div>
</div>

@if(auth()->guest())
    <!-- MODAL CLIENT LOGIN -->
    <div class="modal fade" id="formModal_client" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{ trans('homepage.login_client') }}</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div role="tabpanel">

                        @if ($errors->has('client_login'))
                            <span style="padding: 3px" class="badge-danger">
                                        {{ $errors->first('client_login') }}
                                    </span>
                        @elseif($errors->has('client_login_necessary'))
                            <div style="padding: 3px" class="badge-danger">
                                {{ $errors->first('client_login_necessary') }}
                            </div>
                        @elseif ($errors->has('client_registration'))
                            @foreach ($errors->all() as $message)
                                <div style="padding: 3px" class="badge-danger">
                                    {{ $message }}
                                </div>
                            @endforeach
                        @elseif ($errors->has('client_registration_success'))
                            <span style="padding: 3px" class="badge-success">
                                        {{ $errors->first('client_registration_success') }}
                                    </span>
                    @endif

                    <!-- Tabs -->
                        <ul class="nav nav-tabs mb-1" role="tablist">
                            <li class="active nav-item">
                                <a href="#client_login" class="nav-link active" aria-controls="uploadTab" role="tab"
                                   data-toggle="tab">{{ trans('franchisee.login') }}</a>
                            </li>
                            <li class="nav-item">
                                <a href="#client_registration" class="nav-link" aria-controls="browseTab" role="tab"
                                   data-toggle="tab">{{ trans('franchisee.create_account') }}</a>
                            </li>
                        </ul>

                        <!-- Tabs content -->
                        <div class="tab-content">

                            {{-- Tab client login --}}
                            <div role="tabpanel" class="tab-pane active" id="client_login">
                                <form name="client_form" method="post" action="{{ route('client_login') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group">
                                        <label for="email">{{ trans('auth.email') }}</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                               placeholder="{{ trans('auth.set_email') }}"
                                               value="{{ old('email') }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="password">{{ trans('auth.password') }}</label>
                                        <input type="password" name="password" class="form-control" id="password"
                                               placeholder="{{ trans('auth.set_password') }}" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ trans('franchisee.cancel') }}</button>
                                        <div class="form-group">
                                            <button type="submit"
                                                    class="btn btn-primary">{{ trans('franchisee.login') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- Tab client registration --}}
                            <div role="tabpanel" class="tab-pane" id="client_registration">
                                <form method="post" action="{{ route('light_registration_submit') }}">
                                    <div class="row">

                                        <div class="col-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="firstname">{{ trans('client/registration.firstname') }}</label>
                                                <input type="text" name="firstname" id="firstname"
                                                       placeholder="{{ trans('client/registration.set_firstname') }}"
                                                       value="{{ old('firstname') }}"
                                                       class="form-control"
                                                       minlength="2" maxlength="30" required>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="lastname">{{ trans('client/registration.lastname') }}</label>
                                                <input type="text" name="lastname" id="lastname"
                                                       placeholder="{{ trans('client/registration.set_lastname') }}"
                                                       value="{{ old('lastname') }}"
                                                       class="form-control"
                                                       minlength="2" maxlength="30" required>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="email">{{ trans('client/registration.email') }}</label>
                                        <input type="email" name="email" id="email"
                                               placeholder="{{ trans('client/registration.set_email') }}"
                                               value="{{ old('email') }}"
                                               class="form-control"
                                               maxlength="100" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="password">{{ trans('client/registration.password') }}</label>
                                                <input type="password" name="password" id="password"
                                                       placeholder="{{ trans('client/registration.set_password') }}"
                                                       class="form-control"
                                                       minlength="6" maxlength="100" required>
                                            </div>
                                        </div>

                                        <div class="col-6 col-md-6 col-lg-6">
                                            <div class="form-group">
                                                <label for="password_confirm">{{ trans('client/registration.password_confirm') }}</label>
                                                <input type="password" name="password_confirm" id="password_confirm"
                                                       placeholder="{{ trans('client/registration.set_password_confirm') }}"
                                                       class="form-control"
                                                       minlength="6" maxlength="100" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group g-recaptcha"
                                             data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                                    </div>

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                                    <div class="form-group">
                                        <button type="submit"
                                                class="btn btn-info"
                                                id="submitBtn">{{ trans('client/registration.submit') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

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