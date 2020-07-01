@extends('client.layout_client')
@section('title')
    <span class="text-light">
    </span>
@endsection

@section('content')

    <div class="col-12 col-xl-8 card mt-5 bg-dark text-light" id="event-list">
        <div class="card-header">
            <h2>
                {{trans('event.event_list')}}
            </h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allEvents" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>{{trans('event.event_type')}}</th>
                        <th>{{trans('event.title')}}</th>
                        <th>{{trans('event.description')}}</th>
                        <th>{{trans('event.city')}}</th>
                        <th>{{trans('event.start')}}</th>
                        <th>{{trans('event.end')}}</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($event_list as $event)
                        <tr id="{{'row_'.$event['id']}}">
                            <td>{{trans('event.event_'.$event['type'])}}</td>
                            <td>{{$event['title']}}</td>
                            <td>{{strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description']}}</td>
                            <td>{{empty($event['location']['city'])? trans('event.no-address') : $event['location']['city']}}</td>
                            <td>{{$event['date_start']}}</td>
                            <td>{{$event['date_end']}}</td>
                            <td><a href="{{route('client.event_view',['event_id'=>$event['id']])}}">
                                    <button class="fa fa-eye"></button>
                                </a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-8 card mt-5 bg-dark text-light" id="event-list">
        <div class="card-header">
            <h2>
                {{trans('event.calendar')}}
            </h2>
        </div>
        <div class="card-body">
            {!! $calendar_details->calendar() !!}
        </div>
    </div>
@endsection

@section('script')
    {!! $calendar_details->script() !!}
    <script type="text/javascript">

        $(document).ready(function () {
            $('#allEvents').DataTable();
        });

    </script>
@endsection