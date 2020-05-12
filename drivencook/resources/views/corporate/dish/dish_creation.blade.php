@extends('corporate.layout_corporate')

@section('title')
    Création de produit
@endsection


@section('content')
    <div class="content">

        @if(Session::has('success'))
            <div class="alert-success">{{ Session::get('success') }}</div>
        @endif

        @if(Session::has('error'))
            <div class="alert-danger">
                {{ trans('dish.creation_error') }}
                @foreach(Session::get('error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-sm-10 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('dish_creation_submit') }}">

                            <div class="form-group">
                                <label for="name">{{ trans('dish.name') }}</label>
                                <input type="text" name="name" id="name"
                                       placeholder="{{ trans('dish.set_name') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="category">{{ trans('dish.category') }}</label>
                                <div class="input-group">
                                    <select class="custom-select" name="category" id="category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}">{{ trans('dish.category_'.strtolower($category)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ trans('dish.description') }}</label>
                                <input type="text" name="description" id="description"
                                       placeholder="{{ trans('dish.set_description') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="category">{{ trans('dish.diet') }}</label>
                                <div class="input-group">
                                    <select class="custom-select" name="diet" id="diet">
                                        @foreach($diets as $diet)
                                            <option value="{{ $diet }}">{{ trans('dish.diet_'.strtolower($diet)) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-info">{{ trans('dish.submit') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
@endsection