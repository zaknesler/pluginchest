@extends('layouts/base')

@section('title', 'Edit Plugin File')
@section('show-header', true)

@section('content')
    <div class="w-full">
        <div class="border rounded">
            <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3">Edit Plugin File</div>

            <div class="bg-white rounded-b p-6">
                <form action="{{ route('plugins.files.update', [$pluginFile->plugin->slug, $pluginFile->plugin->id, $pluginFile->id]) }}" method="post">
                    @csrf
                    @method('patch')

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
                                    value="{{ old('name') ?? $pluginFile->name }}"
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
                                >{{ old('description') ?? $pluginFile->description  }}</textarea>
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
                                        <option value="{{ $stage }}" {{ $pluginFile->stage == $stage ? 'selected' : '' }}>{{ title_case($stage) }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('stage'))
                                    <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('stage') }}</div>
                                @endif
                            </div>

                            <div class="w-1/2 mx-3">
                                <label class="inline-block mb-2 font-semibold text-grey-darker" for="game_version">Game Version</label>

                                <select class="block appearance-none outline-none w-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded" name="game_version" id="game_version">
                                    @foreach (config('pluginchest.game_versions') as $game_version)
                                        <option value="{{ $game_version }}" {{ $pluginFile->game_version == $game_version ? 'selected' : '' }}>{{ $game_version }}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('game_version'))
                                    <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('game_version') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="inline-block mb-2 font-semibold text-grey-darker" for="description">File</label>

                            <div class="p-3 text-sm bg-grey-lightest border rounded">
                                For security reasons, you are unable to upload a different file. If you wish, you can delete this file and re-upload a different one.
                            </div>
                        </div>

                        <div class="block">
                            <input class="appearance-none w-auto border-0 bg-blue hover:bg-blue-dark text-white rounded cursor-pointer py-3 px-6" type="submit" value="Update" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
