@extends('layouts.app')

@section('title', 'Create Plugin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Create Plugin
                    </div>

                    <div class="panel-body">
                        <form role="form" class="form" method="POST" action="{{ route('plugins.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->first('name', 'has-error') }}">
                                <label for="name" class="control-label">Name</label>

                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus />

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group{{ $errors->first('description', 'has-error') }}">
                                <label for="description" class="control-label">Description</label>

                                <textarea name="description" id="description" rows="10" class="form-control" required>{{ old('description') }}</textarea>

                                @if ($errors->has('description'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>


                            <div class="form-group">
                                <button class="btn btn-primary">
                                    Create Plugin
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
