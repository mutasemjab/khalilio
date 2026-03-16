<?php $__env->startSection('title', __('messages.student_registration')); ?>

<?php $__env->startSection('content'); ?>


<?php
    $redirectTo = $redirectTo ?? session('redirect_to', 'average');
    $contextMeta = match($redirectTo) {
        'track' => [
            'icon'     => '🧭',
            'color'    => '#667eea',
            'service'  => 'معرفة حقلك الدراسي',
            'subtitle' => 'سجّل بياناتك أولاً لتتمكن من معرفة الحقل المناسب لك',
            'step'     => 'الخطوة 1 من 3',
            'next'     => 'إدخال علامات المواد',
        ],
        'quiz' => [
            'icon'     => '🧮',
            'color'    => '#f5576c',
            'service'  => 'الامتحان التشخيصي بالرياضيات',
            'subtitle' => 'سجّل بياناتك أولاً للبدء بالامتحان التشخيصي',
            'step'     => 'الخطوة 1 من 2',
            'next'     => 'بدء الامتحان',
        ],
        default => [  // average
            'icon'     => '📊',
            'color'    => '#4facfe',
            'service'  => 'حساب معدلك الدراسي',
            'subtitle' => 'سجّل بياناتك أولاً لحساب معدلك بدقة',
            'step'     => 'الخطوة 1 من 3',
            'next'     => 'إدخال العلامات',
        ],
    };
?>

<div class="form-container">

    
    <div class="sf-context-banner" style="--ctx-color: <?php echo e($contextMeta['color']); ?>">
        <span class="sf-ctx-icon"><?php echo e($contextMeta['icon']); ?></span>
        <div class="sf-ctx-text">
            <span class="sf-ctx-service"><?php echo e($contextMeta['service']); ?></span>
            <span class="sf-ctx-step"><?php echo e($contextMeta['step']); ?></span>
        </div>
        <a href="<?php echo e(route('hub')); ?>" class="sf-ctx-back">← تغيير</a>
    </div>

    
    <div class="sf-progress">
        <div class="sf-step sf-step--active">
            <div class="sf-step-circle">1</div>
            <span>بياناتك</span>
        </div>
        <div class="sf-step-line"></div>
        <div class="sf-step">
            <div class="sf-step-circle">2</div>
            <span><?php echo e($contextMeta['next']); ?></span>
        </div>
        <?php if($redirectTo !== 'quiz'): ?>
        <div class="sf-step-line"></div>
        <div class="sf-step">
            <div class="sf-step-circle">3</div>
            <span>النتيجة</span>
        </div>
        <?php endif; ?>
    </div>

    
    <div class="form-header">
        <img src="<?php echo e(asset('assets_front/images/logo.jpeg')); ?>"
             alt="<?php echo e(__('messages.logo')); ?>"
             class="logo2">
        <br>
        <a href="<?php echo e(route('student.form')); ?>" class="site-title">أحمد خليليو</a>
        <h1 class="form-title"><?php echo e(__('messages.student_registration')); ?></h1>
        <p class="form-subtitle"><?php echo e($contextMeta['subtitle']); ?></p>
    </div>

    <form method="POST" action="<?php echo e(route('student.store')); ?>" class="student-form" id="studentForm">
        <?php echo csrf_field(); ?>

        
        <input type="hidden" name="redirect_to" value="<?php echo e($redirectTo); ?>">

        <div class="form-grid">

            
            <div class="form-group form-group-full">
                <label for="name" class="form-label">
                    <span class="label-icon">👤</span>
                    الاسم الكامل (ثلاثة مقاطع)
                </label>
                <input type="text"
                       id="name"
                       name="name"
                       value="<?php echo e(old('name')); ?>"
                       class="form-input <?php echo e($errors->has('name') ? 'input-error' : ''); ?>"
                       placeholder="مثال: أحمد محمد العمري"
                       required>
                <div class="input-hint">
                    <span class="hint-icon">💡</span>
                    يجب إدخال الاسم الأول واسم الأب واسم العائلة
                </div>
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message"><span class="error-icon">⚠️</span><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="form-group">
                <label for="phone" class="form-label">
                    <span class="label-icon">📱</span>
                    رقم الهاتف
                </label>
                <input type="text"
                       id="phone"
                       name="phone"
                       value="<?php echo e(old('phone')); ?>"
                       class="form-input <?php echo e($errors->has('phone') ? 'input-error' : ''); ?>"
                       placeholder="07XXXXXXXX"
                       maxlength="10"
                       required>
                <div class="input-hint">
                    <span class="hint-icon">💡</span>
                    يبدأ بـ 07 ويتكون من 10 أرقام
                </div>
                <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message"><span class="error-icon">⚠️</span><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            
            <div class="form-group">
                <label class="form-label">
                    <span class="label-icon">🎂</span>
                    الجيل / سنة الميلاد
                </label>
                <div class="generation-picker">
                    <?php $__currentLoopData = ['2008','2009','2010']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gen): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <label class="gen-option <?php echo e(old('generation') == $gen ? 'selected' : ''); ?>">
                        <input type="radio"
                               name="generation"
                               value="<?php echo e($gen); ?>"
                               <?php echo e(old('generation') == $gen ? 'checked' : ''); ?>

                               required>
                        <span class="gen-label">
                            <span class="gen-year"><?php echo e($gen); ?></span>
                            <span class="gen-sub">جيل <?php echo e($gen); ?></span>
                        </span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php $__errorArgs = ['generation'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message"><span class="error-icon">⚠️</span><?php echo e($message); ?></div>
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
                <input type="text"
                       id="school_name"
                       name="school_name"
                       value="<?php echo e(old('school_name')); ?>"
                       class="form-input <?php echo e($errors->has('school_name') ? 'input-error' : ''); ?>"
                       placeholder="<?php echo e(__('messages.enter_school_name')); ?>"
                       required>
                <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message"><span class="error-icon">⚠️</span><?php echo e($message); ?></div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

        </div>

        
        <div class="form-actions">
            <button type="submit" class="submit-btn" id="submitBtn" style="--btn-color: <?php echo e($contextMeta['color']); ?>">
                <span class="btn-icon"><?php echo e($contextMeta['icon']); ?></span>
                <?php echo e(__('messages.next_enter_grades')); ?>

                <div class="btn-ripple"></div>
            </button>
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
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/student-form.blade.php ENDPATH**/ ?>