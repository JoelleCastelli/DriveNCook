@extends('corporate.layout_corporate')

@section('title')
    {{ trans('truck.trucks_list') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="alltrucks" class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th>{{ trans('truck.brand') }}</th>
                                        <th>{{ trans('truck.model') }}</th>
                                        <th>{{ trans('truck.functional') }}</th>
                                        <th>{{ trans('truck.purchase_date') }}</th>
                                        <th>{{ trans('truck.license_plate') }}</th>
                                        <th>{{ trans('truck.horsepower') }}</th>
                                        <th>{{ trans('truck.payload') }}</th>
                                        <th>{{ trans('truck.mileage') }}</th>
                                        <th>{{ trans('truck.location') }}</th>
                                        <th>{{ trans('truck.availability') }}</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($trucks as $truck)
                                        <tr id="{{'row_'.$truck['id'] }}">
                                            <td>{{ $truck['brand'] }}</td>
                                            <td>{{ $truck['model'] }}</td>
                                            <td>{{ $truck['functional'] ? trans('truck.yes') : trans('truck.no')}}</td>
                                            <td>{{ DateTime::createFromFormat('Y-m-d',$truck['purchase_date'])->format('d/m/Y') }}</td>
                                            <td>{{ $truck['license_plate'] }}</td>
                                            <td>{{ $truck['horsepower'].' CV'}}</td>
                                            <td>{{ $truck['payload'].' kg'}}</td>
                                            <td>{{ empty($truck['last_safety_inspection'])?
                                                    trans('truck.unknown') : $truck['last_safety_inspection']['truck_mileage'].' km'}}</td>
                                            <td>{{ empty($truck['location'])?
                                                    trans('truck.unknown') : $truck['location']['name'].' - '.$truck['location']['address']
                                                     .' '.$truck['location']['postcode'].' '.$truck['location']['city']}}</td>
                                            <td>{{ empty($truck['user'])?
                                                    trans('truck.available') :
                                                    trans('truck.unavailable', ['franchisee' => $truck['user']['firstname'].' '.$truck['user']['lastname']]) }}</td>
                                            <td>
                                                <a href="{{route('truck_view',['id'=>$truck['id']]) }}">
                                                    <i class="text-light fa fa-eye"></i>
                                                </a>
                                                <a href="{{route('truck_update',['id'=>$truck['id']]) }}">
                                                    <button class="text-light fa fa-edit ml-2"></button>
                                                </a>

                                                <button onclick="deleteTruck({{ $truck['id'] }})"
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
            let table = $('#alltrucks').DataTable({searchPanes: true});
            //table.searchPanes.container().prependTo(table.table().container());
        });

        function deleteTruck(id) {
            if (confirm(Lang.get('truck.confirm_delete'))) {
                if (!isNaN(id)) {
                    let urlB = '{{route('truck_delete',['id'=>':id']) }}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('truck.delete_success'));
                                let row = document.getElementById('row_' + id);
                                row.remove();
                            } else {
                                alert(Lang.get('truck.ajax_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('truck.ajax_error'));
                        }
                    })
                }
            }
        }
    </script>
@endsection