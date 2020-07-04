@extends('corporate.layout_corporate')
@section('title')
    {{ trans('franchisee.revenues_and_statistics') }}
@endsection

@section('content')
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
                    @if ($revenues['sales_count'] != 0)
                        <div class="row mt-4">
                            <div class="col-6 col-md-6 col-lg-6">
                                <div id="turnover_chart">
                                    {!! $payment_methods_chart->container() !!}
                                </div>
                            </div>
                            <div class="col-6 col-md-6 col-lg-6">
                                <div id="turnover_chart">
                                    {!! $origins_chart->container() !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    {!! $sales_chart->script() !!}
    {!! $turnover_chart->script() !!}
    @if ($revenues['sales_count'] != 0)
        {!! $payment_methods_chart->script() !!}
        {!! $origins_chart->script() !!}
    @endif
@endsection
