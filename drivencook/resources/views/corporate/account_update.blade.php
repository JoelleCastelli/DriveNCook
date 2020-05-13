@extends('corporate.layout_corporate')
@section('title')
    Modification du compte
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-sm-10 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('corporate.update_account_submit') }}">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="lastname">{{ trans('corporate_update.lastname') }}</label>
                            <input type="text" name="lastname" id="lastname"
                                   value="{{ $corporate['lastname'] }}"
                                   placeholder="{{ trans('corporate_update.set_name') }}"
                                   class="form-control">
                            @if ($errors->has('lastname'))
                                <span class="badge-danger">
                                    {{$errors->first('lastname')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="firstname">{{ trans('corporate_update.firstname') }}</label>
                            <input type="text" name="firstname" id="firstname"
                                   value="{{ $corporate['firstname'] }}"
                                   placeholder="{{ trans('corporate_update.set_firstname') }}"
                                   class="form-control">
                            @if ($errors->has('firstname'))
                                <span class="badge-danger">
                                    {{$errors->first('firstname')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            {!! Form::label('birthdate', trans('corporate_update.birthdate')) !!}
                            {!! Form::date('birthdate', date($corporate['birthdate']), ['class' => 'form-control']) !!}
                            @if ($errors->has('birthdate'))
                                <span class="badge-danger">
                                    {{$errors->first('birthdate')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('corporate_update.email') }}</label>
                            <input type="text" name="email" id="email" value="{{ $corporate['email'] }}"
                                   placeholder="{{ trans('corporate_update.set_email') }}"
                                   class="form-control">
                            @if ($errors->has('email'))
                                <span class="badge-danger">
                                    {{$errors->first('email')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="telephone">{{ trans('corporate_update.telephone') }}</label>
                            <input type="text" name="telephone" id="telephone"
                                   value="{{ $corporate['telephone'] }}"
                                   placeholder="{{ trans('corporate_update.set_telephone') }}"
                                   class="form-control">
                            @if ($errors->has('telephone'))
                                <span class="badge-danger">
                                    {{$errors->first('telephone')}}
                                </span>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{ trans('corporate_update.submit') }}</button>
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
                    <form action="{{route('corporate.update_password')}}" method="post">
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