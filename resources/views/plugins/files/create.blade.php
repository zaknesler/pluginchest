@extends('layouts/base')

@section('title', 'Create File')
@section('show-header', true)

@section('content')
    <div class="w-full">
        <div class="border rounded">
            <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3">Create File</div>

            <div class="bg-white rounded-b p-6">
                <form action="{{ route('plugins.files.store', ['slug' => $plugin->slug, 'id' => $plugin->id]) }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="max-w-md mx-auto">
                        <div class="block mb-6">
                            <div class="w-full">
                                <label class="inline-block mb-2 font-semibold text-grey-darker" for="name">Name</label>

                                <input
                                    autofocus
                                    required
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="Release 1.0.0"
                                    value="{{ old('name') }}"
                                    class="block appearance-none outline-none w-full h-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded{{ $errors->first('name', ' border-red') }}"
                                >
                            </div>

                            @if ($errors->has('name'))
                                <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="block mb-6">
                            <div class="w-full">
                                <label class="inline-block mb-2 font-semibold text-grey-darker" for="description">Description</label>

                                <textarea
                                    required
                                    rows="15"
                                    type="text"
                                    id="description"
                                    name="description"
                                    placeholder="Description"
                                    class="block font-sans font-normal leading-normal tracking-normal appearance-none outline-none w-full h-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded{{ $errors->first('description', ' border-red') }}"
                                >{{ old('description') }}</textarea>
                            </div>

                            @if ($errors->has('description'))
                                <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('description') }}</div>
                            @endif
                        </div>

                        <div class="mb-6 block flex justify-between -mx-3">
                            <div class="w-1/2 mx-3">
                                <label class="inline-block mb-2 font-semibold text-grey-darker" for="stage">Stage</label>

                                <select class="block appearance-none outline-none w-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded" name="stage" id="stage">
                                    @foreach (config('pluginchest.file_stages') as $stage)
                                        <option value="{{ $stage }}">{{ title_case($stage) }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('stage'))
                                    <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('stage') }}</div>
                                @endif
                            </div>

                            <div class="w-1/2 mx-3">
                                <label class="inline-block mb-2 font-semibold text-grey-darker" for="game_version">Game Version</label>

                                <select class="block appearance-none outline-none w-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded" name="game_version" id="stage">
                                    @foreach (config('pluginchest.game_versions') as $version)
                                        <option value="{{ $version }}">{{ $version }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('game_version'))
                                    <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('game_version') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="block mb-6">
                            <label class="inline-block mb-2 font-semibold text-grey-darker" for="plugin_file">File</label>

                            <input
                                required
                                type="file"
                                id="plugin_file"
                                name="plugin_file"
                                placeholder="Release 1.0.0"
                                value="{{ old('plugin_file') }}"
                                class="block appearance-none outline-none w-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded{{ $errors->first('plugin_file', ' border-red') }}"
                            >

                            @if ($errors->has('plugin_file'))
                                <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('plugin_file') }}</div>
                            @endif
                        </div>

                        <div class="block">
                            <input class="appearance-none w-auto border-0 bg-blue hover:bg-blue-dark text-white rounded cursor-pointer py-3 px-6" type="submit" value="Create" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
