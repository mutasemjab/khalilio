<?php $__env->startSection('title', 'خليليو - الصفحة الرئيسية'); ?>

<?php $__env->startSection('content'); ?>
<div class="hub-wrapper">

    
    <div class="hub-hero">
        <img src="<?php echo e(asset('assets_front/images/logo.jpeg')); ?>" alt="logo" class="hub-logo">
        <br>
        <h1 class="hub-title">أهلاً بك في منصة خليليو</h1>
        <p class="hub-subtitle">اختر ما تريد معرفته اليوم</p>
        <div class="hub-stars">
            <?php for($i=0;$i<12;$i++): ?>
            <span class="hub-star"
                  style="--d:<?php echo e(rand(0,360)); ?>deg;--r:<?php echo e(rand(60,130)); ?>px;--s:<?php echo e(rand(4,14)); ?>px;--delay:<?php echo e($i*0.18); ?>s">
                ★
            </span>
            <?php endfor; ?>
        </div>
    </div>

    
    <div class="hub-grid">

        
        
        <a href="<?php echo e(route('student.form', ['redirect_to' => 'track'])); ?>" class="hub-card hub-card--track">
            <div class="hub-card__glow"></div>
            <div class="hub-card__number">01</div>
            <div class="hub-card__icon-wrap">
                <span class="hub-card__icon">🧭</span>
                <div class="hub-card__ring"></div>
            </div>
            <h2 class="hub-card__title">كيف تعرف حقلك</h2>
            <p class="hub-card__desc">أدخل علامات مواد الصف العاشر واعرف أي حقل يناسبك من بين الصحي والتكنولوجي والأعمال واللغات والشريعة</p>
            <div class="hub-card__badge">سجّل بياناتك أولاً</div>
            <div class="hub-card__arrow">←</div>
            <div class="hub-card__shine"></div>
        </a>

        
        
        <a href="<?php echo e(route('student.form', ['redirect_to' => 'quiz'])); ?>" class="hub-card hub-card--math">
            <div class="hub-card__glow"></div>
            <div class="hub-card__number">02</div>
            <div class="hub-card__icon-wrap">
                <span class="hub-card__icon">🧮</span>
                <div class="hub-card__ring"></div>
            </div>
            <h2 class="hub-card__title">كيف تعرف مستواك بالرياضيات</h2>
            <p class="hub-card__desc">اخضع لاختبار تشخيصي تفاعلي وتعرف على مستواك الحقيقي في الرياضيات وانضم للمجموعة المناسبة لك</p>
            <div class="hub-card__badge">سجّل بياناتك أولاً</div>
            <div class="hub-card__arrow">←</div>
            <div class="hub-card__shine"></div>
        </a>

        
        
        <a href="<?php echo e(route('student.form', ['redirect_to' => 'average'])); ?>" class="hub-card hub-card--avg">
            <div class="hub-card__glow"></div>
            <div class="hub-card__number">03</div>
            <div class="hub-card__icon-wrap">
                <span class="hub-card__icon">📊</span>
                <div class="hub-card__ring"></div>
            </div>
            <h2 class="hub-card__title">كيف تحسب معدلك</h2>
            <p class="hub-card__desc">أدخل علاماتك في المواد الأربعة لجيل 2008 واحسب معدلك الدراسي بدقة وسهولة</p>
            <div class="hub-card__badge">سجّل بياناتك أولاً</div>
            <div class="hub-card__arrow">←</div>
            <div class="hub-card__shine"></div>
        </a>

        
        <a href="<?php echo e(route('top-students.index')); ?>" class="hub-card hub-card--top">
            <div class="hub-card__glow"></div>
            <div class="hub-card__number">04</div>
            <div class="hub-card__icon-wrap">
                <span class="hub-card__icon">🏆</span>
                <div class="hub-card__ring"></div>
            </div>
            <h2 class="hub-card__title">الأوائل</h2>
            <p class="hub-card__desc">تعرف على الطلاب الأوائل وإنجازاتهم وشهاداتهم وانضم إلى جيش الفل والأوائل</p>
            <div class="hub-card__arrow">←</div>
            <div class="hub-card__shine"></div>
        </a>

    </div>

    
    <div class="hub-cta">
        <div class="hub-cta__inner">
            <div class="hub-cta__icon">📲</div>
            <div class="hub-cta__text">
                <strong>انضم لقناة الواتساب الآن</strong>
                <span>وتابع كل جديد وخطتك الدراسية على مدار الساعة</span>
            </div>
            <a href="https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r"
               target="_blank" class="hub-cta__btn">
                <span>📱</span> انضم الآن
            </a>
        </div>
    </div>

</div>

<style>
/* ── Hub Wrapper ─────────────────────────────── */
.hub-wrapper { max-width: 1100px; margin: 0 auto; padding: 0 10px 60px; }

/* ── Hero ────────────────────────────────────── */
.hub-hero { text-align: center; padding: 40px 20px 50px; position: relative; animation: fadeInDown 0.8s ease-out; }
.hub-logo { width: 100px; height: 100px; border-radius: 50%; object-fit: cover; box-shadow: 0 8px 30px rgba(102,126,234,0.35); border: 4px solid rgba(255,255,255,0.8); animation: float 4s ease-in-out infinite; margin-bottom: 20px; }
.hub-title { font-size: 42px; font-weight: 800; margin-bottom: 10px; background: linear-gradient(135deg, var(--primary-color), var(--secondary-color), #ff6b6b); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-size: 200%; animation: gradientText 4s ease infinite; }
.hub-subtitle { font-size: 20px; color: #555; }
.hub-stars { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; overflow: hidden; }
.hub-star { position: absolute; top: 50%; left: 50%; transform: rotate(var(--d)) translateX(var(--r)); font-size: var(--s); color: rgba(102,126,234,0.5); animation: starPulse 2s ease-in-out infinite; animation-delay: var(--delay); }
@keyframes starPulse { 0%,100% { opacity:.3; transform: rotate(var(--d)) translateX(var(--r)) scale(1); } 50% { opacity:1; transform: rotate(var(--d)) translateX(calc(var(--r) + 10px)) scale(1.3); } }
@keyframes gradientText { 0%,100% { background-position:0% 50%; } 50% { background-position:100% 50%; } }
@keyframes float { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-12px); } }
@keyframes fadeInDown { from { transform:translateY(-30px); opacity:0; } to { transform:translateY(0); opacity:1; } }

/* ── Grid ────────────────────────────────────── */
.hub-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; margin-bottom: 40px; }

/* ── Base Card ───────────────────────────────── */
.hub-card {
    position: relative; border-radius: 24px; padding: 36px 30px 30px;
    text-decoration: none; color: white;
    display: flex; flex-direction: column; gap: 14px;
    overflow: hidden; cursor: pointer;
    transition: transform 0.35s cubic-bezier(.34,1.56,.64,1), box-shadow 0.35s ease;
    animation: cardIn 0.6s ease-out both;
}
.hub-card:nth-child(1) { animation-delay: 0.1s; }
.hub-card:nth-child(2) { animation-delay: 0.2s; }
.hub-card:nth-child(3) { animation-delay: 0.3s; }
.hub-card:nth-child(4) { animation-delay: 0.4s; }
@keyframes cardIn { from { transform:translateY(40px); opacity:0; } to { transform:translateY(0); opacity:1; } }
.hub-card:hover { transform: translateY(-8px) scale(1.01); text-decoration: none; color: white; }
.hub-card:active { transform: translateY(-4px) scale(0.99); }

/* Glow */
.hub-card__glow { position: absolute; top: -40%; left: -40%; width: 180%; height: 180%; border-radius: 50%; opacity: 0; transition: opacity 0.4s ease; pointer-events: none; }
.hub-card:hover .hub-card__glow { opacity: 1; }

/* Shine */
.hub-card__shine { position: absolute; top: 0; left: -100%; width: 60%; height: 100%; background: linear-gradient(105deg, transparent 40%, rgba(255,255,255,0.18) 50%, transparent 60%); transition: left 0.5s ease; pointer-events: none; }
.hub-card:hover .hub-card__shine { left: 150%; }

/* Number */
.hub-card__number { font-size: 72px; font-weight: 900; line-height: 1; opacity: 0.12; position: absolute; top: 16px; left: 20px; letter-spacing: -4px; font-family: 'Inter', monospace; }
html[dir="rtl"] .hub-card__number { left: auto; right: 20px; }

/* Icon */
.hub-card__icon-wrap { position: relative; width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; }
.hub-card__icon { font-size: 36px; z-index: 2; filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2)); animation: iconBounce 3s ease-in-out infinite; }
.hub-card__ring { position: absolute; width: 60px; height: 60px; border-radius: 50%; border: 2px solid rgba(255,255,255,0.3); animation: ringPulse 2s ease-in-out infinite; }
@keyframes iconBounce { 0%,100% { transform:translateY(0); } 50% { transform:translateY(-6px); } }
@keyframes ringPulse { 0%,100% { transform:scale(1); opacity:.5; } 50% { transform:scale(1.2); opacity:1; } }

/* Text */
.hub-card__title { font-size: 22px; font-weight: 700; line-height: 1.3; text-shadow: 0 2px 8px rgba(0,0,0,0.2); }
.hub-card__desc { font-size: 14px; opacity: 0.88; line-height: 1.7; flex: 1; }

/* Registration badge */
.hub-card__badge {
    display: inline-flex; align-items: center; gap: 5px;
    background: rgba(255,255,255,0.22); backdrop-filter: blur(6px);
    padding: 5px 12px; border-radius: 20px; font-size: 12px; font-weight: 600;
    border: 1px solid rgba(255,255,255,0.3); width: fit-content;
}
.hub-card__badge::before { content: '📝'; font-size: 13px; }

/* Arrow */
.hub-card__arrow { display: inline-flex; align-items: center; justify-content: center; width: 40px; height: 40px; border-radius: 50%; background: rgba(255,255,255,0.25); font-size: 20px; align-self: flex-end; transition: transform 0.3s ease, background 0.3s ease; }
.hub-card:hover .hub-card__arrow { transform: translateX(-6px); background: rgba(255,255,255,0.4); }

/* ── Color themes ────────────────────────────── */
.hub-card--track { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); box-shadow: 0 20px 50px rgba(102,126,234,0.4); }
.hub-card--track .hub-card__glow { background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 65%); }
.hub-card--track:hover { box-shadow: 0 30px 70px rgba(102,126,234,0.5); color: white; }

.hub-card--math { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); box-shadow: 0 20px 50px rgba(245,87,108,0.35); }
.hub-card--math .hub-card__glow { background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 65%); }
.hub-card--math:hover { box-shadow: 0 30px 70px rgba(245,87,108,0.5); color: white; }

.hub-card--avg { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); box-shadow: 0 20px 50px rgba(79,172,254,0.35); }
.hub-card--avg .hub-card__glow { background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 65%); }
.hub-card--avg:hover { box-shadow: 0 30px 70px rgba(79,172,254,0.5); color: white; }

.hub-card--top { background: linear-gradient(135deg, #f7971e 0%, #ffd200 100%); box-shadow: 0 20px 50px rgba(247,151,30,0.35); color: #2d1600; }
.hub-card--top:hover { box-shadow: 0 30px 70px rgba(247,151,30,0.5); color: #2d1600; }
.hub-card--top .hub-card__arrow { background: rgba(0,0,0,0.12); }
.hub-card--top:hover .hub-card__arrow { background: rgba(0,0,0,0.22); }

/* ── WhatsApp CTA ─────────────────────────────── */
.hub-cta { background: linear-gradient(135deg, #25D366, #128C7E); border-radius: 20px; padding: 24px 30px; box-shadow: 0 15px 40px rgba(37,211,102,0.3); animation: cardIn 0.6s ease-out 0.5s both; }
.hub-cta__inner { display: flex; align-items: center; gap: 20px; flex-wrap: wrap; justify-content: space-between; }
.hub-cta__icon { font-size: 40px; animation: iconBounce 2s ease-in-out infinite; }
.hub-cta__text { flex: 1; color: white; }
.hub-cta__text strong { display: block; font-size: 20px; font-weight: 700; margin-bottom: 4px; }
.hub-cta__text span { font-size: 14px; opacity: 0.9; }
.hub-cta__btn { display: flex; align-items: center; gap: 8px; background: white; color: #128C7E; padding: 14px 28px; border-radius: 50px; text-decoration: none; font-size: 16px; font-weight: 700; transition: all 0.3s ease; white-space: nowrap; box-shadow: 0 4px 15px rgba(0,0,0,0.15); }
.hub-cta__btn:hover { transform: translateY(-3px) scale(1.03); color: #128C7E; text-decoration: none; }

/* ── Responsive ──────────────────────────────── */
@media (max-width: 768px) {
    .hub-grid { grid-template-columns: 1fr; gap: 18px; }
    .hub-title { font-size: 28px; }
    .hub-card { padding: 28px 22px 22px; }
    .hub-card__title { font-size: 20px; }
    .hub-cta__inner { flex-direction: column; text-align: center; }
    .hub-cta__btn { width: 100%; justify-content: center; }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/hub.blade.php ENDPATH**/ ?>