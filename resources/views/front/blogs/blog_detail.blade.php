@include('front.theme.header')

<section class="breadcrumb-sec">

    <div class="container">

        <nav aria-label="breadcrumb">

            <h2 class="breadcrumb-title mb-2">{{trans('labels.blog_details')}}</h2>

            <ol class="breadcrumb justify-content-center">

                <li class="breadcrumb-item"><a class="text-dark"
                        href="{{URL::to($storeinfo->slug.'/')}}">{{trans('labels.home')}}</a>
                </li>

                <li class="text-muted breadcrumb-item active" aria-current="page">{{ trans('labels.latest-post') }}</li>

                <li class="text-muted breadcrumb-item active" aria-current="page">{{ $blogdetail->title }}</li>

            </ol>

        </nav>

    </div>

</section>

<div class="blog-sec">
    <div class="container">
        <section class="blog-section">
            <div class="container">
                <div class="row mb-5">
                    <div class="blog-details px-0">
                        <div class="card border border-0">

                            <img src="{{ helper::image_path($blogdetail->image) }}"
                                class="card-img-top border blog-card-border">

                            <div class="card-body px-0">
                                <div class="row justify-content-between mb-3">
                                    <div class="col-auto text-muted">
                                        <span>{{ helper::date_format($blogdetail->created_at) }}</span>
                                    </div>
                                </div>
                                <p class="fs-4 mb-3">{{ $blogdetail->title }}</p>
                                <small class="text-muted card-text">{!! $blogdetail->description !!}</small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        @if ($getblog->count() > 0)
            <section class="mb-4">

                <div class="d-flex align-items-center justify-content-between">
                    <h2 class="text-font blog-titel m-0">{{ trans('labels.latest-post') }}</h2>
                    <a href="{{URL::to($storeinfo->slug.'/blogs')}}" class="btn btn-store mobile-btn">{{trans('labels.view_all')}}</a>
                </div>

                <div class="row">
                    @foreach ($getblog as $blog)
                        <div class="col-md-6 col-lg-4 col-xl-3 d-flex mt-3 justify-content-sm-center">
                            <div class="card w-100 border-0 border-1">
                                <div class="img-overlay border rounded-4 overflow-hidden">
                                    <img src="{{ helper::image_path($blog->image) }}" height="300"
                                        class="card-img-top" alt="...">
                                </div>
                                <div class="card-body px-0">
                                    <p class="mb-3 line-2">{{ $blog->title }}</p>
                                    <small class="card-text m-0 text-muted line-3">{!! Str::limit($blog->description, 100) !!}</small>
                                </div>
                                <div class="card-footer border-0 bg-white px-0">
                                    <div class="d-flex justify-content-between">
                                        <p class="m-0 text-primary-color fw-600 text-muted"><i
                                                class="fa-regular fa-calendar"></i>
                                            {{ helper::date_format($blog->created_at) }}</p>
                                        <a href="{{ URL::to($storeinfo->slug . '/blogs-' . $blog->slug) }}"
                                            class="read-btn">{{ trans('labels.readmore') }}<span class="mx-1"><i
                                                    class="{{ session()->get('direction') == 2 ? 'fa-regular fa-arrow-left' : 'fa-regular fa-arrow-right' }}"></i></span></a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            </section>
        @else
            @include('front.no_data')
        @endif
    </div>

</div>

@include('front.theme.footer')
