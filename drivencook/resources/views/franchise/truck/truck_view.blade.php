@extends('franchise.layout_franchise')

@section('title')
    {{trans('franchisee.truck')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('franchisee.truck_info')}}</h2>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_constructor') }}</b>
                        {{ empty($truck['brand'])? trans('franchisee.not_specified_m') : $truck['brand'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_model') }}</b>
                        {{ empty($truck['model'])? trans('franchisee.not_specified_m') : $truck['model'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_purchase_date') }}</b>
                        {{ empty($truck['purchase_date'])? trans('franchisee.not_specified_f'):
                            DateTime::createFromFormat('Y-m-d',$truck['purchase_date'])->format('d/m/Y')}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_licence_plate') }}</b>
                        {{ empty($truck['license_plate'])? trans('franchisee.not_specified_f') : $truck['license_plate'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_insurance_number') }}</b>
                        {{ empty($truck['insurance_number'])? trans('franchisee.not_specified_m') : $truck['insurance_number'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_fuel_type') }}</b>
                        {{ empty($truck['fuel_type'])? trans('franchisee.not_specified_m') : $truck['fuel_type'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_power') }}</b>
                        {{ empty($truck['horsepower'])? trans('franchisee.not_specified_f') : $truck['horsepower'].' CV'}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_payload') }}</b>
                        {{ empty($truck['payload'])? trans('franchisee.not_specified_f') : $truck['payload'].' KG'}}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_general_state') }}</b>
                        {{ empty($truck['general_state'])? trans('franchisee.not_specified_m') : $truck['general_state'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.truck_last_safety_inspection') }}</b>
                        {{ empty($truck['last_safety_inspection']) ? trans('franchisee.not_specified_m') :
                            DateTime::createFromFormat('Y-m-d',$truck['last_safety_inspection']['date'])->format('d/m/Y')
                            .' ('.$truck['last_safety_inspection']['truck_mileage'].' km)'}}
                    </li>
                    <li class="list-group-item"><b>{{trans('franchisee.truck_position')}}
                        </b><?php
                        if (empty($truck['location'])) {
                            echo trans('franchisee.unknown');
                        } else {
                            echo $truck['location']['address'] . ' (' . $truck['location']['postcode'] . ')';
                            echo '<br>';
                            if ($truck['location_date_end'] != null) {
                                echo trans('franchisee.from') . ' ' . DateTime::createFromFormat('Y-m-d', $truck['location_date_start'])->format('d/m/Y');
                                echo ' ' . trans('franchisee.to') . ' ' . DateTime::createFromFormat('Y-m-d', $truck['location_date_end'])->format('d/m/Y');
                            } else {
                                echo trans('franchisee.since') . ' ' . DateTime::createFromFormat('Y-m-d', $truck['location_date_start'])->format('d/m/Y');
                                echo ' ('.trans('franchisee.undetermined_duration').')';
                            }
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>

        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('franchisee.truck_breakdown_history')}}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="breakdowns_history" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{trans('franchisee.date')}}</th>
                                <th>{{trans('franchisee.breakdown_type')}}</th>
                                <th>{{trans('franchisee.description')}}</th>
                                <th>{{trans('franchisee.breakdown_cost')}}</th>
                                <th>{{trans('franchisee.breakdown_status')}}</th>
                                <th>{{trans('franchisee.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($truck['breakdowns'] as $breakdown)
                                <tr id="row_{{$breakdown['id']}}">
                                    <td>
                                        {{$breakdown['date']}}
                                    </td>
                                    <td>{{$breakdown['type']}}</td>
                                    <td>{{$breakdown['description']}}</td>
                                    <td>{{$breakdown['cost']}} €</td>
                                    <td>{{$breakdown['status']}}</td>
                                    <td>
                                        <a href="{{route('franchise.truck_breakdown_update',["breakdown_id"=>$breakdown['id']])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('franchise.truck_breakdown_add')}}">
                        <button class="btn btn-light_blue">{{trans('franchisee.add_breakdown')}}</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{trans('franchisee.truck_safety_inspection_history')}}</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="safety_inspection_history"
                               class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>{{trans('franchisee.date')}}</th>
                                <th>{{trans('franchisee.truck_mileage_kilometers')}}</th>
                                <th>{{trans('franchisee.replaced_parts')}}</th>
                                <th>{{trans('franchisee.drained_fluids')}}</th>
                                <th>{{trans('franchisee.action')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($truck['safety_inspection'] as $inspection)
                                <tr id="row_{{$inspection['id']}}">
                                    <td>{{$inspection['date']}}</td>
                                    <td>{{$inspection['truck_mileage']}} km</td>
                                    <td>{{$inspection['replaced_parts']}}</td>
                                    <td>{{$inspection['drained_fluids']}}</td>
                                    <td>
                                        <a href="{{route('franchise.truck_safety_inspection_update',["safety_inspection_id"=> $inspection['id']])}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{route('franchise.truck_safety_inspection_add')}}">
                        <button class="btn btn-light_blue">{{trans('franchisee.add_safety_inspection')}}</button>
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

        let urlB = "{{route('unset_franchisee_truck',['id'=>':id'])}}";
    </script>
@endsection

