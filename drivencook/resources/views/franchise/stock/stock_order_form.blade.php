@extends('franchise.layout_franchise')

@section('title')
    Nouvelle commande
@endsection

@section('content')
    @if (empty($warehouse))
        <!-- Étape 1, choix du warehouse -->
        <div class="row">
            <div class="col-12 col-lg-6 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h2>Étape 1: Choisissez un entrepôt :</h2>
                    </div>
                    <div class="card-body">
                        <select id="warehouse_select" class="form-control">
                            <option value="choisir" selected disabled>Choisir</option>
                            @foreach($warehouse_list as $warehouse)
                                <option value="{{$warehouse['id']}}">
                                    {{$warehouse['name'].' - '.$warehouse['city']['name'].' ('.$warehouse['city']['postcode'].')'}}
                                </option>
                            @endforeach
                        </select>
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
                        <h2>Étape 2: Choisissez les plats :</h2>
                        <h3>Entrepôt {{$warehouse['name'].' - '.$warehouse['city']['name'].' ('.$warehouse['city']['postcode'].')'}}</h3>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('franchise.stock_order_submit')}}">
                            {{csrf_field()}}
                            <input type="hidden" name="warehouse_id" value="{{$warehouse['id']}}">

                            @foreach($warehouse['stock'] as $product)
                                <div class="form-group">
                                    <label for="{{'product_'.$product['dish_id']}}">{{$product['dish']['name'].' '.$product['warehouse_price'].'€/unité'}}</label>
                                    <input class="form-control" type="number" id="{{'product_'.$product['dish_id']}}"
                                           name="{{'product_'.$product['dish_id']}}"
                                           min="0" step="1" max="{{$product['quantity']}}"
                                           value="0">
                                    @if ($errors->has('product_'.$product['dish_id']))
                                        <span class="badge-danger">
                                    {{$errors->first('product_'.$product['dish_id'])}}
                                </span>
                                    @endif
                                </div>
                            @endforeach
                            <div class="form-group">
                                <button type="submit"
                                        class="btn btn-info">Valider la commande
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
            console.log(link);
            location.href = link;
        })
    </script>
@endsection