<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function showStudentForm()
    {
        return view('user.student-form');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'school_name' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'school_name' => $request->school_name,
        ]);

        return redirect()->route('grades.form', $user->id);
    }

    public function showGradesForm(User $user)
    {
        return view('user.grades-form', compact('user'));
    }

    public function storeGrades(Request $request, User $user)
    {
        $request->validate([
            'arabic_grade' => 'required|integer|min:0|max:100',
            'english_grade' => 'required|integer|min:0|max:100',
            'jordan_history_grade' => 'required|integer|min:0|max:40',
            'islamic_education_grade' => 'required|integer|min:0|max:60',
        ]);

        $user->update([
            'arabic_grade' => $request->arabic_grade,
            'english_grade' => $request->english_grade,
            'jordan_history_grade' => $request->jordan_history_grade,
            'islamic_education_grade' => $request->islamic_education_grade,
        ]);

        // Calculate and save average
        $average = $user->calculateAverage();
        $user->update(['average' => $average]);

        return redirect()->route('result.show', $user->id);
    }

    public function showResult(User $user)
    {
        return view('user.result', compact('user'));
    }
}