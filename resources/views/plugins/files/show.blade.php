@extends('layouts.app')

@section('title', $file->name)

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>{{ $plugin->name }} <small>{{ $file->name }}</small></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Summary
                    </div>

                    <div class="panel-body">
                        @parsedown($file->summary)
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading clearfix">
                        <div class="pull-left">
                            File Information
                        </div>

                        @can('update', $file)
                            <div class="pull-right">
                                <a href="{{ route('plugins.files.edit', [$plugin->id, $file->id]) }}">Edit</a>
                            </div>
                        @endcan
                    </div>

                    <div class="panel-body">
                        <dl class="with-space">
                            <dt>Plugin</dt>
                            <dd><a href="{{ route('plugins.show', [$plugin->slug, $plugin->id]) }}">{{ $plugin->name }}</a></dd>

                            <dt>Created</dt>
                            <dd>{{ $file->created_at->diffForHumans() }}</dd>

                            <dt>Stage</dt>
                            <dd>{{ title_case($file->stage) }}</dd>

                            <dt>Game Version</dt>
                            <dd>{{ $file->game_version }}</dd>

                            <dt>File Size</dt>
                            <dd>{{ $file->getFileSize() }}</dd>

                            <dt>Downloads</dt>
                            <dd>{{ $file->downloads_count }}</dd>
                        </dl>

                        <div class="text-center">
                            <a href="{{ route('plugins.files.download', [$plugin->id, $file->id]) }}" class="btn btn-primary">
                                Download File
                            </a>
                        </div>
                    </div>

                    @can('delete', $file)
                        <div class="panel-footer">
                            <div class="text-right">
                                <form role="form" method="POST" action="{{ route('plugins.files.destroy', [$plugin->id, $file->id]) }}" onsubmit="return confirm('Delete file? This cannot be undone.')">
                                    {{ csrf_field() }}

                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-xs btn-danger">
                                        Delete File
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection
