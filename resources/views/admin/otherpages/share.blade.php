@extends('admin.layout.default')
@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.share') }}</h5>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <div class="card-block text-center">
                        <img src="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ URL::to('/') }}/{{ Auth::user()->slug }}&choe=UTF-8"
                            title="Link to Google.com" />
                        <div class="card-block">
                            <button class="btn btn-secondary mb-4" onclick="myFunction()">{{ trans('labels.share') }} <i
                                    class="fa-sharp fa-solid fa-share-nodes ms-2"></i></button>
                            <a href="https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl={{ URL::to('/') }}/{{ Auth::user()->slug }}&choe=UTF-8"
                                target="_blank" class="btn btn-secondary mb-4">{{ trans('labels.download') }} <i
                                    class="fa-solid fa-arrow-down-to-line ms-2"></i></a>
                            <div id="share-icons" class="d-none">
                                {!! $shareComponent !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function myFunction() {
            $('#share-icons').removeClass('d-none');
        }
    </script>
@endsection
