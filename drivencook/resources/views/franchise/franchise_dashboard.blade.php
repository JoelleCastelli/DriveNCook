@extends('franchise.layout_franchise')

@section('title')
    {{trans('franchisee.dashboard').' '.$franchise['firstname'].' '.$franchise['lastname']. ' ('.(empty($franchise['pseudo'])?trans('franchisee.unknown_pseudo'):$franchise['pseudo']['name']).')'}}
@endsection


@section('content')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="card text-light2">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-indigo">{{trans('franchisee.truck_location')}} :<br>
                                </b><?php
                                if (empty($truck['location'])) {
                                    echo trans('franchisee.unknown');
                                } else {
                                    echo $truck['location']['address'] . ' (' . $truck['location']['city']['postcode'] . ')';
                                    echo '<br>';
                                    echo trans('franchisee.from') . ' ' . DateTime::createFromFormat('Y-m-d', $truck['location_date_start'])->format('d/m/Y');
                                    if ($truck['location_date_end'] != null) {
                                        echo ' ' . trans('franchisee.to') . ' ' . DateTime::createFromFormat('Y-m-d', $truck['location_date_end'])->format('d/m/Y');
                                    } else {
                                        echo ' ' . trans('franchisee.undetermined_duration');
                                    }
                                }
                                ?>

                            </li>
                            <li class="list-group-item bg-indigo align-content-arround">
                                <a href="{{route('franchise.truck_view')}}" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{trans('franchisee.view_details')}}
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
                            <li class="list-group-item bg-info">{{trans('franchisee.sell_count_30_days')}} : #TODO</li>
                            <li class="list-group-item bg-info align-content-arround">
                                <a href="#" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{trans('franchisee.view_details')}}
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
                            <li class="list-group-item bg-success">{{trans('franchisee.real_time_revenues_monthly')}} :
                                #TODO €
                            </li>
                            <li class="list-group-item bg-success align-content-arround">
                                <a href="#" target="_blank" class="row text-light2">
                                    <div class="col-10">
                                        {{trans('franchisee.view_details')}}
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