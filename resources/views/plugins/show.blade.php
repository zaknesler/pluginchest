@extends('layouts/base')

@section('title', $plugin->name)
@section('show-header', true)

@section('content-wide')
    <div class="max-w-xl mx-auto">
        <div class="w-full flex flex-col md:flex-row">
            <div class="w-full md:w-2/3 mb-3 md:mb-0 md:mr-3">
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
                        <div class="markdown">
                            @parsedown($plugin->description)
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full md:w-1/3 mt-3 md:mt-0 md:ml-3">
                <example-component title="Users">
                    <ul class="list-reset">
                        @foreach ($plugin->users as $user)
                            <li><span class="font-semibold">{{ $user->username }}</span> <span class="text-xs text-grey-dark">({{ $user->pivot->role }})</span></li>
                        @endforeach
                    </ul>
                </example-component>
            </div>
        </div>
    </div>
@endsection
