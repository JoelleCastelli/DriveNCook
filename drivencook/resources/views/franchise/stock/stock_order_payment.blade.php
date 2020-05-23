@extends('franchise.layout_franchise')

@section('title')
    Récapitulatif et paiement
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>Récapitulatif de votre commande :</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach ($order['dishes'] as $dish_order)
                            <li class="list-group-item">
                                {{$dish_order['dish']['name'].' x '.$dish_order['quantity'].' ('.$dish_order['price'].'€/unité) : '}}
                                <b>{{$dish_order['quantity']*$dish_order['price']}} €</b>
                            </li>
                        @endforeach

                        <li class="list-group-item">
                            <b>Total : {{$order['total']}} €</b>
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <form action="{{ route('franchise.stock_order_charge', ['total' => $order['total'] * 100])}}" method="POST">
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
                        <button type="submit" class="btn btn-light_blue">Paiement de la commande</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection