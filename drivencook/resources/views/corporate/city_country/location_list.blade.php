@extends('corporate.layout_corporate')

@section('title')
    {{ trans('locations.locations_management') }}
@endsection

@section('style')
    <style>
        .pac-container {
            background-color: #FFF;
            z-index: 20;
            position: fixed;
            display: inline-block;
            float: left;
        }
        .modal{
            z-index: 20;
        }
        .modal-backdrop{
            z-index: 10;
        }​
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h2>{{ trans('locations.add_location') }}</h2>
                </div>
                <div class="card-body">
                    <form>
                        {{ csrf_field() }}
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <input id="new_location_name_input" class="form-control" type="text" placeholder="{{ trans('locations.enter_name') }}" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <input id="new_location_input" class="form-control" type="text" placeholder="{{ trans('locations.enter_address') }}" required>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="map_latitude" value="">
                        <input type="hidden" id="map_longitude" value="">
                        <input type="hidden" id="map_address" value="">
                        <input type="hidden" id="map_city" value="">
                        <input type="hidden" id="map_postcode" value="">
                        <input type="hidden" id="map_country" value="">
                        <button type="button" class="btn btn-primary" id="modalSubmit" onclick="onSubmit('create')">{{ trans('locations.add') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <div class="card mt-5" id="locations-list">
        <div class="card-header d-flex justify-content-between">
            <h2>{{ trans('locations.locations_list') }}</h2>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="all_locations" class="table table-hover table-striped table-bordered table-dark"
                       style="width: 100%">
                    <thead>
                    <tr>
                        <th>{{ trans('locations.name') }}</th>
                        <th>{{ trans('locations.address') }}</th>
                        <th>{{ trans('locations.city') }}</th>
                        <th>{{ trans('locations.country') }}</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($location_list as $location)
                        <tr id="{{'row_'.$location['id']}}">
                            <td>{{ $location['name'] }}</td>
                            <td>{{ $location['address'] }}</td>
                            <td>{{ $location['city'] .' ('. $location['postcode'].')' }}</td>
                            <td>{{ $location['country'] }}</td>
                            <td>
                                <button onclick="onUpdateModal('{{ $location['id'] }}','{{ $location['name'] }}',
                                        '{{ $location['address'] }}','{{ $location['city'] }}','{{ $location['postcode'] }}',
                                        '{{ $location['country'] }}','{{ $location['latitude'] }}','{{$location['longitude']}}')"
                                        class="fa fa-edit" data-toggle="modal"
                                        data-target="#formModal"></button>
                                <button onclick="onDelete({{ $location['id'] }})" class="fa fa-trash ml-3"></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="form">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">{{ trans('locations.update_location') }}</h5>
                    <button type="button" id="closeModal" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        {{csrf_field()}}
                        <input type="hidden" id="formId" name="id" value="">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="update_location_name">{{ trans('locations.name') }} :</label>
                                        <input type="text" name="update_location_name" id="update_location_name"
                                               value="" minlength="1" maxlength="30" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="update_location_address">{{ trans('locations.address') }} :</label>
                                        <input type="text" name="update_location_address" id="update_location_input"
                                               value="" minlength="1" maxlength="100" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="map_latitude_update" value="">
                        <input type="hidden" id="map_longitude_update" value="">
                        <input type="hidden" id="map_address_update" value="">
                        <input type="hidden" id="map_city_update" value="">
                        <input type="hidden" id="map_postcode_update" value="">
                        <input type="hidden" id="map_country_update" value="">

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('locations.cancel') }}</button>
                            <button type="button" class="btn btn-primary" id="modalSubmit" onclick="onSubmit('update')">{{ trans('locations.save_changes') }}
                            </button>
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
            autocomplete.addListener('place_changed', function() {
                let place = autocomplete.getPlace();
                document.getElementById('map_latitude').value = place.geometry.location.lat();
                document.getElementById('map_longitude').value = place.geometry.location.lng();
                document.getElementById('map_address').value = place.name;
                document.getElementById('map_city').value = place.address_components[2].long_name;
                document.getElementById('map_postcode').value = place.address_components[6].long_name;
                document.getElementById('map_country').value = place.address_components[5].long_name;
            });

            // UPDATE AUTOCOMPLETE
            let update_input = document.getElementById('update_location_input');
            let update_autocomplete = new google.maps.places.Autocomplete(update_input, options);
            update_autocomplete.addListener('place_changed', function() {
                let place = update_autocomplete.getPlace();
                document.getElementById('map_latitude_update').value = place.geometry.location.lat();
                document.getElementById('map_longitude_update').value = place.geometry.location.lng();
                document.getElementById('map_address_update').value = place.name;
                document.getElementById('map_city_update').value = place.address_components[2].long_name;
                document.getElementById('map_postcode_update').value = place.address_components[6].long_name;
                document.getElementById('map_country_update').value = place.address_components[5].long_name;
            });
        }
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#all_locations').DataTable();
        });

        function onUpdateModal(id, name, address, city, postcode, country, latitude, longitude) {
            document.getElementById('formId').value = id;
            document.getElementById('update_location_name').value = name;
            document.getElementById('update_location_input').value = address + ', ' + city + ', ' + country;
            document.getElementById('map_latitude_update').value = latitude;
            document.getElementById('map_longitude_update').value = longitude;
            document.getElementById('map_address_update').value = address;
            document.getElementById('map_city_update').value = city;
            document.getElementById('map_postcode_update').value = postcode;
            document.getElementById('map_country_update').value = country;
        }

        let id, name, address, city, postcode, country, lat, lon;
        function onSubmit(value) {
            if(value === 'create') {
                id = 0;
                name = document.getElementById('new_location_name_input').value;
                address = document.getElementById('map_address').value;
                city = document.getElementById('map_city').value;
                postcode = document.getElementById('map_postcode').value;
                country = document.getElementById('map_country').value;
                lat = document.getElementById('map_latitude').value;
                lon = document.getElementById('map_longitude').value;
            } else if (value === 'update') {
                id = document.getElementById('formId').value;
                name = document.getElementById('update_location_name').value;
                address = document.getElementById('map_address_update').value;
                city = document.getElementById('map_city_update').value;
                postcode = document.getElementById('map_postcode_update').value;
                country = document.getElementById('map_country_update').value;
                lat = document.getElementById('map_latitude_update').value;
                lon = document.getElementById('map_longitude_update').value;
            }

            if (!isNaN(id)) {
                $.ajax({
                    url: '{{ route('location_submit') }}',
                    method: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {'id': id, 'name': name,
                        'address': address, 'city': city, 'postcode': postcode, 'country': country,
                        'lat': lat, 'lon': lon },
                    success: function (data) {
                        const dataJ = JSON.parse(data);
                        if (dataJ.response === "success") {
                            if (dataJ.isNew === true) {
                                alert(Lang.get('locations.location_created'));
                                let tbody = document.getElementsByTagName('tbody')[0];
                                tbody.innerHTML =
                                    '<tr id="row_' + dataJ.id + '">' +
                                    '<td>' + dataJ.name       + '</td>' +
                                    '<td>' + dataJ.address    + '</td>' +
                                    '<td>' + dataJ.city +' (' + dataJ.postcode + ')'      + '</td>' +
                                    '<td>' + dataJ.country    + '</td>' +
                                    '<td>' +
                                    '<button onclick="onUpdateModal(' + dataJ.id + ',' + dataJ.name + ',' + dataJ.address
                                    + ',' + dataJ.city + ',' + dataJ.postcode + ',' + dataJ.country + ',' + dataJ.latitude + dataJ.longitude + ')"' +
                                    'class="fa fa-edit" data-toggle="modal" data-target="#formModal"></button>' +
                                    '<button onclick="onDelete(' + dataJ.id + ')" class="fa fa-trash ml-3"></button>' +
                                    '</td>' +
                                    '</tr>' + tbody.innerHTML;
                            } else {
                                alert(Lang.get('locations.location_updated'));
                                let row = document.getElementById('row_' + dataJ.id);
                                let nameTd = row.getElementsByTagName('td')[0];
                                let addressTd = row.getElementsByTagName('td')[1];
                                let cityTd = row.getElementsByTagName('td')[2];
                                let countryTd = row.getElementsByTagName('td')[3];
                                nameTd.innerText = dataJ.name;
                                addressTd.innerText = dataJ.address;
                                cityTd.innerText = dataJ.city;
                                countryTd.innerText = dataJ.country;
                            }
                            document.getElementById('closeModal').click();
                        } else {
                            alert(Lang.get('locations.ajax_error'));
                        }
                    },
                    error: function (error) {
                        alert(error.responseText);
                    }
                })
            }
        }

        function onDelete(id) {
            if (confirm(Lang.get('locations.delete_confirm'))) {
                if (!isNaN(id)) {
                    let urlB = '{{route('location_delete',['id'=>':id'])}}';
                    urlB = urlB.replace(':id', id);
                    $.ajax({
                        url: urlB,
                        method: "delete",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (data) {
                            if (data == id) {
                                alert(Lang.get('locations.delete_success'));
                                let row = document.getElementById('row_' + id);
                                row.remove();
                            } else {
                                alert(Lang.get('locations.ajax_error'));
                            }
                        },
                        error: function () {
                            alert(Lang.get('locations.useful_location'));
                        }
                    })
                }
            }
        }
    </script>
@endsection