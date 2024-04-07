@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
    $user = App\Models\User::where('id', $vendor_id)->first();
@endphp

@section('content')
    <h5 class="text-uppercase">
        {{ trans('labels.settings') }}</h5>
    <div class="row settings mt-3">
        <div class="col-xl-3 mb-3">
            <div class="card card-sticky-top border-0">
                <ul class="list-group list-options">
                    <a href="#basicinfo" data-tab="basicinfo"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                        aria-current="true">{{ trans('labels.basic_info') }} <i class="fa-regular fa-angle-right"></i></a>
                    @if (Auth::user()->type == 1)
                        <a href="#theme_images" data-tab="theme_images"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.theme') }} {{ trans('labels.images') }} <i
                                class="fa-regular fa-angle-right"></i></a>
                    @endif
                    <a href="#editprofile" data-tab="editprofile"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.edit_profile') }} <i class="fa-regular fa-angle-right"></i></a>
                    <a href="#changepasssword" data-tab="changepasssword"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.change_password') }} <i
                            class="fa-regular fa-angle-right"></i></a>

                    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();
                                    if (@$user->allow_without_subscription == 1) {
                                        $whatsapp_message = 1;
                                    } else {
                                        $whatsapp_message = @$checkplan->whatsapp_message;
                                    }
                                @endphp
                                @if ($whatsapp_message == 1)
                                    <a href="#whatsappmessagesettings" data-tab="whatsappmessagesettings"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.whatsapp_message') }} @if (env('Environment') == 'sendbox')
                                            <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                        @endif
                                        <i class="fa-regular fa-angle-right"></i></a>
                                @endif
                            @endif
                        @else
                            @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                                <a href="#whatsappmessagesettings" data-tab="whatsappmessagesettings"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.whatsapp_message') }} @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i class="fa-regular fa-angle-right"></i></a>
                            @endif
                        @endif

                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();
                                    if (@$user->allow_without_subscription == 1) {
                                        $telegram_message = 1;
                                    } else {
                                        $telegram_message = @$checkplan->telegram_message;
                                    }
                                @endphp
                                @if ($telegram_message == 1)
                                    <a href="#telegram" data-tab="telegram"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.telegram_message_settings') }}@if (env('Environment') == 'sendbox')
                                            <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                        @endif
                                        <i class="fa-regular fa-angle-right"></i>
                                    </a>
                                @endif
                            @endif
                        @else
                            @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                                <a href="#telegram" data-tab="telegram"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.telegram_message_settings') }}@if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i class="fa-regular fa-angle-right"></i>
                                </a>
                            @endif
                        @endif
                    @endif

                    @if (Auth::user()->type == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first()->activated == 1)
                            <a href="#google_analytics" data-tab="google_analytics"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.google_analytics') }}@if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                @endif <i class="fa-regular fa-angle-right"></i></a>
                        @endif
                        @if (App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first()->activated == 1)
                            <a href="#recaptcha" data-tab="recaptcha"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.google_recaptcha') }}@if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                @endif <i class="fa-regular fa-angle-right"></i></a>
                        @endif
                    @endif
                    <a href="#email_settings" data-tab="email_settings"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.email_settings') }} <i
                            class="fa-regular fa-angle-right"></i></a>

                    @if (Auth::user()->type == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1)
                            <a href="#social_login_settings" data-tab="social_login_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.social_logins') }} @if (env('Environment') == 'sendbox')
                                    <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                @endif
                                <i class="fa-regular fa-angle-right"></i></a>
                        @endif
                    @endif
                    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            @if (App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1)
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if (@$user->allow_without_subscription == 1) {
                                        $social_login = 1;
                                    } else {
                                        $social_login = @$checkplan->social_login;
                                    }
                                @endphp
                                @if ($social_login == 1)
                                    <a href="#social_login_settings" data-tab="social_login_settings"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.social_logins') }}@if (env('Environment') == 'sendbox')
                                            <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                        @endif <i class="fa-regular fa-angle-right"></i></a>
                                @endif
                            @endif
                        @else
                            @if (App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1)
                                <a href="#social_login_settings" data-tab="social_login_settings"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.social_logins') }} @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                    @endif <i class="fa-regular fa-angle-right"></i></a>
                            @endif
                        @endif
                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            @if (App\Models\SystemAddons::where('unique_identifier', 'pixel')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'pixel')->first()->activated == 1)
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if (@$user->allow_without_subscription == 1) {
                                        $pixel = 1;
                                    } else {
                                        $pixel = @$checkplan->pixel;
                                    }
                                @endphp
                                @if ($pixel == 1)
                                    <a href="#pixel_settings" data-tab="pixel_settings"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.pixel_settings') }} <i
                                            class="fa-regular fa-angle-right"></i></a>
                                @endif
                            @endif
                        @else
                            @if (App\Models\SystemAddons::where('unique_identifier', 'pixel')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'pixel')->first()->activated == 1)
                                <a href="#pixel_settings" data-tab="pixel_settings"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.pixel_settings') }} <i
                                        class="fa-regular fa-angle-right"></i></a>
                            @endif
                        @endif
                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            @if (App\Models\SystemAddons::where('unique_identifier', 'shopify')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'shopify')->first()->activated == 1)
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if (@$user->allow_without_subscription == 1) {
                                        $shopify = 1;
                                    } else {
                                        $shopify = @$checkplan->shopify;
                                    }
                                @endphp
                                @if ($shopify == 1)
                                    <a href="#shopify_settings" data-tab="shopify_settings"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.shopify_settings') }} <i
                                            class="fa-regular fa-angle-right"></i></a>
                                @endif
                            @endif
                        @else
                            @if (App\Models\SystemAddons::where('unique_identifier', 'shopify')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'shopify')->first()->activated == 1)
                                <a href="#shopify_settings" data-tab="shopify_settings"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.shopify_settings') }} <i
                                        class="fa-regular fa-angle-right"></i></a>
                            @endif
                        @endif
                        <a href="#delete_profile" data-tab="delete_profile"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.delete_profile') }} <i
                                class="fa-regular fa-angle-right"></i></a>
                    @endif

                </ul>
            </div>
        </div>
        <div class="col-xl-9">
            <div id="settingmenuContent">
                <div id="basicinfo">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.basic_info') }}</h5>
                                    </div>
                                    <form action="{{ URL::to('admin/settings/update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <div class="col-md-3">
                                                            <label
                                                                class="form-label">{{ trans('labels.currency_symbol') }}<span
                                                                    class="text-danger"> * </span></label>
                                                            <input type="text" class="form-control" name="currency"
                                                                value="{{ @$settingdata->currency }}"
                                                                placeholder="{{ trans('labels.currency_symbol') }}"
                                                                required>
                                                            @error('currency')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-3">
                                                            <p class="form-label">
                                                                {{ trans('labels.currency_position') }}
                                                            </p>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input form-check-input-secondary"
                                                                    type="radio" name="currency_position"
                                                                    id="radio" value="1"
                                                                    {{ @$settingdata->currency_position == 'left' ? 'checked' : '' }} />
                                                                <label for="radio"
                                                                    class="form-check-label">{{ trans('labels.left') }}</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input form-check-input-secondary"
                                                                    type="radio" name="currency_position"
                                                                    id="radio1" value="2"
                                                                    {{ @$settingdata->currency_position == 'right' ? 'checked' : '' }} />
                                                                <label for="radio1"
                                                                    class="form-check-label">{{ trans('labels.right') }}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label
                                                                class="form-label">{{ trans('labels.currency_formate') }}<span
                                                                    class="text-danger"> * </span></label>
                                                            <input type="number" class="form-control numbers_only"
                                                                name="currency_formate"
                                                                value="{{ @$settingdata->currency_formate }}"
                                                                placeholder="{{ trans('labels.currency_formate') }}"
                                                                required>
                                                            @error('currency_formate')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label
                                                                class="form-label">{{ trans('labels.decimal_separator') }}</label><br>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input form-check-input-secondary"
                                                                    type="radio" name="decimal_separator"
                                                                    id="dot" value="1" checked
                                                                    {{ @$settingdata->decimal_separator == '1' ? 'checked' : '' }} />
                                                                <label for="dot"
                                                                    class="form-check-label">{{ trans('labels.dot') }}
                                                                    (.)</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input form-check-input-secondary"
                                                                    type="radio" name="decimal_separator"
                                                                    id="comma" value="2"
                                                                    {{ @$settingdata->decimal_separator == '2' ? 'checked' : '' }} />
                                                                <label for="comma"
                                                                    class="form-check-label">{{ trans('labels.comma') }}
                                                                    (,)</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3 form-group">
                                                <label class="form-label"
                                                    for="">{{ trans('labels.maintenance_mode') }}
                                                </label>
                                                <input id="maintenance_mode-switch" type="checkbox"
                                                    class="checkbox-switch" name="maintenance_mode" value="1"
                                                    {{ $settingdata->maintenance_mode == 1 ? 'checked' : '' }}>
                                                <label for="maintenance_mode-switch" class="switch">
                                                    <span
                                                        class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                            class="switch__circle-inner"></span></span>
                                                    <span
                                                        class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                    <span
                                                        class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                </label>
                                            </div>
                                            @if (Auth::user()->type == 1)
                                                <div class="col-md-3 form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.vendor_register') }}
                                                    </label>
                                                    <input id="vendor_register-switch" type="checkbox"
                                                        class="checkbox-switch" name="vendor_register" value="1"
                                                        {{ $settingdata->vendor_register == 1 ? 'checked' : '' }}>
                                                    <label for="vendor_register-switch" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                                                @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                                        App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
                                                    <div
                                                        class="{{ env('Environment') == 'sendbox' ? 'col-md-4' : 'col-md-3' }}">
                                                        <label class="form-label"
                                                            for="">{{ trans('labels.checkout_login_required') }}
                                                        </label>
                                                        @if (env('Environment') == 'sendbox')
                                                            <span
                                                                class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                        @endif
                                                        <input id="checkout_login_required-switch" type="checkbox"
                                                            class="checkbox-switch" name="checkout_login_required"
                                                            value="1"
                                                            {{ $settingdata->checkout_login_required == 1 ? 'checked' : '' }}>
                                                        <label for="checkout_login_required-switch" class="switch">
                                                            <span
                                                                class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                            <span
                                                                class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                        </label>
                                                    </div>
                                                @endif
                                                <div
                                                class="{{ env('Environment') == 'sendbox' ? 'col-md-4' : 'col-md-3' }}">
                                                <label class="form-label"
                                                    for="">{{ trans('labels.time_format') }}
                                                </label>
                                                
                                                <input id="time_format-switch" type="checkbox"
                                                    class="checkbox-switch" name="time_format"
                                                    value="1"
                                                    {{ $settingdata->time_format == 1 ? 'checked' : '' }}>
                                                <label for="time_format-switch" class="switch">
                                                    <span
                                                        class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                            class="switch__circle-inner"></span></span>
                                                    <span
                                                        class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                    <span
                                                        class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                </label>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label">{{ trans('labels.time_zone') }}</label>
                                                    <select class="form-select" name="timezone">
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Midway' ? 'selected' : '' }}
                                                            value="Pacific/Midway">(GMT-11:00) Midway Island, Samoa
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Adak' ? 'selected' : '' }}
                                                            value="America/Adak">(GMT-10:00) Hawaii-Aleutian
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Etc/GMT+10' ? 'selected' : '' }}
                                                            value="Etc/GMT+10">(GMT-10:00) Hawaii</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Marquesas' ? 'selected' : '' }}
                                                            value="Pacific/Marquesas">(GMT-09:30) Marquesas Islands
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Gambier' ? 'selected' : '' }}
                                                            value="Pacific/Gambier">(GMT-09:00) Gambier Islands
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Anchorage' ? 'selected' : '' }}
                                                            value="America/Anchorage">(GMT-09:00) Alaska</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Ensenada' ? 'selected' : '' }}
                                                            value="America/Ensenada">(GMT-08:00) Tijuana, Baja
                                                            California </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Etc/GMT+8' ? 'selected' : '' }}
                                                            value="Etc/GMT+8">(GMT-08:00) Pitcairn Islands</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Los_Angeles' ? 'selected' : '' }}
                                                            value="America/Los_Angeles">(GMT-08:00) Pacific Time
                                                            (US
                                                            &amp; Canada) </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Denver' ? 'selected' : '' }}
                                                            value="America/Denver">(GMT-07:00) Mountain Time (US
                                                            &amp;
                                                            Canada) </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Chihuahua' ? 'selected' : '' }}
                                                            value="America/Chihuahua">(GMT-07:00) Chihuahua, La
                                                            Paz,
                                                            Mazatlan </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Dawson_Creek' ? 'selected' : '' }}
                                                            value="America/Dawson_Creek">(GMT-07:00) Arizona
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Belize' ? 'selected' : '' }}
                                                            value="America/Belize">(GMT-06:00) Saskatchewan,
                                                            Central
                                                            America </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Cancun' ? 'selected' : '' }}
                                                            value="America/Cancun">(GMT-06:00) Guadalajara, Mexico
                                                            City,
                                                            Monterrey </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Chile/EasterIsland' ? 'selected' : '' }}
                                                            value="Chile/EasterIsland">(GMT-06:00) Easter Island
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Chicago' ? 'selected' : '' }}
                                                            value="America/Chicago">(GMT-06:00) Central Time (US
                                                            &amp;
                                                            Canada) </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/New_York' ? 'selected' : '' }}
                                                            value="America/New_York">(GMT-05:00) Eastern Time (US
                                                            &amp;
                                                            Canada) </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Havana' ? 'selected' : '' }}
                                                            value="America/Havana">(GMT-05:00) Cuba</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Bogota' ? 'selected' : '' }}
                                                            value="America/Bogota">(GMT-05:00) Bogota, Lima, Quito,
                                                            Rio
                                                            Branco </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Caracas' ? 'selected' : '' }}
                                                            value="America/Caracas">(GMT-04:30) Caracas</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Santiago' ? 'selected' : '' }}
                                                            value="America/Santiago">(GMT-04:00) Santiago</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/La_Paz' ? 'selected' : '' }}
                                                            value="America/La_Paz">(GMT-04:00) La Paz</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Atlantic/Stanley' ? 'selected' : '' }}
                                                            value="Atlantic/Stanley">(GMT-04:00) Faukland Islands
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Campo_Grande' ? 'selected' : '' }}
                                                            value="America/Campo_Grande">(GMT-04:00) Brazil
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Goose_Bay' ? 'selected' : '' }}
                                                            value="America/Goose_Bay">(GMT-04:00) Atlantic Time
                                                            (Goose
                                                            Bay) </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Glace_Bay' ? 'selected' : '' }}
                                                            value="America/Glace_Bay">(GMT-04:00) Atlantic Time
                                                            (Canada) </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/St_Johns' ? 'selected' : '' }}
                                                            value="America/St_Johns">(GMT-03:30) Newfoundland
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Araguaina' ? 'selected' : '' }}
                                                            value="America/Araguaina">(GMT-03:00) UTC-3</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Montevideo' ? 'selected' : '' }}
                                                            value="America/Montevideo">(GMT-03:00) Montevideo
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Miquelon' ? 'selected' : '' }}
                                                            value="America/Miquelon">(GMT-03:00) Miquelon, St.
                                                            Pierre
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Godthab' ? 'selected' : '' }}
                                                            value="America/Godthab">(GMT-03:00) Greenland</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Argentina' ? 'selected' : '' }}
                                                            value="America/Argentina/Buenos_Aires">(GMT-03:00)
                                                            Buenos
                                                            Aires </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Sao_Paulo' ? 'selected' : '' }}
                                                            value="America/Sao_Paulo">(GMT-03:00) Brasilia</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'America/Noronha' ? 'selected' : '' }}
                                                            value="America/Noronha">(GMT-02:00) Mid-Atlantic
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Atlantic/Cape_Verde' ? 'selected' : '' }}
                                                            value="Atlantic/Cape_Verde">(GMT-01:00) Cape Verde Is.
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Atlantic/Azores' ? 'selected' : '' }}
                                                            value="Atlantic/Azores">(GMT-01:00) Azores</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Belfast' ? 'selected' : '' }}
                                                            value="Europe/Belfast">(GMT) Greenwich Mean Time :
                                                            Belfast
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Dublin' ? 'selected' : '' }}
                                                            value="Europe/Dublin">(GMT) Greenwich Mean Time :
                                                            Dublin
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Lisbon' ? 'selected' : '' }}
                                                            value="Europe/Lisbon">(GMT) Greenwich Mean Time :
                                                            Lisbon
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/London' ? 'selected' : '' }}
                                                            value="Europe/London">(GMT) Greenwich Mean Time :
                                                            London
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Africa/Abidjan' ? 'selected' : '' }}
                                                            value="Africa/Abidjan">(GMT) Monrovia, Reykjavik
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Amsterdam' ? 'selected' : '' }}
                                                            value="Europe/Amsterdam">(GMT+01:00) Amsterdam, Berlin,
                                                            Bern, Rome, Stockholm, Vienna</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Belgrade' ? 'selected' : '' }}
                                                            value="Europe/Belgrade">(GMT+01:00) Belgrade,
                                                            Bratislava,
                                                            Budapest, Ljubljana, Prague</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Brussels' ? 'selected' : '' }}
                                                            value="Europe/Brussels">(GMT+01:00) Brussels,
                                                            Copenhagen,
                                                            Madrid, Paris </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Africa/Algiers' ? 'selected' : '' }}
                                                            value="Africa/Algiers">(GMT+01:00) West Central Africa
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Africa/Windhoek' ? 'selected' : '' }}
                                                            value="Africa/Windhoek">(GMT+01:00) Windhoek</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Beirut' ? 'selected' : '' }}
                                                            value="Asia/Beirut">(GMT+02:00) Beirut</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Africa/Cairo' ? 'selected' : '' }}
                                                            value="Africa/Cairo">(GMT+02:00) Cairo</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Gaza' ? 'selected' : '' }}
                                                            value="Asia/Gaza">(GMT+02:00) Gaza</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Africa/Blantyre' ? 'selected' : '' }}
                                                            value="Africa/Blantyre">(GMT+02:00) Harare, Pretoria
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Jerusalem' ? 'selected' : '' }}
                                                            value="Asia/Jerusalem">(GMT+02:00) Jerusalem</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Minsk' ? 'selected' : '' }}
                                                            value="Europe/Minsk">(GMT+02:00) Minsk</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Damascus' ? 'selected' : '' }}
                                                            value="Asia/Damascus">(GMT+02:00) Syria</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Europe/Moscow' ? 'selected' : '' }}
                                                            value="Europe/Moscow">(GMT+03:00) Moscow, St.
                                                            Petersburg,
                                                            Volgograd </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Africa/Addis_Ababa' ? 'selected' : '' }}
                                                            value="Africa/Addis_Ababa">(GMT+03:00) Nairobi</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Tehran' ? 'selected' : '' }}
                                                            value="Asia/Tehran">(GMT+03:30) Tehran</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Dubai' ? 'selected' : '' }}
                                                            value="Asia/Dubai">(GMT+04:00) Abu Dhabi, Muscat
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Yerevan' ? 'selected' : '' }}
                                                            value="Asia/Yerevan">(GMT+04:00) Yerevan</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Kabul' ? 'selected' : '' }}
                                                            value="Asia/Kabul">(GMT+04:30) Kabul</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Yekaterinburg' ? 'selected' : '' }}
                                                            value="Asia/Yekaterinburg">(GMT+05:00) Ekaterinburg
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Tashkent' ? 'selected' : '' }}
                                                            value="Asia/Tashkent"> (GMT+05:00) Tashkent</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Kolkata' ? 'selected' : '' }}
                                                            value="Asia/Kolkata"> (GMT+05:30) Chennai, Kolkata,
                                                            Mumbai,
                                                            New Delhi</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Katmandu' ? 'selected' : '' }}
                                                            value="Asia/Katmandu">(GMT+05:45) Kathmandu</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Dhaka' ? 'selected' : '' }}
                                                            value="Asia/Dhaka">(GMT+06:00) Astana, Dhaka</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Novosibirsk' ? 'selected' : '' }}
                                                            value="Asia/Novosibirsk">(GMT+06:00) Novosibirsk
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Rangoon' ? 'selected' : '' }}
                                                            value="Asia/Rangoon">(GMT+06:30) Yangon (Rangoon)
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Bangkok' ? 'selected' : '' }}
                                                            value="Asia/Bangkok">(GMT+07:00) Bangkok, Hanoi,
                                                            Jakarta
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Kuala_Lumpur' ? 'selected' : '' }}
                                                            value="Asia/Kuala_Lumpur">(GMT+08:00) Kuala Lumpur
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Krasnoyarsk' ? 'selected' : '' }}
                                                            value="Asia/Krasnoyarsk">(GMT+07:00) Krasnoyarsk
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Hong_Kong' ? 'selected' : '' }}
                                                            value="Asia/Hong_Kong">(GMT+08:00) Beijing, Chongqing,
                                                            Hong
                                                            Kong, Urumqi</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Irkutsk' ? 'selected' : '' }}
                                                            value="Asia/Irkutsk">(GMT+08:00) Irkutsk, Ulaan Bataar
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Australia/Perth' ? 'selected' : '' }}
                                                            value="Australia/Perth">(GMT+08:00) Perth</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Australia/Eucla' ? 'selected' : '' }}
                                                            value="Australia/Eucla">(GMT+08:45) Eucla</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Tokyo' ? 'selected' : '' }}
                                                            value="Asia/Tokyo">(GMT+09:00) Osaka, Sapporo, Tokyo
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Seoul' ? 'selected' : '' }}
                                                            value="Asia/Seoul">(GMT+09:00) Seoul</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Yakutsk' ? 'selected' : '' }}
                                                            value="Asia/Yakutsk">(GMT+09:00) Yakutsk</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Australia/Adelaide' ? 'selected' : '' }}
                                                            value="Australia/Adelaide">(GMT+09:30) Adelaide
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Australia/Darwin' ? 'selected' : '' }}
                                                            value="Australia/Darwin">(GMT+09:30) Darwin</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Australia/Brisbane' ? 'selected' : '' }}
                                                            value="Australia/Brisbane">(GMT+10:00) Brisbane
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Australia/Hobart' ? 'selected' : '' }}
                                                            value="Australia/Hobart">(GMT+10:00) Hobart</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Vladivostok' ? 'selected' : '' }}
                                                            value="Asia/Vladivostok">(GMT+10:00) Vladivostok
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Australia/Lord_Howe' ? 'selected' : '' }}
                                                            value="Australia/Lord_Howe">(GMT+10:30) Lord Howe
                                                            Island
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Etc/GMT-11' ? 'selected' : '' }}
                                                            value="Etc/GMT-11">(GMT+11:00) Solomon Is., New
                                                            Caledonia
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Magadan' ? 'selected' : '' }}
                                                            value="Asia/Magadan">(GMT+11:00) Magadan</option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Norfolk' ? 'selected' : '' }}
                                                            value="Pacific/Norfolk">(GMT+11:30) Norfolk Island
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Asia/Anadyr' ? 'selected' : '' }}
                                                            value="Asia/Anadyr">(GMT+12:00) Anadyr, Kamchatka
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Auckland' ? 'selected' : '' }}
                                                            value="Pacific/Auckland">(GMT+12:00) Auckland,
                                                            Wellington
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Etc/GMT-12' ? 'selected' : '' }}
                                                            value="Etc/GMT-12">(GMT+12:00) Fiji, Kamchatka,
                                                            Marshall
                                                            Is. </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Chatham' ? 'selected' : '' }}
                                                            value="Pacific/Chatham">(GMT+12:45) Chatham Islands
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Tongatapu' ? 'selected' : '' }}
                                                            value="Pacific/Tongatapu">(GMT+13:00) Nuku'alofa
                                                        </option>
                                                        <option
                                                            {{ @$settingdata->timezone == 'Pacific/Kiritimati' ? 'selected' : '' }}
                                                            value="Pacific/Kiritimati">(GMT+14:00) Kiritimati
                                                        </option>
                                                    </select>
                                                    @error('timezone')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                @if (Auth::user()->type == 1)
                                                    @if (App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first() != null &&
                                                            App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first()->activated == 1)
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ trans('labels.firebase_server_key') }}</label>
                                                            @if (env('Environment') == 'sendbox')
                                                                <span
                                                                    class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                            @endif
                                                            <input type="text" class="form-control"
                                                                name="firebase_server_key"
                                                                value="{{ @$settingdata->firebase }}"
                                                                placeholder="{{ trans('labels.firebase_server_key') }}"
                                                                required>
                                                            @error('firebase_server_key')
                                                                <small class="text-danger">{{ $message }}</small> <br>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                @endif

                                                @if (Auth::user()->type == 2)
                                                    @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                                                            App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ trans('labels.firebase_server_key') }}</label>
                                                            @if (env('Environment') == 'sendbox')
                                                                <span
                                                                    class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                            @endif
                                                            <input type="text" class="form-control"
                                                                name="firebase_server_key"
                                                                value="{{ @$settingdata->firebase }}"
                                                                placeholder="{{ trans('labels.firebase_server_key') }}"
                                                                required>
                                                            @error('firebase_server_key')
                                                                <small class="text-danger">{{ $message }}</small> <br>
                                                            @enderror
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                            
                                            @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                                                <div class="col-md-6">
                                                    <label for=""
                                                        class="form-label">{{ trans('labels.order_type') }}</label>
                                                    <div class="form-group">


                                                        <input class="form-check-input me-0 store_can_sale mx-2"
                                                            type="checkbox" name="delivery_type[]" id="delivery1"
                                                            value="delivery"
                                                            @if (in_Array('delivery', explode('|', $settingdata->delivery_type))) checked @endif>
                                                        <label class="form-check-label"
                                                            for="delivery1">{{ trans('labels.delivery') }}</label>

                                                        <input class="form-check-input me-0 store_can_sale mx-2"
                                                            type="checkbox" name="delivery_type[]" id="delivery2"
                                                            value="pickup"
                                                            @if (in_Array('pickup', explode('|', $settingdata->delivery_type))) checked @endif>
                                                        <label class="form-check-label"
                                                            for="delivery2">{{ trans('labels.pickup') }}</label>

                                                        <input class="form-check-input me-0 store_can_sale mx-2"
                                                            type="checkbox" name="delivery_type[]" id="delivery3"
                                                            value="table"
                                                            @if (in_Array('table', explode('|', $settingdata->delivery_type))) checked @endif>
                                                        <label class="form-check-label"
                                                            for="delivery3">{{ trans('labels.table') }}</label>



                                                        @error('delivery_type')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.date_time') }}
                                                    </label>
                                                    <input id="ordertypedatetime-switch" type="checkbox"
                                                        class="checkbox-switch" name="ordertypedatetime" value="1"
                                                        {{ $settingdata->ordertype_date_time == 1 ? 'checked' : '' }}>
                                                    <label for="ordertypedatetime-switch" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                            @endif
                                            @if (Auth::user()->type == 2 || Auth::user()->type == 4)

                                                @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                                        App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                                                    @if (App\Models\SystemAddons::where('unique_identifier', 'notification')->first() != null &&
                                                            App\Models\SystemAddons::where('unique_identifier', 'notification')->first()->activated == 1)
                                                        @php

                                                            $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                                                ->orderByDesc('id')
                                                                ->first();

                                                            if (@$user->allow_without_subscription == 1) {
                                                                $sound_notification = 1;
                                                            } else {
                                                                $sound_notification = @$checkplan->sound_notification;
                                                            }

                                                        @endphp
                                                        @if ($sound_notification == 1)
                                                            <div class="form-group col-md-6">
                                                                <label
                                                                    class="form-label">{{ trans('labels.notification_sound') }}</label>
                                                                @if (env('Environment') == 'sendbox')
                                                                    <span
                                                                        class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                                @endif
                                                                <input type="file" class="form-control"
                                                                    name="notification_sound">
                                                                @error('notification_sound')
                                                                    <small
                                                                        class="text-danger">{{ $message }}</small><br>
                                                                @enderror
                                                                @if (!empty($settingdata->notification_sound) && $settingdata->notification_sound != null)
                                                                    <audio controls class="mt-1">
                                                                        <source
                                                                            src="{{ url(env('ASSETPATHURL') . 'admin-assets/notification/' . $settingdata->notification_sound) }}"
                                                                            type="audio/mpeg">
                                                                    </audio>
                                                                @endif
                                                            </div>
                                                        @endif

                                                    @endif
                                                @else
                                                    @if (App\Models\SystemAddons::where('unique_identifier', 'notification')->first() != null &&
                                                            App\Models\SystemAddons::where('unique_identifier', 'notification')->first()->activated == 1)
                                                        <div class="form-group col-md-6">
                                                            <label
                                                                class="form-label">{{ trans('labels.notification_sound') }}</label>
                                                            @if (env('Environment') == 'sendbox')
                                                                <span
                                                                    class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                            @endif
                                                            <input type="file" class="form-control"
                                                                name="notification_sound">
                                                            @error('notification_sound')
                                                                <small class="text-danger">{{ $message }}</small><br>
                                                            @enderror
                                                            @if (!empty($settingdata->notification_sound) && $settingdata->notification_sound != null)
                                                                <audio controls class="mt-1">
                                                                    <source
                                                                        src="{{ url(env('ASSETPATHURL') . 'admin-assets/notification/' . $settingdata->notification_sound) }}"
                                                                        type="audio/mpeg">
                                                                </audio>
                                                            @endif
                                                        </div>
                                                    @endif
                                                @endif

                                            @endif

                                            <div class="form-group text-end">
                                                <button
                                                    class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="updatebasicinfo" value="1" @endif>{{ trans('labels.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->type == 1)
                    <div id="theme_images">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body pb-0">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="text-uppercase">{{ trans('labels.themes') }}
                                                {{ trans('labels.images') }} @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                            </h5>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                @php
                                                    if (App\Models\SystemAddons::where('unique_identifier', 'template')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'template')->first()->activated == 1) {
                                                        $themes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                                                    } else {
                                                        $themes = [1];
                                                    }
                                                @endphp
                                                <ul class="theme-selection">
                                                    @foreach ($themes as $key => $item)
                                                        <li>
                                                            <label for="template{{ $item }}">
                                                                <img
                                                                    src="{{ helper::image_path('theme-' . $item . '.png') }}">
                                                            </label>
                                                            <div class="text-center mt-2">
                                                                <a class="btn btn-outline-info btn-sm"
                                                                    id="{{ $item }}"
                                                                    onclick="editimage(this.id)"><i
                                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div id="editprofile">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.edit_profile') }}</h5>
                                    </div>
                                    <form method="POST"
                                        action="{{ URL::to('admin/settings/update-profile-' . Auth::user()->id) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.name') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="name"
                                                    value="{{ Auth::user()->name }}"
                                                    placeholder="{{ trans('labels.name') }}" required>
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.email') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="email" class="form-control" name="email"
                                                    value="{{ Auth::user()->email }}"
                                                    placeholder="{{ trans('labels.email') }}" required>
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label"
                                                    for="mobile">{{ trans('labels.mobile') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control mobile-number" name="mobile"
                                                    id="mobile" value="{{ Auth::user()->mobile }}"
                                                    placeholder="{{ trans('labels.mobile') }}" required>
                                                @error('mobile')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.image') }}</label>
                                                <input type="file" class="form-control" name="profile">
                                                <img class="img-fluid rounded hw-70 mt-1"
                                                    src="{{ helper::image_Path(Auth::user()->image) }}" alt="">
                                            </div>
                                            @if (Auth::user()->type == 2)
                                                @if (App\Models\SystemAddons::where('unique_identifier', 'unique_slug')->first() != null &&
                                                        App\Models\SystemAddons::where('unique_identifier', 'unique_slug')->first()->activated == 1)
                                                    @php
                                                        $domain = App\Models\CustomDomain::where('vendor_id', $vendor_id)->first();
                                                    @endphp

                                                    @if (!empty($domain) && @$domain->status != 1)
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ trans('labels.personlized_link') }}<span
                                                                    class="text-danger"> * </span></label>
                                                            @if (env('Environment') == 'sendbox')
                                                                <span
                                                                    class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                            @endif
                                                            <div class="input-group">
                                                                <span class="input-group-text">{{ URL::to('/') }}</span>
                                                                <input type="text" class="form-control" id="slug"
                                                                    name="slug" value="{{ $user->slug }}"
                                                                    required>
                                                            </div>
                                                            @error('slug')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    @else
                                                        <div class="form-group">
                                                            <label
                                                                class="form-label">{{ trans('labels.personlized_link') }}<span
                                                                    class="text-danger"> * </span></label>
                                                            @if (env('Environment') == 'sendbox')
                                                                <span
                                                                    class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                                            @endif
                                                            <div class="input-group">
                                                                <span class="input-group-text">{{ URL::to('/') }}</span>
                                                                <input type="text" class="form-control" id="slug"
                                                                    name="slug" value="{{ $user->slug }}"
                                                                    required>
                                                            </div>
                                                            @error('slug')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    @endif


                                                @endif
                                            @endif
                                            @if (Auth::user()->type == 2)
                                                <div class="form-group col-md-6">
                                                    <label for="country"
                                                        class="form-label">{{ trans('labels.city') }}<span
                                                            class="text-danger"> * </span></label>
                                                    <select name="country" class="form-select" id="country" required>
                                                        <option value="">{{ trans('labels.select') }}</option>
                                                        @foreach ($countries as $country)
                                                            <option value="{{ $country->id }}"
                                                                {{ $country->id == $user->country_id ? 'selected' : '' }}>
                                                                {{ $country->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="city"
                                                        class="form-label">{{ trans('labels.area') }}<span
                                                            class="text-danger">
                                                            * </span></label>
                                                    <select name="city" class="form-select" id="city" required>
                                                        <option value="">{{ trans('labels.select') }}</option>
                                                    </select>
                                                </div>
                                            @endif
                                            <div class="form-group text-end">
                                                <button
                                                    class="btn btn-secondary  {{ Auth::user()->type == 4 ? (helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" name="updateprofile" value="1" @endif>{{ trans('labels.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="changepasssword">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.change_password') }}</h5>
                                    </div>
                                    <form action="{{ URL::to('admin/settings/change-password') }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-sm-12">
                                                <label class="form-label">{{ trans('labels.current_password') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="password" class="form-control" name="current_password"
                                                    value="{{ old('current_password') }}"
                                                    placeholder="{{ trans('labels.current_password') }}" required>
                                                @error('current_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.new_password') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="password" class="form-control" name="new_password"
                                                    value="{{ old('new_password') }}"
                                                    placeholder="{{ trans('labels.new_password') }}" required>
                                                @error('new_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.confirm_password') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="password" class="form-control" name="confirm_password"
                                                    value="{{ old('confirm_password') }}"
                                                    placeholder="{{ trans('labels.confirm_password') }}" required>
                                                @error('confirm_password')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group text-end">
                                                <button
                                                    class="btn btn-secondary  {{ Auth::user()->type == 4 ? (helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $whatsapp_message = 1;
                                } else {
                                    $whatsapp_message = @$checkplan->whatsapp_message;
                                }
                            @endphp
                            @if ($whatsapp_message == 1)
                                @include('admin.whatsapp_message.setting_form')
                            @endif
                        @endif
                    @else
                        @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                            @include('admin.whatsapp_message.setting_form')
                        @endif
                    @endif


                    @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $telegram_message = 1;
                                } else {
                                    $telegram_message = @$checkplan->telegram_message;
                                }
                            @endphp
                            @if ($telegram_message == 1)
                                @include('admin.telegram_message.setting_form')
                            @endif
                        @endif
                    @else
                        @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                            @include('admin.telegram_message.setting_form')
                        @endif
                    @endif

                @endif
                @if (Auth::user()->type == 1)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first()->activated == 1)
                        @include('admin.analytics.setting_form')
                    @endif
                    @if (App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first()->activated == 1)
                        @include('admin.cookie_recaptcha.setting_form')
                    @endif
                @endif
                @include('admin.emailsettings.email_setting')
                @if (Auth::user()->type == 1)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1)
                        @include('admin.sociallogin.social_settings')
                    @endif
                @endif
                @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1)
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $social_login = 1;
                                } else {
                                    $social_login = @$checkplan->social_login;
                                }
                            @endphp
                            @if ($social_login == 1)
                                @include('admin.sociallogin.social_settings')
                            @endif
                        @endif
                    @else
                        @if (App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1)
                            @include('admin.sociallogin.social_settings')
                        @endif
                    @endif
                    @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'pixel')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'pixel')->first()->activated == 1)
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $pixel = 1;
                                } else {
                                    $pixel = @$checkplan->pixel;
                                }
                            @endphp
                            @if ($pixel == 1)
                                @include('admin.pixel.pixel_setting')
                            @endif
                        @endif
                    @else
                        @if (App\Models\SystemAddons::where('unique_identifier', 'pixel')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'pixel')->first()->activated == 1)
                            @include('admin.pixel.pixel_setting')
                        @endif
                    @endif
                    @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'shopify')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'shopify')->first()->activated == 1)
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $shopify = 1;
                                } else {
                                    $shopify = @$checkplan->shopify;
                                }
                            @endphp
                            @if ($shopify == 1)
                                @include('admin.shopify.shopify_setting')
                            @endif
                        @endif
                    @else
                        @if (App\Models\SystemAddons::where('unique_identifier', 'shopify')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'shopify')->first()->activated == 1)
                            @include('admin.shopify.shopify_setting')
                        @endif
                    @endif
                    <div id="delete_profile">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="text-uppercase">{{ trans('labels.delete_profile') }}</h5>
                                        </div>
                                        <div class="row">
                                            <p class="form-group">{{ trans('labels.before_delete_msg') }}
                                            </p>
                                            <div class="form-group col-sm-6">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        name="delete_account" id="delete_account" required>
                                                    <label class="form-check-label fw-bolder" for="delete_account">
                                                        {{ trans('labels.are_you_sure_delete_account') }}
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit"  onclick="deleteaccount('{{ URL::to('admin/deleteaccount-' . $vendor_id) }}')" @endif
                                                class="btn btn-secondary  {{ Auth::user()->type == 4 ? (helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">{{ trans('labels.save') }}</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    {{-- EDIT THEME IMAGE MODAL --}}
    <div class="modal modal-fade-transform" id="editModal" tabindex="-1" aria-labelledby="editModallable"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModallable">{{ trans('labels.image') }}<span class="text-danger"> *
                        </span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action=" {{ URL::to('admin/plan/updateimage') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="image_id" name="image_id">
                        <input type="file" name="theme_image" class="form-control" id="">
                        @error('theme_image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">{{ trans('labels.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var cityurl = "{{ URL::to('admin/getcity') }}";
        var select = "{{ trans('labels.select') }}";
        var cityid = "{{ Auth::user()->city_id != null ? Auth::user()->city_id : '0' }}";
        var requiredmsg = "{{ trans('messages.checkbox_delete_account') }}";
        var langurl = "{{ URL::to('admin/settings/getlanguage') }}";
        $(document).ready(function() {
            $('#recaptcha_version').on('change', function() {
                var recaptcha_version = $(this).val();
                if (recaptcha_version == 'v3') {
                    $("#score_threshold").show();
                } else {
                    $("#score_threshold").hide();
                }
            });
        });
    </script>
    <script>
        function deleteaccount(nexturl) {
            var deleted = document.getElementById("delete_account").checked;
            if (deleted == true) {
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success mx-1',
                        cancelButton: 'btn btn-danger mx-1'
                    },
                    buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                    title: are_you_sure,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: yes,
                    cancelButtonText: no,
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#preloader').show();
                        location.href = nexturl;
                    } else {
                        result.dismiss === Swal.DismissReason.cancel
                    }
                })
            } else {
                toastr.error(requiredmsg);
            }
        }
    </script>

    <script src="{{ url('storage/app/public/admin-assets/js/user.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/settings.js') }}"></script>
@endsection
