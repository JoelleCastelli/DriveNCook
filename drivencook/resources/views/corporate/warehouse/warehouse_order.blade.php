@extends('corporate.layout_corporate')
@section('style')

@endsection
@section('title')
    {{ trans('warehouse_order.title') }}
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="id" id="orderId" value="{{ $order[0]->po_id }}">

                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('warehouse_order.order_details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('warehouse_order.reference') }} : </b>{{ $order[0]->reference }}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_order.date') }} : </b>{{ $order[0]->date }}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_order.status') }} : </b>
                        <p style="display: inline" id="orderStatus">{{ trans($GLOBALS['PURCHASE_ORDER_STATUS'][$order[0]->status]) }}</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('warehouse_order.franchisee_details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('warehouse_order.firstname') }} : </b>{{ $franchisee[0]->firstname }}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_order.lastname') }} : </b>{{ $franchisee[0]->lastname }}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_order.pseudo') }} : </b>{{ empty($franchisee[0]->name)?
                                        trans('corporate.unknown'):$franchisee[0]->name }}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_order.email') }} : </b>{{ $franchisee[0]->email }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('warehouse_order.products_section') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="products" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('warehouse_order.product') }}</th>
                                <th>{{ trans('warehouse_order.category') }}</th>
                                <th>{{ trans('warehouse_order.quantity_to_send') }}</th>
                                <th>{{ trans('corporate.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($order as $item)
                                    <tr>
                                        <td id="rowName{{ $item->dish_id }}">{{ $item->name }}</td>
                                        <td id="rowCategory{{ $item->dish_id }}">{{ trans($GLOBALS['DISH_TYPE'][$item->category]) }}</td>
                                        <td id="rowQtyToSend{{ $item->dish_id }}">{{ $item->pd_quantity - $item->quantity_sent }}</td>
                                        <td>
                                            <i class="fa fa-edit" onclick="editDish({{ $item->dish_id }})" data-toggle="modal" data-target="#dishModal"></i>
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

    <div class="modal fade" id="dishModal" tabindex="-1" role="dialog" aria-labelledby="dishModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dishModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="dishId">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" id="dishCategory"><b>{{ trans('warehouse_order.category') }} : </b></li>
                    </ul>
                    <label for="dishQtySent" class="col-form-label">{{ trans('warehouse_order.quantity_to_send') }}</label>
                    <input type="number" class="form-control" id="dishQtySent" min="1">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('warehouse_dishes.dish_close') }}</button>
                    <button type="button" class="btn btn-primary" id="updateDish">{{ trans('warehouse_dishes.dish_update') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('#products').DataTable();

            $('#dishQtySent').on('change', function () {
                let max = parseInt($('#rowQtyToSend' + $('#dishId').val()).text());
                if($('#dishQtySent').val() > max || $('#dishQtySent').val() < 1)  {
                   $('#dishQtySent').val(-1);
                }
            });

            console.log($('#orderStatus').text());

            $('#updateDish').click(function () {
                let formData = new FormData();
                formData.append('purchase_order_id', $('#orderId').val());
                formData.append('dish_id', $('#dishId').val());
                formData.append('quantitySent', $('#dishQtySent').val());
                $.ajax({
                    url: '{{ route('warehouse_order_update_product_qty_sent') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data['status'] === 'success') {
                            let id = data['data']['dish_id'];

                            table.cell('#rowQtyToSend' + id).data(data['data']['quantity'] - data['data']['quantity_sent']).draw();

                            $('#dishModal').modal('hide');

                            $('#orderStatus').text(data['purchaseOrder']);
                        } else {
                            let str = '';
                            for(let i = 0; i < data['errorList'].length; i++) {
                                str += '\n' + data['errorList'][i];
                            }
                            alert(Lang.get('warehouse_dishes.update_dish_error') + str);
                        }
                    },
                    error: function () {
                        alert(Lang.get('warehouse_dishes.update_dish_error'));
                    }
                });
            });
        });

        function editDish(id) {
            $('#dishModalLabel').text($('#rowName' + id).text());
            $('#dishId').val(id);
            $('#dishCategory').text($('#rowCategory' + id).text());
            $('#dishQtySent').val($('#rowQtyToSend' + id).text());
            $('#dishQtySent').attr('max', $('#rowQtyToSend' + id).text());
        }

    </script>
@endsection