@extends('admin.layout.default')
@section('content')

    @if (env('Environment') == 'sendbox')
        <div class="alert alert-warning mt-3" role="alert">
            <p>Most of the addons listed below are free with extended license. So proceed with the purchase of <a
                    href="https://1.envato.market/Yg7YmB" target="_blank">extended license</a> for the script</p>
        </div>
        <div class="alert alert-warning" role="alert">
            <p>If you will purchase regular license, you can still use addons as per your needs</p>
        </div>
    @endif
    <div class="card mb-3 border-0 shadow">
        <div class="card-body py-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="card-title mb-1 fw-bold">Visit our store to purchase addons</h5>
                    <p class="text-muted fw-medium">Install our addons to unlock premium features</p>
                </div>
                <a href="https://rb.gy/s7gc5" target="_blank" class="btn btn-success">Visit Our Store</a>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.addons_manager') }}</h5>
        <div class="d-inline-flex">
            <a href="{{ URL::to('admin/createsystem-addons') }}" class="btn btn-secondary px-2 d-flex">
                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
        </div>
    </div>
    <div class="search_row">
        <div class="card border-0 box-shadow h-100">
            <div class="card-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link active" id="installed-tab" data-bs-toggle="tab" href="#installed" role="tab"
                            aria-controls="installed" aria-selected="true">{{ trans('labels.installed_addons') }}</a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="installed" role="tabpanel" aria-labelledby="installed-tab">
                        <div class="row">
                            @forelse(App\Models\SystemAddons::where('unique_identifier', '!=' ,'subscription')->get() as $key => $addon)
                                <div class="col-md-6 col-lg-3 mt-3 d-flex">
                                    <div class="card h-100 w-100">
                                        <img class="img-fluid" src='{!! asset('storage/app/public/addons/' . $addon->image) !!}' alt="">
                                        <div class="card-body">

                                            <h5 class="card-title">
                                                {{ $addon->name }}
                                            </h5>
                                            @if (env('Environment') == 'sendbox')
                                                @if ($addon->type == '1')
                                                    <span class="badge bg-primary mb-2 fw-400 fs-8">FREE WITH EXTENDED
                                                        LICENSE</span>
                                                @else
                                                    <span class="badge bg-danger mb-2 fw-400 fs-8">PREMIUM</span>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="card-footer">
                                            <p class="card-text d-inline">
                                                @if (env('Environment') == 'sendbox')
                                                    <small class="text-dark fw-bolder">{{ helper::currency_formate($addon->price, '') }}</small>
                                                @else
                                                    <small class="text-muted">{{ date('d M Y', strtotime($addon->created_at)) }}</small>
                                                @endif
                                            </p>
                                            @if ($addon->activated == 1)
                                                <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/systemaddons/status-' . $addon->id . '/2') }}')" @endif
                                                    class="btn btn-sm btn-success {{ session()->get('direction') == 2 ? 'float-start' : 'float-end' }}">{{ trans('labels.activated') }}</a>
                                            @else
                                                <a @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/systemaddons/status-' . $addon->id . '/1') }}')" @endif
                                                    class="btn btn-sm btn-danger {{ session()->get('direction') == 2 ? 'float-start' : 'float-end' }}">{{ trans('labels.deactivated') }}</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <!-- End Col -->
                            @empty
                                <div class="col col-md-12 text-center text-muted mt-4">
                                    <h4>{{ trans('labels.no_addon_installed') }}</h4>
                                    <a href="https://rb.gy/s7gc5" target="_blank" class="btn btn-success mt-4">Visit Our
                                        Store</a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
