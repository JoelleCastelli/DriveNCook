@extends('corporate.layout_corporate')

@section('sidebar')

@endsection

@section('title')
    Tableau de bord
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">Nombre d'entrepôts : {{ $nbWarehouses }}</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="{{ route('warehouse_list') }}" target="_blank" class="row text-light2">
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
                            <li class="list-group-item bg-indigo">Nombre de franchisés : {{$nbfranchisees}}</li>
                            <li class="list-group-item bg-indigo align-content-arround">
                                <a href="{{route('franchisee_list')}}" target="_blank" class="row text-light2">
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
                            <li class="list-group-item bg-danger">Nombre de clients : undefined</li>
                            <li class="list-group-item bg-danger align-content-arround">
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
                            <li class="list-group-item bg-success">Prévision chiffre d'affaire (mensuel) : {{$revenues['sales_total']}} €</li>
                            <li class="list-group-item bg-success align-content-arround">
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
@endsection