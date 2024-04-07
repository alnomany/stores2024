@include('front.theme.header')
<!------ breadcrumb ------>
<section class="breadcrumb-sec">

    <div class="container">

        <nav aria-label="breadcrumb">

            <h2 class="breadcrumb-title text-center mb-2">{{ trans('labels.profile') }}</h2>

            <ol class="breadcrumb justify-content-center">

                <li class="breadcrumb-item"><a class="text-dark"
                        href="{{URL::to($storeinfo->slug.'/')}}">{{trans('labels.home')}}</a>
                </li>

                <li class="text-muted breadcrumb-item active" aria-current="page">{{ trans('labels.profile') }}</li>

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
                                    <h5 class="mb-0"><i class="fa-regular fa-user"></i><span class="px-2">{{ trans('labels.profile') }}</span></h5>
                                </div>
                                <div class="settings-box-body p-3">
                                    <form id="deatilsForm" action="{{ URL::to($storeinfo->slug . '/updateprofile/') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" value="{{ Auth::user()->id }}" name="id">
                                        <div class="row row-cols-1 row-cols-sm-2 g-3 mb-3">
                                            <div class="col-12">
                                                <label class="form-label label14">{{ trans('labels.name') }} <span class="required">*</span></label>
                                                <input type="text" name="name" class="form-control p-3 rounded-5" placeholder="{{ trans('labels.name') }}" value="{{ Auth::user()->name }}" required="">
                                            </div>
                                            <div class="col-12">
                                                <label class="form-label label14">{{ trans('labels.email') }}<span class="required">*</span></label>
                                                <input type="email" name="email" class="form-control p-3 rounded-5 mb-0" placeholder="{{ trans('labels.email') }}" value="{{ Auth::user()->email }}">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label label14">{{ trans('labels.mobile') }} <span class="required">*</span></label>
                                            <input type="text" name="mobile" class="form-control p-3 rounded-5" placeholder="{{ trans('labels.mobile') }}" value="{{ Auth::user()->mobile }}">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label label14">{{ trans('labels.image') }}  </label>
                                            <input type="file" name="profile" class="form-control p-3 rounded-5" >
                                            @error('profile')
                                                <span class="text-danger">{{ $message }} <br></span>
                                            @enderror
                                            <img class="rounded-circle object-fit-cover mt-3" src="{{ helper::image_path(Auth::user()->image) }}"
                                                alt="" width="70" height="70">
                                           
                                        </div>
                                        <div class="d-flex justify-content-end">
                                            <button class="btn btn-store">{{ trans('labels.save') }}</button>
                                        </div>
                                    </form>
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

