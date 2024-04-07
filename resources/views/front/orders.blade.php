@include('front.theme.header')
<!------ breadcrumb ------>
<section class="breadcrumb-sec">

    <div class="container">

        <nav aria-label="breadcrumb">

            <h2 class="breadcrumb-title mb-2">{{ trans('labels.orders') }}</h2>

            <ol class="breadcrumb justify-content-center">

                <li class="breadcrumb-item"><a class="text-dark"
                        href="{{ URL::to($storeinfo->slug . '/') }}">{{ trans('labels.home') }}</a>
                </li>

                <li class="text-muted breadcrumb-item active" aria-current="page">{{ trans('labels.orders') }}</li>

            </ol>

        </nav>

    </div>

</section>

<section class="product-prev-sec product-list-sec">
    <div class="container">
        <div class="user-bg-color mb-5">
            <div class="container">
                <div class="row">
                    @include('front.theme.sidebar')
                    <div class="col-lg-8 col-xxl-9 col-12">
                        <div class="border rounded table-box">
                            <div class="card">
                                <div class="settings-box-header border-bottom px-4 py-3">
                                    <h5 class="mb-0"><i class="fa-regular fa-user"></i><span
                                            class="px-2">{{ trans('labels.orders') }}</span></h5>
                                </div>
                                <div class="card-body">
                                    <div class='d-flex align-items-center pb-4 table-top-box'>
                                        @if (helper::appdata($storeinfo->id)->product_type == 1)
                                            <a href="{{ URL::to($storeinfo->slug . '/orders?type=processing') }}"
                                                class="w-100">
                                                <button type='button'
                                                    class="btn-outline-warning border border-warning rounded warning-icon-box px-3 py-3 w-100 {{ app('request')->input('type') == 'processing' ? 'preparing-box-active' : '' }} processing-box">
                                                    <span class='warning-icon d-flex d-flex align-items-center'>
                                                        <i
                                                            class="fa-regular fa-hourglass  d-flex justify-content-center align-items-center"></i>
                                                        <div class='px-3'>
                                                            <p class='m-0 p-0'>{{ trans('labels.preparing') }}</p>
                                                            <p class='text-start-pro m-0 p-0 text-left'>
                                                                {{ $totalprocessing }}</p>
                                                        </div>
                                                    </span>
                                                </button>
                                            </a>


                                            <a href="{{ URL::to($storeinfo->slug . '/orders?type=completed') }}"
                                                class="w-100 mx-3 delivered-box">
                                                <button type='button'
                                                    class="btn-outline-success border border-success rounded warning-icon-box px-3 py-3 w-100 {{ app('request')->input('type') == 'completed' ? 'completed-box-active' : '' }} processing-box">
                                                    <span class='success-icon d-flex d-flex align-items-center'>
                                                        <i
                                                            class='fa-regular fa-circle-check d-flex justify-content-center align-items-center'>
                                                        </i>
                                                        <div class='px-3'>
                                                            <p class='m-0 p-0'>{{ trans('labels.delivered') }}</p>
                                                            <p class='text-start-pro m-0 p-0 text-left'>
                                                                {{ $totalcompleted }}</p>
                                                        </div>
                                                    </span>
                                                </button>
                                            </a>

                                            <a href="{{ URL::to($storeinfo->slug . '/orders?type=rejected') }}"
                                                class="w-100 rejected-box">
                                                <button type='button'
                                                    class="btn-outline-danger border border-danger rounded px-3 py-3 w-100 {{ app('request')->input('type') == 'rejected' ? 'rejected-box-active' : '' }}">
                                                    <span class='danger-icon d-flex d-flex align-items-center'>
                                                        <i
                                                            class='fa-solid fa-xmark d-flex justify-content-center align-items-center'></i>
                                                        <div class='px-3'>
                                                            <p class='m-0 p-0'>{{ trans('labels.rejected') }}</p>
                                                            <p class='text-start-pro m-0 p-0 text-left'>
                                                                {{ $totalrejected }}</p>
                                                        </div>
                                                    </span>
                                                </button>
                                            </a>
                                        @endif
                                    </div>



                                    <!-- new order list -->
                                    <div class="row">
                                        @if ($getorders->count() > 0)
                                            @foreach ($getorders as $orderdata)
                                                <div class="col-md-6 col-12 mb-3">
                                                    <a
                                                        href="{{ URL::to(@$storeinfo->slug . '/find-order?order=' . $orderdata->order_number) }}">
                                                        <div class="card border rounded-4">
                                                            <div class="card-body">
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between pb-2">
                                                                    <p
                                                                        class="m-0 fw-semibold text-uppercase order-number">
                                                                        {{ trans('labels.id') }} :
                                                                        <span>{{ $orderdata->order_number }}</span>
                                                                    </p>
                                                                    <span
                                                                        class="m-0 text-muted order-date">{{ helper::date_format($orderdata->created_at) }}</span>
                                                                </div>

                                                                <p class="text-muted order-payment">
                                                                    {{ trans('labels.payment_type') }} :
                                                                    <span>
                                                                        @if ($orderdata->payment_type == 6)
                                                                            {{ @helper::getpayment($orderdata->payment_type, $orderdata->vendor_id)->payment_name }}
                                                                            : <small><a
                                                                                    href="{{ helper::image_path($orderdata->screenshot) }}"
                                                                                    target="_blank"
                                                                                    class="text-danger">{{ trans('labels.click_here') }}</a></small>
                                                                        @elseif($orderdata->payment_type == 1)
                                                                            {{ @helper::getpayment($orderdata->payment_type, $orderdata->vendor_id)->payment_name }}
                                                                        @elseif(in_array($orderdata->payment_type, [2, 3, 4, 5, 7, 8, 9, 10]))
                                                                            {{ @helper::getpayment($orderdata->payment_type, $orderdata->vendor_id)->payment_name }}
                                                                            : {{ $orderdata->payment_id }}
                                                                        @endif
                                                                    </span>
                                                                </p>
                                                                <div
                                                                    class="d-flex align-items-center justify-content-between">

                                                                    <p class="m-0 fw-semibold">
                                                                        {{ helper::currency_formate($orderdata->grand_total, $orderdata->vendor_id) }}
                                                                    </p>

                                                                    <span class="m-0">
                                                                        @if ($orderdata->status_type == '1')
                                                                            <span class="badge text-bg-warning p-2"> <i
                                                                                    class="fa-regular fa-bell"></i>
                                                                                {{ @helper::gettype($orderdata->status,$orderdata->status_type,$orderdata->order_type,$orderdata->vendor_id)->name }}</span>
                                                                        @elseif($orderdata->status_type == '2')
                                                                            <span class="badge text-bg-info p-2"> <i
                                                                                    class="fa-regular fa-tasks"></i>
                                                                                {{ @helper::gettype($orderdata->status,$orderdata->status_type,$orderdata->order_type,$orderdata->vendor_id)->name }}</span>
                                                                        @elseif($orderdata->status_type == '4')
                                                                            <span class="badge text-bg-danger p-2"> <i
                                                                                    class="fa-regular fa-close"></i>
                                                                                {{ @helper::gettype($orderdata->status,$orderdata->status_type,$orderdata->order_type,$orderdata->vendor_id)->name }}</span>
                                                                        @elseif($orderdata->status_type == '3')
                                                                            <span class="badge text-bg-success"> <i
                                                                                    class="fa-regular fa-check"></i>
                                                                                {{ @helper::gettype($orderdata->status,$orderdata->status_type,$orderdata->order_type,$orderdata->vendor_id)->name }}</span>
                                                                        @else
                                                                            --
                                                                        @endif
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            @endforeach
                                        @else
                                        @include('front.no_data')
                                        @endif
                                        @php $i = 1; @endphp

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- newsletter -->
@include('front.newsletter')
<!-- newsletter -->

@include('front.theme.footer')
