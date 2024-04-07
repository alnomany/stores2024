@extends('landing.layout.default')

@section('content')
<!-- banner-section start -->
<section class="bg-color-banner" id="home">
    <div class="header-container">
        <div class="banner">
            <div class="banner-page text-center">
                <div class="banner-text">
                    <h1 class="col-sm-7 col-11 mx-auto">{{ trans('landing.hero_banner_title') }}</h1>
                    <p class="pt-4 mx-auto">{{ trans('landing.hero_banner_description') }}</p>

                    <div class="mt-5">
                        <a href="{{ URL::to('/admin') }}" class="btn-secondary rounded-2" target="_blank">
                            {{ trans('landing.get_started') }}
                        </a>
                        <a href="@if (env('Environment') == 'sendbox') https://1.envato.market/Yg7YmB @else {{ URL::to('/#pricing-plans') }} @endif" class="btn-border-white border-white rounded-2" @if (env('Environment') == 'sendbox') target="_blank" @endif>
                            {{ trans('labels.buy_now') }}
                        </a>
                    </div>
                </div>
                <div>
                    <img src="{{ @helper::image_path(helper::landingsettings()->landing_home_banner) }}" alt="" class="banner-images img-fluid mt-5">
                </div>
            </div>
        </div>
        <a class="{{ session()->get('direction') == 2 ? 'button-top-arrow-up-rtl' : 'button-top-arrow-up' }}">
            <i class="fa-solid fa-arrow-up"></i>
        </a>
    </div>
</section>
<!-- banner-section End -->
@if ($workdata->count() > 0)
<section class="project-management py-5 overflow-hidden">
    <div class="container position-relative container-project-management">
        <h5 class="beautiful-ui-kit-title col-md-12">
            {{ trans('landing.how_it_work') }}
        </h5>
        <p class="subtitle col-md-8 sub-title-mein text-muted">
            {{ trans('landing.how_it_work_description') }}
        </p>
        <!-- Create Your Account start -->
        @foreach ($workdata as $key => $data)
        <div class="management-main mt-5 row {{ $key % 2 == 0 ? '' : 'flex-row-reverse' }} justify-content-between align-items-center">
            <div class="project-management-text col-lg-7 mb-3 order-md-0 order-2">
                <div data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000" direction="false">
                    <div class="{{ $key % 2 == 0 ? '' : 'd-flex justify-content-end' }}">
                        <h5 class="work-title col-md-auto landing-rtl {{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}">
                            {{ $data->title }}
                        </h5>
                    </div>
                    <p class="mt-2 text-muted sub-title-mein landing-rtl {{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}">
                        {{ $data->description }}
                    </p>
                    <div class="mt-lg-5 mt-4 landing-rtl {{ session()->get('direction') == 2 ? 'rtl' : 'ltr' }}">
                        <a href="{{ URL::to('/admin') }}" class="btn-secondary btn-class rounded-2" target="_blank">
                            {{ trans('landing.get_started') }}
                        </a>
                        <a href="@if (env('Environment') == 'sendbox') https://1.envato.market/Yg7YmB @else {{ URL::to('/#pricing-plans') }} @endif" class="btn-border-dark rounded-2" @if (env('Environment') == 'sendbox') target="_blank" @endif>
                            {{ trans('labels.buy_now') }}
                        </a>
                    </div>

                </div>
            </div>
            <div class="col-lg-auto management-image-2 aos-init overflow-hidden">
                <div data-aos="fade-left img-div" data-aos-delay="100" data-aos-duration="1000">
                    <img src="{{ helper::image_path($data->image) }}" alt="" class="project-management-image">
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endif
<!-- features -->
@if ($features->count() > 0)
<section id="features">
    <div class="beautiful-ui-kit-bg-color">
        <div class="container beautiful-ui-kit-container">
            <h5 class="beautiful-ui-kit-title col-md-12">
                {{ trans('landing.premium_features') }}
            </h5>
            <p class="subtitle col-md-8 sub-title-mein text-muted">
                {{ trans('landing.premium_features_description') }}
            </p>
            <div class="row row-cols-1 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-3 row-cols-md-2 mt-3 g-4">
                @php
                $strings = ['card-bg-color-1', 'card-bg-color-2', 'card-bg-color-3', 'card-bg-color-4', 'card-bg-color-5', 'card-bg-color-6'];
                $count = count($strings);
                @endphp
                @if ($features->count() > 0)
                @foreach ($features as $key => $feature)
                <div class="col " data-aos="zoom-in" data-aos-delay="100" data-aos-duration="1000">
                    <div class="card beautiful-card border-0 text-center m-auto h-100">
                        <div class="card-body features-body rounded-3">
                            <img src="{{ helper::image_path($feature->image) }}" alt="">
                            <h6 class="card-title my-3 fw-semibold">{{ $feature->title }}</h6>
                            <p class="card-text text-muted fs-7">
                                {{ Str::limit($feature->description) }}
                            </p>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
@endif
<!-- features -->

@if ($themes->count() > 0)
@if (App\Models\SystemAddons::where('unique_identifier', 'template')->first() != null &&
App\Models\SystemAddons::where('unique_identifier', 'template')->first()->activated == 1)
<!-- our-template -->
<section id="our-template">
    <div class="container clients-container">
        <div class="clients overflow-hidden">
            <div class="what-our-clients-says-main">
                <h5 class="what-our-clients-says-title">
                    {{ trans('landing.awesome_templates') }}
                </h5>
                <p class="how-works-subtitle text-center text-muted col-md-8 mx-auto sub-title-mein text-muted">
                    {{ trans('landing.awesome_templates_description') }}
                </p>
            </div>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 row-cols-xl-3 row-cols-xxl-3 g-4 mt-sm-4 mt-3">
                @foreach ($themes as $key => $theme)
                <div class="col" data-aos="fade-up" data-aos-delay="{{ $key == 0 ? $key + 1 : $key }}00" data-aos-duration="1000">
                    <div class="overflow-hidden p-3 h-100 them-card-box">
                        <img src="{{ helper::image_path($theme->image) }}" class="card-img-top them-name-images shadow rounded-2">
                        <div class="pt-4">
                            <h5 class="card-title text-center">{{ $theme->name }}</h5>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>
@endif
@endif

<!-- free_section -->
<section class="you-work-everywhere-you-are-bg-color">
    <div class="container">
        <div data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            <h5 class="you-work-everywhere-you-are  position-relative text-center choose-plan-title">
                {{ trans('landing.free_section') }}
            </h5>
            <P class="choose-plan text-center pt-4 sub-title-mein">
                {{ trans('landing.free_section_description') }}
            </P>
            <div class="text-center mt-4">
                <a href="{{ URL::to('/admin') }}" class="btn-border-white rounded-2" target="_blank">
                    {{ trans('landing.get_started') }}
                </a>
                <a href="@if (env('Environment') == 'sendbox') https://1.envato.market/Yg7YmB @else {{ URL::to('/#pricing-plans') }} @endif" class="btn-primary rounded-2" @if (env('Environment') == 'sendbox') target="_blank" @endif>
                    {{ trans('labels.buy_now') }}
                </a>
            </div>
        </div>
    </div>
</section>
<!-- free_section -->

<!-- our-stores -->
@if (helper::storedata()->count() > 0)
@if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
<!-- our-stores -->
<section id="our-stores">
    <div class="card-section-bg-color">
        <div class="container card-section-container">
            <div>
                <h5 class="hotel-main-title">
                    {{ trans('landing.our_stores') }}
                </h5>
                <p class="hotel-main-subtitle col-md-8 sub-title-mein px-1 text-muted ">
                    {{ trans('landing.our_stores_description') }}
                </p>
            </div>
            <div class="row row-cols-2 mt-2 row-cols-sm-2 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 row-cols-xll-4 g-sm-4 g-2">
                @include('landing.storelist')
            </div>
            <div class="d-flex justify-content-center mt-sm-5 mt-4 view-all-btn">
                <a href="{{ URL::to('/stores') }}" class="btn-secondary rounded-2">{{ trans('landing.view_all') }}
                </a>
            </div>
        </div>
    </div>
</section>
@endif
@endif
<!-- our-stores -->

<!-- Mobile app -->
@if (!empty($app_settings))
@if (App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first() != null &&
App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first()->activated == 1)
<section class="use-as-extension">
    <div class="container work-together-container">
        <div class="work-together row flex-row-reverse align-items-center justify-content-between">
            <div class="col-lg-5 overflow-hidden d-lg-block d-none">
                <div data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
                    <img src="{{ helper::image_path($app_settings->image) }}" alt="" class="img-fluidn object-fit-cover w-100 ">
                </div>
            </div>
            <div class="col-lg-6 overflow-hidden">
                <div data-aos="fade-right" data-aos-delay="100" data-aos-duration="1000">
                    <div class="work-together-content">
                        <div class="extension-text">
                            <div>
                                <h5 class="Work-together-title position-relative use-extension">
                                    {{ trans('landing.mobile_app_section') }}
                                </h5>
                            </div>
                            <p class="with-notes mt-3 use-as-extension-text sub-title-mein text-muted">
                                {{ trans('landing.mobile_app_section_description') }}
                            </p>
                            <div class="d-flex gap-3 mt-sm-5 mt-4 store-img-box">

                                @if (!empty($app_settings->android_link) && $app_settings->android_link != '')
                                <a href="{{ $app_settings->android_link }}" target="_blank">
                                    <img src="{{ url(env('ASSETPATHURL') . '/landing/images/playstore.png') }}" class="store-img bg-black py-3 px-4 rounded-2" alt="">
                                </a>
                                @endif
                                @if (!empty($app_settings->ios_link) && $app_settings->ios_link != '')
                                <a href="{{ $app_settings->ios_link }}" target="_blank">
                                    <img src="{{ url(env('ASSETPATHURL') . '/landing/images/appstorebtn.png') }}" class="store-img bg-black py-3 px-4 rounded-2" alt="">
                                </a>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
@endif
@endif
<!-- Mobile app -->

<!-- pricing-plans -->
@if ($planlist->count() > 0)
@if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
<!-- pricing-plans -->
<section id="pricing-plans">
    <div class="container choose-your-plan-container">
        <h5 class="Work-together-title position-relative text-center choose-plan-title">
            {{ trans('landing.pricing_plan_title') }}
        </h5>
        <P class="choose-plan text-center mt-3 sub-title-mein col-md-8 text-muted mx-auto">
            {{ trans('landing.pricing_plan_description') }}
        </P>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4 choose-card">
            @foreach ($planlist as $plan)
            <div class="col d-flex plan-card">
                <div class="card plan-card-border h-100 w-100">
                    <div class="card-body  plan-card-body">
                        <p class="plan-card-frist-titel">{{ $plan->name }}</p>
                        <div class="d-flex align-items-center">
                            <h5 class="card-title plan-card-second-titel py-2 mb-0">
                                {{ helper::currency_formate($plan->price, '') }} /
                            </h5>&nbsp;
                            <p class="plan-card-second-titel">
                                @if ($plan->plan_type == 1)
                                @if ($plan->duration == 1)
                                {{ trans('labels.one_month') }}
                                @elseif($plan->duration == 2)
                                {{ trans('labels.three_month') }}
                                @elseif($plan->duration == 3)
                                {{ trans('labels.six_month') }}
                                @elseif($plan->duration == 4)
                                {{ trans('labels.one_year') }}
                                @elseif($plan->duration == 5)
                                {{ trans('labels.lifetime') }}
                                @endif
                                @endif
                                @if ($plan->plan_type == 2)
                                {{ $plan->days }}
                                {{ $plan->days > 1 ? trans('labels.days') : trans('labels.day') }}
                                @endif
                            </p>
                        </div>
                        <p class="card-text plan-card-text ">
                        <p class="text-muted capture pb-3 border-bottom border-secondary">
                            {{ $plan->description }}
                        </p>
                        <div class="d-flex iconimg align-items-center mt-3">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">
                                {{ $plan->order_limit == -1 ? trans('labels.unlimited') : $plan->order_limit }}
                                {{ $plan->order_limit > 1 || $plan->order_limit == -1 ? trans('labels.products') : trans('labels.products') }}
                            </p>
                        </div>
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">
                                {{ $plan->appointment_limit == -1 ? trans('labels.unlimited') : $plan->appointment_limit }}
                                {{ $plan->appointment_limit > 1 || $plan->appointment_limit == -1 ? trans('labels.orders') : trans('labels.orders') }}
                            </p>
                        </div>
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            @php
                            $themes = [];
                            if ($plan->themes_id != '' && $plan->themes_id != null) {
                            $themes = explode('|', $plan->themes_id);
                            } @endphp
                            <p class="px-2 fs-15px">{{ count($themes) }}
                                {{ count($themes) > 1 ? trans('labels.themes') : trans('labels.theme') }}
                                <span> <a onclick="themeinfo('{{ $plan->id }}','{{ $plan->themes_id }}','{{ $plan->name }}')" tooltip="{{ trans('labels.info') }}" href="javascript:void(0)">
                                        <i class="fa-regular fa-circle-info"></i> </a></span>
                            </p>
                        </div>
                        @if ($plan->coupons == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.coupons') }}</p>
                        </div>
                        @endif
                        @if ($plan->custom_domain == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.custom_domain_available') }}</p>
                        </div>
                        @endif
                        @if ($plan->google_analytics == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.google_analytics_available') }}
                            </p>
                        </div>
                        @endif
                        @if ($plan->blogs == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.blogs') }}</p>
                        </div>
                        @endif
                        @if ($plan->social_logins == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.social_logins') }}</p>
                        </div>
                        @endif
                        @if ($plan->sound_notification == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.sound_notification') }}</p>
                        </div>
                        @endif
                        @if ($plan->whatsapp_message == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.whatsapp_message') }}</p>
                        </div>
                        @endif
                        @if ($plan->telegram_message == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.telegram_message') }}</p>
                        </div>
                        @endif
                        @if ($plan->vendor_app == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.vendor_app_available') }}</p>
                        </div>
                        @endif
                        @if ($plan->customer_app == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.customer_app') }}</p>
                        </div>
                        @endif
                        @if ($plan->pos == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.pos') }}</p>
                        </div>
                        @endif
                        @if ($plan->pwa == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.pwa') }}</p>
                        </div>
                        @endif
                        @if ($plan->role_management == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.role_management') }}</p>
                        </div>
                        @endif
                        @if ($plan->pixel == 1)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px">{{ trans('labels.pixel') }}</p>
                        </div>
                        @endif
                        @php $features = ($plan->features == null ? null : explode('|', $plan->features));@endphp
                        @if ($features != '')
                        @foreach ($features as $feature)
                        <div class="d-flex iconimg align-items-center">
                            <i class="fa-regular fa-circle-check fs-15px"></i>
                            <p class="px-2 fs-15px w-100">{{ $feature }}</p>
                        </div>
                        @endforeach
                        @endif
                    </div>
                    <div class="card-footer bg-white border-top-0 pb-3">
                        <a href="{{ URL::to('/admin') }}" class="btn-secondary w-100 m-0 text-center py-2 rounded-2" target="_blank">
                            {{ trans('landing.get_started') }}
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endif
<!-- pricing-plans -->


<!-- Funfact start -->
@if ($funfacts->count() > 0)
<section class="fun-fact">
    <div class="container js-ranig-number">
        <div class="row js-nnum row-cols-md-2 row-cols-lg-4 row-cols-xl-4 mx-auto" data-aos="fade-up" data-aos-delay="100" data-aos-duration="1000">
            @foreach ($funfacts as $fact)
            <div class="col-3 py-md-5 py-3 js-main-card">
                <div class="js-number text-center fs-1">
                    {!! $fact->icon !!}
                    <div class="funfact-title">{{ $fact->title }}</div>
                    <div class="js-text-number">
                        <p>
                            {{ $fact->description }}
                        </p>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</section>
@endif
<!-- Funfact End -->

<!-- What Our Clients Says -->
@if ($testimonials->count() > 0)
<div class="client-slaider-bg-color py-5">
    <div class="container client-slaider-container">
        <div class="row align-items-center justify-content-between m-0">
            <div class="col-lg-6 overflow-hidden">
                <div data-aos="fade-left" data-aos-delay="100" data-aos-duration="1000">
                    <div class="carousel-client-slaider owl-stage-outer">
                        <h5>{{ trans('labels.testimonial_title') }}</h5>
                        <p class="text-muted">{{ trans('labels.testimonial_subtitle') }}</p>
                        <div class="owl-carousel client-slai owl-theme h-100 mt-sm-4 mt-2">
                            @foreach ($testimonials as $testimonial)
                            <div class="item client-items w-100 h-100">
                                <div class="card-body h-100">
                                    <div class="card h-100 border-0 rounded-3 d-flex justify-content-center m-auto px-4 py-5">
                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                            <div class="d-flex align-items-center">
                                                <img src="{{ helper::image_path($testimonial->image) }}" alt="" class="invisible-img w-25 h-25 rounded-circle">
                                                <div class="invisible-img-text px-3">
                                                    <p class="annette-text m-0 p-0 text-start">
                                                        {{ $testimonial->name }}
                                                    </p>
                                                    <p class="google-ceo m-0 p-0 text-start">
                                                        {{ $testimonial->position }}
                                                    </p>
                                                </div>
                                            </div>
                                            <img src="{{ url(env('ASSETPATHURL') . 'landing/images/png/Quote.png') }}" alt="" class="quote-png">
                                        </div>
                                        <div class="d-flex align-items-center rattings-tar">
                                            @php
                                            $count = (int) $testimonial->star;
                                            @endphp
                                            @for ($i = 0; $i < 5; $i++) @if ($i <=$count) <i class="fa-solid fa-star text-warning fs-5 mx-1"></i>
                                                @else
                                                <i class="fa-regular fa-star text-warning fs-5 mx-1"></i>
                                                @endif
                                                @endfor
                                        </div>
                                        <p class="card-text client-subtext mt-3 line-3">
                                            “{{ $testimonial->description }}”
                                        </p>

                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 overflow-hidden d-lg-block d-none">
                <div data-aos="flip-left" data-aos-delay="100" data-aos-duration="1000">
                    <img src="{{ @helper::image_path(helper::landingsettings()->testimonial_image) }}" alt="" class="img-fluidn object-fit-cover w-100">
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- What Our Clients Says End -->

<!-- Blogs start -->
@if ($blogs->count() > 0)
@if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
<section id="blogs">
    <div class="blogs-bg-color">
        <div class="container blog-container">
            <div class="blog-card">
                <h5 class="latest-blog">{{ trans('landing.blog_section_title') }}
                </h5>
                <p class="blog-lorem-text col-md-8 pt-lg-4 pt-2 pb-5 sub-title-mein text-muted">
                    {{ trans('landing.blog_section_description') }}
                </p>
                <div class="owl-carousel blogs-slaider owl-theme pb-5">
                    @include('landing.blogcommonview')
                </div>
                <div class="d-flex justify-content-center view-all-btn">
                    <a href="{{ URL::to('/blogs') }}" class="btn-secondary rounded-2">{{ trans('landing.view_all') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif
@endif
<!-- Blogs End -->

<!-- contact  start -->
<section id="contact-us" class="contact-bg-color">
    <div class="container contact-container">
        <div class="contact-main d-flex align-items-center justify-content-between">
            <div class="overflow-hidden">
                <div class="main-text-title">
                    <div class="contact-title col-md-10 pb-2">
                        {{ trans('landing.contact_section_title') }}
                    </div>
                    <p class="contact-subtitle col-md-12 col-lg-10 pb-4 sub-title-mein text-muted">
                        {{ trans('landing.contact_section_description') }}
                    </p>
                    <div class="pb-4 contact-email-box">
                        <div class="email-icon-text-box">
                            <p class="email-text p-0 m-0">{{ trans('landing.email_us') }}</p>
                            <p class="infogolio-email p-0 m-0"><a href="mailto:{{ helper::appdata('')->email }}">{{ helper::appdata('')->email }}</a>
                            </p>
                        </div>
                        <div class="email-icon-text-box mt-3">
                            <p class="email-text p-0 m-0">{{ trans('landing.call_us') }}</p>
                            <p class="infogolio-email p-0 m-0"><a href="tel:{{ helper::appdata('')->contact }}">{{ helper::appdata('')->contact }}</a>
                            </p>
                        </div>
                        <div class="email-icon-text-box mt-3">
                            <p class="email-text p-0 m-0">{{ trans('landing.address') }}</p>
                            <p class="infogolio-email p-0 m-0"><a href="tel:{{ helper::appdata('')->address }}">{{ helper::appdata('')->address }}</a>
                            </p>
                        </div>
                    </div>

                    <div class="email-icon-text-box-2">
                        <div class="email-md-center">
                            <div class="contact-icons d-flex">
                                @foreach (@helper::getsociallinks(1) as $links)
                                <a href="{{ $links->link }}" target="_blank" class="rounded-2 contact-icon">{!! $links->icon !!}</a>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contact-form col-md-5">
                <form class="border border-2 bg-primary-rgb border-primary bg-white rounded-3 px-sm-4 px-3 py-4" action="{{ URL::To('/inquiry') }}" method="post">
                    @csrf
                    <h5 class="contact-form-title text-center">
                        {{ trans('landing.contact_us') }}
                    </h5>
                    <p class="contact-form-subtitle text-center text-muted">
                        {{ trans('landing.contact_section_description_two') }}
                    </p>
                    <div class="row g-1 mt-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label contact-form-label">{{ trans('landing.name') }}</label>
                            <input type="text" class="form-control contact-input" name="name" placeholder="{{ trans('landing.name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label contact-form-label">{{ trans('landing.email') }}</label>
                            <input type="email" class="form-control contact-input" name="email" placeholder="{{ trans('landing.email') }}" required>
                        </div>
                        <div class="col-12">
                            <label for="inputAddress" class="form-label contact-form-label">{{ trans('landing.mobile') }}</label>
                            <input type="number" class="form-control contact-input" name="mobile" placeholder="{{ trans('landing.mobile') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label contact-form-label">{{ trans('landing.message') }}</label>
                            <textarea class="form-control contact-input" rows="3" name="message" placeholder="{{ trans('landing.message') }}" required></textarea>
                        </div>
                        @include('landing.layout.recaptcha')
                        <div class="col-6 mx-auto">
                            <button type="submit" class="btn-secondary w-100 rounded-2">{{ trans('landing.submit') }}</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</section>
<!-- contact end -->

<!-- subscription -->
@include('landing.newslatter')
<!--theme image Modal -->
<div class="modal fade" id="themeinfo" tabindex="-1" aria-labelledby="themeinfoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="themeinfoLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="theme_modalbody">
                {{-- <div class="row theme_image">
                </div> --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var layout = "{{ session()->get('direction') }}";
</script>
<!-- IF VERSION 2  -->
@if (helper::appdata('')->recaptcha_version == 'v2')
<script src='https://www.google.com/recaptcha/api.js'></script>
@endif
<!-- IF VERSION 3  -->
@if (helper::appdata('')->recaptcha_version == 'v3')
{!! RecaptchaV3::initJs() !!}
@endif
@endsection