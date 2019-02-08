@extends('layouts.app')

@section('action', 'Sign In')
@section('message', 'Enter your email address and password to access admin panel.')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        {{ csrf_field() }}

        <div class="form-group {{--{{ $errors->has('email') ? 'has-error' : '' }}--}}">
            <label for="email" class="control-label">Email address</label>
            <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="example@email.com">

            {{--@if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif--}}
        </div>

        <div class="form-group {{--{{ $errors->has('password') ? 'has-error' : '' }}--}}">
            <label for="password" class="control-label">Password</label>

            <input id="password" type="password" class="form-control" name="password" required placeholder="******">

           {{-- @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif--}}
        </div>

        <div class="form-group mb-3">
            <div class="custom-control custom-checkbox">
                <input type="checkbox"  name="remember" class="custom-control-input" id="checkbox-signin" {{ old('remember') ? 'checked' : '' }}>
                <label class="custom-control-label" for="checkbox-signin">Remember me</label>
            </div>
        </div>

        <div class="form-group mb-0 text-center">
            <button class="btn btn-primary btn-block" type="submit"> Log In </button>
        </div>
    </form>
@endsection
