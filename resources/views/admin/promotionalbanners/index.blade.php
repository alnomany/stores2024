@extends('admin.layout.default')
@section('content')
@php
if (Auth::user()->type == 4) {
$vendor_id = Auth::user()->vendor_id;
} else {
$vendor_id = Auth::user()->id;
}
$i = 1;
@endphp
<div class="d-flex justify-content-between align-items-center">
    <h5 class="text-uppercase">{{ trans('labels.promotional_banners') }}</h5>
    <a href="{{ URL::to('admin/promotionalbanners/add') }}" class="btn btn-secondary px-2 d-flex">
        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
    </a>
</div>
<div class="row mt-3">
    <div class="col-12">
        <div class="card border-0 mb-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                        <thead>
                            <tr class="text-uppercase fw-500">
                                <td></td>
                                <td>{{ trans('labels.srno') }}</td>
                                <td>{{ trans('labels.image') }}</td>
                                <td>{{ trans('labels.vendor_title') }}</td>
                                <td>{{ trans('labels.created_date') }}</td>
                                <td>{{ trans('labels.updated_date') }}</td>
                                <td>{{ trans('labels.action') }}</td>
                            </tr>
                        </thead>
                        <tbody id="tabledetails" data-url="{{ url('admin/promotionalbanners/reorder_promotionalbanner') }}">
                            @php
                            $i = 1;
                            @endphp
                            @foreach ($getbannerlist as $banner)
                            <tr class="fs-7 row1" id="dataid{{ $banner->id }}" data-id="{{ $banner->id }}">
                                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                                <td>
                                    @php
                                    echo $i++;
                                    @endphp</td>
                                <td><img src="{{ helper::image_path($banner->image) }}" class="hw-50 object-fit-cover" alt=""></td>
                                <td>{{ $banner['vendor_info']->name }}</td>
                                <td>{{ helper::date_format($banner->created_at) }}<br>
                                    {{ helper::time_format($banner->created_at,$vendor_id) }}
                                </td>
                                <td>{{ helper::date_format($banner->updated_at) }}<br>
                                    {{ helper::time_format($banner->updated_at,$vendor_id) }}
                                </td>
                                <td>
                                    <a href="{{ URL::to('admin/promotionalbanners/edit-' . $banner->id) }}" class="btn btn-outline-info btn-sm mx-1" tooltip="{{ trans('labels.edit') }}"> <i class="fa-regular fa-pen-to-square"></i></a>
                                    <a href="javascript:void(0)" tooltip="{{ trans('labels.delete') }}" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/promotionalbanners/delete-' . $banner->id) }}')" @endif class="btn btn-outline-danger btn-sm">
                                        <i class="fa-regular fa-trash"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection