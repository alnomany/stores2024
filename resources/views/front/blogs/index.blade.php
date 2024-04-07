@include('front.theme.header')

<section class="breadcrumb-sec">

    <div class="container">

        <nav aria-label="breadcrumb">

            <h2 class="breadcrumb-title mb-2">{{ trans('labels.latest-post') }}</h2>

            <ol class="breadcrumb justify-content-center">

                <li class="breadcrumb-item"><a class="text-dark"
                        href="{{URL::to($storeinfo->slug.'/')}}">{{trans('labels.home')}}</a>
                </li>

                <li class="text-muted breadcrumb-item active" aria-current="page">{{ trans('labels.latest-post') }}</li>

            </ol>

        </nav>

    </div>

</section>

<div class="blog-sec">
    <div class="container">
        @if ($getblog->count() > 0)
        <section class="mb-4">
            <div class="container">
                {{-- <h2 class="text-font text-center blog-titel">{{ trans('labels.latest-post') }}</h2> --}}
                <div class="row">
                    @foreach (helper::getblogs($storeinfo->id) as $blog)
                    <div class="col-md-6 col-lg-4 col-xl-3 d-flex mb-5 justify-content-sm-center">
                        <div class="card w-100 border-0 border-1">
                            <div class="img-overlay border rounded-4">
                                <img src="{{ helper::image_path($blog->image) }}" height="300"
                                    class="card-img-top rounded-4 object-fit-cover" alt="...">
                            </div>
                            <div class="card-body px-0 pb-2">
                                <p class="mb-2 line-2"> <a href="{{ URL::to($storeinfo->slug . '/blogs-' . $blog->slug) }}">{{ $blog->title }}</a></p>
                                <small class="card-text m-0 text-muted line-3">{!! Str::limit($blog->description, 100) !!}</small>
                            </div>
                            <div class="card-footer border-0 bg-white px-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p class="m-0 text-primary-color fw-medium fs-7 text-muted"><i class="fa-light fa-calendar-days"></i>
                                        {{ helper::date_format($blog->created_at) }}</p>
                                    <a href="{{ URL::to($storeinfo->slug . '/blogs-' . $blog->slug) }}"
                                        class="read-btn fs-7">{{ trans('labels.readmore') }}<span
                                            class="mx-1"><i class="{{ session()->get('direction') == 2 ? 'fa-regular fa-arrow-left' : 'fa-regular fa-arrow-right' }}"></i></span></a>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
                <div class="d-flex justify-content-center mt-3">
                    {!! $getblog->links() !!}
                </div>
            </div>
        </section>
    @else
        @include('front.no_data')
    @endif

    </div>

</div>


<!-- newsletter -->
@include('front.newsletter')
<!-- newsletter -->

@include('front.theme.footer')
