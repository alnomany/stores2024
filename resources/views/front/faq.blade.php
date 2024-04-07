@include('front.theme.header')
<section class="breadcrumb-sec">
    <div class="container">
        <nav aria-label="breadcrumb">
            <h2 class="breadcrumb-title mb-2">{{trans('labels.faqs')}}</h2>
            <ol class="breadcrumb justify-content-center">
                <li class="breadcrumb-item"><a class="text-dark"
                        href="{{URL::to($storeinfo->slug.'/')}}">{{trans('labels.home')}}</a>
                </li>
                <li class="text-muted breadcrumb-item active" aria-current="page">{{trans('labels.faqs')}}</li>
            </ol>
        </nav>
    </div>
</section>
<section class="mb-5">
    <div class="container">
        @if (helper::getfaqs($storeinfo->id)->count()>0)
        <div class="accordion faq-accordion" id="accordionExample">
            @foreach (helper::getfaqs($storeinfo->id) as $key => $faq)
            <div class="accordion-item mb-3">
                <h2 class="accordion-header">
                    <button class="accordion-button m-0" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                       {{$faq->question}}
                    </button>
                </h2>
                <div id="collapse{{$key}}" class="accordion-collapse collapse rounded-0 {{$key == 0 ? 'show' : ''}}"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <p> {{$faq->answer}}</p>
                    </div>
                </div>
            </div>
            @endforeach
           
        
        </div>
        @else
        @include('front.no_data')
        @endif
       
    </div>
</section>
<!-- newsletter -->
@include('front.newsletter')
<!-- newsletter -->
@include('front.theme.footer')
