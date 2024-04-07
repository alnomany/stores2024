@foreach ($blogs as $blog)
<div class="item h-100 px-2 mb-1">
        <div class="card h-100">
            <div class="overflow-hidden">
                <img src="{{ helper::image_path($blog->image) }}"
                    class="card-img-top blog-card-top-img blog-card-hover" height="300" alt="...">
            </div>
            <div class="card-body pb-0">
                <div class="d-flex align-items-baseline">
                    <i class="fa-solid fa-calendar-days card-date"></i>
                    <p class="card-date px-2">{{ helper::date_format($blog->created_at) }}
                    </p>
                </div>
                <h5 class="card-title blog-card-title pt-2">
                    {{ $blog->title }}
                </h5>
            </div>
            <div class="card-footer pt-0 bg-white text-end border-top-0">
                <a href="{{URL::to('/blogdetail-'.$blog->slug)}}" class="text-primary-color fs-7">
                   {{ Str::contains(request()->url(), 'blog') ? trans('landing.read_more') : trans('landing.read_more') }} 
                   <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
</div>
@endforeach
