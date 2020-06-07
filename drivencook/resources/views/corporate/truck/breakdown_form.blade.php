@extends('corporate.layout_corporate')
@section('style')
@endsection
@section('title')
    {{ empty($breakdown) ? trans('truck.new_breakdown') : trans('truck.breakdown_update') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('breakdown_submit') }}">
                        {{csrf_field()}}
                        @if (!empty($breakdown))
                            <input type="hidden" id="id" name="id" value="{{ $breakdown['id'] }}">
                        @endif
                        <input type="hidden" id="truck_id" name="truck_id" value="{{$truckId}}">

                        <div class="form-group">
                            <label for="type">{{ trans('truck.breakdown_type') }}</label>
                            <select class="form-control" id="type" name="type">
                                @foreach($breakdown_type as $type)
                                    <option
                                            {{!empty($breakdown) && $breakdown['type'] == $type ? 'selected':''}}
                                            value="{{ $type }}">{{ trans('truck.breakdown_type_'.$type) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('type'))
                                <span class="badge-danger">
                                    {{$errors->first('type')}}
                                </span>
                            @endif

                        </div>

                        <div class="form-group">
                            <label for="description">{{ trans('truck.breakdown_description') }}</label>
                            <input {{!empty($breakdown)?'value='.$breakdown['description']:''}}
                                   class="form-control" type="text" id="description" name="description" maxlength="255">
                            @if ($errors->has('description'))
                                <span class="badge-danger">
                                    {{$errors->first('description')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="cost">{{ trans('truck.breakdown_cost') }}</label>
                            <input {{!empty($breakdown)?'value='.$breakdown['cost']:''}}
                                   class="form-control" type="number" id="cost" name="cost" min="0" step="0.01"
                                   max="999999">
                            @if ($errors->has('cost'))
                                <span class="badge-danger">
                                    {{$errors->first('cost')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="date">{{ trans('truck.breakdown_date') }}</label>
                            <input {{!empty($breakdown)?'value='.$breakdown['date']:''}}
                                   class="form-control" type="date" id="date" name="date">
                            @if ($errors->has('date'))
                                <span class="badge-danger">
                                    {{$errors->first('date')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="status">{{ trans('truck.breakdown_status') }}</label>
                            <select class="form-control" id="status" name="status">
                                @foreach($breakdown_status as $status)
                                    <option
                                            {{!empty($breakdown) && $breakdown['status'] == $status ? 'selected':''}}
                                            value="{{$status}}">{{ trans('truck.breakdown_status_'.$status) }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('status'))
                                <span class="badge-danger">
                                    {{$errors->first('status')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info">{{!empty($breakdown) ? trans('truck.update_submit') : trans('truck.submit')}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
