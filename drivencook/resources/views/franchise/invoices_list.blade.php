@extends('franchise.layout_franchise')
@section('title')
    Liste des factures
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="franchisee_invoices_list" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Date d'émission</th>
                                    <th>Référence</th>
                                    <th>Montant</th>
                                    <th>Type de facture</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                    <tr>
                                        <td>
                                            {{DateTime::createFromFormat('Y-m-d',$invoice['date_emitted'])->format('d/m/Y')}}
                                        </td>
                                        <td>{{ $invoice['reference'] }}</td>
                                        <td>{{ number_format($invoice['amount'], 2, ',', ' ') }} €</td>
                                        <td>@if ($invoice['monthly_fee'] == 1)
                                                Redevance périodique
                                            @elseif ($invoice['initial_fee'] == 1)
                                                Redevance initiale forfaitaire
                                            @else
                                                Réassort
                                            @endif</td>
                                        <td>{{ $invoice['status'] }}</td>
                                        <td class="text-center">
                                            <a class="ml-2" href="{{ route('franchise.stream_invoice_pdf',['id'=>$invoice['id']]) }}">
                                                <button class="text-light fa fa-file-pdf ml-3"></button>
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
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#franchisee_invoices_list').DataTable();
        });
    </script>
@endsection