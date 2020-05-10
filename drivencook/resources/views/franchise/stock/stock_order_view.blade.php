@extends('franchise.layout_franchise')
@section('title')
    Commande
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>Informations de la commande</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Date de commande : </b>{{$order['date']}}</li>
                    <li class="list-group-item"><b>Statut de la commande : </b>{{$order['status']}}</li>
                    <li class="list-group-item"><b>Entrepôt : </b>{{$order['warehouse']['name']}}</li>
                    <li class="list-group-item"><b>Adresse de l'entrpôt : </b>
                        {{$order['warehouse']['address'].' - '.$order['warehouse']['city']['name'].
                        ' ('.$order['warehouse']['city']['postcode'].')'}}
                    </li>
                    <li class="list-group-item"><b>Total : </b>
                        <?php
                        $total = 0;
                        foreach ($order['purchased_dishes'] as $dish) {
                            $total += $dish['unit_price'] * $dish['quantity'];
                        }
                        echo $total . ' €';
                        ?>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Produits commandés</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="order_product_list" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Plat</th>
                                <th>Quantité commandé</th>
                                <th>Prix unitaire</th>
                                <th>Total</th>
                                <th>Quantité envoyé</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order['purchased_dishes'] as $dish)
                                <tr>
                                    <td>{{$dish['dish']['name']}}</td>
                                    <td>{{$dish['quantity']}}</td>
                                    <td>{{$dish['unit_price'].' €'}}</td>
                                    <td>{{$dish['unit_price'] * $dish['quantity'].' €'}}</td>
                                    <td>{{$dish['quantity_sent']}}</td>
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
            $('#order_product_list').DataTable();
        });
    </script>
@endsection
