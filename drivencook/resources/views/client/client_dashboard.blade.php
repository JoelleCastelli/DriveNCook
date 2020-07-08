@extends('app')

@section('title')

@endsection

@section('style')
    <style>
        .dashboard_content {
            padding: 100px 50px;
        }
    </style>
@endsection

@section('content')
    <div class="row dashboard_content">
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/account.my_info') }}</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>{{ trans('client/account.firstname') }} : </b> {{ $client['firstname'] }} </li>
                        <li class="list-group-item"><b>{{ trans('client/account.lastname') }} : </b> {{ $client['lastname'] }} </li>
                        <li class="list-group-item"><b>{{ trans('client/account.email') }} : </b> {{ $client['email'] }} </li>
                        <li class="list-group-item"><b>{{ trans('client/account.telephone') }} : </b>
                            {{ $client['telephone'] ? $client['telephone'] : trans('client/account.not_specified_m') }}
                        </li>
                        <li class="list-group-item"><b>{{ trans('client/account.birthdate') }} : </b>
                            {{ $client['birthdate'] ? DateTime::createFromFormat('Y-m-d', $client['birthdate'])->format('d/m/Y') : trans('client/account.not_specified_f') }}
                        </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="{{ route('client_account') }}" class="btn btn-light_blue">
                        {{ trans('client/account.update_submit') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/account.my_loyalty') }}</h2>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>{{ trans('client/account.my_loyalty_points') }} </b> {{ $client['loyalty_point'] }} </li>
                    </ul>
                </div>
                <div class="card-footer">
                    <a href="#" data-toggle="modal" data-target="#loyaltyPointModal" class="btn btn-light_blue">
                        {{ trans('client/account.see_loyalty_perks') }}
                    </a>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/account.latest_order') }}</h2>
                </div>
                @if($never_ordered == true)
                    <div class="card-body">
                        {{ trans('client/account.never_ordered') }}
                    </div>
                    <div class="card-footer">
                        <a href="#" data-toggle="modal" data-target="#map_modal" class="btn btn-light_blue">
                            {{ trans('homepage.find_truck') }}
                        </a>
                    </div>
                @else
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>Détails : </b><br>
                                @foreach($sale['sold_dishes'] as $sold_dish)
                                    {{ $sold_dish['quantity'] }} x {{ $sold_dish['dish']['name'] }}  - {{ $sold_dish['unit_price'] }}€/ u.<br>
                                @endforeach
                            </li>
                            @if($sale['discount_amount'])
                                <li class="list-group-item"><b>{{ trans('client/sale.sub_total') }} : </b>
                                    {{ $sale['total'] }} €
                                </li>
                                <li class="list-group-item"><b>{{ trans('client/sale.discount') }} : </b>
                                    {{ $sale['discount_amount'] }} €
                                </li>
                                <li class="list-group-item"><b>{{ trans('client/sale.total') }} : </b>
                                    {{ $sale['total'] - $sale['discount_amount'] }} €
                                </li>
                            @else
                                <li class="list-group-item"><b>{{ trans('client/sale.total') }} : </b>
                                    {{ $sale['total'] }} €
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            {{ trans('client/sale.franchisee') }}
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><b>{{ trans('client/sale.truck') }} : </b>
                                    {{ $sale['user_franchised']['pseudo']['name'] }}
                                </li>
                                <li class="list-group-item"><b>{{ trans('client/sale.franchisee_email') }} : </b>
                                    {{ $sale['user_franchised']['email'] }}
                                </li>
                                <li class="list-group-item"><b>{{ trans('client/sale.franchisee_phone') }} : </b>
                                    @if(!empty($sale['user_franchised']['telephone']))
                                        {{ $sale['user_franchised']['telephone'] }}
                                    @else
                                        {{ trans('client/account.not_specified_m') }}
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="card-footer">
                        <a href="{{ route('client_sale_display', ['id' => $sale['id']]) }}" class="btn btn-light_blue">
                            {{ trans('client/account.see_latest_order') }}
                        </a>
                        @if($can_reorder == true)
                            <a href="{{ route('client_order', ['id' => $sale['user_franchised']['truck']['id']]) }}"
                               class="btn btn-light_blue">
                                {{ trans('client/global.order_again') }}
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection