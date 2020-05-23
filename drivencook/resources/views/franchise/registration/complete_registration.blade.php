@extends('franchise.layout_franchise')
@section('title')
    {{trans('franchisee.complete_registration')}} : {{$email}}
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="{{route('franchise.complete_registration_submit')}}" method="post">
                <input type="hidden" id="email" name="email" value="{{$email}}">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="driving_licence">{{trans('franchisee.driving_licence')}}</label>
                    <input type="text" class="form-control" id="driving_licence" name="driving_licence"
                           placeholder="Entrez votre numéro de permis de conduire" required>
                    @if ($errors->has('driving_licence'))
                        <span class="badge-danger">
                            {{$errors->first('driving_licence')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="social_security">{{trans('franchisee.social_security')}}</label>
                    <input type="text" class="form-control" id="social_security" name="social_security"
                           placeholder="{{trans('franchisee.enter_social_security')}}" required>
                    @if ($errors->has('social_security'))
                        <span class="badge-danger">
                            {{$errors->first('social_security')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="telephone">{{trans('franchisee.phone')}}</label>
                    <input type="text" class="form-control" id="telephone" name="telephone"
                           placeholder="{{trans('franchisee.enter_phone')}}" required>
                    @if ($errors->has('telephone'))
                        <span class="badge-danger">
                            {{$errors->first('telephone')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">{{trans('franchisee.password')}}</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="{{trans('franchisee.enter_password')}}" minlength="6" required>
                    @if ($errors->has('password'))
                        <span class="badge-danger">
                            {{$errors->first('password')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation">{{trans('franchisee.password_confirmation')}}</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           placeholder="{{trans('franchisee.enter_password')}}" minlength="6" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="badge-danger">
                            {{$errors->first('password_confirmation')}}
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">{{trans('franchisee.submit')}}</button>
            </form>
        </div>
    </div>
@endsection