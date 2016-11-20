@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4>{{ $plugin->name }} <small>Files</small></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a href="{{ route('plugins.files.create', $plugin->id) }}">Create File</a>
                    </div>

                    <div class="panel-body">
                        @if ($files->count())
                            <ul class="list-group">
                                @foreach ($files as $file)
                                    <li class="list-group-item">
                                        <a href="{{ route('plugins.files.show', [$plugin->id, $file->id]) }}">
                                            <strong>{{ $file->name }}</strong>
                                        </a>

                                        <p>
                                            {{ number_format($file->downloads_count) }} {{ str_plural('download', $file->downloads_count) }}
                                        </p>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>There are no files for this plugin.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
