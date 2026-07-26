@extends('layouts.app')

@section('title', 'লগ ইন')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-5 col-md-7">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- Header -->
                <div class="text-center py-4 text-white"
                     style="background:linear-gradient(135deg,#0f766e,#14b8a6);">

                    <i class="bi bi-person-circle display-3"></i>

                    <h2 class="fw-bold mt-2 mb-1">
                        Welcome Back
                    </h2>

                    <p class="mb-0">
                        আপনার অ্যাকাউন্টে লগ ইন করুন
                    </p>

                </div>

                <!-- Body -->
                <div class="card-body p-4 p-lg-5">

                    @if ($errors->any())
                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>
                    @endif

                    <form method="POST"
                          action="{{ route('login.submit') }}">

                        @csrf

                        <!-- Phone -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Phone Number
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-telephone-fill"></i>
                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    value="{{ old('phone') }}"
                                    placeholder="01XXXXXXXXX"
                                    required>

                            </div>

                        </div>

                        <!-- Password -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Password
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">
                                    <i class="bi bi-lock-fill"></i>
                                </span>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="password"
                                    name="password"
                                    placeholder="********"
                                    required>

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword()">

                                    <i class="bi bi-eye" id="eyeIcon"></i>

                                </button>

                            </div>

                        </div>

                        <!-- Remember -->

                        <div class="d-flex justify-content-between align-items-center mb-4">

                            <div class="form-check">

                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="remember"
                                    id="remember">

                                <label
                                    class="form-check-label"
                                    for="remember">

                                    Remember Me

                                </label>

                            </div>

                            <a href="#"
                               class="text-decoration-none text-success">

                                Forgot Password?

                            </a>

                        </div>

                        <!-- Button -->

                        <button
                            class="btn btn-success w-100 py-2 fw-bold rounded-3">

                            <i class="bi bi-box-arrow-in-right"></i>

                            Login

                        </button>

                    </form>

                    <hr class="my-4">

                    <p class="text-center mb-0">

                        Don't have an account?

                        <a href="{{ route('register') }}"
                           class="fw-bold text-success text-decoration-none">

                            Register Now

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function togglePassword(){

    let password=document.getElementById("password");

    let icon=document.getElementById("eyeIcon");

    if(password.type==="password"){

        password.type="text";

        icon.classList.remove("bi-eye");

        icon.classList.add("bi-eye-slash");

    }else{

        password.type="password";

        icon.classList.remove("bi-eye-slash");

        icon.classList.add("bi-eye");

    }

}

</script>

@endsection