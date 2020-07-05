@extends('corporate.layout_corporate')

@section('title')
    {{ trans('franchisee_update.franchisee_update') }}
@endsection

@section('content')
    <div class="content">

        @if(Session::has('success'))
            <div class="alert-success">{{ Session::get('success') }}</div>
        @endif

        @if(Session::has('error'))

            <div class="alert-danger">
                {{ trans('franchisee_update.update_error') }}
                @foreach(Session::get('error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-sm-10 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('franchisee_update_submit') }}">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="{{ $franchisee['id'] }}">
                            </div>

                            <div class="form-group">
                                <label for="lastname">{{ trans('franchisee_update.lastname') }}</label>
                                <input type="text" name="lastname" id="lastname"
                                       value="{{ $franchisee['lastname'] }}"
                                       placeholder="{{ trans('franchisee_update.set_name') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="firstname">{{ trans('franchisee_update.firstname') }}</label>
                                <input type="text" name="firstname" id="firstname"
                                       value="{{ $franchisee['firstname'] }}"
                                       placeholder="{{ trans('franchisee_update.set_firstname') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="pseudo">{{ trans('franchisee_update.pseudo') }}</label>
                                <div class="input-group">
                                    <select class="custom-select" name="pseudo" id="pseudo">
                                        @if ($franchisee['pseudo'] == '')
                                            <option selected
                                                    value="">{{ trans('franchisee_update.no_pseudo') }}</option>
                                            @foreach($pseudos as $pseudo)
                                                <option value="{{ $pseudo['id'] }}">{{ $pseudo['name'] }}</option>
                                            @endforeach
                                        @else
                                            <option selected
                                                    value="{{ $franchisee['pseudo']['id'] }}">{{ $franchisee['pseudo']['name'] }}</option>
                                            <option value="">{{ trans('franchisee_update.no_pseudo') }}</option>
                                            @foreach($pseudos as $pseudo)
                                                @if($pseudo['id'] != $franchisee['pseudo']['id'])
                                                    <option value="{{ $pseudo['id'] }}">{{ $pseudo['name'] }}</option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                {!! Form::label('birthdate', trans('franchisee_update.birthdate')) !!}
                                {!! Form::date('birthdate', date($franchisee['birthdate']), ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                <label for="email">{{ trans('franchisee_update.email') }}</label>
                                <input type="text" name="email" id="email" value="{{ $franchisee['email'] }}"
                                       placeholder="{{ trans('franchisee_update.set_email') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="telephone">{{ trans('franchisee_update.telephone') }}</label>
                                <input type="text" name="telephone" id="telephone"
                                       value="{{ $franchisee['telephone'] }}"
                                       placeholder="{{ trans('franchisee_update.set_telephone') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="driving_licence">{{ trans('franchisee_update.driving_licence') }}</label>
                                <input type="text" name="driving_licence" id="driving_licence"
                                       value="{{ $franchisee['driving_licence'] }}"
                                       placeholder="{{ trans('franchisee_update.set_driving_licence') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="social_security">{{ trans('franchisee_update.social_security') }}</label>
                                <input type="text" name="social_security" id="social_security"
                                       value="{{ $franchisee['social_security'] }}"
                                       placeholder="{{ trans('franchisee_update.set_social_security') }}"
                                       class="form-control">
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

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
                        <h3>{{ trans('franchisee_update.password_update') }}</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{route('franchisee_update_password')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="id" id="id" value="{{ $franchisee['id'] }}">

                            <div class="form-group">
                                <label for="password">{{ trans('franchisee_update.new_password') }}</label>
                                <input class="form-control" type="password" name="password" id="password"
                                       placeholder="{{ trans('franchisee_update.set_new_password') }}" minlength="6">
                                @if ($errors->has('password'))
                                    <span class="badge-danger">
                                        {{$errors->first('password')}}
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">{{ trans('franchisee_update.new_password_confirmation') }}</label>
                                <input class="form-control" type="password" name="password_confirmation"
                                       id="password_confirmation" placeholder="{{ trans('franchisee_update.set_new_password_confirmation') }}" minlength="6">
                                @if ($errors->has('password_confirmation'))
                                    <span class="badge-danger">
                                        {{$errors->first('password_confirmation')}}
                                    </span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-info">{{ trans('franchisee_update.update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection