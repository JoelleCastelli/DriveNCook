@extends('corporate.layout_corporate')
@section('title')
    {{trans('corporate.event')}} : {{strtoupper($event['title'])}}
@endsection

@section('content')

    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('corporate.event_info')}}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Type : </b>{{trans('corporate.'.$event['type'])}}</li>
                    <li class="list-group-item">
                        <b>{{trans('corporate.start')}} : </b>
                        {{DateTime::createFromFormat('Y-m-d',$event['date_start'])->format('d/m/Y')}}
                    </li>
                    <li class="list-group-item">
                        <b>{{trans('corporate.end')}} : </b>
                        {{DateTime::createFromFormat('Y-m-d',$event['date_end'])->format('d/m/Y')}}
                    </li>
                    @if (!empty($event['location']))
                        <li class="list-group-item"><b>{{trans('truck.location')}} : {{$event['location']['name']}}</b>
                                    - {{$event['location']['address'].' - '.$event['location']['city'].' ('.$event['location']['postcode'].')'}}
                        </li>
                    @endif
                    <li class="list-group-item text-justify"><b>{{trans('corporate.description')}} : </b><br>
                        {{$event['description']}}
                    </li>
                </ul>
                <div class="card-footer">
                    <a href="{{route('corporate.event_update',['event_id'=>$event['id']])}}">
                        <button class="btn btn-light_blue">{{trans('corporate.update')}}</button>
                    </a>
                </div>
            </div>
        </div>
        @if ($event['type'] === 'private')
            <div class="col-12 col-lg-6 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h2>{{trans('corporate.invited')}}</h2>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="invitedUsers" class="table table-hover table-striped table-bordered table-dark"
                                   style="width: 100%">
                                <thead>
                                <tr>
                                    <th>{{trans('client/account.lastname')}}</th>
                                    <th>{{trans('client/account.firstname')}}</th>
                                    <th>{{trans('client/account.telephone')}}</th>
                                    <th>{{trans('client/account.email')}}</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($event['invited'] as $invited)
                                    <tr id="{{'row_user'.$invited['user']['id']}}">

                                        <td>{{$invited['user']['lastname']}}</td>
                                        <td>{{$invited['user']['firstname']}}</td>
                                        <td>{{$invited['user']['telephone']}}</td>
                                        <td>{{$invited['user']['email']}}</td>


                                        <td>
                                            <a href="{{route('client_view',['id'=>$invited['user']['id']])}}">
                                                <button class="text-light fa fa-eye"></button>
                                            </a>

                                            <button onclick="eventRemoveInviteUser({{$event['id']}}, {{$invited['user']['id']}})"
                                                    class="text-light fa fa-ban ml-2"></button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-light_blue" data-toggle="modal" data-target="#inviteModal">Add</button>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="inviteModal" tabindex="-1" role="dialog" aria-labelledby="inviteModal"
                 aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{trans('corporate.invite_user')}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table id="inviteUser" class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>{{trans('client/account.lastname')}}</th>
                                        <th>{{trans('client/account.firstname')}}</th>
                                        <th>{{trans('client/account.email')}}</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    @foreach($user_list as $user)
                                        <tr>
                                            <td>{{$user['lastname']}}</td>
                                            <td>{{$user['firstname']}}</td>
                                            <td>{{$user['email']}}</td>
                                            <td>
                                                <a href="{{route('corporate.event_invite_user',['event_id'=>$event['id'],'user_id'=>$user['id']])}}">
                                                    <i class="text-light fa fa-paper-plane"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#client_orders').DataTable();
            $('#inviteUser').DataTable();
        });

        function eventRemoveInviteUser(event_id, user_id) {
            if (confirm("Voulez-vous vraiment retirer cet invité ?")) {
                if (!isNaN(event_id) && !isNaN(user_id)) {
                    let urlB = '{{route('corporate.event_remove_invite_user',['event_id' => ':event_id', 'user_id' => ':user_id'])}}';
                    urlB = urlB.replace(':event_id', event_id);
                    urlB = urlB.replace(':user_id', user_id);
                    $.ajax({
                        url: urlB,
                        method: "get",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == user_id) {
                                alert("Invité retiré");
                                $('#invitedUsers').DataTable().row('#row_user' + user_id).remove().draw();
                            } else {
                                alert("Une erreur est survenue lors de l'annulation, veuillez rafraîchir la page");
                            }
                        },
                        error: function () {
                            alert("Une erreur est survenue lors de l'annulation, veuillez rafraîchir la page");
                        }
                    })
                }
            }
        }

    </script>
@endsection
