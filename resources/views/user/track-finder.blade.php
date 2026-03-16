{{-- resources/views/user/track-finder.blade.php --}}
{{-- User is already registered. Route: /track-finder/{user} --}}
@extends('layouts.front')

@section('title', 'كيف تعرف حقلك - خليليو')

@section('content')
<div class="tf-wrapper">

    {{-- Header --}}
    <div class="tf-header">
        <a href="{{ route('hub') }}" class="tf-back">← العودة</a>
        <div class="tf-badge">🧭 حقلك الدراسي</div>
        <h1 class="tf-title">كيف تعرف حقلك؟</h1>
        <p class="tf-subtitle">أدخل علاماتك في مواد الصف العاشر واعرف أي حقل يناسبك</p>
    </div>

    {{-- Student welcome bar --}}
    <div class="tf-student-bar">
        <span class="tf-student-avatar">👤</span>
        <div class="tf-student-info">
            <span class="tf-student-name">{{ $user->name }}</span>
            <span class="tf-student-meta">{{ $user->school_name }} • جيل {{ $user->generation }}</span>
        </div>
        <span class="tf-student-step">الخطوة 2 من 3 ✏️</span>
    </div>

    {{-- Info boxes --}}
    <div class="tf-info-row">
        <div class="tf-info-box tf-info--purple">
            <span class="tf-info-icon">📋</span>
            <span>اجمع علامات <strong>10 مواد</strong></span>
        </div>
        <div class="tf-info-box tf-info--blue">
            <span class="tf-info-icon">⚡</span>
            <span>نتيجة <strong>فورية</strong> ودقيقة</span>
        </div>
        <div class="tf-info-box tf-info--green">
            <span class="tf-info-icon">🎯</span>
            <span>معتمد على <strong>معيار التنسيق</strong></span>
        </div>
    </div>

    <form method="POST"
          action="{{ route('track.calculate', $user->id) }}"
          class="tf-form"
          id="tfForm">
        @csrf

        <div class="tf-subjects-grid">

            @php
            $subjects = [
                ['key'=>'islamic',   'icon'=>'☪️',  'label'=>'التربية الإسلامية',          'max'=>200, 'color'=>'#e8a838'],
                ['key'=>'arabic',    'icon'=>'📚',  'label'=>'اللغة العربية',              'max'=>300, 'color'=>'#667eea'],
                ['key'=>'english',   'icon'=>'🇬🇧',  'label'=>'اللغة الإنجليزية',           'max'=>200, 'color'=>'#4facfe'],
                ['key'=>'math',      'icon'=>'📐',  'label'=>'الرياضيات',                  'max'=>200, 'color'=>'#f5576c'],
                ['key'=>'social',    'icon'=>'🏛️',  'label'=>'الدراسات الاجتماعية',        'max'=>200, 'color'=>'#43e97b'],
                ['key'=>'science',   'icon'=>'🔬',  'label'=>'العلوم',                     'max'=>400, 'color'=>'#0ba360'],
                ['key'=>'arts',      'icon'=>'🎨',  'label'=>'التربية الفنية والموسيقية',   'max'=>100, 'color'=>'#fc5c7d'],
                ['key'=>'pe',        'icon'=>'⚽',  'label'=>'التربية الرياضية',            'max'=>100, 'color'=>'#ff9a44'],
                ['key'=>'digital',   'icon'=>'💻',  'label'=>'المهارات الرقمية',            'max'=>100, 'color'=>'#6a82fb'],
                ['key'=>'financial', 'icon'=>'💰',  'label'=>'الثقافة المالية',             'max'=>100, 'color'=>'#11998e'],
            ];
            @endphp

            @foreach($subjects as $s)
            <div class="tf-subject-card" style="--accent: {{ $s['color'] }}">
                <div class="tf-subject-header">
                    <span class="tf-subject-icon">{{ $s['icon'] }}</span>
                    <div class="tf-subject-meta">
                        <h3 class="tf-subject-name">{{ $s['label'] }}</h3>
                        <span class="tf-subject-max">من {{ $s['max'] }}</span>
                    </div>
                </div>
                <div class="tf-input-wrap">
                    <input
                        type="number"
                        name="{{ $s['key'] }}"
                        id="{{ $s['key'] }}"
                        min="0"
                        max="{{ $s['max'] }}"
                        value="{{ old($s['key']) }}"
                        placeholder="0"
                        class="tf-input"
                        required
                        oninput="updateBar(this, {{ $s['max'] }})"
                    >
                    <span class="tf-input-max">/{{ $s['max'] }}</span>
                </div>
                <div class="tf-progress-bar">
                    <div class="tf-progress-fill"
                         id="bar_{{ $s['key'] }}"
                         style="width: {{ old($s['key']) ? round((old($s['key'])/$s['max'])*100) : 0 }}%">
                    </div>
                </div>
                @error($s['key'])
                    <div class="tf-error">⚠️ {{ $message }}</div>
                @enderror
            </div>
            @endforeach

        </div>

        {{-- Live total --}}
        <div class="tf-total-bar">
            <div class="tf-total-inner">
                <span class="tf-total-label">المجموع الكلي</span>
                <span class="tf-total-value" id="liveTotal">0</span>
                <span class="tf-total-max">/ 1900</span>
                <div class="tf-total-percent" id="livePct">0%</div>
            </div>
        </div>

        <div class="tf-submit-wrap">
            <button type="submit" class="tf-submit-btn">
                <span class="tf-submit-icon">🧭</span>
                اعرف حقلك الآن
                <div class="tf-btn-shine"></div>
            </button>
        </div>
    </form>
</div>

<style>
.tf-wrapper { max-width: 980px; margin: 0 auto; }
.tf-header { text-align: center; margin-bottom: 22px; animation: fadeInDown 0.7s ease-out; position: relative; }
.tf-back { position: absolute; top: 0; right: 0; display: inline-flex; align-items: center; gap: 6px; color: var(--primary-color); text-decoration: none; font-size: 14px; font-weight: 600; padding: 7px 14px; border-radius: 20px; background: rgba(102,126,234,0.1); transition: all 0.2s ease; }
html[dir="rtl"] .tf-back { right: auto; left: 0; }
.tf-back:hover { background: rgba(102,126,234,0.2); color: var(--primary-color); text-decoration: none; }
.tf-badge { display: inline-block; background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 7px 18px; border-radius: 30px; font-size: 13px; font-weight: 600; margin-bottom: 14px; }
.tf-title { font-size: 34px; font-weight: 800; color: var(--text-color); margin-bottom: 8px; }
.tf-subtitle { color: #666; font-size: 16px; }

/* Student bar */
.tf-student-bar { display: flex; align-items: center; gap: 14px; background: rgba(255,255,255,0.95); border: 2px solid rgba(102,126,234,0.25); border-radius: 16px; padding: 13px 18px; margin-bottom: 20px; animation: fadeInUp 0.6s ease-out 0.1s both; box-shadow: 0 4px 15px rgba(102,126,234,0.08); }
.tf-student-avatar { font-size: 26px; }
.tf-student-info { flex: 1; }
.tf-student-name { display: block; font-size: 15px; font-weight: 700; color: var(--text-color); }
.tf-student-meta { display: block; font-size: 12px; color: #888; margin-top: 2px; }
.tf-student-step { font-size: 13px; font-weight: 600; color: var(--primary-color); white-space: nowrap; }

/* Info row */
.tf-info-row { display: flex; gap: 14px; margin-bottom: 24px; flex-wrap: wrap; }
.tf-info-box { flex: 1; min-width: 160px; display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 500; }
.tf-info--purple { background: rgba(102,126,234,0.1); color: #5563c1; }
.tf-info--blue   { background: rgba(79,172,254,0.1);  color: #2980b9; }
.tf-info--green  { background: rgba(67,233,123,0.1);  color: #0ba360; }
.tf-info-icon { font-size: 20px; }

/* Subjects grid */
.tf-subjects-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 24px; }
.tf-subject-card { background: rgba(255,255,255,0.96); border: 2px solid rgba(0,0,0,0.06); border-radius: 16px; padding: 18px; transition: all 0.3s ease; position: relative; overflow: hidden; }
.tf-subject-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; background: var(--accent); border-radius: 16px 16px 0 0; }
.tf-subject-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(0,0,0,0.09); border-color: var(--accent); }
.tf-subject-header { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.tf-subject-icon { font-size: 26px; width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.04); border-radius: 10px; }
.tf-subject-meta { flex: 1; }
.tf-subject-name { font-size: 14px; font-weight: 700; color: var(--text-color); margin: 0 0 3px; }
.tf-subject-max { font-size: 11px; color: #888; font-weight: 600; background: rgba(0,0,0,0.05); padding: 2px 8px; border-radius: 10px; }
.tf-input-wrap { position: relative; display: flex; align-items: center; margin-bottom: 8px; }
.tf-input { width: 100%; padding: 12px 55px 12px 14px; border: 2px solid var(--border-color); border-radius: 10px; font-size: 20px; font-weight: 700; text-align: center; font-family: inherit; transition: all 0.3s ease; background: white; box-sizing: border-box; color: var(--accent); }
.tf-input:focus { outline: none; border-color: var(--accent); box-shadow: 0 0 0 3px rgba(0,0,0,0.05); }
.tf-input-max { position: absolute; left: 12px; color: #aaa; font-size: 13px; font-weight: 600; pointer-events: none; }
html[dir="rtl"] .tf-input-max { left: auto; right: 12px; }
html[dir="rtl"] .tf-input { padding: 12px 14px 12px 55px; }
.tf-progress-bar { height: 5px; background: #eee; border-radius: 4px; overflow: hidden; }
.tf-progress-fill { height: 100%; background: var(--accent); border-radius: 4px; transition: width 0.4s ease; }
.tf-error { color: var(--danger-color); font-size: 12px; margin-top: 5px; }

/* Total bar */
.tf-total-bar { background: linear-gradient(135deg, #667eea, #764ba2); border-radius: 16px; padding: 18px 24px; margin-bottom: 24px; box-shadow: 0 10px 28px rgba(102,126,234,0.32); }
.tf-total-inner { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; }
.tf-total-label { color: rgba(255,255,255,0.85); font-size: 15px; font-weight: 600; flex: 1; }
.tf-total-value { font-size: 38px; font-weight: 800; color: white; line-height: 1; }
.tf-total-max { font-size: 18px; color: rgba(255,255,255,0.7); font-weight: 600; }
.tf-total-percent { background: rgba(255,255,255,0.2); color: white; padding: 5px 14px; border-radius: 20px; font-size: 15px; font-weight: 700; }

/* Submit */
.tf-submit-wrap { text-align: center; }
.tf-submit-btn { display: inline-flex; align-items: center; gap: 12px; padding: 18px 56px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border: none; border-radius: 50px; font-size: 19px; font-weight: 700; font-family: inherit; cursor: pointer; transition: all 0.35s ease; position: relative; overflow: hidden; box-shadow: 0 12px 35px rgba(102,126,234,0.4); }
.tf-submit-btn:hover { transform: translateY(-4px); box-shadow: 0 20px 50px rgba(102,126,234,0.5); }
.tf-submit-icon { font-size: 22px; }
.tf-btn-shine { position: absolute; top:0; left:-100%; width:60%; height:100%; background: linear-gradient(105deg,transparent 40%,rgba(255,255,255,0.2) 50%,transparent 60%); transition: left 0.5s ease; }
.tf-submit-btn:hover .tf-btn-shine { left: 150%; }

@keyframes fadeInDown { from { transform: translateY(-22px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fadeInUp { from { transform: translateY(22px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

@media (max-width: 768px) {
    .tf-subjects-grid { grid-template-columns: 1fr; }
    .tf-title { font-size: 24px; }
    .tf-submit-btn { width: 100%; justify-content: center; }
    .tf-back { position: static; margin-bottom: 14px; }
}
</style>

<script>
const maxValues = {
    islamic: 200, arabic: 300, english: 200, math: 200,
    social: 200, science: 400, arts: 100, pe: 100, digital: 100, financial: 100
};

function updateBar(input, max) {
    const val = Math.min(Math.max(parseInt(input.value) || 0, 0), max);
    const pct = (val / max) * 100;
    const bar = document.getElementById('bar_' + input.name);
    if (bar) bar.style.width = pct + '%';
    updateTotal();
}

function updateTotal() {
    let total = 0;
    Object.keys(maxValues).forEach(key => {
        const el = document.getElementById(key);
        if (el) total += Math.min(parseInt(el.value) || 0, maxValues[key]);
    });
    document.getElementById('liveTotal').textContent = total;
    const pct = ((total / 1900) * 100).toFixed(1);
    document.getElementById('livePct').textContent = pct + '%';
}

document.querySelectorAll('.tf-input').forEach(input => {
    input.addEventListener('input', () => {
        const max = parseInt(input.getAttribute('max'));
        if (parseInt(input.value) > max) input.value = max;
        if (parseInt(input.value) < 0 || input.value === '') input.value = '';
    });
});

updateTotal();
</script>
@endsection
