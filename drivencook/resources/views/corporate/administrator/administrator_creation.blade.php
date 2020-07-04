@extends('corporate.layout_corporate')
@section('title')
    {{ trans('admin.creation_title') }}
@endsection

@section('content')
    <div class="row">
        @if ($errors->has('admin_creation'))
            @foreach ($errors->all() as $message)
                <div style="padding: 3px" class="badge-danger">
                    {{ $message }}
                </div>
            @endforeach
        @elseif ($errors->has('admin_creation_success'))
            <span style="padding: 3px" class="badge-success">
                {{ $errors->first('admin_creation_success') }}
            </span>
        @endif
        <div class="col12 col-md-6">
            <div class="card">
                <div class="card-body">
                    <form method="post" action="{{ route('admin_creation_submit') }}">
                        <div class="form-group">
                            <label for="lastname">{{ trans('admin.name') }}</label>
                            <input type="text" name="lastname" id="lastname"
                                   placeholder="{{ trans('admin.set_lastname') }}"
                                   class="form-control"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="firstname">{{ trans('admin.firstname') }}</label>
                            <input type="text" name="firstname" id="firstname"
                                   placeholder="{{ trans('admin.set_firstname') }}"
                                   class="form-control"
                                   maxlength="30">
                        </div>

                        <div class="form-group">
                            <label for="email">{{ trans('admin.email') }}</label>
                            <input type="text" name="email" id="email"
                                   placeholder="{{ trans('admin.set_email') }}"
                                   class="form-control"
                                   maxlength="100">
                        </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <button type="submit"
                                    class="btn btn-info"
                                    id="submitBtn">{{ trans('admin.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection