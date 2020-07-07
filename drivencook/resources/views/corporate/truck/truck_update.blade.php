@extends('corporate.layout_corporate')

@section('title')
    {{ trans('truck.truck_update') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            @if(Session::has('success'))
                <div class="alert-success mb-3">{{ Session::get('success') }}</div>
            @endif

            @if(Session::has('error'))
                <div class="alert-danger mb-3">
                    {{ trans('truck.new_truck_error') }}
                    @foreach(Session::get('error') as $error)
                        <li style="margin-left: 20px">{{ $error }}</li>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('truck_update_submit') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $truck['id'] }}">

                        <div class="form-group">
                            <label for="brand">{{ trans('truck.brand') }}</label>
                            <input type="text" name="brand" id="brand" value="{{$truck['brand']}}"
                                   class="form-control"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="model">{{ trans('truck.model') }}</label>
                            <input type="text" name="model" id="model" value="{{$truck['model']}}"
                                   class="form-control"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="functional">{{ trans('truck.functional') }}</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" name="functional" id="functional">
                                    <option value="0" {{$truck['functional']?'selected':''}}>{{ trans('truck.no') }}</option>
                                    <option value="1" {{$truck['functional']?'selected':''}}>{{ trans('truck.yes') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="purchase_date">{{ trans('truck.purchase_date') }}</label>
                            <input type="date" name="purchase_date" id="purchase_date"
                                   value="{{$truck['purchase_date']}}" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="license_plate">{{ trans('truck.license_plate') }}</label>
                            <input type="text" name="license_plate" id="license_plate"
                                   value="{{$truck['license_plate']}}"
                                   class="form-control"
                                   minlength="9"
                                   maxlength="9">
                        </div>

                        <div class="form-group">
                            <label for="registration_document">{{ trans('truck.registration_document') }}</label>
                            <input type="text" name="registration_document" id="registration_document"
                                   value="{{$truck['registration_document']}}"
                                   class="form-control"
                                   minlength="15" maxlength="15">
                        </div>

                        <div class="form-group">
                            <label for="insurance_number">{{ trans('truck.insurance_number') }}</label>
                            <input type="text" name="insurance_number" id="insurance_number"
                                   value="{{$truck['insurance_number']}}"
                                   class="form-control"
                                   minlength="20" maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="fuel_type">{{ trans('truck.fuel_type') }}</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" name="fuel_type" id="fuel_type">
                                    <option value="{{$truck['fuel_type']}}"
                                            selected>{{ trans('truck.fuel_type_' . strtolower($truck['fuel_type']) . '') }}</option>
                                    @foreach($fuels as $fuel)
                                        <option value={{ $fuel }}>{{ trans('truck.fuel_type_' . strtolower($fuel) . '') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="chassis_number">{{ trans('truck.chassis_number') }}</label>
                            <input type="text" name="chassis_number" id="chassis_number"
                                   value="{{$truck['chassis_number']}}"
                                   class="form-control"
                                   minlength="20" maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="engine_number">{{ trans('truck.engine_number') }}</label>
                            <input type="text" name="engine_number" id="engine_number"
                                   value="{{$truck['engine_number']}}"
                                   class="form-control"
                                   minlength="20"
                                   maxlength="20">
                        </div>

                        <div class="form-group">
                            <label for="horsepower">{{ trans('truck.horsepower') }}</label>
                            <input type="number" name="horsepower" id="horsepower" value="{{$truck['horsepower']}}"
                                   class="form-control"
                                   min="1">
                        </div>

                        <div class="form-group">
                            <label for="weight_empty">{{ trans('truck.weight_empty') }}</label>
                            <input type="number" name="weight_empty" id="weight_empty"
                                   value="{{$truck["weight_empty"]}}"
                                   class="form-control"
                                   min="1">
                        </div>

                        <div class="form-group">
                            <label for="payload">{{ trans('truck.payload') }}</label>
                            <input type="number" name="payload" id="payload" value="{{$truck['payload']}}"
                                   class="form-control" min="2">
                        </div>

                        <div class="form-group">
                            <label for="general_state">{{ trans('truck.general_state') }}</label>
                            <input type="text" name="general_state" id="general_state"
                                   value="{{$truck['general_state']}}"
                                   class="form-control"
                                   maxlength="255">
                        </div>

                        <div class="form-group">
                            <label for="location_id">{{ trans('truck.location_name') }}</label>
                            <div class="input-group mb-3">
                                <select class="custom-select selectsearch" name="location_id" id="location_id">
                                    @foreach($locations as $location)
                                        <option {{$location['id'] == $truck['location_id'] ? 'selected' : ''}}
                                                value={{ $location['id'] }}>{{ $location['name'] }}
                                            - {{ $location['address'].' '.$location['postcode'].' '.$location['city'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location_date_start">{{ trans('truck.location_date_start') }}</label>
                            <input type="date" name="location_date_start" id="location_date_start"
                                   value="{{$truck['location_date_start']}}"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="location_date_end">{{ trans('truck.location_date_end') }}</label>
                            <input type="date" name="location_date_end" id="location_date_end"
                                   value="{{$truck['location_date_end']}}"
                                   class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{ trans('truck.update_submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.selectsearch').SumoSelect({search: true});
        });
    </script>
@endsection