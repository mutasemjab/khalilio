<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $levels = [];

    protected $dontReport = [];

    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Redirect students to login on session/CSRF expiry instead of showing a raw error.
     */
    public function render($request, Throwable $e)
    {
        // 419 — CSRF / session expired
        if ($e instanceof TokenMismatchException) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return redirect()->route('admin.showlogin')
                    ->with('error', 'انتهت صلاحية الجلسة. يرجى تسجيل الدخول مجدداً.');
            }
            return redirect()->route('user.login')
                ->with('session_expired', true);
        }

        return parent::render($request, $e);
    }

    /**
     * Redirect unauthenticated students to login instead of throwing.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->route('admin.showlogin');
        }

        return redirect()->route('user.login')->with('session_expired', true);
    }
}
