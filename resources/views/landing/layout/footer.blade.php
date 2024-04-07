<footer>
    <div class="footer-bg-color overflow-hidden">
        <div class="container footer-container">
            <div class="footer-contain row row-cols-md-4">
                <div class="col-md-4 col-lg-4 mt-4 me-auto">
                    <div>
                        <a href="{{ URL::to('/') }}">
                            <img src="{{ helper::image_path(helper::appdata('')->logo) }}" height="50" alt="">
                        </a>
                        <p class="footer-contain mt-4 col-lg-10">
                            {{ trans('landing.footer_description') }}
                        </p>
                    </div>
                </div>
                <div class="col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-xl-4 footer-contain">
                            <div>
                                <p class="footer-title mb-2 mt-4">{{ trans('landing.pages') }}</p>
                                <p class="py-1 fs-7"><a
                                        href="{{ URL::to('/aboutus') }}">{{ trans('landing.about_us') }}</a></p>
                                <p class="py-1 fs-7"><a
                                        href="{{ URL::to('/privacypolicy') }}">{{ trans('landing.privacy_policy') }}</a>
                                </p>
                                <p class="py-1 fs-7"><a
                                        href="{{ URL::to('/refund_policy') }}">{{ trans('landing.refund_policy') }}</a>
                                </p>
                                <p class="py-1 fs-7"><a
                                        href="{{ URL::to('/termscondition') }}">{{ trans('landing.terms_conditions') }}</a>
                                </p>


                            </div>
                        </div>
                        <div class="col-md-3 col-lg-3 col-xl-4 footer-contain">
                            <div>
                                <p class="footer-title mb-2 mt-4">{{ trans('landing.other') }}</p>
                                @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                                    @if (helper::getblogs(1)->count() > 0)
                                        <p class="py-1 fs-7"><a
                                                href="{{ URL::to('/blogs') }}">{{ trans('landing.blogs') }}</a></p>
                                    @endif
                                @endif
                                <p class="py-1 fs-7"><a href="{{ URL::to('/faqs') }}">{{ trans('landing.faqs') }}</a>
                                </p>
                                @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                        App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                                    <p class="py-1 fs-7"><a
                                            href="{{ URL::to('/stores') }}">{{ trans('landing.our_stores') }}</a></p>
                                @endif
                                <p class="py-1 fs-7"><a
                                        href="{{ URL::to('/contact') }}">{{ trans('landing.contact_us') }}</a></p>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-5 col-xl-4 footer-contain">
                            <div>
                                <p class="footer-title mb-2 mt-4">{{ trans('landing.help') }}</p>
                                <p class="py-1 fs-7"><a href="mailto:{{ helper::appdata('')->email }}"><i
                                            class="fa-solid fa-envelope {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}"></i>{{ helper::appdata('')->email }}</a>
                                </p>
                                <p class="py-1 fs-7"><a href="tel:{{ helper::appdata('')->contact }}"><i
                                            class="fa-solid fa-phone {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}"></i>{{ helper::appdata('')->contact }}</a>
                                </p>
                                <p class="py-1 fs-7"><a href="tel:{{ helper::appdata('')->address }}"><i
                                            class="fa-solid fa-location-dot {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}"></i>{{helper::appdata('')->address}}</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!------ whatsapp_icon ------>

            @if (App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first() != null &&
                    App\Models\SystemAddons::where('unique_identifier', 'whatsapp_message')->first()->activated == 1)
                @if (helper::appdata('')->whatsapp_number != null && helper::appdata('')->whatsapp_number != '')
                    <input type="checkbox" id="check" class="d-none">
                    <label class="chat-btn {{ session()->get('direction') == 2 ? 'chat-btn_rtl' : 'chat-btn_ltr' }}"
                        for="check">
                        <i class="fa-brands fa-whatsapp comment"></i>
                        <i class="fa fa-close close"></i>
                    </label>
                    <div class="shadow {{ session()->get('direction') == 2 ? 'wrapper_rtl' : 'wrapper' }}">
                        <div class="msg_header">
                            <h6>{{ helper::appdata('')->website_title }}</h6>
                        </div>

                        <div class="text-start p-3 bg-msg">
                            <div class="card p-2 msg d-inline-block fs-7">
                                {{ trans('labels.how_can_help_you') }}
                            </div>
                        </div>

                        <div class="chat-form">

                            <form action="https://api.whatsapp.com/send" method="get" target="_blank"
                                class="d-flex align-items-center d-grid gap-2">
                                <textarea class="form-control m-0" name="text" placeholder="Your Text Message" cols="30" rows="10"
                                    required></textarea>
                                <input type="hidden" name="phone"
                                    value="{{ helper::appdata('')->whatsapp_number }}">
                                <button type="submit" class="btn-whatsapp btn-block m-0">
                                    <i class="fa-solid fa-paper-plane"></i>
                                </button>
                            </form>

                        </div>
                    </div>
                @endif
            @endif
            <hr class="text-white mt-5">
            <div class="d-md-flex justify-content-between align-items-center pb-2">
                <h5 class="copy-right-text m-0">{{ helper::appdata('')->copyright }}</h5>
                <ul class="footer_acceped_card d-flex justify-content-center gap-2 p-0 m-0 mt-3 mt-md-0">
                    @foreach (helper::getallpayment(1) as $item)
                        <li>
                            <a href="#">
                                <img src="{{ helper::image_path($item->image) }}" class="w-20px">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</footer>
