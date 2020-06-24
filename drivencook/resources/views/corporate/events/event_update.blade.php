@extends('corporate.layout_corporate')
@section('title')
    {{trans('corporate.event_update')}}
@endsection

@section('content')
    <div class="col-8 col-xl-6 mt-5">
        <div class="card">
            <div class="card-header">
                <h2>{{trans('corporate.event_type').' : '.trans('corporate.event_'.$event['type'])}}</h2>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('corporate.event_update_submit')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="event_id" id="event_id" value="{{$event['id']}}">

                    <div class="form-group">
                        <label for="title">
                            {{trans('corporate.title')}}
                        </label>
                        <input type="text" class="form-control" name="title" id="title" maxlength="100"
                               value="{{$event['title']}}" required>
                        @if ($errors->has('title'))
                            <span class="badge-danger">
                                    {{$errors->first('title')}}
                                </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="date_start">
                            {{trans('corporate.start')}}
                        </label>
                        <input type="date" name="date_start" id="date_start" class="form-control"
                               min="{{date('Y-m-d')}}" value="{{$event['date_start']}}" required>
                        @if ($errors->has('date_start'))
                            <span class="badge-danger">
                                    {{$errors->first('date_start')}}
                                </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="date_end">
                            {{trans('corporate.end')}}
                        </label>
                        <input type="date" name="date_end" id="date_end" class="form-control"
                               min="{{date('Y-m-d')}}" value="{{$event['date_end']}}" required>
                        @if ($errors->has('date_end'))
                            <span class="badge-danger">
                                    {{$errors->first('date_end')}}
                                </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="location_id">{{trans('truck.location')}}</label><br>
                        <select name="location_id" id="location_id" class="form-control selectsearch">
                            <option value="">{{trans('corporate.no-address')}}</option>
                            @foreach($location_list as $location)
                                <option value="{{$location['id']}}" {{$location['id'] == $event['location_id'] ? 'selected' : ''}}>
                                    {{$location['address'].' - '.$location['city'].' ('.$location['name'].')'}}
                                </option>
                            @endforeach
                        </select>
                        @if ($errors->has('location_id'))
                            <span class="badge-danger">
                                    {{$errors->first('location_id')}}
                                </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control"
                                  required>{{$event['description']}}</textarea>
                        @if ($errors->has('description'))
                            <span class="badge-danger">
                                    {{$errors->first('description')}}
                                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{trans('corporate.update_event')}}</button>
                    </div>
                </form>
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