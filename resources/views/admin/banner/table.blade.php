<table class="table table-striped table-bordered py-3 zero-configuration w-100">
    <thead>
        <tr class="text-uppercase fw-500">
            <td></td>
            <td>{{ trans('labels.srno') }}</td>
            <td>{{ trans('labels.image') }}</td>
            <td>{{ trans('labels.category') }}</td>
            <td>{{ trans('labels.product') }}</td>
            @if ($section == 0)
                <td>{{ trans('labels.title') }}</td>
                <td>{{ trans('labels.description') }}</td>
                <td>{{ trans('labels.link_text') }}</td>
            @endif
            <td>{{ trans('labels.created_date') }}</td>
            <td>{{ trans('labels.updated_date') }}</td>
            <td>{{ trans('labels.action') }}</td>
        </tr>
    </thead>
    <tbody id="tabledetails" data-url="{{url('admin/'. $url.'/reorder_banner')}}">
        @php $i = 1; @endphp

        @foreach ($getbannerlist as $banner)
            @if ($banner->section == $section)
                <tr class="fs-7 row1" id="dataid{{$banner->id}}" data-id="{{$banner->id}}">
                    <td><a tooltip="{{ trans('labels.move') }}"><i
                        class="fa-light fa-up-down-left-right mx-2"></i></a></td>
                    <td>@php echo $i++; @endphp</td>
                    <td><img src="{{ helper::image_path($banner->banner_image) }}"
                            class="img-fluid rounded hw-50 object-fit-cover" alt="">
                    </td>
                    <td>{{ $banner->type == '1' ? @$banner['category_info']->name : '--' }}</td>
                    <td>{{ $banner->type == '2' ? @$banner['product_info']->item_name : '--' }}</td>
                    @if ($section == 0)
                        <td>{{ $banner->title }}</td>
                        <td>{{ $banner->description }}</td>
                        <td>{{ $banner->link_text }}</td>
                    @endif
                    <td>{{ helper::date_format($banner->created_at) }}<br>
                        {{ helper::time_format($banner->created_at,$vendor_id) }}
                      
                    </td>
                    <td>{{ helper::date_format($banner->updated_at) }}<br>
                        {{ helper::time_format($banner->updated_at,$vendor_id) }}
                    </td>
                    <td>
                        <a tooltip="{{ trans('labels.edit') }}"
                            href="{{ URL::to('admin/' . $url . '/edit-' . $banner->id) }}"
                            class="btn btn-outline-info btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_banner', Auth::user()->role_id, $vendor_id, 'edit') == 1 || helper::check_access('role_sliders', Auth::user()->role_id, $vendor_id, 'edit') == 1 ? '' : 'd-none') : '' }}"><i
                                class="fa-regular fa-pen-to-square"></i></a>
                        <a tooltip="{{ trans('labels.delete') }}" href="javascript:void(0)"
                            @if (env('Environment') == 'sendbox') onclick="myFunction()" @else
                    onclick="deletedata('{{ URL::to('admin/' . $url . '/delete-' . $banner->id) }}')" @endif
                            class="btn btn-outline-danger btn-sm {{ Auth::user()->type == 4 ? (helper::check_access('role_banner', Auth::user()->role_id, $vendor_id, 'delete') == 1 || helper::check_access('role_sliders', Auth::user()->role_id, $vendor_id, 'delete') == 1 ? '' : 'd-none') : '' }}">
                            <i class="fa-regular fa-trash"></i></a>
                    </td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
