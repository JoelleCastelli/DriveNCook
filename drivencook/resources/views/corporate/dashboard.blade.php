@extends('corporate.layout_corporate')

@section('sidebar')

@endsection

@section('title')
    {{ trans('dashboard_corporate.dashboard') }}
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-info">{{ trans('dashboard_corporate.nb_warehouses') }} {{ $nbWarehouses }}</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="{{ route('warehouse_list') }}" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('dashboard_corporate.see_details') }}
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
                            <li class="list-group-item bg-indigo">{{ trans('dashboard_corporate.nb_franchisees') }} {{$nbfranchisees}}</li>
                            <li class="list-group-item bg-indigo align-content-arround">
                                <a href="{{route('franchisee_list')}}" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('dashboard_corporate.see_details') }}
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
                            <li class="list-group-item bg-danger">{{ trans('dashboard_corporate.nb_clients') }} {{$nbUsers}}</li>
                            <li class="list-group-item bg-danger align-content-arround">
                                <a href="{{route('client_list')}}" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('dashboard_corporate.see_details') }}
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
                            <li class="list-group-item bg-success">{{ trans('dashboard_corporate.next_invoice') }} {{$revenues['next_invoice']}} €</li>
                            <li class="list-group-item bg-success align-content-arround">
                                <a href="#" class="row text-light2">
                                    <div class="col-10">
                                        {{ trans('dashboard_corporate.see_details') }}
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