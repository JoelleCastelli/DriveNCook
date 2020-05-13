@extends('franchise.layout_franchise')
@section('title')
    Modification du compte
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-sm-10 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('franchise.update_account_submit') }}">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="lastname">{{ trans('franchisee_update.lastname') }}</label>
                            <input type="text" name="lastname" id="lastname"
                                   value="{{ $franchisee['lastname'] }}"
                                   placeholder="{{ trans('franchisee_update.set_name') }}"
                                   class="form-control">
                            @if ($errors->has('lastname'))
                                <span class="badge-danger">
                                    {{$errors->first('lastname')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="firstname">{{ trans('franchisee_update.firstname') }}</label>
                            <input type="text" name="firstname" id="firstname"
                                   value="{{ $franchisee['firstname'] }}"
                                   placeholder="{{ trans('franchisee_update.set_firstname') }}"
                                   class="form-control">
                            @if ($errors->has('firstname'))
                                <span class="badge-danger">
                                    {{$errors->first('firstname')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('birthdate', trans('franchisee_update.birthdate')) !!}
                            {!! Form::date('birthdate', date($franchisee['birthdate']), ['class' => 'form-control']) !!}
                            @if ($errors->has('birthdate'))
                                <span class="badge-danger">
                                    {{$errors->first('birthdate')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('franchisee_update.email') }}</label>
                            <input type="text" name="email" id="email" value="{{ $franchisee['email'] }}"
                                   placeholder="{{ trans('franchisee_update.set_email') }}"
                                   class="form-control">
                            @if ($errors->has('email'))
                                <span class="badge-danger">
                                    {{$errors->first('email')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="telephone">{{ trans('franchisee_update.telephone') }}</label>
                            <input type="text" name="telephone" id="telephone"
                                   value="{{ $franchisee['telephone'] }}"
                                   placeholder="{{ trans('franchisee_update.set_telephone') }}"
                                   class="form-control">
                            @if ($errors->has('telephone'))
                                <span class="badge-danger">
                                    {{$errors->first('telephone')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="driving_licence">{{ trans('franchisee_update.driving_licence') }}</label>
                            <input type="text" name="driving_licence" id="driving_licence"
                                   value="{{ $franchisee['driving_licence'] }}"
                                   placeholder="{{ trans('franchisee_update.set_driving_licence') }}"
                                   class="form-control">
                            @if ($errors->has('driving_licence'))
                                <span class="badge-danger">
                                    {{$errors->first('driving_licence')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="social_security">{{ trans('franchisee_update.social_security') }}</label>
                            <input type="text" name="social_security" id="social_security"
                                   value="{{ $franchisee['social_security'] }}"
                                   placeholder="{{ trans('franchisee_update.set_social_security') }}"
                                   class="form-control">
                            @if ($errors->has('social_security'))
                                <span class="badge-danger">
                                    {{$errors->first('social_security')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{ trans('franchisee_update.submit') }}</button>
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
                    <form action="{{route('franchise.update_password')}}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="password">Nouveau mot de passe</label>
                            <input class="form-control" type="password" name="password" id="password"
                                   placeholder="nouveau mot de passe" minlength="6">
                            @if ($errors->has('password'))
                                <span class="badge-danger">
                                        {{$errors->first('password')}}
                                    </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirmation mot de passe</label>
                            <input class="form-control" type="password" name="password_confirmation"
                                   id="password_confirmation" placeholder="confirmation mot de passe" minlength="6">
                            @if ($errors->has('password_confirmation'))
                                <span class="badge-danger">
                                        {{$errors->first('password_confirmation')}}
                                    </span>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-light_blue">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection