<?php $__env->startSection('title', __('messages.questions') . ' — ' . $quiz->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap" style="gap:12px">
        <div class="d-flex align-items-center">
            <a href="<?php echo e(route('admin.quizzes.index')); ?>"
               class="btn btn-sm btn-light border mr-3 qq-back-btn">
                <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> mr-1"></i>
                <?php echo e(__('messages.back_to_quizzes')); ?>

            </a>
            <div>
                <h4 class="mb-0 font-weight-bold">❓ <?php echo e(__('messages.questions')); ?></h4>
                <p class="text-muted small mb-0"><?php echo e($quiz->name); ?></p>
            </div>
        </div>
        <a href="<?php echo e(route('admin.quizzes.edit', $quiz->id)); ?>"
           class="btn btn-sm btn-light border">
            <i class="fas fa-cog mr-1"></i> <?php echo e(__('messages.edit_quiz')); ?>

        </a>
    </div>


    
    <div class="qq-marks-panel <?php echo e($isComplete ? 'qq-marks-panel--complete' : ($currentSum > $quiz->total_marks ? 'qq-marks-panel--over' : '')); ?>">
        <div class="qq-marks-header">
            <div class="qq-marks-label">
                <i class="fas fa-star mr-1"></i>
                <?php echo e(app()->getLocale() == 'ar' ? 'توزيع العلامات' : 'Marks Distribution'); ?>

            </div>
            <div class="qq-marks-numbers">
                <span class="qq-marks-used"><?php echo e($currentSum); ?></span>
                <span class="qq-marks-sep">/</span>
                <span class="qq-marks-total"><?php echo e($quiz->total_marks); ?></span>
                <?php if($isComplete): ?>
                    <span class="qq-marks-complete-badge">
                        <i class="fas fa-check-circle mr-1"></i>
                        <?php echo e(app()->getLocale() == 'ar' ? 'مكتمل' : 'Complete'); ?>

                    </span>
                <?php elseif($remainingMarks > 0): ?>
                    <span class="qq-marks-remaining-badge">
                        <?php echo e(app()->getLocale() == 'ar' ? "متبقي: {$remainingMarks}" : "Remaining: {$remainingMarks}"); ?>

                    </span>
                <?php else: ?>
                    <span class="qq-marks-over-badge">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <?php echo e(app()->getLocale() == 'ar' ? 'تجاوز الحد' : 'Over limit'); ?>

                    </span>
                <?php endif; ?>
            </div>
        </div>
        <div class="qq-marks-bar-wrap">
            <?php
                $pct = $quiz->total_marks > 0
                    ? min(100, round(($currentSum / $quiz->total_marks) * 100))
                    : 0;
            ?>
            <div class="qq-marks-bar">
                <div class="qq-marks-bar-fill" style="width: <?php echo e($pct); ?>%"></div>
            </div>
            <span class="qq-marks-pct"><?php echo e($pct); ?>%</span>
        </div>

        
        <?php if($questions->count() > 0): ?>
        <div class="qq-marks-chips">
            <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="qq-marks-chip" data-toggle="tooltip"
                 title="<?php echo e($q->question_text); ?>">
                <span class="qq-chip-num">س<?php echo e($i+1); ?></span>
                <span class="qq-chip-grade"><?php echo e($q->grade); ?><?php echo e(app()->getLocale() == 'ar' ? 'ع' : 'pt'); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php if($remainingMarks > 0): ?>
            <div class="qq-marks-chip qq-marks-chip--empty">
                <span class="qq-chip-num">...</span>
                <span class="qq-chip-grade"><?php echo e($remainingMarks); ?><?php echo e(app()->getLocale() == 'ar' ? 'ع' : 'pt'); ?></span>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <div class="row">

        
        <div class="col-md-5 col-lg-4">
            <div class="card border-0 shadow-sm rounded-lg qq-add-card">
                <div class="card-header qq-card-header">
                    <i class="fas fa-plus-circle mr-2 text-primary"></i>
                    <?php echo e(__('messages.add_question')); ?>

                    <?php if($isComplete): ?>
                        <span class="badge badge-warning mr-2" style="font-size:11px">
                            <?php echo e(app()->getLocale() == 'ar' ? 'العلامات مكتملة' : 'Marks Full'); ?>

                        </span>
                    <?php endif; ?>
                </div>
                <div class="card-body">

                    <?php if($isComplete): ?>
                    <div class="alert alert-warning border-0 rounded-lg py-2 mb-3" style="font-size:13px">
                        <i class="fas fa-lock mr-1"></i>
                        <?php echo e(app()->getLocale() == 'ar'
                            ? "مجموع العلامات ({$quiz->total_marks}) مكتمل. لإضافة سؤال جديد، احذف سؤالاً موجوداً أولاً أو عدّل العلامة الكاملة للامتحان."
                            : "Total marks ({$quiz->total_marks}) are fully assigned. Delete an existing question or edit the quiz total marks."); ?>

                    </div>
                    <?php endif; ?>

                    <form method="POST"
                          action="<?php echo e(route('admin.quizzes.questions.store', $quiz->id)); ?>"
                          enctype="multipart/form-data"
                          id="addQuestionForm">
                        <?php echo csrf_field(); ?>

                        
                        <div class="form-group">
                            <label class="qq-label">
                                <?php echo e(__('messages.question_text')); ?>

                                <span class="qq-required">*</span>
                            </label>
                            <textarea name="question_text"
                                      class="form-control qq-input <?php $__errorArgs = ['question_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                      rows="3"
                                      placeholder="<?php echo e(app()->getLocale() == 'ar' ? 'اكتب السؤال هنا...' : 'Write the question here...'); ?>"
                                      required><?php echo e(old('question_text')); ?></textarea>
                            <?php $__errorArgs = ['question_text'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-group">
                            <label class="qq-label">
                                <i class="fas fa-star text-warning mr-1"></i>
                                <?php echo e(app()->getLocale() == 'ar' ? 'علامة هذا السؤال' : 'Question Grade'); ?>

                                <span class="qq-required">*</span>
                            </label>
                            <div class="qq-grade-wrap">
                                <div class="input-group">
                                    <input type="number"
                                           name="grade"
                                           id="gradeInput"
                                           value="<?php echo e(old('grade', $remainingMarks > 0 ? min(1, $remainingMarks) : 1)); ?>"
                                           class="form-control qq-input qq-grade-input <?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           min="1"
                                           max="<?php echo e($quiz->total_marks); ?>"
                                           required>
                                    <div class="input-group-append">
                                        <span class="input-group-text qq-grade-suffix">
                                            <?php echo e(app()->getLocale() == 'ar' ? 'من' : 'of'); ?>

                                            <strong class="mx-1" id="remainingDisplay"><?php echo e($remainingMarks); ?></strong>
                                            <?php echo e(app()->getLocale() == 'ar' ? 'متبقي' : 'rem.'); ?>

                                        </span>
                                    </div>
                                </div>
                                <?php $__errorArgs = ['grade'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                
                                <div class="qq-quick-grades mt-2">
                                    <?php $__currentLoopData = [1,2,3,4,5]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($g <= $remainingMarks): ?>
                                    <button type="button" class="qq-quick-btn"
                                            onclick="document.getElementById('gradeInput').value = <?php echo e($g); ?>">
                                        <?php echo e($g); ?>

                                    </button>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($remainingMarks > 0): ?>
                                    <button type="button" class="qq-quick-btn qq-quick-btn--all"
                                            onclick="document.getElementById('gradeInput').value = <?php echo e($remainingMarks); ?>"
                                            data-toggle="tooltip"
                                            title="<?php echo e(app()->getLocale() == 'ar' ? 'استخدم كل العلامات المتبقية' : 'Use all remaining marks'); ?>">
                                        <?php echo e(app()->getLocale() == 'ar' ? 'الكل' : 'All'); ?> (<?php echo e($remainingMarks); ?>)
                                    </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="qq-label"><?php echo e(__('messages.question_type')); ?></label>
                            <div class="qq-type-toggle">
                                <label class="qq-type-option" id="lbl_mc">
                                    <input type="radio" name="type" value="multiple_choice"
                                           <?php echo e(old('type', 'multiple_choice') == 'multiple_choice' ? 'checked' : ''); ?>

                                           onchange="switchType('multiple_choice')">
                                    <span><i class="fas fa-list-ul mr-1"></i><?php echo e(__('messages.multiple_choice')); ?></span>
                                </label>
                                <label class="qq-type-option" id="lbl_tf">
                                    <input type="radio" name="type" value="true_false"
                                           <?php echo e(old('type') == 'true_false' ? 'checked' : ''); ?>

                                           onchange="switchType('true_false')">
                                    <span><i class="fas fa-check-double mr-1"></i><?php echo e(__('messages.true_false')); ?></span>
                                </label>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="qq-label">
                                <?php echo e(__('messages.question_image')); ?>

                                <small class="text-muted">(<?php echo e(__('messages.optional_field')); ?>)</small>
                            </label>
                            <div class="qq-img-upload" onclick="document.getElementById('inp_qimg').click()">
                                <div id="qq_img_prev">
                                    <i class="fas fa-image qq-img-icon"></i>
                                    <span><?php echo e(app()->getLocale() == 'ar' ? 'انقر لرفع صورة' : 'Click to upload'); ?></span>
                                </div>
                                <img id="qq_img_preview" src="" alt="" class="qq-img-preview d-none">
                            </div>
                            <input type="file" name="question_image" id="inp_qimg"
                                   class="d-none" accept="image/*"
                                   onchange="previewQImg(this)">
                        </div>

                        
                        <div id="mc_options_section">
                            <div class="qq-options-grid">
                                <?php $__currentLoopData = ['a'=>'A','b'=>'B','c'=>'C','d'=>'D']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="form-group">
                                    <label class="qq-label qq-option-label qq-opt-<?php echo e($key); ?>"><?php echo e($letter); ?></label>
                                    <input type="text" name="option_<?php echo e($key); ?>"
                                           value="<?php echo e(old('option_' . $key)); ?>"
                                           class="form-control qq-input qq-option-input"
                                           placeholder="<?php echo e(__('messages.option_' . $key)); ?>">
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="form-group" id="mc_correct_section">
                                <label class="qq-label">
                                    <?php echo e(__('messages.correct_answer')); ?>

                                    <span class="qq-required">*</span>
                                </label>
                                <div class="qq-correct-grid">
                                    <?php $__currentLoopData = ['A','B','C','D']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <label class="qq-correct-opt qq-opt-<?php echo e(strtolower($letter)); ?>">
                                        <input type="radio" name="correct_answer" value="<?php echo e($letter); ?>"
                                               <?php echo e(old('correct_answer') == $letter ? 'checked' : ''); ?>>
                                        <span><?php echo e($letter); ?></span>
                                    </label>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                                <?php $__errorArgs = ['correct_answer'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="text-danger small mt-1"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        
                        <div id="tf_correct_section" class="d-none">
                            <div class="form-group">
                                <label class="qq-label">
                                    <?php echo e(__('messages.correct_answer')); ?>

                                    <span class="qq-required">*</span>
                                </label>
                                <div class="qq-tf-grid">
                                    <label class="qq-tf-opt qq-tf-true">
                                        <input type="radio" name="correct_answer_tf" value="true"
                                               <?php echo e(old('correct_answer_tf') == 'true' ? 'checked' : ''); ?>>
                                        <span>✅ <?php echo e(__('messages.true_label')); ?></span>
                                    </label>
                                    <label class="qq-tf-opt qq-tf-false">
                                        <input type="radio" name="correct_answer_tf" value="false"
                                               <?php echo e(old('correct_answer_tf') == 'false' ? 'checked' : ''); ?>>
                                        <span>❌ <?php echo e(__('messages.false_label')); ?></span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="qq-label"><?php echo e(__('messages.question_order')); ?></label>
                            <input type="number" name="order"
                                   value="<?php echo e(old('order', $questions->count() + 1)); ?>"
                                   class="form-control qq-input" min="1">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block qq-add-btn"
                                <?php echo e($isComplete ? 'disabled' : ''); ?>>
                            <i class="fas fa-plus mr-2"></i>
                            <?php echo e(__('messages.add_question')); ?>

                        </button>

                    </form>
                </div>
            </div>
        </div>

        
        <div class="col-md-7 col-lg-8">
            <?php if($questions->count() > 0): ?>
            <div class="qq-questions-list">
                <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="card border-0 shadow-sm rounded-lg mb-3 qq-question-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div class="d-flex align-items-start flex-grow-1" style="gap:14px">
                                <div class="qq-num-badge"><?php echo e($i + 1); ?></div>
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center flex-wrap mb-1" style="gap:8px">
                                        <span class="qq-type-badge <?php echo e($q->type == 'true_false' ? 'qq-type-badge--tf' : 'qq-type-badge--mc'); ?>">
                                            <i class="fas <?php echo e($q->type == 'true_false' ? 'fa-check-double' : 'fa-list-ul'); ?> mr-1"></i>
                                            <?php echo e($q->type == 'true_false' ? __('messages.true_false') : __('messages.multiple_choice')); ?>

                                        </span>
                                        
                                        <span class="qq-grade-badge">
                                            <i class="fas fa-star mr-1"></i>
                                            <?php echo e($q->grade); ?>

                                            <?php echo e(app()->getLocale() == 'ar' ? 'علامة' : 'pt'); ?>

                                        </span>
                                    </div>
                                    <p class="qq-question-text mb-2"><?php echo e($q->question_text); ?></p>

                                    <?php if($q->question_image): ?>
                                    <div class="qq-question-img mb-2">
                                        <img src="<?php echo e(asset('storage/' . $q->question_image)); ?>"
                                             alt="" class="qq-q-img"
                                             onclick="openImgModal('<?php echo e(asset('storage/'.$q->question_image)); ?>')"
                                             data-toggle="tooltip" title="<?php echo e(__('messages.view')); ?>">
                                    </div>
                                    <?php endif; ?>

                                    <?php if($q->type === 'true_false'): ?>
                                    <div class="qq-tf-display">
                                        <span class="qq-tf-item <?php echo e($q->correct_answer == 'true' ? 'correct' : ''); ?>">
                                            ✅ <?php echo e(__('messages.true_label')); ?>

                                            <?php if($q->correct_answer == 'true'): ?><i class="fas fa-check-circle mr-1 text-success"></i><?php endif; ?>
                                        </span>
                                        <span class="qq-tf-item <?php echo e($q->correct_answer == 'false' ? 'correct' : ''); ?>">
                                            ❌ <?php echo e(__('messages.false_label')); ?>

                                            <?php if($q->correct_answer == 'false'): ?><i class="fas fa-check-circle mr-1 text-success"></i><?php endif; ?>
                                        </span>
                                    </div>
                                    <?php else: ?>
                                    <div class="qq-mc-display">
                                        <?php $__currentLoopData = ['A'=>$q->option_a,'B'=>$q->option_b,'C'=>$q->option_c,'D'=>$q->option_d]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $letter => $text): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($text): ?>
                                        <div class="qq-mc-item <?php echo e($q->correct_answer == $letter ? 'correct' : ''); ?>">
                                            <span class="qq-mc-letter qq-opt-<?php echo e(strtolower($letter)); ?>"><?php echo e($letter); ?></span>
                                            <span class="qq-mc-text"><?php echo e($text); ?></span>
                                            <?php if($q->correct_answer == $letter): ?><i class="fas fa-check-circle text-success mr-auto"></i><?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <form method="POST"
                                  action="<?php echo e(route('admin.quizzes.questions.destroy', $q->id)); ?>"
                                  style="margin:0;flex-shrink:0"
                                  onsubmit="return confirm('<?php echo e(__('messages.confirm_delete_question')); ?>')">
                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-sm qq-delete-btn"
                                        data-toggle="tooltip" title="<?php echo e(__('messages.delete')); ?>">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div class="qq-empty">
                <div class="qq-empty-icon">❓</div>
                <h5><?php echo e(__('messages.no_questions')); ?></h5>
                <p class="text-muted"><?php echo e(__('messages.no_questions_desc')); ?></p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>


<div class="modal fade" id="imgModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-lg overflow-hidden">
            <div class="modal-header border-0 pb-0">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body pt-0 text-center">
                <img id="modalQImg" src="" alt="" style="max-width:100%;border-radius:10px">
            </div>
        </div>
    </div>
</div>

<style>
.qq-back-btn { color: #495057; font-size: 13px; }
.qq-card-header { background: #f8f9fa; font-weight: 600; font-size: 14px; color: #495057; padding: 14px 20px; border-bottom: 1px solid #e9ecef; display: flex; align-items: center; }
.qq-add-card { position: sticky; top: 20px; }

/* ── Marks panel ───────────────────────────── */
.qq-marks-panel { background: rgba(255,255,255,0.98); border: 2px solid #e9ecef; border-radius: 14px; padding: 16px 20px; margin-bottom: 22px; transition: border-color 0.3s ease; }
.qq-marks-panel--complete { border-color: rgba(40,167,69,0.4); background: rgba(40,167,69,0.02); }
.qq-marks-panel--over { border-color: rgba(220,53,69,0.4); background: rgba(220,53,69,0.02); }
.qq-marks-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px; }
.qq-marks-label { font-size: 13px; font-weight: 700; color: #495057; }
.qq-marks-numbers { display: flex; align-items: center; gap: 6px; font-size: 15px; }
.qq-marks-used { font-size: 24px; font-weight: 800; color: #667eea; line-height: 1; }
.qq-marks-sep { color: #ccc; font-size: 18px; }
.qq-marks-total { font-size: 18px; font-weight: 700; color: #333; }
.qq-marks-complete-badge { background: rgba(40,167,69,0.12); color: #28a745; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.qq-marks-remaining-badge { background: rgba(102,126,234,0.1); color: #667eea; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 20px; }
.qq-marks-over-badge { background: rgba(220,53,69,0.1); color: #dc3545; font-size: 12px; font-weight: 700; padding: 3px 10px; border-radius: 20px; }
.qq-marks-bar-wrap { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
.qq-marks-bar { flex: 1; height: 10px; background: #eee; border-radius: 6px; overflow: hidden; }
.qq-marks-bar-fill { height: 100%; background: linear-gradient(90deg, #667eea, #764ba2); border-radius: 6px; transition: width 0.6s ease; }
.qq-marks-panel--complete .qq-marks-bar-fill { background: linear-gradient(90deg, #28a745, #20c997); }
.qq-marks-panel--over .qq-marks-bar-fill { background: #dc3545; }
.qq-marks-pct { font-size: 13px; font-weight: 700; color: #666; width: 38px; text-align: right; flex-shrink: 0; }
.qq-marks-chips { display: flex; flex-wrap: wrap; gap: 6px; }
.qq-marks-chip { display: flex; flex-direction: column; align-items: center; background: rgba(102,126,234,0.08); border: 1px solid rgba(102,126,234,0.15); border-radius: 8px; padding: 4px 8px; min-width: 40px; }
.qq-marks-chip--empty { background: rgba(0,0,0,0.04); border-style: dashed; border-color: #ccc; }
.qq-chip-num { font-size: 10px; color: #888; line-height: 1; }
.qq-chip-grade { font-size: 13px; font-weight: 700; color: #667eea; }
.qq-marks-chip--empty .qq-chip-grade { color: #aaa; }

/* ── Grade input ───────────────────────────── */
.qq-grade-input { font-size: 18px; font-weight: 700; text-align: center; color: #f7971e; }
.qq-grade-suffix { font-size: 12px; background: #f8f9fa; color: #555; }
.qq-quick-grades { display: flex; gap: 6px; flex-wrap: wrap; }
.qq-quick-btn { padding: 4px 12px; border: 1px solid #ddd; background: white; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.15s ease; color: #555; }
.qq-quick-btn:hover { border-color: #f7971e; background: rgba(247,151,30,0.08); color: #f7971e; }
.qq-quick-btn--all { border-color: #667eea; color: #667eea; }
.qq-quick-btn--all:hover { background: rgba(102,126,234,0.1); }

/* Grade badge on question card */
.qq-grade-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 12px; font-weight: 700; background: rgba(247,151,30,0.12); color: #c07800; }

/* Existing styles */
.qq-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 7px; display: block; }
.qq-required { color: #dc3545; }
.qq-input { border-radius: 10px; border-color: #e0e0e0; font-size: 14px; padding: 10px 14px; transition: all 0.2s ease; }
.qq-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.12); }
textarea.qq-input { border-radius: 10px; }
.qq-type-toggle { display: flex; gap: 8px; }
.qq-type-option { flex: 1; cursor: pointer; margin: 0; }
.qq-type-option input { display: none; }
.qq-type-option span { display: flex; align-items: center; justify-content: center; padding: 10px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 13px; font-weight: 600; color: #888; transition: all 0.2s ease; white-space: nowrap; }
.qq-type-option input:checked + span { border-color: #667eea; background: rgba(102,126,234,0.08); color: #667eea; }
.qq-img-upload { border: 2px dashed #d0d0d0; border-radius: 10px; padding: 14px; text-align: center; cursor: pointer; transition: all 0.25s ease; background: #fafafa; min-height: 65px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
.qq-img-upload:hover { border-color: #667eea; }
.qq-img-icon { font-size: 18px; color: #aaa; display: block; margin-bottom: 3px; }
#qq_img_prev { display: flex; flex-direction: column; align-items: center; }
#qq_img_prev span { font-size: 12px; color: #888; }
.qq-img-preview { width: 100%; max-height: 70px; object-fit: cover; border-radius: 8px; }
.qq-options-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0 12px; }
.qq-option-label { width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: white; margin-bottom: 5px; }
.qq-opt-a { background: #667eea; }
.qq-opt-b { background: #f5576c; }
.qq-opt-c { background: #f7971e; }
.qq-opt-d { background: #43e97b; color: #005a1f; }
.qq-option-input { font-size: 13px; padding: 8px 12px; }
.qq-correct-grid { display: flex; gap: 8px; }
.qq-correct-opt { flex: 1; cursor: pointer; margin: 0; }
.qq-correct-opt input { display: none; }
.qq-correct-opt span { display: flex; align-items: center; justify-content: center; width: 100%; padding: 10px; border-radius: 10px; font-size: 15px; font-weight: 800; color: white; transition: all 0.2s ease; opacity: 0.5; }
.qq-correct-opt input:checked + span { opacity: 1; transform: scale(1.05); box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.qq-correct-opt.qq-opt-a span { background: #667eea; }
.qq-correct-opt.qq-opt-b span { background: #f5576c; }
.qq-correct-opt.qq-opt-c span { background: #f7971e; }
.qq-correct-opt.qq-opt-d span { background: #43e97b; color: #005a1f; }
.qq-tf-grid { display: flex; gap: 8px; }
.qq-tf-opt { flex: 1; cursor: pointer; margin: 0; }
.qq-tf-opt input { display: none; }
.qq-tf-opt span { display: flex; align-items: center; justify-content: center; padding: 10px; border: 2px solid #e0e0e0; border-radius: 10px; font-size: 14px; font-weight: 600; transition: all 0.2s ease; }
.qq-tf-true input:checked + span { border-color: #28a745; background: rgba(40,167,69,0.08); color: #28a745; }
.qq-tf-false input:checked + span { border-color: #dc3545; background: rgba(220,53,69,0.08); color: #dc3545; }
.qq-add-btn { border-radius: 10px; padding: 12px; font-size: 15px; font-weight: 600; }
.qq-num-badge { width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, #667eea, #764ba2); color: white; display: flex; align-items: center; justify-content: center; font-size: 14px; font-weight: 700; flex-shrink: 0; }
.qq-question-card { transition: all 0.2s ease; }
.qq-question-card:hover { box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important; }
.qq-type-badge { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 11px; font-weight: 600; }
.qq-type-badge--mc { background: rgba(102,126,234,0.1); color: #667eea; }
.qq-type-badge--tf { background: rgba(67,233,123,0.1); color: #0ba360; }
.qq-question-text { font-size: 15px; font-weight: 600; color: #333; margin: 0; }
.qq-question-img .qq-q-img { max-height: 80px; border-radius: 8px; cursor: pointer; border: 1px solid #e9ecef; }
.qq-mc-display { display: flex; flex-direction: column; gap: 5px; }
.qq-mc-item { display: flex; align-items: center; gap: 8px; padding: 6px 10px; border-radius: 8px; font-size: 13px; background: #f8f9fa; border: 1px solid #eee; }
.qq-mc-item.correct { background: rgba(40,167,69,0.08); border-color: rgba(40,167,69,0.25); }
.qq-mc-letter { width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 800; color: white; flex-shrink: 0; }
.qq-mc-text { flex: 1; color: #555; }
.qq-tf-display { display: flex; gap: 8px; flex-wrap: wrap; }
.qq-tf-item { display: flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 20px; font-size: 13px; background: #f8f9fa; border: 1px solid #eee; }
.qq-tf-item.correct { background: rgba(40,167,69,0.08); border-color: rgba(40,167,69,0.3); font-weight: 600; }
.qq-delete-btn { background: transparent; color: #ccc; border: none; padding: 5px 8px; border-radius: 8px; transition: all 0.2s ease; flex-shrink: 0; }
.qq-delete-btn:hover { background: rgba(220,53,69,0.1); color: #dc3545; }
.qq-empty { text-align: center; padding: 50px 20px; }
.qq-empty-icon { font-size: 50px; display: block; margin-bottom: 14px; }
.qq-empty h5 { font-weight: 600; color: #495057; margin-bottom: 8px; }
</style>

<script>
function switchType(type) {
    const isTF = type === 'true_false';
    document.getElementById('mc_options_section').classList.toggle('d-none', isTF);
    document.getElementById('tf_correct_section').classList.toggle('d-none', !isTF);
    const mcCorrect = document.querySelector('[name="correct_answer"]');
    const tfCorrect = document.querySelector('[name="correct_answer_tf"]');
    if (mcCorrect && tfCorrect) {
        if (isTF) {
            mcCorrect.setAttribute('name', 'correct_answer_disabled');
            tfCorrect.setAttribute('name', 'correct_answer');
        } else {
            tfCorrect.setAttribute('name', 'correct_answer_tf');
            mcCorrect.setAttribute('name', 'correct_answer');
        }
    }
}

function previewQImg(input) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        document.getElementById('qq_img_preview').src = e.target.result;
        document.getElementById('qq_img_preview').classList.remove('d-none');
        document.getElementById('qq_img_prev').classList.add('d-none');
    };
    reader.readAsDataURL(file);
}

function openImgModal(src) {
    document.getElementById('modalQImg').src = src;
    $('#imgModal').modal('show');
}

// Validate grade input doesn't exceed remaining
const gradeInput = document.getElementById('gradeInput');
const remaining  = <?php echo e($remainingMarks); ?>;
if (gradeInput) {
    gradeInput.setAttribute('max', remaining);
    gradeInput.addEventListener('input', function() {
        if (parseInt(this.value) > remaining) {
            this.value = remaining;
        }
    });
}

const checkedType = document.querySelector('[name="type"]:checked');
if (checkedType) switchType(checkedType.value);

$(function() { $('[data-toggle="tooltip"]').tooltip(); });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/admin/quizzes/questions.blade.php ENDPATH**/ ?>