@extends('franchise.layout_franchise')
@section('title')
    {{trans('event.event_list')}}
@endsection

@section('content')

    <div class="col-12 col-xl-12 card mt-5" id="event-list">
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
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($event_list as $event)
                        <tr id="{{'row_'.$event['id']}}">
                            <td>{{trans('event.event_'.$event['type'])}}</td>
                            <td>{{$event['title']}}</td>
                            <td>{{strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description']}}</td>
                            <td>{{empty($event['location']['city'])? trans('event.no-address') : $event['location']['city']}}</td>
                            <td>{{ DateTime::createFromFormat('Y-m-d', $event['date_start'])->format('d/m/Y') }}</td>
                            <td>{{ DateTime::createFromFormat('Y-m-d', $event['date_end'])->format('d/m/Y') }}</td>
                            <td><a href="{{route('franchise.event_view',['event_id'=>$event['id']])}}">
                                    <button class="fa text-light fa-eye"></button>
                                </a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-12 col-xl-12 card mt-5" id="event-list">
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
            let table = $('#allEvents').DataTable({searchPanes: true});
            table.searchPanes.container().prependTo(table.table().container());
        });

    </script>
@endsection