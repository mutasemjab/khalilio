<?php $__env->startSection('title', 'الأوائل - خليليو'); ?>

<?php $__env->startSection('content'); ?>
<div class="ts-wrapper">

    
    <div class="ts-header">
        <a href="<?php echo e(route('hub')); ?>" class="ts-back">← العودة</a>
        <div class="ts-crown">👑</div>
        <h1 class="ts-title">جيش الفل والأوائل</h1>
        <p class="ts-subtitle">هؤلاء هم أوائل الطلاب الذين حققوا إنجازات رائعة</p>
        <div class="ts-sparkles">
            <?php for($i=0;$i<8;$i++): ?>
            <span class="ts-sparkle" style="--x:<?php echo e(rand(5,95)); ?>%;--y:<?php echo e(rand(5,90)); ?>%;--d:<?php echo e(rand(3,7)); ?>s;--size:<?php echo e(rand(10,20)); ?>px">✦</span>
            <?php endfor; ?>
        </div>
    </div>

    <?php if($students->count() > 0): ?>
    
    <div class="ts-grid">
        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="ts-card" style="animation-delay: <?php echo e($i * 0.12); ?>s">

            
            <?php if($student->rank): ?>
            <div class="ts-rank">
                <?php if($student->rank == '1' || $student->rank == 'الأول'): ?>🥇
                <?php elseif($student->rank == '2' || $student->rank == 'الثاني'): ?>🥈
                <?php elseif($student->rank == '3' || $student->rank == 'الثالث'): ?>🥉
                <?php else: ?>
                <span class="ts-rank-num"><?php echo e($student->rank); ?></span>
                <?php endif; ?>
            </div>
            <?php endif; ?>

            
            <div class="ts-photos">
                
                <div class="ts-photo-main">
                    <?php if($student->photo): ?>
                        <img src="<?php echo e(asset('assets/admin/uploads/' . $student->photo)); ?>" alt="<?php echo e($student->name); ?>" class="ts-photo-img">
                    <?php else: ?>
                        <div class="ts-photo-placeholder">🎓</div>
                    <?php endif; ?>
                </div>

                
                <div class="ts-photo-thumbs">
                    <div class="ts-thumb" onclick="openPhotoModal('<?php echo e($student->grades_photo ? asset('assets/admin/uploads/'.$student->grades_photo) : ''); ?>', 'كشف العلامات')">
                        <?php if($student->grades_photo): ?>
                            <img src="<?php echo e(asset('assets/admin/uploads/' . $student->grades_photo)); ?>" alt="كشف العلامات">
                        <?php else: ?>
                            <div class="ts-thumb-placeholder">📋</div>
                        <?php endif; ?>
                        <div class="ts-thumb-label">كشف العلامات</div>
                    </div>
                    <div class="ts-thumb" onclick="openPhotoModal('<?php echo e($student->certificate_photo ? asset('assets/admin/uploads/'.$student->certificate_photo) : ''); ?>', 'الشهادة')">
                        <?php if($student->certificate_photo): ?>
                            <img src="<?php echo e(asset('assets/admin/uploads/' . $student->certificate_photo)); ?>" alt="الشهادة">
                        <?php else: ?>
                            <div class="ts-thumb-placeholder">🏅</div>
                        <?php endif; ?>
                        <div class="ts-thumb-label">الشهادة</div>
                    </div>
                </div>
            </div>

            
            <div class="ts-info">
                <h3 class="ts-name"><?php echo e($student->name); ?></h3>
                <?php if($student->school_name): ?>
                <p class="ts-school">🏫 <?php echo e($student->school_name); ?></p>
                <?php endif; ?>
                <?php if($student->average): ?>
                <div class="ts-avg">
                    <span class="ts-avg-label">المعدل</span>
                    <span class="ts-avg-val"><?php echo e($student->average); ?>%</span>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="ts-card-sparkles">
                <?php for($j=0;$j<5;$j++): ?>
                <span class="ts-card-star" style="--x:<?php echo e(rand(5,95)); ?>%;--d:<?php echo e(rand(2,5)); ?>s;--delay:<?php echo e($j*0.4); ?>s">✦</span>
                <?php endfor; ?>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    
    <div class="ts-cta">
        <div class="ts-cta-emoji">🌟</div>
        <h2 class="ts-cta-title">حابب تكون من ضمنهم؟</h2>
        <p class="ts-cta-text">تفضل انضم لقناة الواتساب حتى تكون من جيش الفل والأوائل</p>
        <a href="https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r" target="_blank" class="ts-cta-btn">
            <span>📱</span> انضم لجيش الفل الآن
        </a>
    </div>

    <?php else: ?>
    
    <div class="ts-empty">
        <div class="ts-empty-icon">🏆</div>
        <h3>قريباً سيتم إضافة الأوائل</h3>
        <p>ترقب قائمة الأوائل قريباً</p>
        <a href="<?php echo e(route('hub')); ?>" class="ts-back-btn">← العودة للرئيسية</a>
    </div>
    <?php endif; ?>

</div>


<div class="ts-modal" id="photoModal" onclick="closeModal()">
    <div class="ts-modal-content" onclick="event.stopPropagation()">
        <button class="ts-modal-close" onclick="closeModal()">✕</button>
        <div class="ts-modal-label" id="modalLabel"></div>
        <img src="" alt="" class="ts-modal-img" id="modalImg">
    </div>
</div>

<style>
.ts-wrapper { max-width: 1080px; margin: 0 auto; }

/* Header */
.ts-header { text-align: center; padding: 20px 20px 40px; position: relative; overflow: hidden; animation: fadeInDown 0.7s ease-out; }
.ts-back { display: inline-flex; align-items: center; gap: 6px; color: var(--primary-color); text-decoration: none; font-size: 15px; font-weight: 600; padding: 8px 16px; border-radius: 20px; background: rgba(102,126,234,0.1); transition: all 0.3s ease; position: absolute; top: 20px; right: 0; }
html[dir="rtl"] .ts-back { right: auto; left: 0; }
.ts-back:hover { background: rgba(102,126,234,0.2); color: var(--primary-color); text-decoration: none; }
.ts-crown { font-size: 70px; animation: crownBounce 2s ease-in-out infinite; display: block; margin-bottom: 10px; margin-top: 10px; }
@keyframes crownBounce { 0%,100% { transform: translateY(0) rotate(-5deg); } 50% { transform: translateY(-12px) rotate(5deg); } }
.ts-title { font-size: 40px; font-weight: 900; background: linear-gradient(135deg, #f7971e, #ffd200, #f7971e); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; background-size: 200%; animation: goldShimmer 3s ease-in-out infinite; }
@keyframes goldShimmer { 0%,100% { background-position: 0%; } 50% { background-position: 100%; } }
.ts-subtitle { color: #666; font-size: 18px; margin-top: 8px; }
.ts-sparkles { position: absolute; top:0; left:0; width:100%; height:100%; pointer-events:none; }
.ts-sparkle { position: absolute; left: var(--x); top: var(--y); font-size: var(--size); color: #ffd200; animation: sparkleAnim var(--d) ease-in-out infinite; opacity: 0.6; }
@keyframes sparkleAnim { 0%,100% { transform: scale(1) rotate(0deg); opacity: 0.6; } 50% { transform: scale(1.5) rotate(180deg); opacity: 1; } }

/* Grid */
.ts-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 24px; margin-bottom: 40px; }
.ts-card {
    background: rgba(255,255,255,0.97); border-radius: 22px; overflow: hidden;
    box-shadow: 0 8px 30px rgba(0,0,0,0.1); transition: all 0.35s ease;
    animation: cardIn 0.6s ease-out both; position: relative;
    border: 2px solid rgba(255,215,0,0.2);
}
.ts-card:hover { transform: translateY(-8px) scale(1.01); box-shadow: 0 20px 50px rgba(0,0,0,0.15); border-color: rgba(255,215,0,0.5); }
@keyframes cardIn { from { transform: translateY(40px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

/* Rank */
.ts-rank { position: absolute; top: 12px; left: 12px; z-index: 10; font-size: 32px; filter: drop-shadow(0 2px 6px rgba(0,0,0,0.2)); animation: rankBounce 2.5s ease-in-out infinite; }
html[dir="rtl"] .ts-rank { left: auto; right: 12px; }
@keyframes rankBounce { 0%,100% { transform: scale(1); } 50% { transform: scale(1.15); } }
.ts-rank-num { display: inline-block; background: linear-gradient(135deg, #667eea, #764ba2); color: white; width: 36px; height: 36px; border-radius: 50%; font-size: 16px; font-weight: 800; text-align: center; line-height: 36px; box-shadow: 0 4px 12px rgba(102,126,234,0.4); }

/* Photos */
.ts-photos { padding: 20px 20px 0; }
.ts-photo-main { width: 100%; height: 200px; border-radius: 16px; overflow: hidden; margin-bottom: 12px; background: #f8f9fa; position: relative; }
.ts-photo-img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.4s ease; }
.ts-card:hover .ts-photo-img { transform: scale(1.05); }
.ts-photo-placeholder { width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 60px; background: linear-gradient(135deg, #f8f9fa, #e9ecef); }

.ts-photo-thumbs { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.ts-thumb {
    height: 80px; border-radius: 10px; overflow: hidden; cursor: pointer;
    position: relative; transition: all 0.3s ease; background: #f8f9fa;
}
.ts-thumb:hover { transform: scale(1.03); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
.ts-thumb img { width: 100%; height: 60px; object-fit: cover; display: block; }
.ts-thumb-placeholder { height: 60px; display: flex; align-items: center; justify-content: center; font-size: 28px; background: linear-gradient(135deg, #f0f0f0, #e0e0e0); }
.ts-thumb-label { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(0,0,0,0.65); color: white; font-size: 11px; text-align: center; padding: 3px; }

/* Info */
.ts-info { padding: 16px 20px 20px; }
.ts-name { font-size: 20px; font-weight: 800; color: var(--text-color); margin-bottom: 6px; }
.ts-school { font-size: 14px; color: #666; margin-bottom: 10px; }
.ts-avg { display: flex; align-items: center; gap: 8px; }
.ts-avg-label { font-size: 13px; color: #888; }
.ts-avg-val { font-size: 22px; font-weight: 800; background: linear-gradient(135deg, #f7971e, #ffd200); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }

/* Card sparkles */
.ts-card-sparkles { position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; overflow: hidden; }
.ts-card-star { position: absolute; left: var(--x); top: 10%; color: #ffd200; font-size: 10px; animation: cardStarAnim var(--d) ease-in-out var(--delay) infinite; opacity: 0; }
@keyframes cardStarAnim { 0%,100% { opacity: 0; transform: translateY(0); } 50% { opacity: 0.6; transform: translateY(-20px); } }

/* CTA */
.ts-cta {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 24px; padding: 40px; text-align: center;
    box-shadow: 0 15px 40px rgba(102,126,234,0.35);
    animation: fadeInUp 0.7s ease-out both;
}
.ts-cta-emoji { font-size: 50px; margin-bottom: 12px; animation: crownBounce 3s ease-in-out infinite; }
.ts-cta-title { font-size: 28px; font-weight: 800; color: white; margin-bottom: 10px; }
.ts-cta-text { font-size: 16px; color: rgba(255,255,255,0.85); margin-bottom: 24px; }
.ts-cta-btn { display: inline-flex; align-items: center; gap: 10px; padding: 16px 36px; background: white; color: #667eea; border-radius: 50px; text-decoration: none; font-size: 18px; font-weight: 700; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(0,0,0,0.15); }
.ts-cta-btn:hover { transform: translateY(-3px) scale(1.03); box-shadow: 0 12px 30px rgba(0,0,0,0.2); color: #667eea; text-decoration: none; }

/* Empty */
.ts-empty { text-align: center; padding: 60px 20px; }
.ts-empty-icon { font-size: 80px; margin-bottom: 20px; }
.ts-empty h3 { font-size: 24px; color: var(--text-color); margin-bottom: 10px; }
.ts-empty p { color: #666; margin-bottom: 20px; }
.ts-back-btn { display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: linear-gradient(135deg, #667eea, #764ba2); color: white; border-radius: 30px; text-decoration: none; font-weight: 600; transition: all 0.3s ease; }
.ts-back-btn:hover { transform: translateY(-2px); color: white; text-decoration: none; }

/* Modal */
.ts-modal { display: none; position: fixed; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.85); z-index: 9999; align-items: center; justify-content: center; padding: 20px; }
.ts-modal.active { display: flex; }
.ts-modal-content { position: relative; max-width: 800px; width: 100%; background: white; border-radius: 20px; overflow: hidden; animation: modalIn 0.3s ease-out; }
@keyframes modalIn { from { transform: scale(0.8); opacity:0; } to { transform: scale(1); opacity:1; } }
.ts-modal-close { position: absolute; top: 12px; left: 12px; background: rgba(0,0,0,0.6); color: white; border: none; width: 36px; height: 36px; border-radius: 50%; font-size: 16px; cursor: pointer; z-index: 10; }
html[dir="rtl"] .ts-modal-close { left: auto; right: 12px; }
.ts-modal-label { background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 12px 20px; font-size: 16px; font-weight: 700; }
.ts-modal-img { width: 100%; max-height: 80vh; object-fit: contain; display: block; }

@keyframes fadeInDown { from { transform: translateY(-25px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
@keyframes fadeInUp { from { transform: translateY(25px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

@media (max-width: 768px) {
    .ts-grid { grid-template-columns: 1fr; }
    .ts-title { font-size: 28px; }
    .ts-cta { padding: 28px 20px; }
    .ts-cta-title { font-size: 22px; }
    .ts-back { position: static; margin-bottom: 16px; }
}
</style>

<script>
function openPhotoModal(src, label) {
    if (!src) return;
    document.getElementById('modalImg').src = src;
    document.getElementById('modalLabel').textContent = label;
    document.getElementById('photoModal').classList.add('active');
    document.body.style.overflow = 'hidden';
}
function closeModal() {
    document.getElementById('photoModal').classList.remove('active');
    document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if(e.key === 'Escape') closeModal(); });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/top-students.blade.php ENDPATH**/ ?>