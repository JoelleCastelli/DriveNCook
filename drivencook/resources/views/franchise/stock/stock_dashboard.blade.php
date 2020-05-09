@extends('franchise.layout_franchise')

@section('title')
    Gestion des stocks & commandes entrepôts
@endsection

@section('content')
    <div class="row">

        <div class="col-12 mb-5">
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
                                <tr id="row_{{$order['id']}}">
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
                                        <a href="{{route('franchise.stock_order_cancel',["order_id"=>$order['id']])}}">
                                            <i class="fa fa-ban"></i>
                                        </a>
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
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#purchase_orders').DataTable();
        });
    </script>
@endsection

