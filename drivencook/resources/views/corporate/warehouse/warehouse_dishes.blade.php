@extends('corporate.layout_corporate')
@section('title')
    {{ trans('warehouse_dishes.title') }} : {{ strtoupper($warehouse['name']) }}
@endsection
@section('style')
    {{--    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">--}}
    {{--    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">--}}
@endsection


@section('content')
    <input type="hidden" id="warehouseId" value="{{ $warehouse['id'] }}">
    <div class="row">
        <div class="col-12 col-lg-12 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('warehouse_dishes.dishes_section') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('warehouse_dishes.product') }}</th>
                                <th>{{ trans('warehouse_dishes.category') }}</th>
                                <th>{{ trans('warehouse_dishes.quantity') }}</th>
                                <th>{{ trans('warehouse_dishes.warehouse_price') }}</th>
                                <th>{{ trans('warehouse_dishes.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($warehouse['dishes'] as $dish)
                                <tr id="rowId{{ $dish['id'] }}">
                                    <td id="rowName{{ $dish['id'] }}">{{ $dish['name'] }}</td>
                                    <td id="rowCategory{{ $dish['id'] }}" data-whatever={{ $dish['category'] }}>{{ trans($GLOBALS['DISH_TYPE'][$dish['category']]) }}</td>
                                    <td id="rowQuantity{{ $dish['id'] }}">{{ $dish['quantity'] }}</td>
                                    <td id="rowWarehousePrice{{ $dish['id'] }}">{{ $dish['warehouse_price'] }}</td>
                                    <td>
                                        <i class="fa fa-edit" onclick="editDish({{ $dish['id'] }})" data-toggle="modal" data-target="#dishModal"></i>
                                        <i class="fa fa-trash ml-3" onclick="deleteDish({{ $dish['id'] }})"></i>
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
    <div class="modal fade" id="dishModal" tabindex="-1" role="dialog" aria-labelledby="dishModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dishModalLabel"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <input type="hidden" id="dishId">
                            <label for="dishName" class="col-form-label">{{ trans('warehouse_dishes.dish_name') }}</label>
                            <input type="text" class="form-control" id="dishName" maxlength="30">
                            <label for="dishCategory" class="col-form-label">{{ trans('warehouse_dishes.dish_category') }}</label>
                            <select class="custom-select" name="dishCategory" id="dishCategory">
                                <option value="" selected>{{ trans('warehouse_dishes.select_menu_off') }}</option>
                                @foreach($categories as $category)
                                    <option value={{ $category }}>{{ trans($GLOBALS['DISH_TYPE'][$category]) }}</option>
                                @endforeach
                            </select>
                            <label for="dishQuantity" class="col-form-label">{{ trans('warehouse_dishes.dish_quantity') }}</label>
                            <input type="number" class="form-control" id="dishQuantity">
                            <label for="dishWarehousePrice" class="col-form-label">{{ trans('warehouse_dishes.dish_warehouse_price') }}</label>
                            <input type="number" class="form-control" id="dishWarehousePrice">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('warehouse_dishes.dish_close') }}</button>
                    <button type="button" class="btn btn-primary" id="updateDish">{{ trans('warehouse_dishes.dish_update') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addDishModal" tabindex="-1" role="dialog" aria-labelledby="addDishModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ trans('warehouse_dishes.add_dish') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="addDishName" class="col-form-label">{{ trans('warehouse_dishes.dish_name') }}</label>
                            <input type="text" class="form-control" id="addDishName" maxlength="30">
                            <label for="addDishCategory" class="col-form-label">{{ trans('warehouse_dishes.dish_category') }}</label>
                            <select class="custom-select" id="addDishCategory">
                                <option value="" selected>{{ trans('warehouse_dishes.select_menu_off') }}</option>
                                @foreach($categories as $category)
                                    <option value={{ $category }}>{{ trans($GLOBALS['DISH_TYPE'][$category]) }}</option>
                                @endforeach
                            </select>
                            <label for="addDishQuantity" class="col-form-label">{{ trans('warehouse_dishes.dish_quantity') }}</label>
                            <input type="number" class="form-control" id="addDishQuantity">
                            <label for="addDishWarehousePrice" class="col-form-label">{{ trans('warehouse_dishes.dish_warehouse_price') }}</label>
                            <input type="number" class="form-control" id="addDishWarehousePrice">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('warehouse_dishes.dish_close') }}</button>
                    <button type="button" class="btn btn-primary" id="addDish">{{ trans('warehouse_dishes.dish_create') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#dishes').DataTable();

            $('#updateDish').click(function () {
                let formData = new FormData();
                formData.append('id', $('#dishId').val());
                formData.append('name', $('#dishName').val());
                formData.append('category', $('#dishCategory').val());
                formData.append('quantity', $('#dishQuantity').val());
                formData.append('warehousePrice', $('#dishWarehousePrice').val());
                $.ajax({
                    url: '{{ route('dish_update_submit') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data['status'] === 'success') {
                            let table = $('#dishes').DataTable();
                            let id = data['data']['id'];

                            table.cell('#rowName' + id).data(data['data']['name']).draw();
                            table.cell('#rowCategory' + id).data(data['data']['category']).draw();
                            table.cell('#rowQuantity' + id).data(data['data']['quantity']).draw();
                            table.cell('#rowWarehousePrice' + id).data(data['data']['warehouse_price']).draw();

                            $('#dishModal').modal('hide');
                        } else {
                            alert('{{ trans('warehouse_dishes.update_dish_error') }}');
                        }
                    },
                    error: function () {
                        alert('{{ trans('warehouse_dishes.update_dish_error') }}');
                    }
                });
            });

            $('#addDish').click(function () {
                let formData = new FormData();
                formData.append('name', $('#addDishName').val());
                formData.append('category', $('#addDishCategory').val());
                formData.append('quantity', $('#addDishQuantity').val());
                formData.append('warehousePrice', $('#addDishWarehousePrice').val());
                formData.append('warehouseId', $('#warehouseId').val());
                $.ajax({
                    url: '{{ route('dish_creation_submit') }}',
                    method: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if (data['status'] === 'success') {
                            let table = $('#dishes').DataTable();
                            let id = data['data']['id'];
                            let row = table.row.add([
                                data['data']['name'],
                                Lang.get('warehouse_dishes.' + data['data']['category']),
                                data['data']['quantity'],
                                data['data']['warehouse_price'],
                                '<i class="fa fa-edit" onclick="editDish(' + id + ')"' + 'data-toggle="modal" data-target="#dishModal"></i> ' +
                                '<i class="fa fa-trash ml-3" onclick="deleteDish(' + id + ')"></i>'
                            ]).draw().node();

                            $(row).attr('id', 'rowId' + id);
                            $(row).children().eq(0).attr('id', 'rowName' + id);
                            $(row).children().eq(1).attr('id', 'rowCategory' + id);
                            $(row).children().eq(1).attr('data-whatever', data['data']['category']);
                            $(row).children().eq(2).attr('id', 'rowQuantity' + id);
                            $(row).children().eq(3).attr('id', 'rowWarehousePrice' + id);

                            $('#addDishModal').modal('hide');
                        } else {
                            let str = '';
                            for(let i = 0; i < data['errorList'].length; i++) {
                                str += '\n' + data['errorList'][i];
                            }
                            alert(Lang.get('warehouse_dishes.create_dish_error') + str);
                        }
                    },
                    error: function () {
                        alert(Lang.get('warehouse_dishes.create_dish_error'));
                    }
                });
            });
        });

        function editDish(id) {
            $('#dishModalLabel').text($('#rowName' + id).text());
            $('#dishId').val(id);
            $('#dishName').val($('#rowName' + id).text());
            $('#dishCategory').val($('#rowCategory' + id).data('whatever'));
            $('#dishQuantity').val($('#rowQuantity' + id).text());
            $('#dishWarehousePrice').val($('#rowWarehousePrice' + id).text());
        }

        function deleteDish(id) {
            if (confirm(Lang.get('warehouse_dishes.ask_delete_dish'))) {
                if (!isNaN(id)) {
                    let urlB = '{{ route('dish_delete', ['id'=>':id']) }}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data['status'] === 'success') {
                                $('#dishes').DataTable().row('#rowId' + id).remove().draw();
                            } else {
                                alert(Lang.get('warehouse_dishes.delete_dish_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('warehouse_dishes.delete_dish_error'));
                        }
                    });
                }
            }
        }

    </script>
@endsection
