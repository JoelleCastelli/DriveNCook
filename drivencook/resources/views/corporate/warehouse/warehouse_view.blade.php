@extends('corporate.layout_corporate')
@section('title')
    {{ trans('warehouse_view.title') }} : {{ strtoupper($warehouse['name']) }}
@endsection
@section('style')
    {{--    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
    {{--    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">--}}
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('warehouse_view.warehouse_details_section') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('warehouse_view.warehouse_name') }} : </b>{{$warehouse['name']}}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_view.warehouse_address') }} : </b>{{$warehouse['address']}}</li>
                    <li class="list-group-item"><b>{{ trans('warehouse_view.warehouse_city') }} : </b>{{$warehouse['city']['name']}}</li>
                </ul>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('warehouse_update',['id'=>$warehouse['id']])}}">
                        <button class="btn btn-light_blue">{{ trans('warehouse_view.warehouse_edit') }}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('warehouse_view.dishes_section') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('warehouse_view.product') }}</th>
                                <th>{{ trans('warehouse_view.category') }}</th>
                                <th>{{ trans('warehouse_view.quantity') }}</th>
                                <th>{{ trans('warehouse_view.warehouse_price') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouse['dishes'] as $dish)
                                @if ($dish['quantity'] <= 5)
                                <tr>
                                    <td>{{$dish['name']}}</td>
                                    <td>{{ trans($GLOBALS['DISH_TYPE'][$dish['category']]) }}</td>
                                    <td>{{$dish['quantity']}}</td>
                                    <td>{{$dish['warehouse_price']}}</td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{route('warehouse_dishes',['id'=>$warehouse['id']])}}">
                        <button class="btn btn-light_blue">{{ trans('warehouse_view.warehouse_dishes_edit') }}</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>--}}
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>--}}
    {{--    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>--}}
    {{--    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>--}}
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dishes').DataTable();
        });
        /*
        function unsetTruck(id) {
            if (confirm("Voulez vous vraiment retirer le camion au franchisé ?")) {
                if (!isNaN(id)) {
                    let urlB = '{{route('unset_franchisee_truck',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                window.location.reload();
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
        }
        */

    </script>
@endsection
