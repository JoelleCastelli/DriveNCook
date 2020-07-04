@extends('franchise.layout_franchise')

@section('title')
    {{trans('franchisee.new_order')}}
@endsection

@section('content')
    @if (empty($warehouse))
        <!-- Étape 1, choix du warehouse -->
        <div class="row">
            <div class="col-12 col-lg-6 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h2>{{Lang::get('franchisee.step',['step_number'=>'1'])}}
                            - {{trans('franchisee.choose_warehouse')}} :</h2>
                    </div>
                    <div class="card-body">
                        @if(!empty($warehouse_list))
                            <select id="warehouse_select" class="form-control">
                                <option value="choisir" selected disabled>{{trans('franchisee.choose')}}</option>
                                @foreach($warehouse_list as $warehouse)
                                <option value="{{$warehouse['id']}}">
                                    {{ $warehouse['name'].' - '.$warehouse['location']['address'].' '.$warehouse['location']['postcode'].' '.$warehouse['location']['city'] }}
                                </option>
                                @endforeach
                            </select>
                        @else
                            {{ trans('franchisee.warehouse_no_stock') }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Étape 2, choix des plats -->
        <div class="row">
            <div class="col-12 col-lg-6 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h2>{{Lang::get('franchisee.step',['step_number'=>'2'])}}
                            - {{trans('franchisee.choose_plates')}} :</h2>
                        <h4>
                            {{trans('franchisee.warehouse')}} {{ $warehouse['name'].' - '.$warehouse['location']['address'].' '.$warehouse['location']['postcode'].' '.$warehouse['location']['city'] }}</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('franchise.stock_order_submit')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="warehouse_id" value="{{$warehouse['id']}}">

                            @foreach($warehouse['stock'] as $product)
                                @if($product['quantity'] > 0)
                                    <div class="form-group">
                                        <label for="{{'product_'.$product['dish_id']}}">{{$product['dish']['name'].' '.$product['warehouse_price'].'€/u'}}
                                            , Stock : {{$product['quantity']}}</label>
                                        <input class="form-control" type="number"
                                               id="{{'product_'.$product['dish_id']}}"
                                               name="{{'product_'.$product['dish_id']}}"
                                               min="0" step="1" max="{{$product['quantity']}}"
                                               value="0">
                                        @if ($errors->has('product_'.$product['dish_id']))
                                            <span class="badge-danger">
                                                {{$errors->first('product_'.$product['dish_id'])}}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <div class="form-group">
                                        <label for="{{'product_'.$product['dish_id']}}">{{$product['dish']['name'].' '.$product['warehouse_price'].'€/u'}}</label>
                                        <div class="form-control" type="text">Rupture de stock</div>
                                    </div>
                                @endif
                            @endforeach
                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-info">{{trans('franchisee.submit_order')}}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @endif
@endsection

@section('script')
    <script type="text/javascript">
        $('#warehouse_select').on('change', function (e) {
            var link = "{{route('franchise.stock_order_select_warehouse',['warehouse_id'=>':id'])}}";
            link = link.replace(":id", $('#warehouse_select').val());
            location.href = link;
        })
    </script>
@endsection