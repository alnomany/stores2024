@include('front.theme.header')
@if ($sliders->count() > 0)
    <div class="card border-0">
        <div class="furniture_home owl-carousel owl-theme">
            @foreach ($sliders as $slider)
                <div class="item"><img class="banner-bg" src=" {{ helper::image_path($slider->banner_image) }} "
                        alt="">
                    <div class="card-img-overlay banner-content">
                        <div class="container d-flex align-items-center justify-content-center z-9">
                            <div class="col-md-10">
                                <h3 class="banner-text mb-4">{{ $slider->title }}</h3>
                                <p class="banner-subtext mb-5">{{ $slider->description }}</p>
                                @if ($slider->product_id != 0 || $slider->category_id != 0)
                                    <div class="d-flex justify-content-center">
                                        @if ($slider->type == 1)
                                            <a href="{{ URL::to($storeinfo->slug . '/search?category=' . $slider['category_info']->slug) }}"
                                                class="btn btn-store">
                                            @elseif($slider->type == 2)
                                                <a onclick="GetProductOverview('{{ $slider->product_id }}')"
                                                    class="btn btn-store">
                                                @else
                                                    <a href="javascript:void(0)" class="btn btn-store">
                                        @endif
                                        {{ $slider->link_text }}</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@else
    <div class="furniture_home owl-carousel owl-theme">
        <div class="item"><img class="banner-bg"
                src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/banner-placeholder.png') }} "
                alt="">
        </div>
    </div>
@endif
@if ($bannerimage->count() > 0)
    <section class="feature-sec mt-4 my-lg-4">
        <div class="container">
            <div class="feature-carousel owl-carousel owl-theme m-0">
                @foreach ($bannerimage as $image)
                    @if ($image->type == 1)
                        <a href="{{ URL::to($storeinfo->slug . '/search?category=' . @$image['category_info']->slug) }}"
                            class="cursor-pointer">
                        @elseif($image->type == 2)
                            <a onclick="GetProductOverview('{{ $image->product_id }}')" class="cursor-pointer">
                            @else
                                <a href="javascript:void(0)" class="cursor-pointer">
                    @endif
                    <div class="item h-100">
                        <div class="feature-box h-100">
                            <img src='{{ helper::image_path($image->banner_image) }}' class="">
                        </div>
                    </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

@if (helper::getcategory($storeinfo->id)->count() > 0)
    <section class="product-prev-sec product-list-sec pt-0">
        <div class="container">
            <div class="product-rev-wrap row">
                <div class="card cat-aside cat-aside-theme1 col-xl-3 col-lg-3 d-none d-lg-block">
                    <div class="card-header cat-dispaly bg-transparent px-0">
                        <div class=" d-inline-block">
                            <h4 class="{{ session()->get('direction') == 2 ? 'text-right' : '' }} m-0 ">
                                {{ trans('labels.category') }} d</h4>
                        </div>
                    </div>
                    <div
                        class="cat-aside-wrap responsiv-cat-aside mt-2 {{ session()->get('direction') == 2 ? 'text-right' : '' }}">

                        @foreach (helper::getcategory($storeinfo->id) as $key => $category)
                            @php
                                $check_cat_count = 0;
                            @endphp

                            @foreach ($getitem as $item)
                                @if (in_array($category->id, explode('|', $item->cat_id)))
                                    @php
                                        $check_cat_count++;
                                    @endphp
                                @endif
                            @endforeach
                            @if ($check_cat_count > 0)
                                <div>
                                    <a href="#{{ $category->slug }}"
                                        class="border-top-no cat-check rounded-5 catinfo {{ session()->get('direction') == 2 ? 'cat-right-margin' : 'cat-left-margin' }} {{ $key == 0 ? 'active' : '' }}"
                                        data-tab="{{ $category->slug }}">
                                        <p class="line-1">{{ $category->name }}</p>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div
                    class="cat-product col-xl-9 col-lg-9 custom-categories-main-sec">
                    @foreach (helper::getcategory($storeinfo->id) as $key => $category)
                        @php
                            $check_cat_count = 0;
                        @endphp

                        @foreach ($getitem as $item)
                            @if (in_array($category->id, explode('|', $item->cat_id)))
                                @php
                                    $check_cat_count++;
                                @endphp
                            @endif
                        @endforeach

                        @if ($check_cat_count > 0)
                            <div class="card card-header responsive-padding bg-transparent px-0  custom-cat-name-sec mt-4 mb-2"
                                id="{{ $category->slug }}">
                                <div class=" d-inline-block">
                                    <h4
                                        class="sec-title {{ session()->get('direction') == 2 ? 'text-right mt-2' : '' }}">
                                        {{ $category->name }}<span class="px-2">({{ $check_cat_count }})</span>
                                    </h4>
                                </div>
                            </div>
                        @endif
                        <div class="row recipe-card custom-product-card g-2">
                            @if (!helper::getcategory($storeinfo->id)->isEmpty())
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
                                    @if (in_array($category->id, explode('|', $item->cat_id)))
                                        <div class="col-xl-3 col-md-4 responsive-col custom-product-column"
                                            id="pro-box">
                                            <div class="card pro-box h-100">

                                                <div class="pro-img">
                                                    @if (@$item['product_image']->image == null)
                                                        <img src="{{ url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/item-placeholder.png') }}"
                                                            class="cursor-pointer"
                                                            onclick="GetProductOverview('{{ $item->id }}')"
                                                            alt="product image">
                                                    @else
                                                        <img src="{{ @helper::image_path($item['product_image']->image) }}"
                                                            class="cursor-pointer"
                                                            onclick="GetProductOverview('{{ $item->id }}')"
                                                            alt="product image">
                                                    @endif

                                                    <div class="sale-heart">
                                                        @if ($off > 0)
                                                            <div class="sale-label-on">-{{ $off }}%</div>
                                                        @endif
                                                        @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                                                App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
                                                            @if (helper::appdata($storeinfo->id)->checkout_login_required == 1)
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
                                                    <div class="card-footer border-0 bg-transparent p-0">
                                                        @if (App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
                                                                App\Models\SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1)
                                                            @if (helper::appdata($storeinfo->id)->checkout_login_required == 1 &&
                                                                    helper::appdata($storeinfo->id)->product_ratting_switch == 1)
                                                                <p class="m-0 rating-star d-inline cursor-pointer"
                                                                    data-bs-toggle="offcanvas"
                                                                    data-bs-target="#ratingsidebar"
                                                                    onclick="rattingmodal('{{ $item->id }}','{{ $storeinfo->id }}','{{ $item->item_name }}')"
                                                                    aria-controls="offcanvasRight"><i
                                                                        class="fa-solid fa-star text-warning"></i><span
                                                                        class="px-1">{{ number_format($item->ratings_average, 1) }}</span>
                                                                </p>
                                                            @endif
                                                        @endif
                                                        <div class="d-flex align-items-baseline">
                                                            <p class="pro-pricing line-1">
                                                                @if ($item['variation']->count() > 0)
                                                                    {{ helper::currency_formate($item['variation'][0]->price, $storeinfo->id) }}
                                                                @else
                                                                    {{ helper::currency_formate($item->item_price, $storeinfo->id) }}
                                                                @endif
    
                                                            </p>
                                                            <p class="pro-pricing pro-org-value line-1">
                                                                @if ($item['variation']->count() > 0)
                                                                    {{ $item['variation'][0]->original_price ? helper::currency_formate($item['variation'][0]->original_price, $storeinfo->id) : '' }}
                                                                @else
                                                                    {{ $item->item_original_price > 0 ? helper::currency_formate($item->item_original_price, $storeinfo->id) : '' }}
                                                                @endif
    
                                                            </p>
                                                        </div>
                                                        <button class="btn btn-sm m-0 py-1 w-100 btn-content rounded-5"
                                                            onclick="GetProductOverview('{{ $item->id }}')">{{ helper::appdata($storeinfo->id)->online_order == 1 ? trans('labels.add_to_cart') : trans('labels.view') }}</button>
                                                    </div>

                                                </div>
                                                @if ($item->stock_management == 1)
                                                    @if (helper::checklowqty($item->id, $storeinfo->id) == 2 && $item->has_variants != 1)
                                                        <div class="item-stock text-center">
                                                            <div class="m-1">
                                                                <span
                                                                    class="bg-danger p-1 px-2 fs-8 rounded-1 text-white border border-white">{{ trans('labels.out_of_stock') }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endif

                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif



<!--------- storereview --------->
@include('front.testimonial')

<!-- blog -->
@if (helper::getblogs($storeinfo->id)->count() > 0)
    <section class="blog-6-sec">
        <div class="container">
            <div class="sec-header py-2">
                <h4 class="sec-title">{{ trans('labels.our_latest_blogs') }}</h4>
            </div>
            @php
                $blog = helper::getblogs($storeinfo->id);
            @endphp

            <!-- blogs -->
            @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                    @php
                        $checkplan = App\Models\Transaction::where('vendor_id', $storeinfo->id)
                            ->orderByDesc('id')
                            ->first();
                        if ($storeinfo->allow_without_subscription == 1) {
                            $blogs_allow = 1;
                        } else {
                            $blogs_allow = @$checkplan->blogs;
                        }
                    @endphp

                    @if ($blogs_allow == 1)
                        <div class="blog-6 owl-carousel owl-theme th-2-p">
                             @foreach($blog as $blog)
                                    <div class="item h-100">
                                        <div class="card border-0 h-100 rounded-3 overflow-hidden p-2">
                                            <div class="blog-6-img rounded-3">
                                                <a
                                                    href="{{ URL::to($storeinfo->slug . '/blogs-' . $blog->slug) }}">
                                                    <img src="{{ helper::image_path($blog->image) }}"
                                                        height="300" alt="blog img"
                                                        class="w-100 object-fit-cover rounded-3">
                                                </a>
                                            </div>
                                            <div class="card-body px-0 py-3">
                                                <h4 class="title line-2">
                                                    <a
                                                        href="{{ URL::to($storeinfo->slug . '/blogs-' . $blog->slug) }}">{{ $blog->title }}</a>
                                                </h4>
                                                <span class="blog-created">
                                                    <i class="fa-regular fa-calendar-days"></i>
                                                    <span
                                                        class="date">{{ helper::date_format($blog->created_at) }}</span>
                                                </span>
                                                <div class="description line-2">{!! Str::limit($blog->description, 200) !!}</div>
                                            </div>
                                        </div>
                                    </div>
                            @endforeach
                        </div>
                    @endif
                @endif
            @else
                @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                        App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                    <div class="blog-6 owl-carousel owl-theme th-2-p">
                        @foreach($blog as $blog)
                                <div class="item h-100">
                                    <div class="card border-0 h-100 rounded-3 overflow-hidden p-2">
                                        <div class="blog-6-img rounded-3">
                                            <a href="{{ URL::to($storeinfo->slug . '/blogs-' . $blog->slug) }}">
                                                <img src="{{ helper::image_path($blog->image) }}" height="300"
                                                    alt="blog img" class="w-100 object-fit-cover rounded-3">
                                            </a>
                                        </div>
                                        <div class="card-body px-0 py-3">
                                            <h4 class="title line-2">
                                                <a
                                                    href="{{ URL::to($storeinfo->slug . '/blogs-' . $blog->slug) }}">{{ $blog->title }}</a>
                                            </h4>
                                            <span class="blog-created">
                                                <i class="fa-regular fa-calendar-days"></i>
                                                <span
                                                    class="date">{{ helper::date_format($blog->created_at) }}</span>
                                            </span>
                                            <div class="description line-2">{!! Str::limit($blog->description, 200) !!}</div>
                                        </div>
                                    </div>
                                </div>
                         @endforeach
                    </div>
                @endif
            @endif
        </div>
    </section>
@endif


<!--------- newsletter --------->
@include('front.newsletter')

@include('front.theme.footer')
