@extends('corporate.layout_corporate')
@section('title')
    {{trans('event.event_list')}}
@endsection

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">{{ trans('event.nb_events') }} {{ count($event_list) }}</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="#event-list" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('event.view_details') }}
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

    <div class="col-12 col-xl-12 card mt-5" id="event-list">
        <div class="card-body">
            <div class="table-responsive">
                <table id="allEvents" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                        <tr>
                            <th>Type</th>
                            <th>{{ trans('event.title') }}</th>
                            <th>{{ trans('event.description') }}</th>
                            <th>{{ trans('event.city') }}</th>
                            <th>{{ trans('event.start') }}</th>
                            <th>{{ trans('event.end') }}</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event_list as $event)
                            <tr id="{{ 'row_'.$event['id']}}">
                                <td>{{ trans('event.event_'.$event['type'])}}</td>
                                <td>{{ $event['title']}}</td>
                                <td>{{ strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description']}}</td>
                                <td>{{ empty($event['location']['city'])? trans('event.location_not_specified') : $event['location']['city']}}</td>
                                <td>{{ DateTime::createFromFormat('Y-m-d', $event['date_start'])->format('d/m/Y') }}</td>
                                <td>{{ DateTime::createFromFormat('Y-m-d', $event['date_end'])->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{route('corporate.event_view',['event_id'=>$event['id']])}}">
                                        <button class="text-light fa fa-eye"></button>
                                    </a>
                                    <a class="ml-2" href="{{route('corporate.event_update',['event_id'=>$event['id']])}}">
                                        <button class="text-light fa fa-edit"></button>
                                    </a>
                                    <button onclick="deleteEvent({{$event['id']}})"
                                            class="text-light fa fa-trash ml-2"></button>
                                </td>
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
                {{ trans('event.calendar') }}
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

        function deleteEvent(id) {
            if (confirm(Lang.get('event.delete_confirm'))) {
                if (!isNaN(id)) {
                    let urlB = '{{route('event_delete',['event_id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('event.delete_success'));
                                $('#allEvents').DataTable().row('#row_' + id).remove().draw();
                            } else {
                                alert(Lang.get('event.ajax_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('event.ajax_error'));
                        }
                    })
                }
            }
        }
    </script>
@endsection