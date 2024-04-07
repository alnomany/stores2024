@extends('admin.layout.default')
@section('content')
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-uppercase">{{ trans('labels.edit') }}</h5>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{ URL::to('admin/faqs') }}">{{ trans('labels.faqs') }}</a></li>
                    <li class="breadcrumb-item active {{session()->get('direction') == 2 ? 'breadcrumb-rtl' : ''}}" aria-current="page">{{ trans('labels.edit') }}</li>
                </ol>
            </nav>
        </div>
        <div class="row mt-3">
            <div class="col-12">
                <div class="card border-0 box-shadow">
                    <div class="card-body">
                        <form action="{{ URL::to('/admin/faqs/update-' . $getfaq->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.question') }}<span class="text-danger"> *
                                        </span></label>
                                    <input type="text" class="form-control" name="question"
                                        value="{{ $getfaq->question }}" placeholder="{{ trans('labels.question') }}"
                                        required>
                                    @error('question')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.answer') }}<span class="text-danger"> *
                                        </span></label>
                                    <textarea class="form-control" name="answer" placeholder="{{ trans('labels.answer') }}" rows="5" required>{{ $getfaq->answer }}</textarea>
                                    @error('answer')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <a href="{{ URL::to('admin/faqs') }}"
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
