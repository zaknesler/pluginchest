@extends('layouts.app')

@section('title', 'Edit File')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Edit File
                    </div>

                    <div class="panel-body">
                        <form role="form" class="form" method="POST" action="{{ route('plugins.files.update', [$plugin->id, $file->id]) }}" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <div class="form-group{{ $errors->first('name', 'has-error') }}">
                                <label for="name" class="control-label">Name</label>

                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') ?? $file->name }}" required autofocus />

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->first('summary', 'has-error') }}">
                                <label for="summary" class="control-label">Summary</label>

                                <textarea name="summary" id="summary" rows="10" class="form-control" required>{{ old('summary') ?? $file->summary }}</textarea>

                                @if ($errors->has('summary'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('summary') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->first('stage', 'has-error') }}">
                                <label for="stage" class="control-label">Stage</label>

                                <select id="stage" class="form-control" name="stage">
                                    @foreach (config('pluginchest.file_stages') as $stage)
                                        <option value="{{ $stage }}"{{ (old('stage') == $stage || $file->stage == $stage) ? ' selected' : '' }}>
                                            {{ title_case($stage) }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('stage'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('stage') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->first('game_version', 'has-error') }}">
                                <label for="game_version" class="control-label">Game Version</label>

                                <select id="game_version" class="form-control" name="game_version">
                                    @foreach (config('pluginchest.game_versions') as $version)
                                        <option value="{{ $version }}" {{ (old('game_version') == $version || $file->game_version == $version) ? ' selected' : '' }}>
                                            {{ $version }}
                                        </option>
                                    @endforeach
                                </select>

                                @if ($errors->has('game_version'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('game_version') }}</strong>
                                    </span>
                                @endif
                            </div>

                            {{-- <div class="form-group{{ $errors->first('file', 'has-error') }}">
                                <label for="file" class="control-label">Plugin File (must be .jar)</label>

                                <input id="file" type="file" class="form-control" name="file" required />

                                @if ($errors->has('file'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                            </div> --}}

                            <div class="form-group">
                                <button class="btn btn-primary">
                                    Update File
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
