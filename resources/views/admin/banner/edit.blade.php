@extends('admin.layout.default')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
    if (request()->is('admin/sliders*')) {
        $section = 0;
        $title = trans('labels.sliders');
        $url = URL::to('admin/sliders');
    } elseif (request()->is('admin/banner*')) {
        $section = 1;
        $title = trans('labels.banner');
        $url = URL::to('admin/banner');
    }
@endphp
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/banner') }}">{{ $title }}</a>
                </li>
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.edit') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/banner/update-' . $getbannerdata->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="section" value="{{ $getbannerdata->section }}">
                            <div class="col-sm-6 form-group">
                                <label class="form-label">{{ trans('labels.type') }}</label>
                                <select class="form-select type" name="banner_info">
                                    <option value="0">{{ trans('labels.select') }} </option>
                                    <option value="1" {{ $getbannerdata->type == '1' ? 'selected' : '' }}>
                                        {{ trans('labels.category') }}</option>
                                    <option value="2" {{ $getbannerdata->type == '2' ? 'selected' : '' }}>
                                        {{ trans('labels.product') }}</option>
                                </select>
                              
                            </div>
                            <div class="{{$getbannerdata->section == 0 ?'col-sm-3' : 'col-sm-6'}} form-group 1 gravity">
                                <label class="form-label">{{ trans('labels.category') }}<span class="text-danger">
                                        *
                                    </span></label>
                                <select class="form-select" name="category" id="category">
                                    <option value="" selected>{{ trans('labels.select') }} </option>
                                    @foreach ($getcategorylist as $item)
                                        <option
                                            value="{{ $item->id }}"{{ $item->id == $getbannerdata->category_id ? 'selected' : '' }}>
                                            {{ $item->name }} </option>
                                    @endforeach
                                </select>
                              
                            </div>
                            <div class="{{$getbannerdata->section == 0 ?'col-sm-3' : 'col-sm-6'}} form-group 2 gravity">
                                <label class="form-label">{{ trans('labels.product') }}<span class="text-danger"> *
                                    </span></label>
                                <select class="form-select" name="product" id="product">
                                    <option value="" selected>{{ trans('labels.select') }} </option>
                                    @foreach ($getproductslist as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $getbannerdata->product_id ? 'selected' : '' }}>
                                            {{ $item->item_name }}</option>
                                    @endforeach
                                </select>
                              
                            </div>
                            @if ($getbannerdata->section == 0)
                                <div class="col-sm-3 form-group link_text">
                                    <label class="form-label">{{ trans('labels.link_text') }} <span class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control" name="link_text" id="link_text"
                                        placeholder="{{ trans('labels.link_text') }}"
                                        value="{{ $getbannerdata->link_text }}" required>
                                   
                                </div>
                            @endif
                        </div>
                        <div class="row">
                            @if ($getbannerdata->section == 0)
                                <div class="col-sm-6 form-group">
                                    <label class="form-label">{{ trans('labels.title') }} <span class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control" name="title"
                                        placeholder="{{ trans('labels.title') }}" value="{{ $getbannerdata->title }}"
                                        required>
                                  
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="form-label">{{ trans('labels.image') }}<span class="text-danger"> *
                                        </span></label>
                                    <input type="file" class="form-control" name="image">
                                   
                                    <img src="{{ helper::image_path($getbannerdata->banner_image) }}"
                                        class="img-fluid rounded hw-50 mt-1" alt="">
                                </div>
                                <div class="col-sm-6 form-group">
                                    <label class="form-label">{{ trans('labels.description') }} <span class="text-danger">
                                            *
                                        </span></label>
                                    <textarea name="description" class="form-control" rows="5" placeholder="{{ trans('labels.description') }}">{{ $getbannerdata->description }}</textarea>
                                   
                                </div>
                            @else
                                <div class="col-sm-6 form-group">
                                    <label class="form-label">{{ trans('labels.image') }}<span class="text-danger"> *
                                        </span></label>
                                    <input type="file" class="form-control" name="image">
                                   
                                    <img src="{{ helper::image_path($getbannerdata->banner_image) }}"
                                        class="img-fluid rounded hw-50 mt-1" alt="">
                                </div>
                            @endif

                        </div>
                        <div class="row">
                            <div class="form-group text-end">
                                <a href="{{ URL::to($url) }}"
                                    class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                                <button
                                    class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_banner', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button"
                                    onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $('.type').on('change', function() {
            "use strict";
            var optionValue = $(this).find("option:selected").attr("value");

            if (optionValue) {
                $(".gravity").not("." + optionValue).hide();
                $(".gravity").not("." + optionValue).find('select').prop('required', false);
                $("." + optionValue).show();
                $("." + optionValue).find('select').prop('required', true);

            } else {
                $(".gravity").hide();
                $(".gravity").find('select').prop('required', false);
                $('#link_text').prop('required', false);
            }
            if (optionValue != 0) {
                $('#link_text').prop('required', true);
                $('.link_text').removeClass('d-none');

            } else {
                $('#link_text').prop('required', false);
                $('.link_text').addClass('d-none');
            }
        }).change();
    </script>
@endsection
