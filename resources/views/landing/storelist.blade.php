@php
$i = 1;
@endphp

@foreach (helper::storedata() as $user)

<div class="col" data-aos="fade-up" data-aos-delay="{{$i++}}00" data-aos-duration="1000">
    <a href="{{URL::to($user->slug . '/')}}" target="_blank">
        <div class="card overflow-hidden rounded-0 view-all-hover h-100 rounded-2">
            <img src="{{ @helper::image_path(@$user->cover_image) }}"
                class="card-img-top rounded-0 object-fit-cover img-fluid object-fit-cover"
                height="185" alt="...">
            <div class="card-body p-sm-3 p-2">
                <h6 class="card-title fs-6 fw-semibold hotel-title">{{ @$user->website_title }}</h6>
            </div>
        </div>
    </a>
</div>
@endforeach