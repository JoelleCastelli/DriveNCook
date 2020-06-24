@extends('corporate.layout_corporate')
@section('title')
    {{trans('corporate.event_creation')}}
@endsection
@section('style')
    {{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">--}}
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
                <div class="card-header">{{trans('corporate.choose_event_type')}}</div>
                <div class="card-body">
                    <form id="select_event_type" method="post" action="{{route('corporate.event_creation_type')}}">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label>
                                <select name="type" id="type" class="form-control"
                                        onChange="document.getElementById('select_event_type').submit()">
                                    <option value="choisir" selected disabled>{{trans('corporate.choose')}}</option>
                                    <option value="private">{{trans('corporate.event_private')}}</option>
                                    <option value="public">{{trans('corporate.event_public')}}</option>
                                    <option value="news">{{trans('corporate.event_news')}}</option>
                                </select>
                            </label>
                        </div>
                    </form>
                </div>
            @else
                <div class="card-header">
                    <h2>{{trans('corporate.event_type').' : '.trans('corporate.event_'.$type)}}</h2>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('corporate.event_creation_submit')}}">
                        {{csrf_field()}}
                        <input type="hidden" name="type" id="type" value="{{$type}}">
                        <div class="form-group">
                            <label for="title">
                                {{trans('corporate.title')}}
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
                                <label for="invited">Invite</label><br>
                                <select name="invited[]" id="invited" class="form-control selectsearch" multiple>
                                    @foreach($user_list as $user)
                                        <option value="{{$user['id']}}">{{$user['firstname'].' '.$user['lastname'].' ('.$user['email'].')'}}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="date_start">
                                {{trans('corporate.start')}}
                            </label>
                            <input type="date" name="date_start" id="date_start" class="form-control"
                                   min="{{date('Y-m-d')}}" required>
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
                                   min="{{date('Y-m-d')}}" required>
                            @if ($errors->has('date_end'))
                                <span class="badge-danger">
                                    {{$errors->first('date_end')}}
                                </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="location_id">{{trans('truck.location')}}</label><br>
                            <select name="location_id" id="location_id" class="form-control selectsearch">
                                <option value="" selected disabled>{{trans('corporate.select_address')}}</option>
                                @foreach($location_list as $location)
                                    <option value="{{$location['id']}}">
                                        {{$location['address'].' - '.$location['city'].' ('.$location['name'].')'}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea id="description" name="description" class="form-control" required></textarea>
                            @if ($errors->has('description'))
                                <span class="badge-danger">
                                    {{$errors->first('description')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">{{trans('corporate.add_event')}}</button>
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