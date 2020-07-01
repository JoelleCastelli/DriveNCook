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
                                <tr id="stock_{{$stock['dish_id']}}">
                                    <td>{{$stock['dish']['name']}}</td>
                                    <td>{{ trans($GLOBALS['DISH_TYPE'][$stock['dish']['category']]) }}</td>
                                    <td>{{$stock['quantity']}}</td>
                                    <td>{{$stock['unit_price']}} €</td>
                                    <td>
                                        <button class="fa fa-edit"
                                                onclick="onUpdateStockModal({{$stock['dish_id']}}, '{{$stock['dish']['name']}}', {{$stock['quantity']}}, {{$stock['unit_price']}})"
                                                data-toggle="modal"
                                                data-target="#formModalStock"></button>
                                        <button class="fa fa-trash ml-2"
                                                onclick="onRemoveStock({{$stock['dish_id']}})"></button>
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
                                <tr id="order_{{$purchase_order['id']}}">
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
                                        <button class="fa fa-edit"
                                                onclick="onUpdateOrderModal({{$purchase_order['id']}}, '{{$purchase_order['status']}}', {{$total}})"
                                                data-toggle="modal"
                                                data-target="#formModalOrder"></button>
                                        <button class="fa fa-trash ml-2"
                                                onclick="onRemoveOrder({{$purchase_order['id']}})"></button>
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

    <div class="modal fade" id="formModalStock" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="stockModalTitle">Modal title</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    {{csrf_field()}}
                    <input type="hidden" id="stockFormDishId" name="id" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="formStockQuantity">{{trans('franchisee.quantity')}}</label>
                            <input type="number" name="formPrice" id="formStockQuantity"
                                   value=""
                                   min="0"
                                   step="1"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="formStockSellPrice">{{trans('franchisee.sell_price')}}</label>
                            <input type="number" name="formPrice" id="formStockSellPrice"
                                   value=""
                                   min="0"
                                   step="0.01"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="modalStockSubmit"
                                onclick="onUpdateStockSubmit()">{{trans('franchisee.update')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModalOrder" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderModalTitle">Modal title</h5>
                    <button type="button" id="closeModal2" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    {{csrf_field()}}
                    <input type="hidden" id="orderFormId" name="id" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="orderFormStatusSelect">{{trans('franchisee.order_status')}}</label>
                            <select class="form-control" id="orderFormStatusSelect" name="status">
                                @foreach($order_status as $status)
                                    <option value="{{$status}}">{{trans($GLOBALS['PURCHASE_ORDER_STATUS'][$status])}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="modalStockSubmit"
                                onclick="onUpdateOrderSubmit()">{{trans('franchisee.update')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#stocks').DataTable();
            $('#purchase_orders').DataTable();
        });

        function onUpdateStockModal(dish_id, dish_name, quantity, unit_price) {
            document.getElementById('stockModalTitle').innerText = dish_name;
            document.getElementById('stockFormDishId').value = dish_id;
            document.getElementById('formStockQuantity').value = quantity;
            document.getElementById('formStockSellPrice').value = unit_price;
        }

        function onUpdateStockSubmit() {
            const dish_id = document.getElementById('stockFormDishId').value;
            const unit_price = document.getElementById('formStockSellPrice').value;
            const quantity = document.getElementById('formStockQuantity').value;
            if (!isNaN(dish_id)) {
                $.ajax({
                    url: '{{route('corporate.stock_update_submit')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'user_id':{{$franchisee['id']}},
                        'dish_id': dish_id,
                        'unit_price': unit_price,
                        'quantity': quantity
                    },
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            document.getElementById('closeModal').click();
                            alert('{{trans('corporate.stock_updated')}}');
                            let row = document.getElementById('stock_' + dish_id);
                            let dishName = row.getElementsByTagName('td')[0].innerText;
                            let quantityTd = row.getElementsByTagName('td')[2];
                            let priceTd = row.getElementsByTagName('td')[3];
                            priceTd.innerText = unit_price + ' €';
                            quantityTd.innerText = quantity;

                        } else {
                            alert("{{trans('franchisee.ajax_error')}}\n" + dataJ.message);
                        }
                    },
                    error: function (data) {
                        const dataJ = JSON.parse(data);
                        alert("{{trans('franchisee.ajax_error')}}\n" + dataJ.message);
                    }
                })
            }
        }

        function onRemoveStock(dish_id) {
            if (confirm('{{trans('corporate.remove_franchise_stock')}}')) {
                if (!isNaN(dish_id)) {
                    let urlB = '{{route('corporate.remove_franchisee_stock',['user_id'=>$franchisee['id'],'dish_id'=>':id'])}}';
                    urlB = urlB.replace(':id', dish_id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == dish_id) {
                                alert("{{trans('corporate.stock_removed')}}");
                                document.getElementById("stock_" + dish_id).remove();
                            } else {
                                alert("{{trans('franchisee.ajax_error')}}\n" + data);
                            }
                        },
                        error: function (data) {
                            alert("{{trans('franchisee.ajax_error')}}\n" + data);
                        }
                    })
                }
            }
        }

        function onUpdateOrderModal(id, current_status, total) {
            document.getElementById('orderModalTitle').innerText = total + " €";
            document.getElementById('orderFormId').value = id;
            document.getElementById('orderFormStatusSelect').value = current_status;
        }

        function onUpdateOrderSubmit() {
            const id = document.getElementById('orderFormId').value;
            const status = document.getElementById('orderFormStatusSelect').value;
            if (!isNaN(id)) {
                $.ajax({
                    url: '{{route('corporate.stock_order_update_submit')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'id': id,
                        'status': status
                    },
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            document.getElementById('closeModal2').click();
                            alert('{{trans('corporate.stock_updated')}}');
                            let row = document.getElementById('order_' + id);
                            let statusTd = row.getElementsByTagName('td')[3];
                            statusTd.innerText = status

                        } else {
                            alert("{{trans('franchisee.ajax_error')}}\n" + dataJ.message);
                        }
                    },
                    error: function (data) {
                        const dataJ = JSON.parse(data);
                        alert("{{trans('franchisee.ajax_error')}}\n" + dataJ.message);
                    }
                })
            }
        }

        function onRemoveOrder(id) {
            if (confirm('{{trans('corporate.remove_franchise_stock_order')}}')) {
                if (!isNaN(id)) {
                    let urlB = '{{route('corporate.remove_franchisee_purchase_order',['purchase_order_id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("{{trans('corporate.order_removed')}}");
                                document.getElementById("order_" + id).remove();
                            } else {
                                alert("{{trans('franchisee.ajax_error')}}\n" + data);
                            }
                        },
                        error: function (data) {
                            alert("{{trans('franchisee.ajax_error')}}\n" + data);
                        }
                    })
                }
            }
        }

    </script>
@endsection
