<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'English Path')</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Fraunces:opsz,wght@9..144,600;9..144,700&display=swap" rel="stylesheet">
  <link href="{{ asset('css/platform.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top"><div class="container py-2">
  <a href="{{ route('home') }}" class="navbar-brand brand-mark"><i class="bi bi-book-half"></i> JUBOUNOYON <span>Learning Platform</span></a>
  <button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#mainNav"><span class="navbar-toggler-icon"></span></button>
  <div class="collapse navbar-collapse" id="mainNav"><div class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
    <a href="{{ route('home') }}" class="nav-link">হোম</a><a href="{{ route('courses.index') }}" class="nav-link">কোর্সসমূহ</a>
    @auth
      <a href="{{ route('dashboard') }}" class="nav-link">আমার প্রোগ্রেস</a>
      @if (auth()->user()->is_admin)<a href="{{ route('admin.courses.index') }}" class="nav-link">Admin</a>@endif
      <span class="nav-link text-muted small">{{ auth()->user()->name }}</span>
      <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-dark">Log out</button></form>
    @else
      <a href="{{ route('login') }}" class="nav-link">লগ ইন</a><a href="{{ route('register') }}" class="btn btn-brand btn-sm px-3">ফ্রি রেজিস্ট্রেশন</a>
    @endauth
  </div></div>
</div></nav>
<main class="container py-5">
  @if(session('status'))<div class="alert alert-success border-0 shadow-sm">{{ session('status') }}</div>@endif
  @if($errors->any())<div class="alert alert-danger border-0 shadow-sm"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
  @yield('content')
</main>
<footer class="site-footer py-4 mt-5">
  <div class="container d-flex justify-content-between small">
    <span>© {{ date('Y') }} JUBOUNOYON Learning Platform</span>
    <span>ইংরেজি শিখুন, আত্মবিশ্বাসী হোন।</span>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')
</body></html>
