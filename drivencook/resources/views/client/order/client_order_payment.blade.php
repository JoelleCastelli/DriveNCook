@extends('client.layout_client')

@section('title')
    {{trans('client/order.summary_and_payment')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/order.order_summary') }} :</h2>
                </div>
                <div class="card-body">
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
                </div>
                <div class="card-footer">
                    <form action="{{ route('client_new_order_charge', ['total' => $order['total'] * 100]) }}" method="POST">
                        {{ csrf_field() }}
                        <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="{{ env('STRIPE_PUB_KEY') }}"
                                data-amount="{{ $order['total'] * 100 }}"
                                data-name="DriveNCook.fr"
                                data-description="Paiement de votre commande"
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
                        <button type="submit" class="btn btn-light_blue">{{ trans('client/order.pay') }} <b>{{ $order['total'] }} €</b></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection