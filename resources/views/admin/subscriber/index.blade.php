@extends('admin.layout.default')
@section('content')
@php
    if (Auth::user()->type == 4) {
    $vendor_id = Auth::user()->vendor_id;
    } else {
    $vendor_id = Auth::user()->id;
    }
    @endphp
    <div class="d-flex justify-content-between align-items-center">
        <h5 class="text-uppercase">{{ trans('labels.subscribers') }}</h5>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                            <thead>
                                <tr class="text-uppercase fw-500">
                                    <td>{{ trans('labels.srno') }}</td>
                                    <td>{{ trans('labels.email') }}</td>
                                    <td>{{ trans('labels.created_date') }}</td>
                                    <td>{{ trans('labels.updated_date') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                                @php $i=1; @endphp
                                @foreach ($getsubscribers as $subscriber)
                                    <tr class="fs-7">
                                        <td>@php echo $i++ @endphp</td>
                                        <td>{{ $subscriber->email }}</td>
                                        <td>{{ helper::date_format($subscriber->created_at) }}<br>
                                        {{helper::time_format($subscriber->created_at,$vendor_id)}}
                                        </td>
                                        <td>{{ helper::date_format($subscriber->updated_at) }}<br>
                                        {{helper::time_format($subscriber->updated_at,$vendor_id)}}
                                        </td>
                                        <td>
                                            <a tooltip="{{ trans('labels.delete') }}"
                                                @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="deletedata('{{ URL::to('admin/subscribers/delete-' . $subscriber->id) }}')" @endif
                                                class="btn btn-outline-danger btn-sm {{ Auth::user()->type == 4 ? (helper::check_access(trans('labels.subscribers'), Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
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
