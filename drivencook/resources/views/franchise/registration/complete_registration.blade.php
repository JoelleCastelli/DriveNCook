@extends('franchise.layout_franchise')
@section('title')
    Finaliser l'enregistrement : {{$email}}
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <form action="{{route('franchise.complete_registration_submit')}}" method="post">
                <input type="hidden" id="email" name="email" value="{{$email}}">
                {{csrf_field()}}

                <div class="form-group">
                    <label for="driving_licence">Permis de conduire</label>
                    <input type="text" class="form-control" id="driving_licence" name="driving_licence"
                           placeholder="Entrez votre numéro de permis de conduire" required>
                    @if ($errors->has('driving_licence'))
                        <span class="badge-danger">
                            {{$errors->first('driving_licence')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="social_security">Sécurité social</label>
                    <input type="text" class="form-control" id="social_security" name="social_security"
                           placeholder="Entrez votre numéro de sécurité social" required>
                    @if ($errors->has('social_security'))
                        <span class="badge-danger">
                            {{$errors->first('social_security')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="telephone">Téléphone</label>
                    <input type="text" class="form-control" id="telephone" name="telephone"
                           placeholder="Entre votre numéro de téléphone" required>
                    @if ($errors->has('telephone'))
                        <span class="badge-danger">
                            {{$errors->first('telephone')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password"
                           placeholder="Mot de passe" minlength="6" required>
                    @if ($errors->has('password'))
                        <span class="badge-danger">
                            {{$errors->first('password')}}
                        </span>
                    @endif
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Mot de passe confirmation</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                           placeholder="Mot de passe confirmation" minlength="6" required>
                    @if ($errors->has('password_confirmation'))
                        <span class="badge-danger">
                            {{$errors->first('password_confirmation')}}
                        </span>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Valider</button>
            </form>
        </div>
    </div>
@endsection