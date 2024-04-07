<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="text-uppercase fw-500">
            <td><?php echo e(trans('labels.srno')); ?></td>
            <td><?php echo e(trans('labels.transaction_number')); ?></td>
            <td><?php echo e(trans('labels.plan_name')); ?></td>
            <td><?php echo e(trans('labels.total')); ?> <?php echo e(trans('labels.amount')); ?></td>
            <td><?php echo e(trans('labels.payment_type')); ?></td>
            <td><?php echo e(trans('labels.purchase_date')); ?></td>
            <td><?php echo e(trans('labels.expire_date')); ?></td>
            <td><?php echo e(trans('labels.status')); ?></td>
            <td><?php echo e(trans('labels.created_date')); ?></td>
            <td><?php echo e(trans('labels.updated_date')); ?></td>
            <td><?php echo e(trans('labels.action')); ?></td>
        </tr>
    </thead>
    <tbody>
        <?php
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            $i = 1;
        ?>
        <?php $__currentLoopData = $transaction; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="fs-7">
                <td><?php echo $i++; ?></td>
                <td>#<?php echo e($transaction->transaction_number); ?></td>
                <td><?php echo e(helper::plandetail($transaction->plan_id)->name); ?></td>
                <td><?php echo e(helper::currency_formate($transaction->grand_total, '')); ?></td>
                <td>
                    <?php if($transaction->payment_type != ''): ?>
                        <?php if($transaction->payment_type == 0): ?>
                            <?php echo e(trans('labels.manual')); ?>

                        <?php else: ?>
                            <?php echo e(@helper::getpayment($transaction->payment_type, $vendor_id)->payment_name); ?>

                        <?php endif; ?>
                    <?php elseif($transaction->amount == 0): ?>
                        -
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($transaction->payment_type == 6): ?>
                        <?php if($transaction->status == 2): ?>
                            <span class="badge bg-success"><?php echo e(helper::date_format($transaction->purchase_date)); ?></span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    <?php else: ?>
                        <span class="badge bg-success"><?php echo e(helper::date_format($transaction->purchase_date)); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($transaction->payment_type == 6): ?>
                        <?php if($transaction->status == 2): ?>
                            <span
                                class="badge bg-danger"><?php echo e($transaction->expire_date != '' ? helper::date_format($transaction->expire_date) : '-'); ?></span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    <?php else: ?>
                        <span
                            class="badge bg-danger"><?php echo e($transaction->expire_date != '' ? helper::date_format($transaction->expire_date) : '-'); ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <?php if($transaction->payment_type == 6): ?>
                        <?php if($transaction->status == 1): ?>
                            <span class="badge bg-warning"><?php echo e(trans('labels.pending')); ?></span>
                        <?php elseif($transaction->status == 2): ?>
                            <span class="badge bg-success"><?php echo e(trans('labels.accepted')); ?></span>
                        <?php elseif($transaction->status == 3): ?>
                            <span class="badge bg-danger"><?php echo e(trans('labels.rejected')); ?></span>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td><?php echo e(helper::date_format($transaction->created_at)); ?><br>
                    <?php echo e(helper::time_format($transaction->created_at,$vendor_id)); ?>

                </td>
                <td><?php echo e(helper::date_format($transaction->updated_at)); ?><br>
                    <?php echo e(helper::time_format($transaction->updated_at,$vendor_id)); ?>

                </td>
                <td>
                    <?php if(Auth::user()->type == '1'): ?>
                        <?php if($transaction->payment_type == 6): ?>
                            <?php if($transaction->status == 1): ?>
                                <a class="btn btn-sm btn-outline-success"
                                    onclick="statusupdate('<?php echo e(URL::to('admin/transaction-' . $transaction->id . '-2')); ?>')"><i
                                        class="fas fa-check"></i></a>
                                <a class="btn btn-sm btn-outline-danger"
                                    onclick="statusupdate('<?php echo e(URL::to('admin/transaction-' . $transaction->id . '-3')); ?>')"><i
                                        class="fas fa-close"></i></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    <a class="btn btn-sm btn-outline-secondary"
                        href="<?php echo e(URL::to('admin/transaction/plandetails-' . $transaction->id)); ?>"><i
                            class="fa-regular fa-eye"></i></a>
                </td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>
<?php /**PATH /home/emlhor/public_html/stores/resources/views/admin/dashboard/admintransaction.blade.php ENDPATH**/ ?>