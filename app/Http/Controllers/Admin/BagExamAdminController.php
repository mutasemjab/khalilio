<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BagExam;
use App\Models\BagExamAttempt;
use App\Models\BagExamQuestion;
use App\Models\PdfSubcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BagExamAdminController extends Controller
{
    private string $imgDir;

    public function __construct()
    {
        $this->imgDir = public_path('assets/admin/uploads');
    }

    // ── Exams list for a subcategory ─────────────────────────

    public function index(PdfSubcategory $subcategory)
    {
        $exams = $subcategory->exams()->withCount(['questions', 'attempts'])->orderBy('sort_order')->get();
        return view('admin.bag-exams.index', compact('subcategory', 'exams'));
    }

    public function store(Request $request, PdfSubcategory $subcategory)
    {
        $request->validate([
            'title_ar'          => 'required|string|max:255',
            'title_en'          => 'nullable|string|max:255',
            'description_ar'    => 'nullable|string|max:1000',
            'description_en'    => 'nullable|string|max:1000',
            'duration_minutes'  => 'required|integer|min:1|max:300',
            'total_marks'       => 'required|integer|min:1|max:1000',
            'sort_order'        => 'nullable|integer|min:0',
        ]);

        BagExam::create([
            'pdf_subcategory_id' => $subcategory->id,
            'title_ar'           => $request->title_ar,
            'title_en'           => $request->title_en,
            'description_ar'     => $request->description_ar,
            'description_en'     => $request->description_en,
            'duration_minutes'   => $request->duration_minutes,
            'total_marks'        => $request->total_marks,
            'is_active'          => $request->boolean('is_active', true),
            'sort_order'         => $request->sort_order ?? 0,
        ]);

        return back()->with('success', app()->getLocale() === 'ar' ? 'تم إنشاء الامتحان بنجاح.' : 'Exam created successfully.');
    }

    public function update(Request $request, BagExam $exam)
    {
        $request->validate([
            'title_ar'          => 'required|string|max:255',
            'title_en'          => 'nullable|string|max:255',
            'description_ar'    => 'nullable|string|max:1000',
            'description_en'    => 'nullable|string|max:1000',
            'duration_minutes'  => 'required|integer|min:1|max:300',
            'total_marks'       => 'required|integer|min:1|max:1000',
            'sort_order'        => 'nullable|integer|min:0',
        ]);

        $exam->update([
            'title_ar'          => $request->title_ar,
            'title_en'          => $request->title_en,
            'description_ar'    => $request->description_ar,
            'description_en'    => $request->description_en,
            'duration_minutes'  => $request->duration_minutes,
            'total_marks'       => $request->total_marks,
            'is_active'         => $request->boolean('is_active', true),
            'sort_order'        => $request->sort_order ?? 0,
        ]);

        return back()->with('success', app()->getLocale() === 'ar' ? 'تم تحديث الامتحان بنجاح.' : 'Exam updated successfully.');
    }

    public function destroy(BagExam $exam)
    {
        $exam->delete();
        return back()->with('success', app()->getLocale() === 'ar' ? 'تم حذف الامتحان.' : 'Exam deleted.');
    }

    // ── Questions ─────────────────────────────────────────────

    public function questions(BagExam $exam)
    {
        $questions     = $exam->questions()->orderBy('order')->get();
        $currentSum    = $exam->currentGradesSum();
        $remainingMarks = $exam->remainingMarks();
        $isComplete    = $remainingMarks === 0;

        return view('admin.bag-exams.questions', compact('exam', 'questions', 'currentSum', 'remainingMarks', 'isComplete'));
    }

    public function storeQuestion(Request $request, BagExam $exam)
    {
        $request->validate([
            'question_text'  => 'required|string',
            'type'           => 'required|in:multiple_choice,true_false',
            'correct_answer' => 'required|string',
            'grade'          => 'required|integer|min:1',
            'question_image' => 'nullable|image|max:5120',
        ]);

        $remaining = $exam->remainingMarks();
        if ($request->grade > $remaining) {
            return back()->withErrors(['grade' => app()->getLocale() === 'ar'
                ? "العلامة ({$request->grade}) تتجاوز المتبقي ({$remaining})."
                : "Grade ({$request->grade}) exceeds remaining ({$remaining})."
            ])->withInput();
        }

        $imageName = null;
        if ($request->hasFile('question_image')) {
            $img = $request->file('question_image');
            $imageName = time() . '_' . Str::random(6) . '.' . $img->getClientOriginalExtension();
            $img->move($this->imgDir, $imageName);
        }

        BagExamQuestion::create([
            'bag_exam_id'    => $exam->id,
            'question_text'  => $request->question_text,
            'question_image' => $imageName,
            'type'           => $request->type,
            'correct_answer' => $request->correct_answer,
            'option_a'       => $request->option_a,
            'option_b'       => $request->option_b,
            'option_c'       => $request->option_c,
            'option_d'       => $request->option_d,
            'order'          => $request->order ?? ($exam->questions()->count() + 1),
            'grade'          => $request->grade,
        ]);

        return back()->with('success', app()->getLocale() === 'ar' ? 'تم إضافة السؤال.' : 'Question added.');
    }

    public function destroyQuestion(BagExamQuestion $question)
    {
        if ($question->question_image) {
            $path = $this->imgDir . DIRECTORY_SEPARATOR . $question->question_image;
            if (File::exists($path)) File::delete($path);
        }
        $question->delete();
        return back()->with('success', app()->getLocale() === 'ar' ? 'تم حذف السؤال.' : 'Question deleted.');
    }

    // ── Attempts ──────────────────────────────────────────────

    public function attempts(BagExam $exam)
    {
        $attempts = $exam->attempts()
            ->when(request('search'), fn($q) => $q->where('student_name', 'like', '%' . request('search') . '%')
                ->orWhere('student_phone', 'like', '%' . request('search') . '%'))
            ->latest()
            ->paginate(PAGINATION_COUNT);

        return view('admin.bag-exams.attempts', compact('exam', 'attempts'));
    }
}
