{{-- resources/views/user/bag-exam-start.blade.php --}}
@extends('layouts.front')

@section('title', $exam->title)

@section('content')
<div class="be-wrapper">

    <div class="be-header">
        <a href="{{ route('pdf-bag.subcategory', [$exam->subcategory->category->id, $exam->subcategory->id]) }}"
           class="ts-back">{{ app()->getLocale() === 'ar' ? '← العودة' : '→ Back' }}</a>
        <div class="be-icon">📝</div>
        <h1 class="be-title">{{ $exam->title }}</h1>
        @if($exam->description)
        <p class="be-subtitle">{{ $exam->description }}</p>
        @endif
    </div>

    {{-- Stats --}}
    <div class="be-stats">
        <div class="be-stat">
            <span class="be-stat-icon">⏱️</span>
            <span class="be-stat-val">{{ $exam->duration_minutes }}</span>
            <span class="be-stat-lbl">{{ app()->getLocale() === 'ar' ? 'دقيقة' : 'Minutes' }}</span>
        </div>
        <div class="be-stat">
            <span class="be-stat-icon">❓</span>
            <span class="be-stat-val">{{ $exam->questions()->count() }}</span>
            <span class="be-stat-lbl">{{ app()->getLocale() === 'ar' ? 'سؤال' : 'Questions' }}</span>
        </div>
        <div class="be-stat">
            <span class="be-stat-icon">⭐</span>
            <span class="be-stat-val">{{ $exam->total_marks }}</span>
            <span class="be-stat-lbl">{{ app()->getLocale() === 'ar' ? 'علامة' : 'Marks' }}</span>
        </div>
    </div>

    {{-- Start form --}}
    <div class="be-start-card">
        <h3 class="be-start-title">
            {{ app()->getLocale() === 'ar' ? 'أدخل بياناتك للبدء' : 'Enter your info to start' }}
        </h3>

        <form action="{{ route('bag-exam.take', $exam->id) }}" method="POST" class="be-form">
            @csrf
            @if($errors->any())
            <div class="be-error">
                @foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach
            </div>
            @endif

            <div class="be-field">
                <label>{{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }} *</label>
                <input type="text" name="student_name"
                       value="{{ old('student_name') }}"
                       placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: محمد أحمد' : 'e.g. John Doe' }}"
                       required>
            </div>
            <div class="be-field">
                <label>{{ app()->getLocale() === 'ar' ? 'رقم الهاتف (اختياري)' : 'Phone Number (optional)' }}</label>
                <input type="tel" name="student_phone"
                       value="{{ old('student_phone') }}"
                       placeholder="{{ app()->getLocale() === 'ar' ? 'مثال: 0791234567' : 'e.g. 0791234567' }}">
            </div>

            <button type="submit" class="be-btn-start">
                <span>🚀</span>
                {{ app()->getLocale() === 'ar' ? 'ابدأ الامتحان' : 'Start Exam' }}
            </button>
        </form>
    </div>

</div>

<style>
.be-wrapper { max-width: 600px; margin: 0 auto; padding-bottom: 60px; }

.be-header { text-align: center; margin-bottom: 28px; animation: beFadeDown 0.7s ease-out; }
.be-icon { font-size: 64px; display: block; margin-bottom: 12px; animation: beFloat 3s ease-in-out infinite; }
.be-title {
    font-size: 28px; font-weight: 800;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
    margin-bottom: 10px;
}
.be-subtitle { color: #666; font-size: 15px; line-height: 1.6; }

.be-stats { display: flex; gap: 16px; justify-content: center; margin-bottom: 32px; flex-wrap: wrap; }
.be-stat {
    display: flex; flex-direction: column; align-items: center; gap: 4px;
    background: rgba(255,255,255,0.95); border: 2px solid rgba(102,126,234,0.15);
    border-radius: 18px; padding: 18px 28px; min-width: 100px;
    animation: beCardIn 0.5s ease-out both;
}
.be-stat:nth-child(1) { animation-delay: 0.1s; }
.be-stat:nth-child(2) { animation-delay: 0.2s; }
.be-stat:nth-child(3) { animation-delay: 0.3s; }
.be-stat-icon { font-size: 28px; }
.be-stat-val { font-size: 26px; font-weight: 800; color: #667eea; line-height: 1; }
.be-stat-lbl { font-size: 13px; color: #888; font-weight: 500; }

.be-start-card {
    background: rgba(255,255,255,0.97); border-radius: 24px; padding: 36px;
    border: 2px solid rgba(102,126,234,0.1); box-shadow: 0 12px 40px rgba(102,126,234,0.08);
    animation: beCardIn 0.6s ease-out 0.4s both;
}
.be-start-title { font-size: 20px; font-weight: 700; color: var(--text-color,#2d3748); margin-bottom: 24px; text-align: center; }

.be-form { display: flex; flex-direction: column; gap: 18px; }
.be-field { display: flex; flex-direction: column; gap: 6px; }
.be-field label { font-size: 14px; font-weight: 600; color: #555; }
.be-field input {
    padding: 14px 18px; border: 2px solid rgba(102,126,234,0.2); border-radius: 14px;
    font-size: 16px; font-family: inherit; outline: none; transition: border-color 0.25s;
    background: white; color: var(--text-color,#2d3748);
}
.be-field input:focus { border-color: #667eea; }

.be-error { background: rgba(220,53,69,0.08); border: 1px solid rgba(220,53,69,0.2); border-radius: 10px; padding: 12px 16px; color: #dc3545; font-size: 14px; }
.be-error p { margin: 0; }

.be-btn-start {
    display: flex; align-items: center; justify-content: center; gap: 12px;
    padding: 18px; border: none; border-radius: 50px;
    background: linear-gradient(135deg, #667eea, #764ba2); color: white;
    font-size: 19px; font-weight: 700; font-family: inherit; cursor: pointer;
    transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(102,126,234,0.35);
    margin-top: 8px;
}
.be-btn-start:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(102,126,234,0.45); }

@keyframes beFadeDown { from { transform:translateY(-24px); opacity:0; } to { transform:translateY(0); opacity:1; } }
@keyframes beFloat { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-10px); } }
@keyframes beCardIn { from { transform:translateY(30px); opacity:0; } to { transform:translateY(0); opacity:1; } }

@media (max-width:600px) {
    .be-title { font-size: 22px; }
    .be-start-card { padding: 24px; }
    .be-stats { gap: 10px; }
    .be-stat { padding: 14px 18px; }
}
</style>
@endsection
