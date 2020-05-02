@extends('corporate.layout_corporate')
@section('style')
@endsection
@section('title')
    {{empty($safety_inspection)?'Ajout d\'un contrôle technique' : 'Mise à jour d\'un conrôle technique'}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('safety_inspection_submit')}}">
                        {{csrf_field()}}
                        @if (!empty($safety_inspection))
                            <input type="hidden" id="id" name="id" value="{{$safety_inspection['id']}}">
                        @endif
                        <input type="hidden" id="truck_id" name="truck_id" value="{{$truckId}}">

                        <div class="form-group">
                            <label for="date">Date</label>
                            <input {{!empty($safety_inspection)?'value='.$safety_inspection['date']:''}}
                                   class="form-control" type="date" id="date" name="date">
                            @if ($errors->has('date'))
                                <span class="badge-danger">
                                    {{$errors->first('date')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="truck_age">Age du camion (année(s))</label>
                            <input {{!empty($safety_inspection)?'value='.$safety_inspection['truck_age']:''}}
                                   class="form-control" type="number" id="truck_age" name="truck_age" min="0" step="1"
                                   max="100">
                            @if ($errors->has('truck_age'))
                                <span class="badge-danger">
                                    {{$errors->first('truck_age')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="truck_mileage">Kilométrage du camion (km)</label>
                            <input {{!empty($safety_inspection)?'value='.$safety_inspection['truck_mileage']:''}}
                                   class="form-control" type="number" id="truck_mileage" name="truck_mileage" min="0"
                                   step="1"
                                   max="9999999">
                            @if ($errors->has('truck_mileage'))
                                <span class="badge-danger">
                                    {{$errors->first('truck_mileage')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="replaced_parts">Parties remplacés</label>
                            <input {{!empty($safety_inspection)?'value='.$safety_inspection['replaced_parts']:''}}
                                   class="form-control" type="text" id="replaced_parts" name="replaced_parts"
                                   maxlength="150">
                            @if ($errors->has('replaced_parts'))
                                <span class="badge-danger">
                                    {{$errors->first('replaced_parts')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="drained_fluids">Drainage</label>
                            <input {{!empty($safety_inspection)?'value='.$safety_inspection['drained_fluids']:''}}
                                   class="form-control" type="text" id="drained_fluids" name="drained_fluids"
                                   maxlength="150">
                            @if ($errors->has('drained_fluids'))
                                <span class="badge-danger">
                                    {{$errors->first('drained_fluids')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{!empty($safety_inspection)?'Modifier':'Ajouter'}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
