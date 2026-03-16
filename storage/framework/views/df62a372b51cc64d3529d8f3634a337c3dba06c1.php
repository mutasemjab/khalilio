

<?php $__env->startSection('title', __('messages.Users')); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0"><?php echo e(__('messages.Users')); ?></h4>
                </div>
                <div class="card-body">
                    <?php if($users->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('messages.ID')); ?></th>
                                        <th><?php echo e(__('messages.Name')); ?></th>
                                        <th><?php echo e(__('messages.Phone')); ?></th>
                                        <th><?php echo e(__('messages.School Name')); ?></th>
                                        <th><?php echo e(__('messages.Arabic Grade')); ?></th>
                                        <th><?php echo e(__('messages.Math Grade')); ?></th>
                                        <th><?php echo e(__('messages.Jordan History Grade')); ?></th>
                                        <th><?php echo e(__('messages.Islamic Education Grade')); ?></th>
                                        <th><?php echo e(__('messages.Average')); ?></th>
                                        <th><?php echo e(__('messages.Created At')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($user->id); ?></td>
                                            <td><?php echo e($user->name); ?></td>
                                            <td><?php echo e($user->phone); ?></td>
                                            <td><?php echo e($user->school_name); ?></td>
                                            <td>
                                                <?php if($user->arabic_grade): ?>
                                                    <span class="badge badge-primary"><?php echo e($user->arabic_grade); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted"><?php echo e(__('messages.Not Set')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($user->math_grade): ?>
                                                    <span class="badge badge-success"><?php echo e($user->math_grade); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted"><?php echo e(__('messages.Not Set')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($user->jordan_history_grade): ?>
                                                    <span class="badge badge-info"><?php echo e($user->jordan_history_grade); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted"><?php echo e(__('messages.Not Set')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($user->islamic_education_grade): ?>
                                                    <span class="badge badge-warning"><?php echo e($user->islamic_education_grade); ?></span>
                                                <?php else: ?>
                                                    <span class="text-muted"><?php echo e(__('messages.Not Set')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if($user->average): ?>
                                                    <strong class="text-primary"><?php echo e(number_format($user->average, 2)); ?></strong>
                                                <?php else: ?>
                                                    <span class="text-muted"><?php echo e(__('messages.Not Calculated')); ?></span>
                                                <?php endif; ?>
                                            </td>
                                            <td><?php echo e($user->created_at->format('Y-m-d H:i')); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($users->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted"><?php echo e(__('messages.No Users Found')); ?></h5>
                            <p class="text-muted"><?php echo e(__('messages.No users have been registered yet')); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/admin/users/index.blade.php ENDPATH**/ ?>