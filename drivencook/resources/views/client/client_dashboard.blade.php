@extends('client.layout_client')

@section('title')
    {{ trans('client/global.welcome') . ' ' . $client['firstname'] . ' ' . $client['lastname'] . ' !'}}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
    </style>
@stop
@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">
                                {{ trans('client/global.loyalty_point') . ' : ' . $client['loyalty_point'] }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-danger">
                                {{ trans('client/global.sales') . ' : ' . $nbSales }}
                            </li>
                            <li class="list-group-item bg-danger align-content-arround">
                                <a href="{{ route('client_sales_history') }}" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('client/global.show_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-success">Events : #TODO</li>
                            <li class="list-group-item bg-success align-content-arround">
                                <a href="#" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('client/global.show_details') }}
                                    </div>
                                    <div class="col-2">
                                        <i class="fa fa-chevron-right"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection