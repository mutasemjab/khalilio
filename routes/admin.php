<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

// ── NEW IMPORTS ──────────────────────────────────────────────
use App\Http\Controllers\Admin\TopStudentAdminController;
use App\Http\Controllers\Admin\QuizAdminController;
use App\Http\Controllers\Admin\PdfBagAdminController;
// ────────────────────────────────────────────────────────────

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Permission\Models\Permission;

define('PAGINATION_COUNT', 11);

Route::group([
    'prefix'     => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath'],
], function () {

    
    // ════════════════════════════════════════════════════════
    // ADMIN ROUTES
    // ════════════════════════════════════════════════════════
    Route::group(['prefix' => 'admin', 'middleware' => 'auth:admin'], function () {

        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('logout', [LoginController::class, 'logout'])->name('admin.logout');

        // Update admin login
        Route::get('/admin/edit/{id}',    [LoginController::class, 'editlogin'])->name('admin.login.edit');
        Route::post('/admin/update/{id}', [LoginController::class, 'updatelogin'])->name('admin.login.update');

        // Roles & permissions
        Route::resource('employee', 'App\Http\Controllers\Admin\EmployeeController', ['as' => 'admin']);
        Route::get('role',              'App\Http\Controllers\Admin\RoleController@index')->name('admin.role.index');
        Route::get('role/create',       'App\Http\Controllers\Admin\RoleController@create')->name('admin.role.create');
        Route::get('role/{id}/edit',    'App\Http\Controllers\Admin\RoleController@edit')->name('admin.role.edit');
        Route::patch('role/{id}',       'App\Http\Controllers\Admin\RoleController@update')->name('admin.role.update');
        Route::post('role',             'App\Http\Controllers\Admin\RoleController@store')->name('admin.role.store');
        Route::post('admin/role/delete','App\Http\Controllers\Admin\RoleController@delete')->name('admin.role.delete');

        Route::get('/permissions/{guard_name}', function ($guard_name) {
            return response()->json(Permission::where('guard_name', $guard_name)->get());
        });

        // Existing users
        Route::resource('users', UserController::class)->except(['show']);
        Route::get('/export', [UserController::class, 'export']);

        // ── NEW: Top Students CRUD ────────────────────────────
        Route::prefix('top-students')->name('admin.top-students.')->group(function () {
            Route::get('/',              [TopStudentAdminController::class, 'index'])->name('index');
            Route::get('/create',        [TopStudentAdminController::class, 'create'])->name('create');
            Route::post('/',             [TopStudentAdminController::class, 'store'])->name('store');
            Route::get('/{topStudent}/edit',   [TopStudentAdminController::class, 'edit'])->name('edit');
            Route::put('/{topStudent}',        [TopStudentAdminController::class, 'update'])->name('update');
            Route::delete('/{topStudent}',     [TopStudentAdminController::class, 'destroy'])->name('destroy');
        });

        // ── NEW: Quizzes CRUD ────────────────────────────────
        Route::prefix('quizzes')->name('admin.quizzes.')->group(function () {
            Route::get('/',             [QuizAdminController::class, 'index'])->name('index');
            Route::get('/create',       [QuizAdminController::class, 'create'])->name('create');
            Route::post('/',            [QuizAdminController::class, 'store'])->name('store');
            Route::get('/{quiz}/edit',  [QuizAdminController::class, 'edit'])->name('edit');
            Route::put('/{quiz}',       [QuizAdminController::class, 'update'])->name('update');
            Route::delete('/{quiz}',    [QuizAdminController::class, 'destroy'])->name('destroy');

            // Questions sub-resource
            Route::get('/{quiz}/questions',  [QuizAdminController::class, 'questions'])->name('questions');
            Route::post('/{quiz}/questions', [QuizAdminController::class, 'storeQuestion'])->name('questions.store');
            Route::delete('/questions/{question}', [QuizAdminController::class, 'destroyQuestion'])->name('questions.destroy');

            // Attempts (submissions)
            Route::get('/{quiz}/attempts', [QuizAdminController::class, 'attempts'])->name('attempts');
        });

        // ── PDF Bag ───────────────────────────────────────────
        Route::prefix('admin/pdf-bag')->name('admin.pdf-bag.')->group(function () {
            Route::get('/', [PdfBagAdminController::class, 'index'])->name('index');
            Route::post('/categories', [PdfBagAdminController::class, 'storeCategory'])->name('categories.store');
            Route::delete('/categories/{category}', [PdfBagAdminController::class, 'destroyCategory'])->name('categories.destroy');

            // Subcategories (managed inside category page)
            Route::get('/categories/{category}', [PdfBagAdminController::class, 'showCategory'])->name('categories.show');
            Route::post('/categories/{category}/subcategories', [PdfBagAdminController::class, 'storeSubcategory'])->name('subcategories.store');
            Route::delete('/subcategories/{subcategory}', [PdfBagAdminController::class, 'destroySubcategory'])->name('subcategories.destroy');

            // Files (managed inside subcategory page)
            Route::get('/subcategories/{subcategory}', [PdfBagAdminController::class, 'showSubcategory'])->name('subcategories.show');
            Route::post('/subcategories/{subcategory}/files', [PdfBagAdminController::class, 'storeFile'])->name('files.store');
            Route::delete('/files/{file}', [PdfBagAdminController::class, 'destroyFile'])->name('files.destroy');
        });


    });
});

// ── Admin guest routes (login) ───────────────────────────────
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => 'guest:admin'], function () {
    Route::get('login',  [LoginController::class, 'show_login_view'])->name('admin.showlogin');
    Route::post('login', [LoginController::class, 'login'])->name('admin.login');
});