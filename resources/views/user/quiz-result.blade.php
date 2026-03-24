{{-- resources/views/user/quiz-result.blade.php --}}
@extends('layouts.front')

@section('title', __('messages.quiz_result_title'))

@section('content')

@php
    // ── SAFE ANSWERS DECODE ───────────────────────────────────
    // Fix for: count(): Argument #1 must be of type Countable|array, string given
    // The model cast handles new records, but this guards against old string records.
    $answers = $attempt->answers;
    if (is_string($answers)) {
        $answers = json_decode($answers, true) ?? [];
    }
    if (!is_array($answers)) {
        $answers = [];
    }
    $totalMarks = $attempt->total_marks ?? $attempt->total_questions ?? 30;
@endphp

<div class="qr-wrapper">

    @if($attempt->group === 'A')
    <div class="qr-confetti-container" id="confettiContainer"></div>
    @endif

    {{-- Header --}}
    <div class="qr-header">
        @if($attempt->group === 'A')
    <h1 class="qr-title">{{ __('messages.group_a_title') }}</h1>
@elseif($attempt->group === 'B')
    <h1 class="qr-title">{{ __('messages.group_b_title') }}</h1>
@else
    <h1 class="qr-title">{{ __('messages.group_c_title') }}</h1>
@endif
        <p class="qr-student-name">{{ $attempt->student_name }}</p>
    </div>

    {{-- Score card --}}
    <div class="qr-score-card qr-score--{{ strtolower($attempt->group) }}">
        <div class="qr-score-circle">
            <svg viewBox="0 0 140 140">
                <circle cx="70" cy="70" r="62" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="12"/>
                @php
                    $circumference = round(2 * 3.14159 * 62);
                    $offset = $totalMarks > 0
                        ? round($circumference * (1 - $attempt->score / $totalMarks))
                        : $circumference;
                @endphp
                <circle cx="70" cy="70" r="62" fill="none" stroke="white" stroke-width="12"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ $offset }}"
                    stroke-linecap="round" transform="rotate(-90 70 70)"
                    class="qr-ring"/>
            </svg>
            <div class="qr-score-inner">
                <div class="qr-score-num">{{ $attempt->score }}</div>
              <div class="qr-score-of">{{ __('messages.from_marks') }} {{ $totalMarks }}</div>

            </div>
        </div>
        <div class="qr-score-info">
           <div class="qr-group-badge">{{ __('messages.group_label') }} {{ $attempt->group }}</div>
            <div class="qr-score-pct">
                {{ $totalMarks > 0 ? round(($attempt->score / $totalMarks) * 100) : 0 }}%
            </div>
            <div class="qr-score-correct">
                {{ $attempt->score }} من {{ $totalMarks }} علامة
            </div>
            <div class="qr-score-questions">
                {{ $attempt->total_questions }} سؤال
            </div>
        </div>
    </div>

    {{-- Group description --}}
    <div class="qr-group-desc-card">
     @if($attempt->group === 'A')
    <h3>{{ __('messages.group_a_desc_title') }}</h3>
    <p>{{ __('messages.group_a_desc') }}</p>
@elseif($attempt->group === 'B')
    <h3>{{ __('messages.group_b_desc_title') }}</h3>
    <p>{{ __('messages.group_b_desc') }}</p>
@else
    <h3>{{ __('messages.group_c_desc_title') }}</h3>
    <p>{{ __('messages.group_c_desc') }}</p>
@endif
    </div>

    {{-- WhatsApp CTA --}}
    @php
    $waLink = 'https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r';
    if ($attempt->group === 'A' && $quiz->whatsapp_a) $waLink = $quiz->whatsapp_a;
    elseif ($attempt->group === 'B' && $quiz->whatsapp_b) $waLink = $quiz->whatsapp_b;
    elseif ($attempt->group === 'C' && $quiz->whatsapp_c) $waLink = $quiz->whatsapp_c;
    @endphp

    <div class="qr-wa-card">
        <div class="qr-wa-pulse"></div>
       
       <a href="{{ $waLink }}" class="qr-wa-btn">
    📱 {{ __('messages.join_group_btn') }} {{ $attempt->group }} {{ __('messages.now_label') }}
</a>
    </div>

    {{-- Answers review — SAFE with decoded array --}}
    @if(count($answers) > 0)
    <div class="qr-review">
        <h3 class="qr-review-title">{{ __('messages.answers_review') }}</h3>

        {{-- Summary row --}}
        <div class="qr-review-summary">
            @php
                $correctCount = collect($answers)->where('is_right', true)->count();
                $wrongCount   = collect($answers)->where('is_right', false)->count();
                $earnedMarks  = collect($answers)->sum('earned');
            @endphp
            <div class="qr-summary-item qr-summary--correct">
                <span class="qr-summary-icon">✅</span>
                <span class="qr-summary-num">{{ $correctCount }}</span>
                <span class="qr-summary-label">{{ __('messages.correct_answers') }}</span>

            </div>
            <div class="qr-summary-item qr-summary--wrong">
                <span class="qr-summary-icon">❌</span>
                <span class="qr-summary-num">{{ $wrongCount }}</span>
               <span class="qr-summary-label">{{ __('messages.wrong_answers') }}</span>

            </div>
            <div class="qr-summary-item qr-summary--marks">
                <span class="qr-summary-icon">⭐</span>
                <span class="qr-summary-num">{{ $earnedMarks }}</span>
               <span class="qr-summary-label">{{ __('messages.from_marks') }} {{ $totalMarks }}</span>

            </div>
        </div>

        <div class="qr-answers-grid">
            @foreach($answers as $qId => $ans)
            @php
                $isRight  = (bool)($ans['is_right'] ?? false);
                $grade    = $ans['grade']  ?? 1;
                $earned   = $ans['earned'] ?? ($isRight ? $grade : 0);
                $correct  = $ans['correct'] ?? '';
                $userAns  = $ans['user']    ?? '';
            @endphp
            <div class="qr-answer {{ $isRight ? 'correct' : 'wrong' }}">
                <div class="qr-answer-top">
                    <span class="qr-answer-icon">{{ $isRight ? '✅' : '❌' }}</span>
                    <span class="qr-answer-num">س{{ $loop->iteration }}</span>
                    <span class="qr-answer-marks">
                        {{ $earned }}/{{ $grade }}
                        <i class="fas fa-star" style="font-size:10px"></i>
                    </span>
                </div>
                @if(!$isRight && $correct)
                <div class="qr-answer-correct">
                    {{ app()->getLocale() == 'ar' ? 'الصواب:' : 'Correct:' }}
                    <strong>{{ $correct }}</strong>
                </div>
                @endif
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Actions --}}
    <div class="qr-actions">
        <a href="{{ route('quiz.index', ['user' => session('quiz_user_id', 1)]) }}"
           class="qr-btn qr-btn--secondary"> {{ __('messages.retake_quiz') }}</a>
        <a href="{{ route('hub') }}" class="qr-btn qr-btn--primary"> {{ __('messages.home_page') }}</a>
    </div>

</div>

<style>
.qr-wrapper { max-width: 750px; margin: 0 auto; position: relative; }

/* Confetti */
.qr-confetti-container { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 999; overflow: hidden; }
.confetti-piece { position: absolute; width: 10px; height: 10px; top: -10px; border-radius: 2px; animation: confettiFall linear forwards; }
@keyframes confettiFall { to { transform: translateY(110vh) rotate(720deg); opacity: 0; } }

/* Header */
.qr-header { text-align: center; margin-bottom: 26px; animation: fadeInDown 0.7s ease-out; }
.qr-hero-icon { font-size: 66px; display: block; margin-bottom: 10px; animation: heroBounce 1s cubic-bezier(.34,1.56,.64,1); }
@keyframes heroBounce { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.qr-title { font-size: 30px; font-weight: 800; color: var(--text-color); margin-bottom: 6px; }
.qr-student-name { font-size: 17px; color: #666; }

/* Score card */
.qr-score-card { border-radius: 20px; padding: 28px; margin-bottom: 22px; display: flex; align-items: center; gap: 26px; flex-wrap: wrap; box-shadow: 0 14px 40px rgba(0,0,0,0.2); animation: scaleIn 0.7s cubic-bezier(.34,1.56,.64,1) 0.2s both; color: white; }
@keyframes scaleIn { from { transform: scale(0.85); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.qr-score--a { background: linear-gradient(135deg, #f7971e, #ffd200); color: #2d1600; }
.qr-score--b { background: linear-gradient(135deg, #4facfe, #00f2fe); color: #003366; }
.qr-score--c { background: linear-gradient(135deg, #a8edea, #fed6e3); color: #333; }
.qr-score-circle { position: relative; width: 140px; height: 140px; flex-shrink: 0; }
.qr-score-circle svg { width: 100%; height: 100%; }
.qr-ring { transition: stroke-dashoffset 2s ease-out; }
.qr-score-inner { position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); text-align: center; }
.qr-score-num { font-size: 36px; font-weight: 900; line-height: 1; }
.qr-score-of { font-size: 13px; opacity: .8; }
.qr-score-info { flex: 1; }
.qr-group-badge { display: inline-block; padding: 7px 18px; border-radius: 20px; font-size: 18px; font-weight: 800; background: rgba(255,255,255,0.3); margin-bottom: 10px; }
.qr-score-pct { font-size: 42px; font-weight: 900; line-height: 1; margin-bottom: 6px; }
.qr-score-correct { font-size: 15px; opacity: .85; }
.qr-score-questions { font-size: 13px; opacity: .7; margin-top: 4px; }

/* Group desc */
.qr-group-desc-card { background: rgba(255,255,255,0.95); border-radius: 16px; padding: 22px; text-align: center; margin-bottom: 22px; animation: fadeInUp 0.6s ease-out 0.4s both; }
.qr-desc-icon { font-size: 40px; margin-bottom: 8px; }
.qr-group-desc-card h3 { font-size: 18px; font-weight: 700; color: var(--text-color); margin-bottom: 8px; }
.qr-group-desc-card p { color: #555; line-height: 1.6; font-size: 14px; margin: 0; }

/* WA card */
.qr-wa-card { background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 18px; padding: 24px; margin-bottom: 22px; box-shadow: 0 10px 32px rgba(37,211,102,0.35); position: relative; overflow: hidden; animation: fadeInUp 0.6s ease-out 0.5s both; }
.qr-wa-pulse { position: absolute; top: -20px; right: -20px; width: 110px; height: 110px; border-radius: 50%; background: rgba(255,255,255,0.1); animation: pulsate 3s ease-in-out infinite; }
@keyframes pulsate { 0%,100% { transform: scale(1); opacity: .3; } 50% { transform: scale(1.5); opacity: .1; } }
.qr-wa-content { display: flex; align-items: center; gap: 14px; margin-bottom: 16px; color: white; position: relative; z-index: 2; }
.qr-wa-icon { font-size: 38px; animation: bounce 2s ease-in-out infinite; }
.qr-wa-text h3 { font-size: 18px; font-weight: 800; margin-bottom: 4px; }
.qr-wa-text p { font-size: 13px; opacity: .9; margin: 0; }
.qr-wa-btn { display: flex; align-items: center; justify-content: center; gap: 10px; padding: 14px; background: white; color: #128C7E; border-radius: 12px; text-decoration: none; font-size: 17px; font-weight: 800; transition: all 0.3s ease; position: relative; z-index: 2; box-shadow: 0 4px 15px rgba(0,0,0,0.12); }
.qr-wa-btn:hover { transform: translateY(-2px) scale(1.01); color: #128C7E; text-decoration: none; }

/* Review */
.qr-review { background: rgba(255,255,255,0.95); border-radius: 16px; padding: 22px; margin-bottom: 22px; animation: fadeInUp 0.6s ease-out 0.6s both; }
.qr-review-title { font-size: 17px; font-weight: 700; color: var(--text-color); margin-bottom: 16px; text-align: center; }
.qr-review-summary { display: flex; gap: 12px; margin-bottom: 18px; flex-wrap: wrap; }
.qr-summary-item { flex: 1; min-width: 80px; display: flex; flex-direction: column; align-items: center; gap: 3px; padding: 12px; border-radius: 12px; }
.qr-summary--correct { background: rgba(40,167,69,0.08); border: 1px solid rgba(40,167,69,0.2); }
.qr-summary--wrong   { background: rgba(220,53,69,0.08); border: 1px solid rgba(220,53,69,0.2); }
.qr-summary--marks   { background: rgba(247,151,30,0.08); border: 1px solid rgba(247,151,30,0.2); }
.qr-summary-icon { font-size: 18px; }
.qr-summary-num { font-size: 24px; font-weight: 800; color: var(--text-color); line-height: 1; }
.qr-summary-label { font-size: 12px; color: #888; }
.qr-answers-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(110px, 1fr)); gap: 8px; }
.qr-answer { border-radius: 10px; padding: 10px 12px; font-size: 13px; font-weight: 600; }
.qr-answer.correct { background: rgba(40,167,69,0.08); color: #28a745; border: 1px solid rgba(40,167,69,0.2); }
.qr-answer.wrong    { background: rgba(220,53,69,0.08); color: #dc3545; border: 1px solid rgba(220,53,69,0.15); }
.qr-answer-top { display: flex; align-items: center; gap: 5px; margin-bottom: 4px; }
.qr-answer-icon { font-size: 14px; }
.qr-answer-num { flex: 1; }
.qr-answer-marks { font-size: 11px; font-weight: 700; background: rgba(0,0,0,0.06); padding: 1px 6px; border-radius: 10px; white-space: nowrap; }
.qr-answer-correct { font-size: 11px; opacity: 0.8; margin-top: 2px; }

/* Actions */
.qr-actions { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; animation: fadeInUp 0.6s ease-out 0.7s both; }
.qr-btn { display: inline-flex; align-items: center; gap: 8px; padding: 13px 26px; border-radius: 30px; text-decoration: none; font-size: 15px; font-weight: 600; transition: all 0.3s ease; }
.qr-btn--primary { background: linear-gradient(135deg, #667eea, #764ba2); color: white; box-shadow: 0 6px 18px rgba(102,126,234,0.3); }
.qr-btn--secondary { background: rgba(255,255,255,0.9); color: var(--text-color); border: 2px solid var(--border-color); }
.qr-btn:hover { transform: translateY(-2px); color: inherit; text-decoration: none; }
.qr-btn--primary:hover { color: white; }

@keyframes fadeInDown { from { transform: translateY(-22px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fadeInUp { from { transform: translateY(22px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes bounce { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-7px); } }

@media (max-width: 600px) {
    .qr-score-card { flex-direction: column; text-align: center; }
    .qr-wa-content { flex-direction: column; text-align: center; }
    .qr-actions { flex-direction: column; align-items: center; }
    .qr-btn { width: 100%; max-width: 280px; justify-content: center; }
    .qr-answers-grid { grid-template-columns: repeat(3,1fr); }
}
</style>

<script>
@if($attempt->group === 'A')
(function() {
    const colors = ['#f7971e','#ffd200','#ff6b6b','#4facfe','#43e97b','#a8edea','#667eea'];
    for (let i = 0; i < 80; i++) {
        const el = document.createElement('div');
        el.classList.add('confetti-piece');
        el.style.cssText = `
            left:${Math.random()*100}%;
            background:${colors[Math.floor(Math.random()*colors.length)]};
            width:${6+Math.random()*10}px;height:${6+Math.random()*10}px;
            border-radius:${Math.random()>.5?'50%':'2px'};
            animation-duration:${2+Math.random()*3}s;
            animation-delay:${Math.random()*2}s;
        `;
        document.getElementById('confettiContainer').appendChild(el);
    }
})();
@endif
</script>
@endsection
