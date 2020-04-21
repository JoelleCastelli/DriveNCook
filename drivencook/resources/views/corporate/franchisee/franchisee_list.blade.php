@extends('corporate.layout_corporate')
@section('style')
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
@endsection
@section('title')
    Liste des franchisés
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">Nombre de franchisés : {{count($franchisees)}}</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="#franchisee-list" class="row text-light2">
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
                            <li class="list-group-item bg-indigo">Prochain paiement des taxes : {{$nextPaiement}}</li>
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
            </div>
        </div>
    </div>

    <div class="card mt-5" id="franchisee-list">
        <div class="card-body">
            <div class="table-responsive">
                <table id="allfranchisees" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Téléphone</th>
                        <th>Email</th>
                        <th>Actif</th>
                        <th>Dernier paiement</th>
                        <th>Emplacement camion</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($franchisees as $franchisee)
                        <tr id="{{'row_'.$franchisee['id']}}">
                            <td>{{$franchisee['lastname']}}</td>
                            <td>{{$franchisee['firstname']}}</td>
                            <td>{{$franchisee['telephone']}}</td>
                            <td>{{$franchisee['email']}}</td>
                            <td>{{empty($franchisee['pseudo'])?'Inactif':'Actif ('.$franchisee['pseudo']['name'].')'}}</td>
                            <td>{{empty($franchisee['last_paid_licence_fee'])?'Jamais'
                                :DateTime::createFromFormat('Y-m-d',$franchisee['last_paid_licence_fee']['date_paid'])->format('d-m-Y')}}</td>
                            <td>A faire camion</td>
                            <td>
                                <a href="{{route('franchisee_view',['id'=>$franchisee['id']])}}">
                                    <button class="text-light fa fa-eye"></button>
                                </a>
                                <a class="ml-2" href="{{route('franchisee_update',['id'=>$franchisee['id']])}}">
                                    <button class="text-light fa fa-edit"></button>
                                </a>
                                <button onclick="deleteFranchise({{$franchisee['id']}})"
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('#allfranchisees').DataTable();
        });

        function deleteFranchise(id) {
            if (confirm("Voulez vous vraiment supprimer ce franchisé ? Toute les données associés seront supprimés")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('franchisee_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert("Franchisé supprimé");
                                let row = document.getElementById('row_' + id);
                                row.remove();
                            } else {
                                alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                            }
                        },
                        error: function () {
                            alert("Une erreur est survenue lors de la suppression, veuillez raffraichir la page");
                        }
                    })
                }
            }
            console.log("id : " + id);
        }
    </script>
@endsection