@php
    if(Auth::user()->type == 4)
    {
        $vendor_id = Auth::user()->vendor_id;
    }else{
        $vendor_id = Auth::user()->id;
    }
@endphp

@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.coupons') }}</h5>
        <a href="{{ URL::to('admin/coupons/add') }}" class="btn btn-secondary px-2 d-flex {{Auth::user()->type == 4 ? (helper::check_access('role_coupon', Auth::user()->role_id, $vendor_id, 'add') == 1  ? '':'d-none'): ''}}">
            <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
        </a>
    </div>
    <div class="row">
        <div class="col-12 mb-lg-0">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        @include('admin.coupons.coupons_table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection