<?php $__env->startSection('title', 'الامتحان - ' . $quiz->name); ?>

<?php $__env->startSection('content'); ?>
<div class="qt-wrapper">

    
    <div class="qt-sticky-bar">
        <div class="qt-sticky-inner">
            <div class="qt-quiz-name">🧮 <?php echo e($quiz->name); ?></div>
            <div class="qt-timer" id="timer">
                <span class="qt-timer-icon">⏱️</span>
                <span id="timerDisplay"><?php echo e(str_pad($quiz->duration_minutes, 2, '0', STR_PAD_LEFT)); ?>:00</span>
            </div>
            <div class="qt-progress-text">
                <span id="answeredCount">0</span> / <?php echo e($questions->count()); ?>

            </div>
        </div>
        <div class="qt-progress-bar-full">
            <div class="qt-progress-bar-fill" id="progressBarFill" style="width:0%"></div>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('quiz.submit', $quiz->id)); ?>" id="quizForm">
        <?php echo csrf_field(); ?>
        <div class="qt-questions">
            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="qt-question-card" id="qCard<?php echo e($question->id); ?>" data-answered="false" style="animation-delay: <?php echo e($i * 0.08); ?>s">
                <div class="qt-q-number">
                    <span class="qt-q-num-badge"><?php echo e($i + 1); ?></span>
                    <span class="qt-q-type"><?php echo e($question->type == 'true_false' ? 'صح / خطأ' : 'اختيار متعدد'); ?></span>
                </div>

                <div class="qt-q-text"><?php echo e($question->question_text); ?></div>

                <?php if($question->question_image): ?>
                <div class="qt-q-image">
                    <img src="<?php echo e(asset('assets/admin/uploads/' . $question->question_image)); ?>" alt="صورة السؤال">
                </div>
                <?php endif; ?>

                <div class="qt-options">
                    <?php if($question->type === 'true_false'): ?>
                        <label class="qt-option" for="q<?php echo e($question->id); ?>_true">
                            <input type="radio" name="q_<?php echo e($question->id); ?>" id="q<?php echo e($question->id); ?>_true" value="true" onchange="markAnswered(<?php echo e($question->id); ?>)">
                            <span class="qt-option-icon">✅</span>
                            <span class="qt-option-text">صحيح</span>
                        </label>
                        <label class="qt-option" for="q<?php echo e($question->id); ?>_false">
                            <input type="radio" name="q_<?php echo e($question->id); ?>" id="q<?php echo e($question->id); ?>_false" value="false" onchange="markAnswered(<?php echo e($question->id); ?>)">
                            <span class="qt-option-icon">❌</span>
                            <span class="qt-option-text">خطأ</span>
                        </label>
                    <?php else: ?>
                        <?php $__currentLoopData = ['A'=>$question->option_a,'B'=>$question->option_b,'C'=>$question->option_c,'D'=>$question->option_d]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($text): ?>
                        <label class="qt-option" for="q<?php echo e($question->id); ?>_<?php echo e($letter); ?>">
                            <input type="radio" name="q_<?php echo e($question->id); ?>" id="q<?php echo e($question->id); ?>_<?php echo e($letter); ?>" value="<?php echo e($letter); ?>" onchange="markAnswered(<?php echo e($question->id); ?>)">
                            <span class="qt-option-letter"><?php echo e($letter); ?></span>
                            <span class="qt-option-text"><?php echo e($text); ?></span>
                        </label>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="qt-submit-section">
            <div class="qt-submit-info">
                <span id="finalAnswered">0</span> من <?php echo e($questions->count()); ?> سؤال تمت الإجابة عليه
            </div>
            <button type="submit" class="qt-submit-btn" id="submitBtn" onclick="return confirmSubmit()">
                <span>📤</span> تسليم الامتحان
            </button>
        </div>
    </form>

</div>

<style>
.qt-wrapper { max-width: 800px; margin: 0 auto; }

/* Sticky bar */
.qt-sticky-bar {
    position: sticky; top: 0; z-index: 100;
    background: linear-gradient(135deg, #f093fb, #f5576c);
    border-radius: 0 0 16px 16px; margin: -40px -40px 30px;
    box-shadow: 0 4px 20px rgba(245,87,108,0.35);
    overflow: hidden;
}
@media (max-width: 768px) { .qt-sticky-bar { margin: -25px -25px 24px; } }
.qt-sticky-inner { display: flex; align-items: center; justify-content: space-between; padding: 14px 20px; color: white; }
.qt-quiz-name { font-size: 15px; font-weight: 700; flex: 1; }
.qt-timer { display: flex; align-items: center; gap: 8px; font-size: 22px; font-weight: 800; background: rgba(255,255,255,0.2); padding: 8px 16px; border-radius: 20px; }
.qt-timer.urgent { animation: timerPulse 1s ease-in-out infinite; color: #ffeb3b; }
@keyframes timerPulse { 0%,100% { background: rgba(255,0,0,0.3); } 50% { background: rgba(255,0,0,0.6); } }
.qt-progress-text { font-size: 14px; font-weight: 600; opacity: 0.9; }
.qt-progress-bar-full { height: 5px; background: rgba(255,255,255,0.25); }
.qt-progress-bar-fill { height: 100%; background: white; transition: width 0.4s ease; }

/* Question cards */
.qt-questions { display: flex; flex-direction: column; gap: 20px; margin-bottom: 30px; }
.qt-question-card {
    background: rgba(255,255,255,0.97); border-radius: 18px; padding: 24px;
    border: 2px solid rgba(0,0,0,0.06); transition: all 0.3s ease;
    animation: cardIn 0.5s ease-out both;
}
.qt-question-card.answered { border-color: #4facfe; background: rgba(79,172,254,0.04); }
@keyframes cardIn { from { transform: translateY(25px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

.qt-q-number { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; }
.qt-q-num-badge {
    display: inline-flex; align-items: center; justify-content: center;
    width: 34px; height: 34px; background: linear-gradient(135deg, #f093fb, #f5576c);
    color: white; border-radius: 50%; font-size: 15px; font-weight: 800;
    box-shadow: 0 4px 12px rgba(245,87,108,0.3);
}
.qt-q-type { font-size: 12px; color: #888; background: #f0f0f0; padding: 3px 10px; border-radius: 10px; }

.qt-q-text { font-size: 17px; font-weight: 600; color: var(--text-color); margin-bottom: 16px; line-height: 1.6; }
.qt-q-image { margin-bottom: 16px; border-radius: 12px; overflow: hidden; }
.qt-q-image img { width: 100%; max-height: 280px; object-fit: contain; background: #f8f9fa; }

/* Options */
.qt-options { display: flex; flex-direction: column; gap: 10px; }
.qt-option {
    display: flex; align-items: center; gap: 12px;
    padding: 14px 18px; border-radius: 12px; cursor: pointer;
    border: 2px solid var(--border-color); background: white;
    transition: all 0.2s ease; position: relative;
}
.qt-option:hover { border-color: #f5576c; background: rgba(245,87,108,0.04); transform: translateX(-3px); }
html[dir="ltr"] .qt-option:hover { transform: translateX(3px); }
.qt-option input[type="radio"] { display: none; }
.qt-option:has(input:checked) { border-color: #f5576c; background: rgba(245,87,108,0.08); }
.qt-option-letter { width: 30px; height: 30px; border-radius: 50%; background: rgba(0,0,0,0.06); display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; flex-shrink: 0; transition: all 0.2s ease; }
.qt-option:has(input:checked) .qt-option-letter { background: #f5576c; color: white; }
.qt-option-icon { font-size: 20px; flex-shrink: 0; }
.qt-option-text { font-size: 15px; color: var(--text-color); flex: 1; }

/* Submit */
.qt-submit-section {
    background: rgba(255,255,255,0.97); border-radius: 20px; padding: 28px;
    text-align: center; border: 2px solid rgba(0,0,0,0.06);
    animation: fadeInUp 0.6s ease-out 0.5s both;
}
.qt-submit-info { font-size: 16px; color: #666; margin-bottom: 20px; }
.qt-submit-btn {
    display: inline-flex; align-items: center; gap: 12px; padding: 18px 50px;
    background: linear-gradient(135deg, #f093fb, #f5576c); color: white; border: none;
    border-radius: 50px; font-size: 20px; font-weight: 700; font-family: inherit;
    cursor: pointer; transition: all 0.3s ease; box-shadow: 0 10px 30px rgba(245,87,108,0.35);
}
.qt-submit-btn:hover { transform: translateY(-3px); box-shadow: 0 16px 40px rgba(245,87,108,0.45); }

@keyframes fadeInUp { from { transform: translateY(25px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
</style>

<script>
// Timer
let totalSeconds = <?php echo e($quiz->duration_minutes * 60); ?>;
let timerId;

function startTimer() {
    timerId = setInterval(() => {
        totalSeconds--;
        if (totalSeconds <= 0) {
            clearInterval(timerId);
            document.getElementById('quizForm').submit();
            return;
        }
        const m = Math.floor(totalSeconds / 60).toString().padStart(2,'0');
        const s = (totalSeconds % 60).toString().padStart(2,'0');
        document.getElementById('timerDisplay').textContent = `${m}:${s}`;
        if (totalSeconds < 120) {
            document.getElementById('timer').classList.add('urgent');
        }
    }, 1000);
}

// Track answered
let answeredSet = new Set();
function markAnswered(qId) {
    answeredSet.add(qId);
    document.getElementById('qCard' + qId).classList.add('answered');
    document.getElementById('answeredCount').textContent = answeredSet.size;
    document.getElementById('finalAnswered').textContent = answeredSet.size;
    const total = <?php echo e($questions->count()); ?>;
    document.getElementById('progressBarFill').style.width = (answeredSet.size / total * 100) + '%';
}

function confirmSubmit() {
    const total = <?php echo e($questions->count()); ?>;
    const answered = answeredSet.size;
    if (answered < total) {
        return confirm(`لم تجب على ${total - answered} سؤال بعد. هل تريد التسليم الآن؟`);
    }
    return true;
}

startTimer();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/user/quiz-take.blade.php ENDPATH**/ ?>