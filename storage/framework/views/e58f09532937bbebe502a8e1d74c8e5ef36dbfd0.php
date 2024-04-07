<header class="page-topbar">
    <?php
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = App\Models\User::where('id', $vendor_id)->first();
    ?>
    <div class="navbar-header">
        <button class="navbar-toggler d-lg-none d-md-block px-4" type="button" data-bs-toggle="collapse"
            data-bs-target="#sidebarcollapse" aria-expanded="false" aria-controls="sidebarcollapse">
            <i class="fa-regular fa-bars fs-4"></i>
        </button>
        <div class="d-flex align-items-center gap-2">

            <?php if(session('vendor_login')): ?>
                <a href="<?php echo e(URL::to('/admin/admin_back')); ?>" title="<?php echo e(trans('labels.back_to_admin')); ?>"
                    class="btn btn-outline-primary btn-hover btn-sm tooltip-bottom"><i
                        class="fa-regular fa-user"></i></a>
            <?php endif; ?>
            <?php if(Auth::user()->type == 2 || Auth::user()->type == 4): ?>
                <a class="btn btn-outline-primary btn-hover btn-sm tooltip-bottom" title="<?php echo e(trans('labels.view_website')); ?>" href="<?php echo e(URL::to('/' . $user->slug)); ?>"
                    target="_blank"><i class="fa-solid fa-link"></i>
                </a>
            <?php endif; ?>
            <!-- dekstop-tablet-mobile-language-dropdown-button-start-->
            <?php if(helper::available_language('')->count() > 1): ?>
                <?php if(App\Models\SystemAddons::where('unique_identifier', 'language')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'language')->first()->activated == 1): ?>
                    <div class="position-relative">
                        <div class="dropdown">
                            <a class="btn btn-sm btn-outline-primary btn-hover dropdown-toggle" href="#"
                                role="button" data-bs-toggle ="dropdown" aria-expanded="false">
                                <i class="fa-regular fa-globe"></i>
                            </a>
                            <ul class="dropdown-menu drop-menu <?php echo e(session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu'); ?>">
                                <?php $__currentLoopData = helper::available_language(''); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $languagelist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li>
                                        <a class="dropdown-item d-flex align-items-center px-3 py-2"
                                            href="<?php echo e(URL::to('/lang/change?lang=' . $languagelist->code)); ?>">
                                            <img src="<?php echo e(helper::image_path($languagelist->image)); ?>" alt=""
                                                class="img-fluid lag-img" width="25px">
                                            <span class="px-2"><?php echo e($languagelist->name); ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- dekstop-tablet-mobile-language-dropdown-button-end-->
            <div class="dropwdown d-inline-block">
                <button class="btn header-item" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="<?php echo e(helper::image_path(Auth::user()->image)); ?>">
                    <span class="d-none d-xxl-inline-block d-xl-inline-block ms-1"><?php echo e(Auth::user()->name); ?></span>
                    <i class="fa-regular fa-angle-down d-none d-xxl-inline-block d-xl-inline-block"></i>
                </button>
                <div class="dropdown-menu box-shadow">
                    <a href="<?php echo e(URL::to('admin/settings')); ?>#editprofile"
                        class="dropdown-item d-flex align-items-center">
                        <i class="fa-light fa-address-card fs-5 mx-2"></i><?php echo e(trans('labels.edit_profile')); ?>

                    </a>
                    <a href="<?php echo e(URL::to('admin/settings')); ?>#changepasssword"
                        class="dropdown-item d-flex align-items-center">

                        <i class="fa-light fa-lock-keyhole fs-5 mx-2"></i><?php echo e(trans('labels.change_password')); ?>


                    </a>

                    <a href="javascript:void(0)" onclick="statusupdate('<?php echo e(URL::to('/admin/logout')); ?>')"
                        class="dropdown-item d-flex align-items-center">
                        <i class="fa-light fa-right-from-bracket fs-5 mx-2"></i><?php echo e(trans('labels.logout')); ?>

                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /home/emlhor/public_html/resources/views/admin/layout/header.blade.php ENDPATH**/ ?>