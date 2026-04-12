<?php
// =========================================================
// HubController.php  — Main landing hub with 4 buttons
// =========================================================
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HubController extends Controller
{
    public function index()
    {
        // Check logged-in user via Auth guard first, then fall back to session (set after registration)
        if (Auth::guard('user')->check()) {
            $userId = Auth::guard('user')->id();
        } elseif (session('registered_user_id')) {
            $userId = session('registered_user_id');
        } else {
            return redirect()->route('user.login');
        }

        return view('user.hub', compact('userId'));
    }
}