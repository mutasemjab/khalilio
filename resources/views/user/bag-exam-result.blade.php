{{-- resources/views/user/bag-exam-result.blade.php --}}
@extends('layouts.front')

@section('title', app()->getLocale() === 'ar' ? 'نتيجة الامتحان' : 'Exam Result')

@section('content')
@php
    $answers = $attempt->answers;
    if (is_string($answers)) $answers = json_decode($answers, true) ?? [];
    if (!is_array($answers)) $answers = [];
    $pct = $attempt->total_marks > 0 ? round($attempt->score / $attempt->total_marks * 100) : 0;
    $passed = $pct >= 50;
    $circumference = round(2 * 3.14159 * 62);
    $offset = $attempt->total_marks > 0
        ? round($circumference * (1 - $attempt->score / $attempt->total_marks))
        : $circumference;
@endphp

<div class="ber-wrapper">

    {{-- Header --}}
    <div class="ber-header">
        <div class="ber-icon">{{ $passed ? '🏆' : '📋' }}</div>
        <h1 class="ber-title {{ $passed ? 'ber-title--pass' : 'ber-title--fail' }}">
            {{ $passed
                ? (app()->getLocale() === 'ar' ? 'أحسنت! نتيجة جيدة' : 'Well Done!')
                : (app()->getLocale() === 'ar' ? 'حاول مرة أخرى' : 'Keep Trying') }}
        </h1>
        <p class="ber-student">{{ $attempt->student_name }}</p>
        <p class="ber-exam-name">{{ $exam->title }}</p>
    </div>

    {{-- Score card --}}
    <div class="ber-score-card {{ $passed ? 'ber-score--pass' : 'ber-score--fail' }}">
        <div class="ber-score-circle">
            <svg viewBox="0 0 140 140">
                <circle cx="70" cy="70" r="62" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="12"/>
                <circle cx="70" cy="70" r="62" fill="none" stroke="white" stroke-width="12"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ $offset }}"
                    stroke-linecap="round" transform="rotate(-90 70 70)"
                    class="ber-ring"/>
            </svg>
            <div class="ber-score-inner">
                <div class="ber-score-num">{{ $attempt->score }}</div>
                <div class="ber-score-of">/ {{ $attempt->total_marks }}</div>
            </div>
        </div>
        <div class="ber-score-info">
            <div class="ber-pct-badge">{{ $pct }}%</div>
            <div class="ber-score-detail">
                {{ $attempt->score }} {{ app()->getLocale() === 'ar' ? 'من' : 'of' }} {{ $attempt->total_marks }}
                {{ app()->getLocale() === 'ar' ? 'علامة' : 'marks' }}
            </div>
            <div class="ber-questions-count">
                {{ $attempt->total_questions }} {{ app()->getLocale() === 'ar' ? 'سؤال' : 'questions' }}
            </div>
        </div>
    </div>

    {{-- Retry + Back --}}
    <div class="ber-actions">
        <a href="{{ route('bag-exam.show', $exam->id) }}" class="ber-btn ber-btn--retry">
            🔄 {{ app()->getLocale() === 'ar' ? 'أعد المحاولة' : 'Try Again' }}
        </a>
        <a href="{{ route('pdf-bag.subcategory', [$exam->subcategory->category->id, $exam->subcategory->id]) }}"
           class="ber-btn ber-btn--back">
            ← {{ app()->getLocale() === 'ar' ? 'العودة للمحتوى' : 'Back to Content' }}
        </a>
    </div>

    {{-- Answer review --}}
    @if($questions->count() > 0)
    <div class="ber-review">
        <h2 class="ber-review-title">
            🔍 {{ app()->getLocale() === 'ar' ? 'مراجعة الإجابات' : 'Answer Review' }}
        </h2>
        @foreach($questions as $i => $q)
        @php
            $ans = $answers[$q->id] ?? [];
            $isRight = $ans['is_right'] ?? false;
            $userAnswer = $ans['user'] ?? '';
            $grade = $ans['grade'] ?? $q->grade;
            $earned = $ans['earned'] ?? 0;
        @endphp
        <div class="ber-q-card {{ $isRight ? 'ber-q--right' : 'ber-q--wrong' }}">
            <div class="ber-q-header">
                <span class="ber-q-num">{{ $i + 1 }}</span>
                <span class="ber-q-status">
                    {{ $isRight
                        ? (app()->getLocale() === 'ar' ? '✅ صحيح' : '✅ Correct')
                        : (app()->getLocale() === 'ar' ? '❌ خطأ' : '❌ Wrong') }}
                </span>
                <span class="ber-q-grade">
                    {{ $earned }}/{{ $grade }} {{ app()->getLocale() === 'ar' ? 'ع' : 'pt' }}
                </span>
            </div>
            <p class="ber-q-text">{{ $q->question_text }}</p>

            @if($q->question_image)
            <img src="{{ asset('assets/admin/uploads/' . $q->question_image) }}" class="ber-q-img" alt="">
            @endif

            @if($q->type === 'true_false')
            <div class="ber-tf">
                @foreach(['true' => (app()->getLocale() === 'ar' ? 'صح' : 'True'), 'false' => (app()->getLocale() === 'ar' ? 'خطأ' : 'False')] as $val => $label)
                <div class="ber-tf-item
                    {{ $q->correct_answer == $val ? 'ber-correct' : '' }}
                    {{ $userAnswer == $val && !$isRight ? 'ber-wrong' : '' }}">
                    {{ $val == 'true' ? '✅' : '❌' }} {{ $label }}
                    @if($q->correct_answer == $val) <span class="ber-mark">✓</span> @endif
                    @if($userAnswer == $val && !$isRight) <span class="ber-your">{{ app()->getLocale() === 'ar' ? '(إجابتك)' : '(yours)' }}</span> @endif
                </div>
                @endforeach
            </div>
            @else
            <div class="ber-mc">
                @foreach(['A'=>$q->option_a,'B'=>$q->option_b,'C'=>$q->option_c,'D'=>$q->option_d] as $letter => $text)
                @if($text)
                <div class="ber-mc-item
                    {{ $q->correct_answer == $letter ? 'ber-correct' : '' }}
                    {{ $userAnswer == $letter && !$isRight ? 'ber-wrong' : '' }}">
                    <span class="ber-letter ber-opt-{{ strtolower($letter) }}">{{ $letter }}</span>
                    <span class="ber-mc-text">{{ $text }}</span>
                    @if($q->correct_answer == $letter) <span class="ber-mark">✓</span> @endif
                    @if($userAnswer == $letter && !$isRight) <span class="ber-your">{{ app()->getLocale() === 'ar' ? '(إجابتك)' : '(yours)' }}</span> @endif
                </div>
                @endif
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>
    @endif

</div>

<style>
.ber-wrapper { max-width: 750px; margin: 0 auto; padding-bottom: 60px; }
.ber-header { text-align: center; margin-bottom: 28px; animation: berFade 0.7s ease-out; }
.ber-icon { font-size: 64px; display: block; margin-bottom: 10px; animation: berFloat 3s ease-in-out infinite; }
.ber-title { font-size: 28px; font-weight: 800; margin-bottom: 6px; }
.ber-title--pass { background:linear-gradient(135deg,#43e97b,#38f9d7); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.ber-title--fail { background:linear-gradient(135deg,#f093fb,#f5576c); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
.ber-student { font-size: 18px; font-weight: 700; color: var(--text-color,#2d3748); margin-bottom: 4px; }
.ber-exam-name { font-size: 14px; color: #888; }

.ber-score-card {
    border-radius: 24px; padding: 36px; display: flex; align-items: center; gap: 36px;
    margin-bottom: 28px; animation: berSlideUp 0.6s ease-out 0.2s both; flex-wrap: wrap; justify-content: center;
}
.ber-score--pass { background: linear-gradient(135deg, #43e97b, #38f9d7); }
.ber-score--fail { background: linear-gradient(135deg, #f093fb, #f5576c); }

.ber-score-circle { position: relative; width: 140px; height: 140px; flex-shrink: 0; }
.ber-score-circle svg { width: 100%; height: 100%; }
.ber-ring { transition: stroke-dashoffset 1s ease; }
.ber-score-inner {
    position: absolute; inset: 0; display: flex; flex-direction: column;
    align-items: center; justify-content: center; color: white;
}
.ber-score-num { font-size: 36px; font-weight: 900; line-height: 1; }
.ber-score-of { font-size: 14px; opacity: 0.85; }

.ber-score-info { color: white; text-align: center; }
.ber-pct-badge { font-size: 52px; font-weight: 900; line-height: 1; margin-bottom: 8px; }
.ber-score-detail { font-size: 16px; opacity: 0.9; margin-bottom: 4px; }
.ber-questions-count { font-size: 14px; opacity: 0.75; }

.ber-actions { display: flex; gap: 16px; justify-content: center; margin-bottom: 36px; flex-wrap: wrap; animation: berSlideUp 0.6s ease-out 0.4s both; }
.ber-btn {
    display: inline-flex; align-items: center; gap: 8px; padding: 14px 28px;
    border-radius: 50px; font-size: 16px; font-weight: 700; text-decoration: none;
    transition: all 0.3s ease;
}
.ber-btn--retry { background: linear-gradient(135deg,#667eea,#764ba2); color: white; box-shadow: 0 8px 24px rgba(102,126,234,0.35); }
.ber-btn--retry:hover { color: white; text-decoration: none; transform: translateY(-2px); }
.ber-btn--back { background: rgba(255,255,255,0.95); color: #555; border: 2px solid rgba(0,0,0,0.1); }
.ber-btn--back:hover { color: #333; text-decoration: none; transform: translateY(-2px); }

.ber-review { animation: berSlideUp 0.6s ease-out 0.6s both; }
.ber-review-title { font-size: 20px; font-weight: 800; color: var(--text-color,#2d3748); margin-bottom: 20px; }

.ber-q-card { background: rgba(255,255,255,0.97); border-radius: 18px; padding: 22px; margin-bottom: 16px; border: 2px solid; }
.ber-q--right { border-color: rgba(40,167,69,0.3); }
.ber-q--wrong { border-color: rgba(220,53,69,0.3); }
.ber-q-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; flex-wrap: wrap; }
.ber-q-num { width: 30px; height: 30px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0; }
.ber-q-status { font-size: 14px; font-weight: 700; }
.ber-q-grade { margin-right: auto; font-size: 12px; background: rgba(247,151,30,0.12); color: #c07800; padding: 3px 10px; border-radius: 20px; font-weight: 600; }
.ber-q-text { font-size: 16px; font-weight: 600; color: var(--text-color,#2d3748); margin-bottom: 14px; line-height: 1.6; }
.ber-q-img { max-height: 180px; border-radius: 10px; margin-bottom: 14px; object-fit: contain; background: #f8f9fa; }

.ber-tf { display: flex; gap: 10px; flex-wrap: wrap; }
.ber-tf-item { display: flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: 20px; font-size: 14px; background: #f8f9fa; border: 1px solid #eee; }
.ber-mc { display: flex; flex-direction: column; gap: 8px; }
.ber-mc-item { display: flex; align-items: center; gap: 10px; padding: 10px 14px; border-radius: 12px; font-size: 14px; background: #f8f9fa; border: 1px solid #eee; }
.ber-correct { background: rgba(40,167,69,0.08) !important; border-color: rgba(40,167,69,0.3) !important; }
.ber-wrong { background: rgba(220,53,69,0.08) !important; border-color: rgba(220,53,69,0.3) !important; }
.ber-letter { width: 26px; height: 26px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 800; color: white; flex-shrink: 0; }
.ber-opt-a { background: #667eea; } .ber-opt-b { background: #f5576c; } .ber-opt-c { background: #f7971e; } .ber-opt-d { background: #43e97b; color: #005a1f; }
.ber-mc-text { flex: 1; color: #555; }
.ber-mark { color: #28a745; font-weight: 800; margin-right: auto; }
.ber-your { color: #dc3545; font-size: 12px; margin-right: auto; }

@keyframes berFade { from { opacity:0; transform:translateY(-20px); } to { opacity:1; transform:translateY(0); } }
@keyframes berFloat { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-10px); } }
@keyframes berSlideUp { from { opacity:0; transform:translateY(30px); } to { opacity:1; transform:translateY(0); } }
</style>
@endsection
