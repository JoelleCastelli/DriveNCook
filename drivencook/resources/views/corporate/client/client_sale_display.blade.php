@extends('corporate.layout_corporate')
@section('title')
    {{ trans('corporate.client_sale') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('client/sale.sale_details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <b>{{ trans('client/sale.date') }}
                            : </b>{{ DateTime::createFromFormat('Y-m-d', $sale['date'])->format('d/m/Y') }}
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('client/sale.online_order') }} : </b>{{ $sale['online_order'] == true ?
                                                            trans('client/sale.is_order') :
                                                            trans('client/sale.is_sale') }}
                    </li>
                    <li class="list-group-item d-flex align-items-baseline justify-content-between">
                        <span><b>{{ trans('client/sale.status') }}
                                : </b>{{ trans($GLOBALS['SALE_STATUS'][$sale['status']]) }}</span>
                        <button class="btn btn-indigo" data-toggle="modal"
                                data-target="#formModal">{{trans('franchisee.update')}}</button>
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('client/sale.payment_method') }} : </b>{{ $sale['payment_method'] == null ?
                                                            trans('client/sale.not_paid') :
                                                            trans($GLOBALS['SALE_PAYMENT_METHOD'][$sale['payment_method']]) }}
                    </li>
                    <li class="list-group-item">
                        <b>{{ trans('client/sale.total_price') }}
                            : </b>{{ $sale['total_price'] }} €
                    </li>
                </ul>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('franchisee.client_info') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('client/account.lastname') }} : </b>{{
                                                            $sale['user_client']['firstname'] . ' ' .
                                                            $sale['user_client']['lastname'] }}</li>
                    <li class="list-group-item"><b>{{ trans('client/sale.franchisee_email') }}
                            : </b>{{ $sale['user_client']['email'] }}</li>
                    <li class="list-group-item"><b>{{ trans('client/sale.franchisee_phone') }}
                            : </b>{{ $sale['user_client']['telephone'] }}</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.sale_details') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('client/sale.product') }}</th>
                                <th>{{ trans('client/sale.category') }}</th>
                                <th>{{ trans('client/sale.description') }}</th>
                                <th>{{ trans('client/sale.diet') }}</th>
                                <th>{{ trans('client/sale.quantity') }}</th>
                                <th>{{ trans('client/sale.sale_price') }}</th>
                                <th>{{ trans('client/sale.total_price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($sale['sold_dishes'] as $soldDish)
                                <tr>
                                    <td>{{ $soldDish['dish']['name'] }}</td>
                                    <td>{{ trans($GLOBALS['DISH_TYPE'][$soldDish['dish']['category']]) }}</td>
                                    <td>{{ $soldDish['dish']['description'] }}</td>
                                    <td>{{ trans('dish.diet_'.strtolower($soldDish['dish']['diet'])) }}</td>
                                    <td>{{ $soldDish['quantity'] }}</td>
                                    <td>{{ $soldDish['unit_price'] }} €</td>
                                    <td>{{ $soldDish['unit_price'] * $soldDish['quantity'] }} €</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{trans('franchisee.update_client_sale_status')}}</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{route('corporate.update_client_sale_status')}}">
                    {{csrf_field()}}
                    <input type="hidden" id="sale_id" name="sale_id" value="{{$sale['id']}}">

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="status">{{trans('client/sale.status')}}</label>
                            <select class="form-control" id="status" name="status">
                                @foreach($sale_status as $status)
                                    @if ($status == $sale['status'])
                                        <option selected value="{{$status}}">
                                            {{trans($GLOBALS['SALE_STATUS'][$status])}}
                                        </option>
                                    @else
                                        <option value="{{$status}}">
                                            {{trans($GLOBALS['SALE_STATUS'][$status])}}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{trans('corporate.cancel')}}</button>
                        <button type="submit" class="btn btn-primary" id="modalSubmit">{{trans('franchisee.update')}}
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
            $('#dishes').DataTable();
        });
    </script>
@endsection
