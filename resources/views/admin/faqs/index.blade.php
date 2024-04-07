@extends('admin.layout.default')
@section('content')
   
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-uppercase">{{ trans('labels.faqs') }}</h5>
            <a href="{{ URL::to('admin/faqs/add') }}" class="btn btn-secondary px-2 d-flex">
                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}
            </a>
        </div>
        <div class="row mt-3">
        @php
    if (Auth::user()->type == 4) {
    $vendor_id = Auth::user()->vendor_id;
    } else {
    $vendor_id = Auth::user()->id;
    }
    @endphp
            <div class="col-12">
                <div class="card border-0 mb-3">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table
                                class="table table-striped table-bordered py-3 zero-configuration w-100 dataTable no-footer">
                                <thead>
                                    <tr class="text-uppercase fw-500">
                                        <td></td>
                                        <td>{{ trans('labels.srno') }}</td>
                                        <td>{{ trans('labels.question') }}</td>
                                        <td>{{ trans('labels.answer') }}</td>
                                        <td>{{ trans('labels.created_date') }}</td>
                                        <td>{{ trans('labels.updated_date') }}</td>
                                        <td>{{ trans('labels.action') }}</td>
                                    </tr>
                                </thead>
                                <tbody id="tabledetails" data-url="{{url('admin/faqs/reorder_faq')}}">
                                    @php
                                        
                                        $i = 1;
                                        
                                    @endphp
                                    @foreach ($faqs as $faq)
                                        <tr class="fs-7 row1" id="dataid{{$faq->id}}" data-id="{{$faq->id}}">
                                            <td><a tooltip="{{trans('labels.move')}}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                                            <td>@php
                                                
                                                echo $i++;
                                                
                                            @endphp</td>
                                            <td>{{ $faq->question }}</td>
                                            <td>{{ $faq->answer }}</td>
                                            <td>{{ helper::date_format($faq->created_at) }}<br>
                                            {{helper::time_format($faq->created_at,$vendor_id)}}
                                            </td>
                                            <td>{{ helper::date_format($faq->updated_at) }}<br>
                                            {{helper::time_format($faq->updated_at,$vendor_id)}}
                                            </td>
                                            <td>
                                                <a href="{{ URL::to('/admin/faqs/edit-' . $faq->id) }}" tooltip="{{trans('labels.edit')}}"
                                                    class="btn btn-outline-info btn-sm mx-1"> <i
                                                        class="fa-regular fa-pen-to-square"></i></a>
                                                <a href="javascript:void(0)" tooltip="{{trans('labels.delete')}}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/faqs/delete-' . $faq->id) }}')" @endif
                                                    class="btn btn-outline-danger btn-sm">
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
