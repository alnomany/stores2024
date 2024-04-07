@extends('admin.layout.default')

@section('content')

    <div class="d-flex justify-content-between align-items-center">

        <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>

        <nav aria-label="breadcrumb">

            <ol class="breadcrumb m-0">

                <li class="breadcrumb-item"><a href="{{ URL::to('admin/how_it_works') }}">{{ trans('labels.how_it_works') }}</a></li>

                <li class="breadcrumb-item active {{session()->get('direction') == 2 ? 'breadcrumb-rtl' : ''}}" aria-current="page">{{ trans('labels.edit') }}</li>

            </ol>

        </nav>

    </div>

    <div class="row mt-3">

        <div class="col-12">

            <div class="card border-0 box-shadow">

                <div class="card-body">

                    <form action="{{ URL::to('/admin/how_it_works/update-'.$data->id) }}" method="POST" enctype="multipart/form-data">

                        @csrf

                        <div class="row">

                            <div class="form-group col-md-6">

                                <label class="form-label">{{ trans('labels.title') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="text" class="form-control" name="title"

                                    value="{{ $data->title }}" placeholder="{{ trans('labels.title') }}"

                                    required>

                                @error('title')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>

                            <div class="form-group col-md-6">

                                <label class="form-label">{{ trans('labels.image') }}<span class="text-danger"> *

                                    </span></label>

                                <input type="file" class="form-control" name="image">
                                <img src="{{ helper::image_path($data->image)}}" class="img-fluid rounded hw-50 mt-1" alt="">

                            </div>

                            <div class="form-group">

                                <label class="form-label">{{ trans('labels.description') }}<span class="text-danger"> *

                                    </span></label>

                                <textarea class="form-control" name="description" rows="5" placeholder="{{ trans('labels.description') }}" required>{{$data->description}}</textarea>

                                @error('description')

                                    <span class="text-danger">{{ $message }}</span>

                                @enderror

                            </div>

                            

                        </div>

                        <div class="form-group text-end">

                            <a href="{{ URL::to('admin/how_it_works') }}"

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

