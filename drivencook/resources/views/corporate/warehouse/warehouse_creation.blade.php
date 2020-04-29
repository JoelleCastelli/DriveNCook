@extends('corporate.layout_corporate')
@section('style')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
@endsection
@section('title')
    Ajouter un entrepôt
@endsection


@section('content')
    <div class="row">
        @if(Session::has('success'))
            <div class="alert-success mb-3">{{ Session::get('success') }}</div>
        @endif

        @if(Session::has('error'))
            <div class="alert-danger mb-3">
                {{ trans('warehouse_creation.new_warehouse_error') }}
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
                            <label for="name">{{ trans('warehouse_creation.name') }}</label>
                            <input type="text" name="name" id="name"
                                   placeholder="{{ trans('warehouse_creation.set_name') }}" class="form-control"
                                   minlength="1"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="city">{{ trans('warehouse_creation.city') }}</label>
                            <div class="input-group mb-3">
                                <select class="custom-select" name="city" id="city">
                                    <option value="" selected>{{ trans('warehouse_creation.select_menu_off') }}</option>
                                    @foreach($cities as $city)
                                        <option value={{ $city['id'] }}>{{ $city['name'] }}
                                            - {{ $city['postcode'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="address">{{ trans('warehouse_creation.address') }}</label>
                            <input type="text" name="address" id="address"
                                   placeholder="{{ trans('warehouse_creation.set_address') }}" class="form-control"
                                   minlength="1"
                                   maxlength="100">
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <button type="submit" class="btn btn-info">{{ trans('warehouse_creation.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <!--
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
    -->
@endsection