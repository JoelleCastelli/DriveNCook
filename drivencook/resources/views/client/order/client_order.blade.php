@extends('app')

@section('title')

@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }

        .orderIpt label {
            color: #FFFFFF;
        }

        .order_btn {
            width: 100%;
            min-height: 60px;
            font-size: 25px;
            cursor: not-allowed;
        }

        .add_to_cart_btn:hover, .remove_from_cart_btn:hover {
            cursor: pointer;
        }

        #empty_cart_label {
            color: gray;
            font-style: italic;
        }

        .dish_price {
            text-align: right;
        }

        .category_title {
            margin-left: 1.5rem;
        }

        .menu_content {
            padding: 100px 50px;
        }
    </style>
@endsection
@section('content')
    <div class="row menu_content">
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h2>
                        @if(count($stocks) > 0)
                            {{ trans('client/order.franchisee_menu') . ' ' . $truck['user']['pseudo']['name'] }}
                        @else
                            {{ trans('client/order.franchisee_menu_empty') }}
                        @endif
                    </h2>
                    @if(!empty($truck['location']['postcode'])
                     && !empty($truck['location']['city'])
                     && !empty($truck['location']['address'])
                     && !empty($truck['location']['country']))
                        {{ $truck['location']['address'] . ' '
                         . $truck['location']['postcode'] . ' '
                         . $truck['location']['city'] }}
                    @endif
                </div>
                <div class="card-body">
                    @foreach($stock_by_category as $category_name => $category)
                        <div class="row mt-2">
                            <h2 class="category_title">{{ trans('client/order.category_'.$category_name) }}</h2>
                        </div>
                        <div class="row">
                            @foreach($category as $dish)
                                <div id="{{ $dish['dish_id'] }}" class="card col-5 add_to_cart_btn" style="margin: 5px;">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <h5 class="dish_name" class="card-title">{{ $dish['dish']['name'] }}</h5>
                                            </div>
                                            <div class="col-4">
                                                <p class="dish_price" class="card-text text-right">{{ $dish['unit_price'] }} €</p>
                                            </div>
                                        </div>
                                        <p class="card-text">{{ $dish['dish']['description'] }}</p>
                                        @if ($dish['dish']['diet'] != "none")
                                            <h6 class="card-subtitle mb-2 text-muted">{{ trans('dish.diet_' . strtolower($dish['dish']['diet'])) }}</h6>
                                        @endif
                                        <p class="max_quantity" style="display: none">{{ $dish['quantity'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        @if(!auth()->guest())
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h2>{{ trans('client/order.shopping_cart') }}</h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="empty_cart_label">{{ trans('client/order.cart_empty') }}</div>
                                <div id="cart" class="table-responsive" style="display: none">
                                    <table class="table table-hover table-striped table-bordered table-dark"
                                           style="width: 100%">
                                        <thread>
                                            <tr>
                                                <th scope="col">{{ trans('dish.name') }}</th>
                                                <th scope="col">{{ trans('client/order.line_price') }}</th>
                                                <th scope="col">{{ trans('client/order.quantity_ordered') }}</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thread>
                                        <tbody id="cart_content">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @if ($client['loyalty_point'] > $promotions[0]['step'])
                            <div class="row">
                                <div class="col-lg-12 mb-4">
                                    <label class="col-form-label"><b>{{ trans('client/order.discount_amount') }}</b></label>
                                    <select class="custom-select" id="discount_selection">
                                        <option value="" selected>{{ trans('client/order.select_menu_no_discount') }}</option>
                                        @if(!empty($promotions))
                                            @foreach($promotions as $promotion)
                                                @if($promotion['step'] <= $client['loyalty_point'])
                                                    <option value="{{ $promotion['reduction'] }}"
                                                            id="discount_{{ $promotion['id'] }}">
                                                        -{{ $promotion['reduction'] }} €
                                                    </option>
                                                @endif
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        @else
                            <select class="custom-select" id="discount_selection" style="display: none">
                                <option value="0" selected></option>
                            </select>
                        @endif
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="alert alert-warning" id="discountAlert" style="display: none">
                                    {{ trans('client/order.alert_discount_more_than_total') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-light_blue order_btn" disabled>{{ trans('client/order.order_btn') }}<p
                                    id="order_btn_text" style="margin-bottom: 5px"></p></button>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <img src="{{route('generate_franchise_qr',['truck_id'=>$truck['id']])}}" class="img-thumbnail"
                             alt="qr_code">
                    </div>
                </div>
            </div>
        @else
            <div class="col-4">
                <div class="card">
                    <div class="card-body">
                        {{ trans('client/order.to_order_connection_require') }}
                    </div>
                    <div class="card-footer">
                        <img src="{{route('generate_franchise_qr',['truck_id'=>$truck['id']])}}" class="img-thumbnail qr_code"
                             alt="qr_code">
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('script')
    <script type="text/javascript">

        $('.add_to_cart_btn').on('click', function () {

            if($('#cart').css('display') === 'none') {
                $('#cart').css('display', 'block');
                $('#empty_cart_label').css('display', 'none');
                $('.order_btn').css('cursor', 'pointer');
                $('.order_btn').attr("disabled", false);
            }

            let dish_id = $(this).attr('id');
            let dish_price = parseFloat($(this).find('.dish_price').text());
            let dish_name = $(this).find('.dish_name').text();
            let dish_max_quantity = $(this).find('.max_quantity').text();
            if ($('#ordered_' + dish_id).length === 0) {
                let cart_quantity_input = '<input type="number" class="form-control qtyToOrderIpt dish_cart_quantity_input" id="qty_' + dish_id + '" ' +
                    'style="width: 100%" value="1" min="1" max="'+ dish_max_quantity +'">';
                $('#cart_content').append('' +
                    '<tr class="ordered_dish" id="ordered_' + dish_id + '">' +
                    '<td>' + dish_name + '</td>' +
                    '<td id="ordered_dish_price' + dish_id + '">' + dish_price.toFixed(2) + ' €</td>' +
                    '<td>' + cart_quantity_input + '</td>' +
                    '<td><button class="text-light fa fa-trash remove_from_cart_btn"></button></td>' +
                    '</tr>'
                );
            }
            update_cart_total();
        });

        function update_cart_total() {
            let orders = $('.ordered_dish');
            let sum = 0;

            for (let i = 0; i < orders.length; i++) {
                let dish_id = orders[i].getAttribute('id').split('_').slice(-1)[0];
                let dish_line_price = parseFloat($('#ordered_dish_price' + dish_id).text());
                sum += parseFloat(dish_line_price.toFixed(2));
            }
            let temp_sum = sum;

            let discount = $('#discount_selection');
            if (discount !== '' && sum > 0) {
                sum -= discount.val();
            }

            if (orders.length > 0) {
                if (sum <= 0) {
                    $('#order_btn_text').text('{{ trans('client/order.free') }}');
                } else {
                    $('#order_btn_text').text(sum.toFixed(2) + ' €');
                }
            } else {
                $('#order_btn_text').text('');
            }

            check_discount_with_total(discount, temp_sum);

            return temp_sum;
        }

        function check_discount_with_total(elem, total) {
            if (parseInt($(elem).val(), 10) > Math.floor(total) && total > 0) {
                $('#discountAlert').show();
            } else {
                $('#discountAlert').hide();
            }
        }

        $(document).on('click', '.remove_from_cart_btn', function () {
            $(this).parent().parent().remove();
            if ($('#cart_content').children().length == 0) {
                $('#cart').css('display', 'none');
                $('#empty_cart_label').css('display', 'block');
                $('.order_btn').css('cursor', 'not-allowed');
                $('.order_btn').attr("disabled", true);
            }
            update_cart_total();
        });

        $(document).on('change', '.qtyToOrderIpt', function () {
            let max = parseInt($(this).attr('max'));
            let min = parseInt($(this).attr('min'));
            let val = parseInt($(this).val());

            if (val > max) {
                $(this).val(max);
            } else if (val < min) {
                $(this).val(min);
            } else {
                $(this).val(val);
            }
        });

        $(document).on('change', '.dish_cart_quantity_input', function () {
            let dish_id = $(this).attr('id').split('_').slice(-1)[0];
            let dish_price = $('#' + dish_id).find('.dish_price').text();
            let dish_line_price = parseFloat(dish_price) * parseInt($(this).val());
            $('#ordered_dish_price' + dish_id).text(dish_line_price.toFixed(2) + ' €');
            update_cart_total();
        });

        $(document).on('change', '#discount_selection', function () {
            check_discount_with_total($(this), update_cart_total());
        });

        $(document).ready(function () {

            $('.order_btn').on('click', function () {
                let table = $('.ordered_dish');
                let order = {};

                if (table.length > 0) {
                    for (let i = 0; i < table.length; i++) {
                        let id = table[i].id.split('_').slice(-1)[0];
                        order[id] = parseInt($('#qty_' + id).val());
                    }

                    let discountId = $('#discount_selection').find(':checked').attr('id');

                    if (discountId !== undefined) {
                        discountId = discountId.substring(discountId.lastIndexOf('_') + 1);
                    } else {
                        discountId = '';
                    }

                    order = JSON.stringify(order);

                    $.ajax({
                        url: '{{ route('client_order_submit') }}',
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'order': order,
                            'discount_id': discountId,
                            'truck_id': window.location.href.split('/').slice(-1)[0]
                        },
                        dataType: 'json',
                        success: function (data) {
                            if (data['status'] === 'success') {
                                window.location.replace('{{ route('client_order_charge') }}');
                            } else {
                                let str = '';

                                if (data['errorList']) {
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
                }
            });
        });
    </script>
@endsection