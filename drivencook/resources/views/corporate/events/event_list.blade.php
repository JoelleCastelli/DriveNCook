@extends('corporate.layout_corporate')
@section('title')
    {{trans('corporate.event_list')}}
@endsection


@section('content')

    {{--    <div class="card">--}}
    {{--        <div class="card-body">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-12 col-md-6 col-lg-3">--}}
    {{--                    <div class="card text-light2">--}}
    {{--                        <ul class="list-group list-group-flush">--}}
    {{--                            <li class="list-group-item bg-info">Nombre d'évenements' : {{count($event_list)}}</li>--}}
    {{--                            <li class="list-group-item bg-info align-content-arround">--}}
    {{--                                <a href="#franchisee-list" class="row text-light2">--}}
    {{--                                    <div class="col-10">--}}
    {{--                                        Consulter les détails--}}
    {{--                                    </div>--}}
    {{--                                    <div class="col-2">--}}
    {{--                                        <i class="fa fa-chevron-right"></i>--}}
    {{--                                    </div>--}}
    {{--                                </a>--}}
    {{--                            </li>--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

    <div class="card mt-5" id="event-list">
        <div class="card-body">
            <div class="table-responsive">
                <table id="allEvents" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>Type</th>
                        <th>{{trans('corporate.title')}}</th>
                        <th>{{trans('corporate.description')}}</th>
                        <th>{{trans('corporate.city')}}</th>
                        <th>{{trans('corporate.start')}}</th>
                        <th>{{trans('corporate.end')}}</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($event_list as $event)
                        <tr id="{{'row_'.$event['id']}}">
                            <td>{{trans('corporate.'.$event['type'])}}</td>
                            <td>{{$event['title']}}</td>
                            <td>{{strlen($event['description']) > 100 ? substr($event['description'], 0, 100) . '...' : $event['description']}}</td>
                            <td>{{empty($event['location']['city'])? trans('franchisee.not_specified_f') : $event['location']['city']}}</td>
                            <td>{{DateTime::createFromFormat('Y-m-d',$event['date_start'])->format('d/m/Y')}}</td>
                            <td>{{DateTime::createFromFormat('Y-m-d',$event['date_end'])->format('d/m/Y')}}</td>
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
@endsection

@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            $('#allEvents').DataTable();
        });

        function deleteEvent(id) {
            if (confirm("Voulez-vous vraiment supprimer cet événement ? Toutes les données associées seront supprimées")) {
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
                                alert("Événement supprimé");
                                $('#allEvents').DataTable().row('#row_' + id).remove().draw();
                            } else {
                                alert("Une erreur est survenue lors de la suppression, veuillez rafraîchir la page");
                            }
                        },
                        error: function () {
                            alert("Une erreur est survenue lors de la suppression, veuillez rafraîchir la page");
                        }
                    })
                }
            }
        }
    </script>
@endsection