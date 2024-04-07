@extends('landing.layout.default')

@section('content')
    <!-- BREADCRUMB AREA START -->
    <section class="py-5 mb-5 bg-light">
        <div class="container">
            <nav aria-label="breadcrumb">
                <h3 class="breadcrumb-title fw-semibold mb-2 text-center">{{ trans('landing.blog_section_title') }}</h3>
                <ol class="breadcrumb justify-content-center">
                    <li class="{{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }}"><a
                            class="text-dark" href="{{ URL::to(@$vendordata->slug . '/') }}">{{ trans('labels.home') }}</a>
                    </li>
                    <li class="text-muted {{ session()->get('direction') == 2 ? 'breadcrumb-item-rtl' : ' breadcrumb-item ' }} active"
                        aria-current="page">{{ trans('landing.blog_section_title') }}</li>
                </ol>
            </nav>
        </div>
    </section>
    <div class="container blog-container">
        <div class="blog-card my-3">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                @include('landing.blogcommonview')
            </div>
            <div class="d-flex justify-content-center mt-3">

                {!! $blogs->links() !!}

            </div>

        </div>
    </div>
    <!-- subscription -->
    @include('landing.newslatter')
@endsection
