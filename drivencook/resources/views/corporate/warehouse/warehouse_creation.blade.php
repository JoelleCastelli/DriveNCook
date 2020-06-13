@extends('corporate.layout_corporate')

@section('title')
    {{ trans('warehouse.title_creation') }}
@endsection


@section('content')
    <div class="row">
        @if(Session::has('success'))
            <div class="alert-success mb-3">{{ Session::get('success') }}</div>
        @endif

        @if(Session::has('error'))
            <div class="alert-danger mb-3">
                {{ trans('warehouse.new_warehouse_error') }}
                @foreach(Session::get('error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('warehouse_creation_submit') }}">
                        <div class="row">
                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="new_location_name_input">{{ trans('warehouse.name') }}</label>
                                    <input name="warehouse_name" id="new_location_name_input" class="form-control"
                                           type="text" placeholder="{{ trans('warehouse.name_placeholder') }}"
                                           minlength="1" maxlength="30">
                                </div>
                            </div>

                            <div class="col-md-6 col-6">
                                <div class="form-group">
                                    <label for="select_location">{{ trans('warehouse.select_existing_location') }}</label>
                                    <select class="custom-select" name="existing_location_id" id="select_location">
                                        <option selected value>{{ trans('warehouse.select_menu_off') }}</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location['id'] }}">{{ $location['name'] .' - '. $location['address']
                                                            .' '.$location['postcode'] . ' '.$location['city']}}</option>
                                        @endforeach
                                    </select>
                                    <p><i>{{ trans('warehouse.select_existing_location_tooltip') }}</i></p>
                                </div>

                                <div class="form-group">{{ trans('warehouse.or') }}</div>

                                <div class="form-group">
                                    <label for="create_location">{{ trans('warehouse.add_new_location') }}</label>
                                    <input id="new_location_input" class="form-control" name="new_address_full" type="text" placeholder="Enter an address">
                                    <input type="hidden" id="map_latitude" name="new_address_lat" value="">
                                    <input type="hidden" id="map_longitude" name="new_address_lon" value="">
                                    <input type="hidden" id="map_address" name="new_address_address" value="">
                                    <input type="hidden" id="map_city" name="new_address_city" value="">
                                    <input type="hidden" id="map_postcode" name="new_address_postcode" value="">
                                    <input type="hidden" id="map_country" name="new_address_country" value="">
                                    <p><i>{{ trans('warehouse.new_location_name_tooltip') }}</i></p>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <button type="submit" class="btn btn-info">{{ trans('warehouse.submit') }}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places&callback=initMap" async defer></script>
    <script>
        function initMap() {
            let options = {
                componentRestrictions: {country: "FR"},
                types: ['address']
            };

            // CREATION AUTOCOMPLETE
            let input = document.getElementById('new_location_input');
            let autocomplete = new google.maps.places.Autocomplete(input, options);
            autocomplete.addListener('place_changed', function () {
                let place = autocomplete.getPlace();
                document.getElementById('map_latitude').value = place.geometry.location.lat();
                document.getElementById('map_longitude').value = place.geometry.location.lng();
                document.getElementById('map_address').value = place.name;
                document.getElementById('map_city').value = place.address_components[2].long_name;
                document.getElementById('map_postcode').value = place.address_components[6].long_name;
                document.getElementById('map_country').value = place.address_components[5].long_name;
            });
        }

    </script>
@endsection