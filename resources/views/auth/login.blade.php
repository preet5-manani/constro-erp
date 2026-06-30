@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
    <div class="text-center mb-4">
        <div class="auth-brand">REMS</div>
        <p class="text-muted mb-0">Real Estate Management System</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="form-group">
            <label for="email" class="placeholder">Email</label>
            <input id="email" type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                   value="{{ old('email') }}" required autofocus placeholder="you@example.com">
        </div>

        <div class="form-group">
            <label for="password" class="placeholder">Password</label>
            <input id="password" type="password" name="password" class="form-control"
                   required placeholder="••••••••">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="remember" id="remember">
            <label class="form-check-label" for="remember">Remember me</label>
        </div>

        <button type="submit" class="btn btn-primary w-100">Sign In</button>
    </form>
@endsection
