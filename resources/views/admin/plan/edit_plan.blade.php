@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/plan') }}">{{ trans('labels.pricing_plans') }}</a></li>
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.edit') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/plan/update_plan-' . $editplan->id) }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="plan_name" value="{{ $editplan->name }}"
                                    placeholder="{{ trans('labels.name') }}" required>
                                @error('plan_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label">{{ trans('labels.amount') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control numbers_only" name="plan_price"
                                    value="{{ $editplan->price }}" placeholder="{{ trans('labels.amount') }}" required>
                                @error('plan_price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="col-sm-3 form-group">
                                <label class="form-label">{{ trans('labels.tax') }}</label>
                                    <select name="plan_tax[]"  class="form-control selectpicker" multiple data-live-search="true">
                                        <option value="">{{trans('labels.select')}}</option>
                                        @if (!empty($gettaxlist))
                                        @foreach ($gettaxlist as $tax)
                                            <option value="{{ $tax->id }}" {{ in_array($tax->id,explode('|',$editplan->tax)) ? 'selected' : ''}}> {{ $tax->name }} </option>
                                        @endforeach
                                    @endif
                                    </select>
                                @error('plan_tax')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.duration_type') }}</label>
                                    <select class="form-select type" name="type">
                                        <option value="1" {{ $editplan->plan_type == '1' ? 'selected' : '' }}>
                                            {{ trans('labels.fixed') }}
                                        </option>
                                        <option value="2" {{ $editplan->plan_type == '2' ? 'selected' : '' }}>
                                            {{ trans('labels.custom') }}
                                        </option>
                                    </select>
                                    @error('type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group 1 selecttype">
                                    <label class="form-label">{{ trans('labels.duration') }}<span class="text-danger"> *
                                        </span></label>
                                    <select class="form-select" name="plan_duration">
                                        <option value="1" {{ $editplan->duration == 1 ? 'selected' : '' }}>
                                            {{ trans('labels.one_month') }}
                                        </option>
                                        <option value="2" {{ $editplan->duration == 2 ? 'selected' : '' }}>
                                            {{ trans('labels.three_month') }}
                                        </option>
                                        <option value="3" {{ $editplan->duration == 3 ? 'selected' : '' }}>
                                            {{ trans('labels.six_month') }}
                                        </option>
                                        <option value="4" {{ $editplan->duration == 4 ? 'selected' : '' }}>
                                            {{ trans('labels.one_year') }}
                                        </option>
                                        <option value="5" {{ $editplan->duration == 5 ? 'selected' : '' }}>
                                            {{ trans('labels.lifetime') }}
                                        </option>
                                    </select>
                                    @error('plan_duration')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group 2 selecttype">
                                    <label class="form-label">{{ trans('labels.days') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <input type="text" class="form-control numbers_only" name="plan_days"
                                        placeholder="{{ trans('labels.days') }}" value="{{ $editplan->days }}">
                                    @error('plan_days')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.service_limit') }}</label>
                                    <select class="form-select service_limit_type" name="service_limit_type">
                                        <option value="1" {{ $editplan->order_limit != '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.limited') }}
                                        </option>
                                        <option value="2" {{ $editplan->order_limit == '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.unlimited') }}
                                        </option>
                                    </select>
                                    @error('service_limit_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group 1 service-limit">
                                    <label class="form-label">{{ trans('labels.max_business') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <input type="number" class="form-control numbers_only" name="plan_max_business"
                                        value="{{ $editplan->order_limit == -1 ? '' : $editplan->order_limit }}"
                                        placeholder="{{ trans('labels.max_business') }}">
                                    @error('plan_max_business')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.booking_limit') }}</label>
                                    <select class="form-select booking_limit_type" name="booking_limit_type">
                                        <option value="1"
                                            {{ $editplan->appointment_limit != '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.limited') }}
                                        </option>
                                        <option value="2"
                                            {{ $editplan->appointment_limit == '-1' ? 'selected' : '' }}>
                                            {{ trans('labels.unlimited') }}
                                        </option>
                                    </select>
                                    @error('booking_limit_type')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group 1 booking-limit">
                                    <label class="form-label">{{ trans('labels.orders_limit') }}<span class="text-danger">
                                            *
                                        </span></label>
                                    <input type="number" class="form-control numbers_only" name="plan_appoinment_limit"
                                        value="{{ $editplan->appointment_limit == -1 ? '' : $editplan->appointment_limit }}"
                                        placeholder="{{ trans('labels.orders_limit') }}">
                                    @error('plan_appoinment_limit')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    @php
                                        $new_array = [];
                                        if ($editplan->features != '') {
                                            $new_array = explode('|', $editplan->features);
                                        }
                                    @endphp
                                    <div class="d-flex justify-content-between align-items-center">
                                        <label class="form-label">{{ trans('labels.features') }}<span
                                                class="text-danger">
                                                * </span></label>
                                        <button type="button" class="btn btn-outline-secondary mx-2 btn-sm"
                                            tooltip="{{ trans('labels.add') }}" id="addfeature">
                                            <i class="fa-regular fa-plus"></i>
                                        </button>
                                    </div>

                                    <div id="repeater">
                                        @foreach ($new_array as $key => $features)
                                            <div class="d-flex my-2" id="deletediv{{ $key }}">
                                                <input type="text" class="form-control" name="plan_features[]"
                                                    value="{{ $features }}"
                                                    placeholder="{{ trans('labels.features') }}" required>
                                                    <button type="button" class="btn btn-danger mx-2 btn-sm"
                                                        tooltip="{{ trans('labels.delete') }}"
                                                        onclick="deletefeature({{ $key }})">
                                                        <i class="fa-regular fa-trash"></i>
                                                    </button>
                                              
                                            </div>
                                        @endforeach
                                        @error('plan_features')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.description') }}</label>
                                    <textarea class="form-control" rows="3" name="plan_description"
                                        placeholder="{{ trans('labels.description') }}">{{ $editplan->description }}</textarea>
                                    @error('plan_description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                               
                                <div class="row">
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'coupon')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'coupon')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="coupons"
                                                    id="coupons" @if ($editplan->coupons == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="coupons">{{ trans('labels.coupons') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('coupons')
                                                    <span class="text-danger" id="coupons">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'custom_domain')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="custom_domain"
                                                    id="custom_domain" @if ($editplan->custom_domain == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="custom_domain">{{ trans('labels.custom_domain') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('custom_domain')
                                                    <span class="text-danger" id="custom_domain">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'google_analytics')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="google_analytics"
                                                    id="google_analytics" @if ($editplan->google_analytics == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="google_analytics">{{ trans('labels.google_analytics') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('google_analytics')
                                                    <span class="text-danger"
                                                        id="google_analytics">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="blogs"
                                                    id="blogs" @if ($editplan->blogs == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="blogs">{{ trans('labels.blogs') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('blogs')
                                                    <span class="text-danger" id="blogs">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'sociallogin')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="social_logins"
                                                    id="social_logins" @if ($editplan->social_logins == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="social_logins">{{ trans('labels.social_logins') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('social_logins')
                                                    <span class="text-danger" id="social_logins">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'notification')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'notification')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="sound_notification"
                                                    id="sound_notification"
                                                    @if ($editplan->sound_notification == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="sound_notification">{{ trans('labels.sound_notification') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('sound_notification')
                                                    <span class="text-danger"
                                                        id="sound_notification">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="whatsapp_message"
                                                    id="whatsapp_message"
                                                    @if ($editplan->whatsapp_message == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="whatsapp_message">{{ trans('labels.whatsapp_message') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('whatsapp_message')
                                                    <span class="text-danger"
                                                        id="whatsapp_message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'telegram_message')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="telegram_message"
                                                    id="telegram_message"
                                                    @if ($editplan->telegram_message == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="telegram_message">{{ trans('labels.telegram_message') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('telegram_message')
                                                    <span class="text-danger"
                                                        id="telegram_message">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'vendor_app')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="vendor_app"
                                                    id="vendor_app" @if ($editplan->vendor_app == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="vendor_app">{{ trans('labels.vendor_app_available') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('vendor_app')
                                                    <span class="text-danger" id="vendor_app">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'user_app')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'user_app')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="customer_app"
                                                    id="customer_app" @if ($editplan->customer_app == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="customer_app">{{ trans('labels.customer_app') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('customer_app')
                                                    <span class="text-danger" id="customer_app">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'pos')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'pos')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="pos"
                                                    id="pos" @if ($editplan->pos == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="pos">{{ trans('labels.pos') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('pos')
                                                    <span class="text-danger" id="pos">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'pwa')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'pwa')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="pwa"
                                                    id="pwa" @if ($editplan->pwa == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="pwa">{{ trans('labels.pwa') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('pwa')
                                                    <span class="text-danger" id="pwa">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'employee')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'employee')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="employee"
                                                    id="employee" @if ($editplan->role_management == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="employee">{{ trans('labels.role_management') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('employee')
                                                    <span class="text-danger" id="employee">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                    @if (App\Models\SystemAddons::where('unique_identifier', 'pixel')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'pixel')->first()->activated == 1)
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input class="form-check-input" type="checkbox" name="pixel"
                                                    id="pixel" @if ($editplan->pixel == '1') checked @endif>
                                                <label class="form-check-label"
                                                    for="pixel">{{ trans('labels.pixel') }}</label>
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                                @error('pixel')
                                                    <span class="text-danger" id="pixel">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.themes') }}
                                        <span class="text-danger"> * </span> </label>
                                    @if (env('Environment') == 'sendbox')
                                        <span class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                    @endif
                                    @php $planthemes = explode('|', $editplan->themes_id); @endphp
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
                                                <input type="checkbox" name="themecheckbox[]"
                                                    id="template{{ $item }}" value="{{ $item }}"
                                                    {{ in_array($item, $planthemes) ? 'checked' : '' }}>
                                                <label for="template{{ $item }}">
                                                    <img src="{{ helper::image_path('theme-' . $item . '.png') }}">
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <a href="{{ URL::to('admin/plan') }}"
                                class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                            <button class="btn btn-secondary"
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
  
@endsection
@section('scripts')
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/plan.js') }}"></script>
@endsection
