@extends('corporate.layout_corporate')

@section('title')
    Modification d'un client
@endsection


@section('content')
    <div class="content">

        <div class="row">
            <div class="col-12 col-sm-10 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('client_update_submit') }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="{{ $client['id'] }}">
                            </div>

                            <div class="form-group">
                                <label for="lastname">{{ trans('client_update.lastname') }}</label>
                                <input type="text" name="lastname" id="lastname"
                                       value="{{ $client['lastname'] }}"
                                       placeholder="{{ trans('client_update.set_name') }}"
                                       class="form-control">
                                @if ($errors->has('lastname'))
                                    <span class="badge-danger">
                                    {{$errors->first('lastname')}}
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="firstname">{{ trans('client_update.firstname') }}</label>
                                <input type="text" name="firstname" id="firstname"
                                       value="{{ $client['firstname'] }}"
                                       placeholder="{{ trans('client_update.set_firstname') }}"
                                       class="form-control">
                                @if ($errors->has('firstname'))
                                    <span class="badge-danger">
                                    {{$errors->first('firstname')}}
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('birthdate', trans('client_update.birthdate')) !!}
                                {!! Form::date('birthdate', date($client['birthdate']), ['class' => 'form-control']) !!}
                                @if ($errors->has('birthdate'))
                                    <span class="badge-danger">
                                    {{$errors->first('birthdate')}}
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="email">{{ trans('client_update.email') }}</label>
                                <input type="text" name="email" id="email" value="{{ $client['email'] }}"
                                       placeholder="{{ trans('client_update.set_email') }}"
                                       class="form-control">
                                @if ($errors->has('email'))
                                    <span class="badge-danger">
                                    {{$errors->first('email')}}
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="telephone">{{ trans('client_update.telephone') }}</label>
                                <input type="text" name="telephone" id="telephone"
                                       value="{{ $client['telephone'] }}"
                                       placeholder="{{ trans('client_update.set_telephone') }}"
                                       class="form-control">
                                @if ($errors->has('telephone'))
                                    <span class="badge-danger">
                                    {{$errors->first('telephone')}}
                                </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-info">{{ trans('client_update.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-12 col-sm-10 col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Mise à jour du mot de passe</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('client_update_password')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" id="id" value="{{ $client['id'] }}">

                            <div class="form-group">
                                <label for="password">{{ trans('client_update.new_password') }}</label>
                                <input class="form-control" type="password" name="password" id="password"
                                       placeholder="nouveau mot de passe" minlength="6">
                                @if ($errors->has('password'))
                                    <span class="badge-danger">
                                        {{$errors->first('password')}}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ trans('client_update.password_confirm') }}</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                       id="password_confirmation" placeholder="confirmation mot de passe" minlength="6">
                                @if ($errors->has('password_confirmation'))
                                    <span class="badge-danger">
                                        {{$errors->first('password_confirmation')}}
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-light_blue">{{ trans('client_update.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>

@endsection