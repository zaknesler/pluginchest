@extends('layouts/base')

@section('title', 'Edit Plugin')
@section('show-header', true)

@section('content')
    <div class="w-full">
        <div class="border rounded">
            <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3">Edit Plugin</div>

            <div class="bg-white rounded-b p-6">
                <form action="{{ route('plugins.update', [$plugin->slug, $plugin->id]) }}" method="post">
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
                                    placeholder="Name"
                                    value="{{ old('name') ?? $plugin->name }}"
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
                                >{{ old('description') ?? $plugin->description }}</textarea>
                            </div>

                            @if ($errors->has('description'))
                                <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('description') }}</div>
                            @endif
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
