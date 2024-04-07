@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/products') }}">{{ trans('labels.products') }}</a></li>
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.edit') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    @if (!empty($getproductdata))
                        <form action="{{ URL::to('admin/products/update-' . $getproductdata->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.category') }} <span class="text-danger">
                                                *
                                            </span></label><br>
                                        <select class="form-control selectpicker" name="category[]" multiple
                                            data-live-search="true" id="editcat_id" required>
                                            <option value="">{{ trans('labels.select') }}</option>
                                            @if (!empty($getcategorylist))
                                                @foreach ($getcategorylist as $catdata)
                                                    <option value="{{ $catdata->id }}" data-id="{{ $catdata->id }}"
                                                        {{ in_array($catdata->id, explode('|', $getproductdata->cat_id)) ? 'selected' : '' }}>
                                                        {{ $catdata->name }} </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('category')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.name') }} <span class="text-danger">
                                                * </span></label>
                                        <input type="text" class="form-control" name="product_name"
                                            value="{{ $getproductdata->item_name }}"
                                            placeholder="{{ trans('labels.name') }}" required>
                                        @error('product_name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.sku') }}</label>
                                        <input type="text" class="form-control" name="product_sku"
                                            value="{{ $getproductdata->sku }}" placeholder="{{ trans('labels.sku') }}"
                                            id="product_sku">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.video_url') }} </label>
                                        <input class="form-control" type="text" name="video_url"
                                            placeholder="{{ trans('labels.video_url') }}"
                                            value="{{ $getproductdata->video_url }}">
                                        @error('video_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.tax') }}</label>
                                        <select name="tax[]" class="form-control selectpicker" multiple
                                            data-live-search="true">
                                            @if (!empty($gettaxlist))
                                                @foreach ($gettaxlist as $tax)
                                                    <option value="{{ $tax->id }}"
                                                        {{ in_array($tax->id, explode('|', $getproductdata->tax)) ? 'selected' : '' }}>
                                                        {{ $tax->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                        @error('tax')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ trans('labels.attachment_name') }} </label>
                                        <input type="text" class="form-control" name="attachmentname" id="attachmentname"
                                            placeholder="{{ trans('labels.attachment_name') }}"
                                            value="{{ $getproductdata->attchment_name }}">
                                        @error('attachment_name')
                                            <span class="text-danger">{{ $message }}</span> <br>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label">{{ trans('labels.attachment_file') }}</label>
                                        <input type="file" class="form-control" name="attachmentfile"
                                            id="attachmentfile">
                                        <p class="text-danger mt-2">{{ trans('labels.attachment') }} : <span
                                                class="text-dark">
                                                <a href="{{ url(env('ASSETPATHURL') . 'admin-assets/images/product/' . $getproductdata->attchment_file) }}"
                                                    target="_blank">{{ $getproductdata->attchment_file }}</a></span></p>
                                        @error('attachment_file')
                                            <span class="text-danger">{{ $message }}</span> <br>
                                        @enderror
                                    </div>
                                </div>
                                @if (App\Models\SystemAddons::where('unique_identifier', 'digital_product')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'digital_product')->first()->activated == 1)
                                    @include('admin.product.digital_product')
                                @endif
                                <div class="col-md-12 form-group">
                                    <label class="form-label">{{ trans('labels.description') }}</label>
                                    <textarea class="form-control" id="ckeditor" name="description">{!! $getproductdata->description !!}</textarea>
                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <div class="form-group">
                                        <label for="has_extras"
                                            class="col-form-label">{{ trans('labels.product_has_extras') }}</label>
                                        <div class="col-md-12">
                                            <div class="form-check-inline">
                                                <input class="form-check-input me-0 has_extras" type="radio"
                                                    name="has_extras" id="extras_no" value="2"
                                                    {{ count($getproductdata['extras']) > 0 ? '' : 'checked' }}>
                                                <label class="form-check-label"
                                                    for="extras_no">{{ trans('labels.no') }}</label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input me-0 has_extras" type="radio"
                                                    name="has_extras" id="extras_yes" value="1"
                                                    {{ count($getproductdata['extras']) > 0 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="extras_yes">{{ trans('labels.yes') }}</label>
                                            </div>
                                            @error('has_extras')
                                                <br><span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                   

                                </div>
                                <div class=" {{ $getproductdata['extras']->count() > 0 ? 'd-block' : 'd-none' }}"
                                    id="extras">
                                    <div class="d-flex align-items-center justify-content-end">
                                        @if (count($globalextras) > 0)
                                            <button class="btn btn-sm btn-outline-info mx-1"
                                                type="button" onclick="global_extras()"><i
                                                    class="fa-sharp fa-solid fa-plus"></i>
                                                {{ trans('labels.add_global_extras') }}</button>
                                            <button class="btn btn-sm btn-outline-info mx-1 float-end" id="add_extras"
                                                type="button"
                                                onclick="more_editextras_fields('{{ trans('labels.name') }}','{{ trans('labels.price') }}')">
                                                {{ trans('labels.add_extras') }} <i class="fa-sharp fa-solid fa-plus"></i>
                                            </button>
                                        @endif
                                    </div>
                                    @forelse ($getproductdata['extras'] as $key => $extras)
                                        <div class="row pe-0">
                                            <input type="hidden" class="form-control" name="extras_id[]"
                                                value="{{ $extras->id }}">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    @if ($key == 0)
                                                        <label class="col-form-label">{{ trans('labels.name') }} <span
                                                                class="text-danger">
                                                                * </span></label>
                                                    @endif
                                                    <input type="text" class="form-control extras_name"
                                                        name="extras_name[]" value="{{ $extras->name }}"
                                                        placeholder="{{ trans('labels.name') }}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    @if ($key == 0)
                                                        <label class="col-form-label">{{ trans('labels.price') }} <span
                                                                class="text-danger">
                                                                * </span></label>
                                                    @endif
                                                    <div class="d-flex">
                                                        <input type="text"
                                                            class="form-control numbers_only extras_price"
                                                            name="extras_price[]" value="{{ $extras->price }}"
                                                            placeholder="{{ trans('labels.price') }}" required>
                                                        <button class="btn btn-danger mx-2" type="button"
                                                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="deletedata('{{ URL::to('admin/products/delete/extras-' . $extras->id) }}')" @endif><i
                                                                class="fa fa-trash" aria-hidden="true"></i> </button>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                        <span class="hiddenextrascount d-none">{{ $key }}</span>
                                    @empty
                                        <div class="row m-0">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{ trans('labels.name') }} <span
                                                            class="text-danger">
                                                            * </span></label>
                                                    <input type="text" class="form-control extras_name"
                                                        name="extras_name[]" placeholder="{{ trans('labels.name') }}">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="col-form-label">{{ trans('labels.price') }} <span
                                                            class="text-danger">
                                                            * </span></label>
                                                    <div class="d-flex">
                                                        <input type="text"
                                                            class="form-control numbers_only extras_price"
                                                            name="extras_price[]"
                                                            placeholder="{{ trans('labels.price') }}">
                                                        <button class="btn btn-outline-info mx-2" type="button"
                                                            onclick="more_editextras_fields('{{ trans('labels.name') }}','{{ trans('labels.price') }}')"><i
                                                                class="fa-sharp fa-solid fa-plus"></i> </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforelse
                                    <div id="global-extras"></div>
                                    <div id="more_editextras_fields"></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="has_variants"
                                            class="col-form-label">{{ trans('labels.product_has_variation') }}</label>
                                        <div class="col-md-12">
                                            <div class="form-check-inline">
                                                <input class="form-check-input me-0 has_variants" type="radio"
                                                    name="has_variants" id="no" value="2" checked
                                                    @if ($getproductdata->has_variants == 2) checked @endif>
                                                <label class="form-check-label"
                                                    for="no">{{ trans('labels.no') }}</label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input me-0 has_variants" type="radio"
                                                    name="has_variants" id="yes" value="1"
                                                    @if ($getproductdata->has_variants == 1) checked @endif>
                                                <label class="form-check-label"
                                                    for="yes">{{ trans('labels.yes') }}</label>
                                            </div>
                                            @error('has_variants')
                                                <br><span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                @if ($getproductdata->has_variants == 1 && count($getproductdata['variation']) > 0)
                                    <div
                                        class="col-md-6 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                        <button class="btn btn-outline-info btn-sm get-variants" type="button"
                                            dataa-url="{{ URL::to('admin/products/variants/edit', $getproductdata->id) }}">
                                            {{ trans('labels.add_variation') }} <i class="fa-sharp fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                @else
                                    <div
                                        class="col-md-6 {{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                        <button class="btn btn-outline-info btn-sm" type="button" id="btn_addvariants"
                                            onclick="addvariantModal()">
                                            {{ trans('labels.add_variants') }} <i class="fa-sharp fa-solid fa-plus"></i>
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="row @if ($getproductdata->has_variants == 1) dn @endif" id="price_row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.original_price') }} <span
                                                class="text-danger">
                                                * </span></label>
                                        <input type="text" class="form-control numbers_only" name="original_price"
                                            value="{{ $getproductdata->has_variants == 1 ? '' : ($getproductdata->item_original_price > 0 ? $getproductdata->item_original_price : 0) }}"
                                            placeholder="{{ trans('labels.original_price') }}" id="original_price">
                                        @error('original_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.selling_price') }} <span
                                                class="text-danger">
                                                * </span></label>
                                        <input type="text" class="form-control numbers_only" name="price"
                                            value="{{ $getproductdata->has_variants == 1 ? '' : $getproductdata->item_price }}"
                                            placeholder="{{ trans('labels.selling_price') }}" id="price">
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 d-flex align-items-center justify-content-between">
                                    <div class="form-group">
                                        <label for="has_stock"
                                            class="form-label">{{ trans('labels.stock_management') }}</label>
                                        <div class="col-md-12">
                                            <div class="form-check-inline">
                                                <input class="form-check-input me-0 has_stock" type="radio"
                                                    name="has_stock" id="stock_no" value="2" checked
                                                    @if ($getproductdata->stock_management == 2) checked @endif>
                                                <label class="form-check-label"
                                                    for="stock_no">{{ trans('labels.no') }}</label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input class="form-check-input me-0 has_stock" type="radio"
                                                    name="has_stock" id="stock_yes" value="1"
                                                    @if ($getproductdata->stock_management == 1) checked @endif>
                                                <label class="form-check-label"
                                                    for="stock_yes">{{ trans('labels.yes') }}</label>
                                            </div>
                                            @error('has_stock')
                                                <br><span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3" id="block_stock_qty">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.stock_qty') }} <span
                                                class="text-danger"> * </span></label>
                                        <input type="text" class="form-control numbers_only" name="qty"
                                            value="{{ $getproductdata->has_variants == 1 ? '' : $getproductdata->qty }}"
                                            placeholder="{{ trans('labels.stock_qty') }}" id="qty">
                                    </div>
                                </div>
                                <div class="col-md-3" id="block_min_order">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.min_order_qty') }}</label>
                                        <input type="text" class="form-control numbers_only" name="min_order"
                                            value="{{ $getproductdata->has_variants == 1 ? '' : ($getproductdata->min_order > 0 ? $getproductdata->min_order : 0) }}"
                                            placeholder="{{ trans('labels.min_order_qty') }}" id="min_order">
                                        @error('min_order')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3" id="block_max_order">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.max_order_qty') }}</label>
                                        <input type="text" class="form-control numbers_only" name="max_order"
                                            value="{{ $getproductdata->has_variants == 1 ? '' : ($getproductdata->max_order > 0 ? $getproductdata->max_order : 0) }}"
                                            placeholder="{{ trans('labels.max_order_qty') }}" id="max_order">
                                        @error('max_order')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-3" id="block_product_low_qty_warning">
                                    <div class="form-group">
                                        <label class="form-label">{{ trans('labels.product_low_qty_warning') }}</label>
                                        <input type="text" class="form-control" name="low_qty"
                                            value="{{ $getproductdata->low_qty }}"
                                            placeholder="{{ trans('labels.product_low_qty_warning') }}">
                                        @error('low_qty')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>


                            </div>
                            <div class="@if ($getproductdata->has_variants == 2) dn @endif" id="variations">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card my-3 {{ count($productVariantArrays) > 0 ? 'd-flex' : 'd-none' }}"
                                            id="variant_card">
                                            <div class="card-header">
                                                <div class="row flex-grow-1">
                                                    <div class="col-md d-flex align-items-center">
                                                        <h5 class="card-header-title">
                                                            {{ trans('labels.product') }} {{ trans('labels.variants') }}
                                                        </h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="row form-group">
                                                    <div class="table-responsive">

                                                        <input type="hidden" id="hiddenVariantOptions"
                                                            name="hiddenVariantOptions"
                                                            value="{{ $getproductdata->variants_json == null ? '{}' : $getproductdata->variants_json }}">
                                                        <div class="variant-table">
                                                            <table class="table" id='tblvariants'>
                                                                <thead>
                                                                    <tr class="text-center">
                                                                        @if (isset($product_variant_names))
                                                                            @foreach ($product_variant_names as $variant)
                                                                                <th><span>{{ ucwords($variant) }}</span>
                                                                                </th>
                                                                            @endforeach
                                                                        @endif
                                                                        <th><span>{{ trans('labels.original_price') }}</span>
                                                                        </th>
                                                                        <th><span>{{ trans('labels.selling_price') }}</span>
                                                                        </th>
                                                                        <th><span>{{ trans('labels.stock_qty') }}</span>
                                                                        </th>
                                                                        <th><span>{{ trans('labels.min_order_qty') }}</span>
                                                                        </th>
                                                                        <th><span>{{ trans('labels.max_order_qty') }}</span>
                                                                        </th>
                                                                        <th><span>{{ trans('labels.product_low_qty_warning') }}</span>
                                                                        </th>
                                                                        <th><span>{{ trans('labels.stock_management') }}</span>
                                                                        </th>
                                                                        <th><span>{{ trans('labels.is_available') }}</span>
                                                                        </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @if (isset($productVariantArrays))
                                                                        @foreach ($productVariantArrays as $counter => $productVariant)
                                                                            <tr
                                                                                data-id="{{ $productVariant['product_variants']['id'] }}">
                                                                                @foreach (explode('|', $productVariant['product_variants']['name']) as $key => $values)
                                                                                    <td>
                                                                                        <input type="text"
                                                                                            name="variants[{{ $productVariant['product_variants']['id'] }}][variants][{{ $key }}][]"
                                                                                            autocomplete="off"
                                                                                            spellcheck="false"
                                                                                            class="form-control"
                                                                                            value="{{ $values }}"
                                                                                            readonly>
                                                                                    </td>
                                                                                @endforeach
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][original_price]"
                                                                                        autocomplete="off"
                                                                                        spellcheck="false"
                                                                                        placeholder="{{ trans('labels.original_price') }}"
                                                                                        class="form-control voriginal_price_{{ $counter }}"
                                                                                        value="{{ $productVariant['product_variants']['original_price'] }}"
                                                                                        id="voriginal_price_{{ $counter }}"
                                                                                        required>
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][price]"
                                                                                        autocomplete="off"
                                                                                        spellcheck="false"
                                                                                        placeholder="{{ trans('labels.selling_price') }}"
                                                                                        class="form-control vprice_{{ $counter }}"
                                                                                        value="{{ $productVariant['product_variants']['price'] }}"
                                                                                        id="vprice_{{ $counter }}"
                                                                                        required>
                                                                                </td>

                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][qty]"
                                                                                        autocomplete="off"
                                                                                        spellcheck="false"
                                                                                        placeholder="{{ trans('labels.stock_qty') }}"
                                                                                        class="form-control vqty_{{ $counter }}"
                                                                                        value="{{ $productVariant['product_variants']['qty'] }}"
                                                                                        id="vqty_{{ $counter }}">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][min_order]"
                                                                                        autocomplete="off"
                                                                                        spellcheck="false"
                                                                                        placeholder="{{ trans('labels.min_order_qty') }}"
                                                                                        class="form-control vmin_order_{{ $counter }}"
                                                                                        value="{{ $productVariant['product_variants']['min_order'] }}"
                                                                                        id="vmin_order_{{ $counter }}">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][max_order]"
                                                                                        autocomplete="off"
                                                                                        spellcheck="false"
                                                                                        placeholder="{{ trans('labels.max_order_qty') }}"
                                                                                        class="form-control vmax_order_{{ $counter }}"
                                                                                        value="{{ $productVariant['product_variants']['max_order'] }}"
                                                                                        id="vmax_order_{{ $counter }}">
                                                                                </td>
                                                                                <td>
                                                                                    <input type="number"
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][low_qty]"
                                                                                        autocomplete="off"
                                                                                        spellcheck="false"
                                                                                        placeholder="{{ trans('labels.product_low_qty_warning') }}"
                                                                                        class="form-control vlow_qty_{{ $counter }}"
                                                                                        value="{{ $productVariant['product_variants']['low_qty'] }}"
                                                                                        id="vlow_qty_{{ $counter }}">
                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <input
                                                                                        class="form-check-input  vstock_management_{{ $counter }}"
                                                                                        type="checkbox" value="1"
                                                                                        {{ $productVariant['product_variants']['stock_management'] == 1 ? 'checked' : '' }}
                                                                                        onclick="edit_stock_management(this.id)"
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][stock_management]"
                                                                                        id="vstockmanagement_{{ $counter }}">

                                                                                </td>
                                                                                <td class="text-center">
                                                                                    <input
                                                                                        class="form-check-input  vis_available_{{ $counter }} product_available"
                                                                                        type="checkbox" value="1"
                                                                                        {{ $productVariant['product_variants']['is_available'] == 1 ? 'checked' : '' }}
                                                                                        name="variants[{{ $productVariant['product_variants']['id'] }}][is_available]"
                                                                                        id="{{ $counter }}">

                                                                                </td>

                                                                            </tr>
                                                                        @endforeach
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group d-flex justify-content-end">
                                <div>
                                    <a href="{{ URL::to('admin/products') }}"
                                        class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                    <button
                                        class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_products', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                        @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                </div>
                            </div>
                        </form>
                    @else
                        @include('admin.layout.no_data')
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card border-0 box-shadow p-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                            <h5 class="text-uppercase">{{ trans('labels.product_images') }}</h5>
                            <a href="javascript:void(0)" onclick="addimage('{{ $getproductdata->id }}')"
                                class="btn btn-secondary">
                                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add_new') }}
                            </a>
                        </div>

                        @foreach ($getproductdata['multi_image'] as $key => $productimage)
                            <div class="col-2">
                                <div class="card-dec h-100 w-100">
                                    <img src="{{ helper::image_path($productimage->image) }}"
                                        class="img-fluid product-image rounded-3 h-75">
                                    <div class="text-center mt-2">
                                        <a href="javascript:void(0)" class="btn btn-outline-info btn-sm"
                                            onclick="imageview('{{ $productimage->id }}','{{ $productimage->image }}')"><i
                                                class="fa-regular fa-pen-to-square"></i></a>
                                        <a href="javascript:void(0)"
                                            onclick="statusupdate('{{ URL::to('admin/products/delete_image-' . $productimage->id . '/' . $productimage->item_id) }}')"
                                            class="btn btn-outline-danger btn-sm @if ($getproductdata['multi_image']->count() == 1) d-none @else '' @endif"><i
                                                class="fa-regular fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>


    @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
            App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
        @if (helper::appdata($vendor_id)->checkout_login_required == 1)
            <div class="card border-0 mt-3 box-shadow">
                <div class="card-body">
                    <h5 class="text-uppercase">{{ trans('labels.product_reviews') }}</h5>
                    <div class="table-responsive">
                        <table
                            class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                            <thead>
                                <tr class="text-uppercase fw-500">
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.image') }}</td>
                                    <td>{{ trans('labels.name') }}</td>
                                    <td>{{ trans('labels.description') }}</td>
                                    <td>{{ trans('labels.ratting') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($productreview as $item)
                                    <tr class="fs-7 row1" id="dataid{{ $item->id }}"
                                        data-id="{{ $item->id }}">
                                        <td>@php
                                            echo $i++;
                                        @endphp</td>
                                        <td>
                                            <img src="{{ @helper::image_path($item->image) }}"
                                                class="img-fluid rounded hw-50" alt="">
                                        </td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->description }}</td>
                                        <td>{{ $item->star }} </td>
                                        <td>
                                            <a href="javascript:void(0)"
                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                                                onclick="statusupdate('{{ URL::to('/admin/products/review/delete-' . $item->id) }}')" @endif
                                                class="btn btn-outline-danger btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_products', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                                                <i class="fa-regular fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
    @endif

    {{-- add Modal --}}
    <div class="modal modal-fade-transform" id="addModal" tabindex="-1" aria-labelledby="addModallable"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModallable">{{ trans('labels.image') }} <span class="text-danger"> *
                        </span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action=" {{ URL::to('admin/products/add_image') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="product_id" name="product_id">
                        <input type="file" name="image[]" class="form-control" multiple>
                        @error('image')
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
    
    {{-- EDIT PRODUCT IMAGE MODAL --}}
    <div class="modal modal-fade-transform" id="editModal" tabindex="-1" aria-labelledby="editModallable"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModallable">{{ trans('labels.image') }} <span class="text-danger">
                            * </span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action=" {{ URL::to('admin/products/updateimage') }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="img_id" name="id">
                        <input type="hidden" id="img_name" name="image">
                        <input type="file" name="product_image" class="form-control" id="">
                        @error('product_image')
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

    <div class="modal modal-fade-transform" id="commonModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-inner lg-dialog" role="document">
            <div class="modal-content">
                <div class="popup-content">
                    <div class="modal-header  popup-header align-items-center">
                        <div class="modal-title">
                            <h6 class="mb-0" id="modelCommanModelLabel">{{ trans('labels.add_variants') }}</h6>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal modal-fade-transform" id="addvariantModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-inner lg-dialog" role="document">
            <div class="modal-content">
                <div class="popup-content">
                    <div class="modal-header  popup-header align-items-center">
                        <div class="modal-title">
                            <h6 class="mb-0" id="modelCommanModelLabel">{{ trans('labels.add_variants') }}</h6>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST"
                            action="{{ URL::to('admin/products/get-product-variants-possibilities') }}">
                            @csrf
                            <div class="form-group">
                                <label for="variant_name">{{ trans('labels.variant_name') }}</label>
                                <input class="form-control" name="variant_name" type="text" id="variant_name"
                                    placeholder="{{ 'Variant Name, i.e Size, Color etc' }}">
                            </div>
                            <div class="form-group">
                                <label for="variant_options">{{ trans('labels.variant_options') }}</label>
                                <input class="form-control" name="variant_options" type="text" id="variant_options"
                                    placeholder="{{ 'Variant Options separated by|pipe symbol, i.e Black|Blue|Red' }}">
                            </div>
                            <div class="form-group col-12 d-flex justify-content-end form-label">
                                <input type="button" value="{{ trans('labels.cancel') }}"
                                    class="btn btn-danger btn-light" data-bs-dismiss="modal">
                                <input type="button" value="{{ trans('labels.add_variants') }}"
                                    class="btn btn-secondary add-variants ms-2">
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        var extrasurl = "{{ URL::to('admin/editgetextras-' . $getproductdata->id) }}";
        var vendor_id = "{{ $vendor_id }}";
        var placehodername = "{{ trans('labels.name') }}";
        var placeholderprice = "{{ trans('labels.price') }}";
        var page = "edit";
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('ckeditor');

        $(document).on('click', '.get-variants', function(e) {
            $("#commonModal .modal-title").html('{{ __('Add Variants') }}');
            $("#commonModal .modal-dialog").addClass('modal-md');
            $("#commonModal").modal('show');
            var data_url = $(this).attr('dataa-url');

            $.get(data_url, {}, function(data) {
                $('#commonModal .modal-body').html(data);
            });
        });

        $(document).on('click', '.add-variants', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            var variantNameEle = $('#variant_name');
            var variantOptionsEle = $('#variant_options');
            var isValid = true;
            var hiddenVariantOptions = $('#hiddenVariantOptions').val();

            if (variantNameEle.val() == '') {
                variantNameEle.focus();
                isValid = false;
            } else if (variantOptionsEle.val() == '') {
                variantOptionsEle.focus();
                isValid = false;
            }

            if (isValid) {
                $.ajax({
                    url: form.attr('action'),
                    datType: 'json',
                    data: {
                        variant_name: variantNameEle.val(),
                        variant_options: variantOptionsEle.val(),
                        hiddenVariantOptions: hiddenVariantOptions
                    },
                    success: function(data) {
                        if (data.message != "" && data.message != null) {
                            toastr.error(data.message);
                        }
                        $('#hiddenVariantOptions').val(data.hiddenVariantOptions);
                        $('.variant-table').html(data.varitantHTML);
                        $('#variant_card').removeClass('d-none');
                        $("#commonModal").modal('hide');
                    }
                })
            }
        });
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/product.js') }}"></script>
@endsection
