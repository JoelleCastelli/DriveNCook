@extends('corporate.layout_corporate')
@section('title')
    {{trans('event.event_creation')}}
@endsection

@section('content')



    <div class="col-8 col-xl-6 mt-5">
        @if (sizeof($errors) > 0)
            <div class="badge-danger">
                <ul>
                    @foreach($errors as $key => $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            @if (empty($type))
                <div class="card-header">{{trans('event.choose_event_type')}}</div>
                <div class="card-body">
                    <form id="select_event_type" method="post" action="{{route('corporate.event_creation_type')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>
                                <select name="type" id="type" class="form-control"
                                        onChange="document.getElementById('select_event_type').submit()">
                                    <option value="choisir" selected
                                            disabled>{{trans('event.choose_event_type')}}</option>
                                    <option value="private">{{trans('event.event_private')}}</option>
                                    <option value="public">{{trans('event.event_public')}}</option>
                                    <option value="news">{{trans('event.event_news')}}</option>
                                </select>
                            </label>
                        </div>
                    </form>
                </div>
            @else
                <div class="card-header">
                    <h2>{{trans('event.event_type').' : '.trans('event.event_'.$type)}}</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('corporate.event_creation_submit')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="type" id="type" value="{{$type}}">
                        <div class="form-group">
                            <label for="title">
                                {{trans('event.title')}}
                            </label>
                            <input type="text" class="form-control" name="title" id="title" maxlength="100" required>
                            @if ($errors->has('title'))
                                <span class="badge-danger">
                                    {{$errors->first('title')}}
                                </span>
                            @endif
                        </div>

                        @if ($type == 'private')
                            <div class="form-group">
                                <label for="invited">{{trans('event.invite_users')}}</label><br>
                                <select name="invited[]" id="invited" class="form-control selectsearch" multiple>
                                    @foreach($user_list as $user)
                                        <option value="{{$user['id']}}">{{$user['firstname'].' '.$user['lastname'].' ('.$user['email'].')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="date_start">
                                {{trans('event.start')}}
                            </label>
                            <input type="date" name="date_start" id="date_start" class="form-control" required>
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
                            <input type="date" name="date_end" id="date_end" class="form-control" required>
                            @if ($errors->has('date_end'))
                                <span class="badge-danger">
                                    {{$errors->first('date_end')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="location_id">{{trans('event.location')}}</label><br>
                            <select name="location_id" id="location_id" class="form-control selectsearch">
                                <option value="" selected disabled>{{trans('event.select_address')}}</option>
                                @foreach($location_list as $location)
                                    <option value="{{$location['id']}}">
                                        {{$location['address'].' - '.$location['city'].' ('.$location['name'].')'}}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="description">{{trans('event.description')}}</label>
                            <textarea id="description" name="description" class="form-control" required></textarea>
                            @if ($errors->has('description'))
                                <span class="badge-danger">
                                    {{$errors->first('description')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-light_blue">{{trans('event.add_event')}}</button>
                        </div>
                    </form>
                </div>
            @endif
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