@extends('app')

@section('title')
    Création de franchisé
@endsection


@section('content')
    <div class="content">

        @if(Session::has('success'))
            <div class="alert-success">{{ Session::get('success') }}</div>
        @endif

        @if(Session::has('error'))

            <div class="alert-danger">
                {{ trans('franchisee_creation.new_franchisee_error') }}
                @foreach(Session::get('error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif


        <form method="post" action="{{ route('franchisee_creation_submit') }}">
            <div class="form-group">
                <label for="lastname">{{ trans('franchisee_creation.lastname') }}</label>
                <input type="text" name="lastname" id="lastname"
                       placeholder="{{ trans('franchisee_creation.set_name') }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="firstname">{{ trans('franchisee_creation.firstname') }}</label>
                <input type="text" name="firstname" id="firstname"
                       placeholder="{{ trans('franchisee_creation.set_firstname') }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="email">{{ trans('franchisee_creation.email') }}</label>
                <input type="text" name="email" id="email" placeholder="{{ trans('franchisee_creation.set_email') }}"
                       class="form-control">
            </div>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <button type="submit" class="btn btn-info">{{ trans('franchisee_creation.submit') }}</button>
            </div>
        </form>

    </div>

@endsection