@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
    if (request()->is('admin/sliders*')) {
        $section = 0;
    
        $title = trans('labels.sliders');
    
        $url = 'sliders';
    } elseif (request()->is('admin/banner*')) {
        $section = 1;
    
        $title = trans('labels.banner') ;
    
        $url = 'banner';
    }
@endphp

@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{$title }}</h5>
        @if (Auth::user()->type == 4 && helper::check_access('role_banner', Auth::user()->role_id, $vendor_id, 'add') == 1)
            <a href="{{ URL::to(request()->url() . '/add') }}" class="btn btn-secondary px-2 d-flex">
                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
            </a>
        @endif
        @if (Auth::user()->type == 1 || Auth::user()->type == 2)
            <a href="{{ URL::to(request()->url() . '/add') }}" class="btn btn-secondary px-2 d-flex">
                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
            </a>
        @endif
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin.banner.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
