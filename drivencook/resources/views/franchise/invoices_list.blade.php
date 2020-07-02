@extends('franchise.layout_franchise')
@section('title')
    {{ trans('franchisee.invoices_list') }}
@endsection


@section('content')

    <div class="col-12 col-lg-12 mb-5">
        <div class="card">
            <div class="card-header">
                <h2>{{ trans('franchisee.obligations_invoice_info') }}</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                        <div class="card text-light2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-indigo">{{ trans('franchisee.obligations_revenue_percentage') }} <b>{{ $current_obligation['revenue_percentage'] }} %</b></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                        <div class="card text-light2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-success">{!! trans('franchisee.obligations_billing_day',['day'=>$current_obligation['billing_day']]) !!}</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4">
                        <div class="card text-light2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item bg-info">{{ trans('franchisee.obligations_last_updated') }} <b>{{ $current_obligation['date_updated'] }}</b></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="franchisee_invoices_list" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('franchisee.invoice_emission_date') }}</th>
                                    <th>{{ trans('franchisee.invoice_reference') }}</th>
                                    <th>{{ trans('franchisee.invoice_amount') }}</th>
                                    <th>{{ trans('franchisee.invoice_type') }}</th>
                                    <th>{{ trans('franchisee.invoice_status') }}</th>
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
                                                {{ trans('franchisee.invoice_monthly_fee') }}
                                            @elseif ($invoice['initial_fee'] == 1)
                                                {{ trans('franchisee.invoice_initial_fee') }}
                                            @elseif ($invoice['franchisee_order'] == 1)
                                                {{ trans('franchisee.invoice_restock') }}
                                            @endif</td>
                                        <td>{{ trans('franchisee.invoice_status_'.$invoice['status']) }}</td>
                                        <td class="text-center">
                                            <a class="ml-2" href="{{ route('franchise.stream_invoice_pdf',['id'=>$invoice['id']]) }}" target="_blank">
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