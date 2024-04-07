<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>{{ trans('labels.dear') }} <b>{{$admin_name}}</b>,</p>
            <p>{{ trans('labels.vendor_register_admin_message') }}</p><br>
            {{ trans('labels.name') }} : <b>{{$vendor_name}}</b><br>
            {{ trans('labels.email') }} : <b>{{$vendor_email}}</b><br>
            {{ trans('labels.mobile') }} : <b>{{$vendor_mobile}}</b><br>
        </div>
    </div>
</body>
</html>