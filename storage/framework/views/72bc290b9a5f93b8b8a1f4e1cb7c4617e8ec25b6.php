<?php $__env->startSection('content'); ?>
    <div class="d-flex mb-3">
        <h5 class="text-uppercase"><?php echo e(trans('labels.dashboard')); ?></h5>
    </div>
    <div class="row">
        <?php
            if(Auth::user()->type == 4){
                $vendor_id = Auth::user()->vendor_id;
            }else{
                $vendor_id = Auth::user()->id;
            }
        ?>
        <?php if(Auth::user()->type == 1): ?>
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-regular fa-user fs-5"></i>
                            </span>
                            <span class="<?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.users')); ?></p>
                                <h4><?php echo e($totalvendors); ?></h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-regular fa-medal fs-5"></i>
                            </span>
                            <span class="<?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                                <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.pricing_plans')); ?></p>
                                <h4><?php echo e($totalplans); ?></h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if(Auth::user()->type == 2 || Auth::user()->type == 4): ?>
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-solid fa-list-timeline fs-5"></i>
                            </span>
                            <span class="<?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.products')); ?></p>
                                <h4><?php echo e($totalvendors); ?></h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-regular fa-medal fs-5"></i>
                            </span>
                            <span class="<?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.current_plan')); ?></p>
                                <?php if(!empty($currentplanname)): ?>
                                    <h4> <?php echo e(@$currentplanname->name); ?> </h4>
                                <?php else: ?>
                                    <i class="fa-regular fa-exclamation-triangle h4 text-muted"></i>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <?php if(Auth::user()->type == 1): ?>
                                <i class="fa-solid fa-ballot-check fs-5"></i>
                            <?php else: ?>
                                <i class="fa-regular fa-cart-shopping fs-5"></i>
                            <?php endif; ?>
                        </span>
                        <span class="<?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                            <p class="text-muted fw-medium mb-1">
                                <?php echo e(Auth::user()->type == 1 ? trans('labels.transaction') : trans('labels.orders')); ?>

                            </p>
                            <h4><?php echo e($totalorders); ?></h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                        </span>
                        <span class="<?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end'); ?>">
                            <p class="text-muted fw-medium mb-1"><?php echo e(trans('labels.revenue')); ?></p>
                            <h4><?php echo e(helper::currency_formate($totalrevenue, $vendor_id)); ?></h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title"><?php echo e(trans('labels.revenue')); ?></h5>
                        <select class="form-select form-select-sm w-auto" id="revenueyear"
                            data-url="<?php echo e(URL::to('/admin/dashboard')); ?>">
                            <?php if(count($revenue_years) > 0 && !in_array(date('Y'), array_column($revenue_years->toArray(), 'year'))): ?>
                                <option value="<?php echo e(date('Y')); ?>" selected><?php echo e(date('Y')); ?></option>
                            <?php endif; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $revenue_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $revenue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($revenue->year); ?>" <?php echo e(date('Y') == $revenue->year ? 'selected' : ''); ?>>
                                    <?php echo e($revenue->year); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <option value="" selected disabled><?php echo e(trans('labels.select')); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="revenuechart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title">
                            <?php echo e(Auth::user()->type == 1 ? trans('labels.users') : trans('labels.orders')); ?></h5>
                        <select class="form-select form-select-sm w-auto" id="doughnutyear"
                            data-url="<?php echo e(request()->url()); ?>">
                            <?php if(count($doughnut_years) > 0 && !in_array(date('Y'), array_column($doughnut_years->toArray(), 'year'))): ?>
                                <option value="<?php echo e(date('Y')); ?>" selected><?php echo e(date('Y')); ?></option>
                            <?php endif; ?>
                            <?php $__empty_1 = true; $__currentLoopData = $doughnut_years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $useryear): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <option value="<?php echo e($useryear->year); ?>"
                                    <?php echo e(date('Y') == $useryear->year ? 'selected' : ''); ?>><?php echo e($useryear->year); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <option value="" selected disabled><?php echo e(trans('labels.select')); ?></option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="doughnut"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h5 class="card-title text-uppercase">
            <?php echo e(Auth::user()->type == 1 ? trans('labels.today_transaction') : trans('labels.processing_orders')); ?></h5>
        <div class="col-12">
            <div class="card border-0 my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <?php if(Auth::user()->type == 1): ?>
                            <?php echo $__env->make('admin.dashboard.admintransaction', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php else: ?>
                            <?php echo $__env->make('admin.orders.orderstable', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <!--- Admin -------- users-chart-script --->
    <!--- VendorAdmin -------- orders-count-chart-script --->
    <script type="text/javascript">
        var doughnut = null;
        var doughnutlabels = <?php echo e(Js::from($doughnutlabels)); ?>;
        var doughnutdata = <?php echo e(Js::from($doughnutdata)); ?>;
    </script>
    <!--- Admin ------ revenue-by-plans-chart-script --->
    <!--- vendorAdmin ------ revenue-by-orders-script --->
    <script type="text/javascript">
        var revenuechart = null;
        var labels = <?php echo e(Js::from($revenuelabels)); ?>;
        var revenuedata = <?php echo e(Js::from($revenuedata)); ?>;
    </script>
    <script src="<?php echo e(url(env('ASSETPATHURL') . 'admin-assets/js/dashboard.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/emlhor/public_html/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>