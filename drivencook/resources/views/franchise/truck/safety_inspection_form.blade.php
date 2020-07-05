@extends('franchise.layout_franchise')

@section('title')
    {{empty($safety_inspection)?trans('franchisee.add_safety_inspection') : trans('franchisee.update_safety_inspection')}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('franchise.truck_safety_inspection_submit')}}">
                        {{csrf_field()}}
                        @if (!empty($safety_inspection))
                            <input type="hidden" id="id" name="id" value="{{$safety_inspection['id']}}">
                        @endif

                        <div class="form-group">
                            <label for="date">{{trans('franchisee.date')}}</label>
                            <input class="form-control" type="date" id="date" name="date"
                                    {{!empty($safety_inspection)?'value='.$safety_inspection['date']:''}}>
                            @if ($errors->has('date'))
                                <span class="badge-danger">
                                    {{$errors->first('date')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="truck_age">{{trans('franchisee.truck_age_year')}}</label>
                            <input class="form-control" type="number" id="truck_age" name="truck_age" min="0" step="1"
                                   max="100" {{!empty($safety_inspection)?'value='.$safety_inspection['truck_age']:''}}>
                            @if ($errors->has('truck_age'))
                                <span class="badge-danger">
                                    {{$errors->first('truck_age')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="truck_mileage">{{trans('franchisee.truck_mileage_kilometers')}}</label>
                            <input class="form-control" type="number" id="truck_mileage" name="truck_mileage" min="0"
                                   step="1"
                                   max="9999999"
                                    {{!empty($safety_inspection)?'value='.$safety_inspection['truck_mileage']:''}}>
                            @if ($errors->has('truck_mileage'))
                                <span class="badge-danger">
                                    {{$errors->first('truck_mileage')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="replaced_parts">{{trans('franchisee.replaced_parts')}}</label>
                            <input class="form-control" type="text" id="replaced_parts" name="replaced_parts"
                                   maxlength="150"
                                    {{!empty($safety_inspection)?'value='.$safety_inspection['replaced_parts']:''}}>
                            @if ($errors->has('replaced_parts'))
                                <span class="badge-danger">
                                    {{$errors->first('replaced_parts')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="drained_fluids">{{trans('franchisee.drained_fluids')}}</label>
                            <input class="form-control" type="text" id="drained_fluids" name="drained_fluids"
                                   maxlength="150"
                                    {{!empty($safety_inspection)?'value='.$safety_inspection['drained_fluids']:''}}>
                            @if ($errors->has('drained_fluids'))
                                <span class="badge-danger">
                                    {{$errors->first('drained_fluids')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{!empty($safety_inspection)?trans('franchisee.update'):trans('franchisee.add')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
