@extends('layouts/base')

@section('title', 'Home')
@section('show-header', true)

@section('content')
    <example-component title="Dashboard">
        <div class="-mb-3">
            @foreach($plugins as $plugin)
                <div class="mb-3">
                    <a class="text-blue-dark font-semibold no-underline hover:underline" href="{{ route('plugins.show', [$plugin->slug, $plugin->id]) }}">{{ $plugin->name }}</a>
                    <div class="text-sm text-grey-dark font-semibold">{{ $plugin->users->first()->username }}</div>
                </div>
            @endforeach
        </div>
    </example-component>
@endsection
