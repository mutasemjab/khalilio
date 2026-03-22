<?php
// =========================================================
// HubController.php  — Main landing hub with 4 buttons
// =========================================================
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HubController extends Controller
{
    public function index()
    {
        if (!session('registered_user_id')) {
            return redirect()->route('hub');
        }

        $userId = session('registered_user_id'); // ✅ مررها للـ view

        return view('user.hub', compact('userId'));
    }
}