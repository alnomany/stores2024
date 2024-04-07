@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp
@extends('admin.layout.default')
@section('content')
    <div class="d-flex align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.payment_settings') }}</h5>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="accordion accordion-flush sort_menu" id="accordionExample"
                        data-url="{{ url('admin/payment/reorder_payment') }}">
                        @php
                            $i = 1;
                        @endphp

                        @foreach ($getpayment as $key => $pmdata)
                            <form action="{{ URL::to('admin/payment/update') }}" method="POST" class="payments"
                                data-id="{{ $pmdata->id }}" enctype="multipart/form-data">
                                @csrf
                                @php
                                    $transaction_type = strtolower($pmdata->payment_type);
                                    $image_tag_name = $transaction_type . '_image';
                                @endphp
                                <input type="hidden" name="payment_id" value="{{ $pmdata->payment_type }}">
                                <input type="hidden" name="payment_name" value="{{ $transaction_type }}">
                                <div class="payment-accordian card rounded border mb-3 handle">
                                    <h2 class="card-header d-flex align-items-center rounded border-0 justify-content-between"
                                        id="heading{{ $transaction_type }}">
                                        <div>
                                            <img src="{{ helper::image_path($pmdata->image) }}" alt=""
                                                class="img-fluid rounded mx-2" height="30" width="30">
                                            <b>{{ $pmdata->payment_name }}</b>
                                            @if ($transaction_type == '7' || $transaction_type == '8' || $transaction_type == '9' || $transaction_type == '10')
                                                @if (env('Environment') == 'sendbox')
                                                    <span
                                                        class="badge badge bg-danger ms-2">{{ trans('labels.addon') }}</span>
                                                @endif
                                            @endif
                                        </div>
                                        <a class="cursor-pointer" tooltip="{{ trans('labels.move') }}"><i
                                                class="fa-light fa-up-down-left-right"></i></a>
                                    </h2>

                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label class="form-label">
                                                    {{ trans('labels.payment_name') }} <span class="text-danger">
                                                        *</span> </label>
                                                <input type="text" class="form-control" name="name"
                                                    placeholder="{{ trans('labels.payment_name') }}"
                                                    value="{{ $pmdata->payment_name }}" required>
                                            </div>
                                            @if ($transaction_type == '6')
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image" class="form-label">
                                                            {{ trans('labels.image') }} </label>
                                                        <input type="file" class="form-control" name="image">
                                                      
                                                        <img src="{{ helper::image_path($pmdata->image) }}" alt=""
                                                            class="img-fluid rounded hw-50 mt-1">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            {{ trans('labels.payment_description') }} <span
                                                                class="text-danger">
                                                                *</span></label>
                                                        <textarea class="form-control" id="ckeditor" name="payment_description">{{ $pmdata->payment_description }}</textarea>
                                                        @error('payment_description')
                                                            <span class="text-danger">{{ $message }}</span><br>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endif
                                            @if (in_array($transaction_type, ['2', '3', '4', '5', '7', '8', '9', '10']))
                                                <div class="col-md-6">
                                                    <p class="form-label">{{ trans('labels.environment') }}</p>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="environment[{{ $transaction_type }}]"
                                                            id="{{ $transaction_type }}_{{ $key }}_environment"
                                                            value="1"
                                                            {{ $pmdata->environment == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="{{ $transaction_type }}_{{ $key }}_environment">
                                                            {{ trans('labels.sandbox') }} </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio"
                                                            name="environment[{{ $transaction_type }}]"
                                                            id="{{ $transaction_type }}_{{ $i }}_environment"
                                                            value="2"
                                                            {{ $pmdata->environment == 2 ? 'checked' : '' }}>
                                                        <label class="form-check-label"
                                                            for="{{ $transaction_type }}_{{ $i }}_environment">
                                                            {{ trans('labels.production') }} </label>
                                                    </div>
                                                </div>

                                                <div
                                                    class="col-md-6 {{ $transaction_type == '7' ? 'd-none' : '' }}  {{ $transaction_type == '9' ? 'd-none' : '' }}">
                                                    <div class="form-group">
                                                        <label for="{{ $transaction_type }}_publickey" class="form-label">
                                                            {{ trans('labels.public_key') }} <span class="text-danger">
                                                                *</span></label>
                                                        <input type="text" id="{{ $transaction_type }}_publickey"
                                                            class="form-control" name="public_key[{{ $transaction_type }}]"
                                                            placeholder="{{ trans('labels.public_key') }}"
                                                            @if (env('Environment') == 'sendbox') value="*********" @else value="{{ $pmdata->public_key }}" @endif
                                                            {{ $transaction_type == '9' ? '' : 'required' }}>
                                                    </div>
                                                </div>
                                                <div
                                                    class=" {{ $transaction_type == '7' ? 'col-md-12' : 'col-md-6' }} {{ $transaction_type == '9' ? 'col-md-12' : 'col-md-6' }}">
                                                    <div class="form-group">
                                                        <label for="{{ $transaction_type }}_secretkey" class="form-label">
                                                            {{ trans('labels.secret_key') }} <span class="text-danger">
                                                                *</span></label>
                                                        <input type="text" id="{{ $transaction_type }}_secretkey"
                                                            class="form-control" name="secret_key[{{ $transaction_type }}]"
                                                            placeholder="{{ trans('labels.secret_key') }}"
                                                            @if (env('Environment') == 'sendbox') value="*********" @else value="{{ $pmdata->secret_key }}" @endif
                                                            required>
                                                    </div>
                                                </div>
                                                @if ($transaction_type == '4')
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="encryption_key"
                                                                class="form-label">{{ trans('labels.encryption_key') }}
                                                                <span class="text-danger"> *</span>
                                                            </label>
                                                            <input type="text" id="encryptionkey" class="form-control"
                                                                name="encryption_key"
                                                                placeholder="{{ trans('labels.encryption_key') }}"
                                                                @if (env('Environment') == 'sendbox') value="*********" @else
                                                                    value="{{ $pmdata->encryption_key }}" @endif
                                                                required>
                                                        </div>
                                                    </div>
                                                @endif
                                                @if ($transaction_type != '6')
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="image" class="form-label">
                                                                {{ trans('labels.image') }} </label>
                                                            <input type="file" class="form-control" name="image">
                                                           
                                                            <img src="{{ helper::image_path($pmdata->image) }}"
                                                                alt="" class="img-fluid rounded hw-50 mt-1">
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="{{ $transaction_type }}currency" class="form-label">
                                                            {{ trans('labels.currency') }}
                                                            <span class="text-danger"> *</span>
                                                        </label>
                                                        <input type="text" id="{{ $transaction_type }}currency"
                                                            class="form-control" name="currency[{{ $transaction_type }}]"
                                                            placeholder="{{ trans('labels.currency') }}"
                                                            value="{{ $pmdata->currency }}" required>
                                                    </div>
                                                </div>
                                            @elseif($transaction_type == 1)
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="image" class="form-label">
                                                            {{ trans('labels.image') }} </label>
                                                        <input type="file" class="form-control" name="image">
                                                     
                                                        <img src="{{ helper::image_path($pmdata->image) }}"
                                                            alt="" class="img-fluid rounded hw-50 mt-1">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="form-group d-flex justify-content-between align-items-center">
                                                <div>
                                                    <input id="checkbox-switch-{{ $transaction_type }}" type="checkbox"
                                                        class="checkbox-switch"
                                                        name="is_available[{{ $transaction_type }}]" value="1"
                                                        {{ $pmdata->is_available == 1 ? 'checked' : '' }}>
                                                    <label for="checkbox-switch-{{ $transaction_type }}" class="switch">
                                                        <span
                                                            class="{{ session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle' }}"><span
                                                                class="switch__circle-inner"></span></span>
                                                        <span
                                                            class="switch__left {{ session()->get('direction') == 2 ? 'pe-2' : 'ps-2' }}">{{ trans('labels.off') }}</span>
                                                        <span
                                                            class="switch__right {{ session()->get('direction') == 2 ? 'ps-2' : 'pe-2' }}">{{ trans('labels.on') }}</span>
                                                    </label>
                                                </div>
                                                <button
                                                    class="btn btn-secondary {{ Auth::user()->type == 4 ? (helper::check_access('role_payment_methods', Auth::user()->role_id, $vendor_id, 'add') == 1 || helper::check_access('role_payment_methods', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            $('.sort_menu').sortable({
                handle: '.handle',
                cursor: 'move',
                placeholder: 'highlight',
                axis: "y",
                header: "> div > h2",
                update: function(e, ui) {
                    var sortData = $('.sort_menu').sortable('toArray', {
                        attribute: 'data-id'
                    })
                    updateToDatabase(sortData.join(','))
                }
            })

            function updateToDatabase(idString) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: "POST",
                    dataType: "json",
                    url: $('#accordionExample').attr('data-url'),
                    data: {
                        ids: idString,
                    },
                    success: function(response) {
                        if (response.status == 1) {
                            toastr.success(response.msg);
                        } else {
                            toastr.success(wrong);
                        }
                    }
                });
            }

        })
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.12.1/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('ckeditor');
    </script>
    <script src="{{ url(env('ASSETPATHURL') . 'admin-assets/js/payment.js') }}"></script>
@endsection
