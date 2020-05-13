@extends('franchise.layout_franchise')

@section('title')
    Tableau de bord de {{$franchise['firstname'].' '.$franchise['lastname']. ' ('.$franchise['pseudo']['name'].')'}}
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-indigo">Emplacement du camion :<br>
                                </b><?php
                                if (empty($truck['location'])) {
                                    echo 'Non renseigné';
                                } else {
                                    echo $truck['location']['address'] . ' (' . $truck['location']['city']['postcode'] . ')';
                                    echo '<br>';
                                    echo 'Du ' . DateTime::createFromFormat('Y-m-d', $truck['location_date_start'])->format('d/m/Y');
                                    if ($truck['location_date_end'] != null) {
                                        echo ' au ' . DateTime::createFromFormat('Y-m-d', $truck['location_date_end'])->format('d/m/Y');
                                    } else {
                                        echo ' jusqu\'à une durée indéterminée';
                                    }
                                }
                                ?>

                            </li>
                            <li class="list-group-item bg-indigo align-content-arround">
                                <a href="{{route('franchise.truck_view')}}" target="_blank" class="row text-light2">
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
                            <li class="list-group-item bg-info">Nombre de ventes (30 jours) : #TODO</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="#" target="_blank" class="row text-light2">
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
                            <li class="list-group-item bg-success">Chiffre d'affaire temps réel (mensuel) : #TODO €</li>
                            <li class="list-group-item bg-success align-content-arround">
                                <a href="#" target="_blank" class="row text-light2">
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