@extends('franchise.layout_franchise')
@section('title')
    {{trans('franchisee.order')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{trans('franchisee.order_info')}}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{trans('franchisee.date_order')}} : </b>{{ DateTime::createFromFormat('Y-m-d', $order['date'])->format('d/m/Y') }}</li>
                    <li class="list-group-item"><b>{{trans('franchisee.order_status')}} : </b>{{ trans('franchisee.stock_order_status_'.strtolower($order['status'])) }}</li>
                    <li class="list-group-item"><b>{{trans('franchisee.order_warehouse')}}
                            : </b>{{$order['warehouse']['name']}}</li>
                    <li class="list-group-item"><b>{{trans('franchisee.warehouse_location')}} : </b>
                        {{$order['warehouse']['location']['address'].' '.$order['warehouse']['location']['postcode'].' '.$order['warehouse']['location']['city']}}
                    </li>
                    <li class="list-group-item"><b>{{trans('franchisee.total')}} : </b>
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
                    <h2>{{trans('franchisee.products_ordered')}}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="order_product_list" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{trans('franchisee.plate')}}</th>
                                <th>{{trans('franchisee.quantity')}}</th>
                                <th>{{trans('franchisee.unit_price')}}</th>
                                <th>{{trans('franchisee.total')}}</th>
                                <th>{{trans('franchisee.quantity_sent')}}</th>
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
