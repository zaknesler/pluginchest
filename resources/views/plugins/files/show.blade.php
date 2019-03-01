@extends('layouts/base')

@section('title', $pluginFile->name)
@section('show-header', true)

@section('content-wide')
    <div class="max-w-md mx-auto p-4">
        <div class="mb-4 flex items-baseline justify-between">
            <a class="inline-block text-blue-dark hover:text-blue-darkest no-underline" href="{{ $pluginFile->plugin->getUrl() }}">&larr; View Plugin</a>

            <div class="flex items-baseline">
                <div class="mr-4 text-sm">
                    {{ $pluginFile->downloads_count . ' ' . str_plural('download', $pluginFile->downloads_count) }}
                </div>

                <a class="px-4 py-2 rounded inline-block bg-blue hover:bg-blue-dark text-white font-semibold text-sm no-underline" href="{{ $pluginFile->getDownloadUrl() }}">Download</a>
            </div>
        </div>

        <div class="border rounded">
            <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3 flex items-center justify-between">
                <div>{{ $pluginFile->name }}</div>

                @can('update', $pluginFile)
                    <div>
                        <a class="text-blue-dark no-underline hover:underline text-sm font-normal" href="{{ route('plugins.files.edit', [$pluginFile->plugin->slug, $pluginFile->plugin->id, $pluginFile->id]) }}">Edit</a>
                    </div>
                @endcan
            </div>

            <div class="bg-white rounded-b p-4">
                <div class="markdown">
                    @parsedown($pluginFile->description)
                </div>
            </div>
        </div>
    </div>
@endsection
