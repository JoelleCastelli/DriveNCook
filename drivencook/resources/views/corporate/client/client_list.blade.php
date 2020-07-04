@extends('corporate.layout_corporate')
@section('title')
    Liste des clients
@endsection
@section('content')
    <div class="card mb-5">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">Nombre de clients : {{count($client_list)}}</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="#" class="row text-light2">
                                    <div class="col-10">
                                        Consulter les details
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
                            <li class="list-group-item bg-indigo">Nombre de commandes (30 jours) : {{$sale_count}}</li>
                            <li class="list-group-item bg-indigo align-content-arround">
                                <a href="#" class="row text-light2">
                                    <div class="col-10">
                                        Consulter les details
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
                    <button class="btn btn-primary h-100 w-100" data-toggle="modal" data-target="#newsLetterModal">
                        <i class="fa fa-envelope mr-2"></i> {{trans('corporate.send_newsletter')}}
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="card" id="client_list">
        <div class="card-header">
            <h2>Liste des clients</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="allclients" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Inscrit depuis le</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($client_list as $client)
                        <tr id="{{'row_'.$client['id']}}">
                            <td>{{$client['lastname']}}</td>
                            <td>{{$client['firstname']}}</td>
                            <td>{{$client['telephone']}}</td>
                            <td>{{$client['email']}}</td>
                            <td>{{$client['created_at']}}</td>
                            <td>
                                <a href="{{route('client_view',['id'=>$client['id']])}}">
                                    <button class="text-light fa fa-eye"></button>
                                </a>
                                <a class="ml-2" href="{{route('client_update',['id'=>$client['id']])}}">
                                    <button class="text-light fa fa-edit"></button>
                                </a>
                                <button onclick="deleteClient({{$client['id']}})"
                                        class="text-light fa fa-trash ml-2"></button>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <div class="modal fade" id="newsLetterModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{trans('corporate.send_newsletter')}}</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('send_client_newsletters')}}" method="post" class="p-2">

                    {{csrf_field()}}
                    <div class="form-group">
                        <div class="form-check" id="newsletter_type">
                            <input checked class="form-group form-check-input" type="radio" name="type" value="all"
                                   id="inlineRadio1" onclick="hideLoyaltyField()">
                            <label class="form-check-label"
                                   for="inlineRadio1">{{trans('corporate.newsletter_everybody')}}</label>
                        </div>
                        <div class="form-check" id="newsletter_type">
                            <input class="form-group form-check-input" type="radio" name="type" value="new"
                                   id="inlineRadio2"
                                   onclick="hideLoyaltyField()">
                            <label class="form-check-label"
                                   for="inlineRadio2">{{trans('corporate.newsletter_new_users')}}</label>
                        </div>
                        <div class="form-check" id="newsletter_type">
                            <input class="form-group form-check-input" type="radio" name="type" value="loyalty"
                                   id="inlineRadio3"
                                   onclick="showLoyaltyField()">
                            <label class="form-check-label"
                                   for="inlineRadio3">{{trans('corporate.newsletter_loyalty_point')}}</label>
                        </div>

                    </div>
                    <div class="form-group" id="loyalty_point_form" style="display: none">
                        <label for="loyalty_point">
                            {{trans('corporate.minimum_loyalty')}}
                        </label>
                        <input class="form-control" name="loyalty_point" id="loyalty_point" type="number" min="0" value="0"
                               step="1">
                    </div>

                    <div class="form-group">
                        <label for="news_message">{{trans('corporate.newsletter_optional_message')}}</label>
                        <textarea class="form-control" name="news_message" id="news_message" maxlength="255"></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary" id="modalSubmit">{{trans('corporate.send')}}
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
@section('script')
    <script type="text/javascript">

        $(document).ready(function () {
            let table = $('#allclients').DataTable({searchPanes: true});
            table.searchPanes.container().prependTo(table.table().container());
        });

        function hideLoyaltyField() {
            document.getElementById('loyalty_point_form').style.display = 'none';
        }

        function showLoyaltyField() {
            document.getElementById('loyalty_point_form').style.display = 'block';
        }

        function deleteClient(id) {
            if (confirm("Voulez-vous vraiment supprimer ce client ? Toutes les données associées seront supprimées")) {
                if (!isNaN(id)) {
                    let urlB = '{{ route('client_delete', ['id'=>':id']) }}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Client supprimé");
                                $('#allclients').DataTable().row('#row_' + id).remove().draw();
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