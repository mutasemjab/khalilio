<?php

namespace App\Http\Controllers;

use App\Models\BagExam;
use App\Models\BagExamAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BagExamController extends Controller
{
    public function show(BagExam $exam)
    {
        abort_unless($exam->is_active, 404);

        $user = Auth::guard('user')->user();
        $questions = $exam->questions()->orderBy('order')->get();

        return view('user.bag-exam-take', compact('exam', 'questions', 'user'));
    }

    public function take(Request $request, BagExam $exam)
    {
        // kept for backward compatibility — redirects to show
        return redirect()->route('bag-exam.show', $exam->id);
    }

    public function submit(Request $request, BagExam $exam)
    {
        abort_unless($exam->is_active, 404);

        $questions = $exam->questions()->orderBy('order')->get();

        $score   = 0;
        $answers = [];

        foreach ($questions as $q) {
            $userAnswer = $request->input('q_' . $q->id, '');
            $isRight    = ($userAnswer === $q->correct_answer);

            if ($isRight) {
                $score += $q->grade;
            }

            $answers[$q->id] = [
                'user'     => $userAnswer,
                'correct'  => $q->correct_answer,
                'is_right' => $isRight,
                'grade'    => $q->grade,
                'earned'   => $isRight ? $q->grade : 0,
            ];
        }

        $user = Auth::guard('user')->user();

        $attempt = BagExamAttempt::create([
            'bag_exam_id'     => $exam->id,
            'student_name'    => $user ? $user->name  : 'طالب',
            'student_phone'   => $user ? $user->phone : null,
            'score'           => $score,
            'total_marks'     => $exam->total_marks,
            'total_questions' => $questions->count(),
            'answers'         => $answers,
        ]);

        return redirect()->route('bag-exam.result', $attempt->id);
    }

    public function result(BagExamAttempt $attempt)
    {
        $exam = $attempt->exam;
        $questions = $exam->questions()->orderBy('order')->get();

        return view('user.bag-exam-result', compact('attempt', 'exam', 'questions'));
    }
}
