@extends('layouts.app')

@section('action', 'Reset Password')
@section('message', 'Enter your email address and we\'ll send you an email with instructions to reset your password.')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email">E-Mail Address</label>

            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="email@example.com">

            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group mb-0 text-center">
            <button type="submit" class="btn btn-primary btn-block">
                Send Password Reset Link
            </button>
        </div>
    </form>
@endsection

@section('complement')
    <div class="row mt-3">
        <div class="col-12 text-center">
            <p class="text-muted">Back to <a href="{{ route('login') }}" class="text-dark ml-1"><b>Log In</b></a></p>
        </div> <!-- end col -->
    </div>
@endsection
