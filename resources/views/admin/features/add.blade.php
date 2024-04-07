@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.add_new') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ URL::to('admin/features') }}">{{ trans('labels.features') }}</a></li>
                <li class="breadcrumb-item active {{session()->get('direction') == 2 ? 'breadcrumb-rtl' : ''}}" aria-current="page">{{ trans('labels.add') }}</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <form action="{{URL::to('/admin/features/save')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group">
                                <label class="form-label">{{trans('labels.title')}}<span class="text-danger"> * </span></label>
                                <input type="text" class="form-control" name="title" value="{{old('title')}}" placeholder="{{trans('labels.title')}}" required>
                                @error('title')
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{trans('labels.description')}}<span class="text-danger"> * </span></label>
                                <textarea class="form-control" name="description"  placeholder="{{trans('labels.description')}}" rows="5" required>{{old('description')}}</textarea>
                                @error('description')
                                <span class="text-danger">{{ $message }}</span> 
                            @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{trans('labels.image')}}<span class="text-danger"> * </span></label>
                                <input type="file" class="form-control" name="image"  placeholder="{{trans('labels.image')}}" required>
                                
                            </div>
                        </div>
                        <div class="form-group text-end">
                            <a href="{{ URL::to('admin/features') }}"
                                class="btn btn-outline-danger">{{ trans('labels.cancel') }}</a>
                            <button
                                @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif
                                class="btn btn-secondary ">{{ trans('labels.save') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection