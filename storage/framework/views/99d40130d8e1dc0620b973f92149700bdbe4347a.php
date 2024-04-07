<?php $__env->startSection('content'); ?>
    <section>
        <div class="row align-items-center g-0 w-100 h-100vh position-relative">
            <div class="col-md-5 d-md-block d-none">
                <div class="login-left-content">
                    <a href="<?php echo e(URL::to('/')); ?>">
                    <img src="<?php echo e(helper::image_path(helper::appdata('')->logo)); ?>" class="logo-img" alt="">
                    </a>
                </div>
            </div>
            <div class="col-md-7 overflow-hidden bg-white">
                <div class="login-right-content login-forgot-padding row">
                    <div class="pb-0 px-0">
                        <div class="text-primary d-flex align-items-center justify-content-between">
                            <div>
                                <h2 class="fw-bold text-color title-text mb-2"><?php echo e(trans('labels.login')); ?></h2>
                                <p class="text-color"><?php echo e(trans('labels.please_login')); ?></p>
                            </div>
                            <!-- FOR SMALL DEVICE TOP CATEGORIES -->
                            <?php if(App\Models\SystemAddons::where('unique_identifier', 'language')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'language')->first()->activated == 1): ?>
                                <div class="lag-btn dropdown border-0 shadow-none login-lang">
                                    <button class="btn dropdown-toggle border-0 language-dropdown" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-globe fs-5 text-dark"></i>
                                    </button>
                                    <ul class="dropdown-menu rounded-1 p-0 rounded-3 overflow-hidden">
                                        <?php $__currentLoopData = helper::listoflanguage(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $languagelist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a class="dropdown-item text-dark d-flex align-items-center text-left px-3 py-2"
                                                    href="<?php echo e(URL::to('/lang/change?lang=' . $languagelist->code)); ?>">
                                                    <img src="<?php echo e(helper::image_path($languagelist->image)); ?>" alt=""
                                                        class="img-fluid lag-img mx-1 w-25">
                                                    &nbsp;&nbsp;<?php echo e($languagelist->name); ?>

                                                </a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                        <form class="mt-3" method="POST" action="<?php echo e(URL::to('/admin/checklogin-normal')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group">
                                <label for="email" class="form-label"><?php echo e(trans('labels.email')); ?><span class="text-danger"> * </span></label>
                                <input type="email" class="form-control" name="email" placeholder="<?php echo e(trans('labels.email')); ?>" id="email" required>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label for="password" class="form-label"><?php echo e(trans('labels.password')); ?><span class="text-danger"> * </span></label>
                                <div class="form-control d-flex align-items-center gap-3">
                                    <input type="password" class="form-control border-0 p-0" name="password" placeholder="<?php echo e(trans('labels.password')); ?>" id="password" required>
                                    <span>
                                        <a href="#"><i class="fa-light fa-eye-slash" id="eye"></i></a>
                                    </span>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span class="text-danger"><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="d-flex">
                                <div class="form-group mb-2 col-6 d-flex align-items-center">
                                    <input class="form-check-input mt-0" type="checkbox" value="" name="check_terms"
                                        id="check_terms" checked required>
                                    <label class="form-check-label cursor-pointer mx-1" for="check_terms">
                                        <span class="fs-7 text-color">
                                           <?php echo e(trans('labels.remember_me')); ?>

                                        </span>
                                    </label>
                                </div>
                                <div class="<?php echo e(session()->get('direction') == 2 ? 'text-start' : 'text-end '); ?> mb-2 col-6">
                                    <a href="<?php echo e(URL::to('/admin/forgot_password')); ?>" class="fs-7 fw-600">
                                        <?php echo e(trans('labels.forgot_password_')); ?>

                                    </a>
                                </div>
                            </div>
                            <button class="btn btn-primary w-100 mt-2 mb-3 padding" type="submit"><?php echo e(trans('labels.login')); ?></button>
                            
                            <?php if(App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1): ?>
                            <div class="d-flex align-items-center mb-4">
                                <div class="login-with-border"></div>
                                <p class="text-center mx-2 fs-7 text-muted col-auto"><?php echo e(trans('labels.login_with')); ?></p>
                                <div class="login-with-border"></div>
                            </div>
                            <div class="login-form-bottom-icon d-flex align-items-center justify-content-center text-end mb-3">
                                <?php if(helper::appdata('')->google_mode == 1): ?>
                                <a <?php if(env('Environment')=='sendbox' ): ?> onclick="myFunction()" <?php else: ?> href="<?php echo e(URL::to('admin/login/google-vendor')); ?>" <?php endif; ?>>
                                    <button type="button" class="btn btn-primary icon-btn-google">
                                        <i class="fa-brands fa-google"></i>
                                    </button>

                                </a>
                                <?php endif; ?>
                                <?php if(helper::appdata('')->facebook_mode == 1): ?>
                                <a <?php if(env('Environment')=='sendbox' ): ?> onclick="myFunction()" <?php else: ?> href="<?php echo e(URL::to('admin/login/facebook-vendor')); ?>" <?php endif; ?>>
                                    <button type="button" class="btn btn-primary icon-btn-facebook">
                                        <i class="fa-brands fa-facebook-f"></i>
                                    </button>

                                </a>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            <?php if(helper::appdata('')->vendor_register == 1): ?>
                            <p class="fs-7 text-center mt-4"><?php echo e(trans('labels.dont_have_account')); ?>

                                <a href="<?php echo e(URL::to('admin/register')); ?>" class="text-secondary fw-semibold text-decoration fw-600"><?php echo e(trans('labels.create_acount')); ?></a>
                            </p>
                            <?php endif; ?>
                        </form>
                        <?php if(env('Environment') == 'sendbox'): ?>
                            <div class="form-group mt-3 table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Admin<br>admin@gmail.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info btn-sm"
                                                    onclick="AdminFill('admin@gmail.com' , '123456')">Copy</button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Vendor<br>grocery@gmail.com</td>
                                            <td>123456</td>
                                            <td><button class="btn btn-info btn-sm"
                                                    onclick="AdminFill('grocery@gmail.com' , '123456')">Copy</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php if(env('Environment') == 'sendbox'): ?>
        <button class="btn btn-primary theme-label text-white" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">

            <i class="fa-solid fa-list text-white px-2"></i>
            Themes</button>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header border-bottom">
                <h5 id="offcanvasRightLabel">Themes</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row px-3">
                    <a href="https://store-mart.paponapps.co.in/theme-1" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-1.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 1</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-2" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-2.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 2</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-3" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-3.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 3</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-4" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-4.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 4</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-5" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-5.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 5</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-6" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-6.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 6</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-7" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-7.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 7</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-8" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-8.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 8</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-9" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-9.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 9</h5>
                        </div>
                    </a>

                    <a href="https://store-mart.paponapps.co.in/theme-10" target="_blank"
                        class="card h-100 them-card-box overflow-hidden mb-3 rounded-5 border-0 p-0">
                        <img src="<?php echo e(helper::image_path('theme-10.png')); ?>" class="card-img-top them-name-images">
                        <div class="card-body">
                            <h5 class="card-title text-center">Theme - 10</h5>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        function AdminFill(email, password) {
            $('#email').val(email);
            $('#password').val(password);
        }
        // password eye hide
        $(function() {
            $('#eye').click(function() {
                if ($(this).hasClass('fa-eye-slash')) {
                    $(this).removeClass('fa-eye-slash');
                    $(this).addClass('fa-eye');
                    $('#password').attr('type', 'text');
                } else {
                    $(this).removeClass('fa-eye');
                    $(this).addClass('fa-eye-slash');
                    $('#password').attr('type', 'password');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layout.auth_default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/emlhor/public_html/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>