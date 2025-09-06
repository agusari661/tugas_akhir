@extends('layouts.app')

@section('content')
<style>
    body {
        background-color: #37474F;
    }

    .login-wrapper {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        padding-top: 40px;
    }

    .login-logo img {
        width: 320px;
        margin-bottom: 30px;
    }

    .card {
        background-color: #455A64;
        color: white;
        border-radius: 20px;
    }

    .form-control {
        background-color: #CFD8DC;
        border: none;
        color: #000;
        border-radius: 25px;
        padding: 10px 20px;
    }

    .form-control:focus {
        box-shadow: none;
    }

    .btn-primary {
        background-color: #90CAF9;
        border-color: #90CAF9;
        color: #000;
        border-radius: 25px;
        padding: 10px 0;
    }

    .footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        text-align: center;
        background-color: #263238;
        color: white;
        padding: 10px 0;
        font-size: 14px;
    }
</style>

<div class="login-wrapper">
    <!-- Logo -->
    <div class="login-logo text-center">
        <img src="{{ asset('img/logo1.png') }}" alt="Toko Aris Logo">
    </div>

    <!-- Login Card -->
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm rounded-lg">
                    <div class="card-body">
                        <h2 class="text-center mb-4 text-white">Login</h2>
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email Input -->
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Username</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password Input -->
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            {{-- <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Remember Me
                                </label>
                            </div> --}}

                            <!-- Login Button -->
                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-block">
                                    Login
                                </button>
                            </div>

                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        &copy;Copyright2025 - Toko Aris Dalung
    </div>
</div>
@endsection
