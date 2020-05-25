@extends('client.layout_client')

@section('title')
    {{ trans('auth.connection_title') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
        #submitBtn, #join_btn {
            width: 100%;
            min-height: 60px;
            font-size: 25px;
        }
        #join_message {
            color: #FFFFFF;
            font-size: 25px;
            font-weight: bold;
            text-align: justify;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('client_login') }}" method="post">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="email">{{ trans('auth.email') }}</label>
                            <input type="email" name="email" class="form-control" id="email"
                                   placeholder="{{ trans('auth.set_email') }}"
                                   value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="badge-danger">
                                    {{ $errors->first('email') }}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="password">{{ trans('auth.password') }}</label>
                            <input type="password" name="password" class="form-control" id="password"
                                   placeholder="{{ trans('auth.set_password') }}">
                            @if ($errors->has('password'))
                                <span class="badge-danger">
                                    {{ $errors->first('password') }}
                                </span>
                            @endif

                        </div>

                        <button type="submit"
                                class="btn btn-primary"
                                id="submitBtn">{{ trans('auth.connection_btn') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
                    <p id="join_message">{{ trans('client/global.join_message') }}</p>
                    <a class="btn btn-primary"
                            id="join_btn"
                            href="{{ route('registration') }}">{{ trans('auth.to_register_btn') }}</a>
        </div>
    </div>
@endsection
