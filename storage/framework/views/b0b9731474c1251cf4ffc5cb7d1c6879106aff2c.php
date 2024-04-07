<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="<?php echo e(helper::appdata('')->meta_title); ?>" />
    <meta property="og:description" content="<?php echo e(helper::appdata('')->meta_description); ?>" />
    <meta property="og:image" content='<?php echo e(helper::image_path(helper::appdata('')->og_image)); ?>' />
    <link rel="icon" href="<?php echo e(helper::image_path(helper::appdata('')->favicon)); ?>" type="image" sizes="16x16">
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETPATHURL') . 'admin-assets/css/bootstrap/bootstrap.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETPATHURL') . 'admin-assets/css/fontawesome/all.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETPATHURL') . 'admin-assets/css/lending/aos.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(url(env('ASSETPATHURL') . 'admin-assets/css/lending/app.css')); ?>" />
    <title> <?php echo e(helper::appdata('')->website_title); ?> </title>
</head>
<body>
    <div class="container">
        <div class="row align-items-center justify-content-center vh-100">
            <div class="col-12">
                <img src="<?php echo e(url(env('ASSETPATHURL') . 'admin-assets/images/about/404.svg')); ?>" class="w-100"
                    alt="" height="400">
                <div class="text-center">
                    <h1 class="display-1 fw-bold">500</h1>
                    <p> <span class="text-danger error-content">Opps!</span></p>
                    <p class="text-uppercase fw-bold">Internal server error</p>
                    <p>We are currently trying to fix the problem.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php /**PATH /home/emlhor/public_html/resources/views/errors/500.blade.php ENDPATH**/ ?>