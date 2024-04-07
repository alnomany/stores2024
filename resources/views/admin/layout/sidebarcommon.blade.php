@php
    if (Auth::user()->type == 4) {
        $role_id = Auth::user()->role_id;
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $role_id = '';
        $vendor_id = Auth::user()->id;
    }
    $user = App\Models\User::where('id', $vendor_id)->first();
@endphp
<ul class="navbar-nav">
    <li class="nav-item fs-7 {{ helper::check_menu($role_id, 'role_dashboard') == 1 ? 'd-block' : 'd-none' }}">
        <a class="nav-link rounded d-flex {{ request()->is('admin/dashboard') ? 'active' : '' }}" aria-current="page"
            href="{{ URL::to('admin/dashboard') }}">
            <i class="fa-solid fa-house-user"></i> <span class="">{{ trans('labels.dashboard') }}</span>
        </a>
    </li>
    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
        <li
            class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_orders') == 1 || helper::check_menu($role_id, 'role_report') == 1 || helper::check_menu($role_id, 'role_pos') == 1 ? 'd-block' : 'd-none' }}">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.orders_management') }}</h6>
        </li>
        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
            @if (App\Models\SystemAddons::where('unique_identifier', 'pos')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'pos')->first()->activated == 1)
                @php

                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                        ->orderByDesc('id')
                        ->first();

                    if ($user->allow_without_subscription == 1) {
                        $pos = 1;
                    } else {
                        $pos = @$checkplan->pos;
                    }

                @endphp
                @if ($pos == 1)
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_pos') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/pos*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('admin/pos') }}">
                            <i class="fa-solid fa-bag-shopping"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.pos') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @else
            @if (App\Models\SystemAddons::where('unique_identifier', 'pos')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'pos')->first()->activated == 1)
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_pos') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/pos*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('admin/pos') }}">
                        <i class="fa-solid fa-bag-shopping"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.pos') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif

        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_orders') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex d-flex {{ request()->is('admin/orders*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/orders') }}" aria-expanded="false">
                <i class="fa-solid fa-cart-shopping"></i><span class="nav-text ">{{ trans('labels.orders') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_report') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex d-flex {{ request()->is('admin/report*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/report') }}" aria-expanded="false">
                <i class="fa-solid fa-chart-mixed"></i><span class="nav-text ">{{ trans('labels.report') }}</span>
            </a>
        </li>
    @endif
    @if (Auth::user()->type == '1' ||
            (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1))
        <li class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_customers') == 1 ? 'd-block' : 'd-none' }}">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.user_management') }}</h6>
        </li>
    @endif

    @if (Auth::user()->type == '1')
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/users*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('admin/users') }}">
                <i class="fa-solid fa-user-plus"></i> <span class="">{{ trans('labels.users') }}</span>
            </a>
        </li>
    @endif

    @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_customers') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/customers*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/customers') }}">
                <i class="fa-solid fa-users"></i>
                <p class="w-100 d-flex justify-content-between">
                    <span class="nav-text ">{{ trans('labels.customers') }}</span>
                    @if (env('Environment') == 'sendbox')
                        <span class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                    @endif
                </p>
            </a>
        </li>
    @endif
    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
        <li
            class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_categories') == 1 || helper::check_menu($role_id, 'role_products') == 1 || helper::check_menu($role_id, 'role_global_extras') == 1 ? 'd-block' : 'd-none' }}">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.product_managment') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_products') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#products-menu" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="products-menu">
                <span class="d-flex"><i class="fa-solid fa-file-lines"></i></i><span
                        class="multimenu-title">{{ trans('labels.products') }}</span></span>
            </a>
            <ul class="collapse" id="products-menu">
                <li class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_categories') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded {{ request()->is('admin/categories*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/categories') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.categories') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_products') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded {{ request()->is('admin/products')  || request()->is('admin/products/add') || request()->is('admin/products/add') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/products') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.products') }}</span>
                    </a>
                </li>
                
                @if (App\Models\SystemAddons::where('unique_identifier', 'product_import')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'product_import')->first()->activated == 1)
                    <li class="nav-item ps-4 mb-1 {{ helper::check_menu($role_id, 'role_import') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded {{ request()->is('admin/products/import') || request()->is('admin/media*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/products/import') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.product_upload') }}</span>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/tax*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/tax') }}">
                <i class="fa-solid fa-magnifying-glass-dollar"></i>
                <p class="w-100 d-flex justify-content-between">
                    <span class="nav-text ">{{ trans('labels.tax') }}</span>
                </p>
            </a>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_global_extras') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/extras*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('admin/extras') }}">
                <i class="fa-solid fa-globe"></i> <span class="">{{ trans('labels.global_extras') }}</span>
            </a>
        </li>
        @if (App\Models\SystemAddons::where('unique_identifier', 'shopify')->first() != null &&
        App\Models\SystemAddons::where('unique_identifier', 'shopify')->first()->activated == 1)
        <li class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_shopify') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#shopify-menu" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="shopify-menu">
                <span class="d-flex"><i class="fa-brands fa-shopify"></i><span
                        class="multimenu-title">{{ trans('labels.shopify') }}</span></span>
            </a>
            <ul class="collapse" id="shopify-menu">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/shopify-category*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/shopify-category') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.shopify_category') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/shopify-products*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/shopify-products') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.shopify_products') }}</span>
                    </a>
                </li>
            </ul>
        </li>
        @endif
    @endif

    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
        @if (Auth::user()->type == '2' ||
                (App\Models\SystemAddons::where('unique_identifier', 'coupon')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'coupon')->first()->activated == 1))
            <li
                class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_banner') == 1 || helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.promotions') }}</h6>
            </li>
        @endif
        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_sliders') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/sliders*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/sliders') }}" aria-expanded="false">
                <i class="fa-solid fa-image"></i><span class="nav-text ">{{ trans('labels.sliders') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_banner') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/banner*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/banner') }}" aria-expanded="false">
                <i class="fa-solid fa-image"></i><span class="nav-text ">{{ trans('labels.banner') }}</span>
            </a>
        </li>
        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
            @if (App\Models\SystemAddons::where('unique_identifier', 'coupon')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'coupon')->first()->activated == 1)
                @php

                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                        ->orderByDesc('id')
                        ->first();

                    if ($user->allow_without_subscription == 1) {
                        $coupons = 1;
                    } else {
                        $coupons = @$checkplan->coupons;
                    }

                @endphp
                @if ($coupons == 1)
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/coupons*') ? 'active' : '' }}"
                            href="{{ URL::to('/admin/coupons') }}" aria-expanded="false">
                            <i class="fa-solid fa-badge-percent"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.coupons') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @else
            @if (App\Models\SystemAddons::where('unique_identifier', 'coupon')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'coupon')->first()->activated == 1)
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/coupons*') ? 'active' : '' }}"
                        href="{{ URL::to('/admin/coupons') }}" aria-expanded="false">
                        <i class="fa-solid fa-badge-percent"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.coupons') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif
    @endif
    <li
        class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_customers') == 1 || helper::check_menu($role_id, 'role_pricing_plans') == 1 || helper::check_menu($role_id, 'role_transaction') == 1 || helper::check_menu($role_id, 'role_payment_methods') == 1 || helper::check_menu($role_id, 'role_working_hours') == 1 || helper::check_menu($role_id, 'role_custom_domains') == 1 || helper::check_menu($role_id, 'role_google_analytics') == 1 ? 'd-block' : 'd-none' }}">
        <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.business_management') }}</h6>
    </li>


    @if (Auth::user()->type == 1)
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/tax*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/tax') }}">
                <i class="fa-solid fa-magnifying-glass-dollar"></i>
                <p class="w-100 d-flex justify-content-between">
                    <span class="nav-text ">{{ trans('labels.tax') }}</span>
                </p>
            </a>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_pricing_plans') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/plan*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('admin/plan') }}">
                <i class="fa-solid fa-medal"></i> <span class="">{{ trans('labels.pricing_plans') }}</span>
            </a>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_transaction') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/transaction*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/transaction') }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span
                    class="">{{ trans('labels.transaction') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/payment') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/payment') }}">
                <i class="fa-solid fa-money-check-dollar-pen"></i> <span
                    class="">{{ trans('labels.payment_methods') }}</span>
            </a>
        </li>
    @elseif(App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_pricing_plans') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/plan*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('admin/plan') }}">
                <i class="fa-solid fa-medal"></i> <span class="">{{ trans('labels.pricing_plans') }}</span>
            </a>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_transaction') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/transaction*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/transaction') }}">
                <i class="fa-solid fa-file-invoice-dollar"></i> <span
                    class="">{{ trans('labels.transaction') }}</span>
            </a>
        </li>
    @endif

    @if (Auth::user()->type == 2 || Auth::user()->type == 4)

        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/payment') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/payment') }}">
                <i class="fa-solid fa-money-check-dollar-pen"></i> <span
                    class="">{{ trans('labels.payment_methods') }}</span>
            </a>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_shipping_area') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/shipping-area*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/shipping-area') }}">
                <i class="fas fa-chart-area"></i>
                <span class="">{{ trans('labels.shipping_area') }}</span>
            </a>
        </li>
        <li
            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_working_hours') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/time*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/time') }}" aria-expanded="false">
                <i class="fa-solid fa-business-time"></i><span
                    class="nav-text ">{{ trans('labels.working_hours') }}</span>
            </a>
        </li>
        
        @php
            $delivery_type = explode('|', helper::appdata($vendor_id)->delivery_type);
        @endphp
        @if (in_array('table', $delivery_type))
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_table') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link rounded d-flex {{ request()->is('admin/dinein*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/dinein') }}" aria-expanded="false">
                    <i class="fa-solid fa-utensils"></i><span class="nav-text ">{{ trans('labels.table') }}</span>
                </a>
            </li>
        @endif
        @if (helper::appdata($vendor_id)->product_type == 1)
            @if (App\Models\SystemAddons::where('unique_identifier', 'custom_status')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'custom_status')->first()->activated == 1)
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_custom_status') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/custom_status*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('admin/custom_status') }}">
                        <i class="fa-regular fa-clipboard-list-check"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.custom_status') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif

    @endif
    @if (Auth::user()->type == 1)
        <li class="nav-item mb-2 fs-7 dropdown multimenu">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#location" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="location">
                <span class="d-flex"><i class="fa-sharp fa-solid fa-location-dot"></i><span
                        class="multimenu-title">{{ trans('labels.location') }}</span></span>
            </a>
            <ul class="collapse" id="location">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/countries*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/countries') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.cities') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/cities*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/cities') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.areas') }}</span>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/store_categories*') ? 'active' : '' }}"
                href="{{ URL::to('/admin/store_categories') }}" aria-expanded="false">
                <i class="fa-sharp fa-solid fa-list"></i> <span
                    class="nav-text ">{{ trans('labels.store_categories') }}</span>
            </a>
        </li>
    @endif
    @if (Auth::user()->type == 1)
        @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
            <li class="nav-item mb-2 fs-7">
                <a class="nav-link rounded d-flex {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                    <i class="fa-solid fa-link"></i>
                    <p class="w-100 d-flex justify-content-between">
                        <span class="nav-text ">{{ trans('labels.custom_domains') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span
                                class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif

    @endif

    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
            @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
                @php
                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                        ->orderByDesc('id')
                        ->first();
                    if ($user->allow_without_subscription == 1) {
                        $custom_domain = 1;
                    } else {
                        $custom_domain = @$checkplan->custom_domain;
                    }

                @endphp
                @if ($custom_domain == 1)
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_custom_domains') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                            <i class="fa-solid fa-link"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.custom_domains') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @else
            @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_custom_domains') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/custom_domain*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/custom_domain') }}">
                        <i class="fa-solid fa-link"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.custom_domains') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif
    @endif

    @if (Auth::user()->type == '2' || Auth::user()->type == 4)
        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
            @if (App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first()->activated == 1)
                @php
                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                        ->orderByDesc('id')
                        ->first();
                    if ($user->allow_without_subscription == 1) {
                        $google_analytics = 1;
                    } else {
                        $google_analytics = @$checkplan->google_analytics;
                    }

                @endphp
                @if ($google_analytics == 1)
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_google_analytics') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link rounded d-flex {{ request()->is('admin/google_analytics*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/google_analytics') }}">
                            <i class="fa-solid fa-bar-chart"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.google_analytics') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @else
            @if (App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first()->activated == 1)
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_google_analytics') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link rounded d-flex {{ request()->is('admin/google_analytics*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/google_analytics') }}">
                        <i class="fa-solid fa-bar-chart"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.google_analytics') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif
        @if (Auth::user()->type == 2 || Auth::user()->type == 4)
            <li
                class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_basic_settings') == 1 || helper::check_menu($role_id, 'role_blogs') == 1 || helper::check_menu($role_id, 'role_cms_pages') == 1 ? 'd-block' : 'd-none' }}">
                <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.website_settings') }}</h6>
            </li>
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_basic_settings') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/basic_settings*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/basic_settings') }}">
                    <i class="fa-solid fa-gears"></i>
                    <span>{{ trans('labels.basic_settings') }}</span>
                </a>
            </li>
            @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                            ->orderByDesc('id')
                            ->first();

                        if ($user->allow_without_subscription == 1) {
                            $blogs = 1;
                        } else {
                            $blogs = @$checkplan->blogs;
                        }

                    @endphp
                    @if ($blogs == 1)
                        <li
                            class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_blogs') == 1 ? 'd-block' : 'd-none' }}">
                            <a class="nav-link d-flex rounded {{ request()->is('admin/blogs') ? 'active' : '' }}"
                                aria-current="page" href="{{ URL::to('admin/blogs') }}">
                                <i class="fa-solid fa-blog"></i>
                                <p class="w-100 d-flex justify-content-between">
                                    <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                                    @if (env('Environment') == 'sendbox')
                                        <span
                                            class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                    @endif
                                </p>
                            </a>
                        </li>
                    @endif
                @endif
            @else
                @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_blogs') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link d-flex rounded {{ request()->is('admin/blogs') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('admin/blogs') }}">
                            <i class="fa-solid fa-blog"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif

            <li class="nav-item mb-2 fs-7">
                <a class="nav-link d-flex rounded {{ request()->is('admin/testimonials*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/testimonials') }}">
                    <i class="fa-solid fa-comment-dots"></i>
                    <span>{{ trans('labels.testimonials') }}</span>
                </a>
            </li>
            <li class="nav-item mb-2 fs-7">
                <a class="nav-link d-flex rounded {{ request()->is('admin/faqs*') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/faqs') }}">
                    <i class="fa-solid fa-question"></i>
                    <span>{{ trans('labels.faqs') }}</span>
                </a>
            </li>
            <li
                class="nav-item mb-2 fs-7 dropdown multimenu {{ helper::check_menu($role_id, 'role_cms_pages') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                    href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                    aria-controls="pages">
                    <span class="d-flex"><i class="fa-solid fa-file-lines"></i></i><span
                            class="multimenu-title">{{ trans('labels.cms_pages') }}</span></span>
                </a>
                <ul class="collapse" id="pages">
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/privacy-policy*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/privacy-policy') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.privacypolicy') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/terms-conditions*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/terms-conditions') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.terms') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/aboutus*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/aboutus') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.about') }}</span>
                        </a>
                    </li>
                    <li class="nav-item ps-4 mb-1">
                        <a class="nav-link rounded {{ request()->is('admin/refund_policy') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/refund_policy') }}">
                            <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                    class="fa-solid fa-circle-small"></i>{{ trans('labels.refund_policy') }}</span>
                        </a>
                    </li>
                </ul>
            </li>
        @endif



    @endif
    @if (Auth::user()->type == 1)
        {{-- landing Page --}}
        <li class="nav-item mt-3">
            <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.landing_page') }}</h6>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/basic_settings*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/basic_settings') }}">
                <i class="fa-solid fa-gears"></i>
                <span>{{ trans('labels.basic_settings') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/how_it_works*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/how_it_works') }}">
                <i class="fa-regular fa-hourglass"></i>
                <span>{{ trans('labels.how_it_works') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/themes*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/themes') }}">
                <i class="fa-solid fa-palette"></i>
                <span>{{ trans('labels.theme_images') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/features*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/features') }}">
                <i class="fa-solid fa-list"></i>
                <span>{{ trans('labels.features') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/promotionalbanners*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/promotionalbanners') }}">
                <i class="fa-solid fa-bullhorn"></i>
                <span>{{ trans('labels.promotional_banners') }}</span>
            </a>
        </li>
        @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_blogs') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link d-flex rounded {{ request()->is('admin/blogs') ? 'active' : '' }}"
                    aria-current="page" href="{{ URL::to('/admin/blogs') }}">
                    <i class="fa-solid fa-blog"></i>
                    <p class="w-100 d-flex justify-content-between">
                        <span class="nav-text ">{{ trans('labels.blogs') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span
                                class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif

        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/faqs*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/faqs') }}">
                <i class="fa-solid fa-question"></i>
                <span>{{ trans('labels.faqs') }}</span>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link d-flex rounded {{ request()->is('admin/testimonials*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/testimonials') }}">
                <i class="fa-solid fa-comment-dots"></i>
                <span>{{ trans('labels.testimonials') }}</span>
            </a>
        </li>

        <li class="nav-item mb-2 fs-7 dropdown multimenu">
            <a class="nav-link collapsed rounded d-flex align-items-center justify-content-between dropdown-toggle mb-1"
                href="#pages" data-bs-toggle="collapse" role="button" aria-expanded="false"
                aria-controls="pages">
                <span class="d-flex"><i class="fa-solid fa-file-lines"></i></i><span
                        class="multimenu-title">{{ trans('labels.cms_pages') }}</span></span>
            </a>
            <ul class="collapse" id="pages">
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/privacy-policy*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/privacy-policy') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.privacypolicy') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/terms-conditions*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/terms-conditions') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.terms') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/aboutus*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/aboutus') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.about') }}</span>
                    </a>
                </li>
                <li class="nav-item ps-4 mb-1">
                    <a class="nav-link rounded {{ request()->is('admin/refund_policy') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/refund_policy') }}">
                        <span class="d-flex align-items-center multimenu-menu-indicator"><i
                                class="fa-solid fa-circle-small"></i>{{ trans('labels.refund_policy') }}</span>
                    </a>
                </li>

            </ul>
        </li>
    @endif

    @if (Auth::user()->type == 1)
        @if (App\Models\SystemAddons::where('unique_identifier', 'coupon')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'coupon')->first()->activated == 1)
            <li
                class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_coupons') == 1 ? 'd-block' : 'd-none' }}">
                <a class="nav-link rounded d-flex {{ request()->is('admin/coupons*') ? 'active' : '' }}"
                    href="{{ URL::to('/admin/coupons') }}" aria-expanded="false">
                    <i class="fa-solid fa-badge-percent"></i>
                    <p class="w-100 d-flex justify-content-between">
                        <span class="nav-text ">{{ trans('labels.coupons') }}</span>
                        @if (env('Environment') == 'sendbox')
                            <span
                                class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                        @endif
                    </p>
                </a>
            </li>
        @endif
    @endif


    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
            @if (App\Models\SystemAddons::where('unique_identifier', 'employee')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'employee')->first()->activated == 1)
                @php

                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                        ->orderByDesc('id')
                        ->first();

                    if ($user->allow_without_subscription == 1) {
                        $role_management = 1;
                    } else {
                        $role_management = @$checkplan->role_management;
                    }

                @endphp
                @if ($role_management == 1)
                    {{-- role management --}}
                    <li
                        class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_employees') == 1 || helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                        <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.employee_management') }}
                        </h6>
                    </li>
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link  d-flex rounded {{ request()->is('admin/roles*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/roles') }}">
                            <i class="fa-solid fa-user-secret"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.roles') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                    <li
                        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_employees') == 1 ? 'd-block' : 'd-none' }}">
                        <a class="nav-link  d-flex rounded {{ request()->is('admin/employees*') ? 'active' : '' }}"
                            aria-current="page" href="{{ URL::to('/admin/employees') }}">
                            <i class="fa fa-users"></i>
                            <p class="w-100 d-flex justify-content-between">
                                <span class="nav-text ">{{ trans('labels.employees') }}</span>
                                @if (env('Environment') == 'sendbox')
                                    <span
                                        class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endif
            @endif
        @else
            @if (App\Models\SystemAddons::where('unique_identifier', 'employee')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'employee')->first()->activated == 1)
                {{-- role management --}}
                <li
                    class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_employees') == 1 || helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                    <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.employee_management') }}</h6>
                </li>
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_roles') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/roles*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/roles') }}">
                        <i class="fa-solid fa-user-secret"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.roles') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
                <li
                    class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_employees') == 1 ? 'd-block' : 'd-none' }}">
                    <a class="nav-link  d-flex rounded {{ request()->is('admin/employees*') ? 'active' : '' }}"
                        aria-current="page" href="{{ URL::to('/admin/employees') }}">
                        <i class="fa fa-users"></i>
                        <p class="w-100 d-flex justify-content-between">
                            <span class="nav-text ">{{ trans('labels.employees') }}</span>
                            @if (env('Environment') == 'sendbox')
                                <span
                                    class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                            @endif
                        </p>
                    </a>
                </li>
            @endif
        @endif
    @endif

    <li
        class="nav-item mt-3 {{ helper::check_menu($role_id, 'role_subscribers') == 1 || helper::check_menu($role_id, 'role_inquiries') == 1 || helper::check_menu($role_id, 'role_share') == 1 || helper::check_menu($role_id, 'role_settings') == 1 ? 'd-block' : 'd-none' }}">
        <h6 class="text-muted mb-2 fs-7 text-uppercase">{{ trans('labels.other') }}</h6>
    </li>
    <li
        class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_subscribers') == 1 ? 'd-block' : 'd-none' }}">
        <a class="nav-link rounded d-flex {{ request()->is('admin/subscribers*') ? 'active' : '' }}"
            aria-current="page" href="{{ URL::to('admin/subscribers') }}">
            <i class="fa-solid fa-envelope"></i> <span class="">{{ trans('labels.subscribers') }}</span>
        </a>
    </li>
    <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_inquiries') == 1 ? 'd-block' : 'd-none' }}">
        <a class="nav-link rounded d-flex {{ request()->is('admin/inquiries*') ? 'active' : '' }}"
            aria-current="page" href="{{ URL::to('admin/inquiries') }}">
            <i class="fa-solid fa-solid fa-address-book"></i><span
                class="">{{ trans('labels.inquiries') }}</span>
        </a>
    </li>
    @if (Auth::user()->type == '2' || Auth::user()->type == 4)
        <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_share') == 1 ? 'd-block' : 'd-none' }}">
            <a class="nav-link rounded d-flex {{ request()->is('admin/share*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('admin/share') }}">
                <i class="fa-solid fa-share-from-square"></i> <span
                    class="">{{ trans('labels.share') }}</span>
            </a>
        </li>
    @endif
    @if ((Auth::user()->type == '2' || Auth::user()->type == 4) && helper::listoflanguage()->count() > 1)
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/language-settings*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/language-settings') }}">
                <i class="fa-solid fa-language"></i>
                <p class="w-100 d-flex justify-content-between">
                    <span class="nav-text ">{{ trans('labels.language-settings') }}</span>
                    @if (env('Environment') == 'sendbox')
                        <span class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                    @endif
                </p>
            </a>
        </li>
    @endif
    <li class="nav-item mb-2 fs-7 {{ helper::check_menu($role_id, 'role_settings') == 1 ? 'd-block' : 'd-none' }}">
        <a class="nav-link rounded d-flex {{ request()->is('admin/settings') ? 'active' : '' }}" aria-current="page"
            href="{{ URL::to('admin/settings') }}">
            <i class="fa-solid fa-gear"></i> <span class="">{{ trans('labels.settings') }}</span>
        </a>
    </li>
    @if (Auth::user()->type == '1')
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link rounded d-flex {{ request()->is('admin/language-settings*') ? 'active' : '' }}"
                aria-current="page" href="{{ URL::to('/admin/language-settings') }}">
                <i class="fa-solid fa-language"></i>
                <p class="w-100 d-flex justify-content-between">
                    <span class="nav-text ">{{ trans('labels.language-settings') }}</span>
                    @if (env('Environment') == 'sendbox')
                        <span class="badge badge bg-danger float-right mr-1 mt-1">{{ trans('labels.addon') }}</span>
                    @endif
                </p>
            </a>
        </li>
        <li class="nav-item mb-2 fs-7">
            <a class="nav-link {{ request()->is('admin/apps*') ? 'active' : '' }}" aria-current="page"
                href="{{ URL::to('/admin/apps') }}">
                <i class="fa-solid fa-rocket"></i>
                <span class="mx-2">{{ trans('labels.addons_manager') }}</span>
            </a>
        </li>
    @endif
</ul>
