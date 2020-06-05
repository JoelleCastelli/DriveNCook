@extends('franchise.layout_franchise')
@section('title')
    {{ trans('franchisee.revenues_and_statistics') }}
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
                                <li class="list-group-item bg-info">{{ trans('franchisee.obligations_last_updated') }} <b>{{ DateTime::createFromFormat("Y-m-d", $current_obligation['date_updated'])->format('d/m/Y') }}</b></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{!! trans('franchisee.revenues_current_month',
                                    ['date_start' => $invoicing_period['period_start_date'],
                                    'date_end' => $invoicing_period['period_end_date']]) !!}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row d-flex justify-content-center">
                                {{ trans('franchisee.sales') }}
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{$revenues['sales_count']}}</h1>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="row d-flex justify-content-center">
                                {{ trans('franchisee.turnover') }}
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{ number_format($revenues['sales_total'], 2, ',', ' ')}} €</h1>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-5">
                            <div class="row d-flex justify-content-center">
                                {{ trans('franchisee.next_invoice') }}
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{ number_format($revenues['next_invoice'], 2, ',', ' ')}} €</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>{{ trans('franchisee.history') }}</h2>
                    <button type="button" class="btn btn-light_blue" data-toggle="modal"
                            data-target="#formModal">{{ trans('franchisee.pdf_export') }}
                    </button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="row d-flex justify-content-center">
                                {{ trans('franchisee.sales') }}
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{ $history['sales_count'] }}</h1>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="row d-flex justify-content-center">
                                {{ trans('franchisee.turnover') }}
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{ number_format($history['sales_total'], 2, ',', ' ') }} €</h1>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-md-5">
                            <div class="row d-flex justify-content-center">
                                {{ trans('franchisee.invoice_total') }}
                            </div>
                            <div class="row d-flex justify-content-center">
                                <h1>{{ number_format($history['total_invoices'], 2, ',', ' ') }} €</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>{{ trans('franchisee.current_month_stats') }}</h2>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 col-md-6 col-lg-6">
                            <div id="sales_chart">
                                {!! $sales_chart->container() !!}
                            </div>
                        </div>
                        <div class="col-6 col-md-6 col-lg-6">
                            <div id="turnover_chart">
                                {!! $turnover_chart->container() !!}
                            </div>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-6 col-md-6 col-lg-6">
                            <div id="turnover_chart">
                                {!! $payment_methods_chart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{ trans('franchisee.generate_sales_history') }}</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('sales_history_pdf') }}">
                    {{csrf_field()}}
                    <input type="hidden" id="formId" name="id" value="">

                    <div class="modal-body">
                        <button type="button" onclick="setAllTimeDates('{{ $history['creation_date'] }}')"
                                class="btn btn-info">{{ trans('franchisee.since_creation') }}</button>
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="{{ $franchisee['id'] }}">
                        </div>
                        <div class="form-group">
                            <label for="end_date">{{ trans('franchisee.date_start') }}</label>
                            <input type="date" name="start_date" id="start_date"
                                   value=""
                                   class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="end_date">{{ trans('franchisee.date_end') }}</label>
                            <input type="date" name="end_date" id="end_date"
                                   value="{{ date("Y-m-d") }}"
                                   class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('franchisee.cancel') }}</button>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{ trans('franchisee.generate') }}</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function setAllTimeDates(creation_date) {
            let start_date = document.getElementById('start_date');
            let end_date = document.getElementById('end_date');
            let today = new Date();
            let dd = today.getDate();
            let mm = today.getMonth()+1;
            let yyyy = today.getFullYear();
            if (dd < 10)
                dd = '0' + dd;
            if (mm < 10)
                mm = '0' + mm;
            today = yyyy + '-' + mm + '-' + dd;
            start_date.value = creation_date;
            end_date.value = today;
        }
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $sales_chart->script() !!}
    {!! $turnover_chart->script() !!}
    {!! $payment_methods_chart->script() !!}
@endsection