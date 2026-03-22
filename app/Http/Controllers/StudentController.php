<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show registration form.
     * Accepts ?redirect_to=average|track|quiz via query string.
     * Stores it in session so the POST can read it.
     */
    public function showStudentForm(Request $request)
    {
        // مسجل بالفعل → روح للـ hub مباشرة
        if (session('registered_user_id')) {
            return redirect()->route('hub.home'); // ✅
        }

        $redirectTo = $request->query('redirect_to', 'average');
        session(['redirect_to' => $redirectTo]);

        return view('user.student-form', compact('redirectTo'));
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $parts = preg_split('/\s+/', trim($value));
                    if (count($parts) < 3) {
                        $fail(__('messages.name_three_parts'));
                    }
                },
            ],
            'phone' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $phone = preg_replace('/\s+/', '', $value);
                    if (!preg_match('/^07\d{8}$/', $phone)) {
                        $fail(__('messages.phone_invalid'));
                    }
                },
            ],
            'school_name' => 'required|string|max:255',
            'generation'  => 'required|in:2008,2009,2010',
        ]);

        $user = User::create([
            'name'        => $request->name,
            'phone'       => preg_replace('/\s+/', '', $request->phone),
            'school_name' => $request->school_name,
            'generation'  => $request->generation,
        ]);

        session(['registered_user_id' => $user->id]);

        return redirect()->route('hub.home'); // ✅ للـ hub الحقيقي
    }

    // ── Grades / Average ─────────────────────────────────────

    public function showGradesForm(User $user)
    {
        return view('user.grades-form', compact('user'));
    }

    public function storeGrades(Request $request, User $user)
    {
        $request->validate([
            'arabic_grade'            => 'required|integer|min:0|max:100',
            'math_grade'           => 'required|integer|min:0|max:100',
            'jordan_history_grade'    => 'required|integer|min:0|max:40',
            'islamic_education_grade' => 'required|integer|min:0|max:60',
        ]);

        $user->update([
            'arabic_grade'            => $request->arabic_grade,
            'math_grade'           => $request->math_grade,
            'jordan_history_grade'    => $request->jordan_history_grade,
            'islamic_education_grade' => $request->islamic_education_grade,
        ]);

        $average = $user->calculateAverage();
        $user->update(['average' => $average]);

        return redirect()->route('result.show', $user->id);
    }

    public function showResult(User $user)
    {
        return view('user.result', compact('user'));
    }
}
