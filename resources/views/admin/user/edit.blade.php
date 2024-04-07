@extends('admin.layout.default')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>
        <nav aria-label="breadcrumb">

            <ol class="breadcrumb m-0">

                <li class="breadcrumb-item"><a href="{{ URL::to('admin/users') }}">{{ trans('labels.users') }}</a>

                </li>

                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.edit') }}</li>

            </ol>

        </nav>

    </div>

    <div class="row">

        <div class="card border-0 box-shadow">

            <div class="card-body">

                <form action="{{ URL::to('admin/users/update-' . $getuserdata->slug) }}" method="post"
                    enctype="multipart/form-data">

                    @csrf
                    <div class="row">

                        @if (App\Models\SystemAddons::where('unique_identifier', 'digital_product')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'digital_product')->first()->activated == 1)
                            <div class="form-group col-md-6">
                                <label for="store" class="form-label">{{ trans('labels.store_categories') }}<span
                                        class="text-danger">
                                        * </span></label>
                                <select name="store" class="form-select" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            {{ $store->id == $getuserdata->store_id ? 'selected' : '' }}>
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('store')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="product_type" class="form-label">{{ trans('labels.product_type') }}<span
                                        class="text-danger">
                                        * </span></label>
                                <select name="product_type" class="form-select" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    <option value="1"
                                        {{ helper::appdata($getuserdata->id)->product_type == 1 ? 'selected' : '' }}>
                                        {{ trans('labels.physical') }}
                                    </option>
                                    <option value="2"
                                        {{ helper::appdata($getuserdata->id)->product_type == 2 ? 'selected' : '' }}>
                                        {{ trans('labels.digital') }}
                                    </option>
                                </select>
                                @error('product_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @else
                            <div class="form-group col-md-12">
                                <label for="store" class="form-label">{{ trans('labels.store_categories') }}<span
                                        class="text-danger">
                                        * </span></label>
                                <select name="store" class="form-select" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($stores as $store)
                                        <option value="{{ $store->id }}"
                                            {{ $store->id == $getuserdata->store_id ? 'selected' : '' }}>
                                            {{ $store->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('store')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="col-sm-6 form-group">
                            <input type="hidden" value="{{ $getuserdata->id }}" name="id">
                            <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                </span></label>
                            <input type="text" class="form-control" name="name" value="{{ $getuserdata->name }}" id="name"
                                placeholder="{{ trans('labels.name') }}" required>
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label">{{ trans('labels.email') }}<span class="text-danger"> *
                                </span></label>
                            <input type="email" class="form-control" name="email" value="{{ $getuserdata->email }}"
                                placeholder="{{ trans('labels.email') }}" required>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="col-sm-6 form-group">
                            <div class="form-group">
                                <label class="form-label">{{ trans('labels.mobile') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control mobile-number" name="mobile"
                                    value="{{ $getuserdata->mobile }}" placeholder="{{ trans('labels.mobile') }}"
                                    required>
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-6 form-group">
                            <label class="form-label">{{ trans('labels.image') }}</label>
                            <input type="file" class="form-control" name="profile">
                            <img class="rounded-circle mt-2" src="{{ helper::image_path($getuserdata->image) }}"
                                alt="" width="70" height="70">

                        </div>
                      
                        <div class="form-group col-md-6">
                            <label for="country" class="form-label">{{ trans('labels.city') }}<span class="text-danger">
                                    *
                                </span></label>
                            <select name="country" class="form-select" id="country" required>
                                <option value="">{{ trans('labels.select') }}</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}"
                                        {{ $country->id == $getuserdata->country_id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="city" class="form-label">{{ trans('labels.area') }}<span
                                    class="text-danger">
                                    * </span></label>
                            <select name="city" class="form-select" id="city" required>
                                <option value="">{{ trans('labels.select') }}</option>
                            </select>
                        </div>
                        @if (App\Models\SystemAddons::where('unique_identifier', 'unique_slug')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'unique_slug')->first()->activated == 1)
                    <div class="form-group">
                        <label for="basic-url" class="form-label">{{ trans('labels.personlized_link') }}<span
                                class="text-danger"> * </span></label>
                        @if (env('Environment') == 'sendbox')
                            <span class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                        @endif
                        <div class="input-group ">
                            <span
                                class="input-group-text col-5 col-lg-auto overflow-x-auto">{{ URL::to('/') }}/</span>
                            <input type="text" class="form-control" id="slug" name="slug"
                                value="{{ $getuserdata->slug }}" required>
                        </div>
                        @error('slug')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                @endif
                        <div class=" col-sm-6">
                            @if (App\Models\SystemAddons::where('unique_identifier', 'allow_without_subscription')->first() != null &&
                                    App\Models\SystemAddons::where('unique_identifier', 'allow_without_subscription')->first()->activated == 1)
                                <div class="form-group" id="plan">
                                    @php
                                        $plan = helper::plandetail(@$getuserdata->plan_id);
                                    @endphp
                                    <div class="d-flex">
                                        <input class="form-check-input mx-1" type="checkbox" name="plan_checkbox"
                                            id="plan_checkbox">
                                        <div>
                                            <label for="plan_checkbox"
                                                class="form-label">{{ trans('labels.assign_plan') }}</label>&nbsp;<span>({{ trans('labels.current_plan') }}&nbsp;:&nbsp;</span>
                                            <span class="fw-500"> {{ !empty($plan) ? $plan->name : '-' }})</span>
                                            @if (env('Environment') == 'sendbox')
                                                <span
                                                    class="badge badge bg-danger ms-2 mb-0">{{ trans('labels.addon') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <select name="plan" id="selectplan" class="form-select" disabled required>
                                        <option value="">{{ trans('labels.select') }}</option>
                                        @foreach ($getplanlist as $plan)
                                            <option value="{{ $plan->id }}">
                                                {{ $plan->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="form-group d-flex">
                                    <input class="form-check-input mx-1" type="checkbox" name="allow_store_subscription"
                                        id="allow_store_subscription" @if ($getuserdata->allow_without_subscription == '1') checked @endif>
                                    <div>
                                        <label class="form-check-label"
                                            for="allow_store_subscription">{{ trans('labels.allow_store_without_subscription') }}
                                        </label>
                                        @if (env('Environment') == 'sendbox')
                                            <span class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <input class="form-check-input mx-1" type="checkbox" name="show_landing_page"
                                    id="show_landing_page" @if ($getuserdata->available_on_landing == '1') checked @endif><label
                                    class="form-check-label"
                                    for="show_landing_page">{{ trans('labels.display_store_on_landing') }}</label>

                            </div>
                        </div>
                        <div class="form-group text-end">
                            <a href="{{ URL::to('admin/users') }}"
                                class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-secondary ">{{ trans('labels.save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
@section('scripts')
    <script>
        @if (count($errors) > 0)
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif
    </script>
    <script>
        var cityurl = "{{ URL::to('admin/getcity') }}";
        var select = "{{ trans('labels.select') }}";
        var cityid = "{{ $getuserdata->city_id }}";
        $('#name').on('blur', function() {
          "use strict";
          $('#slug').val($('#name').val().split(" ").join("-").toLowerCase());
        });
    </script>
    <script src="{{ url('storage/app/public/admin-assets/js/user.js') }}"></script>
@endsection
