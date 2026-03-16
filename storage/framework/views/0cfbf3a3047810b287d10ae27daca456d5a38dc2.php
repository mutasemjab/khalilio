

<aside class="main-sidebar sidebar-dark-primary elevation-4">

    
    <a href="<?php echo e(route('admin.dashboard')); ?>" class="brand-link">
        <img src="<?php echo e(asset('assets/admin/dist/img/AdminLTELogo.png')); ?>"
             alt="AdminLTE Logo"
             class="brand-image img-circle elevation-3"
             style="opacity:.8">
        <span class="brand-text font-weight-light">Khalilio</span>
    </a>

    <div class="sidebar">

        
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?php echo e(asset('assets/admin/dist/img/user2-160x160.jpg')); ?>"
                     class="img-circle elevation-2"
                     alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo e(auth()->user()->name); ?></a>
            </div>
        </div>

        
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column"
                data-widget="treeview"
                role="menu"
                data-accordion="false">

                
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p><?php echo e(__('messages.dashboard')); ?></p>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a href="<?php echo e(route('users.index')); ?>"
                       class="nav-link <?php echo e(request()->routeIs('users.*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-user-graduate"></i>
                        <p><?php echo e(__('messages.students')); ?></p>
                    </a>
                </li>

                
                <li class="nav-header"
                    style="font-size:10px;letter-spacing:1px;opacity:.6;padding:10px 16px 4px">
                    <?php echo e(app()->getLocale() == 'ar' ? 'المنصة التعليمية' : 'PLATFORM'); ?>

                </li>

                
                <li class="nav-item <?php echo e(request()->routeIs('admin.top-students.*') ? 'menu-open' : ''); ?>">
                    <a href="#"
                       class="nav-link <?php echo e(request()->routeIs('admin.top-students.*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-trophy" style="color:#ffd200"></i>
                        <p>
                            <?php echo e(__('messages.top_students')); ?>

                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.top-students.index')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('admin.top-students.index') ? 'active' : ''); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo e(__('messages.top_students_list')); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.top-students.create')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('admin.top-students.create') ? 'active' : ''); ?>">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p><?php echo e(__('messages.add_top_student')); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li class="nav-item <?php echo e(request()->routeIs('admin.quizzes.*') ? 'menu-open' : ''); ?>">
                    <a href="#"
                       class="nav-link <?php echo e(request()->routeIs('admin.quizzes.*') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-calculator" style="color:#4facfe"></i>
                        <p>
                            <?php echo e(__('messages.quizzes')); ?>

                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.quizzes.index')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('admin.quizzes.index') ? 'active' : ''); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p><?php echo e(__('messages.quizzes_list')); ?></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?php echo e(route('admin.quizzes.create')); ?>"
                               class="nav-link <?php echo e(request()->routeIs('admin.quizzes.create') ? 'active' : ''); ?>">
                                <i class="far fa-plus-square nav-icon"></i>
                                <p><?php echo e(__('messages.add_quiz')); ?></p>
                            </a>
                        </li>
                    </ul>
                </li>

                
                <li class="nav-header"
                    style="font-size:10px;letter-spacing:1px;opacity:.6;padding:10px 16px 4px">
                    <?php echo e(app()->getLocale() == 'ar' ? 'روابط سريعة' : 'QUICK LINKS'); ?>

                </li>

                
                <li class="nav-item">
                    <a href="<?php echo e(route('hub')); ?>" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-external-link-alt" style="color:#a8edea"></i>
                        <p><?php echo e(app()->getLocale() == 'ar' ? 'الصفحة الرئيسية' : 'Frontend Hub'); ?></p>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a href="<?php echo e(route('top-students.index')); ?>" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-star" style="color:#ffd200"></i>
                        <p><?php echo e(app()->getLocale() == 'ar' ? 'صفحة الأوائل' : 'Top Students Page'); ?></p>
                    </a>
                </li>

                
                <li class="nav-item">
                    <a href="<?php echo e(route('quiz.landing')); ?>" target="_blank" class="nav-link">
                        <i class="nav-icon fas fa-pen-alt" style="color:#f093fb"></i>
                        <p><?php echo e(app()->getLocale() == 'ar' ? 'صفحة الامتحان' : 'Quiz Page'); ?></p>
                    </a>
                </li>

            </ul>
        </nav>

    </div>
</aside>
<?php /**PATH C:\xampp\htdocs\khalil\resources\views/admin/includes/sidebar.blade.php ENDPATH**/ ?>