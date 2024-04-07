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
        <h5 class="text-uppercase">{{ trans('labels.invoice') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                @if (Auth::user()->type == 1)
                    <li class="breadcrumb-item"><a
                            href="{{ URL::to('admin/customers/orders-' . $getorderdata->user_id) }}">{{ trans('labels.orders') }}</a>
                    </li>
                @else
                    <li class="breadcrumb-item"><a href="{{ URL::to('admin/orders') }}">{{ trans('labels.orders') }}</a></li>
                @endif

                <li class="breadcrumb-item active {{ session()->get('direction') == 2 ? 'breadcrumb-rtl' : '' }}"
                    aria-current="page">{{ trans('labels.invoice') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-5 col-xl-4">
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="card-header text-center">
                        <h4 class="card-title mb-0">#{{ $getorderdata->order_number }}</h4>
                    </div>
                    <div class="basic-list-group">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                {{ trans('labels.date') }}<p class="text-muted">
                                    {{ helper::date_format($getorderdata->created_at) }}</p>
                            </li>
                            @if ($getorderdata->order_from != 'pos')
                                @if ($getorderdata->order_type == 1 || $getorderdata->order_type == 2)
                                    @if (helper::appdata($vendor_id)->ordertype_date_time == 1 &&
                                            $getorderdata->delivery_date != null &&
                                            $getorderdata->delivery_time != null)
                                        <li class="list-group-item px-0 d-flex justify-content-between">
                                            {{ $getorderdata->order_type == 1 ? trans('labels.delivery_date') : trans('labels.pickup_date') }}
                                            <p class="text-muted">{{ helper::date_format($getorderdata->delivery_date) }}
                                            </p>
                                        </li>
                                        <li class="list-group-item px-0 d-flex justify-content-between">
                                            {{ $getorderdata->order_type == 1 ? trans('labels.delivery_time') : trans('labels.pickup_time') }}
                                            <p class="text-muted">{{ $getorderdata->delivery_time }} </p>
                                        </li>
                                    @endif
                                @endif
                            @endif

                            {{-- payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10 --}}
                            <li class="list-group-item px-0 d-flex justify-content-between">
                                {{ trans('labels.payment_type') }}
                                <span>
                                    @if ($getorderdata->payment_type == 6)
                                        {{ @helper::getpayment($getorderdata->payment_type, $getorderdata->vendor_id)->payment_name }}
                                        : <small><a href="{{ helper::image_path($getorderdata->screenshot) }}"
                                                target="_blank"
                                                class="text-danger">{{ trans('labels.click_here') }}</a></small>
                                    @else
                                        {{ @helper::getpayment($getorderdata->payment_type, $getorderdata->vendor_id)->payment_name }}
                                    @endif
                                </span>
                            </li>
                            @if (in_array($getorderdata->payment_type, [2, 3, 4, 5, 7, 8, 9, 10]))
                                <li class="list-group-item px-0">{{ trans('labels.payment_id') }}<p class="text-muted">
                                        {{ $getorderdata->payment_id }}</p>
                                </li>
                            @endif
                        </ul>
                    </div>
                    @if ($getorderdata->notes != '')
                        <h6>{{ trans('labels.order_notes') }}</h6>
                        <small class="text-muted">{{ $getorderdata->notes }}</small>
                    @endif
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="basic-list-group">
                        <div class="row">
                            <div class="col-md-12 my-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item px-0 d-flex align-items-center py-0">
                                        <h6 class="m-2"><i class="fa-regular fa-user"></i></h6>
                                        {{ $getorderdata->customer_name }}
                                    </li>
                                    @if ($getorderdata->mobile != null)
                                        <li class="list-group-item px-0 d-flex align-items-center py-0">
                                            <h6 class="m-2"><i class="fa-regular fa-phone"></i></h6>
                                            {{ $getorderdata->mobile }}
                                        </li>
                                    @endif

                                    @if ($getorderdata->customer_email != null)
                                        <li class="list-group-item px-0 d-flex align-items-center py-0">
                                            <h6 class="m-2"><i class="fa-regular fa-envelope"></i></h6>
                                            {{ $getorderdata->customer_email }}
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            @if ($getorderdata->order_type == 1)
                                <div class="col-md-12 my-2">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-home" type="button" role="tab"
                                                aria-controls="nav-home" aria-selected="true"> <i
                                                    class="fa-regular fa-file-lines"></i>
                                                {{ trans('labels.bill_to') }}</button>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                            aria-labelledby="nav-home-tab">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex align-items-center">
                                                    {{ $getorderdata->address }} </li>
                                                <li class="list-group-item d-flex align-items-center">
                                                    {{ $getorderdata->building }}, {{ $getorderdata->landmark }}
                                                </li>
                                                <li class="list-group-item d-flex align-items-center">
                                                    {{ $getorderdata->pincode }}. </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7 col-xl-8">
            <div class="row">
                <div class="col-md-12 my-2 d-flex justify-content-end">
                    <a href="{{ URL::to('admin/orders/print/' . $getorderdata->order_number) }}" target="_blank"
                        class="btn btn-info mx-1 {{ Auth::user()->type == 1 ? 'disabled' : '' }} {{ Auth::user()->type == 4 ? (helper::check_access(trans('labels.orders'), Auth::user()->role_id, $vendor_id, 'manage') == 1 ? '' : 'disabled') : '' }}">
                        <i class="fa fa-pdf" aria-hidden="true"></i> {{ trans('labels.print') }}
                    </a>
                    @if (helper::appdata($vendor_id)->product_type == 1)
                        @if ($getorderdata->status_type != 3 || $getorderdata->status_type != 4)
                            <button type="button" class="btn btn-sm btn-dark dropdown-toggle"
                                data-bs-toggle="dropdown">{{ trans('labels.action') }}</button>
                            <div class="dropdown-menu dropdown-menu-right {{ Auth::user()->type == 1 ? 'disabled' : '' }}">
                                @foreach (helper::customstauts($getorderdata->vendor_id, $getorderdata->order_type) as $status)
                                    <a class="dropdown-item w-auto @if ($getorderdata->status == '1') fw-600 @endif"
                                        onclick="statusupdate('{{ URL::to('admin/orders/update-' . $getorderdata->id . '-' . $status->id . '-' . $status->type) }}')">{{ $status->name }}</a>
                                @endforeach
                            </div>
                        @endif
                    @endif
                    <a href="{{ URL::to('/admin/orders/generatepdf/' . $getorderdata->order_number) }}"
                        tooltip="{{ trans('labels.downloadpdf') }}" class="btn btn-secondary mx-1"><i
                            class="fa-solid fa-file-pdf"></i></a>
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="progress-barrr">
                        @if (!in_array($getorderdata->status_type, [1, 2, 3, 4]))
                            <div class="progress-step is-active">
                                <div class="step-count"><i class="fa-regular fa-exclamation-triangle"></i></div>
                                <div class="step-description">{{ trans('messages.wrong') }}</div>
                            </div>
                        @else
                            <div class="progress-step @if ($getorderdata->status_type == '1') is-active @endif">
                                <div class="step-count"><i class="fa-regular fa-bell"></i></div>
                                <div class="step-description">{{ trans('labels.placed') }}</div>
                            </div>
                            @if ($getorderdata->status_type == 4)
                                <div class="progress-step is-active">
                                    <div class="step-count"><i class="fa-regular fa-close"></i></div>
                                    <div class="step-description">
                                        {{ trans('labels.cancel') }}
                                    </div>
                                </div>
                            @else
                                <div class="progress-step @if ($getorderdata->status_type == '2') is-active @endif">
                                    <div class="step-count"><i class="fa-regular fa-tasks"></i></div>
                                    <div class="step-description">{{ trans('labels.preparing') }}</div>
                                </div>
                            @endif
                            <div class="progress-step @if ($getorderdata->status == '3') is-active @endif">
                                <div class="step-count"><i class="fa-regular fa-check"></i></div>
                                <div class="step-description">{{ trans('labels.delivered') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card border-0 mb-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr class="text-uppercase">
                                    <td>{{ trans('labels.image') }}</td>
                                    <td>{{ trans('labels.products') }}</td>
                                    <td class="text-end">{{ trans('labels.unit_cost') }}</td>
                                    <td class="text-end">{{ trans('labels.qty') }}</td>
                                    <td class="text-end">{{ trans('labels.sub_total') }}</td>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @foreach ($ordersdetails as $orders)
                                    @php
                                        $itemprice = $orders->price;
                                        if ($orders->variants_id != '') {
                                            $itemprice = $orders->variants_price;
                                        }
                                    @endphp
                                    
                                    <tr>
                                        <td><img src="{{ helper::image_path($orders->item_image) }}"
                                                class="rounded hw-50" alt=""></td>
                                        <td>{{ $orders->item_name }}
                                            @if ($orders->variants_id != '')
                                                - <small>{{ $orders->variants_name }} ({{ helper::currency_formate($orders->variants_price, $getorderdata->vendor_id) }})</small>
                                            @endif
                                            @if ($orders->extras_id != '')
                                                <?php
                                                $extras_id = explode('|', $orders->extras_id);
                                                $extras_name = explode('|', $orders->extras_name);
                                                $extras_price = explode('|', $orders->extras_price);
                                                $extras_total_price = 0;
                                                ?>
                                                <br>
                                                @foreach ($extras_id as $key => $addons)
                                                    <small>
                                                        <b class="text-muted">{{ $extras_name[$key] }}</b> :
                                                        {{ helper::currency_formate($extras_price[$key], $getorderdata->vendor_id) }}<br>
                                                    </small>
                                                    @php
                                                        $extras_total_price += $extras_price[$key];
                                                    @endphp
                                                @endforeach
                                            @else
                                                @php
                                                    $extras_total_price = 0;
                                                @endphp
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            {{ helper::currency_formate((float)$orders->variants_price + (float)$extras_total_price, $getorderdata->vendor_id) }}
                                        </td>
                                        <td class="text-end">{{ $orders->qty }}</td>
                                        @php
                                            $total = ((float)$orders->variants_price +  (float)$extras_total_price) * (float)$orders->qty
                                        @endphp
                                        <td class="text-end">
                                            {{ helper::currency_formate($total, $getorderdata->vendor_id) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td class="text-end" colspan="4">
                                        <strong>{{ trans('labels.sub_total') }}</strong>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ helper::currency_formate($getorderdata->sub_total, $getorderdata->vendor_id) }}</strong>
                                    </td>
                                </tr>
                                @if ($getorderdata->discount_amount > 0)
                                    <tr>
                                        <td class="text-end" colspan="4">
                                            <strong>{{ trans('labels.discount') }}</strong>{{ $getorderdata->couponcode != '' ? '(' . $getorderdata->couponcode . ')' : '' }}
                                        </td>
                                        <td class="text-end">
                                            <strong>-{{ helper::currency_formate($getorderdata->discount_amount, $getorderdata->vendor_id) }}</strong>
                                        </td>
                                    </tr>
                                @endif

                                @php
                                    $tax = explode('|', $getorderdata->tax);
                                    $tax_name = explode('|', $getorderdata->tax_name);
                                @endphp
                                @if ($getorderdata->tax != null && $getorderdata->tax != '')
                                    @foreach ($tax as $key => $tax_value)
                                        <tr>
                                            <td class="text-end" colspan="4">
                                                <strong>{{ $tax_name[$key] }}</strong>
                                            </td>
                                            <td class="text-end">
                                                <strong>{{ helper::currency_formate((float) $tax[$key], $getorderdata->vendor_id) }}</strong>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                @if ($getorderdata->order_type == 1)
                                    <tr>
                                        <td class="text-end" colspan="4">
                                            <strong>{{ trans('labels.delivery_charge') }}
                                                ({{ $getorderdata->delivery_area }}) </strong>
                                        </td>
                                        <td class="text-end">
                                            <strong>{{ helper::currency_formate($getorderdata->delivery_charge, $getorderdata->vendor_id) }}</strong>
                                        </td>
                                    </tr>
                                @endif
                                <tr>
                                    <td class="text-end text-success" colspan="4">
                                        <strong>{{ trans('labels.total') }} {{ trans('labels.amount') }}</strong>
                                    </td>
                                    <td class="text-end text-success">
                                        <strong>{{ helper::currency_formate($getorderdata->grand_total, $getorderdata->vendor_id) }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
