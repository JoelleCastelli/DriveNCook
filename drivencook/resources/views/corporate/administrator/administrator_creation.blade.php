@extends('client.layout_client')
@section('title')
    {{ trans('administrator/creation.title') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
        #submitBtn {
            width: 100%;
            min-height: 60px;
            font-size: 25px;
        }
    </style>
@stop
@section('content')
    <div class="row">
        @if ($errors->has('admin_creation'))
            @foreach ($errors->all() as $message)
                <div style="padding: 3px" class="badge-danger">
                    {{ $message }}
                </div>
            @endforeach
        @elseif ($errors->has('admin_creation_success'))
            <span style="padding: 3px" class="badge-success">
                {{ $errors->first('admin_creation_success') }}
            </span>
        @endif
        <div class="col12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin_creation_submit') }}">
                        <div class="form-group">
                            <label for="lastname">{{ trans('administrator/creation.lastname') }}</label>
                            <input type="text" name="lastname" id="lastname"
                                   placeholder="{{ trans('administrator/creation.set_lastname') }}"
                                   class="form-control"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="firstname">{{ trans('administrator/creation.firstname') }}</label>
                            <input type="text" name="firstname" id="firstname"
                                   placeholder="{{ trans('administrator/creation.set_firstname') }}"
                                   class="form-control"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('administrator/creation.email') }}</label>
                            <input type="text" name="email" id="email"
                                   placeholder="{{ trans('administrator/creation.set_email') }}"
                                   class="form-control"
                                   maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('administrator/creation.password') }}</label>
                            <input type="password" name="password" id="password"
                                   placeholder="{{ trans('administrator/creation.set_password') }}"
                                   class="form-control"
                                   maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="password_confirm">{{ trans('administrator/creation.password_confirm') }}</label>
                            <input type="password" name="password_confirm" id="password_confirm"
                                   placeholder="{{ trans('administrator/creation.set_password_confirm') }}"
                                   class="form-control"
                                   maxlength="100">
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info"
                                    id="submitBtn">{{ trans('administrator/creation.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection