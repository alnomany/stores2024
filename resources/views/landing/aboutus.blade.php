@extends('landing.layout.default')
@section('content')
<!-- BREADCRUMB AREA START -->
<section class="py-5 mb-5 bg-light">
    <div class="container">
        <nav aria-label="breadcrumb">
            <h3 class="breadcrumb-title fw-semibold mb-2 text-center">{{ trans('landing.about_us') }}</h3>
            <ol class="breadcrumb justify-content-center">
                <li class="{{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }}"><a
                        class="text-dark" href="{{ URL::to(@$vendordata->slug . '/') }}">{{ trans('labels.home') }}</a>
                </li>
                <li class="text-muted {{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }} active"
                    aria-current="page">{{ trans('landing.about_us') }}</li>
            </ol>
        </nav>
    </div>
</section>
<section>
    <div class="about-us-bg-color">
        <div class="container">
            <div class="about-us-main">
                @if (!empty($aboutus->about_content))
                    <div class="cms-section my-3">

                        {!! $aboutus->about_content !!}

                    </div>
                @else
                    @include('admin.layout.no_data')
                @endif
            </div>
        </div>
    </div>
</section>

    <!-- subscription -->
    @include('landing.newslatter')
@endsection
