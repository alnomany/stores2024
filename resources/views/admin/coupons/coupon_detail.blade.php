@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">
            {{ trans('labels.coupon_details') }}
        </h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/coupons') }}">{{ trans('labels.coupons') }}</a>
                </li>
                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.coupon_details') }}</li>
            </ol>
        </nav>
    </div>
    <table class="table table-striped table-bordered py-3 zero-configuration w-100">
        <thead>
            <tr class="text-uppercase fw-500">
                <td>{{ trans('labels.srno') }}</td>
                @if (Auth::user()->type == 1)
                    <td>{{ trans('labels.transaction_number') }}</td>
                @else
                    <td>{{ trans('labels.order_number') }}</td>
                @endif
                <td>{{ trans('labels.discount_amount') }}</td>
                <td>{{ trans('labels.date') }}</td>

            </tr>
        </thead>
        <tbody>
            @php $i = 1; @endphp
            @foreach ($coupons as $coupon)
                <tr class="fs-7">
                    <td>@php echo $i++; @endphp</td>
                    @if (Auth::user()->type == 1)
                        <td>{{ $coupon->transaction_number }}</td>
                        <td>{{ helper::currency_formate($coupon->offer_amount,$coupon->vendor_id) }}</td>
                    @else
                        <td>{{ $coupon->order_number }}</td>
                        <td>{{helper::currency_formate($coupon->discount_amount,$coupon->vendor_id) }}</td>
                    @endif
                    <td>{{ helper::date_format($coupon->created_at) }}<br>
                        {{$coupon->created_at->format('h:i A')}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
