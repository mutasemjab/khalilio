<?php

use App\Http\Controllers\StudentController;
use App\Http\Controllers\HubController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\TopStudentController;
use App\Http\Controllers\QuizController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes  (frontend)
|--------------------------------------------------------------------------
|
| quiz.landing  → /quiz              public info page  (no {user} needed)
| quiz.index    → /quiz/{user}       user-specific start page
|
*/

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {

    // ── Hub ──────────────────────────────────────────────────
    Route::get('/', [HubController::class, 'index'])->name('hub');

    // ── Registration ─────────────────────────────────────────
    Route::get('/register',  [StudentController::class, 'showStudentForm'])->name('student.form');
    Route::post('/register', [StudentController::class, 'storeStudent'])->name('student.store');

    // ── Grades / Average ─────────────────────────────────────
    Route::get('/grades/{user}',  [StudentController::class, 'showGradesForm'])->name('grades.form');
    Route::post('/grades/{user}', [StudentController::class, 'storeGrades'])->name('grades.store');
    Route::get('/result/{user}',  [StudentController::class, 'showResult'])->name('result.show');

    // ── Track finder ─────────────────────────────────────────
    Route::get('/track-finder/{user}',  [TrackController::class, 'show'])->name('track.show');
    Route::post('/track-finder/{user}', [TrackController::class, 'calculate'])->name('track.calculate');

    // ── Top students ─────────────────────────────────────────
    Route::get('/top-students', [TopStudentController::class, 'index'])->name('top-students.index');

    // ── Quiz ─────────────────────────────────────────────────
    // Public landing (used by sidebar link — no user needed)
    Route::get('/quiz',                      [QuizController::class, 'landing'])->name('quiz.landing');

    // IMPORTANT: /quiz/result must be defined BEFORE /quiz/{user}
    // otherwise Laravel will try to match "result" as a {user} param
    Route::get('/quiz/result/{attempt}',     [QuizController::class, 'result'])->name('quiz.result');

    // User-specific quiz page (after registration)
    Route::get('/quiz/{user}',               [QuizController::class, 'index'])->name('quiz.index');

    Route::post('/quiz/{quiz}/start',        [QuizController::class, 'start'])->name('quiz.start');
    Route::post('/quiz/{quiz}/submit',       [QuizController::class, 'submit'])->name('quiz.submit');

});
