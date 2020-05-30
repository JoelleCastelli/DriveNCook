@extends('corporate.layout_corporate')
@section('style')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@endsection
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

        <div class="col12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('warehouse_creation_submit') }}">
                        <div class="form-group">
                            <label for="name">{{ trans('warehouse.name') }}</label>
                            <input type="text" name="name" id="name"
                                   placeholder="{{ trans('warehouse.name_placeholder') }}" class="form-control"
                                   minlength="1"
                                   maxlength="30">
                        </div>


                        <div class="form-group">
                            <label for="address">{{ trans('warehouse.address') }}</label>
                            <input type="text" name="address" id="address"
                                   placeholder="{{ trans('warehouse.address_placeholder') }}" class="form-control"
                                   minlength="1"
                            maxlength="100">
                        </div>

                        <div class="form-group">
                            <label for="city">{{ trans('warehouse.city') }}</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" name="city" id="city">
                                    <option value="" selected>{{ trans('warehouse.select_menu_off') }}</option>
                                    @foreach($cities as $city)
                                        <option value={{ $city['id'] }}>{{ $city['name'] }}
                                            - {{ $city['postcode'] }}</option>
                                    @endforeach
                                </select>
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