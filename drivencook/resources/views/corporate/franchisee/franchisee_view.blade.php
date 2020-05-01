@extends('corporate.layout_corporate')
@section('title')
    Franchisé : {{strtoupper($franchisee['firstname'].' '.$franchisee['lastname'])}}
@endsection
@section('style')
    {{--    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
    {{--    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">--}}
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>Informations du franchisé</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Nom : </b>{{$franchisee['lastname']}}</li>
                    <li class="list-group-item"><b>Prénom : </b>{{$franchisee['firstname']}}</li>
                    <li class="list-group-item"><b>Email : </b>{{$franchisee['email']}}</li>
                    <li class="list-group-item"><b>Téléphone :
                        </b>{{empty($franchisee['telephone'])?'Non renseigné':$franchisee['telephone']}}</li>
                    <li class="list-group-item"><b>Date de naissance :
                        </b>{{empty($franchisee['birthdate'])?'Non renseignée':
                                    DateTime::createFromFormat('Y-m-d',$franchisee['birthdate'])->format('d/m/Y')}}
                    </li>
                    <li class="list-group-item"><b>Status :
                        </b>{{empty($franchisee['pseudo_id'])?'Non actif':'Actif ('.$franchisee['pseudo']['name'].')'}}
                    </li>
                    <li class="list-group-item"><b>Permis de conduire :
                        </b>{{empty($franchisee['driving_licence'])?'Non renseigné':$franchisee['driving_licence']}}
                    </li>
                    <li class="list-group-item"><b>Sécurité sociale :
                        </b>{{empty($franchisee['social_security'])?'Non renseignée':$franchisee['social_security']}}
                    </li>
                </ul>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('franchisee_update',['id'=>$franchisee['id']])}}">
                        <button class="btn btn-light_blue">Aller à la page modification</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Informations camion du franchisé</h2>
                </div>
                @if (!empty($franchisee['truck']))
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>Constructeur :
                            </b>{{empty($franchisee['truck']['brand'])?'Non renseigné':$franchisee['truck']['brand']}}
                        </li>
                        <li class="list-group-item"><b>Modèle :
                            </b>{{empty($franchisee['truck']['model'])?'Non renseigné':$franchisee['truck']['model']}}
                        </li>
                        <li class="list-group-item"><b>Date d'achat :
                            </b>{{empty($franchisee['truck']['purchase_date'])?'Non renseigné':
                                DateTime::createFromFormat('Y-m-d',$franchisee['truck']['purchase_date'])->format('d/m/Y')}}
                        </li>
                        <li class="list-group-item"><b>Plaque d'immatriculation :
                            </b>{{empty($franchisee['truck']['license_plate'])?'Non renseigné':$franchisee['truck']['license_plate']}}
                        </li>
                        <li class="list-group-item"><b>Numéro d'assurance :
                            </b>{{empty($franchisee['truck']['insurance_number'])?'Non renseigné':$franchisee['truck']['insurance_number']}}
                        </li>
                        <li class="list-group-item"><b>Carburant :
                            </b>{{empty($franchisee['truck']['fuel_type'])?'Non renseigné':$franchisee['truck']['fuel_type']}}
                        </li>
                        <li class="list-group-item"><b>Puissance :
                            </b>{{empty($franchisee['truck']['horsepower'])?'Non renseigné':$franchisee['truck']['horsepower'].' CV'}}
                        </li>
                        <li class="list-group-item"><b>Charge utile :
                            </b>{{empty($franchisee['truck']['payload'])?'Non renseigné':$franchisee['truck']['payload'].' KG'}}
                        </li>
                        <li class="list-group-item"><b>État général :
                            </b>{{empty($franchisee['truck']['general_state'])?'Non renseigné':$franchisee['truck']['general_state']}}
                        </li>
                        <li class="list-group-item"><b>Dernier contrôle technique :
                            </b>{{empty($franchisee['truck']['last_safety_inspection'])?'Non renseigné':
                                DateTime::createFromFormat('Y-m-d',$franchisee['truck']['last_safety_inspection']['date'])->format('d/m/Y')
                                .' ('.$franchisee['truck']['last_safety_inspection']['truck_mileage'].' km)'}}
                        </li>
                        <li class="list-group-item"><b>Position :
                            </b>{{empty($franchisee['truck']['location'])?'Non renseigné':
                                $franchisee['truck']['location']['address'].' ('.$franchisee['truck']['location']['city']['postcode'].')'}}
                        </li>
                    </ul>
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-danger" onclick="unsetTruck({{$franchisee['truck']['id']}})">Retirer le
                            camion du franchisé
                        </button>

                        <a href="{{route('truck_update',['id'=>$franchisee['truck']['id']])}}">
                            <button class="btn btn-light_blue">Aller à la page modification</button>
                        </a>
                    </div>

                @else
                    <div class="card-body">
                        <h3>Aucun camion attribué</h3>
                    </div>
                @endif
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Temps réel (mois en cours)</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="row d-flex justify-content-center">
                                Ventes
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{$revenues['sales_count']}}</h1>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="row d-flex justify-content-center">
                                Chiffre d'affaires
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{$revenues['sales_total']}} €</h1>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="row d-flex justify-content-center">
                                Prochaine facture
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{$revenues['revenues'] == 0 ? 'Pas de CA' :
                                $revenues['sales_total'] * $revenues['obligation']['revenue_percentage'] / 100 . ' €'}}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Factures</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="licencefees" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Montant</th>
                                <th>Status</th>
                                <th>Date d'émission</th>
                                <th>Date de paiement</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($franchisee['monthly_licence_fees'] as $license_fee)
                                <tr>
                                    <td>{{$license_fee['amount'].' €'}}</td>
                                    <td>{{$license_fee['status']}}</td>
                                    <td>
                                        {{DateTime::createFromFormat('Y-m-d',$license_fee['date_emitted'])->format('d/m/Y')}}
                                    </td>
                                    <td>
                                        {{!empty($license_fee['date_paid'])?
                                        DateTime::createFromFormat('Y-m-d',$license_fee['date_paid'])->format('d/m/Y'):''}}
                                    </td>
                                    <td><i class="fa fa-edit"></i>{{$license_fee['id']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Stock</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stocks" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Produit</th>
                                <th>Catégorie</th>
                                <th>Quantité</th>
                                <th>Prix de vente</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($franchisee['stocks'] as $stock)
                                <tr>
                                    <td>{{$stock['dish']['name']}}</td>
                                    <td>{{$stock['dish']['category']}}</td>
                                    <td>{{$stock['quantity']}}</td>
                                    <td>{{$stock['unit_price']}}</td>
                                    <td>
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash ml-3"></i>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Commandes</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="purchase_orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Entrepôt</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Reference</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($franchisee['purchase_order'] as $purchase_order)
                                <tr>
                                    <td>
                                        {{DateTime::createFromFormat('Y-m-d',$purchase_order['date'])->format('d/m/Y')}}
                                    </td>
                                    <td>{{$purchase_order['purchased_dishes'][0]['dish']['warehouse']['name']}}</td>
                                    <td>
                                        <?php
                                        $total = 0;
                                        foreach ($purchase_order['purchased_dishes'] as $purchased_dish) {
                                            $total += $purchased_dish['dish']['warehouse_price'] * $purchased_dish['quantity'];
                                        }
                                        echo $total;
                                        ?> €
                                    </td>
                                    <td>{{$purchase_order['status']}}</td>
                                    <td>{{$purchase_order['reference']}}</td>
                                    <td>
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash ml-3"></i>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Ventes</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="sales" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Moyen de paiement</th>
                                <th>Commande en ligne</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($franchisee['sales'] as $sale)
                                <tr>
                                    <td>
                                        {{DateTime::createFromFormat('Y-m-d',$sale['date'])->format('d/m/Y')}}
                                    </td>
                                    <td>{{$sale['payment_method']}}</td>
                                    <td>{{$sale['online_order']?'Oui' : 'Non'}}</td>
                                    <td>
                                        <?php
                                        $total = 0;
                                        foreach ($sale['sold_dishes'] as $dish) {
                                            $price = 0;
                                            foreach ($franchisee['stocks'] as $stock) {
                                                if ($stock['dish_id'] == $dish['dish_id']) {
                                                    $price = $stock['unit_price'];
                                                    break;
                                                }
                                            }
                                            $total += $price * $dish['quantity'];
                                        }
                                        echo $total;
                                        ?> €
                                    </td>
                                    <td>
                                        <i class="fa fa-edit"></i>
                                        <i class="fa fa-trash ml-3"></i>
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
@endsection

@section('script')
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
    {{--    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>--}}
    {{--    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>--}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#licencefees').DataTable();
            $('#stocks').DataTable();
            $('#purchase_orders').DataTable();
            $('#sales').DataTable();
        });

        function unsetTruck(id) {
            if (confirm("Voulez vous vraiment retirer le camion au franchisé ?")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('unset_franchisee_truck',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                window.location.reload();
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
