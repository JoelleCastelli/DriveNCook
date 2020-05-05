@extends('corporate.layout_corporate')
@section('title')
    Liste des clients
@endsection
@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">Nombre de clients : #todo</li>
                            <li class="list-group-item bg-info align-content-arround">
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
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-indigo">Nombre de commandes (30 jours) : #todo</li>
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

    <div class="card" id="client_list">
        <div class="card-header">
            <h2>Liste des clients</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allclients" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Inscrit depuis le</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($client_list as $client)
                        <tr id="{{'row_'.$client['id']}}">
                            <td>{{$client['lastname']}}</td>
                            <td>{{$client['firstname']}}</td>
                            <td>{{$client['telephone']}}</td>
                            <td>{{$client['email']}}</td>
                            <td>{{$client['created_at']}}</td>
                            <td>
                                <a href="{{route('client_view',['id'=>$client['id']])}}">
                                    <button class="text-light fa fa-eye"></button>
                                </a>
                                <a class="ml-2" href="{{route('client_update',['id'=>$client['id']])}}">
                                    <button class="text-light fa fa-edit"></button>
                                </a>
                                <button onclick="deleteClient({{$client['id']}})"
                                        class="text-light fa fa-trash ml-2"></button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection