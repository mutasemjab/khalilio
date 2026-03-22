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
        // Safety guard — shouldn't reach here without session, but just in case
        if (!session('registered_user_id')) {
            return redirect()->route('hub');
        }

        return view('user.hub');
    }
}