@extends('layouts.app')

@section('action', 'Free Sign Up')
@section('message', 'Don\'t have an account? Create your account, it takes less than a minute')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label for="name">Name</label>

            <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus placeholder="Type your full name">

            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">E-Mail Address</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="email@example.com">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input id="password" type="password" class="form-control" name="password" required placeholder="******">
        </div>

        <div class="form-group">
            <label for="password-confirm">Confirm Password</label>

            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="******">
        </div>

        <div class="form-group mb-0 text-center">
            <button type="submit" class="btn btn-primary btn-block">
                Register
            </button>
        </div>
    </form>
@endsection

@section('complement')
    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-muted">Already have account? <a href="{{ route('login') }}" class="text-dark ml-1"><b>Log In</b></a></p>
        </div>
    </div>
@endsection
