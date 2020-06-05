@extends('client.layout_client')
@section('title')
    {{ trans('client/order.title') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
        .displayOrder:hover {
            cursor: pointer;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="allOrders" class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('client/global.actions') }}</th>
                                        <th>{{ trans('client/sale.payment_method') }}</th>
                                        <th>{{ trans('client/sale.online_order') }}</th>
                                        <th>{{ trans('client/sale.date') }}</th>
                                        <th>{{ trans('client/sale.status') }}</th>
                                        <th>{{ trans('client/sale.total_price') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('client_sale_display', ['id' => $sale['id']]) }}" style="color: inherit">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $sale['payment_method'] == null ?
                                                            trans('client/sale.not_paid') :
                                                            trans($GLOBALS['SALE_PAYMENT_METHOD'][$sale['payment_method']]) }}</td>
                                                <td>{{ $sale['online_order'] == true ?
                                                            trans('client/sale.is_order') :
                                                            trans('client/sale.is_sale') }}</td>
                                                <td>{{ $sale['date'] }}</td>
                                                <td>{{ trans($GLOBALS['SALE_STATUS'][$sale['status']]) }}</td>
                                                <td>{{ $sale['total_price'] }} €</td>
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
    <script type="text/javascript">
        $(document).ready(function () {
            $('#allOrders').DataTable();
        });
    </script>
@endsection