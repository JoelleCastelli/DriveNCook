@extends('client.layout_client')
@section('title')
    {{ trans('client/order.title_dishes') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
        .orderIpt label {
            color: #FFFFFF;
        }
        .orderBtn {
            width: 100%;
            min-height: 60px;
            font-size: 25px;
        }
        .addToOrderBtn:hover {
            cursor: pointer;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-8">
            <div class="card mt-5">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="allDishes" class="table table-hover table-striped table-bordered table-dark"
                               style="width: 100%">
                            <thead>
                                <tr>
                                    <th>{{ trans('dish.actions') }}</th>
                                    <th>{{ trans('dish.quantity_to_order') }}</th>
                                    <th>{{ trans('dish.name') }}</th>
                                    <th>{{ trans('dish.category') }}</th>
                                    <th>{{ trans('dish.description') }}</th>
                                    <th>{{ trans('dish.diet') }}</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach($stocks as $stock)
                                    <tr>
                                        <td>
                                            <button class="text-light fa fa-plus addToOrderBtn"></button>
                                        </td>
                                        <td><input type="number" class="form-control orderDish"
                                                   id="{{ $stock['dish_id'] }}"
                                                   style="width: 100%"
                                                   value="0"
                                                   min="0"
                                                   max="{{ $stock['quantity'] }}"></td>
                                        <td>{{ $stock['dish']['name'] }}</td>
                                        <td>{{ trans('dish.category_' . strtolower($stock['dish']['category'])) }}</td>
                                        <td>{{ $stock['dish']['description'] }}</td>
                                        <td>{{ trans('dish.diet_' . strtolower($stock['dish']['diet'])) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card mt-5">
                <div class="card-header">
                    <h2>{{ trans('client/order.shopping_cart') }}</h2>
                    <button class="btn btn-light_blue orderBtn">{{ trans('client/order.order_btn') }}</button>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table style="width: 100%">
                            <thread>
                                <tr>
                                    <th scope="col">{{ trans('dish.actions') }}</th>
                                    <th scope="col">{{ trans('dish.quantity_ordered') }}</th>
                                    <th scope="col">{{ trans('dish.name') }}</th>
                                </tr>
                            </thread>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-light_blue orderBtn">{{ trans('client/order.order_btn') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#allDishes').DataTable();

            $('.orderBtn').on('click', function () {
                let table = $('.orderDish');

                for(let i = 0; i < table.length; i++) {
                    console.log(table[i]);
                }
            });
        });
    </script>
@endsection