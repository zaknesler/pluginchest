@extends('layouts/base')

@section('title', $plugin->name)
@section('show-header', true)

@section('content')
    <div class="w-full">
        <div class="border rounded">
            <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3">{{ $plugin->name }}</div>

            <div class="bg-white rounded-b p-4">
                By:
                <ul class="list-reset mb-4">
                    @foreach ($plugin->users as $user)
                        <li>{{ $user->username }} <span class="text-sm text-grey-dark">{{ $user->pivot->role }}</span></li>
                    @endforeach
                </ul>

                <div class="markdown">
                    @parsedown($plugin->description)
                </div>
            </div>
        </div>
    </div>
@endsection
