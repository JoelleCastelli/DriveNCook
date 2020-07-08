@extends('app')
@section('title')
    {{ trans('client/account.title') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
        .update_forms {
            padding: 100px 50px;
        }
    </style>
@stop
@section('content')
    <div class="row update_forms">
        <div class="col-12 col-sm-10 col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>{{ trans('client/account.data') }}</h3>
                    <button id="delete_account" class="btn btn-danger">{{ trans('client/global.delete_account') }}</button>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('client_update_account_submit') }}">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="lastname">{{ trans('client/account.lastname') }}</label>
                            <input type="text" name="lastname" id="lastname"
                                   value="{{ $client['lastname'] }}"
                                   placeholder="{{ trans('client/account.set_name') }}"
                                   class="form-control">
                            @if ($errors->has('lastname'))
                                <span class="badge-danger">
                                    {{ $errors->first('lastname') }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="firstname">{{ trans('client/account.firstname') }}</label>
                            <input type="text" name="firstname" id="firstname"
                                   value="{{ $client['firstname'] }}"
                                   placeholder="{{ trans('client/account.set_firstname') }}"
                                   class="form-control">
                            @if ($errors->has('firstname'))
                                <span class="badge-danger">
                                    {{ $errors->first('firstname') }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('birthdate', trans('client/account.birthdate')) !!}
                            {!! Form::date('birthdate', date($client['birthdate']), ['class' => 'form-control']) !!}
                            @if ($errors->has('birthdate'))
                                <span class="badge-danger">
                                    {{ $errors->first('birthdate') }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('client/account.email') }}</label>
                            <input type="text" name="email" id="email" value="{{ $client['email'] }}"
                                   placeholder="{{ trans('client/account.set_email') }}"
                                   class="form-control">
                            @if ($errors->has('email'))
                                <span class="badge-danger">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="telephone">{{ trans('client/account.telephone') }}</label>
                            <input type="text" name="telephone" id="telephone"
                                   value="{{ $client['telephone'] }}"
                                   placeholder="{{ trans('client/account.set_telephone') }}"
                                   class="form-control">
                            @if ($errors->has('telephone'))
                                <span class="badge-danger">
                                    {{ $errors->first('telephone') }}
                                </span>
                            @endif
                        </div>

                        <br>
                        <div class="form-group custom-control custom-checkbox">
                            <input type="hidden" name="opt_in" value="0">
                            <input type="checkbox"
                                   name="opt_in"
                                   class="custom-control-input"
                                   id="opt_in"
                                   value="1"
                                   @if($client['opt_in'] == true)
                                       checked
                                   @endif
                                    >
                            <label class="custom-control-label"
                                   for="opt_in">{{ trans('client/account.opt_in_message') }}</label>
                        </div>
                        <br>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-light_blue">{{ trans('client/account.update_submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-10 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ trans('client/account.password_edition') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('client_update_account_password') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="password">{{ trans('client/account.new_password') }}</label>
                            <input class="form-control" type="password" name="password" id="password"
                                   placeholder="{{ trans('client/account.set_new_password') }}" minlength="6">
                            @if ($errors->has('password'))
                                <span class="badge-danger">
                                        {{ $errors->first('password') }}
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">{{ trans('client/account.password_confirm') }}</label>
                            <input class="form-control" type="password" name="password_confirmation"
                                   id="password_confirmation" placeholder="{{ trans('client/account.set_password_confirm') }}" minlength="6">
                            @if ($errors->has('password_confirmation'))
                                <span class="badge-danger">
                                        {{ $errors->first('password_confirmation') }}
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-light_blue">{{ trans('client/account.password_submit') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#delete_account').on('click', function () {
                if(confirm(Lang.get('client/global.delete_confirm_client'))) {
                    window.location.replace('{{ route('client_delete_account') }}');
                }
            });
        });
    </script>
@endsection