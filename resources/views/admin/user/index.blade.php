@extends('admin.layout.default')

@section('content')
@php
    if (Auth::user()->type == 4) {
        $vendor_id = Auth::user()->vendor_id;
    } else {
        $vendor_id = Auth::user()->id;
    }
@endphp
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="text-uppercase">{{ trans('labels.users') }}</h5>
        <div class="d-inline-flex">
            <a href="{{ URL::to('admin/users/add') }}" class="btn btn-secondary px-2 d-flex">
                <i class="fa-regular fa-plus mx-1"></i>{{ trans('labels.add') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <div class="table-responsive" id="table-display">
                        <table class="table table-striped table-bordered py-3 zero-configuration w-100">
                            <thead>
                                <tr class="text-uppercase fw-500">
                                    <td>{{ trans('labels.id') }}</td>
                                    <td>{{ trans('labels.image') }}</td>
                                    <td>{{ trans('labels.name') }}</td>
                                    <td>{{ trans('labels.email') }}</td>
                                    <td>{{ trans('labels.mobile') }}</td>
                                    <td>{{ trans('labels.login_type') }}</td>
                                    <td>{{ trans('labels.status') }}</td>
                                    <td>{{ trans('labels.created_date') }}</td>
                                    <td>{{ trans('labels.updated_date') }}</td>
                                    <td>{{ trans('labels.action') }}</td>
                                   
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($getuserslist as $user)
                                    <tr class="fs-7">
                                        <td>{{ $user->id }}</td>
                                        <td> <img src="{{ helper::image_path($user->image) }}"
                                                class="img-fluid rounded hw-50" alt="" srcset=""> </td>
                                        <td> {{ $user->name }} </td>
                                        <td> {{ $user->email }} </td>
                                        <td> {{ $user->mobile }} </td>
                                        <td>
                                            @if ($user->login_type == 'normal')
                                                {{ trans('labels.normal') }}
                                            @elseif ($user->login_type == 'google')
                                                {{ trans('labels.google') }}
                                            @elseif ($user->login_type == 'facebook')
                                                {{ trans('labels.facebook') }}
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->is_available == 1)
                                                <a class="btn btn-sm btn-outline-success"
                                                    tooltip="{{ trans('labels.active') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->slug . '/2') }}')" @endif><i
                                                        class="fa-sharp fa-solid fa-check"></i></a>
                                            @else
                                                <a class="btn btn-sm btn-outline-danger"
                                                    tooltip="{{ trans('labels.inactive') }}"
                                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="statusupdate('{{ URL::to('admin/users/status-' . $user->slug . '/1') }}')" @endif><i
                                                        class="fa-sharp fa-solid fa-xmark mx-1"></i></a>
                                            @endif
                                        </td>
                                        <td>{{ helper::date_format($user->created_at) }}<br>
                                        {{ helper::time_format($user->created_at,$vendor_id) }}
                                        </td>
                                        <td>{{ helper::date_format($user->updated_at) }}<br>
                                        {{ helper::time_format($user->updated_at,$vendor_id) }}
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-outline-info" tooltip="{{ trans('labels.edit') }}"
                                                href="{{ URL::to('admin/users/edit-' . $user->slug) }}"> <i
                                                    class="fa fa-pen-to-square"></i></a>
                                            <a class="btn btn-sm btn-outline-dark" tooltip="{{ trans('labels.login') }}"
                                                href="{{ URL::to('admin/users/login-' . $user->id) }}"> <i
                                                    class="fa-regular fa-arrow-right-to-bracket"></i> </a>
                                            <a class="btn btn-sm btn-outline-secondary"
                                                tooltip="{{ trans('labels.view') }}"
                                                href="{{ URL::to('/' . $user->slug) }}" target="_blank"><i
                                                    class="fa-regular fa-eye"></i></a>
                                            <button type="button" id="btn_password{{ $user->id }}"
                                                tooltip="{{ trans('labels.reset_password') }}"
                                                onclick="myfunction({{ $user->id }})"
                                                class="btn btn-sm btn-outline-success" data-vendor_id="{{ $user->id }}"
                                                data-type="1"><i class="fa-light fa-key"></i></button>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="changepasswordModal" tabindex="-1" aria-labelledby="changepasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ URL::to('/admin/settings/change-password') }}" method="post" class="w-100">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="changepasswordModalLabel">
                            {{ trans('labels.change_password') }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="card p-1 border-0">
                            <input type="hidden" class="form-control" name="modal_vendor_id" id="modal_vendor_id"
                                value="">
                            <input type="hidden" class="form-control" name="type" id="type" value="1">
                            <div class="form-group">
                                <label for="new_password" class="form-label">{{ trans('labels.new_password') }}</label>
                                <input type="password" class="form-control" name="new_password" required
                                    placeholder="{{ trans('labels.new_password') }}">

                            </div>
                            <div class="form-group">
                                <label for="confirm_password"
                                    class="form-label">{{ trans('labels.confirm_password') }}</label>
                                <input type="password" class="form-control" name="confirm_password" required
                                    placeholder="{{ trans('labels.confirm_password') }}">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-secondary">{{ trans('labels.save') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        function myfunction(id) {
            $('#modal_vendor_id').val($('#btn_password' + id).attr("data-vendor_id"));
            $('#changepasswordModal').modal('show');

        }
    </script>
@endsection
