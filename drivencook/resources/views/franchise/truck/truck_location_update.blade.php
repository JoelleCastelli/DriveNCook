@extends('franchise.franchise_dashboard')
@section('title')
    Mettre à jour la position du camion
@endsection


@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('franchise.truck_location_update_submit') }}">
                        {{csrf_field()}}

                        <div class="form-group">
                            <label for="location_id">{{ trans('truck_creation.location_name') }}</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" name="location_id" id="location_id">
                                    <option value="">Non assigné</option>
                                    @foreach($location_list as $location)
                                        <option {{$location['id'] == $truck['location_id']?'selected':''}}
                                                value={{ $location['id'] }}>
                                            {{ $location['name'] .' - '. $location['address'].' ('.$location['city']['postcode'].')' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @if ($errors->has('location_id'))
                                <span class="badge-danger">
                                    {{$errors->first('location_id')}}
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="location_date_start">Date de début</label>
                            <input type="date" class="form-control" id="location_date_start" name="location_date_start"
                                   value="{{$truck['location_date_start']}}" required/>
                            @if ($errors->has('location_date_start'))
                                <span class="badge-danger">
                                    {{$errors->first('location_date_start')}}
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="location_date_end">Date de fin</label>
                            <input type="date" class="form-control" id="location_date_end" name="location_date_end"
                                   value="{{$truck['location_date_end']}}"/>
                            @if ($errors->has('location_date_end'))
                                <span class="badge-danger">
                                    {{$errors->first('location_date_end')}}
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{ trans('truck.update_location_submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
@endsection