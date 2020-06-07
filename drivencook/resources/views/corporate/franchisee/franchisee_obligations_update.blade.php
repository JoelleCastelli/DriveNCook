@extends('corporate.layout_corporate')
@section('title')
    {{ trans('franchisee.franchisee_obligations') }}
@endsection

@section('content')
    @if (Session::has('success'))
        <div class="alert-success mb-3">{{ Session::get('success') }}</div>
    @elseif(Session::has('error'))
        <div class="alert-danger mb-3">
            @foreach(Session::get('error') as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('franchisee_obligation_update_submit')}}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="row">
                            <div class="col-6 col-lg-6">
                                <div class="form-group">
                                    <label for="entrance_fee">{{ trans('franchisee.invoice_initial_fee') }} (€)</label>
                                    <input type="number" min="0" max="1000000" step="0.01" name="entrance_fee" id="entrance_fee"
                                           value="{{ $last_obligation['entrance_fee'] }}"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="revenue_percentage">{{ trans('franchisee.invoice_monthly_fee') }} (%)</label>
                                    <input type="number" min="0" max="100" step="0.01" name="revenue_percentage"
                                           id="revenue_percentage"
                                           value="{{ $last_obligation['revenue_percentage'] }}"
                                           class="form-control">
                                </div>
                            </div>
                            <div class="col-6 col-lg-6">
                                <div class="form-group">
                                    <label for="warehouse_percentage">{{ trans('franchisee.obligations_warehouse_percentage') }}</label>
                                    <input type="number" min="0" max="100" step="0.01" name="warehouse_percentage"
                                           id="warehouse_percentage"
                                           value="{{ $last_obligation['warehouse_percentage'] }}"
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="billing_day">{{ trans('franchisee.obligations_billing_day_info') }} (< 28)</label>
                                    <input type="number" min="1" max="28" step="1" name="billing_day" id="billing_day"
                                           value="{{ $last_obligation['billing_day'] }}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-info">{{ trans('franchisee.update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 mt-5 mt-md-0">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.history') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="obligationshistory" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('franchisee.last_updated') }}</th>
                                    <th>{{ trans('franchisee.invoice_initial_fee') }}</th>
                                    <th>{{ trans('franchisee.invoice_monthly_fee') }}</th>
                                    <th>{{ trans('franchisee.corporate_stock') }}</th>
                                    <th>{{ trans('franchisee.obligations_billing_day_info') }}</th>
                                    <th>{{ trans('franchisee.updated_by') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($obligations as $obligation)
                                    <tr>
                                        <td>{{ $obligation['date_updated']}}</td>
                                        <td>{{ number_format($obligation['entrance_fee'], 2, ',', ' ') }} €</td>
                                        <td>{{ number_format($obligation['revenue_percentage'], 2, ',', ' ') }} %</td>
                                        <td>{{ number_format($obligation['warehouse_percentage'], 2, ',', ' ') }} %</td>
                                        <td>{{ $obligation['billing_day']}}</td>
                                        <td>{{ $obligation['manager'] }}</td>
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
            $('#obligationshistory').DataTable();
        });
    </script>
@endsection
