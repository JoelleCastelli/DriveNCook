@extends('client.layout_client')

@section('title')
    {{ trans('client/global.welcome') . ' ' . $client['firstname'] . ' ' . $client['lastname'] . ' !' }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('client/global.last_order_truck') }}</h2>
                </div>
                <div class="card-body">
                    @php
                        $neverOrdered = false
                    @endphp
                    @if(!empty($sale['user_franchised']))

                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><b>{{ trans('client/sale.franchisee') }} : </b>
                                {{ '[' . $sale['user_franchised']['pseudo']['name'] . '] '
                                       . $sale['user_franchised']['firstname'] . ' '
                                       . $sale['user_franchised']['lastname'] }}
                            </li>
                            <li class="list-group-item"><b>{{ trans('client/sale.franchisee_email') }} : </b>
                                {{ $sale['user_franchised']['email'] }}
                            </li>
                            <li class="list-group-item"><b>{{ trans('client/sale.franchisee_phone') }} : </b>
                                {{ $sale['user_franchised']['telephone'] }}
                            </li>
                            <li class="list-group-item"><b>{{ trans('client/global.franchisee_location') }} : </b>
                                @if(!empty($sale['user_franchised']['truck']['location']['name'])
                                 && !empty($sale['user_franchised']['truck']['location']['address'])
                                 && !empty($sale['user_franchised']['truck']['location']['postcode'])
                                 && !empty($sale['user_franchised']['truck']['location']['city']))

                                    {{ $sale['user_franchised']['truck']['location']['name'] }}
                                    <iframe
                                            width="100%"
                                            height="450"
                                            frameborder="0" style="border:0"
                                            src="https://www.google.com/maps/embed/v1/place?key={{
                                                    env('GOOGLE_MAPS_API_KEY')}}&q={{ $sale['user_franchised']['truck']['location']['address'] . ' '
                                                                                    . $sale['user_franchised']['truck']['location']['city'] . ' '
                                                                                    . $sale['user_franchised']['truck']['location']['postcode']}}"
                                            allowfullscreen>
                                    </iframe>
                                @else
                                    {{ trans('franchisee.unknown') }}
                                @endif
                            </li>
                        </ul>
                    @else
                        @php
                          $neverOrdered = true
                        @endphp
                        {{ trans('client/global.never_ordered') }}
                    @endif
                </div>
                <div class="card-footer">
                    @if(!$neverOrdered)
                        @if(!empty($sale['user_franchised']['truck']['id']))
                            <a href="{{ route('client_order', ['id' => $sale['user_franchised']['truck']['id']]) }}"
                               class="btn btn-light_blue">
                                {{ trans('client/global.order_again') }}
                            </a>
                        @else
                            <span class="btn btn-danger">{{ trans('client/global.no_truck_set') }}</span>
                        @endif
                    @else
                        <a href="{{ route('truck_location_list') }}"
                           class="btn btn-light_blue">
                            {{ trans('client/global.order') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection