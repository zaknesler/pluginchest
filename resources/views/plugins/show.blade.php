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
                <div class="w-full">
                    <div class="border rounded">
                        <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3">Users</div>

                        <div class="bg-white rounded-b p-4">
                            <ul class="list-reset">
                                @foreach ($plugin->users as $user)
                                    <li><span class="font-semibold">{{ $user->username }}</span> <span class="text-xs text-grey-dark">({{ $user->pivot->role }})</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="w-full mt-8">
                    <div class="border rounded">
                        <div class="flex items-baseline justify-between border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3">
                            <span>Files</span>

                            @can ('createPluginFile', $plugin)
                                <a
                                    class="text-xs font-semibold text-grey-darker hover:text-grey-darkest bg-white border hover:border-grey rounded px-3 py-1 no-underline"
                                    href="{{ route('plugins.files.create', ['slug' => $plugin->slug, 'id' => $plugin->id]) }}"
                                >
                                    Add File
                                </a>
                            @endcan
                        </div>

                        <div class="bg-white rounded-b p-4">
                            <ul class="list-reset">
                                @if ($plugin->files->count())
                                    @foreach ($plugin->files as $file)
                                        <li>
                                            <span class="font-semibold">{{ $file->name }}</span>
                                            <span class="text-xs text-grey-dark">
                                                <a class="no-underline text-blue-dark hover:text-blue-darkest" href="{{ $file->getDownloadLink() }}">Download</a>
                                            </span>
                                        </li>
                                    @endforeach
                                @else
                                    <li class="text-sm">No files to display.</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
