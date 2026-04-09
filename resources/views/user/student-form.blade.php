{{-- resources/views/user/student-form.blade.php --}}
@extends('layouts.front')

@section('title', __('messages.student_registration'))

@section('content')

{{--
    $redirectTo is passed from the controller: 'average' | 'track' | 'quiz'
    Used to show context-aware header so the student knows WHY they're registering.
--}}
@php
    $redirectTo = $redirectTo ?? session('redirect_to', 'average');
   // @php block — replace hardcoded Arabic with __()
$contextMeta = match($redirectTo) {
    'track' => [
        'icon'     => '🧭',
        'color'    => '#667eea',
        'service'  => __('messages.service_track'),
        'subtitle' => __('messages.service_track_subtitle'),
        'step'     => __('messages.service_track_step'),
        'next'     => __('messages.service_track_next'),
    ],
    'quiz' => [
        'icon'     => '🧮',
        'color'    => '#f5576c',
        'service'  => __('messages.service_quiz'),
        'subtitle' => __('messages.service_quiz_subtitle'),
        'step'     => __('messages.service_quiz_step'),
        'next'     => __('messages.service_quiz_next'),
    ],
    default => [
        'icon'     => '📊',
        'color'    => '#4facfe',
        'service'  => __('messages.service_avg'),
        'subtitle' => __('messages.service_avg_subtitle'),
        'step'     => __('messages.service_avg_step'),
        'next'     => __('messages.service_avg_next'),
    ],
};
@endphp

<div class="form-container">


    {{-- Progress steps --}}
    <div class="sf-progress">
        <div class="sf-step sf-step--active">
            <div class="sf-step-circle">1</div>
         <span>{{ __('messages.your_data') }}</span>
        </div>
        <div class="sf-step-line"></div>
        <div class="sf-step">
            <div class="sf-step-circle">2</div>
            <span>{{ $contextMeta['next'] }}</span>
        </div>
        @if($redirectTo !== 'quiz')
        <div class="sf-step-line"></div>
        <div class="sf-step">
            <div class="sf-step-circle">3</div>
        <span>{{ __('messages.result') }}</span>

        </div>
        @endif
    </div>

    {{-- Header --}}
    <div class="form-header">
        <img src="{{ asset('assets_front/images/logo.jpeg') }}"
             alt="{{ __('messages.logo') }}"
             class="logo2">
        <br>
        <a href="{{ route('student.form') }}" class="site-title">أحمد خليليو</a>
        <h1 class="form-title">{{ __('messages.student_registration') }}</h1>
    </div>

    <form method="POST" action="{{ route('student.store') }}" class="student-form" id="studentForm">
        @csrf

        {{-- Pass redirect_to through the form --}}
        <input type="hidden" name="redirect_to" value="{{ $redirectTo }}">

        <div class="form-grid">

            {{-- Full Name --}}
            <div class="form-group form-group-full">
                <label for="name" class="form-label">
                    <span class="label-icon">👤</span>
                   {{ __('messages.full_name') }}
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="{{ old('name') }}"
                       class="form-input {{ $errors->has('name') ? 'input-error' : '' }}"
                       placeholder="{{ __('messages.full_name_placeholder') }}"
                       required>
                <div class="input-hint">
                    <span class="hint-icon">💡</span>
                    {{ __('messages.full_name_hint') }}
                </div>
                @error('name')
                    <div class="error-message"><span class="error-icon">⚠️</span>{{ $message }}</div>
                @enderror
            </div>

            {{-- Phone --}}
            <div class="form-group">
                <label for="phone" class="form-label">
                    <span class="label-icon">📱</span>
                   {{ __('messages.phone') }}
                </label>
                <input type="text"
                       id="phone"
                       name="phone"
                       value="{{ old('phone') }}"
                       class="form-input {{ $errors->has('phone') ? 'input-error' : '' }}"
                       placeholder="07XXXXXXXX"
                       maxlength="10"
                       required>
                <div class="input-hint">
                    <span class="hint-icon">💡</span>
                  {{ __('messages.phone_hint') }}
                </div>
                @error('phone')
                    <div class="error-message"><span class="error-icon">⚠️</span>{{ $message }}</div>
                @enderror
            </div>

            {{-- Generation --}}
            <div class="form-group">
                <label class="form-label">
                    <span class="label-icon">🎂</span>
                   {{ __('messages.generation_label') }}
                </label>
                <div class="generation-picker">
                    @foreach(['2008','2009','2010'] as $gen)
                    <label class="gen-option {{ old('generation') == $gen ? 'selected' : '' }}">
                        <input type="radio"
                               name="generation"
                               value="{{ $gen }}"
                               {{ old('generation') == $gen ? 'checked' : '' }}
                               required>
                        <span class="gen-label">
                            <span class="gen-year">{{ $gen }}</span>
                            <span class="gen-sub">جيل {{ $gen }}</span>
                        </span>
                    </label>
                    @endforeach
                </div>
                @error('generation')
                    <div class="error-message"><span class="error-icon">⚠️</span>{{ $message }}</div>
                @enderror
            </div>

            {{-- School --}}
            <div class="form-group form-group-full">
                <label for="school_name" class="form-label">
                    <span class="label-icon">🏫</span>
                    {{ __('messages.school_name') }}
                </label>
                <input type="text"
                       id="school_name"
                       name="school_name"
                       value="{{ old('school_name') }}"
                       class="form-input {{ $errors->has('school_name') ? 'input-error' : '' }}"
                       placeholder="{{ __('messages.enter_school_name') }}"
                       required>
                @error('school_name')
                    <div class="error-message"><span class="error-icon">⚠️</span>{{ $message }}</div>
                @enderror
            </div>

        </div>

        {{-- Submit --}}
        <div class="form-actions">
           <button type="submit" class="submit-btn" id="submitBtn" style="--btn-color: {{ $contextMeta['color'] }}">
    <span class="btn-icon">🚀</span>
    {{ __('messages.start_now') }}
    <div class="btn-ripple"></div>
</button>
            <div class="sf-login-link">
                {{ __('messages.have_account') }}
                <a href="{{ route('user.login') }}">{{ __('messages.login_btn') }}</a>
            </div>
        </div>
    </form>
</div>

<style>
.form-container { max-width: 620px; margin: 0 auto; }

/* Context banner */
.sf-context-banner {
    display: flex; align-items: center; gap: 14px;
    background: rgba(255,255,255,0.9);
    border: 2px solid var(--ctx-color);
    border-radius: 16px; padding: 14px 18px;
    margin-bottom: 24px; animation: fadeInDown 0.6s ease-out;
}
.sf-ctx-icon { font-size: 28px; }
.sf-ctx-text { flex: 1; }
.sf-ctx-service { display: block; font-size: 15px; font-weight: 700; color: var(--ctx-color); }
.sf-ctx-step { display: block; font-size: 12px; color: #888; margin-top: 2px; }
.sf-ctx-back { font-size: 13px; color: #999; text-decoration: none; padding: 6px 12px; border-radius: 20px; background: #f0f0f0; transition: all 0.2s ease; white-space: nowrap; }
.sf-ctx-back:hover { background: #e0e0e0; color: #555; text-decoration: none; }

/* Progress */
.sf-progress { display: flex; align-items: center; justify-content: center; gap: 12px; margin-bottom: 30px; animation: fadeInDown 0.6s ease-out 0.1s both; }
.sf-step { display: flex; flex-direction: column; align-items: center; gap: 5px; }
.sf-step-circle { width: 36px; height: 36px; border-radius: 50%; background: #e9ecef; color: #aaa; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; transition: all 0.3s ease; }
.sf-step--active .sf-step-circle { background: var(--primary-color); color: white; box-shadow: 0 4px 12px rgba(102,126,234,0.35); }
.sf-step span { font-size: 11px; color: #888; text-align: center; max-width: 70px; }
.sf-step--active span { color: var(--primary-color); font-weight: 600; }
.sf-step-line { width: 50px; height: 2px; background: #e9ecef; margin-top: -20px; }

/* Form */
.form-header { text-align: center; margin-bottom: 30px; }
.form-title { font-size: 28px; font-weight: 700; color: var(--text-color); margin-bottom: 8px; }
.form-subtitle { color: #666; font-size: 15px; }
.student-form { animation: slideInUp 0.8s ease-out 0.2s both; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 22px; margin-bottom: 28px; }
.form-group-full { grid-column: 1 / -1; }
.form-group { position: relative; }
.form-label { display: flex; align-items: center; gap: 8px; margin-bottom: 10px; color: var(--text-color); font-weight: 600; font-size: 15px; }
.label-icon { font-size: 17px; }
.form-input { width: 100%; padding: 14px 18px; border: 2px solid var(--border-color); border-radius: 12px; font-size: 15px; font-family: inherit; transition: all 0.3s ease; background: rgba(255,255,255,0.8); box-sizing: border-box; }
.form-input:focus { outline: none; border-color: var(--primary-color); box-shadow: 0 0 0 4px rgba(102,126,234,0.1); background: white; transform: translateY(-2px); }
.form-input.input-error { border-color: var(--danger-color); }
.input-hint { display: flex; align-items: center; gap: 5px; color: #888; font-size: 12px; margin-top: 6px; }
.hint-icon { font-size: 13px; }

/* Generation picker */
.generation-picker { display: flex; gap: 10px; }
.gen-option { flex: 1; cursor: pointer; position: relative; }
.gen-option input[type="radio"] { display: none; }
.gen-label { display: flex; flex-direction: column; align-items: center; padding: 16px 10px; border: 2px solid var(--border-color); border-radius: 12px; transition: all 0.3s ease; background: rgba(255,255,255,0.8); cursor: pointer; text-align: center; }
.gen-year { font-size: 22px; font-weight: 800; color: var(--primary-color); line-height: 1; }
.gen-sub { font-size: 11px; color: #888; margin-top: 3px; }
.gen-option input:checked + .gen-label,
.gen-option.selected .gen-label { border-color: var(--primary-color); background: linear-gradient(135deg, rgba(102,126,234,0.1), rgba(118,75,162,0.1)); box-shadow: 0 0 0 3px rgba(102,126,234,0.15); transform: translateY(-3px); }
.gen-label:hover { border-color: var(--primary-color); transform: translateY(-2px); }

/* Error */
.error-message { display: flex; align-items: center; gap: 5px; color: var(--danger-color); font-size: 13px; margin-top: 6px; }

/* Submit */
.form-actions { text-align: center; margin-top: 36px; }
.submit-btn {
    display: inline-flex; align-items: center; gap: 10px; padding: 18px 44px;
    background: var(--btn-color, var(--success-color));
    color: white; border: none; border-radius: 50px; font-size: 18px;
    font-weight: 600; font-family: inherit; cursor: pointer;
    transition: all 0.3s ease; position: relative; overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2); min-width: 250px;
}
.submit-btn:hover { transform: translateY(-3px); box-shadow: 0 14px 35px rgba(0,0,0,0.25); }
.btn-icon { font-size: 20px; }
.btn-ripple { position: absolute; top:0; left:-100%; width:100%; height:100%; background: linear-gradient(90deg,transparent,rgba(255,255,255,0.2),transparent); transition: left 0.6s ease; }
.submit-btn:hover .btn-ripple { left:100%; }

/* Login link */
.sf-login-link { margin-top: 16px; font-size: 14px; color: #888; }
.sf-login-link a { color: var(--primary-color); font-weight: 700; text-decoration: none; }
.sf-login-link a:hover { text-decoration: underline; }

@keyframes fadeInDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes slideInUp { from { transform: translateY(30px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

@media (max-width: 768px) {
    .form-grid { grid-template-columns: 1fr; gap: 18px; }
    .form-title { font-size: 22px; }
    .submit-btn { width: 100%; min-width: auto; }
    .generation-picker { gap: 7px; }
    .sf-progress { gap: 6px; }
    .sf-step-line { width: 24px; }
}
html[dir="rtl"] .form-label { flex-direction: row-reverse; }
html[dir="rtl"] .error-message { flex-direction: row-reverse; }
html[dir="rtl"] .input-hint { flex-direction: row-reverse; }
html[dir="rtl"] .sf-context-banner { flex-direction: row-reverse; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Phone: digits only, max 10
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
    }

    // Generation picker highlight
    document.querySelectorAll('.gen-option input[type="radio"]').forEach(function (radio) {
        radio.addEventListener('change', function () {
            document.querySelectorAll('.gen-option').forEach(o => o.classList.remove('selected'));
            this.closest('.gen-option').classList.add('selected');
        });
    });
});
</script>
@endsection
