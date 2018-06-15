@extends('layouts/base')

@section('title', 'Home')

@section('show-header', true)

@section('content')
    <example-component title="Plugins">
        @foreach ($plugins as $plugin)
            <p>{{ $plugin->slug }}</p>
        @endforeach
    </example-component>
@endsection
