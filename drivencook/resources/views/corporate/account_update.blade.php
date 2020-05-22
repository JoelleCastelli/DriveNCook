@extends('corporate.layout_corporate')
@section('title')
    {{ trans('corporate_account.page_title') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-sm-10 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('corporate.update_account_submit') }}">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="lastname">{{ trans('corporate_account.lastname') }}</label>
                            <input type="text" name="lastname" id="lastname"
                                   value="{{ $corporate['lastname'] }}"
                                   placeholder="{{ trans('corporate_account.lastname_placeholder') }}"
                                   class="form-control">
                            @if ($errors->has('lastname'))
                                <span class="badge-danger">
                                    {{$errors->first('lastname')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="firstname">{{ trans('corporate_account.firstname') }}</label>
                            <input type="text" name="firstname" id="firstname"
                                   value="{{ $corporate['firstname'] }}"
                                   placeholder="{{ trans('corporate_account.firstname_placeholder') }}"
                                   class="form-control">
                            @if ($errors->has('firstname'))
                                <span class="badge-danger">
                                    {{$errors->first('firstname')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('birthdate', trans('corporate_account.birthdate')) !!}
                            {!! Form::date('birthdate', date($corporate['birthdate']), ['class' => 'form-control']) !!}
                            @if ($errors->has('birthdate'))
                                <span class="badge-danger">
                                    {{$errors->first('birthdate')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('corporate_account.email') }}</label>
                            <input type="text" name="email" id="email" value="{{ $corporate['email'] }}"
                                   placeholder="{{ trans('corporate_account.email_placeholder') }}"
                                   class="form-control">
                            @if ($errors->has('email'))
                                <span class="badge-danger">
                                    {{$errors->first('email')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="telephone">{{ trans('corporate_account.telephone') }}</label>
                            <input type="text" name="telephone" id="telephone"
                                   value="{{ $corporate['telephone'] }}"
                                   placeholder="{{ trans('corporate_account.telephone_placeholder') }}"
                                   class="form-control">
                            @if ($errors->has('telephone'))
                                <span class="badge-danger">
                                    {{$errors->first('telephone')}}
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{ trans('corporate_account.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-10 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>{{ trans('corporate_account.pwd_update') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('corporate.update_password')}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="password">{{ trans('corporate_account.new_pwd') }}</label>
                            <input class="form-control" type="password" name="password" id="password"
                                   placeholder="{{ trans('corporate_account.new_pwd_placeholder') }}" minlength="6">
                            @if ($errors->has('password'))
                                <span class="badge-danger">
                                        {{$errors->first('password')}}
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">{{ trans('corporate_account.new_pwd_confirmation') }}</label>
                            <input class="form-control" type="password" name="password_confirmation"
                                   id="password_confirmation" placeholder="{{ trans('corporate_account.new_pwd_confirmation_placeholder') }}" minlength="6">
                            @if ($errors->has('password_confirmation'))
                                <span class="badge-danger">
                                        {{$errors->first('password_confirmation')}}
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-light_blue">{{ trans('corporate_account.update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection