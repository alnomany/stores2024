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
        {{ trans('labels.basic_settings') }}</h5>
    <div class="row settings mt-3">
        <div class="col-xl-3 mb-3">
            <div class="card-sticky-top border-0">
                <ul class="list-group list-options">
                    <a href="#theme_settings" data-tab="theme_settings"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                        aria-current="true">{{ trans('labels.theme_settings') }} <i class="fa-regular fa-angle-right"></i></a>

                    <a href="#contact_settings" data-tab="contact_settings"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.contact_settings') }} <i
                            class="fa-regular fa-angle-right"></i></a>
                    <a href="#seo" data-tab="seo"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.seo') }} <i class="fa-regular fa-angle-right"></i></a>
                    @if (Auth::user()->type == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first()->activated == 1)
                            <a href="#app_section" data-tab="app_section"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">{{ trans('labels.app_section') }} <i
                                    class="fa-regular fa-angle-right"></i></a>
                        @endif
                        <a href="#fun_fact" data-tab="fun_fact"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.fun_fact') }} <i class="fa-regular fa-angle-right"></i></a>
                    @endif
                    @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if (@$user->allow_without_subscription == 1) {
                                        $user_app = 1;
                                    } else {
                                        $user_app = @$checkplan->customer_app;
                                    }
                                @endphp
                                @if ($user_app == 1)
                                    <a href="#app_section" data-tab="app_section"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.app_section') }} <i
                                            class="fa-regular fa-angle-right"></i></a>
                                @endif
                            @endif
                        @else
                            @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                                <a href="#app_section" data-tab="app_section"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.app_section') }} <i
                                        class="fa-regular fa-angle-right"></i></a>
                            @endif
                        @endif
                        <a href="#footer_features" data-tab="footer_features"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.footer_features') }} <i
                                class="fa-regular fa-angle-right"></i></a>

                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
                                @php
                                    $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                        ->orderByDesc('id')
                                        ->first();

                                    if (@$user->allow_without_subscription == 1) {
                                        $pwa = 1;
                                    } else {
                                        $pwa = @$checkplan->pwa;
                                    }
                                @endphp
                                @if ($pwa == 1)
                                    <a href="#pwa" data-tab="pwa"
                                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                        aria-current="true">{{ trans('labels.pwa') }}@if (env('Environment') == 'sendbox')
                                            <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                        @endif
                                        <i class="fa-regular fa-angle-right"></i>
                                    </a>
                                @endif
                            @endif
                        @else
                            @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
                                <a href="#pwa" data-tab="pwa"
                                    class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                    aria-current="true">{{ trans('labels.pwa') }}@if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                                    @endif
                                    <i class="fa-regular fa-angle-right"></i>
                                </a>
                            @endif
                        @endif

                    @endif
                    <a href="#social_links" data-tab="social_links"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">{{ trans('labels.social_links') }} <i
                                class="fa-regular fa-angle-right"></i></a>
                    <a href="#other" data-tab="other"
                        class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                        aria-current="true">{{ trans('labels.other') }}@if (env('Environment') == 'sendbox')
                            <span class="badge badge bg-danger me-5">{{ trans('labels.addon') }}</span>
                        @endif
                        <i class="fa-regular fa-angle-right"></i>
                    </a>
                </ul>
            </div>
        </div>
        <div class="col-xl-9">
            <div id="settingmenuContent">
                <div id="theme_settings">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.theme_settings') }}</h5>
                                    </div>
                                    <form action="{{ URL::to('admin/theme_settings/update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.website_title') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="website_title"
                                                    value="{{ @$settingdata->website_title }}"
                                                    placeholder="{{ trans('labels.website_title') }}">
                                                @error('website_title')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.primary_color') }}</label>
                                                <input type="color" class="form-control form-control-color w-100 border-0"
                                                    name="landing_primary_color" value="{{ $settingdata->primary_color }}">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.secondary_color') }}</label>
                                                <input type="color" class="form-control form-control-color w-100 border-0"
                                                    name="landing_secondary_color"
                                                    value="{{ $settingdata->secondary_color }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.copyright') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="copyright"
                                                    value="{{ @$settingdata->copyright }}"
                                                    placeholder="{{ trans('labels.copyright') }}">
                                                @error('copyright')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.logo') }}</label>
                                                <input type="file" class="form-control" name="logo">
                                              
                                                <img class="img-fluid rounded hw-70 mt-1 object-fit-contain"
                                                    src="{{ helper::image_path(@$settingdata->logo) }}" alt="">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="form-label">{{ trans('labels.favicon') }}</label>
                                                <input type="file" class="form-control" name="favicon">
                                                
                                                <img class="img-fluid rounded hw-70 mt-1 object-fit-contain"
                                                    src="{{ helper::image_path(@$settingdata->favicon) }}"
                                                    alt="">
                                            </div>
                                            @if (Auth::user()->type == 1)
                                                <div class="form-group col-sm-6">
                                                    <label class="form-label"
                                                        for="">{{ trans('labels.landing_page') }}
                                                    </label>
                                                    <input id="landing-switch" type="checkbox" class="checkbox-switch"
                                                        name="landing" value="1"
                                                        {{ $settingdata->landing_page == 1 ? 'checked' : '' }}>
                                                    <label for="landing-switch" class="switch">
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
                                                @php
                                                    if (Auth::user()->allow_without_subscription == 1) {
                                                        if (App\Models\SystemAddons::where('unique_identifier', 'template')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'template')->first()->activated == 1) {
                                                            $themes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                                                        } else {
                                                            $themes = [1];
                                                        }
                                                    } else {
                                                        if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1) {
                                                            if (empty($theme)) {
                                                                $themes = [1];
                                                            } else {
                                                                $themes = explode('|', @$theme->themes_id);
                                                            }
                                                        } elseif (App\Models\SystemAddons::where('unique_identifier', 'template')->first() != null && App\Models\SystemAddons::where('unique_identifier', 'template')->first()->activated == 1) {
                                                            $themes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
                                                        } else {
                                                            $themes = [1];
                                                        }
                                                    }
                                                @endphp
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ trans('labels.theme') }}
                                                            <span class="text-danger"> * </span> </label>
                                                        @if (env('Environment') == 'sendbox')
                                                            <span
                                                                class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                        @endif
                                                        <ul class="theme-selection">
                                                            @foreach ($themes as $item)
                                                                <li>
                                                                    <input type="radio" name="template"
                                                                        id="template{{ $item }}"
                                                                        value="{{ $item }}"
                                                                        {{ @$settingdata->template == $item ? 'checked' : '' }}>
                                                                    <label for="template{{ $item }}">
                                                                        <img
                                                                            src="{{ helper::image_path('theme-' . $item . '.png') }}">
                                                                    </label>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="form-group text-end">
                                            <button
                                                class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="contact_settings">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.contact_settings') }}</h5>
                                    </div>
                                    <form action="{{ URL::to('admin/contact_settings/update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-6">
                                                <label class="form-label">{{ trans('labels.email') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="email" class="form-control" name="landing_email"
                                                    value="{{ @$settingdata->email }}"
                                                    placeholder="{{ trans('labels.email') }}" required>
                                                @error('landing_email')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-6">
                                                <label class="form-label">{{ trans('labels.mobile') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control mobile-number"
                                                    name="landing_mobile" value="{{ @$settingdata->contact }}"
                                                    placeholder="{{ trans('labels.mobile') }}" required>
                                                @error('contact_mobile')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>


                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.address') }}<span
                                                        class="text-danger"> * </span></label>
                                                <textarea class="form-control" name="landing_address" rows="3" placeholder="{{ trans('labels.address') }}">{{ @$settingdata->address }}</textarea>
                                                @error('address')
                                                    <small class="text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                            @if (Auth::user()->type == 1)
                                                @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                                        App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="form-label">{{ trans('labels.contact') }}</label>
                                                            <input type="text" class="form-control numbers_only"
                                                                name="contact"
                                                                value="{{ @$settingdata->whatsapp_number }}"
                                                                placeholder="{{ trans('labels.contact') }}" >
                                                            @error('contact')
                                                                <small class="text-danger">{{ $message }}</small>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="form-group text-end">
                                            <button
                                                class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="seo">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="card border-0 box-shadow">
                                <div class="card-body pb-0">
                                    <div class="d-flex align-items-center mb-3">
                                        <h5 class="text-uppercase">{{ trans('labels.seo') }}</h5>
                                    </div>
                                    <form action="{{ URL::to('admin/seo/update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.meta_title') }}<span
                                                        class="text-danger"> * </span></label>
                                                <input type="text" class="form-control" name="meta_title"
                                                    value="{{ @$settingdata->meta_title }}"
                                                    placeholder="{{ trans('labels.meta_title') }}" required>
                                                @error('meta_title')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.meta_description') }}<span
                                                        class="text-danger"> * </span></label>
                                                <textarea class="form-control" name="meta_description" rows="3"
                                                    placeholder="{{ trans('labels.meta_description') }}" required>{{ @$settingdata->meta_description }}</textarea>
                                                @error('meta_description')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ trans('labels.og_image') }} </label>
                                                <input type="file" class="form-control" name="og_image">
                                               
                                                <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                    src="{{ helper::image_Path(@$settingdata->og_image) }}"
                                                    alt="">
                                            </div>
                                            <div class="form-group text-end">
                                                <button
                                                    class="btn btn-secondary  {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (Auth::user()->type == 1)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first()->activated == 1)
                        @include('admin.mobile_app.app_section')
                    @endif
                    <div id="fun_fact">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-body pb-0">
                                            <div class="d-flex align-items-center mb-3">
                                                <h5 class="text-uppercase">{{ trans('labels.fun_fact') }}</h5>
                                            </div>
                                            <form action="{{ URL::to('admin/fun_fact/update') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <label class="col-form-label"
                                                            for="">{{ trans('labels.fun_fact') }}
                                                            <span class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i> </span></label>
                                                        @if (count($funfacts) > 0)
                                                            <span class="mx-5"><button
                                                                    class="btn btn-sm btn-outline-info" type="button"
                                                                    onclick="add_funfact('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.sub_title') }}')">
                                                                    <i
                                                                        class="fa-sharp fa-solid fa-plus"></i></button></span>
                                                        @endif
                                                    </div>
                                                    @forelse ($funfacts as $key => $facts)
                                                        <div class="row">
                                                            <input type="hidden" name="edit_icon_key[]"
                                                                value="{{ $facts->id }}">
                                                            <div class="col-md-3 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                                        onkeyup="show_funfact_icon(this)"
                                                                        name="edi_funfact_icon[{{ $facts->id }}]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        value="{{ $facts->icon }}" required>
                                                                    <p
                                                                        class="input-group-text {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                                        {!! $facts->icon !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_funfact_title[{{ $facts->id }}]"
                                                                    placeholder="{{ trans('labels.title') }}"
                                                                    value="{{ $facts->title }}" required>
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_funfact_subtitle[{{ $facts->id }}]"
                                                                    placeholder="{{ trans('labels.sub_title') }}"
                                                                    value="{{ $facts->description }}" required>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <button class="btn btn-danger" type="button"
                                                                    tooltip="{{ trans('labels.delete') }}"
                                                                    onclick="statusupdate('{{ URL::to('admin/fun_fact/delete-' . $facts->id) }}')">
                                                                    <i class="fa fa-trash"></i> </button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="row">
                                                            <div class="col-md-3 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        onkeyup="show_funfact_icon(this)"
                                                                        name="funfact_icon[]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        required>
                                                                    <p class="input-group-text"></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                <input type="text"
                                                                    class="form-control feature_required"
                                                                    name="funfact_title[]"
                                                                    placeholder="{{ trans('labels.title') }}" required>
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <input type="text"
                                                                    class="form-control feature_required"
                                                                    name="funfact_subtitle[]"
                                                                    placeholder="{{ trans('labels.sub_title') }}"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <button class="btn btn-info" type="button"
                                                                    tooltip="{{ trans('labels.add') }}"
                                                                    onclick="add_funfact('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.sub_title') }}')">
                                                                    <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                    <span class="extra_footer_features"></span>
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
                    </div>
                @endif
                @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $user_app = 1;
                                } else {
                                    $user_app = @$checkplan->customer_app;
                                }
                            @endphp
                            @if ($user_app == 1)
                                @include('admin.mobile_app.app_section')
                            @endif
                        @endif
                    @else
                        @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                            @include('admin.mobile_app.app_section')
                        @endif
                    @endif
                    <div id="footer_features">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-body  pb-0">
                                            <div class="d-flex align-items-center mb-3">
                                                <h5 class="text-uppercase">{{ trans('labels.footer_features') }}</h5>
                                            </div>
                                            <form action="{{ URL::to('admin/footer_features/update') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="row justify-content-between">
                                                        <label class="col-auto col-form-label"
                                                            for="">{{ trans('labels.footer_features') }}
                                                            <span class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i> </span></label>
                                                        @if (count($getfooterfeatures) > 0)
                                                            <span class="col-auto"><button
                                                                    class="btn btn-sm btn-outline-info" type="button"
                                                                    onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                                    {{ trans('labels.add_new') }}
                                                                    {{ trans('labels.footer_features') }} <i
                                                                        class="fa-sharp fa-solid fa-plus"></i></button></span>
                                                        @endif
                                                    </div>
                                                    @forelse ($getfooterfeatures as $key => $features)
                                                        <div class="row">
                                                            <input type="hidden" name="edit_icon_key[]"
                                                                value="{{ $features->id }}">
                                                            <div class="col-md-3 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                                        onkeyup="show_feature_icon(this)"
                                                                        name="edi_feature_icon[{{ $features->id }}]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        value="{{ $features->icon }}" required>
                                                                    <p
                                                                        class="input-group-text {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                                        {!! $features->icon !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_feature_title[{{ $features->id }}]"
                                                                    placeholder="{{ trans('labels.title') }}"
                                                                    value="{{ $features->title }}" required>
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_feature_description[{{ $features->id }}]"
                                                                    placeholder="{{ trans('labels.description') }}"
                                                                    value="{{ $features->description }}" required>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <button class="btn btn-danger" type="button"
                                                                    tooltip="{{ trans('labels.delete') }}"
                                                                    onclick="statusupdate('{{ URL::to('admin/settings/delete-feature-' . $features->id) }}')">
                                                                    <i class="fa fa-trash"></i> </button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="row">
                                                            <div class="col-md-3 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        onkeyup="show_feature_icon(this)"
                                                                        name="feature_icon[]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        required>
                                                                    <p class="input-group-text"></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 form-group">
                                                                <input type="text"
                                                                    class="form-control feature_required"
                                                                    name="feature_title[]"
                                                                    placeholder="{{ trans('labels.title') }}" required>
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                <input type="text"
                                                                    class="form-control feature_required"
                                                                    name="feature_description[]"
                                                                    placeholder="{{ trans('labels.description') }}"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-1 form-group">
                                                                <button class="btn btn-info" type="button"
                                                                    tooltip="{{ trans('labels.add') }}"
                                                                    onclick="add_features('{{ trans('labels.icon') }}','{{ trans('labels.title') }}','{{ trans('labels.description') }}')">
                                                                    <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                    <span class="extra_footer_features"></span>
                                                    <div class="form-group text-end">
                                                        <button
                                                            class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  
                    @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
                            @php
                                $checkplan = App\Models\Transaction::where('vendor_id', $vendor_id)
                                    ->orderByDesc('id')
                                    ->first();

                                if (@$user->allow_without_subscription == 1) {
                                    $pwa = 1;
                                } else {
                                    $pwa = @$checkplan->pwa;
                                }
                            @endphp
                            @if ($pwa == 1)
                                @include('admin.pwa.pwa_settings')
                            @endif
                        @endif
                    @else
                        @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
                            @include('admin.pwa.pwa_settings')
                        @endif
                    @endif
                @endif
                <div id="social_links">
                        <div class="row mb-5">
                            <div class="col-12">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-body  pb-0">
                                            <div class="d-flex align-items-center mb-3">
                                                <h5 class="text-uppercase">{{ trans('labels.social_links') }}</h5>
                                            </div>
                                            <form action="{{ URL::to('admin/social_links/update') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="row">
                                                    <div class="row justify-content-between">
                                                        <label class="col-auto col-form-label"
                                                            for="">{{ trans('labels.social_links') }}
                                                            <span class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i> </span></label>
                                                        @if (count($getsociallinks) > 0)
                                                            <span class="col-auto"><button
                                                                    class="btn btn-sm btn-outline-info" type="button"
                                                                    onclick="add_social_links('{{ trans('labels.icon') }}','{{ trans('labels.link') }}')">
                                                                    {{ trans('labels.add_new') }}
                                                                    {{ trans('labels.social_links') }} <i
                                                                        class="fa-sharp fa-solid fa-plus"></i></button></span>
                                                        @endif
                                                    </div>
                                                    @forelse ($getsociallinks as $key => $links)
                                                        <div class="row">
                                                            <input type="hidden" name="edit_icon_key[]"
                                                                value="{{ $links->id }}">
                                                            <div class="col-md-6 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control soaciallink_required  {{ session()->get('direction') == 2 ? 'input-group-rtl' : '' }}"
                                                                        onkeyup="show_feature_icon(this)"
                                                                        name="edi_sociallink_icon[{{ $links->id }}]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        value="{{ $links->icon }}" required>
                                                                    <p
                                                                        class="input-group-text {{ session()->get('direction') == 2 ? 'input-group-icon-rtl' : '' }}">
                                                                        {!! $links->icon !!}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 d-flex align-items-center form-group">
                                                                <input type="text" class="form-control"
                                                                    name="edi_sociallink_link[{{ $links->id }}]"
                                                                    placeholder="{{ trans('labels.link') }}"
                                                                    value="{{ $links->link }}" required>
                                                                <button class="btn btn-danger mx-2" type="button"
                                                                    tooltip="{{ trans('labels.delete') }}"
                                                                    onclick="statusupdate('{{ URL::to('admin/settings/delete-sociallinks-' . $links->id) }}')">
                                                                    <i class="fa fa-trash"></i> </button>
                                                            </div>
                                                        </div>
                                                    @empty
                                                        <div class="row">
                                                            <div class="col-md-6 form-group">
                                                                <div class="input-group">
                                                                    <input type="text"
                                                                        class="form-control soaciallink_required"
                                                                        onkeyup="show_feature_icon(this)"
                                                                        name="social_icon[]"
                                                                        placeholder="{{ trans('labels.icon') }}"
                                                                        required>
                                                                    <p class="input-group-text"></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 d-flex align-items-center form-group">
                                                                <input type="text"
                                                                    class="form-control soaciallink_required"
                                                                    name="social_link[]"
                                                                    placeholder="{{ trans('labels.link') }}" required>
                                                                <button class="btn btn-info mx-2" type="button"
                                                                    tooltip="{{ trans('labels.add') }}"
                                                                    onclick="add_social_links('{{ trans('labels.icon') }}','{{ trans('labels.link') }}')">
                                                                    <i class="fa-sharp fa-solid fa-plus"></i> </button>
                                                            </div>
                                                        </div>
                                                    @endforelse
                                                    <span class="extra_social_links"></span>
                                                    <div class="form-group text-end">
                                                        <button
                                                            class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                            @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <div id="other">
                    <div class="row mb-5">
                        <div class="col-12">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-body pb-0">
                                        <div class="d-flex align-items-center mb-3">
                                            <h5 class="text-uppercase">{{ trans('labels.other') }}</h5>
                                        </div>
                                        <form action="{{ URL::to('admin/other/update') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                @if (Auth::user()->type == 2 || Auth::user()->type == 4)
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.landing_page_cover_image') }}
                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="landin_page_cover_image">
                                                        
                                                        <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                            src="{{ helper::image_path($settingdata->cover_image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.subscribe_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="subscribe_image">
                                                        
                                                            
                                                        <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                            src="{{ helper::image_path(@$settingdata->subscribe_image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.order_detail_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="order_detail_image">
                                                        
                                                        <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                            src="{{ helper::image_path(@$settingdata->order_detail_image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="form-label"
                                                            for="">{{ trans('labels.product_ratting_switch') }}
                                                        </label>
                                                        <div class="text-center">
                                                            <input id="product_ratting_switch" type="checkbox"
                                                                class="checkbox-switch" name="product_ratting_switch"
                                                                value="1"
                                                                {{ $settingdata->product_ratting_switch == 1 ? 'checked' : '' }}>
                                                            <label for="product_ratting_switch" class="switch">
                                                                <span
                                                                    class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                        class="switch__circle-inner"></span></span>
                                                                <span
                                                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                <span
                                                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="col-md-3 form-group">
                                                        <label class="form-label"
                                                            for="">{{ trans('labels.online_order') }}
                                                        </label>
                                                        <div class="text-center">
                                                            <input id="online_order_switch" type="checkbox"
                                                                class="checkbox-switch" name="online_order_switch"
                                                                value="1"
                                                                {{ $settingdata->online_order == 1 ? 'checked' : '' }}>
                                                            <label for="online_order_switch" class="switch">
                                                                <span
                                                                    class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                        class="switch__circle-inner"></span></span>
                                                                <span
                                                                    class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                                <span
                                                                    class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                            </label>
                                                        </div>

                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.google_review_url') }}</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="{{ trans('labels.google_review_url') }}"
                                                            name="google_review_url"
                                                            value="{{ $settingdata->google_review }}">
                                                        @error('google_review_url')
                                                            <small class="text-danger">{{ $message }}</small> <br>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.min_order_amount') }}</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="{{ trans('labels.min_order_amount') }}"
                                                            name="min_order_amount"
                                                            value="{{ $settingdata->min_order_amount }}">
                                                        @error('min_order_amount')
                                                            <small class="text-danger">{{ $message }}</small> <br>
                                                        @enderror
                                                    </div>
                                                @endif
                                                @if (Auth::user()->type == 1)
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.landing_home_banner') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="landing_home_banner">
                                                        <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                            src="{{ helper::image_path(@$landingdata->landing_home_banner) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.testimonial_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="testimonial_image">
                                                        <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                            src="{{ helper::image_path(@$landingdata->testimonial_image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.subscribe_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="subscribe_image">
                                                        <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                            src="{{ helper::image_path(@$landingdata->subscribe_image) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="form-group col-sm-6">
                                                        <label
                                                            class="form-label">{{ trans('labels.faq_image') }}</label>
                                                        <input type="file" class="form-control"
                                                            name="faq_image">
                                                        <img class="img-fluid rounded hw-70 mt-1 object-fit-cover"
                                                            src="{{ helper::image_path(@$landingdata->faq_image) }}"
                                                            alt="">
                                                    </div>
                                                @endif
                                                <div class="form-group text-end">
                                                    <button
                                                        class="btn btn-secondary  {{ Auth::user()->type == 4 ? (helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_basic_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ url('storage/app/public/admin-assets/js/user.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/funfact.js') }}"></script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/settings.js') }}"></script>
@endsection
