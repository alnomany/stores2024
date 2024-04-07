@include('front.theme.header')
<!------ breadcrumb ------>
<section class="breadcrumb-sec">
    <div class="container">
        <nav aria-label="breadcrumb">
            <h2 class="breadcrumb-title text-center mb-2">{{ trans('labels.profile') }}</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a class="text-dark" href="{{ URL::to($storeinfo->slug . '/') }}">Home</a>
                </li>
                <li class="text-muted breadcrumb-item active" aria-current="page">{{ trans('labels.wishlist') }}</li>
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
                    <div class="col-xl-3 col-lg-8 col-xxl-9 col-12">
                        <div class="card-v p-0 border rounded user-form">
                            <div class="settings-box">
                                <div class="settings-box-header border-bottom px-4 py-3">
                                    <h5 class="mb-0"><i class="fa-solid fa-heart"></i><span
                                            class="px-2">{{ trans('labels.wishlist') }}</span></h5>
                                </div>
                                @if ($getitem->count() > 0)
                                <div class="row recipe-card custom-product-card g-2 p-3">
                                    @foreach ($getitem as $item)
                                        @php
                                            if ($item['variation']->count() > 0) {
                                                $price = $item['variation'][0]->price;
                                                $original_price = $item['variation'][0]->original_price;
                                            } else {
                                                $price = $item->item_price;
                                                $original_price = $item->item_original_price;
                                            }
                                            $off = $original_price > 0 ? number_format(100 - ($price * 100) / $original_price, 1) : 0;
                                        @endphp
                                        <div class="col-xl-3 col-md-4 responsive-col custom-product-column"
                                            id="pro-box">
                                            <div class="pro-box">
                                                <div class="pro-img ">
                                                    @if (@$item['product_image']->image == null)
                                                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/item-placeholder.png') }}"
                                                            alt="product image">
                                                    @else
                                                        <img src="{{ @helper::image_path($item['product_image']->image) }}"
                                                            alt="product image">
                                                    @endif
                                                    <div class="sale-heart">
                                                        @if ($off > 0)
                                                            <div class="sale-label-on">-{{ $off }}%</div>
                                                        @endif
                                                        @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                                                App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
                                                            @if (helper::appdata($storeinfo->id)->checkout_login_required == 1 )
                                                                <a onclick="managefavorite('{{ $item->id }}',{{ $storeinfo->id }},'{{ URL::to(@$storeinfo->slug . '/managefavorite') }}')"
                                                                    class="btn-sm btn-Wishlist cursor-pointer {{ session()->get('direction') == 2 ? 'me-auto' : 'ms-auto' }}">
                                                                    @if (Auth::user() && Auth::user()->type == 3)
                                                                        @php
                                                                            $favorite = helper::ceckfavorite($item->id, $storeinfo->id, Auth::user()->id);
                                                                        @endphp
                                                                        @if (!empty($favorite) && $favorite->count() > 0)
                                                                            <i class="fa-solid fa-heart"></i>
                                                                        @else
                                                                            <i class="fa-regular fa-heart"></i>
                                                                        @endif
                                                                    @else
                                                                        <i class="fa-regular fa-heart"></i>
                                                                    @endif
                                                                </a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="product-details-wrap">
                                                    <div class="product-details-inner  mb-2 line-2">
                                                        <h4 id="itemname"
                                                            onclick="GetProductOverview('{{ $item->id }}')"
                                                            class=" {{ session()->get('direction') == 2 ? 'text-right' : '' }}">
                                                            {{ $item->item_name }}</h4>
                                                    </div>
                                                    @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                                            App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
                                                        @if (helper::appdata($storeinfo->id)->checkout_login_required == 1 && helper::appdata($storeinfo->id)->product_ratting_switch == 1)
                                                            <p class="m-0 rating-star d-inline"
                                                                data-bs-toggle="offcanvas"
                                                                data-bs-target="#ratingsidebar"
                                                                onclick="rattingmodal('{{ $item->id }}','{{ $storeinfo->id }}','{{ $item->item_name }}')"
                                                                aria-controls="offcanvasRight"><i
                                                                    class="fa-solid fa-star text-warning"></i><span
                                                                    class="px-1">{{ number_format($item->ratings_average, 1) }}</span>
                                                            </p>
                                                        @endif
                                                    @endif
                                                    <div class="d-flex align-items-baseline ">
                                                        <p class="pro-pricing line-1">
                                                            @if ($item['variation']->count() > 0)
                                                                {{ helper::currency_formate($item['variation'][0]->price, $storeinfo->id) }}
                                                            @else
                                                                {{ helper::currency_formate($item->item_price, $storeinfo->id) }}
                                                            @endif
                                                        </p>
                                                        <p class="pro-pricing pro-org-value line-1">
                                                            @if ($item['variation']->count() > 0)
                                                                {{ helper::currency_formate($item['variation'][0]->original_price, $storeinfo->id) }}
                                                            @else
                                                                {{ helper::currency_formate($item->item_original_price, $storeinfo->id) }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                    <button
                                                        class="btn btn-sm m-0 py-1 w-100 btn-content rounded-5" onclick="GetProductOverview('{{ $item->id }}')">{{ helper::appdata($storeinfo->id)->online_order == 1 ? trans('labels.add_to_cart') : trans('labels.view') }}</button>
                                                </div>
                                                @if (helper::checklowqty($item->id, $storeinfo->id) == 2 && $item->has_variants != 1)
                                                <div class="item-stock text-center"><span
                                                        class="bg-danger w-100 p-1 border border-white">{{ trans('labels.out_of_stock') }}</span>
                                                </div>
                                            @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="d-flex justify-content-center mt-3">
                                    {!! $getitem->links() !!}
                                </div>
                                @else
                                @include('front.no_data')
                                @endif
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
