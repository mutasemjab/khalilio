<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group whichf
| contains the "web" middleware group. Now create something great!
|
*/



Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

Route::get('/', [StudentController::class, 'showStudentForm'])->name('student.form');
Route::post('/student', [StudentController::class, 'storeStudent'])->name('student.store');
Route::get('/grades/{user}', [StudentController::class, 'showGradesForm'])->name('grades.form');
Route::post('/grades/{user}', [StudentController::class, 'storeGrades'])->name('grades.store');
Route::get('/result/{user}', [StudentController::class, 'showResult'])->name('result.show');

});

