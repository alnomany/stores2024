<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="text-uppercase fw-500">
            <td></td>
            <td>{{ trans('labels.srno') }}</td>
            <td>{{ trans('labels.coupon_name') }}</td>
            <td>{{ trans('labels.coupon_code') }}</td>
            <td>{{ trans('labels.discount') }}</td>
            <td>{{ trans('labels.start_date') }}</td>
            <td>{{ trans('labels.end_date') }}</td>
            <td>{{ trans('labels.status') }}</td>
            <td>{{ trans('labels.created_date') }}</td>
            <td>{{ trans('labels.updated_date') }}</td>
            <td>{{ trans('labels.action') }}</td>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{ url('admin/coupons/reorder_coupon') }}">
        @php $i = 1; @endphp
        @foreach ($getpromocodeslist as $promocode)
            <tr class="fs-7  row1" id="dataid{{ $promocode->id }}" data-id="{{ $promocode->id }}">
                <td><a tooltip="{{ trans('labels.move') }}"><i class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                <td>@php echo $i++; @endphp</td>
                <td>{{ $promocode->offer_name }}</td>
                <td>{{ $promocode->offer_code }}</td>
                <td>{{ $promocode->offer_type == 1 ? helper::currency_formate($promocode->offer_amount, $vendor_id) : $promocode->offer_amount . '%' }}
                </td>
                <td><span class="badge bg-success">{{ helper::date_format($promocode->start_date) }}</span></td>
                <td><span class="badge bg-danger">{{ helper::date_format($promocode->exp_date) }}</span></td>
                <td>
                    @if ($promocode->is_available == '1')
                        <a href="javascript:void(0)" tooltip="{{ trans('labels.active') }}"
                            onclick="statusupdate('{{ URL::to('admin/coupons/status-' . $promocode->id . '/2') }}')"
                            class="btn btn-sm btn-outline-success mx-1 {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                class="fa-regular fa-check"></i> </a>
                    @else
                        <a href="javascript:void(0)" tooltip="{{ trans('labels.inactive') }}"
                            onclick="statusupdate('{{ URL::to('admin/coupons/status-' . $promocode->id . '/1') }}')"
                            class="btn btn-sm btn-outline-danger mx-1 {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}">
                            <i class="fa-regular fa-xmark"></i> </a>
                    @endif
                </td>
                <td>{{ helper::date_format($promocode->created_at) }}<br>
                    {{ helper::time_format($promocode->created_at,$vendor_id) }}
                </td>
                <td>{{ helper::date_format($promocode->updated_at) }}<br>
                    {{ helper::time_format($promocode->updated_at,$vendor_id) }}
                </td>
                <td>
                    <a href="{{ URL::to('admin/coupons/edit-' . $promocode->id) }}"
                        class="btn btn-outline-info btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"
                        tooltip="{{ trans('labels.edit') }}"> <i class="fa-regular fa-pen-to-square"></i></a>
                    <a href="javascript:void(0)"
                        onclick="deletedata('{{ URL::to('admin/coupons/delete-' . $promocode->id) }}')"
                        class="btn btn-outline-danger btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_coupons', Auth::user()->role_id, Auth::user()->vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}"
                        tooltip="{{ trans('labels.delete') }}"> <i class="fa-regular fa-trash"></i></a>
                    <a class="btn btn-sm btn-outline-secondary"
                        href="{{ URL::to('admin/coupons/details-' . $promocode->offer_code) }}"
                        tooltip="{{ trans('labels.view') }}"> <i class="fa-regular fa-eye"></i> </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
