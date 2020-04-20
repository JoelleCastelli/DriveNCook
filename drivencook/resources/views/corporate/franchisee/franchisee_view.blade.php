@extends('corporate.layout_corporate')
@section('title')
    Franchisé : {{strtoupper($franchisee['firstname'].' '.$franchisee['lastname'])}}
@endsection
@section('style')
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Informations du franchisé <a href="{{route('franchisee_update',['id'=>$franchisee['id']])}}"><i
                                    class="fa fa-edit fa-1x"></i></a></h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>Nom : </b>{{$franchisee['lastname']}}</li>
                    <li class="list-group-item"><b>Prénom : </b>{{$franchisee['firstname']}}</li>
                    <li class="list-group-item"><b>Email : </b>{{$franchisee['email']}}</li>
                    <li class="list-group-item"><b>Téléphone :
                        </b>{{empty($franchisee['telephone'])?'Non renseigné':$franchisee['telephone']}}</li>
                    <li class="list-group-item"><b>Date de naissance :
                        </b>{{empty($franchisee['birthdate'])?'Non renseignée':
                                    DateTime::createFromFormat('Y-m-d',$franchisee['birthdate'])->format('d-m-Y')}}</li>
                    <li class="list-group-item"><b>Status :
                        </b>{{empty($franchisee['pseudo_id'])?'Non actif':'Actif ('.$franchisee['pseudo']['name'].')'}}
                    </li>
                    <li class="list-group-item"><b>Permis de conduire :
                        </b>{{empty($franchisee['driving_licence'])?'Non renseigné':$franchisee['driving_licence']}}
                    </li>
                    <li class="list-group-item"><b>Sécurité sociale :
                        </b>{{empty($franchisee['social_security'])?'Non renseignée':$franchisee['social_security']}}
                    </li>

                </ul>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-header">
                    <h2>Informations camion du franchisé</h2>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-5">
            <div class="card">
                <div class="card-header">
                    <h2>Factures</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="licencefees" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Montant</th>
                                <th>Status</th>
                                <th>Date d'émission</th>
                                <th>Date de paiement</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($franchisee['monthly_licence_fees'] as $license_fee)
                                <tr>
                                    <td>{{$license_fee['amount'].' €'}}</td>
                                    <td>{{$license_fee['status']}}</td>
                                    <td>{{$license_fee['date_emitted']}}</td>
                                    <td>{{$license_fee['date_paid']}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
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
            $('#licencefees').DataTable();
        });
    </script>
@endsection
