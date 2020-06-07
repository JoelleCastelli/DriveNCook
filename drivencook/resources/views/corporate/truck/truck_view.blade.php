@extends('corporate.layout_corporate')
@section('style')
@endsection
@section('title')
    {{ trans('truck.truck_view') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('truck.truck_info') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('truck.brand') }}:</b>
                        {{ empty($truck['brand']) ? trans('truck.not_specified_f') : $truck['brand'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.model') }}:</b>
                        {{ empty($truck['model']) ? trans('truck.not_specified_m') : $truck['model'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.functional') }}:</b>
                        {{ $truck['functional'] ? trans('truck.yes') : trans('truck.not_specified_m') }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.purchase_date') }}:</b>
                        {{ empty($truck['purchase_date']) ? trans('truck.not_specified_f') :
                                DateTime::createFromFormat('Y-m-d',$truck['purchase_date'])->format('d/m/Y')}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.license_plate') }}:</b>
                        {{ empty($truck['license_plate']) ? trans('truck.not_specified_f') : $truck['license_plate'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.insurance_number') }}:</b>
                        {{ empty($truck['insurance_number']) ? trans('truck.not_specified_m') : $truck['insurance_number'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.registration_document') }}:</b>
                        {{ empty($truck['registration_document']) ? trans('truck.not_specified_f') : $truck['registration_document'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.fuel_type') }}:</b>
                        {{ empty($truck['fuel_type']) ? trans('truck.not_specified_m') : $truck['fuel_type'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.horsepower') }}:</b>
                        {{ empty($truck['horsepower']) ? trans('truck.not_specified_f') : $truck['horsepower'].' CV'}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.weight_empty') }}:</b>
                        {{ empty($truck['weight_empty']) ? trans('truck.not_specified_m') : $truck['weight_empty'].' kg'}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.payload') }}:</b>
                        {{ empty($truck['payload']) ? trans('truck.not_specified_f'): $truck['payload'].' kg'}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.general_state') }}:</b>
                        {{ empty($truck['general_state']) ? trans('truck.not_specified_m') : $truck['general_state'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.chassis_number') }}:</b>
                        {{ empty($truck['chassis_number']) ? trans('truck.not_specified_m') : $truck['chassis_number'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.engine_number') }}:</b>
                        {{ empty($truck['engine_number']) ? trans('truck.not_specified_m') : $truck['engine_number'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.latest_safety_inspection') }}:</b>
                        {{ empty($truck['last_safety_inspection']) ? trans('truck.not_specified_m') :
                                DateTime::createFromFormat('Y-m-d', $truck['last_safety_inspection']['date'])->format('d/m/Y')
                                .' ('.$truck['last_safety_inspection']['truck_mileage'].' km - '. $truck['last_safety_inspection']['truck_age'].' ans)'}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('truck.location') }}:</b>
                        {{ empty($truck['location']) ? trans('truck.not_specified_f') :
                                $truck['location']['address'].' ('.$truck['location']['city']['postcode'].')'}}
                    </li>
                </ul>

                <div class="card-footer">
                    <a href="{{ route('truck_update',['id' => $truck['id']]) }}">
                        <button class="btn btn-light_blue">{{ trans('truck.update_submit') }}</button>
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('truck.truck_deployment') }}</h2>
                </div>
                <div class="card-body">
                    @if (empty($truck['user']))
                        <form method="post" action="{{ route('set_franchisee_truck') }}">
                            {{csrf_field()}}
                            <input type="hidden" id="truckId" name="truckId" value="{{ $truck['id'] }}">

                            <div class="form-group">
                                <label for="userId">{{ trans('truck.available_franchisees') }}</label>
                                <select class="form-control" id="userId" name="userId">
                                    @foreach($unassigned as $user)
                                        <option value="{{ $user['id'] }}">
                                            {{
                                                 $user['firstname'] . ' '.
                                                 $user['lastname'] . ' ('.
                                                 $user['pseudo']['name'].')'
                                             }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-light_blue">{{ trans('truck.assign') }}</button>
                        </form>
                    @else
                        {{ trans('truck.assigned_to', ['franchisee' => $truck['user']['firstname'].' '.
                                                                        $truck['user']['lastname'].' ('.
                                                                        $truck['user']['pseudo']['name'].')']) }}
                        <br>
                        <button class="btn btn-danger mt-3" onclick="unsetTruck({{ $truck['id'] }})">
                            {{ trans('truck.remove_truck') }}
                        </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('truck.breakdowns') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="breakdowns_history" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('truck.breakdown_date') }}</th>
                                    <th>{{ trans('truck.breakdown_type') }}</th>
                                    <th>{{ trans('truck.breakdown_description') }}</th>
                                    <th>{{ trans('truck.breakdown_cost') }}</th>
                                    <th>{{ trans('truck.breakdown_status') }}</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($truck['breakdowns'] as $breakdown)
                                    <tr id="row_{{ $breakdown['id'] }}">
                                        <td>
                                            {{ DateTime::createFromFormat('Y-m-d',$breakdown['date'])->format('d/m/Y') }}
                                        </td>
                                        <td>{{ trans('truck.breakdown_type_'.$breakdown['type']) }}</td>
                                        <td>{{ $breakdown['description'] }}</td>
                                        <td>{{ $breakdown['cost'] }} €</td>
                                        <td>{{ trans('truck.breakdown_status_'.$breakdown['status']) }}</td>
                                        <td>
                                            <a href="{{ route('update_breakdown',["truckId"=>$truck['id'], "breakdownId"=>$breakdown['id']]) }}">
                                                <i class="text-light fa fa-edit ml-3"></i>
                                            </a>
                                            <button onclick="onDeleteBreakdown({{ $breakdown['id'] }})"
                                                    class="fa fa-trash ml-3"></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('add_breakdown',["truckId"=>$truck['id']]) }}">
                        <button class="btn btn-light_blue">{{ trans('truck.add_breakdown') }}</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('truck.safety_inspections') }}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="safety_inspection_history"
                               class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{ trans('truck.safety_inspection_date') }}</th>
                                <th>{{ trans('truck.truck_age') }}</th>
                                <th>{{ trans('truck.mileage') }}</th>
                                <th>{{ trans('truck.replaced_parts') }}</th>
                                <th>{{ trans('truck.drained_fluids') }}</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($truck['safety_inspection'] as $inspection)
                                    <tr id="row_{{ $inspection['id'] }}">
                                        <td>
                                            {{DateTime::createFromFormat('Y-m-d',$inspection['date'])->format('d/m/Y')}}
                                        </td>
                                        <td>{{ trans('truck.truck_age_years', ['years' => $inspection['truck_age']]) }}</td>
                                        <td>{{ $inspection['truck_mileage'] }} km</td>
                                        <td>{{ $inspection['replaced_parts'] }}</td>
                                        <td>{{ $inspection['drained_fluids'] }}</td>
                                        <td>
                                            <a href="{{route('update_safety_inspection',['truckId'=>$truck['id'], "safetyInspectionId"=> $inspection['id']])}}">
                                                <i class="text-light fa fa-edit"></i>
                                            </a>
                                            <button onclick="onDeleteSafetyInspection({{ $inspection['id'] }})"
                                                    class="fa fa-trash ml-3"></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('add_safety_inspection',["truckId"=>$truck['id']])}}">
                        <button class="btn btn-light_blue">{{ trans('truck.add_safety_inspection') }}</button>
                    </a>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#breakdowns_history').DataTable();
            $('#safety_inspection_history').DataTable();
        });

        let urlB = "{{ route('unset_franchisee_truck',['id'=>':id']) }}";

        function onDeleteBreakdown(id) {
            if (confirm(Lang.get('truck.confirm_delete_breakdown'))) {
                if (!isNaN(id)) {
                    let urlD = '{{ route('delete_breakdown',['id'=>':id']) }}';
                    urlD = urlD.replace(':id', id);
                    $.ajax({
                        url: urlD,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('truck.breakdown_deleted'));
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

        function onDeleteSafetyInspection(id) {
            if (confirm(Lang.get('truck.confirm_delete_inspection'))) {
                if (!isNaN(id)) {
                    let urlD = '{{ route('delete_safety_inspection',['id'=>':id']) }}';
                    urlD = urlD.replace(':id', id);
                    $.ajax({
                        url: urlD,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('truck.inspection_deleted'));
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
    <script type="text/javascript" src="{{asset('js/truckScript.js')}}"></script>
@endsection

