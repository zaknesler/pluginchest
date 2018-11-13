@extends('layouts/base')

@section('title', 'Create Plugin')
@section('show-header', true)

@section('content')
    <div class="w-full">
        <div class="border rounded">
            <div class="border-b bg-grey-lightest rounded-t text-grey-darker font-semibold px-4 py-3">Create Plugin</div>

            <div class="bg-white rounded-b p-4">
                <form action="{{ route('plugins.store') }}" method="post">
                    @csrf

                    <div class="max-w-sm">
                        <div class="block mb-4">
                            <div class="relative">
                                <input autofocus required type="text" name="name" placeholder="Name" value="{{ old('name') }}" class="block appearance-none outline-none w-full h-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded{{ $errors->first('name', ' border-red') }}" />
                            </div>

                            @if ($errors->has('name'))
                                <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="block mb-4">
                            <div class="relative">
                                <textarea required placeholder="Description" class="block font-sans font-normal text-base appearance-none outline-none w-full h-full border focus:border-blue bg-grey-lightest text-grey-darker p-3 rounded{{ $errors->first('name', ' border-red') }}" name="description" rows="10">{{ old('description') }}</textarea>
                            </div>

                            @if ($errors->has('description'))
                                <div class="mt-2 text-sm font-semibold text-red-light">{{ $errors->first('description') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="block">
                        <input class="appearance-none w-auto border-0 bg-blue hover:bg-blue-dark text-white rounded cursor-pointer py-3 px-6" type="submit" value="Create" />
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
