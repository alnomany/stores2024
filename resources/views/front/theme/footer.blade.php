{!! helper::appdata($storeinfo->id)->whatsapp_widget !!}
<section class="product-service mb-5 mb-lg-0">
    <div class="py-4 bg-light">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                @foreach (helper::footer_features(@$storeinfo->id) as $feature)
                    <div class="col-xl-3 col-lg-3 col-md-6 col-12 d-flex p-3 justify-content-center">
                        <div class="fs-4 free-icon icon-color">
                            {!! $feature->icon !!}
                        </div>
                        <div class="free-content px-3">
                            <h6 class="fw-500 m-0">{{ $feature->title }}</h6>
                            <p class="fs-7 text-muted fw-normal line-2">{{ $feature->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- footer -->
<footer class="footer-sec2 bg-light d-none d-lg-block">
    <div class="container">

        <div class="d-flex justify-content-center mb-4">
            <a href="{{ URL::to($storeinfo->slug) }}">
                <img src="{{ helper::image_path(helper::appdata($storeinfo->id)->logo) }}" alt="logo"
                    class="object-fit-cover my-2 logo-h-55-px "></a>
        </div>

        <ul class="footer-menu mb-4 ">
            <li class="px-2"><a
                    href="{{ URL::to($storeinfo->slug . '/privacypolicy') }}">{{ trans('labels.privacy_policy') }}</a>
            </li>|
            <li class="px-2"><a href="{{ URL::to($storeinfo->slug . '/aboutus') }}">{{ trans('labels.about_us') }}</a>
            </li>|
            <li class="px-2"><a
                    href="{{ URL::to($storeinfo->slug . '/terms_condition') }}">{{ trans('labels.terms_condition') }}</a>
            </li>|
            <li class="px-2"><a
                    href="{{ URL::to($storeinfo->slug . '/refund_policy') }}">{{ trans('labels.refund_policy') }}</a>
            </li>|
            <li class="px-2 cursor-pointer"><a data-bs-toggle="modal"
                    data-bs-target="#infomodal">{{ trans('labels.store_information') }}</a>
            </li>

        </ul>

        <div class="hstack justify-content-center gap-3">

            @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $storeinfo->id)
                            ->orderByDesc('id')
                            ->first();

                        if (@$user->allow_without_subscription == 1) {
                            $user_app = 1;
                        } else {
                            $user_app = @$checkplan->customer_app;
                        }
                    @endphp
                    @if ($user_app == 1)
                        <!-- Google play store button -->
                        @if (
                            @helper::getappsetting($storeinfo->id)->android_link != null &&
                                @helper::getappsetting($storeinfo->id)->android_link != '')
                            <a href="{{ @helper::getappsetting($storeinfo->id)->android_link }}"> <img
                                    src="{{ url(env('ASSETPATHURL') . 'front/images/google-play.svg') }}"
                                    class="app-btn" alt=""> </a>
                        @endif
                        @if (@helper::getappsetting($storeinfo->id)->ios_link != null && @helper::getappsetting($storeinfo->id)->ios_link != '')
                            <!-- App store button -->
                            <a href="{{ @helper::getappsetting($storeinfo->id)->ios_link }}"> <img
                                    src="{{ url(env('ASSETPATHURL') . 'front/images/app-store.svg') }}" class="app-btn"
                                    alt=""> </a>
                        @endif
                    @endif


                @endif
            @else
                @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                    <!-- Google play store button -->
                    @if (
                        @helper::getappsetting($storeinfo->id)->android_link != null &&
                            @helper::getappsetting($storeinfo->id)->android_link != '')
                        <a href="{{ @helper::getappsetting($storeinfo->id)->android_link }}"> <img
                                src="{{ url(env('ASSETPATHURL') . 'front/images/google-play.svg') }}" class="app-btn"
                                alt=""> </a>
                    @endif
                    @if (@helper::getappsetting($storeinfo->id)->ios_link != null && @helper::getappsetting($storeinfo->id)->ios_link != '')
                        <!-- App store button -->
                        <a href="{{ @helper::getappsetting($storeinfo->id)->ios_link }}"> <img
                                src="{{ url(env('ASSETPATHURL') . 'front/images/app-store.svg') }}" class="app-btn"
                                alt=""> </a>
                    @endif
                @endif
            @endif
        </div>
    </div>
</footer>

<!-- copy-right-sec -->

<div class="copy-right-sec py-3 d-none d-lg-block">
    <div class="container">
        <div
            class="d-md-flex {{ helper::appdata($storeinfo->id)->online_order == 1 && helper::getallpayment($storeinfo->id)->count() > 0 ? 'justify-content-between' : 'justify-content-center' }}">
            <p class="mb-md-0">{{ helper::appdata($storeinfo->id)->copyright }}</p>
            @if (helper::appdata($storeinfo->id)->online_order == 1 && helper::getallpayment($storeinfo->id)->count() > 0)
                <ul class="footer_acceped_card d-flex justify-content-center gap-3 p-0 m-0">
                    @foreach (helper::getallpayment($storeinfo->id) as $item)
                        <li>
                            <a href="#">
                                <img src="{{ helper::image_path($item->image) }}" class="w-20px">
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>

<!-- back-to-top -->
<section id="back-to-top" class="{{ session()->get('direction') == 2 ? 'back-to-top-rtl' : 'back-to-top-ltr' }}">
    <a class="text-dark">
        <i class="fa-solid fa-angles-up"></i>
    </a>
</section>

<!-- footer -->


<!-- Product View -->
<div class="modal fade" id="viewproduct-over" tabindex="-1" aria-labelledby="add-payment" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-3 pro-modal">
                <div class="row gx-3">
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" class="btn-close rounded-2 m-0 shadow-lg border" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="col-lg-6">
                        <div id="carouseltest" class="carousel slide pb-3">
                            <div class="carousel-inner"></div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div
                            class="card-body repsonsive-cart-modal p-0 {{ session()->get('direction') == 2 ? 'text-right' : 'text-left' }}">
                            <p class="pro-title line-2 mb-2" id="item_name"></p>
                            <!-- category name and rating star -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <div>
                                    <div class="d-flex align-items-center modal-price">
                                        <p class="pro-text pricing" id="item_price"></p>
                                        <input type="hidden" value="" id="product_qty" name="product_qty">
                                        <p class="card-text pro-org-value text-muted pricing" id="item_original_price">
                                        </p>
                                        <span class="text-danger fs-7" id="not_available_text"></span> &nbsp;
                                        <span class="text-dark fs-7" id="out_of_stock"></span>
                                    </div>
                                </div>
                                <!-- rating star -->
                                <div data-bs-dismiss="modal" class="star d-none">
                                    <ul class="d-flex align-itrems-center my-1 p-0 mb-2">
                                        <li class="d-flex gap-1" data-bs-toggle="offcanvas"
                                            data-bs-target="#ratingsidebar" aria-controls="offcanvasRight">
                                            <a href="javascript::void(0)" class="cursor-pointer"><i
                                                    class="fa-solid fa-star text-warning fs-7"></i></a>
                                        </li>
                                        <div id="ratting-div" class="fs-7 fw-semibold">

                                        </div>
                                        {{-- <p class="px-2 avg-ratting cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#ratingsidebar" aria-controls="offcanvasRight"></p> --}}
                                    </ul>
                                </div>
                            </div>
                            <p id="tax"
                                class="responcive-tax {{ session()->get('direction') == 2 ? 'text-right' : 'text-left' }}">
                            </p>
                            <input type="hidden" name="price" id="price" value="">
                            @if (helper::appdata($storeinfo->id)->online_order == 1)
                                <div class="d-flex gap-2 justify-content-between w-100 mb-3">
                                    <div
                                        class="input-group qty-input2 col-xl-6 col-lg-6 col-sm-4 col-5 responsive-margin m-0 rounded-5">
                                        <a class="btn p-0 change-qty-1" id="minus" data-type="minus"
                                            data-item_id="" onclick="changeqty($(this).attr('data-item_id'),'minus')"
                                            value="minus value"><i class="fa fa-minus"></i>
                                        </a>
                                        <input type="number" class="border text-center" name="number"
                                            value="1" id="item_qty" readonly>
                                        <a class="btn p-0 change-qty-1" id="plus" data-item_id=""
                                            onclick="changeqty($(this).attr('data-item_id'),'plus')" data-type="plus"
                                            value="plus value"><i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <div
                                class="modal-dec p-0 mb25 {{ session()->get('direction') == 2 ? 'text-right' : 'text-left' }}">
                                <h6 class="d-none" id="product_description">{{ trans('labels.product_description') }}
                                </h6>
                                <p class="card-text text-muted fs-7" id="item_description"></p>
                            </div>

                            <div class="d-flex mb25 d-none  {{ session()->get('direction') == 2 ? 'text-right' : 'text-left' }}"
                                id="attachment-detail">
                                <h6>{{ trans('labels.attachment') }} :</h6>
                                <span>
                                    <p class="card-text fs-7 mx-2" id="attachment"></p>
                                </span>
                            </div>
                            <div
                                class="woo_pr_color flex_inline_center mb-2 {{ session()->get('direction') == 2 ? 'text-right' : 'text-left' }}">
                                <div class="woo_colors_list">
                                    <span id="variation"></span>
                                </div>
                            </div>
                            <div class="woo_pr_color flex_inline_center mb-2">
                                <div
                                    class="woo_colors_list {{ session()->get('direction') == 2 ? 'text-right' : 'text-left' }}">
                                    <span id="extras"></span>
                                    {{ $errors->login->first('extras') }}
                                </div>
                            </div>
                            <div class="woo_btn_action">
                                <input type="hidden" name="vendor" id="overview_vendor">
                                <input type="hidden" name="attribute" id="attribute">
                                <input type="hidden" name="item_id" id="overview_item_id">
                                <input type="hidden" name="item_name" id="overview_item_name">
                                <input type="hidden" name="item_image" id="overview_item_image">
                                <input type="hidden" name="item_min_order" id="item_min_order">
                                <input type="hidden" name="item_max_order" id="item_max_order">
                                <input type="hidden" name="item_price" id="overview_item_price">
                                <input type="hidden" name="item_tax_name" id="item_tax_name">
                                <input type="hidden" name="item_tax_price" id="item_tax_price">
                                <input type="hidden" name="item_original_price" id="overview_item_original_price">
                                <input type="hidden" name="tax" id="tax_val">
                                <input type="hidden" name="variants_name" id="variants_name">
                                <input type="hidden" name="stock_management" id="stock_management">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-0 text-end">

                    <div class="d-flex align-items-center justify-content-between w-100 gap-2 m-0">
                        <div class="col-6">
                            <div class="d-flex align-items-center justify-content-center gap-2">

                                <a id="btn-video" target="_blank">
                                    <button class="btn rounded-circle video-btn m-0"><i
                                            class="fa-solid fa-video"></i></button></a>
                                @if (helper::appdata($storeinfo->id)->google_review != '' && helper::appdata($storeinfo->id)->google_review != null)
                                    <a href="{{ helper::appdata($storeinfo->id)->google_review }}" target="_blank"
                                        class="btn rounded-circle googlereview-btn"><i
                                            class="fa-solid fa-star"></i></a>
                                @endif
                                @if (helper::appdata($storeinfo->id)->contact != '' && helper::appdata($storeinfo->id)->contact != null)
                                    <a href="tel:{{ helper::appdata($storeinfo->id)->contact }}" target="_blank"
                                        class="btn rounded-circle call-btn">
                                        <i class="fa-solid fa-phone-flip"></i></a>
                                @endif
                                @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                                        @php
                                            $checkplan = App\Models\Transaction::where('vendor_id', $storeinfo->id)
                                                ->orderByDesc('id')
                                                ->first();
                                            $user = App\Models\User::where('id', $storeinfo->id)->first();
                                            if (@$user->allow_without_subscription == 1) {
                                                $whatsapp_message = 1;
                                            } else {
                                                $whatsapp_message = @$checkplan->whatsapp_message;
                                            }
                                        @endphp
                                        @if (
                                            $whatsapp_message == 1 &&
                                                helper::appdata($storeinfo->id)->whatsapp_number != '' &&
                                                helper::appdata($storeinfo->id)->whatsapp_number != null)
                                            <a class="btn rounded-circle whatsapp-btn" id="enquiries"
                                                target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                                        @endif
                                    @endif
                                @else
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                                        @if (helper::appdata($storeinfo->id)->whatsapp_number != '' && helper::appdata($storeinfo->id)->whatsapp_number != null)
                                            <a class="btn rounded-circle whatsapp-btn" id="enquiries"
                                                target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                                        @endif
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class="col-6 d-flex align-items-center justify-content-center gap-2">
                            @if (helper::appdata($storeinfo->id)->online_order == 1)
                                <button class="btn btn-store-outline m-0 add-btn" onclick="AddtoCart('0')">
                                    <span class="px-1">{{ trans('labels.addcart') }}</span>
                                </button>
                                <button class="btn btn-store m-0 add-btn" onclick="AddtoCart('1')">
                                    <span class="px-1">{{ trans('labels.buy_now') }}</span>
                                </button>
                            @endif
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL-INFORMATION -->
<div class="modal fade" id="infomodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    {{ trans('labels.working_hours') }}

                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="business-sec">
                    {{-- <h5 class="business-title card-header mb-4">
                        
                    </h5> --}}
                    <div class="working-hours">
                        <ul class="list-group border-0 bg-none p-0">
                            @if (is_array(@helper::timings($storeinfo->id)) || is_object(@helper::timings($storeinfo->id)))
                                @foreach (@helper::timings($storeinfo->id) as $time)
                                    <li class="list-group-item d-flex border-0 default-color">
                                        <p class="fw-semibold col-6 ">
                                            <i class="fa-solid fa-calendar-days"></i>
                                            <span
                                                class="px-2">{{ trans('labels.' . strtolower($time->day)) }}</span>
                                        </p>
                                        <div class="col-6 d-flex justify-content-center">
                                            <p class="text-center">
                                                @if ($time->is_always_close == 1)
                                                    <span class="text-danger">{{ trans('labels.closed') }}</span>
                                                @else
                                                    <span>{{ $time->open_time . ' ' . trans('labels.to') . ' ' . $time->close_time }}</span>
                                                @endif

                                            </p>
                                        </div>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    <div class="my-3 d-lg-none">
                        <h5>
                            {{ trans('labels.social_links') }}
                        </h5>
                        <div class="social-media">
                            <ul class="d-flex gap-2 m-0 p-0 flex-wrap">
                                @foreach (@helper::getsociallinks($storeinfo->id) as $links)
                                    <li><a href="{{ $links->link }}" target="_blank"
                                            class="social-rounded fb p-0">{!! $links->icon !!}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <div class="my-3 d-lg-none">
                        <h5>
                            {{ trans('labels.payment_methods') }}
                        </h5>
                        @php
                            $payment = helper::getallpayment($storeinfo->id);
                        @endphp

                        <ul class="footer_acceped_card d-flex flex-wrap gap-3 p-0 m-0">
                            @foreach (helper::getallpayment($storeinfo->id) as $item)
                                <li>
                                    <a href="#">
                                        <img src="{{ helper::image_path($item->image) }}" class="w-20px">
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modal_selected_addons" tabindex="-1" aria-labelledby="selected_addons_Label"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title fs-5" id="selected_addons_Label"></h5>
                <a type="button" class="btn-close rounded-2 shadow-lg border" data-bs-dismiss="modal"
                    aria-label="Close"></a>
            </div>
            <div class="modal-body p-0 extra-variation-modal">
                <ul
                    class="list-group list-group-flush p-0 {{ session()->get('direction') == 2 ? 'text-right' : 'text-left' }}">
                </ul>

                <!-- Variants -->
                <div class="p-12px">
                    <div id="item-variations" class="mt-2">

                    </div>
                    <!-- Extras -->
                    <div id="item-extras" class="mt-3">
                        <h5 class="fw-normal m-0 d-none" id="extras_title">{{ trans('labels.extras') }} </h5>
                        <ul class="m-0 ps-2">
                        </ul>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<!-- MODAL_SELECTED_ADDONS--END -->
<input type="hidden" name="currency" id="currency" value="{{ helper::appdata($storeinfo->id)->currency }}">

<!-- Age Verification Modal -->
<div class="modal fade" id="vendorplan" role="dialog" data-toggle="modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered">
        <!-- Modal content-->
        <div class="modal-content close-modal">
            <div class="modal-body">
                <div class="col-lg-12">
                    <img src="{{ helper::image_path(helper::appdata(@$storeinfo->id)->logo) }}"
                        class="img-responsive center-block d-block mx-auto" alt="Sample Image" width="100px">
                </div>
                <h3 class="hidden-xs mt-5" style="text-align: center;">
                    <strong>{{ trans('messages.store_close') }}</strong>
                </h3>
            </div>
        </div>
    </div>
</div>


<!------ whatsapp_icon ------>
@if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
        App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
    @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
        @php
            $checkplan = App\Models\Transaction::where('vendor_id', $storeinfo->id)
                ->orderByDesc('id')
                ->first();
            $user = App\Models\User::where('id', $storeinfo->id)->first();
            if (@$user->allow_without_subscription == 1) {
                $whatsapp_message = 1;
            } else {
                $whatsapp_message = @$checkplan->whatsapp_message;
            }

        @endphp
        @if ($whatsapp_message == 1)
            <input type="checkbox" id="check">
            <label class="chat-btn {{ session()->get('direction') == 2 ? 'chat-btn_rtl' : 'chat-btn_ltr' }}"
                for="check">
                <i class="fa-brands fa-whatsapp comment"></i>
                <i class="fa fa-close close"></i>
            </label>

            <div class="shadow {{ session()->get('direction') == 2 ? 'wrapper_rtl' : 'wrapper' }}">
                <div class="msg_header">
                    <h6>{{ helper::appdata(@$storeinfo->id)->website_title }}</h6>
                </div>

                <div class="text-start p-3 bg-msg">
                    <div class="card p-2 msg d-inline-block fs-7">
                        {{ trans('labels.how_can_help_you') }}
                    </div>
                </div>

                <div class="chat-form">

                    <form action="https://api.whatsapp.com/send" method="get" target="_blank"
                        class="d-flex align-items-center d-grid gap-2">
                        <textarea class="form-control m-0" name="text" placeholder="Your Text Message" cols="30" rows="10"
                            required></textarea>
                        <input type="hidden" name="phone"
                            value="{{ helper::appdata($storeinfo->id)->whatsapp_number }}">
                        <button type="submit" class="btn btn-whatsapp btn-block m-0">
                            <i class="fa-solid fa-paper-plane"></i>
                        </button>
                    </form>

                </div>
            </div>
        @endif
    @endif
@else
    @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
        <input type="checkbox" id="check">
        <label class="chat-btn {{ session()->get('direction') == 2 ? 'chat-btn_rtl' : 'chat-btn_ltr' }}"
            for="check">
            <i class="fa-brands fa-whatsapp comment"></i>
            <i class="fa fa-close close"></i>
        </label>

        <div class="shadow {{ session()->get('direction') == 2 ? 'wrapper_rtl' : 'wrapper' }}">
            <div class="msg_header">
                <h6>{{ helper::appdata(@$storeinfo->id)->website_title }}</h6>
            </div>

            <div class="text-start p-3 bg-msg">
                <div class="card p-2 msg d-inline-block fs-7">
                    {{ trans('labels.how_can_help_you') }}
                </div>
            </div>

            <div class="chat-form">
                <form action="https://api.whatsapp.com/send" method="get" target="_blank"
                    class="d-flex align-items-center d-grid gap-2">
                    <textarea class="form-control m-0" name="text" placeholder="Your Text Message" cols="30" rows="10"
                        required></textarea>
                    <input type="hidden" name="phone"
                        value="{{ helper::appdata($storeinfo->id)->whatsapp_number }}">
                    <button type="submit" class="btn btn-whatsapp btn-block m-0">
                        <i class="fa-solid fa-paper-plane"></i>
                    </button>
                </form>

            </div>
        </div>
    @endif
@endif

<!-- jquery -->
<script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/jquery/jquery.min.js') }}"></script>
<!-- bootstrap js -->
<script src="{{ url(env('ASSETPATHURL') . 'front/js/bootstrap.bundle.js') }}"></script>
<!-- owl.carousel js -->
<script src="{{ url(env('ASSETPATHURL') . 'front/js/owl.carousel.min.js') }}"></script>
<!-- slick slider js -->
<script src="{{ url(env('ASSETPATHURL') . 'front/js/slick.min.js') }}"></script>
<!-- lazyload js -->
<script src="{{ url(env('ASSETPATHURL') . 'front/js/lazyload.js') }}"></script>
<!-- fontawesome js-->
<script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/toastr/toastr.min.js') }}"></script><!-- Toastr JS -->
<!-- custom js -->
<script>
    var are_you_sure = "{{ trans('messages.are_you_sure') }}";
    var yes = "{{ trans('messages.yes') }}";
    var no = "{{ trans('messages.no') }}";
    var formate = "{{ helper::appdata($storeinfo->id)->currency_formate }}";
    var login_title = "{{ trans('labels.login') }}";
    var register_title = "{{ trans('labels.register') }}";
    var forgot_password_title = "{{ trans('labels.forgot_password') }}";
    var current_url = "{{ Request()->url() }}";
    var home_url = "{{ url('/' . $storeinfo->slug) }}";
    var is_logedin = "{{ @Auth::user()->type == 3 ? 1 : 2 }}";
    var loginurl = "{{ URL::to($storeinfo->slug . '/login') }}";
    var out_of_stock = "{{ trans('labels.out_of_stock') }}";
    var rtl = "{{ session()->get('direction') }}";
</script>
<script src="{{ url(env('ASSETPATHURL') . 'front/js/custom.js') }}"></script>
<script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/sweetalert/sweetalert2.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/dataTables.bootstrap4.min.js"></script>
@yield('script')
<!-- loaded js -->

<script>
    var logedin = "{{ Auth::user() && Auth::user()->type == 3 ? 1 : 0 }}"

    function rattingmodal(id, vendor_id, item_name) {

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: "{{ URL::to($storeinfo->slug . '/rattingmodal') }}",
            type: "post",
            dataType: "json",
            data: {
                item_id: id,
                vendor_id: vendor_id
            },
            success: function(response) {
                if (response.status == 1) {
                    $('#avgfive').css({
                        'width': ""
                    });
                    $('#avgfour').css({
                        'width': ""
                    });
                    $('#avgthree').css({
                        'width': ""
                    });
                    $('#avgtwo').css({
                        'width': ""
                    });
                    $('#avgfone').css({
                        'width': ""
                    });
                    var five = 0;
                    var four = 0;
                    var three = 0;
                    var two = 0;
                    var one = 0;
                    $('#rattingmodal_item_id').attr('data-itemid', id);
                    $('#avgreview').text(response.averagerating);
                    $('#totalreview').text(response.totalreview);
                    // five star------------

                    if (response.totalreview != 0) {
                        five = response.avgfive / response.totalreview * 100;
                    }
                    $('#perfive').text(five + '%');
                    $('#avgfive').css({
                        'width': five + '%'
                    });
                    $('#avgfive').attr('aria-valuenow', five);
                    // four star----------------
                    if (response.totalreview != 0) {
                        four = response.avgfour / response.totalreview * 100;
                    }
                    $('#perfour').text(four + '%');
                    $('#avgfour').css({
                        'width': four + '%'
                    });
                    $('#avgfour').attr('aria-valuenow', four);
                    // three star----------------
                    if (response.totalreview != 0) {
                        three = response.avgthree / response.totalreview * 100;
                    }
                    $('#perthree').text(three + '%');
                    $('#avgthree').css({
                        'width': three + '%'
                    });
                    $('#avgthree').attr('aria-valuenow', three);
                    // two star----------------
                    if (response.totalreview != 0) {
                        two = response.avgtwo / response.totalreview * 100;
                    }
                    $('#pertwo').text(two + '%');
                    $('#avgtwo').css({
                        'width': two + '%'
                    });
                    $('#avgtwo').attr('aria-valuenow', two);
                    // one star----------------
                    if (response.totalreview != 0) {
                        one = response.avgone / response.totalreview * 100;
                    }
                    $('#perone').text(one + '%');
                    $('#avgone').css({
                        'width': one + '%'
                    });
                    $('#avgone').attr('aria-valuenow', one);
                    // user reviews 
                    var html = "";
                    for (i in response.userreviews) {
                        html +=
                            '<div class="card border mb-3"><div class="card-body p-2 p-sm-3 d-flex"><div class="avatar avatar-lg me-md-3 me-2 flex-shrink-0"><img class="w-100 rounded-circle" src=' +
                            response.userreviews[i].image_url +
                            ' alt="avatar"></div><div class="review-content w-100"><div class="d-flex justify-content-between mb-2"><div><h6 class="me-3 mb-0 fw-bold text-dark text-truncate review-name">' +
                            response.userreviews[i].name + '</h6>' +
                            '<p class="text-muted text-truncate review-date">' + formatDate(response
                                .userreviews[i].created_at) +
                            '</p></div><p class="badge text-bg-warning icon-md"><i class="fa-solid fa-star text-dark"></i><span class="px-1">' +
                            parseFloat(response.userreviews[i].star).toFixed(1) +
                            '</span></p></div><p class="mb-0 text-muted fs-8 fw-normal">' + response
                            .userreviews[i].description + '</p></div></div></div>'
                    }
                    $('#userreviews').html(html);
                    $('#offcanvasRightLabel').text(item_name);
                    $('#ratingsidebar').show();
                } else {
                    toastr.error(response.message);
                }
            }
        });
    }

    function formatDate(value) {
        let date = new Date(value);
        const day = date.toLocaleString('default', {
            day: '2-digit'
        });
        const month = date.toLocaleString('default', {
            month: 'short'
        });
        const year = date.toLocaleString('default', {
            year: 'numeric'
        });
        return day + ' ' + month + ' ' + year;
    }

    function addratting(itemid) {
        if (logedin == 1) {
            $('#item_id').val(itemid);
            $('#ratingsaddLabel').text($('#offcanvasRightLabel').text());
            $('#ratingsadd').modal('show');
        } else {
            $('#ratingsidebar').offcanvas('hide');
            toastr.error("{{ trans('messages.review_login_message') }}");
        }

    }
</script>
<script>
    $("#back-to-top").on("click", function(e) {
        "use strict";
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, "500");
    });
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#orders').DataTable();
    });
    $(window).on('load', function() {
        $('#preloader').hide();
    });

    //sidebar For Craete Account Form Show
    $('.create_account_btn').on("click", function() {
        $('#register_form').removeClass('d-none');
        $('#login_form').addClass('d-none');
        $('#forgot_password_form').addClass('d-none');
        $('#auth_form_title').html(register_title);
    });

    //sidebar For Login Form Show 
    $('.login_btn').on("click", function() {
        $('#register_form').addClass('d-none');
        $('#login_form').removeClass('d-none');
        $('#forgot_password_form').addClass('d-none');
        $('#auth_form_title').html(login_title);
    });

    //sidebar For Forgot Password Form Show
    $('.forgot_password_btn').on("click", function() {
        $('#register_form').addClass('d-none');
        $('#login_form').addClass('d-none');
        $('#forgot_password_form').removeClass('d-none');
        $('#auth_form_title').html(forgot_password_title);
    });

    const myOffcanvas = document.getElementById('loginpage');
    myOffcanvas.addEventListener('hidden.bs.offcanvas', () => {
        $('.login_btn').click();
    });

    toastr.options = {
        "closeButton": true,
        "positionClass": "toast-top-right",
    }
    @if (Session::has('success'))
        toastr.success("{{ session('success') }}");
    @endif
    @if (Session::has('error'))
        toastr.error("{{ session('error') }}");
    @endif
    var ratting = "{{ number_format(0, 1) }}";
    var reviewshow = 0;
    if ("{{ App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() }}" != null &&
        "{{ App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated }}" == 1) {
        if (
            "{{ helper::appdata($storeinfo->id)->checkout_login_required && helper::appdata($storeinfo->id)->product_ratting_switch == 1 }}"
        ) {
            reviewshow = 1;
        }
    }
    var whatsappnumber = "{{ helper::appdata($storeinfo->id)->whatsapp_number }}";
    function currency_formate(price) {
       
       if ("{{ @helper::appdata($storeinfo->id)->currency_position }}" == "left") {
          
           if ("{{helper::appdata($storeinfo->id)->decimal_separator}}" == 1) {
               return "{{ @helper::appdata($storeinfo->id)->currency }}" + parseFloat(price).toFixed(formate);
           }else{
              var newprice = "{{ @helper::appdata($storeinfo->id)->currency }}" + (parseFloat(price).toFixed(formate));
              newprice = newprice.replace('.',',');
              return newprice;
           }
       } else {
           if ("{{helper::appdata($storeinfo->id)->decimal_separator}}" == 1) {
               return parseFloat(price).toFixed(formate) + "{{ @helper::appdata($storeinfo->id)->currency }}";
           }else{
              var newprice =  (parseFloat(price).toFixed(formate)) + "{{ @helper::appdata($storeinfo->id)->currency }}";
              newprice = newprice.replace('.',',');
              return newprice;
           }
       }
   }
    function GetProductOverview(id) {
        var imagepath =
            "{{ url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/item-placeholder.png') }}";
        var sku = "{{ trans('labels.sku') }}";
        $('#preloader').show();
        var message = 'I am interested for this item : ';
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ URL::to('product-details/details') }}",
            data: {
                id: id
            },
            method: 'POST', //Post method,
            dataType: 'json',
            success: function(response) {
                $('#preloader').hide();
                jQuery("#viewproduct-over").modal('show');
                $('#overview_vendor').val(response.ResponseData.vendor_id);
                $('#minus').attr('data-item_id', response.ResponseData.id);
                $('#plus').attr('data-item_id', response.ResponseData.id);
                $('#overview_item_id').val(response.ResponseData.id);
                $('#attribute').val(response.ResponseData.attribute);
                $('#overview_item_name').val(response.ResponseData.item_name);
                if (response.ResponseData.video_url != "" && response.ResponseData.video_url != null) {
                    $('#btn-video').removeClass('d-none');
                    $('#btn-video').attr('href', response.ResponseData.video_url);
                } else {
                    $('#btn-video').addClass('d-none');
                }
                if (response.ResponseData.product_image == null) {
                    $('#overview_item_image').val("item-placeholder.png");
                    $('.gallerys').html("<img src=" + imagepath +
                        " class='img-fluid  width='100%''>");
                } else {
                    $('#overview_item_image').val(response.ResponseData.product_image.image);
                    $('.gallerys').html("<img src=" + response.ResponseData.product_image.image_url +
                        " class='img-fluid  width='100%''>");
                }
                $('#overview_item_price').val(response.ResponseData.item_price);
                $('#item_name').text(response.ResponseData.item_name);
                if (response.ResponseData.description != null && response.ResponseData.description != "") {
                    $('#product_description').removeClass('d-none');
                    $('#item_description').html(response.ResponseData.description);
                } else {
                    $('#product_description').addClass('d-none');
                    $('#item_description').html();
                }

                $('#category_name').text(response.ResponseData.name);
                $('#tax_val').val(response.ResponseData.tax);
                $('#product_qty').val(response.ResponseData.qty);
                var attachment = "";
                if (response.ResponseData.attchment_name != "" && response.ResponseData.attchment_name !=
                    null) {
                    $('#attachment-detail').removeClass('d-none');
                    attachment += '<a href="' + response.ResponseData.attchment_url +
                        '" target="_blank" class="text-danger">' +
                        response.ResponseData.attchment_name + '</a>'
                } else {
                    $('#attachment-detail').addClass('d-none');
                }
                $('#attachment').html(attachment);
                var html1 = "";
                active = "active";
                if (response.ResponseData.multi_image.length > 0) {
                    for (var i = 0; i < response.ResponseData.multi_image.length; i++) {
                        if (i == 0) {
                            active = "active";
                        } else {
                            active = "";
                        }
                        if (response.ResponseData.multi_image[i].image == null && response.ResponseData
                            .multi_image[i].image == "") {
                            html1 += "<div class='carousel-item" + ' ' + active + " ' name='image" + [i] +
                                "'><img class='img-fluid w-100' src=" + imagepath + "></div>";
                        } else {
                            html1 += "<div class='carousel-item" + ' ' + active + " ' name='image" + [i] +
                                "'><img class='img-fluid w-100' src=" + response.ResponseData.multi_image[
                                    i].image_url + "></div>";
                        }
                    }
                } else {
                    html1 += "<div class='carousel-item" + ' ' + active + "' name='image" + [i] +
                        "'><img class='img-fluid w-100' src=" + imagepath + "></div>";
                }
                if (response.ResponseData.multi_image.length > 1)
                {
                    $('#carouseltest .carousel-inner').html(html1 +
                    "<button class='carousel-control-prev' type='button' data-bs-target='#carouseltest' data-bs-slide='prev'><span class='carousel-control-prev-icon' aria-hidden='true'></span></button><button class='carousel-control-next' type='button' data-bs-target='#carouseltest' data-bs-slide='next'><span class='carousel-control-next-icon' aria-hidden='true'></span></button>"
                );
                }else{
                    $('#carouseltest .carousel-inner').html(html1);
                }
                
                if (reviewshow == 1) {
                    var rattinghtml = "";
                    $('.star').removeClass('d-none');
                    if (response.ResponseData.ratings_average == null || response.ResponseData
                        .ratings_average == "") {
                        rattinghtml +=
                            '<p class="px-2 avg-ratting cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#ratingsidebar" onclick="rattingmodal(' +
                            "'" + response.ResponseData.id + "'" + ',' + "'" + response.ResponseData
                            .vendor_id + "'" + ',' + "'" + response.ResponseData.item_name + "'" +
                            ')" aria-controls="offcanvasRight">' + ratting + '</p>';
                    } else {
                        rattinghtml +=
                            '<p class="px-2 avg-ratting cursor-pointer" data-bs-toggle="offcanvas" data-bs-target="#ratingsidebar" onclick="rattingmodal(' +
                            "'" + response.ResponseData.id + "'" + ',' + "'" + response.ResponseData
                            .vendor_id + "'" + ',' + "'" + response.ResponseData.item_name + "'" +
                            ')" aria-controls="offcanvasRight">' + response.ResponseData.ratings_average +
                            '</p>';
                    }
                    $('#ratting-div').html(rattinghtml);
                }
                if (response.ResponseData.tax != null && response.ResponseData.tax != "") {
                    $('#tax').html(
                        "<span class='text-muted fs-7'>{{ trans('labels.exclusive_taxes') }}</span>");
                } else {
                    $('#tax').html(
                        "<span class='text-muted fs-7'>{{ trans('labels.inclusive_taxes') }}</span>");
                }
                if (response.ResponseData.item_original_price > 0) {
                    $('#overview_item_original_price').val(response.ResponseData.item_original_price);
                    $('#item_original_price').html(response.ResponseData.item_original_p);
                } else {
                    $('#overview_item_original_price').val('');
                    $('#item_original_price').html('');
                }
                var e;
                var i;
                var sessionValue = $("#hdnsession").val();
                var classforview = "";
                var classforul = "extra-food";
                if (sessionValue == "2") {
                    var classforview = "d-flex";
                    var classforul = "mr-0 pr-2 extra-food-rtl";
                }
                let html = '';
                let text_align = '';
                if (response.ResponseData.extras.length != 0) {
                    html += '<h5 class="extra-title">{{ trans('labels.extras') }}</h5>';
                }
                html += '<ul class="list-unstyled ' + classforul + '"><div id="pricelist">';
                for (e in response.ResponseData.extras) {
                    if (response.ResponseData.extras[e].price < 0) {
                        html += '<li class="mb-2"><input type="checkbox" name="addons[]" extras_name="' +
                            response
                            .ResponseData.extras[e].name + '" class="Checkbox" value="' + response
                            .ResponseData.extras[e].id + '" price="' + response.ResponseData.extras[e]
                            .price + '"><p>' + response.ResponseData.extras[e].name + '</p></li>'
                    } else {
                        html += '<li class="mb-2"><input type="checkbox" name="addons[]" extras_name="' +
                            response
                            .ResponseData.extras[e].name + '" class="Checkbox" value="' + response
                            .ResponseData.extras[e].id + '" price="' + response.ResponseData.extras[e]
                            .price + '"><p>' + response.ResponseData.extras[e].name + ' : ' + 
                            currency_formate(parseFloat(response.ResponseData.extras[e].price)) +
                            '</p></li>'
                    }
                }
                html += '</div></ul>';
                $('#extras').html(html);
                let varhtml = '';
                if (response.ResponseData.variation.length != 0) {
                    $('#item_price').text(currency_formate(parseFloat(response.ResponseData
                        .variation[0].price)));
                    $('#overview_item_original_price').val(currency_formate(parseFloat(response.ResponseData
                        .variation[0].original_price)));
                    $('#item_original_price').html(currency_formate(parseFloat(response.ResponseData
                        .variation[0].original_price)));
                    if (response.ResponseData.variation[0].is_available == 2) {
                        $('#not_available_text').html('({{ trans('labels.not_available') }})');
                        $('.add-btn').attr('disabled', true);
                    } else {
                        $('#not_available_text').html('');
                        $('.add-btn').attr('disabled', false);
                        if (response.ResponseData.variation[0].stock_management == 1) {
                            if (response.ResponseData.variation[0].qty > 0) {
                                $('#out_of_stock').removeClass('text-danger');
                                $('#out_of_stock').addClass('text-dark');
                                $('#out_of_stock').html('(' + response.ResponseData.variation[0].qty +
                                    ' {{ trans('labels.in_stock') }})');
                            } else {
                                $('#out_of_stock').removeClass('text-dark');
                                $('#out_of_stock').addClass('text-danger');
                                $('#out_of_stock').html('({{ trans('labels.out_of_stock') }})');
                            }
                        } else {
                            $('#out_of_stock').html('');
                        }
                    }
                    if (response.ResponseData.attribute != null) {
                        varhtml += '<h5 class="extra-title">' + response.ResponseData.attribute +
                            '</h5>';
                    }
                    $('#item_min_order').val(response.ResponseData.variation[0].min_order);
                    $('#item_max_order').val(response.ResponseData.variation[0].max_order);
                    $('#price').val(currency_formate(parseFloat(response.ResponseData.variation[0].price)));
                    $('#stock_management').val(response.ResponseData.variation[0].stock_management);
                    $('#variants_name').val(response.ResponseData.variation[0].name);
                }
                //variation

                if (response.ResponseData.has_variants == '1') {

                    for (var i = 0; i < response.ResponseData.variants_json.length; i++) {

                        varhtml += '<p class="variant_name variant_name  pro-title line-2 mb-2 fs-6">' +
                            response.ResponseData.variants_json[i].variant_name + '</p>';

                        varhtml += '<select name="product[' + [i] +
                            ']"  id="pro_variants_name" class="form-control variant-selection  pro_variants_name' +
                            [i] + ' pro_variants_name variant_loop variant_val mb-2 py-1">';

                        for (var t = 0; t < response.ResponseData.variants_json[i].variant_options
                            .length; t++) {

                            varhtml += '<option value="' + response.ResponseData.variants_json[i]
                                .variant_options[t] + '" id="' + response.ResponseData.variants_json[i]
                                .variant_options[t] + '_varient_option">' + response.ResponseData
                                .variants_json[i].variant_options[t] + '</option>';
                        }
                        varhtml += '</select>';
                    }
                }
                $('#variation').html(varhtml);
                if (response.ResponseData.variation.length === 0) {
                    $('#price').val(response.ResponseData.item_price);
                    $('#item_price').text(response.ResponseData.item_p);
                    $('#overview_item_price').val(response.ResponseData.item_price);
                    $('#item_min_order').val(response.ResponseData.min_order);
                    $('#item_max_order').val(response.ResponseData.max_order);
                    $('#stock_management').val(response.ResponseData.stock_management);
                    if (response.ResponseData.stock_management == 1) {
                        if (response.ResponseData.qty > 0) {
                            $('#out_of_stock').removeClass('text-danger');
                            $('#out_of_stock').addClass('text-dark');
                            $('#out_of_stock').html('(' + response.ResponseData.qty +
                                ' {{ trans('labels.in_stock') }})');
                        } else {
                            $('#out_of_stock').removeClass('text-dark');
                            $('#out_of_stock').addClass('text-danger');
                            $('#out_of_stock').html('({{ trans('labels.out_of_stock') }})');
                        }
                    } else {
                        $('#out_of_stock').html('');
                    }
                }
                message += '' + response.ResponseData.item_name;
                if (response.ResponseData.sku != "" && response.ResponseData.sku != null) {
                    message += ' ' + '(' + sku + ' : ' + response.ResponseData.sku + ')';
                }
                $('#enquiries').attr('href', 'https://api.whatsapp.com/send?phone=' + whatsappnumber +
                    '&text=' + message + '');
            },
            error: function(error) {
                $('#preloader').hide();
            }
        })
    }

    $(document).on('change', '#pro_variants_name', function() {
        set_variant_price();
    }).change();

    function set_variant_price() {
        var variants = [];
        $(".variant-selection").each(function(index, element) {
            variants.push(element.value);
        });

        if (variants.length > 0) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('get-products-variant-quantity') }}",
                data: {
                    name: variants.join('|'),
                    item_id: $('#overview_item_id').val(),
                    vendor_id: {{ $storeinfo->id }},
                },
                success: function(data) {
                    $('#item_min_order').val(data.min_order);
                    $('#item_max_order').val(data.max_order);
                    $('#product_qty').val(data.quantity);
                    $('#overview_item_original_price').val(currency_formate(parseFloat(data
                        .original_price)));
                    $('#item_original_price').html(currency_formate(parseFloat(data.original_price)));
                    $('#item_price').text(currency_formate(parseFloat(data.price)));
                    $('#overview_item_price').val(data.price);
                    $('#price').val(data.price);
                    $('#variants_name').val(data.variants_name);
                    $('#stock_management').val(data.stock_management);
                    if (data.is_available == 2) {
                        $('#not_available_text').html('({{ trans('labels.not_available') }})');
                        $('.add-btn').attr('disabled', true);
                    } else {
                        $('#not_available_text').html('');
                        $('.add-btn').attr('disabled', false);
                        if (data.stock_management == 1) {
                            if (data.quantity > 0) {
                                $('#out_of_stock').removeClass('text-danger');
                                $('#out_of_stock').addClass('text-dark');
                                $('#out_of_stock').html('(' + data.quantity +
                                    ' {{ trans('labels.in_stock') }})');
                            } else {
                                $('#out_of_stock').removeClass('text-dark');
                                $('#out_of_stock').addClass('text-danger');
                                $('#out_of_stock').html('({{ trans('labels.out_of_stock') }})');
                            }
                        }

                    }

                }
            });
        }
    }

    function getprice(id) {
        $('#item_price').text(currency_formate(parseFloat($('#' + id).data('price'))))
        $('#item_original_price').text(currency_formate(parseFloat($('#' + id).data('original-price'))));
        $('#item_min_order').val($('#' + id).data('min_order'));
        $('#item_max_order').val($('#' + id).data('max_order'));

    }

    function AddtoCart(buynow) {
        var vendor = $('#overview_vendor').val();
        var item_id = $('#overview_item_id').val();
        var item_name = $('#overview_item_name').val();
        var item_image = $('#overview_item_image').val();
        var item_price = $('#overview_item_price').val();
        var item_qty = $('#viewproduct-over #item_qty').val();
        var item_original_price = $('#overview_item_original_price').val();
        var tax = $('#tax_val').val();
        var price = $('#price').val();
        var variants_id = $('input[name="variation"]:checked').attr("variation-id");
        var variants_name = $('#variants_name').val();
        var product_qty = $('#product_qty').val();
        var min_order = $('#item_min_order').val();
        var max_order = $('#item_max_order').val();
        var stock_management = $('#stock_management').val();
        var extras_id = ($('.Checkbox:checked').map(function() {
            return this.value;
        }).get().join('| '));
        var extras_name = ($('.Checkbox:checked').map(function() {
            return $(this).attr('extras_name');
        }).get().join('| '));
        var extras_price = ($('.Checkbox:checked').map(function() {
            return $(this).attr('price');
        }).get().join('| '));
        $('#preloader').show();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{ URL::to('/add-to-cart') }}",
            data: {
                vendor_id: vendor,
                item_id: item_id,
                item_name: item_name,
                item_image: item_image,
                item_price: item_price,
                item_original_price: item_original_price,
                tax: tax,
                variants_id: variants_id,
                variants_name: variants_name,
                extras_id: extras_id,
                extras_name: extras_name,
                extras_price: extras_price,
                qty: item_qty,
                price: price,
                product_qty: product_qty,
                min_order: min_order,
                max_order: max_order,
                stock_management: stock_management
            },
            method: 'POST', //Post method,
            dataType: 'json',
            success: function(response) {
                if (response.status == 1) {
                    if (buynow == 0) {
                        $('#cartcnt').text(response.cartcnt);
                        location.reload();
                        toastr.success("{{ trans('messages.success') }}");
                    } else {
                        location.href = "{{ URL::to($storeinfo->slug . '/checkout') }}";
                    }

                } else {
                    $("#preloader").hide();
                    toastr.error(response.message);

                }
            },
            error: function(error) {}
        })
    };
    $('body').on('change', 'input[type="checkbox"]', function(e) {
        var total = parseFloat($("#price").val());
        if ($(this).is(':checked')) {
            total += parseFloat($(this).attr('price')) || 0;
        } else {
            total -= parseFloat($(this).attr('price')) || 0;
        }
        $('h3.pricing').text(currency_formate(parseFloat(total)));
        $('#price').val(total);
    })
    $('body').on('change', 'input[type="radio"]', function(e) {
        $('h3.pricing').text(currency_formate(parseFloat($(this).attr('price'))));
        $('#price').val(parseFloat($(this).attr('price')));
        $('input[type=checkbox]').prop('checked', false);
    })

 
    $('.cat-check').on('click', function() {
        if ($(this).attr('data-cat-type') == 'first') {
            $('html, body').animate({
                scrollTop: 0
            }, '1000');
        }
        $('.cat-aside-wrap').find('.active').removeClass('active');
        $(this).addClass('active');
    });

    function RemoveCart(cart_id, vendor_id) {
        "use strict";
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-1',
                cancelButton: 'btn btn-danger bg-danger mx-1'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            icon: 'error',
            title: "{{ trans('messages.are_you_sure') }}",
            showCancelButton: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            confirmButtonText: "{{ trans('messages.yes') }}",
            cancelButtonText: "{{ trans('messages.no') }}",
            reverseButtons: true,
            showLoaderOnConfirm: true,
            preConfirm: function() {
                return new Promise(function(resolve, reject) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: "{{ URL::to('/cart/deletecartitem') }}",
                        data: {
                            cart_id: cart_id,
                            vendor_id: vendor_id,
                        },
                        method: 'POST',
                        success: function(response) {
                            if (response.status == 1) {
                                $('.shopping-cart #cartcnt').text(response.cartcnt);
                                location.reload();
                            } else {
                                swal("Cancelled", "{{ trans('messages.wrong') }} :(",
                                    "error");
                            }
                        },
                        error: function(e) {
                            swal("Cancelled", "{{ trans('messages.wrong') }} :(",
                                "error");
                        }
                    });
                });
            },
        }).then((result) => {
            if (!result.isConfirmed) {
                result.dismiss === Swal.DismissReason.cancel
            }
        })
    }

    function qtyupdate(cart_id, item_id, variants_id, price, type) {

        var qtys = parseInt($("#number_" + cart_id).val());
        var item_id = item_id;
        var cart_id = cart_id;
        var variants_id = variants_id;
        if (type == "decreaseValue") {
            qty = qtys - 1;
        } else {
            qty = qtys + 1;
        }
        
        if (qty >= "1") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/cart/qtyupdate') }}",
                data: {
                    cart_id: cart_id,
                    item_id: item_id,
                    type: type,
                    qty: qty,
                    variants_id: variants_id,
                    price: price * qty
                },
                method: 'POST',
                success: function(response) {
                    if (response.status == 1) {
                        $("#cart-plus").removeClass('disabled');
                        location.reload();
                    } else {
                        $("#cart-plus").addClass('disabled');
                        $("#number_" + cart_id).val(response.qty);
                        toastr.error(response.message);
                        setTimeout(function() {
                            location.reload();
                        }, 5000);
                    }
                },
                error: function(error) {}
            });
        }

    }

    function changeqty(item_id, type) {
        var qtys = parseInt($('#item_qty').val());
        if (type == "minus") {
            qty = qtys - 1;
        } else {
            qty = qtys + 1;
        }
        if (qty >= "1") {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ URL::to('/changeqty') }}",
                data: {
                    item_id: item_id,
                    type: type,
                    qty: qty,
                    vendor_id: {{ $storeinfo->id }},
                    variants_name: $('#variants_name').val(),
                    stock_management: $('#stock_management').val(),
                },
                method: 'POST',
                success: function(response) {
                    if (response.status == 1) {
                        // $("#plus").removeClass('disabled');
                        $('#item_qty').val(response.qty);
                        // location.reload();
                    } else {
                        $('#preloader').hide();
                        // $("#plus").addClass('disabled');
                        $('#item_qty').val(response.qty);
                        toastr.error(response.message);
                    }
                },
                error: function(error) {}
            });
        }

    }
</script>
<script>
    function showaddons(id, item_name, attribute, extra_name, extra_price, variation_name, variation_price) {
        $('#selected_addons_Label').html(item_name);
        $('#variation_title').html(attribute);
        var extras = extra_name.split("|");
        var variations = variation_name.split(',');
        var extra_price = extra_price.split('|');
        var variation_price = variation_price.split(',');
        var html = "";
        if (variations != '') {
            html +=
                '<p class="fw-bolder m-0" id="variation_title">{{ trans('labels.variants') }} </p><ul class="m-0 ps-2">';
            for (i in variations) {
                html += '<li class="px-0">' + variations[i] + ' : <span class="text-muted">' + currency_formate(
                    parseFloat(
                        variation_price[i])) + '</span></li>'
            }
            html += '</ul>';
        }
        $('#item-variations').html(html);
        var html1 = '';
        if (extras != '') {
            $('#extras_title').removeClass('d-none');
            html1 +=
                '<p class="fw-bolder m-0" id="extras_title">{{ trans('labels.extras') }} </p><ul class="m-0 ps-2">';
            for (i in extras) {
                html1 += '<li class="px-0">' + extras[i] + ' : <span class="text-muted">' + currency_formate(parseFloat(
                    extra_price[i])) + '</span></li>'
            }
            html1 += '</ul>';
        }
        $('#item-extras').html(html1);
        $('#modal_selected_addons').modal('show');
    }
</script>
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id={{ helper::appdata(1)->tracking_id }}"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());
    gtag('config', '{{ helper::appdata(1)->tracking_id }}');
</script>

@if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
        App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
    @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
        @php
            $checkplan = App\Models\Transaction::where('vendor_id', $storeinfo->id)
                ->orderByDesc('id')
                ->first();
            $user = App\Models\User::where('id', $storeinfo->id)->first();
            if ($user->allow_without_subscription == 1) {
                $pwa = 1;
            } else {
                $pwa = @$checkplan->pwa;
            }
        @endphp
        @if ($pwa == 1)
            <script src="{{ url('storage/app/public/sw.js') }}"></script>
            <script>
                if (!navigator.serviceWorker.controller) {
                    navigator.serviceWorker.register("{{ url('storage/app/public/sw.js') }}").then(function(reg) {
                        console.log("Service worker has been registered for scope: " + reg.scope);
                    });
                }
            </script>
        @endif
    @endif
@else
    @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
        <script src="{{ url('storage/app/public/sw.js') }}"></script>
        <script>
            if (!navigator.serviceWorker.controller) {
                navigator.serviceWorker.register("{{ url('storage/app/public/sw.js') }}").then(function(reg) {
                    console.log("Service worker has been registered for scope: " + reg.scope);
                });
            }
        </script>
    @endif
@endif
<script>
    let deferredPrompt = null;
    window.addEventListener('beforeinstallprompt', (e) => {
        $('.mobile_drop_down').show();
        deferredPrompt = e;
    });

    const mobile_install_app = document.getElementById('mobile-install-app');
    if (mobile_install_app != null) {
        mobile_install_app.addEventListener('click', async () => {
            if (deferredPrompt !== null) {
                deferredPrompt.prompt();
                const {
                    outcome
                } = await deferredPrompt.userChoice;
                if (outcome === 'accepted') {
                    deferredPrompt = null;

                }
            }
        });
    }
    $('.nav02').click(function() {
        $('.mobile_drop_down').animate({
            bottom: "-100vh"
        }, 200);
    });
    $(document).ready(function() {
        window.addEventListener('beforeinstallprompt', (e) => {
            $('.install-app-btn-container').show();
            $('.mobile_drop_down').animate({
                bottom: "0px"
            }, 200);
            deferredPrompt = e;
        });

    });

    function myFunction() {
        "use strict";
        toastr.error("This operation was not performed due to demo mode");
        return false;
    }
</script>

<!-- product img change js -->





</body>

</html>
