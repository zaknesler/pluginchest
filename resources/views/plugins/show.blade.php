@extends('layouts.app')

@section('title', $plugin->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>{{ $plugin->name }} <small>Overview</small></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-body">
                        {!! Markdown::convertToHtml($plugin->description) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            Plugin Information
                        </div>

                        @can('update', $plugin)
                            <div class="pull-right">
                                <a href="{{ route('plugins.edit', $plugin->id) }}">Edit</a>
                            </div>
                        @endcan
                    </div>

                    <div class="panel-body">
                        <dl class="with-space">
                            <dt>Author</dt>
                            <dd><a href="#">{{ $plugin->user->getNameOrUsername() }}</a></dd>

                            <dt>Created</dt>
                            <dd>{{ $plugin->created_at->diffForHumans() }}</dd>

                            <dt>Last Updated</dt>
                            <dd>{{ $plugin->updated_at->diffForHumans() }}</dd>

                            <dt>Downloads</dt>
                            <dd>{{ number_format($plugin->total_downloads_count) }}</dd>

                            @if ($files->count())
                                <dt>Recent Files</dt>
                                <dd>
                                    <ul class="list-group">
                                        @foreach ($files as $file)
                                            <li>
                                                <a href="{{ route('plugins.files.show', [$plugin->id, $file->id]) }}">{{ $file->name }}</a> for {{ $file->game_version }} ({{ $file->created_at->diffForHumans() }})
                                            </li>
                                        @endforeach
                                    </ul>
                                </dd>
                            @endif
                        </dl>

                        <div class="text-center">
                            @if ($files->count())
                                <a href="{{ route('plugins.files.download', [$plugin->id, $files->first()->id]) }}" class="btn btn-primary">
                                    Download Latest File
                                </a>
                            @endif

                            @can('createPluginFile', $plugin)
                                <a href="{{ route('plugins.files.create', $plugin->id) }}" class="btn btn-link">
                                    Create File
                                </a>
                            @endcan
                        </div>
                    </div>

                    <div class="panel-footer clearfix">
                        <div class="pull-left">
                            <a href="{{ route('plugins.files.index', $plugin->id) }}">
                                View All Files
                            </a>
                        </div>

                        @can('delete', $plugin)
                            <div class="pull-right">
                                <form role="form" method="POST" action="{{ route('plugins.destroy', $plugin->id) }}" onsubmit="return confirm('Delete plugin? This will also delete all of its files and cannot be undone.')">
                                    {{ csrf_field() }}

                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-xs btn-danger">
                                        Delete Plugin
                                    </button>
                                </form>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
