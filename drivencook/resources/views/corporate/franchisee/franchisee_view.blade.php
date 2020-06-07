@extends('corporate.layout_corporate')
@section('title')
    {{ ucfirst($franchisee['firstname']).' '.strtoupper($franchisee['lastname']).' ('.$franchisee['pseudo']['name'].')' }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <h2>{{ trans('franchisee.franchisee_info') }}</h2>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item"><b>{{ trans('franchisee.name') }}</b> {{ $franchisee['lastname'] }}</li>
                    <li class="list-group-item"><b>{{ trans('franchisee.firstname') }}</b> {{ $franchisee['firstname'] }}</li>
                    <li class="list-group-item"><b>{{ trans('franchisee.email') }}</b> {{ $franchisee['email'] }}</li>
                    <li class="list-group-item"><b>{{ trans('franchisee.phone') }}</b>
                        {{ empty($franchisee['telephone']) ? trans('franchisee.not_specified_m') : $franchisee['telephone'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.birthdate') }}</b>
                        {{ empty($franchisee['birthdate']) ? trans('franchisee.not_specified_f') :
                                    DateTime::createFromFormat('Y-m-d',$franchisee['birthdate'])->format('d/m/Y') }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.account_status') }}</b>
                        {{ empty($franchisee['pseudo_id']) ? trans('franchisee.account_inactive') : trans('franchisee.account_active').' ('.$franchisee['pseudo']['name'].')' }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.driving_licence') }}</b>
                        {{ empty($franchisee['driving_licence']) ? trans('franchisee.not_specified_m') : $franchisee['driving_licence'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.social_security') }}</b>
                        {{ empty($franchisee['social_security']) ? trans('franchisee.not_specified_f') : $franchisee['social_security'] }}
                    </li>
                    <li class="list-group-item"><b>{{ trans('franchisee.registered_on') }}</b>
                        {{ DateTime::createFromFormat('Y-m-d H:i:s', $franchisee['created_at'])->format('d/m/Y') }}
                    </li>
                </ul>
                <div class="card-footer d-flex justify-content-end">
                    <a href="{{ route('franchisee_update',['id'=>$franchisee['id']]) }}">
                        <button class="btn btn-light_blue">{{ trans('franchisee.update_information') }}</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-header">
                    <h2>{{ trans('franchisee.truck_info') }}</h2>
                </div>
                @if (!empty($franchisee['truck']))
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_constructor') }}</b>
                            {{ empty($franchisee['truck']['brand'])? trans('franchisee.not_specified_m') : $franchisee['truck']['brand'] }}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_model') }}</b>
                            {{ empty($franchisee['truck']['model'])? trans('franchisee.not_specified_m') : $franchisee['truck']['model'] }}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_purchase_date') }}</b>
                            {{ empty($franchisee['truck']['purchase_date'])? trans('franchisee.not_specified_f'):
                                DateTime::createFromFormat('Y-m-d',$franchisee['truck']['purchase_date'])->format('d/m/Y')}}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_licence_plate') }}</b>
                            {{ empty($franchisee['truck']['license_plate'])? trans('franchisee.not_specified_f') : $franchisee['truck']['license_plate'] }}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_insurance_number') }}</b>
                            {{ empty($franchisee['truck']['insurance_number'])? trans('franchisee.not_specified_m') : $franchisee['truck']['insurance_number'] }}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_fuel_type') }}</b>
                            {{ empty($franchisee['truck']['fuel_type'])? trans('franchisee.not_specified_m') : $franchisee['truck']['fuel_type'] }}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_power') }}</b>
                            {{ empty($franchisee['truck']['horsepower'])? trans('franchisee.not_specified_f') : $franchisee['truck']['horsepower'].' CV'}}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_payload') }}</b>
                            {{ empty($franchisee['truck']['payload'])? trans('franchisee.not_specified_f') : $franchisee['truck']['payload'].' KG'}}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_general_state') }}</b>
                            {{ empty($franchisee['truck']['general_state'])? trans('franchisee.not_specified_m') : $franchisee['truck']['general_state'] }}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_last_safety_inspection') }}</b>
                            {{ empty($franchisee['truck']['last_safety_inspection']) ? trans('franchisee.not_specified_m') :
                                DateTime::createFromFormat('Y-m-d',$franchisee['truck']['last_safety_inspection']['date'])->format('d/m/Y')
                                .' ('.$franchisee['truck']['last_safety_inspection']['truck_mileage'].' km)'}}
                        </li>
                        <li class="list-group-item"><b>{{ trans('franchisee.truck_position') }}
                            </b>{{ empty($franchisee['truck']['location'])? trans('franchisee.not_specified_f') :
                                $franchisee['truck']['location']['address'].' ('.$franchisee['truck']['location']['city']['postcode'].')'}}
                        </li>
                    </ul>
                    <div class="card-footer d-flex justify-content-between">
                        <button class="btn btn-danger" onclick="unsetTruck({{ $franchisee['truck']['id'] }})">{{ trans('franchisee.remove_truck') }}
                        </button>

                        <a href="{{ route('truck_view',['id'=>$franchisee['truck']['id']]) }}">
                            <button class="btn btn-light_blue">{{ trans('franchisee.see_truck') }}</button>
                        </a>

                        <a href="{{ route('truck_update',['id'=>$franchisee['truck']['id']]) }}">
                            <button class="btn btn-light_blue">{{ trans('franchisee.update_information') }}</button>
                        </a>
                    </div>
                @else
                    <div class="card-body">
                        <h3>{{ trans('franchisee.no_truck_assigned') }}</h3>
                    </div>
                @endif
            </div>
        </div>
@endsection

@section('script')
    <script type="text/javascript">
        let urlB = "{{ route('unset_franchisee_truck',['id'=>':id']) }}";
    </script>
    <script type="text/javascript" src="{{ asset('js/truckScript.js') }}"></script>
@endsection
