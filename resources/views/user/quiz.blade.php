{{-- resources/views/user/quiz.blade.php --}}
{{-- User is already registered. Route: /quiz/{user} --}}
@extends('layouts.front')

@section('title', 'امتحان الرياضيات - خليليو')

@section('content')
    <div class="qz-wrapper">

        <div class="qz-header">
            <a href="{{ route('hub.home') }}" class="qz-back">← {{ __('messages.back') }}</a>
            <div class="qz-icon">🧮</div>
            <h1 class="qz-title">{{ __('messages.card_math_title') }}</h1>
            <p class="qz-subtitle">{{ __('messages.quiz_landing_subtitle') }}</p>
        </div>

        {{-- Student welcome bar --}}
        <div class="qz-student-bar">
            <span class="qz-student-avatar">👤</span>
            <div class="qz-student-info">
                <span class="qz-student-name">{{ $user->name }}</span>
                <span class="qz-student-meta">{{ $user->school_name }} • جيل {{ $user->generation }}</span>
            </div>
            <span class="qz-student-ready">{{ __('messages.ready_for_quiz') }}</span>
        </div>

        @if ($quiz)

            {{-- Quiz info card --}}
            <div class="qz-info-card">
                <div class="qz-info-header">
                    <h2 class="qz-info-name">{{ $quiz->name }}</h2>
                    @if ($quiz->description)
                        <p class="qz-info-desc">{{ $quiz->description }}</p>
                    @endif
                </div>
                <div class="qz-info-stats">
                    <div class="qz-stat">
                        <span class="qz-stat-icon">⏱️</span>
                        <span class="qz-stat-val">{{ $quiz->duration_minutes }}</span>

                        <span class="qz-stat-label">{{ __('messages.minute') }}</span>
                    </div>
                    <div class="qz-stat">
                        <span class="qz-stat-icon">❓</span>
                        <span class="qz-stat-val">{{ $quiz->questions->count() }}</span>
                        <span class="qz-stat-label">{{ __('messages.question_label') }}</span>

                    </div>
                    <div class="qz-stat">
                        <span class="qz-stat-icon">🎯</span>
                        <span class="qz-stat-val">30</span>
                        <span class="qz-stat-label">{{ __('messages.grades') }}</span>
                    </div>
                </div>
            </div>


            {{-- Start form — no name input needed, user is registered --}}
            <div class="qz-start-card">
                <form method="POST" action="{{ route('quiz.start', $quiz->id) }}">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">

                    <div class="qz-start-ready">
                        <div class="qz-start-check">✅</div>
                        <p>{{ __('messages.data_registered_start') }}</p>

                    </div>

                    <div class="qz-start-rules">
                        <div class="qz-rule"><span>⏱️</span>
                            <span>{{ str_replace(':minutes', $quiz->duration_minutes, __('messages.rule_time')) }}</span>
                        </div>
                        <div class="qz-rule"><span>📵</span> <span>{{ __('messages.rule_no_back') }}</span></div>
                        <div class="qz-rule"><span>📤</span> <span>{{ __('messages.rule_auto_submit') }}</span></div>
                    </div>

                    <div class="qz-form-check">
                        <label class="qz-check-label">
                            <input type="checkbox" required>
                            <span>{{ __('messages.agree_rules') }}</span>

                        </label>
                    </div>
                    <button type="submit" class="qz-start-btn">
                        <span class="qz-start-icon">🚀</span>
                        {{ __('messages.start_quiz_now') }}
                    </button>
                </form>
            </div>
        @else
            <div class="qz-empty">
                <div class="qz-empty-icon">🔜</div>
                <h3>{{ __('messages.no_quiz_now') }}</h3>
                <p>{{ __('messages.quiz_coming') }}</p>
                <a href="https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r" target="_blank" class="qz-wa-btn">📱
                    {{ __('messages.join_channel') }}</a>
            </div>
        @endif

    </div>

    <style>
        .qz-wrapper {
            max-width: 800px;
            margin: 0 auto;
        }

        .qz-header {
            text-align: center;
            margin-bottom: 24px;
            animation: fadeInDown 0.7s ease-out;
            position: relative;
        }

        .qz-back {
            position: absolute;
            top: 0;
            right: 0;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: var(--primary-color);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 7px 14px;
            border-radius: 20px;
            background: rgba(102, 126, 234, 0.1);
            transition: all 0.2s ease;
        }

        html[dir="rtl"] .qz-back {
            right: auto;
            left: 0;
        }

        .qz-back:hover {
            background: rgba(102, 126, 234, 0.2);
            color: var(--primary-color);
            text-decoration: none;
        }

        .qz-icon {
            font-size: 56px;
            display: block;
            margin-bottom: 10px;
            animation: float 3s ease-in-out infinite;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .qz-title {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-color);
            margin-bottom: 8px;
        }

        .qz-subtitle {
            color: #666;
            font-size: 15px;
        }

        /* Student bar */
        .qz-student-bar {
            display: flex;
            align-items: center;
            gap: 14px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid rgba(79, 172, 254, 0.3);
            border-radius: 16px;
            padding: 14px 20px;
            margin-bottom: 22px;
            animation: fadeInUp 0.6s ease-out 0.1s both;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.1);
        }

        .qz-student-avatar {
            font-size: 28px;
        }

        .qz-student-info {
            flex: 1;
        }

        .qz-student-name {
            display: block;
            font-size: 16px;
            font-weight: 700;
            color: var(--text-color);
        }

        .qz-student-meta {
            display: block;
            font-size: 12px;
            color: #888;
            margin-top: 2px;
        }

        .qz-student-ready {
            font-size: 13px;
            font-weight: 600;
            color: #28a745;
            white-space: nowrap;
        }

        /* Info card */
        .qz-info-card {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 20px;
            color: white;
            box-shadow: 0 12px 35px rgba(245, 87, 108, 0.35);
            animation: fadeInUp 0.6s ease-out 0.15s both;
        }

        .qz-info-name {
            font-size: 20px;
            font-weight: 800;
            margin-bottom: 6px;
        }

        .qz-info-desc {
            opacity: .9;
            font-size: 14px;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .qz-info-stats {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .qz-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: rgba(255, 255, 255, 0.2);
            padding: 12px 16px;
            border-radius: 12px;
            flex: 1;
            min-width: 70px;
        }

        .qz-stat-icon {
            font-size: 20px;
            margin-bottom: 4px;
        }

        .qz-stat-val {
            font-size: 24px;
            font-weight: 800;
            line-height: 1;
        }

        .qz-stat-label {
            font-size: 12px;
            opacity: .85;
            margin-top: 3px;
        }

        /* Groups */
        .qz-groups {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 18px;
            padding: 22px;
            margin-bottom: 20px;
            animation: fadeInUp 0.6s ease-out 0.2s both;
        }

        .qz-groups-title {
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 16px;
            color: var(--text-color);
        }

        .qz-groups-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
        }

        .qz-group {
            border-radius: 12px;
            padding: 16px 10px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .qz-group:hover {
            transform: translateY(-3px);
        }

        .qz-group--a {
            background: linear-gradient(135deg, #f7971e, #ffd200);
            color: #2d1600;
        }

        .qz-group--b {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            color: #003366;
        }

        .qz-group--c {
            background: linear-gradient(135deg, #a8edea, #fed6e3);
            color: #333;
        }

        .qz-group-icon {
            font-size: 24px;
            margin-bottom: 6px;
        }

        .qz-group-name {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .qz-group-range {
            font-size: 12px;
            font-weight: 600;
            opacity: .85;
            margin-bottom: 3px;
        }

        .qz-group-desc {
            font-size: 11px;
            opacity: .75;
        }

        /* Start card */
        .qz-start-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 18px;
            padding: 26px;
            animation: fadeInUp 0.6s ease-out 0.25s both;
        }

        .qz-start-ready {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(40, 167, 69, 0.07);
            border: 1px solid rgba(40, 167, 69, 0.2);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 18px;
        }

        .qz-start-check {
            font-size: 24px;
        }

        .qz-start-ready p {
            margin: 0;
            font-size: 15px;
            font-weight: 600;
            color: #28a745;
        }

        .qz-start-rules {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 20px;
        }

        .qz-rule {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: #555;
        }

        .qz-rule span:first-child {
            font-size: 18px;
            width: 24px;
            text-align: center;
            flex-shrink: 0;
        }

        .qz-form-check {
            margin-bottom: 20px;
        }

        .qz-check-label {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 14px;
            color: #555;
            cursor: pointer;
            line-height: 1.5;
        }

        .qz-check-label input {
            margin-top: 3px;
            accent-color: #f5576c;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .qz-start-btn {
            width: 100%;
            padding: 17px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 8px 25px rgba(245, 87, 108, 0.35);
        }

        .qz-start-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 35px rgba(245, 87, 108, 0.45);
        }

        .qz-start-icon {
            font-size: 22px;
        }

        /* Empty */
        .qz-empty {
            text-align: center;
            padding: 50px 20px;
        }

        .qz-empty-icon {
            font-size: 60px;
            margin-bottom: 16px;
            display: block;
        }

        .qz-empty h3 {
            font-size: 20px;
            color: var(--text-color);
            margin-bottom: 8px;
        }

        .qz-empty p {
            color: #666;
            margin-bottom: 18px;
        }

        .qz-wa-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: #25D366;
            color: white;
            border-radius: 30px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
        }

        .qz-wa-btn:hover {
            color: white;
            text-decoration: none;
        }

        @keyframes fadeInDown {
            from {
                transform: translateY(-22px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(22px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @media (max-width: 600px) {
            .qz-groups-grid {
                grid-template-columns: 1fr;
            }

            .qz-title {
                font-size: 22px;
            }

            .qz-back {
                position: static;
                margin-bottom: 14px;
            }
        }
    </style>
@endsection
