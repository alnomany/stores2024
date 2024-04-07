<?php if(App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first() != null &&
    App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first()->activated == 1): ?>
    <div class="js-cookie-consent cookie-consent fixed bottom-0 inset-x-0 shadow">
        <div class="max-w-7xl mx-auto px-6">
            <div class="p-4 rounded-lg bg-yellow-100">
                <div class="flex items-center justify-between flex-wrap">
                    <div class="w-0 flex-1 items-center hidden md:inline text-start">
                        <div class="col-3">
                            <img src="<?php echo e(url(env('ASSETPATHURL') . 'landing/images/svg/cookies.png')); ?>" class="card-img-top w-100 mb-4" alt="">
                        </div>
                        <p class="mb-1 fw-bold text-dark"><?php echo e(trans('labels.cookies')); ?></p>
                        <p class="ml-3 text-black text-black cookie-consent__message mb-3">
                            <?php echo e(trans('labels.cookie_text')); ?>

                        </p>
                    </div>
                    <div class="mt-2 d-flex justify-content-between flex-shrink-0 w-full sm:mt-0 sm:w-auto">
                        <button class="col-6 fs-7 py-2 text-sm font-medium js-cookie-consent-agree btn btn-store btn-class rounded cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300" id="btndecline">
                            <?php echo e(trans('labels.reject')); ?>

                        </button>
                        <button class="col-6 fs-7 px-4 py-2 rounded-md text-sm font-medium text-sm font-medium js-cookie-consent-agree btn btn-store btn-class rounded cookie-consent__agree cursor-pointer flex items-center justify-center px-4 py-2 rounded-md text-sm font-medium text-yellow-800 bg-yellow-400 hover:bg-yellow-300 <?php echo e(session()->get('direction') == 2 ? 'me-2' : 'ms-2'); ?>" id="btnagree">
                            <?php echo e(trans('labels.accept')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/emlhor/public_html/stores/vendor/spatie/laravel-cookie-consent/src/../resources/views/dialogContents.blade.php ENDPATH**/ ?>