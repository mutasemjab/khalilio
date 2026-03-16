<?php $__env->startSection('title', __('messages.add_top_student')); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">

    
    <div class="d-flex align-items-center mb-4">
        <a href="<?php echo e(route('admin.top-students.index')); ?>"
           class="btn btn-sm btn-light border mr-3 ts-back-btn">
            <i class="fas fa-arrow-<?php echo e(app()->getLocale() == 'ar' ? 'right' : 'left'); ?> mr-1"></i>
            <?php echo e(__('messages.back_to_top_students')); ?>

        </a>
        <div>
            <h4 class="mb-0 font-weight-bold">
                <span style="font-size:20px;margin-left:6px">🏆</span>
                <?php echo e(__('messages.add_top_student')); ?>

            </h4>
        </div>
    </div>

    <form method="POST"
          action="<?php echo e(route('admin.top-students.store')); ?>"
          enctype="multipart/form-data"
          id="createStudentForm">
        <?php echo csrf_field(); ?>

        <div class="row">

            
            <div class="col-md-7">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header ts-card-header">
                        <i class="fas fa-user-graduate mr-2 text-primary"></i>
                        <?php echo e(__('messages.top_student_details')); ?>

                    </div>
                    <div class="card-body">

                        
                        <div class="form-group">
                            <label class="ts-label">
                                <?php echo e(__('messages.student_name')); ?>

                                <span class="ts-required">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   value="<?php echo e(old('name')); ?>"
                                   class="form-control ts-input <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="<?php echo e(__('messages.student_name')); ?>"
                                   required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-group">
                            <label class="ts-label"><?php echo e(__('messages.school_name_label')); ?></label>
                            <input type="text"
                                   name="school_name"
                                   value="<?php echo e(old('school_name')); ?>"
                                   class="form-control ts-input <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   placeholder="<?php echo e(__('messages.school_name_label')); ?>">
                            <?php $__errorArgs = ['school_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label"><?php echo e(__('messages.average_label')); ?></label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="average"
                                               value="<?php echo e(old('average')); ?>"
                                               class="form-control ts-input <?php $__errorArgs = ['average'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               step="0.01" min="0" max="100"
                                               placeholder="98.50">
                                        <div class="input-group-append">
                                            <span class="input-group-text">%</span>
                                        </div>
                                    </div>
                                    <?php $__errorArgs = ['average'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label"><?php echo e(__('messages.rank_label')); ?></label>
                                    <input type="text"
                                           name="rank"
                                           value="<?php echo e(old('rank')); ?>"
                                           class="form-control ts-input <?php $__errorArgs = ['rank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           placeholder="<?php echo e(__('messages.rank_example')); ?>">
                                    <?php $__errorArgs = ['rank'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="ts-label"><?php echo e(__('messages.display_order')); ?></label>
                                    <input type="number"
                                           name="order"
                                           value="<?php echo e(old('order', 0)); ?>"
                                           class="form-control ts-input"
                                           min="0">
                                </div>
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <div class="ts-toggle-wrap">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox"
                                           class="custom-control-input"
                                           name="is_active"
                                           id="isActive"
                                           value="1"
                                           <?php echo e(old('is_active', true) ? 'checked' : ''); ?>>
                                    <label class="custom-control-label ts-label" for="isActive">
                                        <?php echo e(__('messages.is_active')); ?>

                                        <small class="text-muted d-block"><?php echo e(__('messages.is_active_desc')); ?></small>
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            
            <div class="col-md-5">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header ts-card-header">
                        <i class="fas fa-images mr-2 text-success"></i>
                        <?php echo e(__('messages.photos_section')); ?>

                    </div>
                    <div class="card-body">

                        
                        <div class="form-group ts-photo-group">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">👤</span>
                                <?php echo e(__('messages.student_photo')); ?>

                            </label>
                            <div class="ts-upload-zone" id="zone_photo" onclick="document.getElementById('inp_photo').click()">
                                <div class="ts-upload-preview" id="prev_photo">
                                    <i class="fas fa-user-circle ts-upload-icon"></i>
                                    <span><?php echo e(__('messages.upload_photo')); ?></span>
                                    <small class="text-muted"><?php echo e(__('messages.photo_hint')); ?></small>
                                </div>
                                <img id="img_photo" src="" alt="" class="ts-upload-img d-none">
                            </div>
                            <input type="file" name="photo" id="inp_photo"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_photo', 'prev_photo')">
                            <?php $__errorArgs = ['photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-group ts-photo-group">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">📋</span>
                                <?php echo e(__('messages.grades_photo')); ?>

                            </label>
                            <div class="ts-upload-zone ts-upload-zone--sm" id="zone_grades" onclick="document.getElementById('inp_grades').click()">
                                <div class="ts-upload-preview" id="prev_grades">
                                    <i class="fas fa-file-alt ts-upload-icon"></i>
                                    <span><?php echo e(__('messages.upload_photo')); ?></span>
                                    <small class="text-muted"><?php echo e(__('messages.photo_hint')); ?></small>
                                </div>
                                <img id="img_grades" src="" alt="" class="ts-upload-img d-none">
                            </div>
                            <input type="file" name="grades_photo" id="inp_grades"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_grades', 'prev_grades')">
                            <?php $__errorArgs = ['grades_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        
                        <div class="form-group ts-photo-group mb-0">
                            <label class="ts-label">
                                <span class="ts-photo-label-icon">🏅</span>
                                <?php echo e(__('messages.certificate_photo')); ?>

                            </label>
                            <div class="ts-upload-zone ts-upload-zone--sm" id="zone_cert" onclick="document.getElementById('inp_cert').click()">
                                <div class="ts-upload-preview" id="prev_cert">
                                    <i class="fas fa-certificate ts-upload-icon"></i>
                                    <span><?php echo e(__('messages.upload_photo')); ?></span>
                                    <small class="text-muted"><?php echo e(__('messages.photo_hint')); ?></small>
                                </div>
                                <img id="img_cert" src="" alt="" class="ts-upload-img d-none">
                            </div>
                            <input type="file" name="certificate_photo" id="inp_cert"
                                   class="d-none" accept="image/*"
                                   onchange="previewPhoto(this, 'img_cert', 'prev_cert')">
                            <?php $__errorArgs = ['certificate_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="text-danger small mt-1"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                    </div>
                </div>
            </div>

        </div>

        
        <div class="ts-submit-bar">
            <a href="<?php echo e(route('admin.top-students.index')); ?>"
               class="btn btn-light border px-4">
                <?php echo e(__('messages.cancel')); ?>

            </a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="fas fa-save mr-2"></i> <?php echo e(__('messages.save')); ?>

            </button>
        </div>

    </form>
</div>

<style>
.ts-back-btn { color: #495057; font-size: 13px; }
.ts-card-header { background: #f8f9fa; font-weight: 600; font-size: 14px; color: #495057; padding: 14px 20px; border-bottom: 1px solid #e9ecef; }
.ts-label { font-size: 13px; font-weight: 600; color: #495057; margin-bottom: 7px; }
.ts-required { color: #dc3545; margin-right: 3px; }
.ts-input { border-radius: 10px; border-color: #e0e0e0; font-size: 14px; padding: 10px 14px; transition: all 0.2s ease; }
.ts-input:focus { border-color: #667eea; box-shadow: 0 0 0 3px rgba(102,126,234,0.12); }
.ts-toggle-wrap { padding: 14px; background: #f8f9fa; border-radius: 10px; border: 1px solid #e9ecef; }

/* Photo upload zones */
.ts-photo-label-icon { font-size: 16px; margin-left: 6px; }
html[dir="ltr"] .ts-photo-label-icon { margin-left: 0; margin-right: 6px; }
.ts-upload-zone {
    border: 2px dashed #d0d0d0; border-radius: 12px; padding: 20px;
    text-align: center; cursor: pointer; transition: all 0.25s ease;
    background: #fafafa; min-height: 110px;
    display: flex; align-items: center; justify-content: center;
    position: relative; overflow: hidden;
}
.ts-upload-zone:hover { border-color: #667eea; background: rgba(102,126,234,0.04); }
.ts-upload-zone--sm { min-height: 80px; padding: 14px; }
.ts-upload-preview { display: flex; flex-direction: column; align-items: center; gap: 5px; pointer-events: none; }
.ts-upload-icon { font-size: 28px; color: #aaa; }
.ts-upload-zone--sm .ts-upload-icon { font-size: 20px; }
.ts-upload-preview span { font-size: 13px; font-weight: 500; color: #888; }
.ts-upload-preview small { font-size: 11px; }
.ts-upload-img { width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; border-radius: 10px; }

/* Submit bar */
.ts-submit-bar { display: flex; align-items: center; justify-content: flex-end; gap: 12px; padding: 20px 0; }
</style>

<script>
function previewPhoto(input, imgId, prevId) {
    const file = input.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById(imgId);
        const prev = document.getElementById(prevId);
        img.src = e.target.result;
        img.classList.remove('d-none');
        prev.classList.add('d-none');
    };
    reader.readAsDataURL(file);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\khalil\resources\views/admin/top-students/create.blade.php ENDPATH**/ ?>