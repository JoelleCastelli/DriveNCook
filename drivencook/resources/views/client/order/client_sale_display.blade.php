@extends('app')
@section('title')
    {{ trans('client/sale.title') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }

        .order_summary {
            padding: 100px 50px;
        }
    </style>
@endsection
@section('content')
    <div class="row order_summary">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('client/sale.sale_details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('client/sale.date') }} : </b>{{ DateTime::createFromFormat('Y-m-d', $sale['date'])->format('d/m/Y') }}</li>
                    <li class="list-group-item"><b>{{ trans('client/sale.online_order') }} : </b>{{ $sale['online_order'] == true ?
                                                            trans('client/sale.is_order') :
                                                            trans('client/sale.is_sale') }}</li>
                    <li class="list-group-item"><b>{{ trans('client/sale.status') }}
                            : </b>{{ trans($GLOBALS['SALE_STATUS'][$sale['status']]) }}</li>
                    <li class="list-group-item"><b>{{ trans('client/sale.payment_method') }} : </b>{{ $sale['payment_method'] == null ?
                                                            trans('client/sale.not_paid') :
                                                            trans($GLOBALS['SALE_PAYMENT_METHOD'][$sale['payment_method']]) }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('client/sale.total_price') }}
                            : </b>{{ $sale['total_price'] }} €
                    </li>
                    <li class="list-group-item"><b> {{ trans('client/sale.see_invoice') }}
                            <a class="ml-2" href="{{ route('stream_client_invoice_pdf',['id' => $invoice['id']]) }}" target="_blank">
                            <button class="text-dark fa fa-file-pdf ml-3"></button>
                            </a></b>
                    </li>
                    <li>@if($sale['online_order'] == true && $sale['status'] != 'done')
                            <button class="btn btn-danger"
                                    id="cancelOrderBtn"
                                    style="width: 100%">{{ trans('client/sale.cancel_order') }}</button>
                        @endif</li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('client/sale.franchisee_details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('franchisee.franchise') }} : </b>{{ '[' .
                                                            $sale['user_franchised']['pseudo']['name'] . '] ' .
                                                            $sale['user_franchised']['firstname'] . ' ' .
                                                            $sale['user_franchised']['lastname'] }}</li>
                    <li class="list-group-item"><b>{{ trans('client/sale.franchisee_email') }}
                            : </b>{{ $sale['user_franchised']['email'] }}</li>
                    <li class="list-group-item"><b>{{ trans('client/sale.franchisee_phone') }}
                            : </b>{{ $sale['user_franchised']['telephone'] }}</li>
                </ul>
            </div>
        </div>

        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/sale.dishes_section') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('client/sale.product') }}</th>
                                <th>{{ trans('client/sale.category') }}</th>
                                <th>{{ trans('client/sale.description') }}</th>
                                <th>{{ trans('client/sale.diet') }}</th>
                                <th>{{ trans('client/sale.quantity') }}</th>
                                <th>{{ trans('client/sale.sale_price') }}</th>
                                <th>{{ trans('client/sale.total_price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($sale['sold_dishes'] as $soldDish)
                                    <tr>
                                        <td>{{ $soldDish['dish']['name'] }}</td>
                                        <td>{{ trans($GLOBALS['DISH_TYPE'][$soldDish['dish']['category']]) }}</td>
                                        <td>{{ $soldDish['dish']['description'] }}</td>
                                        <td>{{ trans('dish.diet_'.strtolower($soldDish['dish']['diet'])) }}</td>
                                        <td>{{ $soldDish['quantity'] }}</td>
                                        <td>{{ $soldDish['unit_price'] }} €</td>
                                        <td>{{ $soldDish['unit_price'] * $soldDish['quantity'] }} €</td>
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

            $('#cancelOrderBtn').on('click', function () {
                let url = window.location.href;
                let orderId = url.substring(url.lastIndexOf('/') + 1);

                if (confirm(Lang.get('client/sale.delete_confirm'))) {
                    if (!isNaN(parseInt(orderId))) {
                        let url_delete = '{{ route('client_order_cancel', ['id'=>':id']) }}';
                        url_delete = url_delete.replace(':id', orderId);
                        $.ajax({
                            url: url_delete,
                            method: "delete",
                            dataType: 'json',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (data) {
                                if (data['status'] === 'success') {
                                    window.location.replace('{{ route('client_sales_history') }}');
                                } else {
                                    let str = 'yo';

                                    if (data['errorList']) {
                                        for (let i = 0; i < data['errorList'].length; i++) {
                                            str += '\n' + data['errorList'][i];
                                        }
                                    }
                                    alert(Lang.get('client/sale.ajax_error') + str);
                                }
                            },
                            error: function () {
                                alert(Lang.get('client/sale.ajax_error'));
                            }
                        })
                    }
                }
            })
        });
    </script>
@endsection
