@extends('corporate.layout_corporate')
@section('title')
    {{ ucfirst($franchisee['firstname']).' '.strtoupper($franchisee['lastname']).' ('.$franchisee['pseudo']['name'].')' }}
    - {{ trans('franchisee.stocks') }} & {{ trans('franchisee.warehouse_orders') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.stocks') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stocks" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('franchisee.product') }}</th>
                                    <th>{{ trans('franchisee.product_category') }}</th>
                                    <th>{{ trans('franchisee.product_quantity') }}</th>
                                    <th>{{ trans('franchisee.product_sell_price') }}</th>
                                    <th>{{ trans('franchisee.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($franchisee['stocks'] as $stock)
                                    <tr>
                                        <td>{{$stock['dish']['name']}}</td>
                                        <td>{{ trans($GLOBALS['DISH_TYPE'][$stock['dish']['category']]) }}</td>
                                        <td>{{$stock['quantity']}}</td>
                                        <td>{{$stock['unit_price']}} €</td>
                                        <td>
                                            <i class="fa fa-edit"></i> @php //TODO @endphp
                                            <i class="fa fa-trash ml-3"></i> @php //TODO @endphp
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
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.warehouse_orders') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="purchase_orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('franchisee.date') }}</th>
                                    <th>{{ trans('franchisee.warehouse') }}</th>
                                    <th>{{ trans('franchisee.order_total') }}</th>
                                    <th>{{ trans('franchisee.order_status') }}</th>
                                    <th>{{ trans('franchisee.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($franchisee['purchase_order'] as $purchase_order)
                                    <tr>
                                        <td>
                                            {{ DateTime::createFromFormat('Y-m-d',$purchase_order['date'])->format('d/m/Y') }}
                                        </td>
                                        <td>{{ $purchase_order['warehouse']['name'] }}</td>
                                        <td>
                                            <?php
                                                $total = 0;
                                                foreach ($purchase_order['purchased_dishes'] as $purchased_dish) {
                                                    $total += $purchased_dish['unit_price'] * $purchased_dish['quantity'];
                                                }
                                                echo $total;
                                            ?> €
                                        </td>
                                        <td>{{ trans($GLOBALS['PURCHASE_ORDER_STATUS'][$purchase_order['status']]) }}</td>
                                        <td>
                                            <i class="fa fa-edit"></i> @php //TODO @endphp
                                            <i class="fa fa-trash ml-3"></i> @php //TODO @endphp
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
    <script>
        $('#stocks').DataTable();
        $('#purchase_orders').DataTable();
    </script>
@endsection
