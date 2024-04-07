@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.add_new') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/users') }}">{{ trans('labels.users') }}</a>
                </li>
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.add') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/register_vendor') }}" method="POST">
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
                                                {{ old('store') == $store->id ? 'selected' : '' }}>{{ $store->name }}
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
                                        <option value="1" {{ old('store') == 1 ? 'selected' : '' }}>
                                            {{ trans('labels.physical') }}</option>
                                        <option value="2" {{ old('store') == 2 ? 'selected' : '' }}>
                                            {{ trans('labels.digital') }}</option>
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
                                                {{ old('store') == $store->id ? 'selected' : '' }}>{{ $store->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('store')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif
                            <div class="form-group col-md-6">
                                <label for="name" class="form-label">{{ trans('labels.name') }}<span
                                        class="text-danger">
                                        * </span></label>
                                <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                    id="name" placeholder="{{ trans('labels.name') }}" required>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="form-label">{{ trans('labels.email') }}<span
                                        class="text-danger"> * </span></label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    id="email" placeholder="{{ trans('labels.email') }}" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="mobile" class="form-label">{{ trans('labels.mobile') }}<span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control mobile-number" name="mobile"
                                    value="{{ old('mobile') }}" id="mobile" placeholder="{{ trans('labels.mobile') }}"
                                    required>
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label for="password" class="form-label">{{ trans('labels.password') }}<span
                                        class="text-danger"> * </span></label>
                                <input type="password" class="form-control" name="password" value="{{ old('password') }}"
                                    id="password" placeholder="{{ trans('labels.password') }}" required>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="country" class="form-label">{{ trans('labels.city') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="country" class="form-select" id="country" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>

                            </div>
                            <div class="form-group col-md-6">
                                <label for="city" class="form-label">{{ trans('labels.area') }}<span
                                        class="text-danger"> * </span></label>
                                <select name="city" class="form-select" id="city" required>
                                    <option value="">{{ trans('labels.select') }}</option>
                                </select>

                            </div>
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
                                        value="{{ old('slug') }}" required>
                                </div>
                                @error('slug')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        @endif
                        <div class="form-group text-end">
                            <a href="{{ URL::to('admin/users') }}"
                                class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                            <button class="btn btn-secondary"
                                @if (env('Environment') == 'sendbox') type="button"
                            onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var cityurl = "{{ URL::to('admin/getcity') }}";
        var select = "{{ trans('labels.select') }}";
        var cityid = '0';
        $('#name').on('blur', function() {
            "use strict";
            $('#slug').val($('#name').val().split(" ").join("-").toLowerCase());
        });
    </script>
    <script src="{{ url(env('ASSETPATHURL') . '/admin-assets/js/user.js') }}"></script>
@endsection
