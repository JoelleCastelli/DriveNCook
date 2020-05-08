@extends('franchise.layout_franchise')

@section('title')
    Consultation du camion
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Informations du camion</h2>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Constructeur :
                        </b>{{empty($truck['brand'])?'Non renseigné':$truck['brand']}}
                    </li>
                    <li class="list-group-item"><b>Modèle :
                        </b>{{empty($truck['model'])?'Non renseigné':$truck['model']}}
                    </li>
                    <li class="list-group-item"><b>Date d'achat :
                        </b>{{empty($truck['purchase_date'])?'Non renseigné':
                                DateTime::createFromFormat('Y-m-d',$truck['purchase_date'])->format('d/m/Y')}}
                    </li>
                    <li class="list-group-item"><b>Plaque d'immatriculation :
                        </b>{{empty($truck['license_plate'])?'Non renseigné':$truck['license_plate']}}
                    </li>
                    <li class="list-group-item"><b>Numéro d'assurance :
                        </b>{{empty($truck['insurance_number'])?'Non renseigné':$truck['insurance_number']}}
                    </li>
                    <li class="list-group-item"><b>Carburant :
                        </b>{{empty($truck['fuel_type'])?'Non renseigné':$truck['fuel_type']}}
                    </li>
                    <li class="list-group-item"><b>Puissance :
                        </b>{{empty($truck['horsepower'])?'Non renseigné':$truck['horsepower'].' CV'}}
                    </li>
                    <li class="list-group-item"><b>Charge utile :
                        </b>{{empty($truck['payload'])?'Non renseigné':$truck['payload'].' KG'}}
                    </li>
                    <li class="list-group-item"><b>État général :
                        </b>{{empty($truck['general_state'])?'Non renseigné':$truck['general_state']}}
                    </li>
                    <li class="list-group-item"><b>Dernier contrôle technique :
                        </b>{{empty($truck['last_safety_inspection'])?'Non renseigné':
                                DateTime::createFromFormat('Y-m-d',$truck['last_safety_inspection']['date'])->format('d/m/Y')
                                .' ('.$truck['last_safety_inspection']['truck_mileage'].' km)'}}
                    </li>
                    <li class="list-group-item"><b>Position :
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
                </ul>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Historique des pannes</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="breakdowns_history" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Coût</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($truck['breakdowns'] as $breakdown)
                                <tr id="row_{{$breakdown['id']}}">
                                    <td>
                                        {{$breakdown['date']}}
                                    </td>
                                    <td>{{$breakdown['type']}}</td>
                                    <td>{{$breakdown['description']}}</td>
                                    <td>{{$breakdown['cost']}} €</td>
                                    <td>{{$breakdown['status']}}</td>
                                    <td>
                                        <a href="{{route('franchise.truck_breakdown_update',["breakdown_id"=>$breakdown['id']])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('franchise.truck_breakdown_add')}}">
                        <button class="btn btn-light_blue"> Ajouter une panne</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Historique des contrôles techniques</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="safety_inspection_history"
                               class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Kilométrage</th>
                                <th>Parties remplacés</th>
                                <th>Drainage</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($truck['safety_inspection'] as $inspection)
                                <tr id="row_{{$inspection['id']}}">
                                    <td>{{$inspection['date']}}</td>
                                    <td>{{$inspection['truck_mileage']}} km</td>
                                    <td>{{$inspection['replaced_parts']}}</td>
                                    <td>{{$inspection['drained_fluids']}}</td>
                                    <td>
                                        <a href="{{route('update_safety_inspection',['truckId'=>$truck['id'], "safetyInspectionId"=> $inspection['id']])}}">
                                            <i class="fa fa-edit"></i>TODO
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('add_safety_inspection',["truckId"=>$truck['id']])}}">
                        <button class="btn btn-light_blue"> Ajouter un contrôle technique #TODO</button>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#breakdowns_history').DataTable();
            $('#safety_inspection_history').DataTable();
        });

        let urlB = "{{route('unset_franchisee_truck',['id'=>':id'])}}";
    </script>
@endsection

