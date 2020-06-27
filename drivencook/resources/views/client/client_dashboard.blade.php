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
    <div class="card">
        <div class="card-header">
            {{ trans('client/global.events_for_next_7_days') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allEvents" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>{{ trans('client/event.title') }}</th>
                        <th>{{ trans('client/event.description') }}</th>
                        <th>{{ trans('client/event.city') }}</th>
                        <th>{{ trans('client/event.start') }}</th>
                        <th>{{ trans('client/event.end') }}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($events as $event)
                        <tr id="{{ 'row_'.$event['id'] }}">
                            <td>{{ trans($GLOBALS['EVENT_TYPE'][$event['type']]) }}</td>
                            <td>{{ $event['title'] }}</td>
                            <td>{{ strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description'] }}</td>
                            <td>{{ empty($event['location']['city'])? trans('franchisee.not_specified_f') : $event['location']['city'] }}</td>
                            <td>{{ $event['date_start'] }}</td>
                            <td>{{ $event['date_end'] }}</td>
                            <td><a href="{{ route('client.event_view',['event_id'=>$event['id']]) }}">
                                    <button class="fa fa-eye"></button>
                                </a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-danger">
                                {{ trans('client/global.sales') . ' : ' }}
                            </li>
                            <li class="list-group-item bg-danger align-content-arround">
                                <a href="{{ route('client_sales_history') }}" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('client/global.show_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-success">Events : #TODO</li>
                            <li class="list-group-item bg-success align-content-arround">
                                <a href="#" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('client/global.show_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection