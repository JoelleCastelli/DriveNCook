@extends('app')

@section('title')
    Liste des franchisés
@endsection


@section('content')
    <div class="content">

        @foreach($franchisees as $franchisee)
            <p>{{ $franchisee->lastname }} - {{ $franchisee->firstname }}</p>
        @endforeach

    </div>

@endsection