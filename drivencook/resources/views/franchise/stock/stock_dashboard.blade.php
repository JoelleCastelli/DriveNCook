@extends('franchise.layout_franchise')

@section('title')
    Gestion des stocks & commandes entrepôts
@endsection

@section('content')
    <div class="row">

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Historique des commandes</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="purchase_orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Entrepôt</th>
                                <th>Plats différents</th>
                                <th>Coût</th>
                                <th>Statut</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchase_order as $order)
                                <tr id="row_order_{{$order['id']}}">
                                    <td>{{$order['date']}}</td>
                                    <td>{{$order['warehouse']['name']}}</td>
                                    <td>{{count($order['purchased_dishes'])}}</td>
                                    <td><?php
                                        $total = 0;
                                        foreach ($order['purchased_dishes'] as $purchased_dish) {
                                            $total += $purchased_dish['quantity'] * $purchased_dish['unit_price'];
                                        }
                                        echo $total . ' €'
                                        ?></td>
                                    <td>{{$order['status']}}</td>
                                    <td>
                                        <a href="{{route('franchise.stock_order_view',['order_id'=>$order['id']])}}">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if ($order['status'] == "created")
                                            <button class="fa fa-ban ml-3" onclick="cancelOrder({{$order['id']}})">
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('franchise.stock_order')}}">
                        <button class="btn btn-light_blue"> Nouvelle commande</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Stocks</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stocks" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Plat</th>
                                <th>Quantité</th>
                                <th>Prix de vente</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stock as $stock_dish)
                                <tr id="row_stock_{{$stock_dish['dish_id']}}">
                                    <td>{{$stock_dish['dish']['name']}}</td>
                                    <td>{{$stock_dish['quantity']}}</td>
                                    <td class="d-flex justify-content-between">
                                        {{$stock_dish['unit_price']}} €
                                        <a href="{{route('franchise.stock_update',["dish_id"=>$stock_dish['dish_id']])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>

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
            $('#purchase_orders').DataTable();
            $('#stocks').DataTable();
        });

        function cancelOrder(id) {
            if (confirm("Voulez-vous vraiment cette commande ?")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('franchise.stock_order_cancel',['order_id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Commande annulée");
                                document.getElementById("row_order_" + id).remove();
                            } else {
                                alert("Une erreur est survenue lors de l'annulation, veuillez rafraîchir la page :\n" + data);
                            }
                        },
                        error: function (data) {
                            alert("Une erreur est survenue lors de l'annulation, veuillez rafraîchir la page :\n" + data);
                        }
                    })
                }
            }
        }

    </script>
@endsection

