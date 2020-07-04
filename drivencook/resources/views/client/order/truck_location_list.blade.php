@extends('client.layout_client')
@section('title')
    {{ trans('client/order.title') }}
@endsection
@section('style')
    <style>
        .clientTitle {
            color: #FFFFFF;
        }
    </style>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="allTrucks" class="table table-hover table-striped table-bordered table-dark"
                                       style="width: 100%">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ trans('client/order.pseudo') }}</th>
                                        <th>{{ trans('client/order.franchisee') }}</th>
                                        <th>{{ trans('client/order.location_name') }}</th>
                                        <th>{{ trans('client/order.location_address') }}</th>
                                        <th>{{ trans('client/order.brand') }}</th>
                                        <th>{{ trans('client/order.model') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($trucks as $truck)
                                            @if(!empty($truck['user'])
                                             && !empty($truck['location']['address'])
                                             && !empty($truck['location']['name'])
                                             && !empty($truck['location']['postcode'])
                                             && !empty($truck['location']['city'])
                                             && !empty($truck['location']['country']))
                                            <tr>
                                                <td>
                                                    <a href="{{ route('client_order',['id'=>$truck['id']]) }}" style="color: inherit">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $truck['user']['pseudo']['name'] }}</td>
                                                <td>{{ $truck['user']['firstname'] . '  ' . $truck['user']['lastname'] }}</td>
                                                <td>{{ $truck['location']['name'] }}</td>
                                                <td>{{ $truck['location']['address'] . ' - '
                                                . $truck['location']['postcode'] . ' - '
                                                . $truck['location']['city'] . ' - '
                                                . $truck['location']['country'] }}
                                                </td>
                                                <td>{{ $truck['brand'] }}</td>
                                                <td>{{ $truck['model'] }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script type="text/javascript">
        $(document).ready(function () {
            let table = $('#allTrucks').DataTable({searchPanes: true});
            table.searchPanes.container().prependTo(table.table().container());
        });
    </script>
@endsection