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
                    {{ trans('client/global.events_for_next_7_days') }}
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{trans('event.event_type')}}</th>
                                <th>{{ trans('event.title') }}</th>
                                <th>{{ trans('event.description') }}</th>
                                <th>{{ trans('event.city') }}</th>
                                <th>{{ trans('event.start') }}</th>
                                <th>{{ trans('event.end') }}</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($events as $event)
                                <tr id="{{ 'row_'.$event['id'] }}">
                                    <td>
                                        <a href="{{ route('client.event_view',['event_id'=>$event['id']]) }}"
                                           style="color: inherit">
                                            <button class="fa fa-eye"></button>
                                        </a>
                                    </td>
                                    <td>{{ trans('event.event_'.$event['type']) }}</td>
                                    <td>{{ $event['title'] }}</td>
                                    <td>{{ strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description'] }}</td>
                                    <td>{{ empty($event['location']['city'])? trans('franchisee.not_specified_f') : $event['location']['city'] }}</td>
                                    <td>{{ $event['date_start'] }}</td>
                                    <td>{{ $event['date_end'] }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('client/global.last_order_truck') }}
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ trans('client/order.pseudo') }}</th>
                                        <th>{{ trans('client/order.franchisee') }}</th>
                                        <th>{{ trans('client/order.location_name') }}</th>
                                        <th>{{ trans('client/order.location_address') }}</th>
                                        <th>{{ trans('client/order.brand') }}</th>
                                        <th>{{ trans('client/order.model') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(!empty($sale['user_franchised'])
                                     && !empty($sale['user_franchised']['truck']['location']['address'])
                                     && !empty($sale['user_franchised']['truck']['location']['name'])
                                     && !empty($sale['user_franchised']['truck']['location']['postcode'])
                                     && !empty($sale['user_franchised']['truck']['location']['city'])
                                     && !empty($sale['user_franchised']['truck']['location']['country']))
                                        <tr>
                                            <td>
                                                <a href="{{ route('client_order', ['id'=>$sale['user_franchised']['truck']['id']]) }}"
                                                   style="color: inherit">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                            <td>{{ $sale['user_franchised']['pseudo']['name'] }}</td>
                                            <td>{{ $sale['user_franchised']['firstname'] . '  ' . $sale['user_franchised']['lastname'] }}</td>
                                            <td>{{ $sale['user_franchised']['truck']['location']['name'] }}</td>
                                            <td>{{ $sale['user_franchised']['truck']['location']['address'] . ' - '
                                                . $sale['user_franchised']['truck']['location']['postcode'] . ' - '
                                                . $sale['user_franchised']['truck']['location']['city'] . ' - '
                                                . $sale['user_franchised']['truck']['location']['country'] }}
                                            </td>
                                            <td>{{ $sale['user_franchised']['truck']['brand'] }}</td>
                                            <td>{{ $sale['user_franchised']['truck']['model'] }}</td>
                                        </tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection