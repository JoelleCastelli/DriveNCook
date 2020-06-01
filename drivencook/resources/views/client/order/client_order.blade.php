@extends('client.layout_client')
@section('title')
    {{ trans('client/order.title_dishes') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
        .orderIpt label {
            color: #FFFFFF;
        }
        .orderBtn {
            width: 100%;
            min-height: 60px;
            font-size: 25px;
        }
        .addToOrderBtn:hover, .delToOrderBtn:hover {
            cursor: pointer;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/order.franchisee_menu') . ' ' . $stocks[0]['user']['firstname'] . ' ' . $stocks[0]['user']['lastname'] }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="allDishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('dish.actions') }}</th>
                                    <th>{{ trans('client/order.quantity_to_order') }}</th>
                                    <th>{{ trans('dish.name') }}</th>
                                    <th>{{ trans('dish.category') }}</th>
                                    <th>{{ trans('dish.description') }}</th>
                                    <th>{{ trans('dish.diet') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($stocks as $stock)
                                    <tr>
                                        <td>
                                            <button class="text-light fa fa-plus addToOrderBtn" id="{{ $stock['dish_id'] }}"></button>
                                        </td>
                                        <td><input type="number" class="form-control qtyToOrderIpt"
                                                   id="qty{{ $stock['dish_id'] }}"
                                                   style="width: 100%"
                                                   value="0"
                                                   min="0"
                                                   max="{{ $stock['quantity'] }}"></td>
                                        <td id="name{{ $stock['dish_id'] }}">{{ $stock['dish']['name'] }}</td>
                                        <td>{{ trans('dish.category_' . strtolower($stock['dish']['category'])) }}</td>
                                        <td>{{ $stock['dish']['description'] }}</td>
                                        <td>{{ trans('dish.diet_' . strtolower($stock['dish']['diet'])) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/order.shopping_cart') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thread>
                                <tr>
                                    <th scope="col">{{ trans('dish.actions') }}</th>
                                    <th scope="col">{{ trans('client/order.quantity_ordered') }}</th>
                                    <th scope="col">{{ trans('dish.name') }}</th>
                                </tr>
                            </thread>
                            <tbody id="shopCartContent">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-light_blue orderBtn">{{ trans('client/order.order_btn') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('click', '.delToOrderBtn', function () {
            $(this).parent().parent().remove();
        });

        $(document).ready(function () {
            $('#allDishes').DataTable();

            $('.orderBtn').on('click', function () {
                let table = $('.orderDish');
                let order = {};

                console.log(table);
                for(let i = 0; i < table.length; i++) {
                    let id = table[i].id.split('_').slice(-1)[0];
                    order[id] = parseInt($('#qty' + id).val());
                }

                order['truck_id'] = window.location.href.split('/').slice(-1)[0];

                order = JSON.stringify(order);

                $.ajax({
                    url: '{{ route('client_order_submit') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'order': order,
                    },
                    success: function (data) {
                        alert(data);
                        if (data['status'] === 'success') {

                        } else {
                            let str = '';

                            if(data['errorList']) {
                                for (let i = 0; i < data['errorList'].length; i++) {
                                    str += '\n' + data['errorList'][i];
                                }
                            }
                            alert(Lang.get('client/order.create_order_error') + str);
                        }
                    },
                    error: function () {
                        alert(Lang.get('client/order.create_order_error'));
                    }
                });
            });

            $('.addToOrderBtn').on('click', function () {
                let id = $(this).attr('id');
                let ipt = $('#qty' + id);

                if(ipt && $('#ordered_' + id).length === 0) {
                    if (parseInt(ipt.val()) > 0) {
                        let quantityInput = '<input type="number" class="form-control qtyToOrderIpt" id="qty' + id + '" ' +
                            'style="width: 100%" value="' + ipt.val() + '" min="0" max="' + ipt.attr('max') + '">';

                        $('#shopCartContent').append('' +
                            '<tr class="orderDish" id="ordered_' + id + '">' +
                            '<td><button class="text-light fa fa-minus delToOrderBtn"></button></td>' +
                            '<td>' + quantityInput + '</td>' +
                            '<td>' + $('#name' + id).text() + '</td>' +
                            '</tr>'
                        );
                    }
                }
            });

            $('.qtyToOrderIpt').on('change', function () {
                let max = parseInt($(this).attr('max'));
                let min = parseInt($(this).attr('min'));
                let val = parseInt($(this).val());

                if(val > max) {
                    $(this).val(max);
                } else if(val < min) {
                    $(this).val(min);
                } else {
                    $(this).val(val);
                }
            });
        });
    </script>
@endsection