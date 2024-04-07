@extends('admin.layout.default')
@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="text-uppercase">{{ trans('labels.customers') }}</h5>
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
        <div class="card border-0">
            <div class="card-body">
                <div class="table-responsive" id="table-display">
                    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                        <thead>
                            <tr class="text-uppercase fw-500">
                                <td>{{ trans('labels.srno') }}</td>
                                <td>{{ trans('labels.image') }}</td>
                                <td>{{ trans('labels.name') }}</td>
                                <td>{{ trans('labels.email') }}</td>
                                <td>{{ trans('labels.mobile') }}</td>
                                <td>{{ trans('labels.login_type') }}</td>
                                @if (Auth::user()->type == 1)
                                <td>{{ trans('labels.status') }}</td>
                                @endif
                                <td>{{ trans('labels.created_date') }}</td>
                                <td>{{ trans('labels.updated_date') }}</td>
                                <td>{{ trans('labels.action') }}</td>

                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($getcustomerslist as $user)
                            <tr class="fs-7">
                                <td>@php echo $i++; @endphp</td>
                                <td> <img src="{{ helper::image_path($user->image) }}" class="img-fluid rounded hw-50" alt="" srcset=""> </td>
                                <td> {{ $user->name }} </td>
                                <td> {{ $user->email }} </td>
                                <td> {{ $user->mobile }}</td>
                                <td>
                                    @if ($user->login_type == 'email')
                                    {{ trans('labels.normal') }}
                                    @elseif ($user->login_type == 'google')
                                    {{ trans('labels.google') }}
                                    @elseif ($user->login_type == 'facebook')
                                    {{ trans('labels.facebook') }}
                                    @endif
                                </td>
                                @if (Auth::user()->type == 1)
                                <td>
                                    @if ($user->is_available == 1)
                                    <a class="btn btn-sm btn-outline-success" tooltip="{{ trans('labels.active') }}" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/customers/status-' . $user->id . '/2') }}')" @endif><i class="fa-sharp fa-solid fa-check"></i></a>
                                    @else
                                    <a class="btn btn-sm btn-outline-danger" tooltip="{{ trans('labels.inactive') }}" @if (env('Environment')=='sendbox' ) onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/customers/status-' . $user->id . '/1') }}')" @endif><i class="fa-sharp fa-solid fa-xmark"></i></a>
                                    @endif
                                </td>
                                @endif
                                <td>{{ helper::date_format($user->created_at) }}<br>
                                    {{ helper::time_format($user->created_at,$vendor_id) }}

                                </td>
                                <td>{{ helper::date_format($user->updated_at) }}<br>
                                    {{ helper::time_format($user->updated_at,$vendor_id) }}

                                </td>
                                <td>
                                    <a class="btn btn-sm btn-outline-secondary" tooltip="{{ trans('labels.view') }}" href="{{ URL::to('admin/customers/orders-' . $user->id) }}"><i class="fa-regular fa-eye"></i></a>
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