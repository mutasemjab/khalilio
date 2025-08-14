{{-- resources/views/user/result.blade.php --}}
@extends('layouts.front')

@section('title', __('messages.student_result'))

@section('content')
<div class="result-container">
    <!-- Student Info Card -->
    <div class="student-info-card">
        <div class="student-avatar">
            <div class="avatar-circle">
                🎓
            </div>
        </div>
        <div class="student-details">
            <h2 class="student-name">{{ $user->name }}</h2>
            <div class="student-meta">
                <span class="meta-item">
                    <span class="meta-icon">📱</span>
                    {{ $user->phone }}
                </span>
                <span class="meta-item">
                    <span class="meta-icon">🏫</span>
                    {{ $user->school_name }}
                </span>
            </div>
        </div>
        <div class="completion-badge">
            <div class="badge-icon">✅</div>
            <span class="badge-text">{{ __('messages.completed') }}</span>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="progress-section">
        <div class="progress-bar">
            <div class="progress-step completed">
                <div class="step-number">1</div>
                <span class="step-label">{{ __('messages.student_info') }}</span>
            </div>
            <div class="progress-line completed"></div>
            <div class="progress-step completed">
                <div class="step-number">2</div>
                <span class="step-label">{{ __('messages.grades') }}</span>
            </div>
            <div class="progress-line completed"></div>
            <div class="progress-step completed active">
                <div class="step-number">3</div>
                <span class="step-label">{{ __('messages.results') }}</span>
            </div>
        </div>
    </div>

    <!-- Results Header -->
    <div class="result-header">
        <img src="{{ asset('assets_front/images/logo.jpeg') }}" alt="{{ __('messages.logo') }}" class="logo2">

        <h1 class="result-title">{{ __('messages.congratulations') }}!</h1>
        <p class="result-subtitle">{{ __('messages.results_calculated_successfully') }}</p>
    </div>

    <!-- Grades Summary -->
    <div class="grades-summary">
        <h2 class="section-title">{{ __('messages.grades_summary') }}</h2>
        <div class="grades-grid">
            <div class="grade-card arabic">
                <div class="grade-header">
                    <div class="grade-icon">📚</div>
                    <div class="grade-info">
                        <h3 class="grade-subject">{{ __('messages.arabic_language') }}</h3>
                        <span class="grade-weight">{{ __('messages.weight_10') }}</span>
                    </div>
                </div>
                <div class="grade-display">
                    <span class="grade-value">{{ $user->arabic_grade }}</span>
                    <span class="grade-total">/100</span>
                </div>
                <div class="grade-percentage">
                    <div class="percentage-bar">
                        <div class="percentage-fill" style="width: {{ $user->arabic_grade }}%"></div>
                    </div>
                    <span class="percentage-text">{{ $user->arabic_grade }}%</span>
                </div>
            </div>

            <div class="grade-card english">
                <div class="grade-header">
                    <div class="grade-icon">🇬🇧</div>
                    <div class="grade-info">
                        <h3 class="grade-subject">{{ __('messages.english_language') }}</h3>
                        <span class="grade-weight">{{ __('messages.weight_10') }}</span>
                    </div>
                </div>
                <div class="grade-display">
                    <span class="grade-value">{{ $user->english_grade }}</span>
                    <span class="grade-total">/100</span>
                </div>
                <div class="grade-percentage">
                    <div class="percentage-bar">
                        <div class="percentage-fill" style="width: {{ $user->english_grade }}%"></div>
                    </div>
                    <span class="percentage-text">{{ $user->english_grade }}%</span>
                </div>
            </div>

            <div class="grade-card history">
                <div class="grade-header">
                    <div class="grade-icon">🏛️</div>
                    <div class="grade-info">
                        <h3 class="grade-subject">{{ __('messages.jordan_history') }}</h3>
                        <span class="grade-weight">{{ __('messages.weight_10') }}</span>
                    </div>
                </div>
                <div class="grade-display">
                    <span class="grade-value">{{ $user->jordan_history_grade }}</span>
                    <span class="grade-total">/40</span>
                </div>
                <div class="grade-percentage">
                    <div class="percentage-bar">
                        <div class="percentage-fill" style="width: {{ ($user->jordan_history_grade / 40) * 100 }}%"></div>
                    </div>
                    <span class="percentage-text">{{ round(($user->jordan_history_grade / 40) * 100, 1) }}%</span>
                </div>
            </div>

            <div class="grade-card islamic">
                <div class="grade-header">
                    <div class="grade-icon">☪️</div>
                    <div class="grade-info">
                        <h3 class="grade-subject">{{ __('messages.islamic_education') }}</h3>
                        <span class="grade-weight">{{ __('messages.weight_10') }}</span>
                    </div>
                </div>
                <div class="grade-display">
                    <span class="grade-value">{{ $user->islamic_education_grade }}</span>
                    <span class="grade-total">/60</span>
                </div>
                <div class="grade-percentage">
                    <div class="percentage-bar">
                        <div class="percentage-fill" style="width: {{ ($user->islamic_education_grade / 60) * 100 }}%"></div>
                    </div>
                    <span class="percentage-text">{{ round(($user->islamic_education_grade / 60) * 100, 1) }}%</span>
                </div>
            </div>
        </div>
    </div>

  
    <!-- Final Average Display -->
    <div class="final-average-section">
        <div class="average-card">
            <div class="average-icon">🎯</div>
            <div class="average-content">
                <h2 class="average-label">{{ __('messages.final_average') }}</h2>
                <div class="average-value" data-value="{{ $user->average }}">{{ $user->average }}</div>
             
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="action-section">
        <div class="action-buttons">
            <a href="{{ route('student.form') }}" class="action-btn primary">
                <span class="btn-icon">➕</span>
                {{ __('messages.add_new_student') }}
            </a>
          
        </div>
    </div>
</div>

<style>
.result-container {
    max-width: 1000px;
    margin: 0 auto;
    animation: fadeInUp 0.8s ease-out;
}

.student-info-card {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 30px;
    border-radius: 20px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 25px;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.student-info-card::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 100%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: sparkle 4s ease-in-out infinite;
}

.student-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 90px;
    height: 90px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    backdrop-filter: blur(10px);
    border: 3px solid rgba(255, 255, 255, 0.3);
    animation: float 3s ease-in-out infinite;
}

.student-details {
    flex: 1;
}

.student-name {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 12px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.student-meta {
    display: flex;
    gap: 25px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    opacity: 0.9;
}

.completion-badge {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    background: rgba(255, 255, 255, 0.2);
    padding: 15px;
    border-radius: 15px;
    backdrop-filter: blur(10px);
}

.badge-icon {
    font-size: 24px;
    animation: bounce 2s infinite;
}

.badge-text {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.progress-section {
    margin-bottom: 40px;
}

.progress-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.step-number {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    background: var(--success-color);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 16px;
    animation: pulse 2s infinite;
}

.step-label {
    font-size: 14px;
    color: var(--success-color);
    font-weight: 600;
    text-align: center;
}

.progress-line {
    width: 80px;
    height: 3px;
    background: var(--success-color);
    border-radius: 2px;
}

.result-header {
    text-align: center;
    margin-bottom: 50px;
    animation: slideInDown 0.8s ease-out 0.2s both;
}

.result-icon {
    font-size: 80px;
    margin-bottom: 20px;
    animation: bounce 2s infinite;
}

.result-title {
    font-size: 42px;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 10px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.result-subtitle {
    color: #666;
    font-size: 18px;
}

.section-title {
    font-size: 24px;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 20px;
    text-align: center;
    position: relative;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 2px;
}

.grades-summary {
    margin-bottom: 40px;
    animation: slideInUp 0.8s ease-out 0.4s both;
}

.grades-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
}

.grade-card {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid var(--border-color);
    border-radius: 16px;
    padding: 20px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(5px);
}

.grade-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #ff6b6b, #4ecdc4);
    transform: scaleX(0);
    transition: transform 0.3s ease;
}

.grade-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
}

.grade-card:hover::before {
    transform: scaleX(1);
}

.grade-card.arabic::before { background: linear-gradient(90deg, #ff6b6b, #ee5a24); }
.grade-card.english::before { background: linear-gradient(90deg, #4ecdc4, #44a08d); }
.grade-card.history::before { background: linear-gradient(90deg, #45b7d1, #96c93d); }
.grade-card.islamic::before { background: linear-gradient(90deg, #96ceb4, #ffc048); }

.grade-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 15px;
}

.grade-icon {
    font-size: 24px;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(102, 126, 234, 0.1);
    border-radius: 10px;
}

.grade-info {
    flex: 1;
}

.grade-subject {
    font-size: 16px;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 2px;
}

.grade-weight {
    font-size: 12px;
    color: #666;
    font-weight: 500;
}

.grade-display {
    display: flex;
    align-items: baseline;
    gap: 5px;
    margin-bottom: 15px;
}

.grade-value {
    font-size: 36px;
    font-weight: 700;
    color: var(--primary-color);
}

.grade-total {
    font-size: 18px;
    color: #666;
    font-weight: 600;
}

.grade-percentage {
    display: flex;
    align-items: center;
    gap: 10px;
}

.percentage-bar {
    flex: 1;
    height: 8px;
    background: var(--border-color);
    border-radius: 4px;
    overflow: hidden;
}

.percentage-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
    border-radius: 4px;
    transition: width 1.5s ease-out;
    animation: fillBar 2s ease-out 1s both;
}

.percentage-text {
    font-size: 14px;
    font-weight: 600;
    color: var(--text-color);
    min-width: 40px;
}

.calculation-section {
    margin-bottom: 40px;
    animation: slideInUp 0.8s ease-out 0.6s both;
}

.calculation-card {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid var(--border-color);
    border-radius: 16px;
    padding: 30px;
    backdrop-filter: blur(5px);
}

.formula-title {
    font-size: 20px;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 20px;
    text-align: center;
}

.formula-display {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    justify-content: center;
    gap: 15px;
    margin-bottom: 25px;
}

.formula-step {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(102, 126, 234, 0.1);
    padding: 10px 15px;
    border-radius: 25px;
    font-weight: 600;
}

.step-subject {
    color: var(--primary-color);
    font-size: 14px;
}

.step-operation {
    color: #666;
    font-size: 14px;
}

.step-result {
    color: var(--success-color);
    font-size: 16px;
}

.formula-plus {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary-color);
}

.final-calculation {
    background: linear-gradient(135deg, var(--light-color), rgba(102, 126, 234, 0.1));
    padding: 20px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.calculation-breakdown {
    font-size: 18px;
    font-weight: 600;
    color: var(--text-color);
}

.equals-sign {
    font-size: 24px;
    font-weight: 700;
    color: var(--primary-color);
}

.final-result {
    font-size: 28px;
    font-weight: 700;
    color: var(--success-color);
    background: white;
    padding: 10px 20px;
    border-radius: 25px;
    box-shadow: var(--shadow);
}

.final-average-section {
    margin-bottom: 40px;
    animation: zoomIn 0.8s ease-out 0.8s both;
}

.average-card {
    background: linear-gradient(135deg, var(--success-color), #20c997);
    color: white;
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    box-shadow: var(--shadow-lg);
    position: relative;
    overflow: hidden;
}

.average-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: rotate 8s linear infinite;
}

.average-icon {
    font-size: 60px;
    margin-bottom: 20px;
    animation: pulse 2s infinite;
}

.average-content {
    position: relative;
    z-index: 2;
}

.average-label {
    font-size: 24px;
    font-weight: 600;
    margin-bottom: 15px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.average-value {
    font-size: 72px;
    font-weight: 700;
    margin-bottom: 20px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
    animation: countUp 2s ease-out 1s both;
}

.average-grade {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 15px;
    flex-wrap: wrap;
}

.grade-letter {
    font-size: 32px;
    font-weight: 700;
    padding: 10px 20px;
    border-radius: 15px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.grade-letter.excellent { background: #ff6b6b; }
.grade-letter.very-good { background: #4ecdc4; }
.grade-letter.good { background: #45b7d1; }
.grade-letter.acceptable { background: #ffc048; }
.grade-letter.needs-improvement { background: #ff7675; }

.grade-desc {
    font-size: 18px;
    font-weight: 600;
    opacity: 0.9;
}

.action-section {
    text-align: center;
    animation: fadeInUp 0.8s ease-out 1s both;
}

.action-buttons {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
}

.action-btn {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 16px 30px;
    border: none;
    border-radius: 50px;
    font-size: 16px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    min-width: 200px;
    justify-content: center;
}

.action-btn.primary {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    box-shadow: var(--shadow);
}

.action-btn.secondary {
    background: rgba(255, 255, 255, 0.9);
    color: var(--text-color);
    border: 2px solid var(--border-color);
    backdrop-filter: blur(5px);
}

.action-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-lg);
}

.btn-icon {
    font-size: 18px;
    transition: transform 0.3s ease;
}

.action-btn:hover .btn-icon {
    transform: scale(1.2);
}

/* Animations */
@keyframes fadeInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideInDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes zoomIn {
    from { transform: scale(0.8); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% { transform: translateY(0); }
    40%, 43% { transform: translateY(-10px); }
    70% { transform: translateY(-5px); }
    90% { transform: translateY(-2px); }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

@keyframes sparkle {
    0%, 100% { transform: rotate(0deg); opacity: 0.3; }
    50% { transform: rotate(180deg); opacity: 0.7; }
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

@keyframes fillBar {
    from { width: 0%; }
}

@keyframes countUp {
    from { 
        transform: scale(0.5);
        opacity: 0;
    }
    to { 
        transform: scale(1);
        opacity: 1;
    }
}

/* Print Styles */
@media print {
    .action-section {
        display: none;
    }
    
    .particles {
        display: none;
    }
    
    body {
        background: white !important;
    }
    
    .content-card {
        box-shadow: none !important;
        border: 1px solid #ccc !important;
    }
}

/* Responsive */
@media (max-width: 768px) {
    .student-info-card {
        flex-direction: column;
        text-align: center;
        gap: 20px;
    }
    
    .completion-badge {
        order: -1;
    }
    
    .student-meta {
        justify-content: center;
    }
    
    .grades-grid {
        grid-template-columns: 1fr;
        gap: 15px;
    }
    
    .formula-display {
        flex-direction: column;
        gap: 10px;
    }
    
    .final-calculation {
        flex-direction: column;
        gap: 10px;
    }
    
    .result-title {
        font-size: 28px;
    }
    
    .average-value {
        font-size: 48px;
    }
    
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .action-btn {
        width: 100%;
        max-width: 300px;
    }
    
    .progress-bar {
        flex-wrap: wrap;
        gap: 10px;
    }
}

/* RTL Adjustments */
html[dir="rtl"] .student-info-card {
    flex-direction: row-reverse;
}

html[dir="rtl"] .grade-header {
    flex-direction: row-reverse;
}

html[dir="rtl"] .action-btn {
    flex-direction: row-reverse;
}

html[dir="rtl"] .formula-display {
    flex-direction: row-reverse;
}

html[dir="rtl"] .final-calculation {
    flex-direction: row-reverse;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animate the average value counting up
    const averageElement = document.querySelector('.average-value');
    if (averageElement) {
        const finalValue = parseFloat(averageElement.dataset.value);
        let currentValue = 0;
        const increment = finalValue / 50;
        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= finalValue) {
                currentValue = finalValue;
                clearInterval(timer);
            }
            averageElement.textContent = currentValue.toFixed(2);
        }, 40);
    }
    
    // Animate percentage bars
    setTimeout(() => {
        const percentageFills = document.querySelectorAll('.percentage-fill');
        percentageFills.forEach(fill => {
            const width = fill.style.width;
            fill.style.width = '0%';
            setTimeout(() => {
                fill.style.width = width;
            }, 100);
        });
    }, 1000);
});
</script>
@endsection