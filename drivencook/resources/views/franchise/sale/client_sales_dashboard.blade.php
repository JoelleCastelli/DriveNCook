@extends('franchise.layout_franchise')
@section('title')
    {{trans('franchisee.sales')}}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="order_list" class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('client/sale.payment_method') }}</th>
                                        <th>{{ trans('client/sale.online_order') }}</th>
                                        <th>{{ trans('client/sale.date') }}</th>
                                        <th>{{ trans('client/sale.status') }}</th>
                                        <th>{{ trans('franchisee.sales_client') }}</th>
                                        <th>{{ trans('franchisee.sales_product_count') }}</th>
                                        <th>{{ trans('client/sale.total_price') }}</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>{{ $sale['payment_method'] == null ?
                                                            trans('client/sale.not_paid') :
                                                            trans($GLOBALS['SALE_PAYMENT_METHOD'][$sale['payment_method']]) }}</td>
                                            <td>{{ $sale['online_order'] == true ?
                                                            trans('client/sale.is_order') :
                                                            trans('client/sale.is_sale') }}</td>
                                            <td>{{ $sale['date'] }}</td>
                                            <td>{{ trans($GLOBALS['SALE_STATUS'][$sale['status']]) }}</td>
                                            <td>{{ $sale['user_client']['firstname'].' - '.$sale['user_client']['lastname'] }}</td>
                                            <td>{{ $sale['nb_product'] }}</td>
                                            <td>{{ $sale['total_price'] }} €</td>
                                            <td>
                                                <a href="{{route('franchise.view_client_sale',['sale_id'=>$sale['id']])}}"
                                                   style="color: inherit">
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
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        let table = $(document).ready(function () {
            let table = $('#order_list').DataTable({
                searchPanes: true
            });
            table.searchPanes.container().prependTo(table.table().container());
        });
    </script>

@endsection

