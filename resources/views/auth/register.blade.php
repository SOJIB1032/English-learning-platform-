@extends('layouts.app')

@section('title', 'রেজিস্ট্রেশন')

@section('content')

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-6 col-md-8">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- Header -->
                <div class="text-center text-white py-4"
                     style="background: linear-gradient(135deg,#0f766e,#14b8a6);">

                    <i class="bi bi-person-plus-fill display-3"></i>

                    <h2 class="fw-bold mt-2">
                        Create Account
                    </h2>

                    <p class="mb-0">
                        আপনার নতুন অ্যাকাউন্ট তৈরি করুন
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
                          action="{{ route('register.submit') }}">

                        @csrf

                        <!-- Name -->

                        <div class="mb-3">

                            <label class="form-label fw-semibold">
                                Full Name
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-person-fill"></i>

                                </span>

                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{ old('name') }}"
                                    placeholder="Enter your full name"
                                    required>

                            </div>

                        </div>

                        <!-- Phone -->

                        <div class="mb-3">

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

                        <div class="mb-3">

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
                                    onclick="togglePassword('password','eye1')">

                                    <i class="bi bi-eye" id="eye1"></i>

                                </button>

                            </div>

                        </div>

                        <!-- Confirm Password -->

                        <div class="mb-4">

                            <label class="form-label fw-semibold">
                                Confirm Password
                            </label>

                            <div class="input-group">

                                <span class="input-group-text">

                                    <i class="bi bi-shield-lock-fill"></i>

                                </span>

                                <input
                                    type="password"
                                    class="form-control"
                                    id="confirm_password"
                                    name="password_confirmation"
                                    placeholder="********"
                                    required>

                                <button
                                    type="button"
                                    class="btn btn-outline-secondary"
                                    onclick="togglePassword('confirm_password','eye2')">

                                    <i class="bi bi-eye" id="eye2"></i>

                                </button>

                            </div>

                        </div>

                        <button
                            class="btn btn-success w-100 py-2 fw-bold rounded-3">

                            <i class="bi bi-person-plus-fill"></i>

                            Create Account

                        </button>

                    </form>

                    <hr class="my-4">

                    <p class="text-center mb-0">

                        Already have an account?

                        <a href="{{ route('login') }}"
                           class="fw-bold text-success text-decoration-none">

                            Login Here

                        </a>

                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

function togglePassword(inputId, iconId){

    let input=document.getElementById(inputId);

    let icon=document.getElementById(iconId);

    if(input.type==="password"){

        input.type="text";

        icon.classList.remove("bi-eye");

        icon.classList.add("bi-eye-slash");

    }else{

        input.type="password";

        icon.classList.remove("bi-eye-slash");

        icon.classList.add("bi-eye");

    }

}

</script>

@endsection