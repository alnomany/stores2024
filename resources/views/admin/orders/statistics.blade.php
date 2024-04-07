<div class="row my-3">

    <div class="col-lg-3 col-md-4 col-sm-6 my-1">
        <div class="card box-shadow h-100 {{ request()->get('status') == '' ? 'border border-primary' : 'border-0' }}">
            @if (request()->is('admin/report'))
                <a
                    href="{{ URL::to(request()->url() . '?status=&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                @elseif(request()->is('admin/orders'))
                    <a href="{{ URL::to('admin/orders?status=') }}">
                    @elseif(request()->is('admin/customers/orders*'))
                        <a href="{{ URL::to('admin/customers/orders-' . @$userinfo->id . '?status=') }}">
            @endif
            <div class="card-body">
                <div class="dashboard-card">
                    <span class="card-icon">
                        <i class="fa fa-shopping-cart"></i>
                    </span>
                    <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                        <p class="text-muted fw-medium mb-1">{{ trans('labels.total_orders') }}</p>
                        <h4>{{ $totalorders }}</h4>
                    </span>
                </div>
            </div>
            </a>
        </div>
    </div>
    @if (helper::appdata($vendor_id)->product_type == 1)
        @if (request()->is('admin/orders') || request()->is('admin/customers/orders*'))
            <div class="col-lg-3 col-md-4 col-sm-6 my-1">
                <div
                    class="card box-shadow h-100 {{ request()->get('status') == 'processing' ? 'border border-primary' : 'border-0' }}">
                    @if (request()->is('admin/report'))
                        <a
                            href="{{ URL::to(request()->url() . '?status=processing&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                        @elseif(request()->is('admin/orders'))
                            <a href="{{ URL::to('admin/orders?status=processing') }}">
                            @elseif(request()->is('admin/customers/orders*'))
                                <a
                                    href="{{ URL::to('admin/customers/orders-' . @$userinfo->id . '?status=processing') }}">
                    @endif
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa fa-hourglass"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-muted fw-medium mb-1">{{ trans('labels.processing') }}</p>
                                <h4>{{ $totalprocessing }}</h4>
                            </span>
                        </div>
                    </div>
                    </a>
                </div>
            </div>
        @endif
        <div class="col-lg-3 col-md-4 col-sm-6 my-1">
            <div
                class="card box-shadow h-100 {{ request()->get('status') == 'delivered' ? 'border border-primary' : 'border-0' }}">
                @if (request()->is('admin/report'))
                    <a
                        href="{{ URL::to(request()->url() . '?status=delivered&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                    @elseif(request()->is('admin/orders'))
                        <a href="{{ URL::to('admin/orders?status=delivered') }}">
                        @elseif(request()->is('admin/customers/orders*'))
                            <a href="{{ URL::to('admin/customers/orders-' . @$userinfo->id . '?status=delivered') }}">
                @endif
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-check"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.delivered') }}</p>
                            <h4>{{ $totalcompleted }}</h4>
                        </span>
                    </div>
                </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 my-1">
            <div
                class="card box-shadow h-100 {{ request()->get('status') == 'cancelled' ? 'border border-primary' : 'border-0' }}">
                @if (request()->is('admin/report'))
                    <a
                        href="{{ URL::to(request()->url() . '?status=cancelled&startdate=' . request()->get('startdate') . '&enddate=' . request()->get('enddate')) }}">
                    @elseif(request()->is('admin/orders'))
                        <a href="{{ URL::to('admin/orders?status=cancelled') }}">
                        @elseif(request()->is('admin/customers/orders*'))
                            <a href="{{ URL::to('admin/customers/orders-' . @$userinfo->id . '?status=cancelled') }}">
                @endif
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa fa-close"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.cancelled') }}</p>
                            <h4>{{ $totalcancelled }}</h4>
                        </span>
                    </div>
                </div>
                </a>
            </div>
        </div>
    @endif

    @if (request()->is('admin/report*'))
        <div class="col-lg-3 col-md-4 col-sm-6 my-1">
            <div class="card box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa-regular fa-money-bill-1-wave"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.revenue') }}</p>
                            <h4>{{ helper::currency_formate($totalrevenue, $vendor_id) }}</h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
