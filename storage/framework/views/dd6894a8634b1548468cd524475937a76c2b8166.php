<?php $__env->startSection('title', __('messages.quizzes')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h4 class="mb-1 font-weight-bold">
                <span class="qz-icon-badge">🧮</span>
                <?php echo e(__('messages.quizzes')); ?>

            </h4>
            <p class="text-muted mb-0 small"><?php echo e(__('messages.quizzes_list')); ?></p>
        </div>
        <a href="<?php echo e(route('admin.quizzes.create')); ?>" class="btn btn-primary btn-sm px-4">
            <i class="fas fa-plus mr-1"></i> <?php echo e(__('messages.add_quiz')); ?>

        </a>
    </div>

 

    
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm rounded-lg">
                <div class="card-body p-0">
                    <?php if($quizzes->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 qz-table">
                            <thead>
                                <tr>
                                    <th class="pl-4"><?php echo e(__('messages.ID')); ?></th>
                                    <th><?php echo e(__('messages.quiz_name')); ?></th>
                                    <th><?php echo e(__('messages.duration_minutes')); ?></th>
                                    <th><?php echo e(__('messages.questions_count')); ?></th>
                                    <th><?php echo e(__('messages.attempts_count')); ?></th>
                                    <th><?php echo e(__('messages.whatsapp_links')); ?></th>
                                    <th><?php echo e(__('messages.status')); ?></th>
                                    <th><?php echo e(__('messages.created_at')); ?></th>
                                    <th class="text-center"><?php echo e(__('messages.actions')); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $quizzes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $quiz): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="qz-row">
                                    <td class="pl-4 text-muted small"><?php echo e($quiz->id); ?></td>

                                    
                                    <td>
                                        <div class="font-weight-600"><?php echo e($quiz->name); ?></div>
                                        <?php if($quiz->description): ?>
                                            <small class="text-muted"><?php echo e(Str::limit($quiz->description, 50)); ?></small>
                                        <?php endif; ?>
                                    </td>

                                    
                                    <td>
                                        <span class="qz-duration-badge">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?php echo e($quiz->duration_minutes); ?> <?php echo e(__('messages.minutes')); ?>

                                        </span>
                                    </td>

                                    
                                    <td>
                                        <a href="<?php echo e(route('admin.quizzes.questions', $quiz->id)); ?>"
                                           class="qz-count-badge qz-count-badge--q"
                                           data-toggle="tooltip"
                                           title="<?php echo e(__('messages.manage_questions')); ?>">
                                            <i class="fas fa-question-circle mr-1"></i>
                                            <?php echo e($quiz->questions_count ?? $quiz->questions->count()); ?>

                                        </a>
                                    </td>

                                    
                                    <td>
                                        <span class="qz-count-badge qz-count-badge--a">
                                            <i class="fas fa-users mr-1"></i>
                                            <?php echo e($quiz->attempts->count() ?? 0); ?>

                                        </span>
                                    </td>

                                    
                                    <td>
                                        <div class="qz-wa-dots">
                                            <span class="qz-wa-dot <?php echo e($quiz->whatsapp_a ? 'filled' : ''); ?>"
                                                  data-toggle="tooltip" title="A: <?php echo e($quiz->whatsapp_a ? __('messages.yes') : __('messages.not_available')); ?>">
                                                A
                                            </span>
                                            <span class="qz-wa-dot <?php echo e($quiz->whatsapp_b ? 'filled' : ''); ?>"
                                                  data-toggle="tooltip" title="B: <?php echo e($quiz->whatsapp_b ? __('messages.yes') : __('messages.not_available')); ?>">
                                                B
                                            </span>
                                            <span class="qz-wa-dot <?php echo e($quiz->whatsapp_c ? 'filled' : ''); ?>"
                                                  data-toggle="tooltip" title="C: <?php echo e($quiz->whatsapp_c ? __('messages.yes') : __('messages.not_available')); ?>">
                                                C
                                            </span>
                                        </div>
                                    </td>

                                    
                                    <td>
                                        <?php if($quiz->is_active): ?>
                                            <span class="badge qz-badge-active">
                                                <i class="fas fa-circle mr-1" style="font-size:7px;vertical-align:middle"></i>
                                                <?php echo e(__('messages.active')); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge qz-badge-inactive">
                                                <i class="fas fa-circle mr-1" style="font-size:7px;vertical-align:middle"></i>
                                                <?php echo e(__('messages.inactive')); ?>

                                            </span>
                                        <?php endif; ?>
                                    </td>

                                    <td class="text-muted small">
                                        <?php echo e($quiz->created_at->format('Y-m-d')); ?>

                                    </td>

                                    
                                    <td class="text-center">
                                        <div class="qz-actions">
                                            <a href="<?php echo e(route('admin.quizzes.questions', $quiz->id)); ?>"
                                               class="btn btn-sm qz-btn-questions"
                                               data-toggle="tooltip"
                                               title="<?php echo e(__('messages.manage_questions')); ?>">
                                                <i class="fas fa-list"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.quizzes.edit', $quiz->id)); ?>"
                                               class="btn btn-sm qz-btn-edit"
                                               data-toggle="tooltip"
                                               title="<?php echo e(__('messages.edit')); ?>">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST"
                                                  action="<?php echo e(route('admin.quizzes.update', $quiz->id)); ?>"
                                                  style="display:inline"
                                                  id="deleteQuiz<?php echo e($quiz->id); ?>">
                                                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                            </form>
                                            <button type="button"
                                                    class="btn btn-sm qz-btn-delete"
                                                    data-toggle="tooltip"
                                                    title="<?php echo e(__('messages.delete')); ?>"
                                                    onclick="confirmDeleteQuiz(<?php echo e($quiz->id); ?>)">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(method_exists($quizzes, 'links')): ?>
                    <div class="d-flex justify-content-center py-3">
                        <?php echo e($quizzes->links()); ?>

                    </div>
                    <?php endif; ?>

                    <?php else: ?>
                    <div class="qz-empty-state">
                        <div class="qz-empty-icon">🧮</div>
                        <h5><?php echo e(__('messages.no_quizzes')); ?></h5>
                        <p class="text-muted"><?php echo e(__('messages.no_quizzes_desc')); ?></p>
                        <a href="<?php echo e(route('admin.quizzes.create')); ?>" class="btn btn-primary btn-sm px-4">
                            <i class="fas fa-plus mr-1"></i> <?php echo e(__('messages.add_quiz')); ?>

                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-lg">
            <div class="modal-body text-center p-4">
                <div style="font-size:44px;margin-bottom:12px">⚠️</div>
                <h6 class="font-weight-bold mb-2"><?php echo e(__('messages.delete')); ?></h6>
                <p class="text-muted small mb-4"><?php echo e(__('messages.confirm_delete_quiz')); ?></p>
                <div class="d-flex gap-2 justify-content-center" style="gap:10px">
                    <button type="button" class="btn btn-light btn-sm px-4" data-dismiss="modal">
                        <?php echo e(__('messages.cancel')); ?>

                    </button>
                    <button type="button" class="btn btn-danger btn-sm px-4" id="confirmDeleteBtn">
                        <?php echo e(__('messages.delete')); ?>

                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.qz-icon-badge { font-size: 22px; margin-left: 6px; vertical-align: middle; }
.qz-table thead th { background: #f8f9fa; font-size: 12px; font-weight: 600; text-transform: uppercase; letter-spacing: .5px; color: #6c757d; border-bottom: 2px solid #e9ecef; padding: 14px 12px; white-space: nowrap; }
.qz-table tbody td { vertical-align: middle; padding: 12px 12px; border-color: #f0f0f0; }
.qz-row:hover { background: #fafbff !important; }
.font-weight-600 { font-weight: 600; }

.qz-duration-badge { display: inline-flex; align-items: center; padding: 4px 10px; background: rgba(79,172,254,0.12); color: #2980b9; border-radius: 20px; font-size: 13px; font-weight: 600; }

.qz-count-badge { display: inline-flex; align-items: center; padding: 4px 10px; border-radius: 20px; font-size: 13px; font-weight: 600; text-decoration: none; }
.qz-count-badge--q { background: rgba(102,126,234,0.12); color: #667eea; }
.qz-count-badge--q:hover { background: rgba(102,126,234,0.25); color: #5563c1; text-decoration: none; }
.qz-count-badge--a { background: rgba(40,167,69,0.12); color: #28a745; }

.qz-wa-dots { display: flex; gap: 5px; }
.qz-wa-dot { width: 24px; height: 24px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: #bbb; cursor: default; }
.qz-wa-dot.filled { background: rgba(37,211,102,0.2); color: #128C7E; }

.qz-badge-active { background: rgba(40,167,69,0.12); color: #1a7a34; font-size: 12px; padding: 5px 10px; border-radius: 20px; }
.qz-badge-inactive { background: rgba(108,117,125,0.12); color: #5a6268; font-size: 12px; padding: 5px 10px; border-radius: 20px; }

.qz-actions { display: flex; gap: 6px; justify-content: center; }
.qz-btn-questions { background: rgba(102,126,234,0.1); color: #667eea; border: 1px solid rgba(102,126,234,0.2); border-radius: 8px; padding: 5px 10px; transition: all 0.2s; }
.qz-btn-questions:hover { background: #667eea; color: white; }
.qz-btn-edit { background: rgba(255,193,7,0.12); color: #d39e00; border: 1px solid rgba(255,193,7,0.25); border-radius: 8px; padding: 5px 10px; transition: all 0.2s; }
.qz-btn-edit:hover { background: #ffc107; color: white; }
.qz-btn-delete { background: rgba(220,53,69,0.1); color: #dc3545; border: 1px solid rgba(220,53,69,0.2); border-radius: 8px; padding: 5px 10px; transition: all 0.2s; }
.qz-btn-delete:hover { background: #dc3545; color: white; }

.qz-empty-state { text-align: center; padding: 60px 20px; }
.qz-empty-icon { font-size: 56px; margin-bottom: 16px; display: block; }
.qz-empty-state h5 { font-weight: 600; color: #495057; margin-bottom: 8px; }
</style>

<script>
let deleteTargetId = null;
function confirmDeleteQuiz(id) {
    deleteTargetId = id;
    $('#deleteModal').modal('show');
}
document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
    if (deleteTargetId) {
        const form = document.getElementById('deleteQuiz' + deleteTargetId);
        form.submit();
    }
});
$(function() { $('[data-toggle="tooltip"]').tooltip(); });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/admin/quizzes/index.blade.php ENDPATH**/ ?>