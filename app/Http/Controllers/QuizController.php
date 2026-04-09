<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\User;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /**
     * Public landing page — no user required.
     * Used by the admin sidebar link and any public links.
     * Shows quiz info and redirects to registration to start.
     */
    public function landing()
    {
        $quiz = Quiz::where('is_active', true)->latest()->first();
        return view('user.quiz-landing', compact('quiz'));
    }

    /**
     * User-specific quiz page — after registration.
     * Route: GET /quiz/{user}  →  quiz.index
     */
    public function index(User $user)
    {
        $quiz = Quiz::where('is_active', true)->latest()->first();
        return view('user.quiz', compact('quiz', 'user'));
    }

    public function start(Request $request, Quiz $quiz)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $questions = $quiz->questions()->orderBy('order')->get();
        session(['quiz_user_id' => $request->user_id]);

        return view('user.quiz-take', compact('quiz', 'questions'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        $questions = $quiz->questions()->orderBy('order')->get();

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

        $totalMarks = $quiz->total_marks;

        // Classification based on direct score:
        // > 42 → A | 30–42 → B | < 30 → C
        $group = 'C';
        if ($score > 42)                       $group = 'A';
        elseif ($score >= 30 && $score <= 42)  $group = 'B';

        $userId = session('quiz_user_id');
        $user   = $userId ? User::find($userId) : null;

        $attempt = QuizAttempt::create([
            'quiz_id'         => $quiz->id,
            'student_name'    => $user ? $user->name  : 'طالب',
            'student_phone'   => $user ? $user->phone : null,
            'score'           => $score,
            'total_marks'     => $totalMarks,
            'total_questions' => $questions->count(),
            'group'           => $group,
            'answers'         => $answers,
        ]);

        return redirect()->route('quiz.result', $attempt->id);
    }

    public function result(QuizAttempt $attempt)
    {
        $quiz = $attempt->quiz;

        // Guard against old string records
        if (is_string($attempt->answers)) {
            $attempt->answers = json_decode($attempt->answers, true) ?? [];
        }

        return view('user.quiz-result', compact('attempt', 'quiz'));
    }
}
