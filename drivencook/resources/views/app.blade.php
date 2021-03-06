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
            /*min-height: 860px;*/
            @if(url()->current() == route('homepage') || url()->current() == route('about'))
                            height: 860px;
            @else
                           min-height: 860px;
        @endif
            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body>
<nav class="navbar navbar-expand-md navbar-dark sticky-top bg-dark">
    <a class="navbar-brand" href="/">
        <img src="{{ asset('img/logo_transparent_3.png') }}" height="60" class="d-inline-block align-top" alt="">
    </a>

    <div class="ml-md-auto order-0">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target=".dual-collapse2">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="navbar-collapse collapse w-100 order-1 order-md-1 dual-collapse2">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{url()->current() == route('homepage')?"active":""}}">
                <a class="nav-link" href="{{ route('homepage') }}">
                    <i class="fa fa-home"></i> {{ trans('homepage.home') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="modal"
                   data-target="#map_modal">
                    <i class="fa fa-map-marker-alt"></i> {{ trans('homepage.find_truck') }}
                </a>
            </li>
            <li class="nav-item {{ url()->current() == route('news')?"active":"" }}">
                <a class="nav-link" href="{{route('news')}}">
                    <i class="fa fa-newspaper"></i> {{ trans('homepage.news') }}
                </a>
            </li>
            <li class="nav-item {{ url()->current() == route('about')?"active":"" }}">
                <a class="nav-link" href="{{route('about')}}">
                    <i class="fa fa-info-circle"></i> {{ trans('homepage.about') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#"
                   data-toggle="modal" data-target="#contact_form_modal">
                    <i class="fa fa-address-book"></i> {{ trans('homepage.contact') }}
                </a>
            </li>
        </ul>
    </div>

    <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <div class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" role="button">
                    <img src="{{ asset('img/'.App::getLocale().'_icon.png') }}"
                         height="20">&nbsp;&nbsp;{{ trans('homepage.'. App::getLocale()) }}
                </a>
                <div class="dropdown-menu bg-dark">
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

            @if (auth()->user())
                <li class="nav-item dropdown ml-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;{{ auth()->user()->firstname }} {{ auth()->user()->lastname }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="userDropdownMenuButton">
                        @if (auth()->user()->role == "Franchisé")
                            <a class="dropdown-item text-light"
                               href="{{ route('franchise.dashboard') }}">{{ trans('auth.my_account') }}</a>
                        @else
                            <a class="dropdown-item text-light"
                               href="{{ route('client_dashboard') }}">{{ trans('auth.my_account') }}</a>
                            <a class="dropdown-item text-light"
                               href="{{ route('client_sales_history') }}">{{ trans('client/global.my_orders') }}</a>
                            <a class="dropdown-item text-light"
                               href="{{ route('client.event_list') }}">{{ trans('client/global.my_events') }}</a>
                            <a class="dropdown-item text-light"
                               href="{{ route('client_account') }}">{{ trans('client/global.params') }}</a>
                        @endif
                        <a class="dropdown-item text-light"
                           href="{{ route('client_logout') }}">{{ trans('auth.logout') }}</a>
                    </div>
                </li>
            @else
                <li class="nav-item dropdown ml-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown"
                       aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-user"></i>&nbsp;&nbsp;{{ trans('homepage.login') }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right bg-dark" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-light d-flex align-items-baseline" href="#" data-toggle="modal"
                           data-target="#formModal_client">
                            <i class="fa fa-user"></i>&nbsp;&nbsp;{{ trans('homepage.login_client') }}
                        </a>
                        <a class="dropdown-item text-light d-flex align-items-baseline" href="#" data-toggle="modal"
                           data-target="#formModal_franchisee">
                            <i class="fa fa-truck"></i>&nbsp;&nbsp;{{ trans('homepage.login_franchisee') }}
                        </a>
                        <a class="dropdown-item text-light d-flex align-items-baseline" href="#" data-toggle="modal"
                           data-target="#forgot_password_modal">
                            <i class="fa fa-key"></i>&nbsp;&nbsp;{{ trans('auth.forgot_password')}}
                        </a>
                    </div>
                </li>
            @endif
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container-fluid parallax">
    @include('flash::message')
    @yield('content')
</div>
<!-- FOOTER -->
<footer class="page-footer font-small bg-dark text-light">
    <div class="container-fluid text-center text-md-left">
        <div class="row">
            <div class="col-lg-3 mx-auto d-flex align-items-center">
                <a class="navbar-brand" href="/">
                    <img src="{{asset('img/logo_transparent_3.png')}}" height="60" class="d-inline-block align-top"
                         alt="Drive'N'Cook">
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
                        <a class="nav-link text-light" href="{{ route('homepage') }}">
                            <i class="fa fa-home"></i> {{ trans('homepage.home') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#map_modal" data-toggle="modal"
                           data-target="#map_modal">
                            <i class="fa fa-map-marker-alt"></i> {{ trans('homepage.find_truck') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{ route('news') }}">
                            <i class="fa fa-newspaper"></i> {{ trans('homepage.news') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="{{route('about')}}">
                            <i class="fa fa-info-circle"></i> {{ trans('homepage.about') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#"
                           data-toggle="modal" data-target="#contact_form_modal">
                            <i class="fa fa-address-book"></i> {{ trans('homepage.contact') }}
                        </a>
                    </li>
                </ul>
            </div>

            <hr class="clearfix w-100 d-md-none">

            <div class="col-lg-3 mx-auto">
                <h5 class="font-weight-bold text-uppercase mt-3 mb-3">{{ trans('homepage.become_franchisee') }}</h5>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light"
                           href="https://webgl.drivencook.fr">{{ trans('homepage.concept') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#">{{ trans('homepage.form') }}</a>
                    </li>
                </ul>

                <h5 class="font-weight-bold text-uppercase mt-3 mb-3">{{ trans('homepage.contact_info') }}</h5>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="tel:0606060606"><i class="fa fa-phone"></i>01 56 06 90
                            41</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-light" href="mailto:contact@drivencook.fr"><i
                                    class="fa fa-envelope"></i>contact@drivencook.fr</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

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

<!-- MODAL FRANCHISEE LOGIN -->
<div class="modal fade" id="formModal_franchisee" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">{{ trans('homepage.login_franchisee') }}</h5>
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div role="tabpanel">

                    @if ($errors->has('franchisee_login'))
                        <span style="padding: 3px" class="badge-danger">
                                    {{ $errors->first('franchisee_login') }}
                                </span>
                    @elseif ($errors->has('franchisee_first_login'))
                        <span style="padding: 3px" class="badge-warning">
                                    {{ $errors->first('franchisee_first_login') }}
                                </span>
                    @elseif ($errors->has('franchisee_confirmation_success'))
                        <span style="padding: 3px" class="badge-success">
                                    {{ $errors->first('franchisee_confirmation_success') }}
                                </span>
                    @elseif ($errors->has('franchisee_login_necessary'))
                        <div style="padding: 3px" class="badge-danger">
                            {{ $errors->first('franchisee_login_necessary') }}
                        </div>
                    @elseif ($errors->has('franchisee_complete_registration_necessary'))
                        <div style="padding: 3px" class="badge-warning">
                            {{ $errors->first('franchisee_complete_registration_necessary') }}
                        </div>
                @endif

                <!-- Tabs -->
                    <ul class="nav nav-tabs mb-1" role="tablist">
                        <li class="active nav-item">
                            <a href="#franchisee_login" class="nav-link active" aria-controls="uploadTab" role="tab"
                               data-toggle="tab">{{ trans('franchisee.login') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#franchisee_first_connexion" class="nav-link" aria-controls="browseTab" role="tab"
                               data-toggle="tab">{{ trans('franchisee.first_login') }}</a>
                        </li>
                    </ul>

                    <!-- Tabs content -->
                    <div class="tab-content">

                        {{--Tab franchisee login--}}
                        <div role="tabpanel" class="tab-pane active" id="franchisee_login">
                            <form name="franchisee_login_form" method="post"
                                  action="{{ route('franchise.login_submit') }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="email">{{ trans('franchisee.email')}}</label>
                                    <input type="email" name="email" class="form-control" id="email"
                                           placeholder="{{ trans('franchisee.enter_email') }}"
                                           value="{{ old('email') }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="password">{{ trans('franchisee.password') }}</label>
                                    <input type="password" name="password" class="form-control" id="password"
                                           placeholder="{{ trans('franchisee.enter_password') }}" required>
                                </div>
                                <div class="modal-footer">
                                    <div class="form-group">
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ trans('franchisee.cancel') }}</button>
                                        <button type="submit"
                                                class="btn btn-primary">{{ trans('franchisee.login') }}</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{--Tab franchisee first connexion--}}
                        <div role="tabpanel" class="tab-pane" id="franchisee_first_connexion">
                            @if (!isset($pseudos))
                                <form name="franchisee_first_login_form"
                                      action="{{ route('franchise.complete_registration_email') }}" method="post">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <label for="email_registration">{{ trans('franchisee.email') }}</label>
                                        <input class="form-control" type="email" name="email" id="email_registration"
                                               placeholder="{{ trans('franchisee.enter_email') }}" required>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">{{ trans('franchisee.cancel') }}</button>
                                        <button type="submit"
                                                class="btn btn-primary">{{ trans('franchisee.continue') }}</button>
                                    </div>
                                </form>
                            @elseif(isset($pseudos))
                                <form action="{{ route('franchise.complete_registration_submit') }}" method="post">
                                    <input type="hidden" id="email" name="email" value="{{ $email }}">
                                    {{ csrf_field() }}


                                    <div class="form-group">
                                        <label for="driving_licence">{{ trans('franchisee.enter_driving_licence') }}</label>
                                        <input type="text" class="form-control" id="driving_licence"
                                               name="driving_licence"
                                               placeholder="{{ trans('franchisee.driving_licence') }}"
                                               value="{{ old('driving_licence') }}" required>
                                        @if ($errors->has('driving_licence'))
                                            <span class="badge-danger">
                                                        {{$errors->first('driving_licence')}}
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="social_security">{{ trans('franchisee.social_security') }}</label>
                                        <input type="text" class="form-control" id="social_security"
                                               name="social_security"
                                               value="{{ old('social_security') }}"
                                               placeholder="{{ trans('franchisee.enter_social_security') }}" required>
                                        @if ($errors->has('social_security'))
                                            <span class="badge-danger">
                                                        {{ $errors->first('social_security') }}
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="telephone">{{ trans('franchisee.phone') }}</label>
                                        <input type="text" class="form-control" id="telephone" name="telephone"
                                               placeholder="{{ trans('franchisee.enter_phone') }}"
                                               value="{{ old('telephone') }}" required>
                                        @if ($errors->has('telephone'))
                                            <span class="badge-danger">
                                                        {{$errors->first('telephone')}}
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="pseudo">{{ trans('franchisee.pseudo') }}</label>
                                        @if(empty($pseudos))
                                            <div class="form-control" style="color: red"
                                                 type="text">{{ trans('franchisee.no_pseudo_available') }}</div>
                                        @else
                                            <div class="input-group">
                                                <select class="custom-select" name="pseudo" id="pseudo" required>
                                                    <option disabled selected
                                                            value>{{ trans("franchisee.enter_pseudo") }}</option>
                                                    @foreach($pseudos as $pseudo)
                                                        <option value="{{ $pseudo['id'] }}">{{ $pseudo['name'] }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif

                                        @if ($errors->has('pseudo'))
                                            <span class="badge-danger">
                                                        {{$errors->first('pseudo')}}
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password">{{ trans('franchisee.password') }}</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                               placeholder="{{ trans('franchisee.enter_password') }}" minlength="6"
                                               required>
                                        @if ($errors->has('password'))
                                            <span class="badge-danger">
                                                        {{$errors->first('password')}}
                                                    </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">{{ trans('franchisee.password_confirmation') }}</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                               name="password_confirmation"
                                               placeholder="{{ trans('franchisee.enter_password') }}" minlength="6"
                                               required>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="badge-danger">
                                                        {{$errors->first('password_confirmation')}}
                                                    </span>
                                        @endif
                                    </div>

                                    <button type="submit"
                                            class="btn btn-primary">{{ trans('franchisee.submit') }}</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL FORGOTTEN PASSWORD --}}
<div class="modal fade" id="forgot_password_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">{{ trans('auth.forgot_password') }}</h5>
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div role="tabpanel" class="tab-pane active" id="franchisee_login">
                    <form name="franchisee_login_form" method="post"
                          action="{{ route('forgot_password') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="email">{{ trans('auth.enter_email')}}</label>
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="{{ trans('auth.enter_email') }}"
                                   value="{{ old('email') }}" required>
                        </div>
                        <div class="modal-footer">
                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-primary">{{ trans('auth.send_reset_password') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CONTACT FORM -->
<div class="modal fade" id="contact_form_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="form">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">{{ trans('homepage.contact') }}</h5>
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-center w-responsive mx-auto mb-3">
                    {{ trans('homepage.contact_message') }}
                </p>
                <form id="contact_form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="md-form mb-0">
                                <label for="name">{{ trans('homepage.name') }}</label>
                                <input type="text" id="name" name="name" maxlength="50"
                                       class="form-control" placeholder="{{ trans('homepage.your_name') }}">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="md-form mb-0">
                                <label for="contact_email">{{ trans('homepage.mail') }}</label>
                                <input type="text" id="contact_email" name="email" maxlength="200"
                                       class="form-control" placeholder="{{ trans('homepage.your_mail') }}"
                                       value="{{ !auth()->guest() ? auth()->user()->email : '' }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="md-form">
                                <label for="message">{{ trans('homepage.message') }}</label>
                                <textarea type="text" id="message" name="message"
                                          rows="2" class="form-control md-textarea"
                                          maxlength="10000"
                                          placeholder="{{ trans('homepage.your_message') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="contact_form_recaptcha"
                             class="form-group g-recaptcha"
                             data-sitekey="{{ env('CAPTCHA_SITE_KEY') }}"></div>
                    </div>
                </form>

                <div id="contact_status_success" class="alert alert-success" style="display: none">
                    {{ trans('homepage.send_contact_success') }}
                </div>
                <div id="contact_status_data_error" class="alert alert-danger" style="display: none">
                    {{ trans('homepage.send_contact_data_error') }}
                </div>
                <div id="contact_status_server_error" class="alert alert-danger" style="display: none">
                    {{ trans('homepage.send_contact_server_error') . ' ' }}
                    <a href="mailto:contact@drivencook.fr">
                        contact@drivencook.fr
                    </a>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-center text-md-left">
                    <a id="submit_contact_form"
                       class="btn btn-primary bg-light_blue border-light_blue"
                       style="width: 100%; color: white">{{ trans('homepage.send') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TRUCK MAP -->
<div class="modal fade" id="map_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body d-flex justify-content-center">
                <div id="map_view" style="width: 100%; height:600px;"></div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL FIDELITY POINT -->
@php
    $fidelitySteps = \App\Models\FidelityStep::orderBy('step')->get();
@endphp
<div class="modal fade" id="loyaltyPointModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">{{ trans('client/global.loyalty_array') }}</h5>
                <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-hover table-striped table-bordered"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>{{ trans('client/global.step') }}</th>
                        <th>{{ trans('client/global.reduction') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($fidelitySteps as $fidelityStep)
                        <tr class="{{ $fidelityStep->step > Session::get('loyalty_point') ? 'table-danger' : 'table-success' }}">
                            <td>{{ $fidelityStep->step }}</td>
                            <td>{{ $fidelityStep->reduction }} €</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/app.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}">google.maps.event.addDomListener(window, 'load', initMap);</script>
<script type="text/javascript">
    var locations = [
            @foreach($trucks as $truck)
            @if(!empty($truck['user_with_stocks']))
        [
            '{{$truck['location']['address'].' '.$truck['location']['postcode'].' '.$truck['location']['city']}}',
            '{{$truck['location']['latitude']}}',
            '{{$truck['location']['longitude']}}',
            '{{route('client_order',['truck_id'=>$truck['id']])}}',
            '{{$truck['user_with_stocks']['pseudo']['name']}}'
        ],
        @endif
        @endforeach
    ];

    var map = new google.maps.Map(document.getElementById('map_view'), {
        zoom: 10,
        center: new google.maps.LatLng(48.856978, 2.342782),
    });

    var infowindow = new google.maps.InfoWindow();

    var marker, i;

    for (i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map,
        });

        google.maps.event.addListener(marker, 'click', (function (marker, i) {
            return function () {
                let content = Lang.get('client/global.truck_of') + locations[i][4] +
                    '<br>' + locations[i][0] +
                    '<br><br><a href="' + locations[i][3] + '">' + Lang.get('client/global.see_menu') + '</a>';
                infowindow.setContent(content);
                infowindow.open(map, marker);
            }
        })(marker, i));
    }

    $(document).ready(function () {
        $('#submit_contact_form').on('click', function () {
            let formData = new FormData;
            formData.append('name', $('#name').val());
            formData.append('email', $('#contact_email').val());
            formData.append('message', $('#message').val());
            formData.append('g-recaptcha-response', $('#contact_form').serializeArray()[3].value);

            $.ajax({
                url: '{{ route('contact_form_submit') }}',
                method: 'post',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    if (data['status'] === 'success') {
                        $('#contact_status_success').show();
                        $('#contact_status_data_error').hide();
                        $('#contact_status_server_error').hide();

                        $('#name').val('');
                        $('#contact_email').val('');
                        $('#message').val('');

                        window.setTimeout(function () {
                            $('#contact_status_success').hide();
                        }, 5000);
                    } else {
                        $('#contact_status_success').hide();
                        $('#contact_status_data_error').show();
                    }
                },
                error: function () {
                    $('#contact_status_success').hide();
                    $('#contact_status_server_error').show();
                }
            });
        });
    });

</script>

<!-- SCRIPTS -->
@if($errors->has('client_login') || $errors->has('client_registration_success')
    || $errors->has('client_login_necessary'))
    <script>
        $('#formModal_client').modal('show');
    </script>
@elseif($errors->has('franchisee_login') || $errors->has('franchisee_first_login')
        || $errors->has('franchisee_confirmation_success') || $errors->has('franchisee_login_necessary'))
    <script>
        $('#formModal_franchisee').modal('show');
    </script>
@elseif($errors->has('client_registration'))
    <script>
        $('#formModal_client').modal('show');
        $('a[href="#client_registration"]').click();
    </script>
@elseif(isset($pseudos))
    <script>
        $('#formModal_franchisee').modal('show');
        $('a[href="#franchisee_first_connexion"]').click();
    </script>
@endif

@yield('script')
</body>
</html>