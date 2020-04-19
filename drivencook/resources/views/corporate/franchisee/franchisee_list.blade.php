@extends('app')

@section('title')
    Liste des franchisés
@endsection


@section('content')

    <table class="table table-striped mt-5">
        <thead>
        <tr>
            <th scope="col">Nom</th>
            <th scope="col">Prénom</th>
            <th scope="col">Pseudo</th>
            <th scope="col">email</th>
        </tr>
        </thead>
        <tbody>
        @foreach($franchisees as $franchisee)
            <tr>
                <td><i class="fa fa-users"></i> {{$franchisee->lastname}}</td>
                <td>{{$franchisee->firstname}}</td>
                <td>{{$franchisee->pseudo}}</td>
                <td>{{$franchisee->email}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>


@endsection