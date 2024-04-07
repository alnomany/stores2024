<?php $__env->startSection('content'); ?>
        <div class="d-flex justify-content-between align-items-center">

            <h5 class="text-uppercase"><?php echo e(trans('labels.add_new')); ?></h5>

            <nav aria-label="breadcrumb">

                <ol class="breadcrumb m-0">

                    <li class="breadcrumb-item"><a href="<?php echo e(URL::to('admin/apps')); ?>"><?php echo e(trans('labels.addons_manager')); ?></a></li>

                    <li class="breadcrumb-item active <?php echo e(session()->get('direction') == 2 ? 'breadcrumb-rtl' : ''); ?>" aria-current="page"><?php echo e(trans('labels.add')); ?></li>

                </ol>

            </nav>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card border-0 my-3">
                    <div class="card-body">
                        <form method="post" action="<?php echo e(URL::to('admin/systemaddons/store')); ?>" name="about" id="about" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="row">
                                <div class="col-sm-3 col-md-12">
                                    <div class="form-group mb-3">
                                    <label for="addon_zip" class="col-form-label"><?php echo e(trans('labels.zip_file')); ?><span
                                                class="text-danger"> * </span></label>
                                        <input type="file" class="form-control" name="addon_zip" id="addon_zip" required="">
                                    </div>
                                </div>
                            </div>

                            <div class="text-end">
                                <?php if(env('Environment') == 'sendbox'): ?>
                                <button type="button" class="btn btn-secondary" onclick="myFunction()"><?php echo e(trans('labels.install')); ?></button>
                                <?php else: ?>
                                <button type="submit" class="btn btn-secondary"><?php echo e(trans('labels.install')); ?></button>
                                <?php endif; ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layout.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/emlhor/public_html/resources/views/admin/apps/add.blade.php ENDPATH**/ ?>