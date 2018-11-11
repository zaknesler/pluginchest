@extends('layouts/base')

@section('title', 'Home')
@section('show-header', true)

@section('content')
    <example-component title="Dashboard">
        @auth
            <p>You are signed in!</p>
        @else
            <p>You are not signed in!</p>
        @endauth
    </example-component>
@endsection
