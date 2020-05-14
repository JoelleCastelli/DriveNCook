@extends('corporate.layout_corporate')
@section('title')
    {{ trans('warehouse_view.title') }} : {{ strtoupper($warehouse['name']) }}
@endsection
@section('style')
    {{--    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
    {{--    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">--}}
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('warehouse_view.warehouse_details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('warehouse_view.warehouse_name') }} : </b>{{ $warehouse['name'] }}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_view.warehouse_address') }} : </b>{{ $warehouse['address'] }}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_view.warehouse_city') }} : </b>{{ empty($warehouse['city'])?
                                        trans('corporate.unknown'):$warehouse['city']['name'] }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('warehouse_view.dishes_section') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('warehouse_view.product') }}</th>
                                <th>{{ trans('warehouse_view.category') }}</th>
                                <th>{{ trans('warehouse_view.quantity') }}</th>
                                <th>{{ trans('warehouse_view.warehouse_price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouse['stock'] as $dish)
                                @if ($dish['quantity'] <= 5)
                                <tr>
                                    <td>{{ $dish['dish']['name'] }}</td>
                                    <td>{{ trans($GLOBALS['DISH_TYPE'][$dish['dish']['category']]) }}</td>
                                    <td>{{ $dish['quantity'] }}</td>
                                    <td>{{ $dish['warehouse_price'] }}</td>
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
                    <h2>{{ trans('warehouse_view.orders_section') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('warehouse_order.date') }}</th>
                                <th>{{ trans('warehouse_order.pseudo') }}</th>
                                <th>{{ trans('warehouse_order.status') }}</th>
                                <th>{{ trans('corporate.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouse['purchase_order'] as $order)
                                <tr id="order_{{ $order['id'] }}">
                                    <td>{{ $order['date'] }}</td>
                                    <td>{{ empty($order['user']['pseudo'])?trans('corporate.unknown'):$order['user']['pseudo']['name'] }}</td>
                                    <td>{{ trans($GLOBALS['PURCHASE_ORDER_STATUS'][$order['status']]) }}</td>
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