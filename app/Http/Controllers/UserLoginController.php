<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserLoginController extends Controller
{
    public function showLogin()
    {
        if (Auth::guard('user')->check()) {
            return redirect()->route('hub.home');
        }
        return view('user.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
        ], [
            'phone.required' => __('messages.phone_required'),
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors(['phone' => __('messages.phone_not_found')])->withInput();
        }

        Auth::guard('user')->login($user, true);

        return redirect()->route('hub.home');
    }

    public function logout()
    {
        Auth::guard('user')->logout();
        return redirect()->route('user.login');
    }
}
