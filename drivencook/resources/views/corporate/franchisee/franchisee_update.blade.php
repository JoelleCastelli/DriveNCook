@extends('app')

@section('title')
    Modification d'un franchisé
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

        <form method="post" action="{{ route('franchisee_update_submit') }}">

            <div class="form-group">
                <input type="hidden" name="id" id="id" value="{{ $franchisee->id }}">
            </div>

            <div class="form-group">
                <label for="lastname">{{ trans('franchisee_update.lastname') }}</label>
                <input type="text" name="lastname" id="lastname"
                       value="{{ $franchisee->lastname }}" placeholder="{{ trans('franchisee_update.set_name') }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="firstname">{{ trans('franchisee_update.firstname') }}</label>
                <input type="text" name="firstname" id="firstname"
                       value="{{ $franchisee->firstname }}" placeholder="{{ trans('franchisee_update.set_firstname') }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="pseudo">{{ trans('franchisee_update.pseudo') }}</label>
                <div class="input-group">
                    <select class="custom-select" name="pseudo" id="pseudo">

                        @if ($franchisee->pseudo)
                            <option selected value="{{ $franchisee->pseudo }}">{{ $franchisee->getRelation('pseudo')->name }}</option>
                        @else
                            <option selected value="null">{{ trans('franchisee_update.set_pseudo') }}</option>
                        @endif

                        @foreach($pseudos as $pseudo)
                            <option value="{{ $pseudo->id }}">{{ $pseudo->name }}</option>
                        @endforeach

                    </select>
                </div>
            </div>


            <div class="form-group">
                <label for="birthdate">{{ trans('franchisee_update.birthdate') }}</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">{{ trans('franchisee_update.email') }}</label>
                <input type="text" name="email" id="email" value="{{ $franchisee->email }}" placeholder="{{ trans('franchisee_update.set_email') }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="telephone">{{ trans('franchisee_update.telephone') }}</label>
                <input type="text" name="telephone" id="telephone"
                       value="{{ $franchisee->telephone }}" placeholder="{{ trans('franchisee_update.set_telephone') }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="driving_licence">{{ trans('franchisee_update.driving_licence') }}</label>
                <input type="text" name="driving_licence" id="driving_licence"
                       value="{{ $franchisee->driving_licence }}" placeholder="{{ trans('franchisee_update.set_driving_licence') }}"
                       class="form-control">
            </div>

            <div class="form-group">
                <label for="social_security">{{ trans('franchisee_update.social_security') }}</label>
                <input type="text" name="social_security" id="social_security"
                       value="{{ $franchisee->social_security }}" placeholder="{{ trans('franchisee_update.set_social_security') }}"
                       class="form-control">
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <button type="submit" class="btn btn-info">{{ trans('franchisee_update.submit') }}</button>
            </div>
        </form>

    </div>

@endsection