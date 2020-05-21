@extends('client.layout_client')
@section('title')
    {{ trans('client/registration.title') }}
@endsection
@section('style')
    <style>
        .parallax {
            /* The image used */
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{asset('img/client_homepage.jpg')}});
            /* Set a specific height */
            height: 860px;

            /* Create the parallax scrolling effect */
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .clientTitle {
            color: #FFFFFF;
        }
        #submitBtn {
            width: 100%;
            height: 60px;
            font-size: 25px;
        }
    </style>
@stop
@section('content')
    <div class="col12 col-md-6">
        <div class="card">
            <div class="card-body">
                <form method="post" action="{{ route('registration_submit') }}">
                    <div class="form-group">
                        <label for="lastname">{{ trans('client/registration.lastname') }}</label>
                        <input type="text" name="lastname" id="lastname"
                               placeholder="{{ trans('client/registration.set_lastname') }}"
                               class="form-control"
                               maxlength="30">
                    </div>

                    <div class="form-group">
                        <label for="firstname">{{ trans('client/registration.firstname') }}</label>
                        <input type="text" name="firstname" id="firstname"
                               placeholder="{{ trans('client/registration.set_firstname') }}"
                               class="form-control"
                               maxlength="30">
                    </div>

                    <div class="form-group">
                        <label for="email">{{ trans('client/registration.email') }}</label>
                        <input type="text" name="email" id="email"
                               placeholder="{{ trans('client/registration.set_email') }}"
                               class="form-control"
                               maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="birthdate">{{ trans('client/registration.birthdate') }}</label>
                        <input type="date" name="birthdate" id="birthdate" value=""
                               class="form-control">
                    </div>


                    <div class="form-group">
                        <label for="phone">{{ trans('client/registration.phone') }}</label>
                        <input type="text" name="phone" id="phone"
                               placeholder="{{ trans('client/registration.set_phone') }}"
                               class="form-control"
                               maxlength="20">
                    </div>

                    <div class="form-group">
                        <label for="password">{{ trans('client/registration.password') }}</label>
                        <input type="password" name="password" id="password"
                               placeholder="{{ trans('client/registration.set_password') }}"
                               class="form-control"
                               maxlength="100">
                    </div>

                    <div class="form-group">
                        <label for="password_confirm">{{ trans('client/registration.password_confirm') }}</label>
                        <input type="password" name="password_confirm" id="password_confirm"
                               placeholder="{{ trans('client/registration.set_password_confirm') }}"
                               class="form-control"
                               maxlength="100">
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
@endsection