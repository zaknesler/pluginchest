@extends('layouts.app')

@section('title', 'Settings')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Profile Settings
                    </div>

                    <div class="panel-body">
                        <form role="form" class="form-horizontal" method="POST" action="{{ route('settings.profile.update') }}">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <div class="form-group{{ $errors->first('name', ' has-error') }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') ?? $user->name }}" autofocus />

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('email', ' has-error') }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') ?? $user->email }}" />

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button class="btn btn-primary">
                                        Update Profile Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Password Settings
                    </div>

                    <div class="panel-body">
                        <form role="form" class="form-horizontal" method="POST" action="{{ route('settings.password.update') }}">
                            {{ csrf_field() }}

                            {{ method_field('PUT') }}

                            <div class="form-group{{ $errors->first('old_password', ' has-error') }}">
                                <label for="old_password" class="col-md-4 control-label">Old Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="old_password" id="old_password" class="form-control" />

                                    @if ($errors->has('old_password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('password', ' has-error') }}">
                                <label for="password" class="col-md-4 control-label">New Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="password" id="password" class="form-control" />

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->first('password_confirmation', ' has-error') }}">
                                <label for="password_confirmation" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" />

                                    @if ($errors->has('password_confirmation'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password_confirmation') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button class="btn btn-primary">
                                        Update Password Settings
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
