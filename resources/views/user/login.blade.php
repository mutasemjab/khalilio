{{-- resources/views/user/login.blade.php --}}
@extends('layouts.front')

@section('title', __('messages.login_title') . ' - خليليو')

@section('content')

<div class="login-wrapper">

    <div class="login-header">
        <div class="login-icon">🔐</div>
        <h1 class="login-title">{{ __('messages.login_title') }}</h1>
        <p class="login-subtitle">{{ __('messages.login_subtitle') }}</p>
    </div>

    @if($errors->any())
        <div class="login-alert">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('user.login.post') }}" method="POST" class="login-form">
        @csrf

        <div class="login-field">
            <label for="phone">{{ __('messages.phone_label') }}</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone') }}"
                placeholder="{{ __('messages.phone_placeholder') }}"
                class="login-input {{ $errors->has('phone') ? 'is-error' : '' }}"
                autofocus
                required
            >
        </div>

        <button type="submit" class="login-btn">
            {{ __('messages.login_btn') }}
            <span class="login-btn-arrow">←</span>
        </button>

    </form>

    <div class="login-footer">
        <p>{{ __('messages.no_account') }}
            <a href="{{ route('student.form') }}">{{ __('messages.register_link') }}</a>
        </p>
    </div>

</div>

<style>
.login-wrapper {
    max-width: 440px;
    margin: 0 auto;
    padding-bottom: 40px;
}

.login-header {
    text-align: center;
    margin-bottom: 32px;
    animation: fadeInDown 0.6s ease-out;
}

.login-icon {
    font-size: 64px;
    display: block;
    margin-bottom: 14px;
    animation: bounceIn 0.8s cubic-bezier(.34,1.56,.64,1);
}

.login-title {
    font-size: 28px;
    font-weight: 800;
    background: linear-gradient(135deg, #667eea, #764ba2);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 8px;
}

.login-subtitle {
    color: #666;
    font-size: 15px;
    line-height: 1.6;
}

.login-alert {
    background: rgba(220, 53, 69, 0.08);
    border: 1px solid rgba(220, 53, 69, 0.25);
    color: #dc3545;
    border-radius: 12px;
    padding: 12px 18px;
    margin-bottom: 20px;
    font-size: 14px;
    font-weight: 600;
    animation: shake 0.4s ease-out;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    20%       { transform: translateX(-8px); }
    40%       { transform: translateX(8px); }
    60%       { transform: translateX(-4px); }
    80%       { transform: translateX(4px); }
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 20px;
    animation: fadeInUp 0.6s ease-out 0.2s both;
}

.login-field {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.login-field label {
    font-size: 14px;
    font-weight: 700;
    color: var(--text-color, #2d3748);
}

.login-input {
    width: 100%;
    padding: 14px 18px;
    border: 2px solid var(--border-color, #e9ecef);
    border-radius: 14px;
    font-size: 16px;
    font-family: inherit;
    background: rgba(255,255,255,0.9);
    color: var(--text-color, #2d3748);
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    direction: ltr;
    text-align: center;
    letter-spacing: 1px;
}

html[dir="rtl"] .login-input {
    direction: ltr;
}

.login-input:focus {
    outline: none;
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.15);
}

.login-input.is-error {
    border-color: #dc3545;
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.login-btn {
    width: 100%;
    padding: 15px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    border: none;
    border-radius: 14px;
    font-size: 16px;
    font-weight: 700;
    font-family: inherit;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(102, 126, 234, 0.35);
}

.login-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(102, 126, 234, 0.45);
}

.login-btn-arrow {
    font-size: 18px;
    transition: transform 0.3s ease;
}

html[dir="rtl"] .login-btn-arrow {
    transform: scaleX(-1);
}

.login-btn:hover .login-btn-arrow {
    transform: translateX(-4px);
}

html[dir="rtl"] .login-btn:hover .login-btn-arrow {
    transform: scaleX(-1) translateX(-4px);
}

.login-footer {
    text-align: center;
    margin-top: 24px;
    font-size: 14px;
    color: #888;
    animation: fadeInUp 0.6s ease-out 0.4s both;
}

.login-footer a {
    color: #667eea;
    font-weight: 700;
    text-decoration: none;
    transition: color 0.2s ease;
}

.login-footer a:hover {
    color: #764ba2;
    text-decoration: underline;
}

@keyframes fadeInDown {
    from { transform: translateY(-20px); opacity: 0; }
    to   { transform: translateY(0);     opacity: 1; }
}

@keyframes fadeInUp {
    from { transform: translateY(20px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

@keyframes bounceIn {
    from { transform: scale(0); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}
</style>

@endsection
