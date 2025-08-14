<?php $__env->startSection('title', __('messages.enter_grades')); ?>

<?php $__env->startSection('content'); ?>
<div class="grades-container">
    <!-- Student Info Card -->
    <div class="student-info-card">
        <div class="student-avatar">
            <div class="avatar-circle">👨‍🎓</div>
        </div>
        <div class="student-details">
            <h2 class="student-name"><?php echo e($user->name); ?></h2>
            <div class="student-meta">
                <span class="meta-item">
                    <span class="meta-icon">📱</span>
                    <?php echo e($user->phone); ?>

                </span>
                <span class="meta-item">
                    <span class="meta-icon">🏫</span>
                    <?php echo e($user->school_name); ?>

                </span>
            </div>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="form-header">
        <div class="progress-bar">
            <div class="progress-step completed">
                <div class="step-number">1</div>
                <span class="step-label"><?php echo e(__('messages.student_info')); ?></span>
            </div>
            <div class="progress-line completed"></div>
            <div class="progress-step active">
                <div class="step-number">2</div>
                <span class="step-label"><?php echo e(__('messages.grades')); ?></span>
            </div>
            <div class="progress-line"></div>
            <div class="progress-step">
                <div class="step-number">3</div>
                <span class="step-label"><?php echo e(__('messages.results')); ?></span>
            </div>
        </div>
        
        <h1 class="form-title"><?php echo e(__('messages.enter_subject_grades')); ?></h1>
        <p class="form-subtitle"><?php echo e(__('messages.please_enter_grades_carefully')); ?></p>
    </div>
    
    <!-- FIXED FORM - Simple and Clean -->
    <form method="POST" action="<?php echo e(route('grades.store', $user->id)); ?>" class="grades-form" id="gradesForm">
        <?php echo csrf_field(); ?>
        
        <div class="subjects-grid">
            <!-- Arabic Subject -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">📚</div>
                    <div class="subject-info">
                        <h3 class="subject-name"><?php echo e(__('messages.arabic_language')); ?></h3>
                        <span class="subject-description"><?php echo e(__('messages.arabic_desc')); ?></span>
                    </div>
                    <div class="max-grade-badge"><?php echo e(__('messages.out_of')); ?> 100</div>
                </div>
                <div class="input-group">
                    <label for="arabic_grade" class="grade-label"><?php echo e(__('messages.arabic_language')); ?>:</label>
                    <input 
                        type="number" 
                        name="arabic_grade" 
                        id="arabic_grade"
                        min="0" 
                        max="100" 
                        value="<?php echo e(old('arabic_grade')); ?>" 
                        class="grade-input"
                        placeholder="0"
                        step="1"
                        required>
                    <span class="input-suffix">/100</span>
                </div>
                <?php $__errorArgs = ['arabic_grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- English Subject -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">🇬🇧</div>
                    <div class="subject-info">
                        <h3 class="subject-name"><?php echo e(__('messages.english_language')); ?></h3>
                        <span class="subject-description"><?php echo e(__('messages.english_desc')); ?></span>
                    </div>
                    <div class="max-grade-badge"><?php echo e(__('messages.out_of')); ?> 100</div>
                </div>
                <div class="input-group">
                    <label for="english_grade" class="grade-label"><?php echo e(__('messages.english_language')); ?>:</label>
                    <input 
                        type="number" 
                        name="english_grade" 
                        id="english_grade"
                        min="0" 
                        max="100" 
                        value="<?php echo e(old('english_grade')); ?>" 
                        class="grade-input"
                        placeholder="0"
                        step="1"
                        required>
                    <span class="input-suffix">/100</span>
                </div>
                <?php $__errorArgs = ['english_grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Jordan History Subject -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">🏛️</div>
                    <div class="subject-info">
                        <h3 class="subject-name"><?php echo e(__('messages.jordan_history')); ?></h3>
                        <span class="subject-description"><?php echo e(__('messages.history_desc')); ?></span>
                    </div>
                    <div class="max-grade-badge"><?php echo e(__('messages.out_of')); ?> 40</div>
                </div>
                <div class="input-group">
                    <label for="jordan_history_grade" class="grade-label"><?php echo e(__('messages.jordan_history')); ?>:</label>
                    <input 
                        type="number" 
                        name="jordan_history_grade" 
                        id="jordan_history_grade"
                        min="0" 
                        max="40" 
                        value="<?php echo e(old('jordan_history_grade')); ?>" 
                        class="grade-input"
                        placeholder="0"
                        step="1"
                        required>
                    <span class="input-suffix">/40</span>
                </div>
                <?php $__errorArgs = ['jordan_history_grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Islamic Education Subject -->
            <div class="subject-card">
                <div class="subject-header">
                    <div class="subject-icon">☪️</div>
                    <div class="subject-info">
                        <h3 class="subject-name"><?php echo e(__('messages.islamic_education')); ?></h3>
                        <span class="subject-description"><?php echo e(__('messages.islamic_desc')); ?></span>
                    </div>
                    <div class="max-grade-badge"><?php echo e(__('messages.out_of')); ?> 60</div>
                </div>
                <div class="input-group">
                    <label for="islamic_education_grade" class="grade-label"><?php echo e(__('messages.islamic_education')); ?>:</label>
                    <input 
                        type="number" 
                        name="islamic_education_grade" 
                        id="islamic_education_grade"
                        min="0" 
                        max="60" 
                        value="<?php echo e(old('islamic_education_grade')); ?>" 
                        class="grade-input"
                        placeholder="0"
                        step="1"
                        required>
                    <span class="input-suffix">/60</span>
                </div>
                <?php $__errorArgs = ['islamic_education_grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message">
                        <span class="error-icon">⚠️</span>
                        <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="submit-btn" id="submitBtn">
                <span class="btn-icon">🧮</span>
                <?php echo e(__('messages.calculate_average')); ?>

            </button>
        </div>
    </form>
</div>

<style>
.grades-container {
    max-width: 900px;
    margin: 0 auto;
}

.student-info-card {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 25px;
    border-radius: 20px;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 20px;
    box-shadow: var(--shadow-lg);
    animation: slideInDown 0.8s ease-out;
}

.student-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 80px;
    height: 80px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    backdrop-filter: blur(10px);
    border: 2px solid rgba(255, 255, 255, 0.3);
    animation: pulse 2s infinite;
}

.student-details {
    flex: 1;
}

.student-name {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.student-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 16px;
    opacity: 0.9;
}

.meta-icon {
    font-size: 18px;
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
    animation: fadeInUp 0.8s ease-out 0.2s both;
}

.progress-bar {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 30px;
    gap: 10px;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
}

.step-number {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: var(--border-color);
    color: #999;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    transition: all 0.3s ease;
}

.step-label {
    font-size: 12px;
    color: #999;
    text-align: center;
    transition: color 0.3s ease;
}

.progress-step.completed .step-number {
    background: var(--success-color);
    color: white;
}

.progress-step.completed .step-label {
    color: var(--success-color);
}

.progress-step.active .step-number {
    background: var(--primary-color);
    color: white;
    animation: pulse 2s infinite;
}

.progress-step.active .step-label {
    color: var(--primary-color);
    font-weight: 600;
}

.progress-line {
    width: 60px;
    height: 2px;
    background: var(--border-color);
    transition: background 0.3s ease;
}

.progress-line.completed {
    background: var(--success-color);
}

.form-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 10px;
}

.form-subtitle {
    color: #666;
    font-size: 16px;
}

.grades-form {
    animation: slideInUp 0.8s ease-out 0.4s both;
}

.subjects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 25px;
    margin-bottom: 40px;
}

.subject-card {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid var(--border-color);
    border-radius: 16px;
    padding: 25px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(5px);
}

.subject-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-lg);
    border-color: var(--primary-color);
}

.subject-header {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 20px;
}

.subject-icon {
    font-size: 32px;
    padding: 10px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 52px;
    height: 52px;
    box-shadow: var(--shadow);
}

.subject-info {
    flex: 1;
}

.subject-name {
    font-size: 20px;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 5px;
}

.subject-description {
    font-size: 14px;
    color: #666;
    line-height: 1.4;
}

.max-grade-badge {
    background: var(--accent-color);
    color: var(--dark-color);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    box-shadow: var(--shadow);
}

.input-group {
    position: relative;
    display: block;
}

.grade-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: var(--text-color);
    font-size: 14px;
}

.grade-input {
    width: 100%;
    padding: 16px 60px 16px 20px;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    font-size: 24px;
    font-weight: 600;
    text-align: center;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(5px);
    box-sizing: border-box;
    font-family: inherit;
}

.grade-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    background: white;
    transform: scale(1.02);
}

.input-suffix {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #999;
    font-size: 16px;
    font-weight: 600;
    pointer-events: none;
    margin-top: 14px;
}

html[dir="rtl"] .input-suffix {
    right: auto;
    left: 20px;
}

html[dir="rtl"] .grade-input {
    padding: 16px 20px 16px 60px;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 5px;
    color: var(--danger-color);
    font-size: 14px;
    margin-top: 10px;
    animation: shakeIn 0.5s ease-out;
}

.error-icon {
    font-size: 16px;
}

.form-actions {
    text-align: center;
    margin-top: 40px;
}

.submit-btn {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 20px 50px;
    background: linear-gradient(135deg, var(--success-color), #20c997);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 20px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-lg);
    min-width: 280px;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(40, 167, 69, 0.3);
}

.btn-icon {
    font-size: 24px;
    transition: transform 0.3s ease;
}

.submit-btn:hover .btn-icon {
    transform: scale(1.2);
}

/* Animations */
@keyframes slideInDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes fadeInUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes shakeIn {
    0% { transform: translateX(-10px); opacity: 0; }
    50% { transform: translateX(5px); }
    100% { transform: translateX(0); opacity: 1; }
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.05); }
}

/* Responsive */
@media (max-width: 768px) {
    .subjects-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .student-info-card {
        flex-direction: column;
        text-align: center;
        gap: 15px;
    }
    
    .student-meta {
        justify-content: center;
    }
    
    .form-title {
        font-size: 24px;
    }
    
    .submit-btn {
        width: 100%;
        min-width: auto;
    }
    
    .progress-bar {
        flex-wrap: wrap;
        gap: 5px;
    }
    
    .progress-line {
        width: 30px;
    }
}

/* RTL Adjustments */
html[dir="rtl"] .student-info-card {
    flex-direction: row-reverse;
}

html[dir="rtl"] .subject-header {
    flex-direction: row-reverse;
}

html[dir="rtl"] .submit-btn {
    flex-direction: row-reverse;
}

html[dir="rtl"] .error-message {
    flex-direction: row-reverse;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('gradesForm');
    const submitBtn = document.getElementById('submitBtn');
    const inputs = form.querySelectorAll('input[type="number"]');
    
    console.log('Form loaded, found', inputs.length, 'inputs');
    
    // Simple form validation before submit
    form.addEventListener('submit', function(e) {
        console.log('Form submit triggered');
        
        let isValid = true;
        const formData = new FormData(form);
        
        console.log('Form data being submitted:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Check each input
        inputs.forEach(function(input) {
            const value = input.value.trim();
            const min = parseInt(input.getAttribute('min'));
            const max = parseInt(input.getAttribute('max'));
            
            console.log(input.name + ' value: "' + value + '"');
            
            if (!value || value === '') {
                console.log('Empty value for', input.name);
                isValid = false;
                input.style.borderColor = 'red';
            } else if (parseInt(value) < min || parseInt(value) > max) {
                console.log('Invalid range for', input.name);
                isValid = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = 'green';
            }
        });
        
        if (!isValid) {
            e.preventDefault();
            alert('Please fill all fields with valid values!');
            return false;
        }
        
        console.log('Form validation passed, submitting...');
    });
    
    // Reset border color on input
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            this.style.borderColor = '#e9ecef';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/grades-form.blade.php ENDPATH**/ ?>