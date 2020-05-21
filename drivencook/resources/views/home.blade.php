@extends('app')

@section('content')
    <div class="container h-100">
        <div class="row align-items-center h-100">
            <div class="col-12 mx-auto text-light">
                <div class="d-flex justify-content-center">
                    <h1 class="display-3 font-weight-bold"> {{ trans('homepage.slogan') }}</h1>
                </div>
                <div class="d-flex justify-content-center">
                    <h2>{{ trans('homepage.tagline') }}</h2>
                </div>
                <div class="d-flex justify-content-center">
                    <i class="fab fa-facebook-square fa-3x"></i>
                    <i class="fab fa-twitter-square fa-3x ml-4"></i>
                    <i class="fab fa-instagram-square fa-3x ml-4"></i>
                </div>
            </div>
        </div>
    </div>
@endsection