@extends('corporate.layout_corporate')

@section('title')
    {{ trans('franchisee_creation.franchisee_creation') }}
@endsection


@section('content')
    <div class="content">

        @if(Session::has('success'))
            <div class="alert-success">{{ Session::get('success') }}</div>
        @endif

        @if(Session::has('error'))

            <div style="padding-left: 10px" class="alert-danger">
                {{ trans('franchisee_creation.new_franchisee_error') }}
                @foreach(Session::get('error') as $error)
                    <li style="margin-left: 20px">{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-sm-10 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('franchisee_creation_submit') }}">
                            <div class="form-group">
                                <label for="lastname">{{ trans('franchisee_creation.lastname') }}</label>
                                <input type="text" name="lastname" id="lastname"
                                       placeholder="{{ trans('franchisee_creation.set_name') }}" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="firstname">{{ trans('franchisee_creation.firstname') }}</label>
                                <input type="text" name="firstname" id="firstname"
                                       placeholder="{{ trans('franchisee_creation.set_firstname') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="email">{{ trans('franchisee_creation.email') }}</label>
                                <input type="text" name="email" id="email"
                                       placeholder="{{ trans('franchisee_creation.set_email') }}"
                                       class="form-control">
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-info">{{ trans('franchisee_creation.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection