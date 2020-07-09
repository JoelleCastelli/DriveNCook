@extends('app')
@section('title')
    {{trans('event.event')}} : {{strtoupper($event['title'])}}
@endsection

@section('style')
    <style>
        .event_details {
            padding: 100px 50px;
        }
    </style>
@endsection

@section('content')

    <div class="row event_details">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ $event['title'] }}</h2>
                    <h3>{{trans('event.event_info')}}</h3>
                </div>
                <ul class="list-group list-group-flush">
                    @php $type = $event['type'] == "news" ? "public" : $event['type'] @endphp
                    <li class="list-group-item"><b>{{trans('event.event_type')}}: </b>
                        {{ trans('event.event_'.$type) }}
                    </li>

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
                            - {{$event['location']['address'].' '.$event['location']['postcode'].' '.$event['location']['city']}}
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
