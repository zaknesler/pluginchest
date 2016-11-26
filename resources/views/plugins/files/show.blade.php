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
                        {!! Markdown::convertToHtml($file->summary) !!}
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        File Information
                    </div>

                    <div class="panel-body">
                        <dl class="with-space">
                            <dt>Plugin</dt>
                            <dd><a href="{{ route('plugins.show', [$plugin->slug, $plugin->id]) }}">{{ $file->plugin->name }}</a></dd>

                            <dt>Created</dt>
                            <dd>{{ $file->created_at->diffForHumans() }}</dd>

                            <dt>Stage</dt>
                            <dd>{{ title_case($file->stage) }}</dd>

                            <dt>Game Version</dt>
                            <dd>{{ $file->game_version }}</dd>

                            <dt>Downloads</dt>
                            <dd>{{ number_format($file->downloads_count) }}</dd>
                        </dl>

                        <div class="text-center">
                            <a href="{{ route('plugins.files.download', [$plugin->id, $file->id]) }}" class="btn btn-primary">
                                Download File
                            </a>
                        </div>
                    </div>
                </div>

                @can('delete', $file)
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            File Actions
                        </div>

                        <div class="panel-body">
                                <form role="form" method="POST" action="{{ route('plugins.files.destroy', [$plugin->id, $file->id]) }}">
                                    {{ csrf_field() }}

                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-block btn-danger">
                                        Delete
                                    </button>
                                </form>
                        </div>
                    </div>
                @endcan
            </div>
        </div>
    </div>
@endsection
