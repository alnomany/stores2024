@extends('admin.layout.default')
@section('content')
    <div class="d-flex mb-3">
        <h5 class="text-uppercase">{{ trans('labels.dashboard') }}</h5>
    </div>
    <div class="row">
        @php
            if(Auth::user()->type == 4){
                $vendor_id = Auth::user()->vendor_id;
            }else{
                $vendor_id = Auth::user()->id;
            }
        @endphp
        @if (Auth::user()->type == 1)
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-regular fa-user fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <p class="text-muted fw-medium mb-1">{{ trans('labels.users') }}</p>
                                <h4>{{ $totalvendors }}</h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-regular fa-medal fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                                <p class="text-muted fw-medium mb-1">{{ trans('labels.pricing_plans') }}</p>
                                <h4>{{ $totalplans }}</h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        @if (Auth::user()->type == 2 || Auth::user()->type == 4)
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-solid fa-list-timeline fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <p class="text-muted fw-medium mb-1">{{ trans('labels.products') }}</p>
                                <h4>{{ $totalvendors }}</h4>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                <div class="card border-0 box-shadow h-100">
                    <div class="card-body">
                        <div class="dashboard-card">
                            <span class="card-icon">
                                <i class="fa-regular fa-medal fs-5"></i>
                            </span>
                            <span class="{{ session()->get('direction') == '2' ? 'text-start' : 'text-end' }}">
                                <p class="text-muted fw-medium mb-1">{{ trans('labels.current_plan') }}</p>
                                @if (!empty($currentplanname))
                                    <h4> {{ @$currentplanname->name }} </h4>
                                @else
                                    <i class="fa-regular fa-exclamation-triangle h4 text-muted"></i>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            @if (Auth::user()->type == 1)
                                <i class="fa-solid fa-ballot-check fs-5"></i>
                            @else
                                <i class="fa-regular fa-cart-shopping fs-5"></i>
                            @endif
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-muted fw-medium mb-1">
                                {{ Auth::user()->type == 1 ? trans('labels.transaction') : trans('labels.orders') }}
                            </p>
                            <h4>{{ $totalorders }}</h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="dashboard-card">
                        <span class="card-icon">
                            <i class="fa-regular fa-money-bill-1-wave fs-5"></i>
                        </span>
                        <span class="{{ session()->get('direction') == 2 ? 'text-start' : 'text-end' }}">
                            <p class="text-muted fw-medium mb-1">{{ trans('labels.revenue') }}</p>
                            <h4>{{ helper::currency_formate($totalrevenue, $vendor_id) }}</h4>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title">{{ trans('labels.revenue') }}</h5>
                        <select class="form-select form-select-sm w-auto" id="revenueyear"
                            data-url="{{ URL::to('/admin/dashboard') }}">
                            @if (count($revenue_years) > 0 && !in_array(date('Y'), array_column($revenue_years->toArray(), 'year')))
                                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                            @endif
                            @forelse ($revenue_years as $revenue)
                                <option value="{{ $revenue->year }}" {{ date('Y') == $revenue->year ? 'selected' : '' }}>
                                    {{ $revenue->year }}
                                </option>
                            @empty
                                <option value="" selected disabled>{{ trans('labels.select') }}</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="revenuechart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card border-0 box-shadow h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="card-title">
                            {{ Auth::user()->type == 1 ? trans('labels.users') : trans('labels.orders') }}</h5>
                        <select class="form-select form-select-sm w-auto" id="doughnutyear"
                            data-url="{{ request()->url() }}">
                            @if (count($doughnut_years) > 0 && !in_array(date('Y'), array_column($doughnut_years->toArray(), 'year')))
                                <option value="{{ date('Y') }}" selected>{{ date('Y') }}</option>
                            @endif
                            @forelse ($doughnut_years as $useryear)
                                <option value="{{ $useryear->year }}"
                                    {{ date('Y') == $useryear->year ? 'selected' : '' }}>{{ $useryear->year }}
                                </option>
                            @empty
                                <option value="" selected disabled>{{ trans('labels.select') }}</option>
                            @endforelse
                        </select>
                    </div>
                    <div class="row">
                        <canvas id="doughnut"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h5 class="card-title text-uppercase">
            {{ Auth::user()->type == 1 ? trans('labels.today_transaction') : trans('labels.processing_orders') }}</h5>
        <div class="col-12">
            <div class="card border-0 my-3">
                <div class="card-body">
                    <div class="table-responsive">
                        @if (Auth::user()->type == 1)
                            @include('admin.dashboard.admintransaction')
                        @else
                            @include('admin.orders.orderstable')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!--- Admin -------- users-chart-script --->
    <!--- VendorAdmin -------- orders-count-chart-script --->
    <script type="text/javascript">
        var doughnut = null;
        var doughnutlabels = {{ Js::from($doughnutlabels) }};
        var doughnutdata = {{ Js::from($doughnutdata) }};
    </script>
    <!--- Admin ------ revenue-by-plans-chart-script --->
    <!--- vendorAdmin ------ revenue-by-orders-script --->
    <script type="text/javascript">
        var revenuechart = null;
        var labels = {{ Js::from($revenuelabels) }};
        var revenuedata = {{ Js::from($revenuedata) }};
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/dashboard.js') }}"></script>
@endsection
