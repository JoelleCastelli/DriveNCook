@extends('corporate.layout_corporate')
@section('title')
    {{ ucfirst($franchisee['firstname']).' '.strtoupper($franchisee['lastname']).' ('.$franchisee['pseudo']['name'].')' }}
    - {{ trans('franchisee.invoices') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.invoices') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="invoices" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('franchisee.invoice_emission_date') }}</th>
                                    <th>{{ trans('franchisee.invoice_payment_date') }}</th>
                                    <th>{{ trans('franchisee.invoice_amount') }}</th>
                                    <th>{{ trans('franchisee.invoice_status') }}</th>
                                    <th>{{ trans('franchisee.invoice_reference') }}</th>
                                    <th>{{ trans('franchisee.invoice_type') }}</th>
                                    <th>{{ trans('franchisee.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($franchisee['invoices'] as $license_fee)
                                    <tr>
                                        <td>
                                            {{ DateTime::createFromFormat('Y-m-d',$license_fee['date_emitted'])->format('d/m/Y') }}
                                        </td>
                                        <td>
                                            {{ !empty($license_fee['date_paid'])?
                                            DateTime::createFromFormat('Y-m-d', $license_fee['date_paid'])->format('d/m/Y') : trans('franchisee.invoice_pending') }}
                                        </td>
                                        <td>{{ number_format($license_fee['amount'], 2, ',', ' ').' €'}}</td>
                                        <td>{{ trans('franchisee.invoice_status_'.$license_fee['status']) }}</td>
                                        <td>{{ $license_fee['reference'] }}</td>
                                        <td>@if ($license_fee['monthly_fee'] == 1)
                                                {{ trans('franchisee.invoice_monthly_fee') }}
                                            @elseif ($license_fee['initial_fee'] == 1)
                                                {{ trans('franchisee.invoice_initial_fee') }}
                                            @elseif ($license_fee['franchisee_order'] == 1)
                                                {{ trans('franchisee.invoice_restock') }}
                                            @endif</td>
                                        <td>
                                            <a class="ml-2" href="{{ route('stream_franchisee_invoice',['id'=>$license_fee['id']]) }}" target="_blank">
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
            $('#invoices').DataTable();
        });
    </script>
@endsection
