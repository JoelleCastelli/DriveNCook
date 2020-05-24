@extends('corporate.layout_corporate')

@section('title')
    Connexion
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="{{route('corporate_login')}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="email">{{ trans('corporate.email_address') }}</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="{{ trans('corporate.email_placeholder') }}" value="{{old('email')}}">
                    @if ($errors->has('email'))
                        <span class="badge-danger">
                            {{$errors->first('email')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">{{ trans('corporate.password') }}</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="{{ trans('corporate.password_placeholder') }}">
                    @if ($errors->has('password'))
                        <span class="badge-danger">
                            {{$errors->first('password')}}
                        </span>
                    @endif

                </div>

                <button type="submit" class="btn btn-primary">{{ trans('corporate.login') }}</button>
            </form>
        </div>
    </div>
@endsection
