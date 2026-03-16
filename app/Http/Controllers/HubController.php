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
        return view('user.hub');
    }
}