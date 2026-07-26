@extends('layouts.app')
@section('title', 'JUBOUNOYON Learning Platform')
@section('content')
<section class="janala-hero mb-5">
    <div class="row align-items-center g-4">
        <div class="col-lg-7">
            <span class="hero-kicker">
            <i class="bi bi-patch-check-fill">

            </i> নিজের গতিতে ইংরেজি শিখুন</span>
            <h1>ইংরেজি শিখে<br><em>বদলে দিন জীবন</em></h1>
            <p>কথা বলা, শোনা, পড়া ও লেখার জন্য সহজ এবং ব্যবহারিক ইংরেজি লেসন। প্রতিদিন অল্প সময় দিন, ধাপে ধাপে আত্মবিশ্বাস বাড়ান।</p>
            <div class="d-flex gap-3 flex-wrap">
                <a href="{{ route('register') }}" class="btn btn-brand btn-lg">ফ্রি রেজিস্ট্রেশন করুন</a>
                <a href="{{ route('courses.index') }}" class="btn btn-outline-light btn-lg">কোর্সগুলো দেখুন</a>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="hero-illustration">
                <div class="illustration-circle">
                    <i class="bi bi-chat-text-fill"></i>
                </div>
                <div class="word-card top">
                    Hello! <small>হ্যালো</small>
                </div>
                <div class="word-card bottom">
                  I can speak English <i class="bi bi-volume-up-fill"></i>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="benefit-strip mb-5">
    <div>
        <i class="bi bi-journal-check"></i>
        <strong>{{ $courses->count() ?: 3 }}টি</strong>
        <span>কোর্সসমূহ</span>
    </div>
    <div>
        <i class="bi bi-play-circle"></i>
        <strong>সহজ</strong>
        <span>ভিডিও ও অডিও লেসন</span>
    </div>
    <div>
        <i class="bi bi-award"></i>
        <strong>কুইজ</strong>
        <span>দিয়ে প্র্যাকটিস করুন</span>
    </div>
    <div>
        <i class="bi bi-graph-up-arrow"></i>
        <strong>প্রোগ্রেস</strong>
        <span>নিজেই দেখুন</span>
    </div>
</section>
<section class="mb-5">
    <div class="section-heading text-center">
        <span>ইংরেজি কোর্সসমূহ</span>
        <h2>আপনার জন্য সঠিক কোর্সটি বেছে নিন</h2>
        <p>প্রতিটি কোর্সে রয়েছে chapter, lesson, practice ও quiz।</p>
    </div>
    <div class="row g-4">@forelse($courses as $course)
        <div class="col-md-6 col-lg-4">
            <article class="janala-course h-100">
                <div class="course-banner banner-{{ ($loop->index % 3) + 1 }}">
                    <span>ইংরেজি কোর্স</span>
                    <b>{{ sprintf('%02d', $loop->iteration) }}</b>
                </div>
                <div class="p-4">
                    <h3>{{ $course->title }}</h3>
                    <p>{{ Str::limit($course->description,120) }}</p>
                    <div class="course-meta">
                        <span><i class="bi bi-collection-play"></i> {{ $course->lessons_count }} লেসন</span>
                        <span><i class="bi bi-layers"></i> {{ $course->topics_count }} চ্যাপ্টার</span>
                    </div>
                    <a href="{{ route('courses.show',$course) }}" class="btn btn-course w-100 mt-4">কোর্সটি শুরু করুন <i class="bi bi-arrow-right"></i></a>
                </div>
            </article>
        </div>@empty
        <div class="col-12">
            <div class="empty-state text-center">
                কোর্স শিগগিরই যোগ করা হবে।
            </div>
        </div>@endforelse
    </div>
</section>
<section class="learning-journey row align-items-center g-4 mb-5">
    <div class="col-lg-6">
        <div class="journey-art">
            <i class="bi bi-compass-fill"></i>
            <span>Learn</span>
            <span>Practice</span>
            <span>Grow</span>
        </div>
    </div>
    <div class="col-lg-6">
        <span class="text-uppercase fw-bold small text-warning">কীভাবে শিখবেন</span>
        <h2>শুরু করুন, প্র্যাকটিস করুন, এগিয়ে যান</h2>
        <div class="journey-step"><b>১</b>
            <div>
             <strong>পছন্দের কোর্স বেছে নিন</strong>
             <p>আপনার লেভেল অনুযায়ী chapter থেকে শুরু করুন।</p>
           </div>            </div>
        <div class="journey-step"><b>২</b>
            <div><strong>লেসন সম্পন্ন করুন</strong>
             <p>শুনুন, পড়ুন এবং নতুন বাক্যগুলো প্র্যাকটিস করুন।</p>
            </div>
        </div>
        <div class="journey-step">
            <b>৩</b>
            <div>
             <strong>কুইজ দিয়ে নিজেকে যাচাই করুন</strong>
             <p>MCQ এবং short answer দিয়ে অগ্রগতি দেখুন।</p>
            </div>

        </div>

    </div>
</section>
@endsection
