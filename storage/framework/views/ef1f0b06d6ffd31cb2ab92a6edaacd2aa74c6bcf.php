<?php $__env->startSection('content'); ?>

    <?php if(env('Environment') == 'sendbox'): ?>
        <div class="alert alert-warning mt-3" role="alert">
            <p>Most of the addons listed below are free with extended license. So proceed with the purchase of <a
                    href="https://1.envato.market/Yg7YmB" target="_blank">extended license</a> for the script</p>
        </div>
        <div class="alert alert-warning" role="alert">
            <p>If you will purchase regular license, you can still use addons as per your needs</p>
        </div>
    <?php endif; ?>
    <div class="card mb-3 border-0 shadow">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1 fw-bold">Visit our store to purchase addons</h5>
                    <p class="text-muted fw-medium">Install our addons to unlock premium features</p>
                </div>
                <a href="https://rb.gy/s7gc5" target="_blank" class="btn btn-success">Visit Our Store</a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase"><?php echo e(trans('labels.addons_manager')); ?></h5>
        <div class="d-inline-flex">
            <a href="<?php echo e(URL::to('admin/createsystem-addons')); ?>" class="btn btn-secondary px-2 d-flex">
                <i class="fa-regular fa-plus mx-1"></i><?php echo e(trans('labels.add')); ?></a>
        </div>
    </div>
    <div class="search_row">
        <div class="card border-0 box-shadow h-100">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="installed-tab" data-bs-toggle="tab" href="#installed" role="tab"
                            aria-controls="installed" aria-selected="true"><?php echo e(trans('labels.installed_addons')); ?></a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="installed" role="tabpanel" aria-labelledby="installed-tab">
                        <div class="row">
                            <?php $__empty_1 = true; $__currentLoopData = App\Models\SystemAddons::where('unique_identifier', '!=' ,'subscription')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $addon): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <div class="col-md-6 col-lg-3 mt-3 d-flex">
                                    <div class="card h-100 w-100">
                                        <img class="img-fluid" src='<?php echo asset('storage/app/public/addons/' . $addon->image); ?>' alt="">
                                        <div class="card-body">

                                            <h5 class="card-title">
                                                <?php echo e($addon->name); ?>

                                            </h5>
                                            <?php if(env('Environment') == 'sendbox'): ?>
                                                <?php if($addon->type == '1'): ?>
                                                    <span class="badge bg-primary mb-2 fw-400 fs-8">FREE WITH EXTENDED
                                                        LICENSE</span>
                                                <?php else: ?>
                                                    <span class="badge bg-danger mb-2 fw-400 fs-8">PREMIUM</span>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                        <div class="card-footer">
                                            <p class="card-text d-inline">
                                                <?php if(env('Environment') == 'sendbox'): ?>
                                                    <small class="text-dark fw-bolder"><?php echo e(helper::currency_formate($addon->price, '')); ?></small>
                                                <?php else: ?>
                                                    <small class="text-muted"><?php echo e(date('d M Y', strtotime($addon->created_at))); ?></small>
                                                <?php endif; ?>
                                            </p>
                                            <?php if($addon->activated == 1): ?>
                                                <a <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="statusupdate('<?php echo e(URL::to('admin/systemaddons/status-' . $addon->id . '/2')); ?>')" <?php endif; ?>
                                                    class="btn btn-sm btn-success <?php echo e(session()->get('direction') == 2 ? 'float-start' : 'float-end'); ?>"><?php echo e(trans('labels.activated')); ?></a>
                                            <?php else: ?>
                                                <a <?php if(env('Environment') == 'sendbox'): ?> onclick="myFunction()" <?php else: ?> onclick="statusupdate('<?php echo e(URL::to('admin/systemaddons/status-' . $addon->id . '/1')); ?>')" <?php endif; ?>
                                                    class="btn btn-sm btn-danger <?php echo e(session()->get('direction') == 2 ? 'float-start' : 'float-end'); ?>"><?php echo e(trans('labels.deactivated')); ?></a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Col -->
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <div class="col col-md-12 text-center text-muted mt-4">
                                    <h4><?php echo e(trans('labels.no_addon_installed')); ?></h4>
                                    <a href="https://rb.gy/s7gc5" target="_blank" class="btn btn-success mt-4">Visit Our
                                        Store</a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/emlhor/public_html/resources/views/admin/apps/index.blade.php ENDPATH**/ ?>