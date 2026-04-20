{{-- resources/views/user/bag-exam-take.blade.php --}}
@extends('layouts.front')

@section('title', $exam->title)

@section('content')
<div class="qt-wrapper">

    {{-- Sticky header --}}
    <div class="qt-sticky-bar">
        <div class="qt-sticky-inner">
            <div class="qt-quiz-name">
                📝 {{ $exam->title }}
                @if(isset($user) && $user)
                <span style="opacity:.75;font-size:12px;font-weight:500;margin-right:8px">— {{ $user->name }}</span>
                @endif
            </div>
            <div class="qt-timer" id="timer">
                <span class="qt-timer-icon">⏱️</span>
                <span id="timerDisplay">{{ str_pad($exam->duration_minutes, 2, '0', STR_PAD_LEFT) }}:00</span>
            </div>
            <div class="qt-progress-text">
                <span id="answeredCount">0</span> / {{ $questions->count() }}
            </div>
        </div>
        <div class="qt-progress-bar-full">
            <div class="qt-progress-bar-fill" id="progressBarFill" style="width:0%"></div>
        </div>
    </div>

    <form method="POST" action="{{ route('bag-exam.submit', $exam->id) }}" id="quizForm">
        @csrf
        <div class="qt-questions">
            @foreach($questions as $i => $question)
            <div class="qt-question-card" id="qCard{{ $question->id }}" data-answered="false"
                 style="animation-delay:{{ $i * 0.08 }}s">
                <div class="qt-q-number">
                    <span class="qt-q-num-badge">{{ $i + 1 }}</span>
                    <span class="qt-q-type">
                        {{ $question->type == 'true_false'
                            ? (app()->getLocale() === 'ar' ? 'صح / خطأ' : 'True / False')
                            : (app()->getLocale() === 'ar' ? 'اختيار متعدد' : 'Multiple Choice') }}
                    </span>
                    <span class="qt-q-grade">
                        ⭐ {{ $question->grade }} {{ app()->getLocale() === 'ar' ? 'علامة' : 'pt' }}
                    </span>
                </div>

                <div class="qt-q-text">{{ $question->question_text }}</div>

                @if($question->question_image)
                <div class="qt-q-image">
                    <img src="{{ asset('assets/admin/uploads/' . $question->question_image) }}" alt="">
                </div>
                @endif

                <div class="qt-options">
                    @if($question->type === 'true_false')
                        <label class="qt-option" for="q{{ $question->id }}_true">
                            <input type="radio" name="q_{{ $question->id }}" id="q{{ $question->id }}_true" value="true" onchange="markAnswered({{ $question->id }})">
                            <span class="qt-option-icon">✅</span>
                            <span class="qt-option-text">{{ app()->getLocale() === 'ar' ? 'صح' : 'True' }}</span>
                        </label>
                        <label class="qt-option" for="q{{ $question->id }}_false">
                            <input type="radio" name="q_{{ $question->id }}" id="q{{ $question->id }}_false" value="false" onchange="markAnswered({{ $question->id }})">
                            <span class="qt-option-icon">❌</span>
                            <span class="qt-option-text">{{ app()->getLocale() === 'ar' ? 'خطأ' : 'False' }}</span>
                        </label>
                    @else
                        @foreach(['A'=>$question->option_a,'B'=>$question->option_b,'C'=>$question->option_c,'D'=>$question->option_d] as $letter => $text)
                        @if($text)
                        <label class="qt-option" for="q{{ $question->id }}_{{ $letter }}">
                            <input type="radio" name="q_{{ $question->id }}" id="q{{ $question->id }}_{{ $letter }}" value="{{ $letter }}" onchange="markAnswered({{ $question->id }})">
                            <span class="qt-option-letter">{{ $letter }}</span>
                            <span class="qt-option-text">{{ $text }}</span>
                        </label>
                        @endif
                        @endforeach
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        {{-- Submit --}}
        <div class="qt-submit-section">
            <div class="qt-submit-info">
                <span id="finalAnswered">0</span> / {{ $questions->count() }}
                {{ app()->getLocale() === 'ar' ? 'سؤال تمت الإجابة عليه' : 'questions answered' }}
            </div>
            <button type="submit" class="qt-submit-btn" id="submitBtn" onclick="return confirmSubmit()">
                <span>📤</span>
                {{ app()->getLocale() === 'ar' ? 'تسليم الامتحان' : 'Submit Exam' }}
            </button>
        </div>
    </form>
</div>

<style>
.qt-wrapper { max-width: 800px; margin: 0 auto; }
.qt-sticky-bar {
    position: sticky; top: 0; z-index: 100;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 0 0 16px 16px; margin: -40px -40px 30px;
    box-shadow: 0 4px 20px rgba(102,126,234,0.35); overflow: hidden;
}
@media (max-width:768px) { .qt-sticky-bar { margin: -25px -25px 24px; } }
.qt-sticky-inner { display:flex; align-items:center; justify-content:space-between; padding:14px 20px; color:white; }
.qt-quiz-name { font-size:15px; font-weight:700; flex:1; }
.qt-timer { display:flex; align-items:center; gap:8px; font-size:22px; font-weight:800; background:rgba(255,255,255,0.2); padding:8px 16px; border-radius:20px; }
.qt-timer.urgent { animation: timerPulse 1s ease-in-out infinite; color:#ffeb3b; }
@keyframes timerPulse { 0%,100% { background:rgba(255,0,0,0.3); } 50% { background:rgba(255,0,0,0.6); } }
.qt-progress-text { font-size:14px; font-weight:600; opacity:0.9; }
.qt-progress-bar-full { height:5px; background:rgba(255,255,255,0.25); }
.qt-progress-bar-fill { height:100%; background:white; transition:width 0.4s ease; }
.qt-questions { display:flex; flex-direction:column; gap:20px; margin-bottom:30px; }
.qt-question-card {
    background:rgba(255,255,255,0.97); border-radius:18px; padding:24px;
    border:2px solid rgba(0,0,0,0.06); transition:all 0.3s ease;
    animation: cardIn 0.5s ease-out both;
}
.qt-question-card.answered { border-color:#667eea; background:rgba(102,126,234,0.04); }
@keyframes cardIn { from { transform:translateY(25px); opacity:0; } to { transform:translateY(0); opacity:1; } }
.qt-q-number { display:flex; align-items:center; gap:10px; margin-bottom:14px; flex-wrap:wrap; }
.qt-q-num-badge {
    display:inline-flex; align-items:center; justify-content:center;
    width:34px; height:34px; background:linear-gradient(135deg,#667eea,#764ba2);
    color:white; border-radius:50%; font-size:15px; font-weight:800;
    box-shadow:0 4px 12px rgba(102,126,234,0.3);
}
.qt-q-type { font-size:12px; color:#888; background:#f0f0f0; padding:3px 10px; border-radius:10px; }
.qt-q-grade { font-size:12px; color:#c07800; background:rgba(247,151,30,0.12); padding:3px 10px; border-radius:10px; font-weight:600; }
.qt-q-text { font-size:17px; font-weight:600; color:var(--text-color,#2d3748); margin-bottom:16px; line-height:1.6; }
.qt-q-image { margin-bottom:16px; border-radius:12px; overflow:hidden; }
.qt-q-image img { width:100%; max-height:280px; object-fit:contain; background:#f8f9fa; }
.qt-options { display:flex; flex-direction:column; gap:10px; }
.qt-option {
    display:flex; align-items:center; gap:12px;
    padding:14px 18px; border-radius:12px; cursor:pointer;
    border:2px solid var(--border-color,#e2e8f0); background:white;
    transition:all 0.2s ease; position:relative;
}
.qt-option:hover { border-color:#667eea; background:rgba(102,126,234,0.04); transform:translateX(-3px); }
html[dir="ltr"] .qt-option:hover { transform:translateX(3px); }
.qt-option input[type="radio"] { display:none; }
.qt-option:has(input:checked) { border-color:#667eea; background:rgba(102,126,234,0.08); }
.qt-option-letter {
    width:30px; height:30px; border-radius:50%; background:rgba(0,0,0,0.06);
    display:flex; align-items:center; justify-content:center; font-weight:700; font-size:14px; flex-shrink:0; transition:all 0.2s;
}
.qt-option:has(input:checked) .qt-option-letter { background:#667eea; color:white; }
.qt-option-icon { font-size:20px; flex-shrink:0; }
.qt-option-text { font-size:15px; color:var(--text-color,#2d3748); flex:1; }
.qt-submit-section {
    background:rgba(255,255,255,0.97); border-radius:20px; padding:28px;
    text-align:center; border:2px solid rgba(0,0,0,0.06);
    animation:fadeInUp 0.6s ease-out 0.5s both;
}
.qt-submit-info { font-size:16px; color:#666; margin-bottom:20px; }
.qt-submit-btn {
    display:inline-flex; align-items:center; gap:12px; padding:18px 50px;
    background:linear-gradient(135deg,#667eea,#764ba2); color:white; border:none;
    border-radius:50px; font-size:20px; font-weight:700; font-family:inherit;
    cursor:pointer; transition:all 0.3s ease; box-shadow:0 10px 30px rgba(102,126,234,0.35);
}
.qt-submit-btn:hover { transform:translateY(-3px); box-shadow:0 16px 40px rgba(102,126,234,0.45); }
@keyframes fadeInUp { from { transform:translateY(25px); opacity:0; } to { transform:translateY(0); opacity:1; } }
</style>

<script>
let totalSeconds = {{ $exam->duration_minutes * 60 }};
function startTimer() {
    const id = setInterval(() => {
        totalSeconds--;
        if (totalSeconds <= 0) {
            clearInterval(id);
            document.getElementById('quizForm').submit();
            return;
        }
        const m = Math.floor(totalSeconds / 60).toString().padStart(2,'0');
        const s = (totalSeconds % 60).toString().padStart(2,'0');
        document.getElementById('timerDisplay').textContent = `${m}:${s}`;
        if (totalSeconds < 120) document.getElementById('timer').classList.add('urgent');
    }, 1000);
}

let answeredSet = new Set();
function markAnswered(qId) {
    answeredSet.add(qId);
    document.getElementById('qCard' + qId).classList.add('answered');
    document.getElementById('answeredCount').textContent = answeredSet.size;
    document.getElementById('finalAnswered').textContent = answeredSet.size;
    const total = {{ $questions->count() }};
    document.getElementById('progressBarFill').style.width = (answeredSet.size / total * 100) + '%';
}

function confirmSubmit() {
    const total = {{ $questions->count() }};
    const answered = answeredSet.size;
    if (answered < total) {
        const msg = `{{ app()->getLocale() === 'ar' ? 'لم تجب على ' : 'You have ' }}` + (total - answered) + `{{ app()->getLocale() === 'ar' ? ' سؤال بعد. هل تريد التسليم؟' : ' unanswered questions. Submit anyway?' }}`;
        return confirm(msg);
    }
    return true;
}

startTimer();
</script>
@endsection
