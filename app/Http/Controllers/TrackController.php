<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class TrackController extends Controller
{
    /**
     * Show the 9-subject grade entry form.
     * User is already registered and passed via route model binding.
     */
    public function show(User $user)
    {
        return view('user.track-finder', compact('user'));
    }

  public function calculate(Request $request, User $user)
{
    $request->validate([
        'islamic'   => 'required|integer|min:0|max:200',
        'arabic'    => 'required|integer|min:0|max:300',
        'english'   => 'required|integer|min:0|max:200',
        'math'      => 'required|integer|min:0|max:200',
        'social'    => 'required|integer|min:0|max:200',
        'science'   => 'required|integer|min:0|max:400',
        'financial' => 'required|integer|min:0|max:100',
    ]);

    $subjects = [
        'islamic'   => ['label' => 'التربية الإسلامية',   'max' => 200, 'value' => (int)$request->islamic],
        'arabic'    => ['label' => 'اللغة العربية',        'max' => 300, 'value' => (int)$request->arabic],
        'english'   => ['label' => 'اللغة الإنجليزية',     'max' => 200, 'value' => (int)$request->english],
        'math'      => ['label' => 'الرياضيات',            'max' => 200, 'value' => (int)$request->math],
        'social'    => ['label' => 'الدراسات الاجتماعية',  'max' => 200, 'value' => (int)$request->social],
        'science'   => ['label' => 'العلوم',               'max' => 400, 'value' => (int)$request->science],
        'financial' => ['label' => 'الثقافة المالية',      'max' => 100, 'value' => (int)$request->financial],
    ];

    $totalScore = array_sum(array_column($subjects, 'value'));
    $totalMax   = array_sum(array_column($subjects, 'max')); // 1600
    $percentage = round(($totalScore / $totalMax) * 100, 2);

    if ($percentage >= 90) {
        $tracks = ['الصحي', 'التكنولوجي', 'الأعمال', 'اللغات', 'الشريعة'];
    } elseif ($percentage >= 80) {
        $tracks = ['التكنولوجي', 'الأعمال', 'اللغات', 'الشريعة'];
    } elseif ($percentage >= 70) {
        $tracks = ['الأعمال', 'اللغات', 'الشريعة'];
    } elseif ($percentage >= 50) {
        $tracks = ['اللغات', 'الشريعة'];
    } else {
        $tracks = [];
    }

    return view('user.track-result', compact('user', 'subjects', 'totalScore', 'totalMax', 'percentage', 'tracks'));
}
}
