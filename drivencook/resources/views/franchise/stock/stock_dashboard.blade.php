@extends('franchise.layout_franchise')

@section('title')
    {{trans('franchisee.stock_warehouses_orders')}}
@endsection

@section('content')
    <div class="row">

        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.obligations_stock_info') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card text-light2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-indigo">{{ trans('franchisee.obligations_warehouse_percentage') }}
                                        <b>{{ $current_obligation['warehouse_percentage'] }} %</b></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-6">
                            <div class="card text-light2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item bg-info">{{ trans('franchisee.obligations_last_updated') }}
                                        <b>{{ $current_obligation['date_updated'] }}</b></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('franchisee.order_history')}}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="purchase_orders" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{trans('franchisee.date')}}</th>
                                <th>{{trans('franchisee.warehouse')}}</th>
                                <th>{{trans('franchisee.different_plate_count')}}</th>
                                <th>{{trans('franchisee.cost')}}</th>
                                <th>{{trans('franchisee.status')}}</th>
                                <th>{{trans('franchisee.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($purchase_order as $order)
                                <tr id="row_order_{{$order['id']}}">
                                    <td>{{$order['date']}}</td>
                                    <td>{{$order['warehouse']['name']}}</td>
                                    <td>{{count($order['purchased_dishes'])}}</td>
                                    <td><?php
                                        $total = 0;
                                        foreach ($order['purchased_dishes'] as $purchased_dish) {
                                            $total += $purchased_dish['quantity'] * $purchased_dish['unit_price'];
                                        }
                                        echo $total . ' €'
                                        ?></td>
                                    <td>{{ trans('franchisee.stock_order_status_'.strtolower($order['status'])) }}</td>
                                    <td>
                                        <a href="{{route('franchise.stock_order_view',['order_id'=>$order['id']])}}">
                                            <i class="text-light fa fa-eye"></i>
                                        </a>
                                        @if ($order['status'] == "created")
                                            <button class="fa fa-ban ml-3" onclick="cancelOrder({{$order['id']}})">
                                            </button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('franchise.stock_new_order')}}">
                        <button class="btn btn-light_blue">{{trans('franchisee.new_order')}}</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('franchisee.stocks')}}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stocks" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{trans('franchisee.plate')}}</th>
                                <th>{{trans('franchisee.quantity')}}</th>
                                <th>{{trans('franchisee.sell_price')}}</th>
                                <th>{{trans('franchisee.menu_available')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($stock as $stock_dish)
                                <tr id="row_stock_{{$stock_dish['dish_id']}}">
                                    <td>{{$stock_dish['dish']['name']}}</td>
                                    <td>{{$stock_dish['quantity']}}</td>
                                    <td class="d-flex justify-content-between">
                                        {{$stock_dish['unit_price']}} €
                                        <button class="fa fa-edit"
                                                onclick="onUpdateModal({{$stock_dish['dish_id']}},'{{$stock_dish['dish']['name']}}',{{$stock_dish['unit_price']}})"
                                                data-toggle="modal"
                                                data-target="#formModal">
                                        </button>

                                    </td>
                                    <td id="menu_{{$stock_dish['dish_id']}}">
                                        <?php
                                        if ($stock_dish['menu']) { ?>
                                        {{trans('franchisee.available')}} <i class="fas fa-ban"
                                                                             onclick="onUpdateMenuSubmit({{$stock_dish['dish_id']}}, 0)"></i>
                                        <?php } else { ?>
                                        {{trans('franchisee.unavailable')}} <i class="fas fa-check"
                                                                               onclick="onUpdateMenuSubmit({{$stock_dish['dish_id']}}, 1)"></i>
                                        <?php
                                        }
                                        ?>
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

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Modal title</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form>
                    {{csrf_field()}}
                    <input type="hidden" id="formId" name="id" value="">

                    <div class="modal-body">
                        <div class="form-group">
                            <label id="modalDish" for="formPrice">132</label>
                            <input type="number" name="formPrice" id="formPrice"
                                   value=""
                                   min="0"
                                   step="0.01"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="modalSubmit"
                                onclick="onUpdateSubmit()">{{trans('franchisee.update')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#purchase_orders').DataTable({
                searchPanes: true
            });
            table.searchPanes.container().prependTo(table.table().container());

            $('#stocks').DataTable();
        });

        function cancelOrder(id) {
            if (confirm('{{trans('franchisee.cancel_order_prompt')}}')) {
                if (!isNaN(id)) {
                    let urlB = '{{route('franchise.stock_order_cancel',['order_id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("{{trans('franchisee.order_cancelled')}}");
                                document.getElementById("row_order_" + id).remove();
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

        function onUpdateModal(id, name, unit_price) {
            document.getElementById('modalTitle').innerText = '{{trans('franchisee.update_sell_price')}}';
            document.getElementById('modalSubmit').innerText = '{{trans('franchisee.update')}}';
            document.getElementById('modalDish').innerText = name;
            document.getElementById('formId').value = id;
            document.getElementById('formPrice').value = unit_price;
        }

        function onUpdateSubmit() {
            const dish_id = document.getElementById('formId').value;
            const unit_price = document.getElementById('formPrice').value;
            if (!isNaN(dish_id)) {
                $.ajax({
                    url: '{{route('franchise.stock_update_submit')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'dish_id': dish_id, 'unit_price': unit_price},
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            document.getElementById('closeModal').click();
                            alert('{{trans('franchisee.sell_price_updated')}}');
                            let row = document.getElementById('row_stock_' + dish_id);
                            let dishName = row.getElementsByTagName('td')[0].innerText;
                            let priceTd = row.getElementsByTagName('td')[2];
                            priceTd.innerHTML = unit_price + ' €';
                            priceTd.innerHTML += '<button class="fa fa-edit" onclick="onUpdateModal(' + dish_id + ',\'' + dishName + '\',' + unit_price + ')" ' +
                                'data-toggle="modal" data-target="#formModal"> </button>';

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

        function onUpdateMenuSubmit(dish_id, available) {
            if (!isNaN(dish_id)) {
                $.ajax({
                    url: '{{route('franchise.stock_update_menu_available')}}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'dish_id': dish_id, 'available': available},
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            document.getElementById('closeModal').click();
                            alert('{{trans('franchisee.menu_available_updated')}}');

                            let td = document.getElementById("menu_" + dish_id)
                            if (available) {
                                td.innerHTML = '{{trans('franchisee.available')}} ' +
                                    '<i class="fas fa-ban" onclick="onUpdateMenuSubmit(' + dish_id + ', 0)"></i>';
                            } else {
                                td.innerHTML = '{{trans('franchisee.unavailable')}} ' +
                                    '<i class="fas fa-check" onclick="onUpdateMenuSubmit(' + dish_id + ', 1)"></i>';
                            }
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


    </script>
@endsection

