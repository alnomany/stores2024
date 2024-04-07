@include('front.theme.header')

<section class="breadcrumb-sec">

    <div class="container">

        <nav aria-label="breadcrumb">

            <h2 class="breadcrumb-title mb-2">{{ trans('labels.refund_policy') }}</h2>

            <ol class="breadcrumb justify-content-center">

                <li class="breadcrumb-item"><a class="text-dark"
                        href="{{URL::to($storeinfo->slug.'/')}}">{{trans('labels.home')}}</a>
                </li>

                <li class="text-muted breadcrumb-item active" aria-current="page">{{ trans('labels.refund_policy') }}</li>

            </ol>

        </nav>

    </div>

</section>

<section class="product-prev-sec product-list-sec">
    <div class="container">
        @if (@$policy->refund_policy != "")
            {!!@$policy->refund_policy!!}
        @else
            @include('front.no_data')
        @endif
    </div>
</section>

<!-- newsletter -->
@include('front.newsletter')

@include('front.theme.footer')