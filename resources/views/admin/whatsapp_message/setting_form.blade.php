<div id="whatsappmessagesettings">
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 box-shadow">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="text-uppercase">
                            {{ trans('labels.whatsapp_message_settings') }}
                        </h5>
                    </div>
                    <form method="POST"
                        action="{{ URL::to('admin/settings/whatsapp_update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label
                                        class="form-label fw-bold">{{ trans('labels.order_variable') }}
                                    </label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0">Order No :
                                                    <code>{order_no}</code>
                                                </li>
                                                <li class="list-group-item px-0">Payment type :
                                                    <code>{payment_type}</code>
                                                </li>
                                                <li class="list-group-item px-0">Subtotal :
                                                    <code>{sub_total}</code>
                                                </li>
                                                <li class="list-group-item px-0">Total Tax :
                                                    <code>{total_tax}</code>
                                                </li>
                                                <li class="list-group-item px-0">Delivery
                                                    charge : <code>{delivery_charge}</code></li>
                                                <li class="list-group-item px-0">Discount
                                                    amount : <code>{discount_amount}</code></li>
                                                <li class="list-group-item px-0">Grand total :
                                                    <code>{grand_total}</code>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0">Customer name
                                                    : <code>{customer_name}</code></li>
                                                <li class="list-group-item px-0">Customer
                                                    mobile : <code>{customer_mobile}</code></li>
                                                <li class="list-group-item px-0">Address :
                                                    <code>{address}</code>
                                                </li>
                                                <li class="list-group-item px-0">Building :
                                                    <code>{building}</code>
                                                </li>
                                                <li class="list-group-item px-0">Landmark :
                                                    <code>{landmark}</code>
                                                </li>
                                                <li class="list-group-item px-0">Postal code :
                                                    <code>{postal_code}</code>
                                                </li>
                                                <li class="list-group-item px-0">Delivery type
                                                    : <code>{delivery_type}</code></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-4">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0">Notes :
                                                    <code>{notes}</code>
                                                </li>
                                                <li class="list-group-item px-0">Item Variable
                                                    : <code>{item_variable}</code></li>
                                                <li class="list-group-item px-0">Time :
                                                    <code>{time}</code>
                                                </li>
                                                <li class="list-group-item px-0">Date :
                                                    <code>{date}</code>
                                                </li>
                                                <li class="list-group-item px-0">Store name :
                                                    <code>{store_name}</code>
                                                </li>
                                                <li class="list-group-item px-0">Store URL :
                                                    <code>{store_url}</code>
                                                </li>
                                                <li class="list-group-item px-0">Track order
                                                    URL : <code>{track_order_url}</code></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label
                                        class="form-label fw-bold">{{ trans('labels.item_variable') }}
                                    </label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0">Item name :
                                                    <code>{item_name}</code>
                                                </li>
                                                <li class="list-group-item px-0">QTY :
                                                    <code>{qty}</code>
                                                </li>
                                                <li class="list-group-item px-0">Variants :
                                                    <code>{variantsdata}</code>
                                                </li>
                                                <li class="list-group-item px-0">Item price :
                                                    <code>{item_price}</code>
                                                </li>
                                                <li class="list-group-item px-0">
                                                    <input type="text" name="item_message"
                                                        class="form-control"
                                                        placeholder="{{ trans('labels.item_message') }}"
                                                        value="{{ @$settingdata->item_message }}">
                                                    @error('item_message')
                                                        <span class="text-danger"
                                                            id="timezone_error">{{ $message }}</span>
                                                    @enderror
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label
                                        class="form-label fw-bold">{{ trans('labels.whatsapp_message') }}
                                        <span class="text-danger"> * </span> </label>
                                    <textarea class="form-control" required="required" name="whatsapp_message" cols="50" rows="10">{{ @$settingdata->whatsapp_message }}</textarea>
                                    @error('whatsapp_message')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ trans('labels.contact') }}<span
                                            class="text-danger"> * </span></label>
                                    <input type="text" class="form-control numbers_only"
                                        name="contact" value="{{ @$settingdata->whatsapp_number }}"
                                        placeholder="{{ trans('labels.contact') }}" required>
                                    @error('contact')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group text-end">
                                <button class="btn btn-secondary  {{ Auth::user()->type == 4 ? (helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'add') == 1 || helper::check_access('role_settings', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1? '' : 'd-none') : '' }}"
                                    @if (env('Environment') == 'sendbox') type="button" onclick="myFunction()" @else type="submit" @endif>{{ trans('labels.save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>