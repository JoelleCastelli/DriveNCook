@extends('corporate.layout_corporate')
@section('title')
    {{ trans('warehouse.title_view') }} : {{ strtoupper($warehouse['name']) }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('warehouse.details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <b>{{ trans('warehouse.name') }} : </b>{{ $warehouse['name'] }}
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('warehouse.address') }} : </b>
                        {{ empty($warehouse['location'])? trans('warehouse.unknown') : $warehouse['location']['address'] }}
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('warehouse.city') }} : </b>
                        {{ empty($warehouse['location'])? trans('warehouse.unknown') : $warehouse['location']['city'].' ('.$warehouse['location']['postcode'].')' }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('warehouse.sold_out_products') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('warehouse.product') }}</th>
                                <th>{{ trans('warehouse.product_category') }}</th>
                                <th>{{ trans('warehouse.product_quantity') }}</th>
                                <th>{{ trans('warehouse.product_price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouse['stock'] as $dish)
                                @if ($dish['quantity'] <= 5)
                                <tr>
                                    <td>{{ $dish['dish']['name'] }}</td>
                                    <td>{{ trans($GLOBALS['DISH_TYPE'][$dish['dish']['category']]) }}</td>
                                    <td>{{ $dish['quantity'] }}</td>
                                    <td>{{ $dish['warehouse_price'] }} €</td>
                                </tr>
                                @endif
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
                    <h2>{{ trans('warehouse.orders_section') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('warehouse.order_date') }}</th>
                                <th>{{ trans('warehouse.order_franchisee_pseudo') }}</th>
                                <th>{{ trans('warehouse.order_status') }}</th>
                                <th>{{ trans('warehouse.order_total') }}</th>
                                <th>{{ trans('warehouse.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouse['purchase_order'] as $order)
                                <tr id="order_{{ $order['id'] }}">
                                    <td>{{ $order['date'] }}</td>
                                    <td>{{ empty($order['user']['pseudo'])?trans('corporate.unknown'):$order['user']['pseudo']['name'] }}</td>
                                    <td>{{ trans($GLOBALS['PURCHASE_ORDER_STATUS'][$order['status']]) }}</td>
                                    <td>{{ $order['order_price'] }} €</td>
                                    <td>
                                        <a style="color: unset" href="{{ route('warehouse_order', ['warehouse_id'=>$warehouse['id'], 'id'=>$order['id']]) }}">
                                            <i class="fa fa-eye"></i>
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
            $('#dishes').DataTable();
            $('#orders').DataTable();
        });
    </script>
@endsection
