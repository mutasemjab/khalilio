<?php $__env->startSection('title', __('messages.student_registration')); ?>

<?php $__env->startSection('content'); ?>
<div class="form-container">
    <div class="form-header">
        <img src="<?php echo e(asset('assets_front/images/logo.jpeg')); ?>" alt="<?php echo e(__('messages.logo')); ?>" class="logo2">
        <br>
        <a href="<?php echo e(route('student.form')); ?>" class="site-title">أحمد خليليو </a>
        <h1 class="form-title"><?php echo e(__('messages.student_registration')); ?></h1>
        <p class="form-subtitle"><?php echo e(__('messages.please_fill_student_info')); ?></p>
    </div>
    
    <form method="POST" action="<?php echo e(route('student.store')); ?>" class="student-form">
        <?php echo csrf_field(); ?>
        
        <div class="form-grid">
            <div class="form-group">
                <label for="name" class="form-label">
                    <span class="label-icon">👤</span>
                    <?php echo e(__('messages.student_name')); ?>

                </label>
                <input type="text" id="name" name="name" value="<?php echo e(old('name')); ?>" 
                       class="form-input" placeholder="<?php echo e(__('messages.enter_student_name')); ?>" required>
                <?php $__errorArgs = ['name'];
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

            <div class="form-group">
                <label for="phone" class="form-label">
                    <span class="label-icon">📱</span>
                    <?php echo e(__('messages.phone_number')); ?>

                </label>
                <input type="text" id="phone" name="phone" value="<?php echo e(old('phone')); ?>" 
                       class="form-input" placeholder="<?php echo e(__('messages.enter_phone_number')); ?>" required>
                <?php $__errorArgs = ['phone'];
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

            <div class="form-group form-group-full">
                <label for="school_name" class="form-label">
                    <span class="label-icon">🏫</span>
                    <?php echo e(__('messages.school_name')); ?>

                </label>
                <input type="text" id="school_name" name="school_name" value="<?php echo e(old('school_name')); ?>" 
                       class="form-input" placeholder="<?php echo e(__('messages.enter_school_name')); ?>" required>
                <?php $__errorArgs = ['school_name'];
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
            <button type="submit" class="submit-btn">
                <span class="btn-icon">➡️</span>
                <?php echo e(__('messages.next_enter_grades')); ?>

                <div class="btn-ripple"></div>
            </button>
        </div>
    </form>
</div>

<style>
.form-container {
    max-width: 600px;
    margin: 0 auto;
}

.form-header {
    text-align: center;
    margin-bottom: 40px;
}

.form-icon {
    margin-bottom: 20px;
}

.icon-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    margin: 0 auto;
    box-shadow: var(--shadow-lg);
    animation: iconFloat 3s ease-in-out infinite;
}

.form-title {
    font-size: 32px;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 10px;
    animation: slideInDown 0.8s ease-out;
}

.form-subtitle {
    color: #666;
    font-size: 16px;
    animation: fadeIn 1s ease-out 0.3s both;
}

.student-form {
    animation: slideInUp 0.8s ease-out 0.2s both;
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 25px;
    margin-bottom: 30px;
}

.form-group-full {
    grid-column: 1 / -1;
}

.form-group {
    position: relative;
}

.form-label {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
    color: var(--text-color);
    font-weight: 600;
    font-size: 16px;
    transition: color 0.3s ease;
}

.label-icon {
    font-size: 18px;
    filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
}

.form-input {
    width: 100%;
    padding: 16px 20px;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    font-size: 16px;
    font-family: inherit;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(5px);
    position: relative;
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    background: white;
    transform: translateY(-2px);
}

.form-input::placeholder {
    color: #999;
    transition: opacity 0.3s ease;
}

.form-input:focus::placeholder {
    opacity: 0.5;
}

.error-message {
    display: flex;
    align-items: center;
    gap: 5px;
    color: var(--danger-color);
    font-size: 14px;
    margin-top: 8px;
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
    gap: 10px;
    padding: 18px 40px;
    background: linear-gradient(135deg, var(--success-color), #20c997);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 18px;
    font-weight: 600;
    font-family: inherit;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow);
    min-width: 250px;
}

.submit-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(40, 167, 69, 0.3);
}

.submit-btn:active {
    transform: translateY(-1px);
}

.btn-icon {
    font-size: 20px;
    transition: transform 0.3s ease;
}

.submit-btn:hover .btn-icon {
    transform: translateX(<?php echo e(app()->getLocale() == 'ar' ? '-5px' : '5px'); ?>);
}

.btn-ripple {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.6s ease;
}

.submit-btn:hover .btn-ripple {
    left: 100%;
}

/* Animations */
@keyframes iconFloat {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
}

@keyframes slideInDown {
    from { transform: translateY(-30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes slideInUp {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes shakeIn {
    0% { transform: translateX(-10px); opacity: 0; }
    50% { transform: translateX(5px); }
    100% { transform: translateX(0); opacity: 1; }
}

/* Responsive */
@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    
    .form-title {
        font-size: 24px;
    }
    
    .icon-circle {
        width: 60px;
        height: 60px;
        font-size: 28px;
    }
    
    .submit-btn {
        width: 100%;
        min-width: auto;
    }
}

/* RTL Adjustments */
html[dir="rtl"] .form-label {
    flex-direction: row-reverse;
}

html[dir="rtl"] .error-message {
    flex-direction: row-reverse;
}

html[dir="rtl"] .submit-btn {
    flex-direction: row-reverse;
}
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/student-form.blade.php ENDPATH**/ ?>