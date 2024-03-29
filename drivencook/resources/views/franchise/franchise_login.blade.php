@extends('franchise.layout_franchise')

@section('title')
    Connexion
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 mb-3">
            <form action="{{route('franchise.login_submit')}}" method="post">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="email">{{trans('franchisee.email')}}</label>
                    <input type="email" name="email" class="form-control" id="email"
                           placeholder="{{trans('franchisee.enter_email')}}"
                           value="{{old('email')}}">
                    @if ($errors->has('email'))
                        <span class="badge-danger">
                            {{$errors->first('email')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">{{trans('franchisee.password')}}</label>
                    <input type="password" name="password" class="form-control" id="password"
                           placeholder="{{trans('franchisee.enter_password')}}">
                    @if ($errors->has('password'))
                        <span class="badge-danger">
                            {{$errors->first('password')}}
                        </span>
                    @endif

                </div>

                <button type="submit" class="btn btn-primary">{{trans('franchisee.login')}}</button>
            </form>
        </div>
        <div class="col-12">
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#completeRegistrationModal">
                Completer son enregistrement
            </button>

            <div class="modal fade" id="completeRegistrationModal" tabindex="-1" role="dialog"
                 aria-labelledby="completeRegistrationModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <form action="{{route('franchise.complete_registration_email')}}" method="post">

                            <div class="modal-header">
                                <h5 class="modal-title"
                                    id="completeRegistrationModalLabel">{{trans('franchisee.enter_email')}}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{csrf_field()}}
                                <div class="form-group">
                                    <label for="email_registration">{{trans('franchisee.email')}}</label>
                                    <input class="form-control" type="email" name="email" id="email_registration"
                                           placeholder="email" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">{{trans('franchisee.cancel')}}</button>
                                <button type="submit" class="btn btn-primary">{{trans('franchisee.continue')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
