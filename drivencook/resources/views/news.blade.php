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
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item bg-dark">
                                <b>{{trans('event.start')}} : </b>
                                {{DateTime::createFromFormat('Y-m-d',$news['date_start'])->format('d/m/Y')}}
                            </li>
                            <li class="list-group-item bg-dark">
                                <b>{{trans('event.end')}} : </b>
                                {{DateTime::createFromFormat('Y-m-d',$news['date_end'])->format('d/m/Y')}}
                            </li>
                            @if (!empty($news['location']))
                                <li class="list-group-item bg-dark"><b>{{trans('event.location')}}
                                        : {{$news['location']['name']}}</b>
                                    - {{$news['location']['address'].' - '.$news['location']['city'].' ('.$news['location']['postcode'].')'}}
                                </li>
                            @endif
                            <li class="list-group-item text-justify bg-dark"><b>{{trans('event.description')}}
                                    : </b><br>
                                {{$news['description']}}
                            </li>
                        </ul>
                    </div>
                    @if (!empty($news['location']))
                        <div class="card-footer">
                            <iframe
                                    width="100%"
                                    height="450"
                                    frameborder="0" style="border:0"
                                    src="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAPS_API_KEY')}}&q={{$news['location']['address'].' '.$news['location']['city'].' '.$news['location']['postcode']}}"
                                    {{--                                    src="https://www.google.com/maps/embed/v1/place?key={{env('GOOGLE_MAPS_API_KEY')}}&q=Space+Needle,Seattle+WA"--}}
                                    allowfullscreen>
                            </iframe>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection