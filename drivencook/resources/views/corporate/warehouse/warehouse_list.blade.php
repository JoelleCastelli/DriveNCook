@extends('corporate.layout_corporate')
@section('style')
    <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css" rel="stylesheet">
@endsection

@section('title')
    {{ trans('warehouse.title_list') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="allwarehouses" class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('warehouse.name') }}</th>
                                        <th>{{ trans('warehouse.address') }}</th>
                                        <th>{{ trans('warehouse.city') }}</th>
                                        <th>{{ trans('warehouse.actions') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($warehouses as $warehouse)
                                        <tr id="{{'row_'.$warehouse['id']}}">
                                            <td>{{$warehouse['name']}}</td>
                                            <td>{{$warehouse['address']}}</td>
                                            <td>{{empty($warehouse['city'])?
                                        'Inconnu':$warehouse['city']['name']}}</td>
                                            <td>
                                                <a href="{{route('warehouse_view',['id'=>$warehouse['id']])}}">
                                                    <button class="text-light fa fa-eye"></button>
                                                </a>
                                                <a href="{{route('warehouse_update',['id'=>$warehouse['id']])}}">
                                                    <button class="fa fa-edit ml-2 text-light"></button>
                                                </a>

                                                <button onclick="deleteWarehouse({{$warehouse['id']}})"
                                                        class="fa fa-trash ml-2"></button>
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
        </div>
    </div>

@endsection



@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#allwarehouses').DataTable();
        });

        function deleteWarehouse(id) {
            if (confirm(Lang.get('warehouse_list.ask_delete_warehouse')/*"Voulez vous vraiment supprimer ce camion ? Toute les données associés seront supprimés"*/)) {
                if (!isNaN(id)) {
                    let urlB = '{{route('warehouse_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                $('#allwarehouses').DataTable().row('#row_' + id).remove().draw();
                                alert(Lang.get('warehouse_list.warehouse_deleted_success'));
                            } else {
                                alert(Lang.get('warehouse_list.warehouse_deleted_error')/*"Une erreur est survenue lors de la suppression, veuillez raffraichir la page"*/);
                            }
                        },
                        error: function () {
                            alert(Lang.get('warehouse_list.warehouse_deleted_error'));
                        }
                    })
                }
            }
        }
    </script>
@endsection