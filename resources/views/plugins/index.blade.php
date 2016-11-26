@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <span class="pull-left">
                            Plugins
                        </span>

                        <span class="pull-right">
                            @can('create', \App\Plugin::class)
                                <a href="{{ route('plugins.create') }}">Create Plugin</a>
                            @endcan
                        </span>
                    </div>

                    <div class="panel-body">
                        @if ($plugins->count())
                            <ul class="list-group">
                                @foreach ($plugins as $plugin)
                                    <li class="list-group-item">
                                        <a href="{{ route('plugins.show', [$plugin->slug, $plugin->id]) }}">
                                            <strong>{{ $plugin->name }}</strong>
                                        </a>

                                        by {{ $plugin->user->getNameOrUsername() }}
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>There are no plugins to display.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
