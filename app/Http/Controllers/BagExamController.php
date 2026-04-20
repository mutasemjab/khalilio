<?php

namespace App\Http\Controllers;

use App\Models\BagExam;
use App\Models\BagExamAttempt;
use Illuminate\Http\Request;

class BagExamController extends Controller
{
    public function show(BagExam $exam)
    {
        abort_unless($exam->is_active, 404);
        return view('user.bag-exam-start', compact('exam'));
    }

    public function take(Request $request, BagExam $exam)
    {
        abort_unless($exam->is_active, 404);

        $request->validate([
            'student_name'  => 'required|string|max:100',
            'student_phone' => 'nullable|string|max:20',
        ]);

        session([
            'bag_exam_name'  => $request->student_name,
            'bag_exam_phone' => $request->student_phone,
        ]);

        $questions = $exam->questions()->orderBy('order')->get();

        return view('user.bag-exam-take', compact('exam', 'questions'));
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

        $attempt = BagExamAttempt::create([
            'bag_exam_id'     => $exam->id,
            'student_name'    => session('bag_exam_name', 'طالب'),
            'student_phone'   => session('bag_exam_phone'),
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
