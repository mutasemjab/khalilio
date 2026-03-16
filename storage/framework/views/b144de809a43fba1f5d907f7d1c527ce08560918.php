



<?php $__env->startSection('title', app()->getLocale() == 'ar' ? 'امتحان الرياضيات - خليليو' : 'Math Quiz - Khaleelio'); ?>

<?php $__env->startSection('content'); ?>
<div class="ql-wrapper">

    <div class="ql-header">
        <a href="<?php echo e(route('hub')); ?>" class="ql-back">← <?php echo e(app()->getLocale() == 'ar' ? 'العودة' : 'Back'); ?></a>
        <div class="ql-icon">🧮</div>
        <h1 class="ql-title">
            <?php echo e(app()->getLocale() == 'ar' ? 'كيف تعرف مستواك بالرياضيات' : 'How to Know Your Math Level'); ?>

        </h1>
        <p class="ql-subtitle">
            <?php echo e(app()->getLocale() == 'ar'
                ? 'اخضع لامتحان تشخيصي تفاعلي وتعرف على مجموعتك الدراسية'
                : 'Take an interactive diagnostic test and find your study group'); ?>

        </p>
    </div>

    <?php if($quiz): ?>

    
    <div class="ql-info-card">
        <div class="ql-info-header">
            <h2 class="ql-info-name"><?php echo e($quiz->name); ?></h2>
            <?php if($quiz->description): ?>
                <p class="ql-info-desc"><?php echo e($quiz->description); ?></p>
            <?php endif; ?>
        </div>
        <div class="ql-info-stats">
            <div class="ql-stat">
                <span class="ql-stat-icon">⏱️</span>
                <span class="ql-stat-val"><?php echo e($quiz->duration_minutes); ?></span>
                <span class="ql-stat-label"><?php echo e(app()->getLocale() == 'ar' ? 'دقيقة' : 'min'); ?></span>
            </div>
            <div class="ql-stat">
                <span class="ql-stat-icon">❓</span>
                <span class="ql-stat-val"><?php echo e($quiz->questions->count()); ?></span>
                <span class="ql-stat-label"><?php echo e(app()->getLocale() == 'ar' ? 'سؤال' : 'questions'); ?></span>
            </div>
            <div class="ql-stat">
                <span class="ql-stat-icon">⭐</span>
                <span class="ql-stat-val"><?php echo e($quiz->total_marks); ?></span>
                <span class="ql-stat-label"><?php echo e(app()->getLocale() == 'ar' ? 'علامة' : 'marks'); ?></span>
            </div>
        </div>
    </div>

    
    <div class="ql-groups">
        <h3 class="ql-groups-title">
            <?php echo e(app()->getLocale() == 'ar' ? 'المجموعات الدراسية' : 'Study Groups'); ?>

        </h3>
        <div class="ql-groups-grid">
            <div class="ql-group ql-group--a">
                <div class="ql-group-icon">🏆</div>
                <div class="ql-group-name"><?php echo e(app()->getLocale() == 'ar' ? 'المجموعة A' : 'Group A'); ?></div>
                <div class="ql-group-range"><?php echo e(app()->getLocale() == 'ar' ? '≥ 83%' : '≥ 83%'); ?></div>
                <div class="ql-group-desc"><?php echo e(app()->getLocale() == 'ar' ? 'المستوى المتقدم' : 'Advanced'); ?></div>
            </div>
            <div class="ql-group ql-group--b">
                <div class="ql-group-icon">⭐</div>
                <div class="ql-group-name"><?php echo e(app()->getLocale() == 'ar' ? 'المجموعة B' : 'Group B'); ?></div>
                <div class="ql-group-range"><?php echo e(app()->getLocale() == 'ar' ? '60% - 82%' : '60% - 82%'); ?></div>
                <div class="ql-group-desc"><?php echo e(app()->getLocale() == 'ar' ? 'المستوى المتوسط' : 'Intermediate'); ?></div>
            </div>
            <div class="ql-group ql-group--c">
                <div class="ql-group-icon">📚</div>
                <div class="ql-group-name"><?php echo e(app()->getLocale() == 'ar' ? 'المجموعة C' : 'Group C'); ?></div>
                <div class="ql-group-range"><?php echo e(app()->getLocale() == 'ar' ? 'أقل من 60%' : 'Below 60%'); ?></div>
                <div class="ql-group-desc"><?php echo e(app()->getLocale() == 'ar' ? 'يحتاج تعزيز' : 'Needs support'); ?></div>
            </div>
        </div>
    </div>

    
    <div class="ql-cta">
        <div class="ql-cta-icon">📝</div>
        <h3><?php echo e(app()->getLocale() == 'ar' ? 'جاهز للبدء؟' : 'Ready to start?'); ?></h3>
        <p><?php echo e(app()->getLocale() == 'ar'
            ? 'سجّل بياناتك أولاً ثم ابدأ الامتحان مباشرة'
            : 'Register your details first, then start the quiz immediately'); ?></p>
        <a href="<?php echo e(route('student.form', ['redirect_to' => 'quiz'])); ?>" class="ql-cta-btn">
            <span>🚀</span>
            <?php echo e(app()->getLocale() == 'ar' ? 'سجّل وابدأ الامتحان' : 'Register & Start Quiz'); ?>

        </a>
    </div>

    <?php else: ?>

    <div class="ql-empty">
        <div class="ql-empty-icon">🔜</div>
        <h3><?php echo e(app()->getLocale() == 'ar' ? 'لا يوجد امتحان متاح حالياً' : 'No quiz available yet'); ?></h3>
        <p><?php echo e(app()->getLocale() == 'ar' ? 'سيتم إضافة الامتحان قريباً' : 'A quiz will be added soon'); ?></p>
        <a href="https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r"
           target="_blank" class="ql-wa-btn">📱 <?php echo e(app()->getLocale() == 'ar' ? 'انضم للقناة' : 'Join Channel'); ?></a>
    </div>

    <?php endif; ?>

</div>

<style>
.ql-wrapper { max-width: 760px; margin: 0 auto; }
.ql-header { text-align: center; margin-bottom: 24px; animation: fadeInDown 0.7s ease-out; position: relative; padding-top: 10px; }
.ql-back { position: absolute; top: 0; right: 0; display: inline-flex; align-items: center; gap: 6px; color: var(--primary-color); text-decoration: none; font-size: 14px; font-weight: 600; padding: 7px 14px; border-radius: 20px; background: rgba(102,126,234,0.1); transition: all 0.2s ease; }
html[dir="rtl"] .ql-back { right: auto; left: 0; }
.ql-back:hover { background: rgba(102,126,234,0.2); color: var(--primary-color); text-decoration: none; }
.ql-icon { font-size: 56px; display: block; margin-bottom: 10px; animation: float 3s ease-in-out infinite; }
@keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
.ql-title { font-size: 28px; font-weight: 800; color: var(--text-color); margin-bottom: 8px; }
.ql-subtitle { color: #666; font-size: 15px; }

.ql-info-card { background: linear-gradient(135deg, #f093fb, #f5576c); border-radius: 18px; padding: 24px; margin-bottom: 20px; color: white; box-shadow: 0 12px 35px rgba(245,87,108,0.35); animation: fadeInUp 0.6s ease-out 0.1s both; }
.ql-info-name { font-size: 20px; font-weight: 800; margin-bottom: 6px; }
.ql-info-desc { opacity: .9; font-size: 14px; margin-bottom: 18px; line-height: 1.6; }
.ql-info-stats { display: flex; gap: 14px; flex-wrap: wrap; }
.ql-stat { display: flex; flex-direction: column; align-items: center; background: rgba(255,255,255,0.2); padding: 12px 16px; border-radius: 12px; flex: 1; min-width: 70px; }
.ql-stat-icon { font-size: 20px; margin-bottom: 4px; }
.ql-stat-val { font-size: 24px; font-weight: 800; line-height: 1; }
.ql-stat-label { font-size: 12px; opacity: .85; margin-top: 3px; }

.ql-groups { background: rgba(255,255,255,0.95); border-radius: 18px; padding: 22px; margin-bottom: 20px; animation: fadeInUp 0.6s ease-out 0.2s both; }
.ql-groups-title { font-size: 16px; font-weight: 700; text-align: center; margin-bottom: 16px; color: var(--text-color); }
.ql-groups-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; }
.ql-group { border-radius: 12px; padding: 16px 10px; text-align: center; }
.ql-group--a { background: linear-gradient(135deg, #f7971e, #ffd200); color: #2d1600; }
.ql-group--b { background: linear-gradient(135deg, #4facfe, #00f2fe); color: #003366; }
.ql-group--c { background: linear-gradient(135deg, #a8edea, #fed6e3); color: #333; }
.ql-group-icon { font-size: 24px; margin-bottom: 6px; }
.ql-group-name { font-size: 15px; font-weight: 800; margin-bottom: 3px; }
.ql-group-range { font-size: 12px; font-weight: 700; opacity: .85; margin-bottom: 3px; }
.ql-group-desc { font-size: 11px; opacity: .75; }

.ql-cta { background: rgba(255,255,255,0.97); border: 2px solid rgba(245,87,108,0.2); border-radius: 18px; padding: 30px; text-align: center; animation: fadeInUp 0.6s ease-out 0.3s both; }
.ql-cta-icon { font-size: 40px; margin-bottom: 10px; }
.ql-cta h3 { font-size: 20px; font-weight: 700; color: var(--text-color); margin-bottom: 8px; }
.ql-cta p { color: #666; font-size: 14px; margin-bottom: 20px; }
.ql-cta-btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 36px; background: linear-gradient(135deg, #f093fb, #f5576c); color: white; border-radius: 50px; text-decoration: none; font-size: 18px; font-weight: 700; transition: all 0.3s ease; box-shadow: 0 8px 25px rgba(245,87,108,0.35); }
.ql-cta-btn:hover { transform: translateY(-3px); box-shadow: 0 14px 35px rgba(245,87,108,0.45); color: white; text-decoration: none; }

.ql-empty { text-align: center; padding: 50px 20px; }
.ql-empty-icon { font-size: 60px; margin-bottom: 16px; display: block; }
.ql-empty h3 { font-size: 20px; color: var(--text-color); margin-bottom: 8px; }
.ql-empty p { color: #666; margin-bottom: 18px; }
.ql-wa-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #25D366; color: white; border-radius: 30px; text-decoration: none; font-size: 15px; font-weight: 700; }
.ql-wa-btn:hover { color: white; text-decoration: none; }

@keyframes fadeInDown { from { transform: translateY(-22px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fadeInUp { from { transform: translateY(22px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

@media (max-width: 600px) {
    .ql-groups-grid { grid-template-columns: 1fr; }
    .ql-title { font-size: 22px; }
    .ql-back { position: static; margin-bottom: 14px; display: inline-flex; }
    .ql-cta-btn { width: 100%; justify-content: center; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/quiz-landing.blade.php ENDPATH**/ ?>