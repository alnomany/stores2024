<div class=" col-xl-3 col-lg-4 col-xxl-3 mb-3 mb-lg-0">
    <div class="card-v bg-light border-0 h-100 p-3 rounded d-none d-lg-block">
        <div class="title-and-image border-bottom pb-3">
            <div class="user-image">
                <img src="{{ helper::image_path(@Auth::user()->image) }}" alt=""
                    class="object-fit-cover img-fluid">
            </div>
            <div class="mx-3">
                <h5 class="title my-0 line-1">{{ @Auth::user()->name }}</h5>
                <p class="fs-7 text-muted">{{ @Auth::user()->email }}</p>
            </div>
        </div>
        <div class="user-list-saide-bar mt-4">
            <ul class="p-0 m-0">
                <a href="{{ URL::to($storeinfo->slug . '/profile/') }}" class="settings-link">
                    <li
                        class="list-unstyled border-0 my-2 p-3 rounded {{ request()->is($storeinfo->slug . '/profile*') ? 'active-menu' : '' }}">
                        <i class="fa-light fa-user"></i><span class="px-3">{{ trans('labels.profile') }}</span>
                        <i class="fa-solid fa-angle-right float-end"></i>
                    </li>
                </a>
                @if (helper::appdata($storeinfo->id)->online_order == 1)
                    <a href="{{ URL::to($storeinfo->slug . '/orders/') }}" class="settings-link ">
                        <li
                            class="list-unstyled  border-0 my-2 p-3 rounded {{ request()->is($storeinfo->slug . '/orders*') ? 'active-menu' : '' }}">
                            <i class="fa-light fa-list-check"></i><span
                                class="px-3">{{ trans('labels.orders') }}</span>
                            <i class="fa-solid fa-angle-right float-end"></i>
                        </li>
                    </a>
                @endif
                <a href="{{ URL::to($storeinfo->slug . '/wishlist/') }}" class="settings-link ">
                    <li
                        class="list-unstyled  border-0 my-2 p-3 rounded {{ request()->is($storeinfo->slug . '/wishlist') ? 'active-menu' : '' }}">
                        <i class="fa-light fa-heart"></i><span class="px-3">{{ trans('labels.wishlist') }}</span>
                        <i class="fa-solid fa-angle-right float-end"></i>
                    </li>
                </a>
                <a href="{{ URL::to($storeinfo->slug . '/change-password/') }}" class="settings-link">
                    <li
                        class="list-unstyled  border-0 my-2 p-3 rounded {{ request()->is($storeinfo->slug . '/change-password*') ? 'active-menu' : '' }}">
                        <i class="fa-light fa-key"></i><span
                            class="px-3">{{ trans('labels.change_password') }}</span>
                        <i class="fa-solid fa-angle-right float-end"></i>
                    </li>
                </a>
                <a href="{{ URL::to($storeinfo->slug . '/delete-password/') }}" class="settings-link ">
                    <li
                        class="list-unstyled  border-0 my-2 p-3 rounded {{ request()->is($storeinfo->slug . '/delete-password*') ? 'active-menu' : '' }}">
                        <i class="fa-light fa-trash"></i><span
                            class="px-3">{{ trans('labels.delete_profile') }}</span>
                        <i class="fa-solid fa-angle-right float-end"></i>
                    </li>
                </a>
                <a href="javascript:void(0)" onclick="deletedata('{{ URL::to($storeinfo->slug . '/logout/') }}')"
                    class="settings-link ">
                    <li class="list-unstyled  border-0 my-2 p-3 rounded">
                        <i class="fa-light fa-arrow-right-from-bracket"></i><span
                            class="px-3">{{ trans('labels.logout') }}</span>
                        <i class="fa-solid fa-angle-right float-end"></i>
                    </li>
                </a>
            </ul>
        </div>
    </div>

    <div class="accordion d-lg-none" id="accordionExample">
        <div class="accordion-item">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed fw-500 bg-light d-flex gap-2 align-items-center text-dark"
                    type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false"
                    aria-controls="collapseTwo">
                    <i class="fa-light fa-bars-staggered"></i>
                    Dashboard Navigation
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <ul class="m-0 p-0">
                        <li class="list-unstyled border-0 rounded">
                            <a href="{{ URL::to($storeinfo->slug . '/profile/') }}"
                                class="border d-block mb-3 p-3 rounded-2 active">
                                <i class="fa-light fa-user"></i>
                                <span class="px-2">{{ trans('labels.profile') }}</span>
                            </a>
                        </li>
                        <li class="list-unstyled border-0 rounded">
                            <a href="{{ URL::to($storeinfo->slug . '/orders/') }}"
                                class="border d-block mb-3 p-3 rounded-2">
                                <i class="fa-light fa-list-check"></i>
                                <span class="px-2">{{ trans('labels.orders') }}</span>
                            </a>
                        </li>
                        <li class="list-unstyled border-0 rounded">
                            <a href="{{ URL::to($storeinfo->slug . '/change-password/') }}"
                                class="border d-block mb-3 p-3 rounded-2">
                                <i class="fa-light fa-key"></i>
                                <span class="px-2">{{ trans('labels.change_password') }}</span>
                            </a>
                        </li>
                        <li class="list-unstyled border-0 rounded">
                            <a href="{{ URL::to($storeinfo->slug . '/delete-password/') }}"
                                class="border d-block mb-3 p-3 rounded-2">
                                <i class="fa-light fa-trash"></i>
                                <span class="px-2">{{ trans('labels.delete_profile') }}</span>
                            </a>
                        </li>
                        <li class="list-unstyled border-0 rounded">
                            <a href="javascript:void(0)"
                                onclick="deletedata('{{ URL::to($storeinfo->slug . '/logout/') }}')"
                                class="border d-block mb-3 p-3 rounded-2">
                                <i class="fa-light fa-arrow-right-from-bracket"></i>
                                <span class="px-2">{{ trans('labels.logout') }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
