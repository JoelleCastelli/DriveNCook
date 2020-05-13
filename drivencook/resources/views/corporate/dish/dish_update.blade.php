@extends('corporate.layout_corporate')
@section('style')
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/css/bootstrap4-toggle.min.css"
          rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css"
          rel="stylesheet">
@endsection
@section('title')
    Modification du produit {{ $dish['name'] }}
@endsection


@section('content')
    <div class="content">

        @if(Session::has('success'))
            <div class="alert-success">{{ Session::get('success') }}</div>
        @endif

        @if(Session::has('error'))
            <div class="alert-danger">
                {{ trans('dish.update_error') }}
                @foreach(Session::get('error') as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-sm-10 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form method="post" action="{{ route('dish_update_submit') }}">
                            <div class="form-group">
                                <input type="hidden" name="id" id="id" value="{{ $dish['id'] }}">
                            </div>

                            <div class="form-group">
                                <label for="name">{{ trans('dish.name') }}</label>
                                <input type="text" name="name" id="name"
                                       value="{{ $dish['name'] }}"
                                       placeholder="{{ trans('dish.set_name') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="category">{{ trans('dish.category') }}</label>
                                <div class="input-group">
                                    <select class="custom-select" name="category" id="category">
                                        <option selected value="{{ $dish['category'] }}">{{ trans('dish.category_'.strtolower($dish['category'])) }}</option>
                                        @foreach($categories as $category)
                                            @if($category != $dish['category'])
                                                <option value="{{ $category }}">{{ trans('dish.category_'.strtolower($category)) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="form-group">
                                <label for="description">{{ trans('dish.description') }}</label>
                                <input type="text" name="description" id="description"
                                       value="{{ $dish['description'] }}"
                                       placeholder="{{ trans('dish.set_description') }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="category">{{ trans('dish.diet') }}</label>
                                <div class="input-group">
                                    <select class="custom-select" name="diet" id="diet">
                                        <option selected value="{{ $dish['diet'] }}">{{ trans('dish.diet_'.strtolower($dish['diet'])) }}</option>
                                        @foreach($diets as $diet)
                                            @if($diet != $dish['diet'])
                                                <option value="{{ $diet }}">{{ trans('dish.diet_'.strtolower($diet)) }}</option>
                                            @endif
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
