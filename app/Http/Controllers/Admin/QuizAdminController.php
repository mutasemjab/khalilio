<?php
// app/Http/Controllers/Admin/QuizAdminController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizAdminController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::withCount('questions')->latest()->get();
        return view('admin.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        return view('admin.quizzes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'total_marks'      => 'required|integer|min:1',   // ← NEW
            'whatsapp_a'       => 'nullable|url',
            'whatsapp_b'       => 'nullable|url',
            'whatsapp_c'       => 'nullable|url',
        ]);

        $quiz = Quiz::create([
            'name'             => $request->name,
            'description'      => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'total_marks'      => $request->total_marks,
            'is_active'        => $request->has('is_active'),
            'whatsapp_a'       => $request->whatsapp_a,
            'whatsapp_b'       => $request->whatsapp_b,
            'whatsapp_c'       => $request->whatsapp_c,
        ]);

        return redirect()
            ->route('admin.quizzes.questions', $quiz->id)
            ->with('success', __('messages.quiz_created'));
    }

    public function edit(Quiz $quiz)
    {
        return view('admin.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'total_marks'      => 'required|integer|min:1',
            'whatsapp_a'       => 'nullable|url',
            'whatsapp_b'       => 'nullable|url',
            'whatsapp_c'       => 'nullable|url',
        ]);

        $quiz->update([
            'name'             => $request->name,
            'description'      => $request->description,
            'duration_minutes' => $request->duration_minutes,
            'total_marks'      => $request->total_marks,
            'is_active'        => $request->has('is_active'),
            'whatsapp_a'       => $request->whatsapp_a,
            'whatsapp_b'       => $request->whatsapp_b,
            'whatsapp_c'       => $request->whatsapp_c,
        ]);

        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', __('messages.quiz_updated'));
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()
            ->route('admin.quizzes.index')
            ->with('success', __('messages.quiz_deleted'));
    }

    // ── Questions ────────────────────────────────────────────

    public function questions(Quiz $quiz)
    {
        $questions      = $quiz->questions()->orderBy('order')->get();
        $currentSum     = $quiz->currentGradesSum();
        $remainingMarks = $quiz->remainingMarks();
        $isComplete     = ($currentSum === $quiz->total_marks);

        return view('admin.quizzes.questions',
            compact('quiz', 'questions', 'currentSum', 'remainingMarks', 'isComplete'));
    }

    public function storeQuestion(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'type'           => 'required|in:multiple_choice,true_false',
            'correct_answer' => 'required|string',
            'option_a'       => 'nullable|string|max:500',
            'option_b'       => 'nullable|string|max:500',
            'option_c'       => 'nullable|string|max:500',
            'option_d'       => 'nullable|string|max:500',
            'question_image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
            'order'          => 'nullable|integer|min:1',
            'grade'          => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($quiz) {
                    // The new grade must not exceed remaining unassigned marks
                    $remaining = $quiz->remainingMarks();
                    if ((int)$value > $remaining) {
                        $fail(
                            app()->getLocale() === 'ar'
                                ? "علامة السؤال ({$value}) تتجاوز العلامات المتبقية ({$remaining}). مجموع العلامات يجب أن يساوي {$quiz->total_marks}."
                                : "Question grade ({$value}) exceeds remaining marks ({$remaining}). Total must equal {$quiz->total_marks}."
                        );
                    }
                },
            ],
        ]);

        $data = [
            'quiz_id'        => $quiz->id,
            'question_text'  => $request->question_text,
            'type'           => $request->type,
            'correct_answer' => $request->correct_answer,
            'option_a'       => $request->option_a,
            'option_b'       => $request->option_b,
            'option_c'       => $request->option_c,
            'option_d'       => $request->option_d,
            'order'          => $request->order ?? ($quiz->questions()->count() + 1),
            'grade'          => (int) $request->grade,
        ];

        if ($request->hasFile('question_image')) {
            $data['question_image'] = uploadImage('assets/admin/uploads', $request->question_image);
        }

        QuizQuestion::create($data);

        return back()->with('success', __('messages.question_added'));
    }

    public function destroyQuestion(QuizQuestion $question)
    {
        $question->delete();
        return back()->with('success', __('messages.question_deleted'));
    }
}
