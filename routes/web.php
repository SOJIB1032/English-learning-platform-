<?php

use App\Http\Controllers\AdminCourseController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TopicQuizController;
use App\Http\Controllers\AdminTopicController;
use App\Http\Controllers\AdminLessonController;
use App\Http\Controllers\AdminQuizController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminPracticeController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\AdminSubjectController;

Route::get('/', LandingController::class)->name('home');
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{course:slug}', [CourseController::class, 'show'])->name('courses.show');


Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/courses', [AdminCourseController::class, 'index'])->name('admin.courses.index');
    Route::get('/admin/courses/create', [AdminCourseController::class, 'create'])->name('admin.courses.create');
    Route::post('/admin/courses', [AdminCourseController::class, 'store'])->name('admin.courses.store');
     /*
|--------------------------------------------------------------------------
| Admin Subjects
|--------------------------------------------------------------------------
*/

Route::get(
    '/admin/courses/{course}/subjects',
    [AdminSubjectController::class, 'index']
)->name('admin.subjects.index');

Route::post(
    '/admin/courses/{course}/subjects',
    [AdminSubjectController::class, 'store']
)->name('admin.subjects.store');

Route::put(
    '/admin/courses/{course}/subjects/{subject}',
    [AdminSubjectController::class, 'update']
)->name('admin.subjects.update');

Route::delete(
    '/admin/courses/{course}/subjects/{subject}',
    [AdminSubjectController::class, 'destroy']
)->name('admin.subjects.destroy');

 //chapter er route .............................................

    Route::get(
    '/admin/courses/{course}/subjects/{subject}/chapters',
    [AdminTopicController::class, 'index']
)->name('admin.topics.index');

   Route::post(
    '/admin/courses/{course}/subjects/{subject}/chapters',
    [AdminTopicController::class, 'store']
)->name('admin.topics.store');
Route::get(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/edit',
    [AdminTopicController::class, 'edit']
)->name('admin.topics.edit');


  Route::put(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}',
    [AdminTopicController::class, 'update']
)->name('admin.topics.update');


    Route::delete(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}',
    [AdminTopicController::class, 'destroy']
)->name('admin.topics.destroy');

//lesson er route ..................................................
   Route::get(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons',
    [AdminLessonController::class, 'index']
)->name('admin.lessons.index');

    
Route::post(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons',
    [AdminLessonController::class, 'store']
)->name('admin.lessons.store');

Route::get(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/edit',
    [AdminLessonController::class, 'edit']
)->name('admin.lessons.edit');

Route::put(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}',
    [AdminLessonController::class, 'update']
)->name('admin.lessons.update');

    Route::delete(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}',
    [AdminLessonController::class, 'destroy']
)->name('admin.lessons.destroy');

//quiz er rout..................................

    Route::get('/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/quiz', [AdminQuizController::class, 'edit'])->name('admin.quizzes.edit');
    Route::put('/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/quiz/{quiz}', [AdminQuizController::class, 'update'])->name('admin.quizzes.update');
    Route::post('/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/quiz/{quiz}/questions', [AdminQuizController::class, 'addQuestion'])->name('admin.quiz-questions.store');
    Route::delete('/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/quiz/{quiz}/questions/{question}', [AdminQuizController::class, 'deleteQuestion'])->name('admin.quiz-questions.destroy');
    Route::get('/courses/{course:slug}/subjects/{subject:slug}/topics/{topic}/lessons/{lesson:slug}', [LessonController::class, 'show'])->name('lessons.show');
    Route::post('/courses/{course:slug}/subjects/{subject:slug}/topics/{topic}/lessons/{lesson:slug}/complete', [LessonController::class, 'markComplete'])->name('lessons.complete');
    Route::get('/courses/{course:slug}/subjects/{subject:slug}/topics/{topic}/lessons/{lesson:slug}/quiz', [QuizController::class, 'show'])->name('quiz.show');
    Route::post('/courses/{course:slug}/subjects/{subject:slug}/topics/{topic}/lessons/{lesson:slug}/quiz', [QuizController::class, 'submit'])->name('quiz.submit');
   // Route::get('/courses/{course}/chapters/{topic}/quiz/{quiz}', [TopicQuizController::class, 'show'])->name('topic-quizzes.show');
   // Route::post('/courses/{course}/chapters/{topic}/quiz/{quiz}', [TopicQuizController::class, 'submit'])->name('topic-quizzes.submit');
   Route::delete(
    '/admin/courses/{course}',
    [AdminCourseController::class, 'destroy']
    )->name('admin.courses.destroy');
   Route::get(
   '/admin/courses/{course}/subjects/{subject}/topics/{topic}//lessons/{lesson}/practice',
  [AdminPracticeController::class,'index']
  )->name('admin.practices.index');

  Route::post(
  '/admin/courses/{course}/subjects/{subject}/topics/{topic}/lessons/{lesson}/practice',
  [AdminPracticeController::class,'store']
  )->name('admin.practices.store');

  Route::delete(
  '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/practice/{practice}',
  [AdminPracticeController::class,'destroy']
  )->name('admin.practices.destroy');
Route::get(
    '/courses/{course:slug}/subjects/{subject:slug}/topics/{topic}/lessons/{lesson:slug}/practice',
    [PracticeController::class, 'show']
)->name('practice.show');

Route::post(
'/courses/{course:slug}/subjects/{subject}/topics/{topic}/lessons/{lesson:slug}/practice',
[PracticeController::class,'submit']
)->name('practice.submit');

Route::get(
    '/admin/courses/{course}/edit',
    [AdminCourseController::class, 'edit']
)->name('admin.courses.edit');

Route::put(
    '/admin/courses/{course}',
    [AdminCourseController::class, 'update']
)->name('admin.courses.update');

Route::get(
    '/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/edit',
    [AdminLessonController::class, 'edit']
)->name('admin.lessons.edit');


Route::get(
'/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/practice/{practice}/edit',
[AdminPracticeController::class,'edit']
)->name('admin.practices.edit');

Route::put(
'/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/practice/{practice}',
[AdminPracticeController::class,'update']
)->name('admin.practices.update');
Route::get(
'/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/quiz/{quiz}/questions/{question}/edit',
[AdminQuizController::class,'editQuestion']
)->name('admin.quiz-questions.edit');

Route::put(
'/admin/courses/{course}/subjects/{subject}/chapters/{topic}/lessons/{lesson}/quiz/{quiz}/questions/{question}',
[AdminQuizController::class,'updateQuestion']
)->name('admin.quiz-questions.update');


});
