@extends('corporate.layout_corporate')
@section('title')
    {{trans('event.event_update')}}
@endsection

@section('content')
    <div class="col-8 col-xl-6 mt-5">
        <div class="card">
            <div class="card-header">
                <h2>{{trans('event.event_type').' : '.trans('event.event_'.$event['type'])}}</h2>
            </div>
            <div class="card-body">
                <form method="post" action="{{route('corporate.event_update_submit')}}">
                    {{csrf_field()}}
                    <input type="hidden" name="event_id" id="event_id" value="{{$event['id']}}">

                    <div class="form-group">
                        <label for="title">
                            {{trans('event.title')}}
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
                            {{trans('event.start')}}
                        </label>
                        <input type="date" name="date_start" id="date_start" class="form-control"
                               value="{{$event['date_start']}}" required>
                        @if ($errors->has('date_start'))
                            <span class="badge-danger">
                                    {{$errors->first('date_start')}}
                                </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="date_end">
                            {{trans('event.end')}}
                        </label>
                        <input type="date" name="date_end" id="date_end" class="form-control"
                               value="{{$event['date_end']}}" required>
                        @if ($errors->has('date_end'))
                            <span class="badge-danger">
                                    {{$errors->first('date_end')}}
                                </span>
                        @endif

                    </div>
                    <div class="form-group">
                        <label for="location_id">{{trans('event.location')}}</label><br>
                        <select name="location_id" id="location_id" class="form-control selectsearch">
                            <option value="">{{trans('event.no-address')}}</option>
                            @foreach($location_list as $location)
                                <option value="{{$location['id']}}" {{$location['id'] == $event['location_id'] ? 'selected' : ''}}>
                                    {{$location['name'].' - '.$location['address'].' '.$location['postcode'].' '.$location['city']}}
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
                        <label for="description">{{trans('event.description')}}</label>
                        <textarea id="description" name="description" class="form-control"
                                  required>{{$event['description']}}</textarea>
                        @if ($errors->has('description'))
                            <span class="badge-danger">
                                    {{$errors->first('description')}}
                                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-light_blue">{{trans('event.event_update')}}</button>
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