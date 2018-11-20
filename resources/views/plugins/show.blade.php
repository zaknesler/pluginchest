@extends('layouts/base')

@section('title', $plugin->name)
@section('show-header', true)

@section('content')
    <div class="w-full">
        <div class="border rounded">
            <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3 flex items-center justify-between">
                <div>{{ $plugin->name }}</div>

                @can('update', $plugin)
                    <div>
                        <a class="text-blue-dark no-underline hover:underline text-sm font-normal" href="{{ route('plugins.edit', [$plugin->slug, $plugin->id]) }}">Edit</a>
                    </div>
                @endcan
            </div>

            <div class="bg-white rounded-b p-4">
                <ul class="list-reset mb-4">
                    @foreach ($plugin->users as $user)
                        <li><span class="font-semibold">{{ $user->username }}</span> <span class="text-xs text-grey-dark">({{ $user->pivot->role }})</span></li>
                    @endforeach
                </ul>

                <div class="markdown">
                    @parsedown($plugin->description)
                </div>
            </div>
        </div>
    </div>
@endsection
