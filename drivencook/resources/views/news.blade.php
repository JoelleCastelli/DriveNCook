@extends('app')

@section('content')
    <div class="col-6 mx-auto text-light">
        <div class="d-flex justify-content-center row">
            @foreach($news_list as $news)
                <div class="card bg-dark w-100 mt-5 mb-5 col-12">
                    <div class="card-header">
                        <h3>{{$news['title']}}</h3>
                    </div>
                    <div class="card-body">
                        drhioegohoehrgoenrhioryàhe
                    </div>
                    @if (!empty($news['location']))
                        <div class="card-footer">
                            <iframe
                                    width="100%"
                                    height="450"
                                    frameborder="0" style="border:0"
{{--                                    src="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAPS_API_KEY')}}&q={{$news['location']['address'].' '.$news['location']['city'].' '.$news['location']['postcode']}}"--}}
                                    src="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAPS_API_KEY')}}&q=Space+Needle,Seattle+WA"
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection