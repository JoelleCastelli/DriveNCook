@extends('corporate.layout_corporate')
@section('style')
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
@endsection

@section('title')
    Liste des camions
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="alltrucks" class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>Marque</th>
                                        <th>Modèle</th>
                                        <th>Fonctionnel</th>
                                        <th>Date d'achat</th>
                                        <th>Immatriculation</th>
                                        <th>Puissance</th>
                                        <th>Poids (vide)</th>
                                        <th>Capacité</th>
                                        <th>Etat général</th>
                                        <th>Kilometrage</th>
                                        <th>Localisation actuelle</th>
                                        <th>Disponibilité</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($trucks as $truck)
                                        <tr id="{{'row_'.$truck['id']}}">
                                            <td>{{$truck['brand']}}</td>
                                            <td>{{$truck['model']}}</td>
                                            <td>{{$truck['functional']?'Oui':'Non'}}</td>
                                            <td>{{$truck['purchase_date']}}</td>
                                            <td>{{$truck['license_plate']}}</td>
                                            <td>{{$truck['horsepower'].' chevaux'}}</td>
                                            <td>{{$truck['weight_empty'].' kg'}}</td>
                                            <td>{{$truck['payload'].' kg'}}</td>
                                            <td>{{$truck['general_state'].' %'}}</td>
                                            <td>{{empty($truck['last_safety_inspection'])?
                                        'Inconnu':$truck['last_safety_inspection']['truck_mileage'].' km'}}</td>
                                            <td>{{empty($truck['location'])?
                                        'Inconnu':$truck['location']['name']}}</td>
                                            <td>{{empty($truck['user'])?
                                        'Disponible':
                                        'Utilisé par '.strtoupper($truck['user']['firstname'].' - '.$truck['user']['lastname'])}}</td>
                                            <td>
                                                <a href="{{route('truck_view',['id'=>$truck['id']])}}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{route('truck_update',['id'=>$truck['id']])}}">
                                                    <button class="fa fa-edit ml-2"></button>
                                                </a>

                                                <button onclick="deleteTruck({{$truck['id']}})"
                                                        class="fa fa-trash ml-2"></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('script')
    <!--
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    -->
    <script type="text/javascript">
        $(document).ready(function () {
            $('#alltrucks').DataTable();
        });

        function deleteTruck(id) {
            if (confirm("Voulez vous vraiment supprimer ce camion ? Toute les données associés seront supprimés")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('truck_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Camion supprimé");
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
@endsection