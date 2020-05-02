@extends('corporate.layout_corporate')
@section('style')
@endsection
@section('title')
    Consultation d'un camion
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
                        </b>{{empty($truck['location'])?'Non renseigné':
                                $truck['location']['address'].' ('.$truck['location']['city']['postcode'].')'}}
                    </li>
                </ul>

                <div class="card-footer">
                    <a href="{{route('truck_update',['id' => $truck['id']])}}">
                        <button class="btn btn-light_blue">Modifier</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Attribution du camion</h2>
                </div>
                <div class="card-body">
                    @if (empty($truck['user']))
                        <form method="post" action="{{route('set_franchisee_truck')}}">
                            {{csrf_field()}}
                            <input type="hidden" id="truckId" name="truckId" value="{{$truck['id']}}">

                            <div class="form-group">
                                <label for="userId">Assigner le camion</label>
                                <select class="form-control" id="userId" name="userId">
                                    @foreach($unassigned as $user)
                                        <option value="{{$user['id']}}">
                                            {{
                                                 $user['firstname'] . ' '.
                                                 $user['lastname'] . ' ('.
                                                 $user['pseudo']['name'].')'
                                             }}
                                        </option>
                                    @endforeach
                                </select>

                            </div>
                            <button type="submit" class="btn btn-light_blue">Assigner</button>
                        </form>
                    @else
                        Assigné à : {{
                                    $truck['user']['firstname'].' '.
                                    $truck['user']['lastname'].' ('.
                                    $truck['user']['pseudo']['name'].')'
                                    }}
                        <br>
                        <button class="btn btn-danger mt-3" onclick="unsetTruck({{$truck['id']}})">Retirer le
                            camion du franchisé
                        </button>
                    @endif
                </div>
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
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($truck['breakdowns'] as $breakdown)
                                <tr id="row_{{$breakdown['id']}}">
                                    <td>
                                        {{DateTime::createFromFormat('Y-m-d',$breakdown['date'])->format('d/m/Y')}}
                                    </td>
                                    <td>{{$breakdown['type']}}</td>
                                    <td>{{$breakdown['description']}}</td>
                                    <td>{{$breakdown['cost']}}</td>
                                    <td>{{$breakdown['status']}}</td>
                                    <td>
                                        <a href="{{route('update_breakdown',["truckId"=>$truck['id'], "breakdownId"=>$breakdown['id']])}}">
                                            <i class="fa fa-edit ml-3"></i>
                                        </a>
                                        <button onclick="onDeleteBreakdown({{$breakdown['id']}})"
                                                class="fa fa-trash ml-3"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('add_breakdown',["truckId"=>$truck['id']])}}">
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
                                    <td>
                                        {{DateTime::createFromFormat('Y-m-d',$inspection['date'])->format('d/m/Y')}}
                                    </td>
                                    <td>{{$inspection['truck_mileage']}} km</td>
                                    <td>{{$inspection['replaced_parts']}}</td>
                                    <td>{{$inspection['drained_fluids']}}</td>
                                    <td>
                                        <a href="{{route('update_safety_inspection',['truckId'=>$truck['id'], "safetyInspectionId"=> $inspection['id']])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button onclick="onDeleteSafetyInspection({{$inspection['id']}})"
                                                class="fa fa-trash ml-3"></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('add_safety_inspection',["truckId"=>$truck['id']])}}">
                        <button class="btn btn-light_blue"> Ajouter un contrôle technique</button>
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

        function onDeleteBreakdown(id) {
            if (confirm("Voulez vous vraiment supprimer cette panne ?")) {
                if (!isNaN(id)) {
                    let urlD = '{{route('delete_breakdown',['id'=>':id'])}}';
                    urlD = urlD.replace(':id', id);
                    $.ajax({
                        url: urlD,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Panne supprimé");
                                let row = document.getElementById('row_' + id);
                                row.remove();
                            } else {
                                alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                            }
                        },
                        error: function () {
                            alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                        }
                    })

                }
            }
        }

        function onDeleteSafetyInspection(id) {
            if (confirm("Voulez vous vraiment supprimer ce contrôle technique ?")) {
                if (!isNaN(id)) {
                    let urlD = '{{route('delete_safety_inspection',['id'=>':id'])}}';
                    urlD = urlD.replace(':id', id);
                    $.ajax({
                        url: urlD,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Contrôle technique supprimé");
                                let row = document.getElementById('row_' + id);
                                row.remove();
                            } else {
                                alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                            }
                        },
                        error: function () {
                            alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                        }
                    })

                }
            }
        }
    </script>
    <script type="text/javascript" src="{{asset('js/truckScript.js')}}"></script>
@endsection

