@extends('corporate.layout_corporate')
@section('style')
@endsection
@section('title')
    {{empty($breakdown)?'Ajout d\'une panne' : 'Mise à jour d\'une panne'}}
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-lg-6 mb-5">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{route('breakdown_submit')}}">
                        {{csrf_field()}}
                        @if (!empty($breakdown))
                            <input type="hidden" id="id" name="id" value="{{$breakdown['id']}}">
                        @endif
                        <input type="hidden" id="truck_id" name="truck_id" value="{{$truckId}}">

                        <div class="form-group">
                            <label for="type">Type de panne</label>
                            <select class="form-control" id="type" name="type">
                                @foreach($breakdown_type as $type)
                                    <option
                                            {{!empty($breakdown) && $breakdown['type'] == $type ? 'selected':''}}
                                            value="{{$type}}">{{$type}}
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
                            <label for="description">Description</label>
                            <input {{!empty($breakdown)?'value='.$breakdown['description']:''}}
                                   class="form-control" type="text" id="description" name="description" maxlength="255">
                            @if ($errors->has('description'))
                                <span class="badge-danger">
                                    {{$errors->first('description')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="cost">Coût</label>
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
                            <label for="date">Date</label>
                            <input {{!empty($breakdown)?'value='.$breakdown['date']:''}}
                                   class="form-control" type="date" id="date" name="date">
                            @if ($errors->has('date'))
                                <span class="badge-danger">
                                    {{$errors->first('date')}}
                                </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                @foreach($breakdown_status as $status)
                                    <option
                                            {{!empty($breakdown) && $breakdown['status'] == $status ? 'selected':''}}
                                            value="{{$status}}">{{$status}}
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
                                    class="btn btn-info">{{!empty($breakdown)?'Modifier':'Ajouter'}}</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
