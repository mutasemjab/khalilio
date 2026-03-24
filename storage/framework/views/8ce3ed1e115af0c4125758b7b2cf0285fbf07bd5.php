<?php $__env->startSection('title', 'نتيجة الحقل - خليليو'); ?>

<?php $__env->startSection('content'); ?>
    <div class="tr-wrapper">

        <div class="tr-header">
            <div class="tr-confetti" id="confetti"></div>
            <div class="tr-icon">🎯</div>
            <h1 class="tr-title"><?php echo e(__('messages.track_result_title')); ?></h1>
        </div>

        
        <div class="tr-score-card">
            <div class="tr-score-left">
                <div class="tr-score-circle">
                    <svg viewBox="0 0 120 120" class="tr-score-svg">
                        <circle cx="60" cy="60" r="54" fill="none" stroke="rgba(255,255,255,0.2)"
                            stroke-width="10" />
                        <circle cx="60" cy="60" r="54" fill="none" stroke="white" stroke-width="10"
                            stroke-dasharray="<?php echo e(round(2 * 3.14159 * 54)); ?>"
                            stroke-dashoffset="<?php echo e(round(2 * 3.14159 * 54 * (1 - $percentage / 100))); ?>"
                            stroke-linecap="round" transform="rotate(-90 60 60)" class="tr-score-ring" />
                    </svg>
                    <div class="tr-score-center">
                        <div class="tr-score-num"><?php echo e($percentage); ?>%</div>
                        <div class="tr-score-sub">المعدل</div>
                    </div>
                </div>
            </div>
            <div class="tr-score-right">
                <div class="tr-score-detail">
                    <span class="tr-score-label"><?php echo e(__('messages.total_sum')); ?></span>

                    <span class="tr-score-val"><?php echo e($totalScore); ?> / <?php echo e($totalMax); ?></span>
                </div>
                <div class="tr-score-detail">
                    <span class="tr-score-label"><?php echo e(__('messages.percentage')); ?></span>
                    <span class="tr-score-val big"><?php echo e($percentage); ?>%</span>
                </div>
                <?php
                    $tier =
                        $percentage >= 90
                            ? __('messages.tier_excellent')
                            : ($percentage >= 80
                                ? __('messages.tier_very_good')
                                : ($percentage >= 70
                                    ? __('messages.tier_good')
                                    : ($percentage >= 50
                                        ? __('messages.tier_acceptable')
                                        : __('messages.tier_needs_work'))));
                ?>
                <div class="tr-tier"><?php echo e($tier); ?></div>
            </div>
        </div>

        
        <div class="tr-subjects-section">
            <h2 class="tr-section-title"><?php echo e(__('messages.grade_details')); ?></h2>
            <div class="tr-subjects-grid">
                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $pct = round(($s['value'] / $s['max']) * 100); ?>
                    <div class="tr-subject-row">
                        <span class="tr-subject-name"><?php echo e($s['label']); ?></span>
                        <div class="tr-subject-bar-wrap">
                            <div class="tr-subject-bar">
                                <div class="tr-subject-fill"
                                    style="width: <?php echo e($pct); ?>%; --delay: <?php echo e($loop->index * 0.1); ?>s"></div>
                            </div>
                        </div>
                        <span class="tr-subject-score"><?php echo e($s['value']); ?>/<?php echo e($s['max']); ?></span>
                        <span class="tr-subject-pct"><?php echo e($pct); ?>%</span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>

        
        <div class="tr-tracks-section">
            <h2 class="tr-section-title"><?php echo e(__('messages.available_tracks')); ?></h2>


            <?php if(count($tracks) > 0): ?>
                <div class="tr-tracks-grid">
                    <?php
                        $trackMeta = [
                            'الصحي' => [
                                'icon' => '🏥',
                                'color' => '#e74c3c',
                                'desc' => 'مجال الطب والصيدلة والتمريض وعلوم الصحة',
                            ],
                            'الهندسي والتكنولوجي' => [
                                'icon' => '💻',
                                'color' => '#3498db',
                                'desc' => 'مجال الهندسة والحاسوب والتكنولوجيا',
                            ],
                            'الأعمال' => [
                                'icon' => '💼',
                                'color' => '#f39c12',
                                'desc' => 'مجال المحاسبة والاقتصاد وإدارة الأعمال',
                            ],
                            'اللغات والشريعة' => [
                                'icon' => '🌍',
                                'color' => '#9b59b6',
                                'desc' => 'مجال الترجمة والأدب واللغات الأجنبية',
                            ],
                            
                        ];
                    ?>
                    <?php $__currentLoopData = $tracks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $track): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $meta = $trackMeta[$track] ?? ['icon'=>'📚','color'=>'#667eea','desc'=>'']; ?>
                        <div class="tr-track-card"
                            style="--tc: <?php echo e($meta['color']); ?>; animation-delay: <?php echo e($i * 0.12); ?>s">
                            <?php if($i === 0): ?>
                                <div class="tr-track-badge"><?php echo e(__('messages.best')); ?></div>
                            <?php endif; ?>
                            <div class="tr-track-icon"><?php echo e($meta['icon']); ?></div>
                            <h3 class="tr-track-name"><?php echo e($track); ?></h3>
                            <p class="tr-track-desc"><?php echo e($meta['desc']); ?></p>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div class="tr-wa-box">
                    <div class="tr-wa-inner">
                        <span class="tr-wa-icon">📲</span>
                        <div class="tr-wa-text">
                            <span><?php echo e(__('messages.whatsapp_plan')); ?></span>
                        </div>
                        <a href="https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r" target="_blank" class="tr-wa-btn">
                            📱 <?php echo e(__('messages.join_now')); ?>

                        </a>
                    </div>
                </div>
            <?php else: ?>
                <div class="tr-no-tracks">
                    <div class="tr-no-icon">😔</div>
                    <h3><?php echo e(__('messages.below_50')); ?></h3>
                    <p><?php echo e(__('messages.below_50_desc')); ?></p>
                    <a href="https://whatsapp.com/channel/0029Vb35e8I2v1Ik7V9Khs3r" target="_blank" class="tr-wa-btn">
                        📱 <?php echo e(__('messages.get_help')); ?>

                    </a>
                </div>
            <?php endif; ?>
        </div>

<div class="tr-note-box">
    <div class="tr-note-icon">📌</div>
    <div class="tr-note-content">
        <p class="tr-note-line"><?php echo e(__('messages.note_track')); ?></p>
        <p class="tr-note-line"><?php echo e(__('messages.note2_track')); ?></p>
    </div>
</div>

        
        <div class="tr-actions">
            <a href="<?php echo e(route('track.show', $user->id)); ?>"
                class="tr-btn tr-btn--secondary"><?php echo e(__('messages.recalculate')); ?></a>
            <a href="<?php echo e(route('hub.home')); ?>" class="tr-btn tr-btn--primary"><?php echo e(__('messages.home_page')); ?></a>
        </div>

    </div>

    <style>
        .tr-note-box {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: rgba(255, 193, 7, 0.12);
    border: 1.5px solid rgba(255, 193, 7, 0.45);
    border-right: 5px solid #f39c12;
    border-radius: 14px;
    padding: 18px 20px;
    margin: 20px 0;
    animation: fadeInUp 0.6s ease-out 0.5s both;
}

.tr-note-icon {
    font-size: 22px;
    flex-shrink: 0;
    margin-top: 2px;
}

.tr-note-content {
    flex: 1;
}

.tr-note-line {
    font-size: 14px;
    color: #7d5a00;
    line-height: 1.7;
    margin: 0;
    font-weight: 500;
}

.tr-note-line + .tr-note-line {
    margin-top: 6px;
}

        .tr-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        /* Header */
        .tr-header {
            text-align: center;
            margin-bottom: 30px;
            position: relative;
            animation: fadeInDown 0.7s ease-out;
        }

        .tr-icon {
            font-size: 60px;
            margin-bottom: 10px;
            animation: bounceIn 0.8s ease-out;
        }

        .tr-title {
            font-size: 36px;
            font-weight: 800;
            color: var(--text-color);
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0.3);
                opacity: 0;
            }

            60% {
                transform: scale(1.1);
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        /* Score card */
        .tr-score-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 24px;
            padding: 32px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 30px;
            flex-wrap: wrap;
            box-shadow: 0 15px 40px rgba(102, 126, 234, 0.4);
            animation: fadeInUp 0.7s ease-out 0.2s both;
        }

        .tr-score-left {
            flex-shrink: 0;
        }

        .tr-score-circle {
            position: relative;
            width: 140px;
            height: 140px;
        }

        .tr-score-svg {
            width: 100%;
            height: 100%;
        }

        .tr-score-ring {
            transition: stroke-dashoffset 1.5s ease-out;
        }

        .tr-score-center {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            color: white;
        }

        .tr-score-num {
            font-size: 28px;
            font-weight: 800;
            line-height: 1;
        }

        .tr-score-sub {
            font-size: 12px;
            opacity: 0.8;
        }

        .tr-score-right {
            flex: 1;
            color: white;
        }

        .tr-score-detail {
            margin-bottom: 12px;
        }

        .tr-score-label {
            display: block;
            font-size: 13px;
            opacity: 0.75;
            margin-bottom: 3px;
        }

        .tr-score-val {
            font-size: 20px;
            font-weight: 700;
        }

        .tr-score-val.big {
            font-size: 32px;
        }

        .tr-tier {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 20px;
            color: white;
            font-weight: 700;
            font-size: 16px;
            margin-top: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        /* Subjects section */
        .tr-subjects-section {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 28px;
            margin-bottom: 28px;
            animation: fadeInUp 0.7s ease-out 0.3s both;
        }

        .tr-section-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--text-color);
            margin-bottom: 20px;
            text-align: center;
            position: relative;
        }

        .tr-section-title::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .tr-subjects-grid {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .tr-subject-row {
            display: grid;
            grid-template-columns: 1fr 3fr 80px 50px;
            align-items: center;
            gap: 10px;
        }

        .tr-subject-name {
            font-size: 14px;
            font-weight: 600;
            color: var(--text-color);
        }

        .tr-subject-bar-wrap {}

        .tr-subject-bar {
            height: 8px;
            background: #eee;
            border-radius: 4px;
            overflow: hidden;
        }

        .tr-subject-fill {
            height: 100%;
            background: linear-gradient(90deg, #667eea, #764ba2);
            border-radius: 4px;
            animation: fillBar 1.2s ease-out var(--delay) both;
        }

        @keyframes fillBar {
            from {
                width: 0% !important;
            }
        }

        .tr-subject-score {
            font-size: 13px;
            color: #666;
            text-align: center;
        }

        .tr-subject-pct {
            font-size: 13px;
            font-weight: 700;
            color: var(--primary-color);
            text-align: center;
        }

        /* Tracks */
        .tr-tracks-section {
            margin-bottom: 30px;
            animation: fadeInUp 0.7s ease-out 0.4s both;
        }

        .tr-tracks-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 18px;
            margin-bottom: 24px;
        }

        .tr-track-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 18px;
            padding: 24px 18px;
            text-align: center;
            border: 2px solid var(--tc);
            position: relative;
            transition: all 0.3s ease;
            animation: cardIn 0.5s ease-out both;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.07);
        }

        .tr-track-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .tr-track-badge {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: var(--tc);
            color: white;
            font-size: 11px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .tr-track-icon {
            font-size: 44px;
            margin: 8px 0 12px;
            animation: iconFloat 3s ease-in-out infinite;
        }

        .tr-track-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--tc);
            margin-bottom: 8px;
        }

        .tr-track-desc {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        @keyframes iconFloat {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-6px);
            }
        }

        @keyframes cardIn {
            from {
                transform: translateY(30px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* WA Box */
        .tr-wa-box {
            background: linear-gradient(135deg, #25D366, #128C7E);
            border-radius: 18px;
            padding: 22px 26px;
            box-shadow: 0 10px 30px rgba(37, 211, 102, 0.3);
        }

        .tr-wa-inner {
            display: flex;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
        }

        .tr-wa-icon {
            font-size: 36px;
            animation: bounce 2s infinite;
        }

        .tr-wa-text {
            flex: 1;
            color: white;
        }

        .tr-wa-text strong {
            display: block;
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .tr-wa-text span {
            font-size: 14px;
            opacity: 0.9;
        }

        .tr-wa-btn {
            background: white;
            color: #128C7E;
            padding: 12px 24px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 15px;
            font-weight: 700;
            transition: all 0.3s ease;
            white-space: nowrap;
        }

        .tr-wa-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: #128C7E;
            text-decoration: none;
        }

        /* No tracks */
        .tr-no-tracks {
            text-align: center;
            padding: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
        }

        .tr-no-icon {
            font-size: 60px;
            margin-bottom: 16px;
        }

        .tr-no-tracks h3 {
            font-size: 22px;
            color: var(--text-color);
            margin-bottom: 12px;
        }

        .tr-no-tracks p {
            color: #666;
            margin-bottom: 20px;
        }

        /* Actions */
        .tr-actions {
            display: flex;
            gap: 16px;
            justify-content: center;
            flex-wrap: wrap;
            margin-top: 30px;
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }

        .tr-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 14px 28px;
            border-radius: 30px;
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .tr-btn--primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .tr-btn--secondary {
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-color);
            border: 2px solid var(--border-color);
        }

        .tr-btn:hover {
            transform: translateY(-3px);
            text-decoration: none;
            color: inherit;
        }

        .tr-btn--primary:hover {
            color: white;
            box-shadow: 0 12px 30px rgba(102, 126, 234, 0.4);
        }

        @keyframes fadeInDown {
            from {
                transform: translateY(-25px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                transform: translateY(25px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        @media (max-width: 768px) {
            .tr-score-card {
                flex-direction: column;
                text-align: center;
            }

            .tr-subject-row {
                grid-template-columns: 1fr 2fr 60px;
            }

            .tr-subject-pct {
                display: none;
            }

            .tr-tracks-grid {
                grid-template-columns: 1fr 1fr;
            }

            .tr-actions {
                flex-direction: column;
                align-items: center;
            }

            .tr-btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }

            .tr-wa-inner {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/track-result.blade.php ENDPATH**/ ?>