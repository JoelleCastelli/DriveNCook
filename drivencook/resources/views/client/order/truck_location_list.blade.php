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
                            <div id="map_view" style="width: 100%; height:600px;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_API_KEY')}}">google.maps.event.addDomListener(window, 'load', initMap);</script>
    <script type="text/javascript">
        var locations = [
                @foreach($trucks as $truck)
                @if(!empty($truck['user']))
            [
                '{{$truck['location']['address'].' '.$truck['location']['postcode'].' '.$truck['location']['city']}}',
                '{{$truck['location']['latitude']}}',
                '{{$truck['location']['longitude']}}',
                '{{route('client_order',['truck_id'=>$truck['id']])}}',
                '{{$truck['user']['pseudo']['name']}}'
            ],
            @endif
            @endforeach
        ];

        var map = new google.maps.Map(document.getElementById('map_view'), {
            zoom: 10,
            center: new google.maps.LatLng(48.856978, 2.342782),
            // mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {
            marker = new google.maps.Marker({
                position: new google.maps.LatLng(locations[i][1], locations[i][2]),
                map: map,
            });

            google.maps.event.addListener(marker, 'click', (function (marker, i) {
                return function () {
                    let content = 'Camion de ' + locations[i][4] +
                        '<br>' + locations[i][0] +
                        '<br><br><a href="' + locations[i][3] + '" target="_blank">' + 'Voir le menu' + '</a>';
                    infowindow.setContent(content);
                    infowindow.open(map, marker);
                }
            })(marker, i));

            // google.maps.event.addListener(marker, 'click', function() {
            //     window.location.href = this.url;
            // });
        }

    </script>
@endsection