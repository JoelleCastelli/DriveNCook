@extends('corporate.layout_corporate')

@section('title')
    {{ trans('warehouse_update.title') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6">
            @if(Session::has('success'))
                <div class="alert-success mb-3">{{ Session::get('success') }}</div>
            @endif

            @if(Session::has('error'))
                <div class="alert-danger mb-3">
                    {{ trans('warehouse_update.update_warehouse_error') }}
                    @foreach(Session::get('error') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('warehouse_update_submit') }}">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id" value="{{ $warehouse['id'] }}">

                        <div class="form-group">
                            <label for="name">{{ trans('warehouse_creation.name') }}</label>
                            <input type="text" name="name" id="name" value="{{ $warehouse['name'] }}"
                                   class="form-control"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="city">{{ trans('warehouse.select_existing_location') }}<b>*</b></label>
                            <div class="input-group mb-3">
                                <select class="custom-select" name="location_id" id="location_id">
                                    @foreach($locations as $location)
                                        <option {{ $location['id'] == $warehouse['location_id'] ? 'selected' : '' }}
                                                value={{ $location['id'] }}>{{ $location['name'] }} - {{ $location['address'] }} {{ $location['postcode'] }} {{ $location['city'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <p><b>*</b>: <i>{{ trans('warehouse.select_existing_location_tooltip') }}</i></p>
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{ trans('warehouse_update.update_submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection