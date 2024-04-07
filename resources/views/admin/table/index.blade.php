@php

if (Auth::user()->type == 4) {

$vendor_id = Auth::user()->vendor_id;

} else {

$vendor_id = Auth::user()->id;

}

@endphp

@extends('admin.layout.default')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">

    <h5 class="text-uppercase">{{ trans('labels.table') }}</h5>

    <a href="{{ URL::to('admin/dinein/add') }}" class="btn btn-secondary px-2 d-flex {{ Auth::user()->type == 4 ? (helper::check_access('role_table', Auth::user()->role_id, $vendor_id, 'add') == 1 ? '' : 'd-none') : '' }}"><i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>

</div>

<div class="row">

    <div class="col-12">

        <div class="card border-0 my-3">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-striped table-bordered py-3 zero-configuration w-100">

                        <thead>

                            <tr class="text-uppercase fw-500">

                                <td></td>

                                <td>{{ trans('labels.srno') }}</td>

                                <td>{{ trans('labels.name') }}</td>

                                <td>{{ trans('labels.status') }}</td>

                                <td>{{ trans('labels.created_date') }}</td>

                                <td>{{ trans('labels.updated_date') }}</td>

                                <td>{{ trans('labels.action') }}</td>

                            </tr>

                        </thead>

                        <tbody id="tabledetails" data-url="{{ url('admin/dinein/reorder_category') }}">

                            @php $i=1; @endphp

                            @foreach ($tables as $table)

                            <tr class="fs-7 row1" id="dataid{{ $table->id }}" data-id="{{ $table->id }}">

                                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>

                                <td>@php echo $i++ @endphp</td>

                                <td>{{ $table->name }}</td>

                                <td>

                                    @if ($table->is_available == '1')

                                    <a tooltip="{{ trans('labels.active') }}" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/dinein/change_status-' . $table->id . '/2') }}')" @endif class="btn btn-sm btn-outline-success {{ Auth::user()->type == 4 ? (helper::check_access('role_table', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i class="fas fa-check"></i></a>

                                    @else

                                    <a tooltip="{{ trans('labels.inactive') }}" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/dinein/change_status-' . $table->id . '/1') }}')" @endif class="btn btn-sm btn-outline-danger {{ Auth::user()->type == 4 ? (helper::check_access('role_table', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i class="fas fa-close"></i></a>

                                    @endif

                                </td>

                                <td>{{ helper::date_format($table->created_at) }}<br>
                                    {{helper::time_format($table->created_at,$vendor_id)}}

                                </td>

                                <td>{{ helper::date_format($table->updated_at) }}<br>
                                {{helper::time_format($table->updated_at,$vendor_id)}}
                                </td>

                                <td>

                                    <a href="{{ URL::to('admin/dinein/edit-' . $table->id) }}" tooltip="{{ trans('labels.edit') }}" class="btn btn-outline-info btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_table', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">

                                        <i class="fa-regular fa-pen-to-square"></i></a>

                                    <a tooltip="{{ trans('labels.delete') }}" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/dinein/delete-' . $table->id) }}')" @endif class="btn btn-outline-danger btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_table', Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">

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