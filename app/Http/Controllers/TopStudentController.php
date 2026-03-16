<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TopStudent;

class TopStudentController extends Controller
{
    public function index()
    {
        $students = TopStudent::where('is_active', true)->orderBy('order')->get();
        return view('user.top-students', compact('students'));
    }
}