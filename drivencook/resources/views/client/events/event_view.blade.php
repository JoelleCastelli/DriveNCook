@extends('client.layout_client')
@section('title')
    {{trans('event.event')}} : {{strtoupper($event['title'])}}
@endsection

@section('content')

    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('event.event_info')}}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{trans('event.event_type')}}
                            : </b>{{trans('event.event_'.$event['type'])}}</li>
                    <li class="list-group-item">
                        <b>{{trans('event.start')}} : </b>
                        {{DateTime::createFromFormat('Y-m-d',$event['date_start'])->format('d/m/Y')}}
                    </li>
                    <li class="list-group-item">
                        <b>{{trans('event.end')}} : </b>
                        {{DateTime::createFromFormat('Y-m-d',$event['date_end'])->format('d/m/Y')}}
                    </li>
                    @if (!empty($event['location']))
                        <li class="list-group-item"><b>{{trans('event.location')}} : {{$event['location']['name']}}</b>
                            - {{$event['location']['address'].' - '.$event['location']['city'].' ('.$event['location']['postcode'].')'}}
                        </li>
                    @endif
                    <li class="list-group-item text-justify"><b>{{trans('event.description')}} : </b><br>
                        {{$event['description']}}
                    </li>
                    @if (!empty($event['location']))
                        <div class="card-footer">
                            <iframe
                                    width="100%"
                                    height="450"
                                    frameborder="0" style="border:0"
                                    src="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAPS_API_KEY')}}&q={{$event['location']['address'].' '.$event['location']['city'].' '.$event['location']['postcode']}}"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @endif

                </ul>
            </div>
        </div>
    </div>

@endsection
