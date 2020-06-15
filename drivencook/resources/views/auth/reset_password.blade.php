@extends('app')

@section('title')
    {{ trans('auth.reset_password') }}
@endsection
@section('content')
    <div class="container">
        <div class="row pt-5">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h2>{{$email.' '.trans('auth.password_reset')}}</h2>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reset_password_submit') }}" method="post">
                            {{csrf_field()}}

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

                            <div class="form-group">
                                <label for="password_confirmation">{{ trans('auth.password') }}</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                       id="password_confirmation"
                                       placeholder="{{ trans('auth.set_password') }}">
                                @if ($errors->has('password_confirmation'))
                                    <span class="badge-danger">
                                    {{ $errors->first('password_confirmation') }}
                                </span>
                                @endif

                            </div>

                            <button type="submit"
                                    class="btn btn-primary"
                                    id="submitBtn">{{ trans('franchisee.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
