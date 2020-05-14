@extends('corporate.layout_corporate')
@section('title')
    Client : {{strtoupper($client['firstname'].' '.$client['lastname'])}}
@endsection

@section('content')

    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Informations du client</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Nom : </b>{{$client['lastname']}}</li>
                    <li class="list-group-item"><b>Prénom : </b>{{$client['firstname']}}</li>
                    <li class="list-group-item"><b>Email : </b>{{$client['email']}}</li>
                    <li class="list-group-item"><b>Téléphone :
                        </b>{{empty($client['telephone'])?'Non renseigné':$client['telephone']}}
                    </li>
                    <li class="list-group-item"><b>Date de naissance :
                        </b>{{empty($client['birthdate'])?'Non renseignée':
                          DateTime::createFromFormat('Y-m-d',$client['birthdate'])->format('d/m/Y')}}
                    </li>
                    <li class="list-group-item"><b>Inscrit depuis :
                        </b>{{empty($client['created_at'])?'Non renseignée':
                          DateTime::createFromFormat('Y-m-d H:i:s',$client['created_at'])->format('d/m/Y à H\hi')}}
                    </li>
                </ul>
                <div class="card-footer">
                    <a href="{{route('client_update',['id'=>$client['id']])}}">
                        <button class="btn btn-light_blue">Modifier</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Commandes du client</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="client_orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Commande en ligne</th>
                                <th>Moyen de paiement</th>
                                <th>Plats commandés</th>
                                <th>Total</th>
                                <th>Franchisé</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($client_orders as $order)
                                <tr>
                                    <td>
                                        {{DateTime::createFromFormat('Y-m-d',$order['date'])->format('Y/m/d')}}
                                    </td>
                                    <td>{{$order['online_order']?'Oui':'Non'}}</td>
                                    <td>{{$order['payment_method']}}</td>
                                    <td>{{count($order['sold_dishes'])}}</td>
                                    <td>
                                        <?php
                                        $total = 0;
                                        foreach ($order['sold_dishes'] as $sold_dish) {
                                            $total += $sold_dish['quantity'] * $sold_dish['unit_price'];
                                        }
                                        echo $total . ' €';
                                        ?>
                                    </td>
                                    <td>
                                        {{$order['user_franchised']['pseudo']['name']}}
                                        <a href="{{route('franchisee_view',['id'=>$order['user_franchised']['id']])}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <i class="fa fa-eye"></i>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#client_orders').DataTable();
        });
    </script>
@endsection