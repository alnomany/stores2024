@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/extras') }}">{{ trans('labels.extras')
                        }}</a></li>
                <li class="breadcrumb-item active {{session()->get('direction') == 2 ? 'breadcrumb-rtl' : ''}}" aria-current="page">{{ trans('labels.edit') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{ URL::to('admin/extras/update-' . $editextras->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.name') }}<span class="text-danger"> *
                                    </span></label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ $editextras->name }}" placeholder="{{ trans('labels.name') }}" required>
                                @error('name')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group col-md-6">
                                <label class="form-label">{{ trans('labels.price') }} <span
                                        class="text-danger"> * </span></label>
                                <input type="text" class="form-control numbers_only" name="price"
                                    value="{{ $editextras->price }}"
                                    placeholder="{{ trans('labels.price') }}" id="price" required>
                                @error('price')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group text-end">
                                <a href="{{ URL::to('admin/extras') }}" class="btn btn-outline-danger">{{
                                    trans('labels.cancel') }}</a>
                                <button class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_global_extras', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}" @if (env('Environment') == 'sendbox') type="button"
                                    onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save')
                                    }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection