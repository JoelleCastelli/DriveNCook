@extends('franchise.layout_franchise')

@section('title')
    {{trans('franchisee.summary_and_paiement')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('franchisee.order_summary')}} :</h2>
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
                    <a href="{{route('franchise.stock_order_validate')}}" class="btn btn-light_blue">
                        {{trans('franchisee.submit_order')}} (modal paiement ici)
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection