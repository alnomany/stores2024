<div class="header sticky-top">
    <div class="container">
        <div class="Navbar py-3">
            <div class="logo">
                <a href="{{ URL::to('/') }}">
                    <img src="{{ helper::image_path(helper::appdata('')->logo) }}" height="50" alt="">
                </a>
            </div>
            <div class="d-flex align-items-center ">
                @if (helper::available_language('')->count() > 1)
                    @if (App\Models\SystemAddons::where('unique_identifier', 'language')->first() != null &&
                            App\Models\SystemAddons::where('unique_identifier', 'language')->first()->activated == 1)
                        <div class=" language-button-icon mx-2 d-xl-none d-block">
                            <a href="#" class="">
                                <div class="p-0 dropdown">
                                    <a class=" dropdown-toggle mx-1 border-0 rounded-1 language-drop py-1 "
                                        href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-globe fs-4"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right mt-2"
                                        aria-labelledby="dropdownMenuLink">
                                        @foreach (Helper::available_language('') as $languagelist)
                                            <li>
                                                <a class="dropdown-item text-dark d-flex text-start"
                                                    href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                    <img src="{{ helper::image_path($languagelist->image) }}"
                                                        alt="" class="lag-img mx-1"> {{ $languagelist->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </div>
                                </div>
                            </a>
                        </div>

                    @endif
                @endif
                <div class="togl-btn">
                    <i class="fa-solid fa-bars"></i>
                </div>
            </div>

            <nav class=" {{ session()->get('direction') == 2 ? 'menu-2' : 'menu' }}">
                <!--deletebtn-start-->
                <div
                    class="{{ session()->get('direction') == 2 ? 'deletebtn-button-header-rtl' : 'deletebtn-button-header' }}">
                    <i class="fa-solid fa-xmark"></i>
                </div>
                <!--deletebtn-End-->
                <div class="menu-list-1152px-none mx-xxl-5 mx-2">
                    <ul class="navbar-nav flex-row">
                        <li class="nav-item dropdown px-3">
                            <a class="nav-link text-white fw-semibold active" href="{{ URL::to('/') }}" role="button">
                                {{ trans('landing.home') }}
                            </a>
                        </li>
                        <li class="nav-item dropdown px-3">
                            <a class="nav-link  text-white fw-semibold" href="{{ URL::to('/#features') }}"
                                role="button">
                                {{ trans('landing.features') }}
                            </a>
                        </li>
                        @if (App\Models\SystemAddons::where('unique_identifier', 'subscription')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'subscription')->first()->activated == 1)
                            <li class="nav-item dropdown px-3">
                                <a class="nav-link text-white fw-semibold" href="{{ URL::to('/#our-stores') }}"
                                    role="button">
                                    {{ trans('landing.our_stores') }}
                                </a>
                            </li>
                            <li class="nav-item dropdown px-3">
                                <a class="nav-link text-white fw-semibold" href="{{ URL::to('/#pricing-plans') }}"
                                    role="button">
                                    {{ trans('landing.pricing_plan') }}
                                </a>
                            </li>
                        @endif
                        @if (App\Models\SystemAddons::where('unique_identifier', 'blog')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'blog')->first()->activated == 1)
                            @if (helper::getblogs(1)->count() > 0)
                                <li class="nav-item dropdown px-3">
                                    <a class="nav-link text-white fw-semibold" href="{{ URL::to('/#blogs') }}"
                                        role="button">
                                        {{ trans('landing.blogs') }}
                                    </a>
                                </li>
                            @endif
                        @endif
                        <li class="nav-item dropdown px-3">
                            <a class="nav-link text-white fw-semibold" href="{{ URL::to('/#contact-us') }}"
                                role="button">
                                {{ trans('landing.contact_us') }}
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="header-btn d-flex align-items-center">
                    @if (helper::available_language('')->count() > 1)
                        @if (App\Models\SystemAddons::where('unique_identifier', 'language')->first() != null &&
                                App\Models\SystemAddons::where('unique_identifier', 'language')->first()->activated == 1)
                            <div class="px-3 dropdown rounded-2">
                                <a class="dropdown-toggle p-0 border-0 rounded-1 language-drop" href="#"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-globe fs-5"></i>
                                </a>

                                <ul
                                    class="dropdown-menu p-0 overflow-hidden rounded-2 drop-menu {{ session()->get('direction') == 2 ? 'drop-menu-rtl' : 'drop-menu' }}">
                                    @foreach (helper::available_language('') as $languagelist)
                                        <li>
                                            <a class="dropdown-item text-dark py-2 px-3 d-flex text-start"
                                                href="{{ URL::to('/lang/change?lang=' . $languagelist->code) }}">
                                                <img src="{{ helper::image_path($languagelist->image) }}"
                                                    alt="" class="lag-img mx-1">
                                                {{ $languagelist->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                    <a href="{{ URL::to('/admin') }}" target="_blank"
                        class="btn-secondary header-btn-login py-2 px-3 rounded-2">
                        {{ trans('landing.get_started') }}</a>
                </div>

            </nav>
        </div>
    </div>
</div>

@include('cookie-consent::index')
