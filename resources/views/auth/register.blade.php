@extends('layouts.app')

@section('title', 'রেজিস্ট্রেশন')

@section('content')

<style>
    .auth-stage {
        min-height: calc(100vh - 180px);
        border-radius: 26px;
        overflow: hidden;
        box-shadow: 0 30px 70px rgba(15,82,87,0.16);
        display: flex;
        flex-wrap: wrap;
        background: #fff;
    }

    /* ============ LEFT: 3D diorama ============ */
    .diorama {
        flex: 1 1 50%;
        min-width: 320px;
        position: relative;
        background:
            radial-gradient(circle at 50% 38%, rgba(217,154,60,0.16), transparent 55%),
            linear-gradient(160deg, #0a2e30 0%, #0a3a3d 45%, #123a45 100%);
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        padding: 2.75rem;
        overflow: hidden;
    }

    .diorama .brand-line {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        font-size: 1.1rem;
        color: #f4f1e8;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        z-index: 3;
        position: relative;
    }
    .diorama .brand-line i { color: var(--gold, #d99a3c); }

    .rig-stage {
        flex: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        perspective: 1200px;
        position: relative;
        margin: 1rem 0;
    }

    .rig {
        position: relative;
        width: 300px;
        height: 240px;
        transform-style: preserve-3d;
        transform: rotateX(16deg) rotateY(24deg);
        transition: transform .25s ease-out;
    }

    .floor-glow {
        position: absolute;
        width: 340px;
        height: 90px;
        left: 50%;
        top: 210px;
        transform: translateX(-50%) translateZ(-40px) rotateX(90deg);
        background: radial-gradient(ellipse at center, rgba(217,154,60,0.35), rgba(217,154,60,0) 70%);
        filter: blur(4px);
    }

    /* ---- 3D standing man (student figure) ---- */
    .man {
        position: absolute;
        left: 50%;
        top: 18px;
        width: 110px;
        height: 190px;
        margin-left: -55px;
        transform-style: preserve-3d;
    }

    .man .shadow-base {
        position: absolute;
        width: 90px;
        height: 26px;
        left: 10px;
        bottom: -4px;
        background: radial-gradient(ellipse at center, rgba(0,0,0,0.35), transparent 70%);
        transform: translateZ(-4px) rotateX(90deg);
        filter: blur(2px);
    }

    .man .head {
        position: absolute;
        width: 40px;
        height: 40px;
        left: 35px;
        top: 0;
        border-radius: 50%;
        background: radial-gradient(circle at 35% 30%, #ffe3b0, var(--gold, #d99a3c) 75%);
        box-shadow:
            inset -6px -6px 10px rgba(0,0,0,0.25),
            inset 3px 3px 6px rgba(255,255,255,0.5),
            0 6px 10px rgba(0,0,0,0.3);
        transform: translateZ(6px);
    }

    .man .neck {
        position: absolute;
        width: 14px;
        height: 12px;
        left: 48px;
        top: 36px;
        background: linear-gradient(180deg, #e3ae5a, var(--gold, #d99a3c));
        transform: translateZ(5px);
    }

    .man .torso {
        position: absolute;
        width: 62px;
        height: 74px;
        left: 24px;
        top: 46px;
        border-radius: 20px 20px 10px 10px;
        background: linear-gradient(160deg, #14636a, #0a3a3d 70%);
        box-shadow:
            inset -8px 0 14px rgba(0,0,0,0.35),
            inset 6px 4px 10px rgba(255,255,255,0.08),
            0 14px 22px rgba(0,0,0,0.35);
        transform: translateZ(4px);
    }

    .man .torso::after {
        content: "";
        position: absolute;
        left: 50%;
        top: 4px;
        width: 3px;
        height: 66px;
        margin-left: -1.5px;
        background: linear-gradient(180deg, var(--gold, #d99a3c), rgba(217,154,60,0.2));
        opacity: 0.85;
    }

    .man .arm {
        position: absolute;
        width: 16px;
        height: 52px;
        top: 50px;
        border-radius: 10px;
        background: linear-gradient(160deg, #0f5257, #0a3a3d);
        box-shadow: inset -4px 0 8px rgba(0,0,0,0.3), 0 6px 10px rgba(0,0,0,0.25);
        transform-origin: top center;
    }
    .man .arm.left { left: 12px; transform: translateZ(2px) rotateZ(9deg); }
    .man .arm.right { left: 82px; transform: translateZ(2px) rotateZ(-9deg); }

    .man .leg {
        position: absolute;
        width: 20px;
        height: 62px;
        top: 116px;
        border-radius: 6px;
        background: linear-gradient(160deg, #16233a, #0a1620);
        box-shadow: inset -4px 0 8px rgba(0,0,0,0.4), 0 8px 12px rgba(0,0,0,0.3);
    }
    .man .leg.left { left: 30px; transform: translateZ(3px); }
    .man .leg.right { left: 58px; transform: translateZ(1px); }

    .man .shoe {
        position: absolute;
        width: 24px;
        height: 10px;
        top: 176px;
        border-radius: 6px 10px 6px 6px;
        background: linear-gradient(160deg, var(--gold, #d99a3c), #b97a24);
        box-shadow: 0 4px 8px rgba(0,0,0,0.35);
    }
    .man .shoe.left { left: 27px; transform: translateZ(4px); }
    .man .shoe.right { left: 55px; transform: translateZ(2px); }

    .man {
        animation: manSway 4.5s ease-in-out infinite;
    }

    @keyframes manSway {
        0%, 100% { transform: translateY(0) rotateZ(0deg); }
        50% { transform: translateY(-6px) rotateZ(1deg); }
    }

    /* ---- floating letter/confetti cubes ---- */

    .flit {
        position: absolute;
        width: 34px;
        height: 34px;
        transform-style: preserve-3d;
        animation: bob 4.5s ease-in-out infinite;
    }
    .flit .f {
        position: absolute;
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Fraunces', serif;
        font-weight: 700;
        font-size: 0.95rem;
        color: #f4f1e8;
        background: linear-gradient(135deg, rgba(217,154,60,0.9), rgba(15,82,87,0.9));
        border: 1px solid rgba(244,241,232,0.25);
        border-radius: 6px;
    }
    .flit .f1 { transform: translateZ(17px); }
    .flit .f2 { transform: rotateY(180deg) translateZ(17px); }
    .flit .f3 { transform: rotateY(90deg) translateZ(17px); }
    .flit .f4 { transform: rotateY(-90deg) translateZ(17px); }

    .flit.a { top: 4px; left: 4px; animation-delay: 0s; }
    .flit.b { top: 24px; right: -2px; animation-delay: 1.1s; }
    .flit.c { bottom: 44px; left: -10px; animation-delay: 2.1s; }

    @keyframes bob {
        0%, 100% { transform: translateY(0) rotateY(0deg); }
        50% { transform: translateY(-14px) rotateY(180deg); }
    }

    .diorama .caption {
        z-index: 3;
        position: relative;
        color: #f4f1e8;
    }
    .diorama .caption h3 {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        margin-bottom: 0.4rem;
    }
    .diorama .caption p {
        color: rgba(244,241,232,0.65);
        font-size: 0.9rem;
        margin: 0;
    }

    @media (max-width: 767px) {
        .diorama { display: none; }
    }

    /* ============ RIGHT: elevated form panel ============ */
    .form-panel {
        flex: 1 1 50%;
        min-width: 320px;
        background: var(--paper, #f6f4ef);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 3rem 2.5rem;
    }

    .form-card {
        width: 100%;
        max-width: 520px;
        background: #fff;
        border-radius: 20px;
        padding: 3rem 3.25rem;
        box-shadow:
            0 2px 4px rgba(22,35,58,0.04),
            0 18px 40px rgba(22,35,58,0.1);
        position: relative;
    }

    .form-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 3.25rem;
        right: 3.25rem;
        height: 5px;
        border-radius: 0 0 6px 6px;
        background: linear-gradient(
            90deg,
            var(--gold, #d99a3c) 0%,
            var(--teal, #0f5257) 25%,
            var(--gold, #d99a3c) 50%,
            var(--teal, #0f5257) 75%,
            var(--gold, #d99a3c) 100%
        );
        background-size: 220% 100%;
        box-shadow:
            0 3px 6px rgba(15,82,87,0.35),
            inset 0 1px 0 rgba(255,255,255,0.4),
            inset 0 -1px 2px rgba(0,0,0,0.25);
        animation: flowLine 3.2s linear infinite;
    }

    @keyframes flowLine {
        0%   { background-position: 0% 50%; }
        100% { background-position: -220% 50%; }
    }

    .form-card .eyebrow {
        font-family: 'DM Sans', sans-serif;
        font-size: 0.75rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gold, #b97a24);
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .form-card h2 {
        font-family: 'Fraunces', serif;
        font-weight: 600;
        color: var(--ink, #16233a);
        margin-bottom: 0.25rem;
    }

    .form-card p.subtitle {
        color: var(--muted, #6b6f76);
        font-size: 0.96rem;
        margin-bottom: 2.2rem;
    }

    .form-card .form-label {
        font-size: 0.82rem;
        font-weight: 600;
        color: var(--ink, #16233a);
        margin-bottom: 0.5rem;
    }

    /* ============ 3D TEXTBOX (stacked, raised depth) ============ */
    .field-3d {
        margin-bottom: 1.25rem;
    }

    .input-group.input-3d {
        border-radius: 14px;
        background: linear-gradient(145deg, #ffffff, var(--paper, #f6f4ef));
        box-shadow:
            6px 6px 14px rgba(22,35,58,0.08),
            -4px -4px 10px rgba(255,255,255,0.9),
            inset 0 1px 0 rgba(255,255,255,0.6);
        transition: box-shadow .18s ease, transform .18s ease;
        overflow: hidden;
    }

    .input-group.input-3d:hover {
        box-shadow:
            7px 7px 16px rgba(22,35,58,0.1),
            -4px -4px 10px rgba(255,255,255,0.9);
    }

    .input-group.input-3d .input-group-text {
        background: transparent;
        border: none;
        color: var(--teal, #0f5257);
        font-size: 1.02rem;
        padding-left: 1rem;
        padding-right: 0.6rem;
    }

    .input-group.input-3d .form-control {
        border: none;
        background: transparent;
        padding: 0.8rem 0.75rem 0.8rem 0.25rem;
        box-shadow: none;
        font-size: 0.96rem;
    }

    .input-group.input-3d .form-control:focus {
        background: transparent;
        box-shadow: none;
    }

    /* the glowing focus ring lives on the wrapper, not the input */
    .input-group.input-3d.is-focused {
        box-shadow:
            inset 3px 3px 8px rgba(22,35,58,0.08),
            inset -2px -2px 6px rgba(255,255,255,0.7),
            0 0 0 3px rgba(15,82,87,0.14);
        transform: translateY(-1px);
    }

    .input-group.input-3d .toggle-eye {
        border: none;
        background: transparent;
        color: var(--muted, #6b6f76);
        padding-right: 1rem;
    }

    .btn-3d {
        background: linear-gradient(135deg, var(--ink, #16233a), #0a3a3d);
        border: none;
        color: #f4f1e8;
        font-weight: 700;
        border-radius: 12px;
        padding: 0.75rem 0;
        box-shadow: 0 10px 22px rgba(22,35,58,0.28), inset 0 1px 0 rgba(255,255,255,0.08);
        transition: transform .12s ease, box-shadow .12s ease;
    }
    .btn-3d:hover {
        color: #f4f1e8;
        transform: translateY(-2px);
        box-shadow: 0 14px 26px rgba(22,35,58,0.34), inset 0 1px 0 rgba(255,255,255,0.1);
    }
    .btn-3d:active {
        transform: translateY(1px);
        box-shadow: 0 6px 12px rgba(22,35,58,0.24);
    }

    .form-divider { border-top: 1px dashed var(--line, #e4e0d6); }

    .form-link {
        color: var(--teal, #0f5257);
        font-weight: 600;
        text-decoration: none;
    }
    .form-link:hover { text-decoration: underline; }
</style>

<div class="container py-5">
    <div class="auth-stage">

        {{-- Diorama --}}
        <div class="diorama" id="diorama">

            <div class="brand-line"><i class="bi bi-book-half"></i> JUBOUNOYON</div>

            <div class="rig-stage">
                <div class="rig" id="rig">

                    <div class="floor-glow"></div>

                    <div class="man">
                        <div class="shadow-base"></div>
                        <div class="head"></div>
                        <div class="neck"></div>
                        <div class="torso"></div>
                        <div class="arm left"></div>
                        <div class="arm right"></div>
                        <div class="leg left"></div>
                        <div class="leg right"></div>
                        <div class="shoe left"></div>
                        <div class="shoe right"></div>
                    </div>

                    <div class="flit a">
                        <div class="f f1">A</div><div class="f f2">A</div>
                        <div class="f f3">A</div><div class="f f4">A</div>
                    </div>
                    <div class="flit b">
                        <div class="f f1">B</div><div class="f f2">B</div>
                        <div class="f f3">B</div><div class="f f4">B</div>
                    </div>
                    <div class="flit c">
                        <div class="f f1">C</div><div class="f f2">C</div>
                        <div class="f f3">C</div><div class="f f4">C</div>
                    </div>

                </div>
            </div>

            <div class="caption">
                <h3>Start Your Journey Today</h3>
                <p>নতুন অ্যাকাউন্ট তৈরি করুন এবং আজই ইংরেজি শেখা শুরু করুন।</p>
            </div>

        </div>

        {{-- Form --}}
        <div class="form-panel">
            <div class="form-card">

                <div class="eyebrow">Get started</div>
                <h2>Create Account</h2>
                <p class="subtitle">আপনার নতুন অ্যাকাউন্ট তৈরি করুন</p>

                @if ($errors->any())
                    <div class="alert alert-danger border-0">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.submit') }}">

                    @csrf

                    <div class="field-3d">
                        <label class="form-label">Full Name</label>
                        <div class="input-group input-3d">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" class="form-control" name="name"
                                   value="{{ old('name') }}" placeholder="Full name" required>
                        </div>
                    </div>

                    <div class="field-3d">
                        <label class="form-label">Phone Number</label>
                        <div class="input-group input-3d">
                            <span class="input-group-text"><i class="bi bi-telephone-fill"></i></span>
                            <input type="text" class="form-control" name="phone"
                                   value="{{ old('phone') }}" placeholder="01XXXXXXXXX" required>
                        </div>
                    </div>

                    <div class="field-3d">
                        <label class="form-label">Email Address</label>
                        <div class="input-group input-3d">
                            <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                            <input type="email" class="form-control" name="email"
                                   value="{{ old('email') }}" placeholder="example@gmail.com" required>
                        </div>
                    </div>

                    <div class="field-3d">
                        <label class="form-label">Password</label>
                        <div class="input-group input-3d">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="password"
                                   name="password" placeholder="********" required>
                            <button type="button" class="btn toggle-eye" onclick="togglePassword('password','eye1')">
                                <i class="bi bi-eye" id="eye1"></i>
                            </button>
                        </div>
                    </div>

                    <div class="field-3d mb-1">
                        <label class="form-label">Confirm Password</label>
                        <div class="input-group input-3d">
                            <span class="input-group-text"><i class="bi bi-shield-lock-fill"></i></span>
                            <input type="password" class="form-control" id="confirm_password"
                                   name="password_confirmation" placeholder="********" required>
                            <button type="button" class="btn toggle-eye" onclick="togglePassword('confirm_password','eye2')">
                                <i class="bi bi-eye" id="eye2"></i>
                            </button>
                        </div>
                    </div>

                    <button class="btn btn-3d w-100 mt-3">
                        <i class="bi bi-person-plus-fill"></i> Create Account
                    </button>

                </form>

                <hr class="form-divider my-4">

                <p class="text-center mb-0 small">
                    Already have an account?
                    <a href="{{ route('login') }}" class="form-link">Login Here</a>
                </p>

            </div>
        </div>

    </div>
</div>

<script>
function togglePassword(inputId, iconId){
    let input = document.getElementById(inputId);
    let icon = document.getElementById(iconId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.remove("bi-eye"); icon.classList.add("bi-eye-slash");
    } else {
        input.type = "password";
        icon.classList.remove("bi-eye-slash"); icon.classList.add("bi-eye");
    }
}

// focus glow ring on 3d input wrapper
document.querySelectorAll('.input-3d .form-control').forEach(function (inp) {
    inp.addEventListener('focus', function () {
        this.closest('.input-3d').classList.add('is-focused');
    });
    inp.addEventListener('blur', function () {
        this.closest('.input-3d').classList.remove('is-focused');
    });
});

(function () {
    const stage = document.getElementById('diorama');
    const rig = document.getElementById('rig');
    if (!stage || !rig || window.matchMedia('(pointer: coarse)').matches) return;

    stage.addEventListener('mousemove', function (e) {
        const rect = stage.getBoundingClientRect();
        const x = (e.clientX - rect.left) / rect.width - 0.5;
        const y = (e.clientY - rect.top) / rect.height - 0.5;
        rig.style.transform = `rotateX(${16 - y * 14}deg) rotateY(${24 + x * 20}deg)`;
    });

    stage.addEventListener('mouseleave', function () {
        rig.style.transform = 'rotateX(16deg) rotateY(24deg)';
    });
})();
</script>

@endsection