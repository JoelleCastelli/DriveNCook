@extends('corporate.layout_corporate')
@section('title')
    Obligations des franchisés
@endsection
@section('style')
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
@endsection


@section('content')
    @if (Session::has('success'))
        <div class="alert-success mb-3">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
        <div class="alert-danger mb-3">
            Erreur !
            @foreach(Session::get('error') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('franchisee_obligation_update_submit')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label for="entrance_fee">Frais d'entrées (€)</label>
                            <input type="number" min="0" max="1000000" step="1" name="entrance_fee" id="entrance_fee"
                                   value="{{ $last_obligation['entrance_fee'] }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="revenue_percentage">Taxes sur les revenues (%)</label>
                            <input type="number" min="0" max="100" step="1" name="revenue_percentage"
                                   id="revenue_percentage"
                                   value="{{ $last_obligation['revenue_percentage'] }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="warehouse_percentage">Taxes sur les entrepôts (%)</label>
                            <input type="number" min="0" max="100" step="1" name="warehouse_percentage"
                                   id="warehouse_percentage"
                                   value="{{ $last_obligation['warehouse_percentage'] }}"
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="billing_day">Jour de facturation mensuel (< 28)</label>
                            <input type="number" min="1" max="28" step="1" name="billing_day" id="billing_day"
                                   value="{{ $last_obligation['billing_day'] }}"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info">Mettre à jour</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mt-5 mt-md-0">
            <div class="card">
                <div class="card-header">
                    <h2>Historique :</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="obligationshistory" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>Date de mise à jour</th>
                                <th>Frais d'entrées</th>
                                <th>Taxes sur les revenues</th>
                                <th>Taxes sur les entrepôts</th>
                                <th>Jour de facturation mensuel</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($obligations as $obligation)
                                <tr>
                                    <td>{{$obligation['date_updated']}}</td>
                                    <td>{{$obligation['entrance_fee']}}</td>
                                    <td>{{$obligation['revenue_percentage']}}</td>
                                    <td>{{$obligation['warehouse_percentage']}}</td>
                                    <td>{{$obligation['billing_day']}}</td>
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
            $('#obligationshistory').DataTable();
        });
    </script>
@endsection
