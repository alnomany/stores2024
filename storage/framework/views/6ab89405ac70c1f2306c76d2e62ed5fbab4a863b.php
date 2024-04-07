<?php if(App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first() != null &&
    App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first()->activated == 1): ?>
    <?php if(helper::appdata('')->recaptcha_version == 'v2'): ?>
        <div class="col-12">
            <div class="g-recaptcha" data-sitekey="<?php echo e(helper::appdata('')->google_recaptcha_site_key); ?>"></div>
            <?php if($errors->has('g-recaptcha-response')): ?>
                <span class="text-danger"><?php echo e($errors->first('g-recaptcha-response')); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <?php if(helper::appdata('')->recaptcha_version == 'v3'): ?>
        <div class="col-12">
            <?php echo RecaptchaV3::field('contact'); ?>

            <?php if($errors->has('g-recaptcha-response')): ?>
                <span class="text-danger"><?php echo e($errors->first('g-recaptcha-response')); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/emlhor/public_html/stores/resources/views/landing/layout/recaptcha.blade.php ENDPATH**/ ?>