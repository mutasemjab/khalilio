<?php $__env->startSection('title', __('messages.edit_quiz')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo e(route('admin.quizzes.index')); ?>"
           class="btn btn-sm btn-light border mr-3 qz-back-btn">
            <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> mr-1"></i>
            <?php echo e(__('messages.back_to_quizzes')); ?>

        </a>
        <div>
            <h4 class="mb-0 font-weight-bold">
                <span style="font-size:20px;margin-left:6px">✏️</span>
                <?php echo e(__('messages.edit_quiz')); ?>:
                <span class="text-primary"><?php echo e($quiz->name); ?></span>
            </h4>
        </div>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
        </div>
    <?php endif; ?>

    
    <div class="row mb-4">
        <div class="col-sm-4 col-md-2">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body py-3 text-center">
                    <div class="qz-stat-num text-primary"><?php echo e($quiz->questions->count()); ?></div>
                    <div class="qz-stat-label"><?php echo e(__('messages.questions_count')); ?></div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-2">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body py-3 text-center">
                    <div class="qz-stat-num text-success"><?php echo e($quiz->attempts->count()); ?></div>
                    <div class="qz-stat-label"><?php echo e(__('messages.attempts_count')); ?></div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 col-md-3">
            <a href="<?php echo e(route('admin.quizzes.questions', $quiz->id)); ?>"
               class="card border-0 shadow-sm rounded-lg text-decoration-none qz-manage-card">
                <div class="card-body py-3 d-flex align-items-center gap-2" style="gap:10px">
                    <i class="fas fa-list-ul text-primary" style="font-size:20px"></i>
                    <div>
                        <div class="font-weight-600 text-dark"><?php echo e(__('messages.manage_questions')); ?></div>
                        <small class="text-muted"><?php echo e(__('messages.add_question')); ?></small>
                    </div>
                    <i class="fas fa-chevron-<?php echo e(app()->getLocale() == 'ar' ? 'left' : 'right'); ?> text-muted mr-auto"></i>
                </div>
            </a>
        </div>
    </div>

    <form method="POST" action="<?php echo e(route('admin.quizzes.update', $quiz->id)); ?>" id="editQuizForm">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <div class="row">
            <div class="col-md-8">

                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header qz-card-header">
                        <i class="fas fa-info-circle mr-2 text-primary"></i>
                        <?php echo e(__('messages.quiz_details')); ?>

                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="qz-label">
                                <?php echo e(__('messages.quiz_name')); ?>

                                <span class="qz-required">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="<?php echo e(old('name', $quiz->name)); ?>"
                                   class="form-control qz-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="form-group">
                            <label class="qz-label"><?php echo e(__('messages.quiz_description')); ?></label>
                            <textarea name="description"
                                      class="form-control qz-input"
                                      rows="3"><?php echo e(old('description', $quiz->description)); ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="qz-label">
                                        <?php echo e(__('messages.duration_minutes')); ?>

                                        <span class="qz-required">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="duration_minutes"
                                               value="<?php echo e(old('duration_minutes', $quiz->duration_minutes)); ?>"
                                               class="form-control qz-input"
                                               min="1" max="180" required>
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="qz-label">&nbsp;</label>
                                    <div class="qz-toggle-wrap" style="margin-top:6px">
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox"
                                                   class="custom-control-input"
                                                   name="is_active"
                                                   id="isActive"
                                                   value="1"
                                                   <?php echo e(old('is_active', $quiz->is_active) ? 'checked' : ''); ?>>
                                            <label class="custom-control-label qz-label" for="isActive">
                                                <?php echo e(__('messages.quiz_active')); ?>

                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header qz-card-header">
                        <i class="fas fa-layer-group mr-2 text-success"></i>
                        <?php echo e(__('messages.whatsapp_links')); ?>

                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label class="qz-label">🏆 <?php echo e(__('messages.whatsapp_group_a')); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text qz-wa-prepend"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" name="whatsapp_a"
                                       value="<?php echo e(old('whatsapp_a', $quiz->whatsapp_a)); ?>"
                                       class="form-control qz-input <?php $__errorArgs = ['whatsapp_a'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="<?php echo e(__('messages.whatsapp_link_hint')); ?>">
                                <?php if($quiz->whatsapp_a): ?>
                                    <div class="input-group-append">
                                        <a href="<?php echo e($quiz->whatsapp_a); ?>" target="_blank"
                                           class="btn btn-outline-success btn-sm"
                                           data-toggle="tooltip" title="<?php echo e(__('messages.view')); ?>">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php $__errorArgs = ['whatsapp_a'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="qz-label">⭐ <?php echo e(__('messages.whatsapp_group_b')); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text qz-wa-prepend"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" name="whatsapp_b"
                                       value="<?php echo e(old('whatsapp_b', $quiz->whatsapp_b)); ?>"
                                       class="form-control qz-input <?php $__errorArgs = ['whatsapp_b'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="<?php echo e(__('messages.whatsapp_link_hint')); ?>">
                                <?php if($quiz->whatsapp_b): ?>
                                    <div class="input-group-append">
                                        <a href="<?php echo e($quiz->whatsapp_b); ?>" target="_blank"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                <?php $__errorArgs = ['whatsapp_b'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>

                        <div class="form-group mb-0">
                            <label class="qz-label">📚 <?php echo e(__('messages.whatsapp_group_c')); ?></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text qz-wa-prepend"><i class="fab fa-whatsapp"></i></span>
                                </div>
                                <input type="url" name="whatsapp_c"
                                       value="<?php echo e(old('whatsapp_c', $quiz->whatsapp_c)); ?>"
                                       class="form-control qz-input <?php $__errorArgs = ['whatsapp_c'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       placeholder="<?php echo e(__('messages.whatsapp_link_hint')); ?>">
                                <?php if($quiz->whatsapp_c): ?>
                                    <div class="input-group-append">
                                        <a href="<?php echo e($quiz->whatsapp_c); ?>" target="_blank"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="fas fa-external-link-alt"></i>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <div class="col-md-4">
                
                <div class="card border-0 shadow-sm rounded-lg border-danger" style="border: 1px solid #f5c6cb !important;">
                    <div class="card-header" style="background:#fff5f5;border-bottom:1px solid #f5c6cb;font-weight:600;font-size:14px;color:#721c24;padding:14px 20px">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <?php echo e(app()->getLocale() == 'ar' ? 'منطقة الخطر' : 'Danger Zone'); ?>

                    </div>
                    <div class="card-body">
                        <p class="small text-muted mb-3"><?php echo e(__('messages.confirm_delete_quiz')); ?></p>
                        <form method="POST"
                              action="<?php echo e(route('admin.quizzes.update', $quiz->id)); ?>"
                              onsubmit="return confirm('<?php echo e(__('messages.confirm_delete_quiz')); ?>')">
                            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-outline-danger btn-sm btn-block">
                                <i class="fas fa-trash-alt mr-1"></i> <?php echo e(__('messages.delete')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="qz-submit-bar">
            <a href="<?php echo e(route('admin.quizzes.index')); ?>" class="btn btn-light border px-4">
                <?php echo e(__('messages.cancel')); ?>

            </a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save mr-2"></i> <?php echo e(__('messages.save')); ?>

            </button>
        </div>

    </form>
</div>

<style>
.qz-back-btn { color: #495057; font-size: 13px; }
.qz-card-header { background: #f8f9fa; font-weight: 600; font-size: 14px; color: #495057; padding: 14px 20px; border-bottom: 1px solid #e9ecef; }
.qz-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 7px; display: block; }
.qz-required { color: #dc3545; }
.qz-input { border-radius: 10px; border-color: #e0e0e0; font-size: 14px; padding: 10px 14px; transition: all 0.2s ease; }
.qz-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.12); }
.qz-toggle-wrap { padding: 12px 16px; background: #f8f9fa; border-radius: 10px; border: 1px solid #e9ecef; }
.qz-wa-prepend { background: #25D366; color: white; border-color: #25D366; }
.qz-stat-num { font-size: 24px; font-weight: 700; line-height: 1; }
.qz-stat-label { font-size: 12px; color: #888; margin-top: 3px; }
.qz-manage-card:hover { background: #f8f9ff; border-color: #667eea !important; }
.font-weight-600 { font-weight: 600; }
.qz-submit-bar { display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding: 20px 0; }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/admin/quizzes/edit.blade.php ENDPATH**/ ?>