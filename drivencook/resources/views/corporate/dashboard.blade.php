@extends('corporate.layout_corporate')

@section('sidebar')
    <li class="nav-item">
        <a class="nav-link text-light2" href="#">
            <i class="fa fa-warehouse"></i>&nbsp;&nbsp;&nbsp;Entrepôts
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light2" href="#">
            <i class="fa fa-user-tie"></i>&nbsp;&nbsp;&nbsp;Franchisés
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light2" href="#">
            <i class="fa fa-user"></i>&nbsp;&nbsp;&nbsp;Clients
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light2" href="#">
            <i class="fa fa-truck"></i>&nbsp;&nbsp;&nbsp;Camions
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light2" href="#">
            <i class="fa fa-chart-line"></i>&nbsp;&nbsp;&nbsp;Revenus & Statistiques
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light2" href="#">
            <i class="fa fa-calendar-alt"></i>&nbsp;&nbsp;&nbsp;Evenements
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-light2" href="#">
            <i class="fa fa-globe"></i>&nbsp;&nbsp;&nbsp;Pays & Villes
        </a>
    </li>
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
                            <li class="list-group-item bg-info">Nombre d'entrepôts : undefined</li>
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
                            <li class="list-group-item bg-danger">Nombre de franchisés : {{count($franchisees)}}</li>
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
                            <li class="list-group-item bg-dark">Nombre de clients : undefined</li>
                            <li class="list-group-item bg-dark align-content-arround">
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
                            <li class="list-group-item bg-success">Prévision chiffre d'affaire (mensuel) : undefined</li>
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