@extends('corporate.layout_corporate')

@section('title')
    Liste des franchisés
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">Nombre de franchisés : {{count($franchisees)}}</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="#franchisee-list" class="row text-light2">
                                    <div class="col-10">
                                        Consulter les details
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-indigo">Prochain paiement des taxes : {{$nextPaiement}}</li>
                            <li class="list-group-item bg-indigo align-content-arround">
                                <a href="#" class="row text-light2">
                                    <div class="col-10">
                                        Consulter les details
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-5" id="franchisee-list">
        <div class="card-body">
            <table class="table table-striped mt-5">
                <thead>
                <tr>
                    <th scope="col">Nom</th>
                    <th scope="col">Prénom</th>
                    <th scope="col">Pseudo</th>
                    <th scope="col">email</th>
                </tr>
                </thead>
                <tbody>
                @foreach($franchisees as $franchisee)
                    <tr>
                        <td><i class="fa fa-users"></i> {{$franchisee['lastname']}}</td>
                        <td>{{$franchisee['firstname']}}</td>
                        <td>{{empty($franchisee['pseudo'])?'Non définie':$franchisee['pseudo']['name']}}</td>
                        <td>{{$franchisee['email']}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>



@endsection