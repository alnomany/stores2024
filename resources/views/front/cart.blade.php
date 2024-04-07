@include('front.theme.header')
<!------ breadcrumb ------>
<section class="breadcrumb-sec">

    <div class="container">

        <nav aria-label="breadcrumb">

            <h2 class="breadcrumb-title mb-2">
                {{ trans('labels.my_cart') }}
            </h2>

            <ol class="breadcrumb justify-content-center">

                <li class="breadcrumb-item"><a class="text-dark"
                        href="{{ URL::to($storeinfo->slug . '/') }}">{{ trans('labels.home') }}</a>
                </li>

                <li class="text-muted breadcrumb-item active" aria-current="page">{{ trans('labels.cart') }}</li>

            </ol>

        </nav>

    </div>

</section>


<div class="cart-sec">
    <div class="container">
        @if (count($cartdata) == 0)
            @include('front.no_data')
        @else
            <div class="row">
                <div class="col-lg-12">
                    <div class="yourcart-sec">

                        @if (count($cartdata) == 0)
                            <p class="text-center">{{ trans('labels.data_not_found') }}</p>
                        @else
                            {{-- customer-title --}}

                            <!-- new product cart list -->
                            <table class="table cart-table m-md-0">
                                <thead>
                                    <tr>
                                        <th class="d-none d-sm-table-cell bg-light">{{ trans('labels.product') }}</th>
                                        <th class="d-none d-lg-table-cell bg-light">{{ trans('labels.price') }}</th>
                                        <th class="d-none d-md-table-cell bg-light">{{ trans('labels.quantity') }}</th>
                                        <th class="d-none d-sm-table-cell bg-light">{{ trans('labels.total') }}</th>
                                        <th class="d-none d-sm-table-cell bg-light">{{ trans('labels.remove') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @php

                                        $subtotal = 0;

                                    @endphp

                                    @foreach ($cartdata as $cart)
                                        @php
                                            $subtotal += $cart->item_price * $cart->qty;
                                        @endphp
                                        <tr>
                                            <td class="px-0 px-sm-2">
                                                <div class="product-detail">
                                                    <div class="pr-img">
                                                        <img src="{{ asset('storage/app/public/item/' . $cart->item_image) }}"
                                                            alt="" class="img-fluid h-100 w-100">
                                                    </div>
                                                    <div class="details">
                                                        <div
                                                            class="d-flex align-items-center justify-content-between mb-2 mb-sm-0">
                                                            <a class="cart_title" href="#">
                                                                <h5 class="cart-card-title card-font mb-1 line-2">
                                                                    {{ $cart->item_name }}
                                                                </h5>
                                                                @if ($cart->variants_id != '' || $cart->extras_id != '')
                                                                    <li class="mb-2">
                                                                        <P><span type="button" class="text-muted fs-7"
                                                                                onclick='showaddons("{{ $cart->id }}","{{ $cart->item_name }}","{{ $cart->attribute }}","{{ $cart->extras_name }}","{{ $cart->extras_price }}","{{ $cart->variants_name }}","{{ $cart->variants_price }}")'>
                                                                                {{ trans('labels.customize') }} </span>
                                                                        </P>
                                                                    </li>
                                                                @endif

                                                            </a>
                                                            <a onclick="RemoveCart('{{ $cart->id }}','{{ $storeinfo->id }}')"
                                                                class="item-delete d-block d-sm-none btn btn-store py-1 px-3">
                                                                <i class="fa-light fa-trash"></i>
                                                            </a>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">

                                                            <p class="cart-total-price m-0 text-left d-md-none">

                                                                {{ helper::currency_formate($cart->item_price, $storeinfo->id) }}

                                                            </p>

                                                            <div class="item-quantity d-md-none">
                                                                <div
                                                                    class="input-group qty-input2 qtu-width d-flex justify-content-between rounded-5 input-postion">
                                                                    <a class="btn btn-sm py-0 change-qty cart-padding"
                                                                        data-type="minus" value="minus value"
                                                                        onclick="qtyupdate('{{ $cart->id }}','{{ $cart->item_id }}','{{ $cart->variants_id }}','{{ $cart->variants_price }}','decreaseValue')">
                                                                        <i class="fa fa-minus"></i>
                                                                    </a>
                                                                    <input type="number"
                                                                        class="border text-center bg-transparent"
                                                                        id="number_{{ $cart->id }}" name="number"
                                                                        value="{{ $cart->qty }}" min="1"
                                                                        max="10" readonly>
                                                                    <a class="btn btn-sm py-0 change-qty cart-padding"
                                                                        data-type="plus" id="cart-plus"
                                                                        onclick="qtyupdate('{{ $cart->id }}','{{ $cart->item_id }}','{{ $cart->variants_id }}','{{ $cart->variants_price }}','increase')"
                                                                        value="plus value"><i class="fa fa-plus"></i>
                                                                    </a>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="price d-none d-lg-table-cell">
                                                <p class="cart-total-price m-0 text-left">
                                                    {{ helper::currency_formate($cart->item_price, $storeinfo->id) }}
                                                </p>
                                            </td>

                                            <td class="d-none d-md-table-cell">
                                                <div
                                                    class="input-group qty-input2 qtu-width d-flex justify-content-between rounded-5 input-postion m-auto">
                                                    <a class="btn btn-sm py-0 change-qty cart-padding" data-type="minus"
                                                        value="minus value"
                                                        onclick="qtyupdate('{{ $cart->id }}','{{ $cart->item_id }}','{{ $cart->variants_id }}','{{ $cart->item_price }}','decreaseValue')">
                                                        <i class="fa fa-minus"></i>
                                                    </a>
                                                    <input type="number" class="border text-center bg-transparent"
                                                        id="number_{{ $cart->id }}" name="number"
                                                        value="{{ $cart->qty }}" min="1" max="10"
                                                        readonly>
                                                    <a class="btn btn-sm py-0 change-qty cart-padding" data-type="plus"
                                                        id="cart-plus"
                                                        onclick="qtyupdate('{{ $cart->id }}','{{ $cart->item_id }}','{{ $cart->variants_id }}','{{ $cart->item_price }}','increase')"
                                                        value="plus value"><i class="fa fa-plus"></i>
                                                    </a>
                                                </div>
                                            </td>

                                            <td class="total d-none d-sm-table-cell">
                                                <p class="cart-total-price m-0 text-left" id="total_price">
                                                    {{ helper::currency_formate($cart->price, $storeinfo->id) }}
                                                </p>
                                            </td>

                                            <td class="total d-none d-sm-table-cell">
                                                <a onclick="RemoveCart('{{ $cart->id }}','{{ $storeinfo->id }}')"
                                                    class="item-delete btn btn-store py-1 px-2 col-xl-5 col-lg-8 col-9 mx-auto">
                                                    <i class="fa-light fa-trash"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                            <!-- new product cart list -->


                            <div class="promo-code d-sm-flex justify-content-between align-items-center my-3">
                                <div class="cuppon-text text-end">
                                    <span class="m-0 card-sub-total-text">{{ trans('labels.sub_total') }} :
                                        {{ helper::currency_formate($subtotal, $storeinfo->id) }}</span>
                                </div>
                                <div class="d-flex align-items-center mt-2 mt-sm-0">

                                    <!-- Continue Shopping btn -->
                                    <a href="{{ URL::to($storeinfo->slug) }}"
                                        class="btn btn-store-outline mx-3">{{ trans('labels.continue_shoping') }}</a>
                                    <!-- Continue Shopping btn -->

                                    @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                            App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
                                        @if (Auth::user() && Auth::user()->type == 3)
                                            <a class="btn btn-store mx-3"
                                                onclick="checkminorderamount('{{ $subtotal }}','{{ URL::to(@$storeinfo->slug . '/checkout') }}')"><span>{{ trans('labels.checkout') }}</span></a>
                                        @else
                                            @if (helper::appdata($storeinfo->id)->checkout_login_required == 1)
                                                <button type="button" class="btn btn-store m-0"
                                                    data-bs-toggle="modal"
                                                    onclick="checkminorderamount('{{ $subtotal }}','')">
                                                    {{ trans('labels.checkout') }}
                                                </button>
                                            @else
                                                <a class="btn btn-store m-0"
                                                    onclick="checkminorderamount('{{ $subtotal }}','{{ URL::to(@$storeinfo->slug . '/checkout') }}')"><span>{{ trans('labels.checkout') }}</span></a>
                                            @endif
                                        @endif
                                    @else
                                        <a class="btn btn-store m-0"
                                            onclick="checkminorderamount('{{ $subtotal }}','{{ URL::to(@$storeinfo->slug . '/checkout') }}')"><span>{{ trans('labels.checkout') }}</span></a>
                                    @endif
                                </div>
                            </div>

                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>


<!-- newsletter -->
@include('front.newsletter')
<!-- newsletter -->

<!-- Login Model Start -->
<div class="modal fade" id="loginmodel" tabindex="-1" aria-labelledby="loginmodelLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content p-2">
            <div class="modal-body">
                <div class="row justify-content-between">
                    <div class="col-md-12 col-lg-7">
                        <h3 class="promocodemodellable-titel m-0 text-start" id="promocodemodellable">
                            {{ trans('labels.proceed_as_guest_or_login') }}</h3>
                        <p class="mb-3 promocodemodellable-subtitel">{{ trans('labels.dont_have_account_guest') }}</p>
                    </div>
                    <div class="col-md-12 col-lg-4 col-xl-3">
                        <a onclick="login()"
                            class="btn btn-store-outline mb-3">{{ trans('labels.login_with_your_account') }}</a>

                        <a href="{{ URL::to(@$storeinfo->slug . '/checkout') }}"
                            class="btn btn-store">{{ trans('labels.continue_as_guest') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Login Model End -->

@include('front.theme.footer')

<script>
    var minorderamount = "{{ helper::appdata($storeinfo->id)->min_order_amount }}";
    var qtycheckurl = "{{ URL::to($storeinfo->slug.'/qtycheckurl')}}";
    function checkminorderamount(subtotal, checkouturl) {
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            url: qtycheckurl,
            method: "post",
            data: {
                vendor_id: "{{$storeinfo->id}}"
            },
            success: function(data) {
                if (data.status == 1) {
                    if (parseInt(minorderamount) <= parseInt(subtotal)) {
                        if (checkouturl != null && checkouturl != "") {
                            location.href = checkouturl;
                        } else {
                            $('#loginmodel').modal('show');
                        }
                    } else {
                        toastr.error('{{ trans('messages.min_order_amount_required') }}' + minorderamount);
                    }
                }else{
                    toastr.error(data.message);
                }
            },
            error: function(data) {
                toastr.error(wrong);
                return false;
            }
        });

    }

    function login() {
        $('#loginmodel').modal('hide');
        var offcanvasElement = document.getElementById("loginpage");
        var offcanvas = new bootstrap.Offcanvas(offcanvasElement);
        offcanvas.toggle();
    }
</script>
