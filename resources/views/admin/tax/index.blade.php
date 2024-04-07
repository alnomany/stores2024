@extends('admin.layout.default')
@section('content')
<div class="d-flex justify-content-between align-items-center">
    <h5 class="text-uppercase">{{ trans('labels.tax') }}</h5>
    <a href="{{ URL::to('admin/tax/add') }}" class="btn btn-secondary px-2 d-flex">
        <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
    </a>
</div>
<div class="row">
    @php
    if (Auth::user()->type == 4) {
    $vendor_id = Auth::user()->vendor_id;
    } else {
    $vendor_id = Auth::user()->id;
    }
    @endphp
    <div class="col-12">
        <div class="card border-0 my-3">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                        <thead>
                            <tr class="text-uppercase fw-500">
                                <td></td>
                                <td>{{trans('labels.srno')}}</td>
                                <td>{{trans('labels.name')}}</td>
                                <td>{{trans('labels.tax')}}</td>
                                <td>{{ trans('labels.status') }}</td>
                                <td>{{trans('labels.created_date')}}</td>
                                <td>{{trans('labels.updated_date')}}</td>
                                <td>{{trans('labels.action')}}</td>

                            </tr>
                        </thead>
                        <tbody id="tabledetails" data-url="{{url('admin/tax/reorder_tax')}}">
                            @php
                            $i=1;
                            @endphp
                            @foreach ($gettax as $tax)
                            <tr class="fs-7 row1" id="dataid{{$tax->id}}" data-id="{{$tax->id}}">
                                <td><a tooltip="{{trans('labels.move')}}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                                <td>@php
                                    echo $i++
                                    @endphp </td>
                                <td>{{$tax->name}}</td>

                                <td>@if($tax->type == 1) {{helper::currency_formate($tax->tax,$vendor_id)}} @else {{$tax->tax}}% @endif</td>
                                <td>
                                    @if ($tax->is_available == '1')
                                    <a @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/tax/change_status-' . $tax->id . '/2') }}')" @endif class="btn btn-sm btn-outline-success" tooltip="{{trans('labels.active')}}"><i class="fas fa-check"></i></a>
                                    @else
                                    <a @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/tax/change_status-' . $tax->id . '/1') }}')" @endif class="btn btn-sm btn-outline-danger" tooltip="{{trans('labels.inactive')}}"><i class="fas fa-close"></i></a>
                                    @endif
                                </td>
                                <td>{{ helper::date_format($tax->created_at) }}<br>
                                    {{ helper::time_format($tax->created_at,$vendor_id) }}
                                </td>
                                <td>{{ helper::date_format($tax->updated_at) }}<br>
                                    {{ helper::time_format($tax->updated_at,$vendor_id) }}
                                </td>
                                <td>
                                    <a href="{{URL::to('admin/tax/edit-'.$tax->id)}}" class="btn btn-outline-info btn-sm" tooltip="{{trans('labels.edit')}}"> <i class="fa-regular fa-pen-to-square"></i></a>
                                    <a @if(env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{URL::to('admin/tax/delete-'.$tax->id)}}')" @endif class="btn btn-outline-danger btn-sm" tooltip="{{trans('labels.delete')}}"> <i class="fa-regular fa-trash"></i></a>
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