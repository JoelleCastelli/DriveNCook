@extends('app')

@section('content')
    <div class="container h-100">
        <div class="row align-items-center h-100" style="color: black">
            <div class="col-lg-8 col-12 d-flex justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <h3 class="h3">A propos de nous</h3>
                    </div>
                    <div class="card-body">
                        <p>
                            C'est à Paris, dans le 12ème arrondissement, que s'est créée Drive'N'Cook, basée sur un concept de food trucks proposant des plats de qualité
                            à base de produits frais, bruts et majoritairement locaux.
                        </p>
                        <p>
                            Après un lancement réussi en 2013, Drive'N'Cook a décidé de s'orienter vers un système de franchise
                            et a déjà convaincu une trentaine de licenciés. Actuellement, d'autres signatures sont en cours.
                        </p>
                        <p>
                            Son ambition est de se déployer dans toute l'Ile de France avant d'envisager un développement sur d'autres régions françaises.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-12 d-flex justify-content-center">
                <div class="card">
                    <img class="card-img-top" src="{{ asset('img/sananes.png') }}" alt="Sananes">
                    <div class="card-body">
                        <h3 class="card-text">Notre père fondateur</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection