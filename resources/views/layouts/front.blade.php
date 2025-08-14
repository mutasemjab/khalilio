{{-- resources/views/layouts/front.blade.php --}}
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', __('messages.student_system'))</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700&family=Inter:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --accent-color: #ffd700;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
            --text-color: #333;
            --border-color: #e9ecef;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: {{ app()->getLocale() == 'ar' ? "'Cairo', sans-serif" : "'Inter', sans-serif" }};
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            min-height: 100vh;
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Breaking News Bar */
        .breaking-news {
            background: linear-gradient(45deg, #ff6b6b, #ee5a24, #ff9ff3, #ff6b6b);
            background-size: 400% 400%;
            animation: gradientShift 4s ease infinite;
            color: white;
            padding: 12px 0;
            position: relative;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            border-bottom: 3px solid rgba(255, 255, 255, 0.3);
        }

        .breaking-news::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: shimmer 3s infinite;
        }

        .breaking-news::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 50%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
            animation: sparkleMove 6s ease-in-out infinite;
        }

        .breaking-news-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            gap: 15px;
            position: relative;
            z-index: 2;
        }

        .breaking-badge-section {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-shrink: 0;
        }

        .breaking-badge {
            background: rgba(255, 255, 255, 0.25);
            padding: 6px 16px;
            border-radius: 20px;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
            animation: pulse 2s infinite;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .breaking-icon {
            font-size: 18px;
            animation: bounce 2s infinite;
        }

        .breaking-content {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        .breaking-text-wrapper {
            animation: scrollText 20s linear infinite;
            white-space: nowrap;
        }

        .breaking-text {
            font-size: 24px;
            font-weight: 600;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.3);
            line-height: 1.4;
            display: inline-block;
            padding-right: 50px;
        }

        .breaking-action {
            flex-shrink: 0;
        }

        .whatsapp-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #25D366;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(37, 211, 102, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .whatsapp-btn:hover {
            background: #128C7E;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.4);
            color: white;
            text-decoration: none;
        }

        .whatsapp-icon {
            font-size: 14px;
            animation: phoneRing 1.5s ease-in-out infinite;
        }

        /* Animations */
        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        @keyframes sparkleMove {

            0%,
            100% {
                opacity: 0.3;
                transform: translateX(0);
            }

            50% {
                opacity: 0.7;
                transform: translateX(20px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes bounce {

            0%,
            20%,
            53%,
            80%,
            100% {
                transform: translateY(0);
            }

            40%,
            43% {
                transform: translateY(-8px);
            }

            70% {
                transform: translateY(-4px);
            }

            90% {
                transform: translateY(-2px);
            }
        }

        @keyframes scrollText {
            0% {
                transform: translateX(100%);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        @keyframes phoneRing {

            0%,
            100% {
                transform: rotate(0deg);
            }

            25% {
                transform: rotate(-10deg);
            }

            75% {
                transform: rotate(10deg);
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .breaking-news-container {
                flex-direction: column;
                gap: 10px;
                padding: 0 15px;
            }

            .breaking-content {
                order: 2;
                width: 100%;
            }

            .breaking-action {
                order: 3;
            }

            .breaking-badge-section {
                order: 1;
            }

            .breaking-text {
                font-size: 24px;
            }

            .breaking-text-wrapper {
                animation-duration: 25s;
                /* Slower on mobile */
            }

            .whatsapp-btn {
                font-size: 11px;
                padding: 6px 12px;
            }
        }

        @media (max-width: 480px) {
            .breaking-news {
                padding: 8px 0;
            }

            .breaking-text {
                font-size: 22px;
            }

            .breaking-badge {
                font-size: 10px;
                padding: 4px 12px;
            }
        }

        /* RTL Support */
        html[dir="rtl"] .breaking-text-wrapper {
            animation-name: scrollTextRTL;
        }

        @keyframes scrollTextRTL {
            0% {
                transform: translateX(-100%);
            }

            100% {
                transform: translateX(100%);
            }
        }

        html[dir="rtl"] .breaking-news-container {
            direction: rtl;
        }

        html[dir="rtl"] .breaking-text {
            padding-right: 0;
            padding-left: 50px;
        }

        /* Pause animation on hover */
        .breaking-news:hover .breaking-text-wrapper {
            animation-play-state: paused;
        }

        /* Accessibility */
        @media (prefers-reduced-motion: reduce) {
            .breaking-text-wrapper {
                animation: none;
                white-space: normal;
            }

            .breaking-badge,
            .breaking-icon,
            .whatsapp-icon {
                animation: none;
            }
        }

        /* High contrast mode */
        @media (prefers-contrast: high) {
            .breaking-news {
                background: #000;
                border-bottom-color: #fff;
            }

            .breaking-badge {
                background: #fff;
                color: #000;
            }

            .whatsapp-btn {
                border: 2px solid #fff;
            }
        }



        /* Header */
        .header {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 15px 0;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 1000;
            border-bottom: 3px solid var(--accent-color);
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }
      
        .logo2 {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: var(--shadow);
            transition: transform 0.3s ease;
        }

        .logo:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .site-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--primary-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .site-title:hover {
            color: var(--secondary-color);
        }

        /* Language Switcher */
        .lang-switcher {
            display: flex;
            gap: 10px;
        }

        .lang-btn {
            padding: 8px 15px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .lang-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .lang-btn:hover::before {
            left: 100%;
        }

        .lang-btn.active {
            background: var(--accent-color);
            color: var(--dark-color);
        }

        .lang-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        /* Main Container */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
            position: relative;
        }

        /* Floating Particles Animation */
        .particles {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
        }

        .particle {
            position: absolute;
            width: 4px;
            height: 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }

        /* Content Card */
        .content-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--accent-color), var(--secondary-color));
            background-size: 200% 100%;
            animation: gradientMove 3s ease-in-out infinite;
        }

        /* Footer */
        .footer {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-top: 50px;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer p {
            margin-bottom: 10px;
        }

        .footer a {
            color: var(--accent-color);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: white;
        }

        /* Animations */
        @keyframes gradientShift {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        @keyframes shimmer {
            0% {
                left: -100%;
            }

            100% {
                left: 100%;
            }
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(-100vh) rotate(360deg);
                opacity: 0;
            }
        }

        @keyframes gradientMove {

            0%,
            100% {
                background-position: 0% 50%;
            }

            50% {
                background-position: 100% 50%;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .header-container {
                flex-direction: column;
                gap: 15px;
            }

            .breaking-news-content {
                flex-direction: column;
                gap: 10px;
            }

            .breaking-text {
                font-size: 24px;
            }

            .site-title {
                font-size: 20px;
            }

            .main-container {
                padding: 20px 15px;
            }

            .content-card {
                padding: 25px;
                border-radius: 15px;
            }
        }

        /* RTL Adjustments */
        html[dir="rtl"] .breaking-news-content {
            direction: rtl;
        }

        html[dir="rtl"] .header-container {
            direction: rtl;
        }

        html[dir="rtl"] .logo-section {
            flex-direction: row-reverse;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--secondary-color);
        }
    </style>
    @stack('styles')
</head>

<body>
    <!-- Breaking News Bar -->
    <div class="breaking-news">
        <div class="breaking-news-container">
            <div class="breaking-badge-section">
                <span class="breaking-badge">{{ __('messages.breaking_news') }}</span>
                <span class="breaking-icon">📢</span>
            </div>
            <div class="breaking-content">
                <div class="breaking-text-wrapper">
                    <span class="breaking-text">{{ __('messages.math_course_announcement') }}</span>
                </div>
            </div>
            <div class="breaking-action">
                <a href="https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r" target="_blank" class="whatsapp-btn">
                    <span class="whatsapp-icon">📱</span>
                    {{ app()->getLocale() == 'ar' ? 'واتساب' : 'WhatsApp' }}
                </a>
            </div>
        </div>
    </div>

    <!-- Header -->
    <header class="header">
        <div class="header-container">
            <div class="logo-section">
                <img src="{{ asset('assets_front/images/logo.jpeg') }}" alt="{{ __('messages.logo') }}" class="logo">
                <a href="{{ route('student.form') }}" class="site-title">نظام خليليو لحساب معدل طلاب جيل 2008 </a>
            </div>

            <div class="lang-switcher">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <a href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}"
                        class="lang-btn {{ app()->getLocale() == $localeCode ? 'active' : '' }}"
                        hreflang="{{ $localeCode }}">
                        <span class="lang-flag">
                            @if ($localeCode == 'ar')
                                🇯🇴
                            @elseif($localeCode == 'en')
                                🇺🇸
                            @else
                                🌐
                            @endif
                        </span>
                        <span class="lang-text">{{ $properties['native'] }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </header>

    <!-- Floating Particles -->
    <div class="particles">
        @for ($i = 0; $i < 20; $i++)
            <div class="particle"
                style="left: {{ rand(0, 100) }}%; animation-delay: {{ rand(0, 15) }}s; animation-duration: {{ rand(10, 20) }}s;">
            </div>
        @endfor
    </div>

    <!-- Main Content -->
    <main class="main-container">
        <div class="content-card">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; {{ date('Y') }} {{ __('messages.all_rights_reserved') }}</p>
            <p>{{ __('messages.developed_with_love') }} ❤️</p>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
