@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.privacypolicy') }}</h5>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <div id="privacy-policy-three" class="privacy-policy">
                        <form action="{{ URL::to('admin/privacy-policy/update') }}" method="post">
                            @csrf
                            <textarea class="form-control" id="ckeditor" name="privacypolicy">{{ @$getprivacypolicy->privacypolicy_content }}</textarea>
                            @error('privacypolicy')
                                <span class="text-danger">{{ $message }}</span><br>
                            @enderror
                            <div class="form-group text-end">
                                <button class="btn btn-secondary my-2 {{ Auth::user()->type == 4 ? (helper::check_access('role_cms_pages', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_cms_pages', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace('ckeditor');
    </script>
@endsection