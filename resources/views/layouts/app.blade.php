<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <title>@yield('title', 'Home') &middot; {{ config('app.name') }}</title>

        <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
        <script defer src="{{ mix('/js/app.js') }}"></script>

        @yield('head')
    </head>
    <body class="relative leading-normal font-sans font-normal min-w-full min-h-full text-grey-darker bg-grey-lighter">
        <div id="root">
            @include('flash::message')

            @include('layouts.partials.header')

            @yield('content')
        </div>
    </body>
</html>
