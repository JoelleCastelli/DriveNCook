@extends('app')
@section('title')
    {{ trans('client/sale.history_title') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
        .displayOrder:hover {
            cursor: pointer;
        }
        .orders_history {
            padding: 100px 50px;
        }
    </style>
@stop
@section('content')
    <div class="row orders_history">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/sale.history') }}</h2>
                </div>
                @if($sales)
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="orders_history" class="table table-hover table-striped table-bordered table-dark" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>{{ trans('client/sale.date') }}</th>
                                    <th>{{ trans('client/sale.total_price') }}</th>
                                    <th>{{ trans('client/sale.payment_method') }}</th>
                                    <th>{{ trans('client/sale.online_order') }}</th>
                                    <th>{{ trans('client/sale.status') }}</th>
                                    <th>Consulter</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <td>{{ $sale['date'] }}</td>
                                            <td>{{ $sale['total_price'] }} €</td>
                                            <td>{{ $sale['payment_method'] == null ?
                                                        trans('client/sale.not_paid') :
                                                        trans($GLOBALS['SALE_PAYMENT_METHOD'][$sale['payment_method']]) }}</td>
                                            <td>{{ $sale['online_order'] == true ?
                                                        trans('client/sale.is_order') :
                                                        trans('client/sale.is_sale') }}</td>
                                            <td>{{ trans($GLOBALS['SALE_STATUS'][$sale['status']]) }}</td>
                                            <td>
                                                <a href="{{ route('client_sale_display', ['id' => $sale['id']]) }}" style="color: inherit">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        {{ trans('client/account.never_ordered') }}
                    </div>
                    <div class="card-footer">
                        <a href="#" data-toggle="modal" data-target="#map_modal" class="btn btn-light_blue">
                            {{ trans('homepage.find_truck') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#orders_history').DataTable();
        });
    </script>
@endsection