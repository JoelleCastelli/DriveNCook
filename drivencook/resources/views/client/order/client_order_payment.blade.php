@extends('app')

@section('title')
    {{trans('client/order.summary_and_payment')}}
@endsection

@section('style')

@endsection

@section('content')

    <div class="card" style="width: 30rem; position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%)">
        <div class="card-body">
            <h5 class="card-title">{{ trans('client/order.order_summary') }}</h5>
        </div>
        <ul class="list-group list-group-flush">
            @foreach ($order['dishes'] as $dish_order)
                <li class="list-group-item">
                    {{ $dish_order['name'].' x '.$dish_order['quantity'].' ('.$dish_order['unit_price'].'€/u) : ' }}
                    <b>{{ $dish_order['quantity']*$dish_order['unit_price'] }} €</b>
                </li>
            @endforeach
                @if(!empty($discount))
                    <li class="list-group-item">
                        {{ trans('client/order.discount_amount') }} : <b>- {{ $discount['reduction'] }} €</b>
                    </li>
                @endif
        </ul>
        <div class="card-footer">
            <p>{{ trans('client/sale.select_payment_method') }}</p>
            <select class="custom-select" id="paymentSelection">
                <option selected>{{ trans('client/sale.credit_card') }}</option>
                <option value="cash">{{ trans('client/sale.cash') }}</option>
            </select>
            <br>
            <br>
            <form id="paymentForm"
                  action="{{ route('client_new_order_charge', ['total' => $order['total'] * 100, 'type' => 'cash']) }}"
                  method="POST">
                {{ csrf_field() }}
            </form>
            <form action="{{ route('client_new_order_charge', ['total' => $order['total'] * 100]) }}" method="POST">
                {{ csrf_field() }}
                @if($order['total'] != 0)
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                            data-key="{{ env('STRIPE_PUB_KEY') }}"
                            data-amount="{{ $order['total'] * 100 }}"
                            data-name="DriveNCook.fr"
                            data-description="{{ trans('client/order.order_payment') }}"
                            data-image="{{ asset('img/logo_transparent.png') }}"
                            data-locale="auto"
                            data-currency="eur"
                            data-zip-code="false"
                            data-email="{{ app('App\Http\Controllers\Franchise\StockController')->get_connected_user()['email'] }}">
                    </script>
                    <script>
                        // Hide default stripe payment button
                        document.getElementsByClassName("stripe-button-el")[0].style.display = 'none';
                    </script>
                @endif
                <button type="submit"
                        class="btn btn-light_blue"
                        id="proceedPayment"
                        style="width: 100%">
                    {{ trans('client/order.pay') }} <b>{{ $order['total'] }} €</b>
                </button>
                <input type="hidden" value="<b>{{ $order['total'] }} €</b>" id="orderTotal">
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).on('change', function () {
            if($('#paymentSelection').val() === 'cash') {
                $('#proceedPayment').html(Lang.get('client/order.truck_payment'));
            } else {
                $('#proceedPayment').html(Lang.get('client/order.pay') + ' ' + $('#orderTotal').val());
            }
        });
        $(document).ready(function () {
            $('#proceedPayment').on('click', function (e) {
                if($('#paymentSelection').val() === 'cash') {
                    e.preventDefault();
                    $('#paymentForm').submit();
                }
            })
        });
    </script>
@endsection
