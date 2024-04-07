<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>{{ trans('labels.dear') }} <b>{{$vendor_name}}</b>,</p>

            <p>{{ trans('labels.you_have_received_new_inquiry') }}</p>

            {{ trans('labels.fullname') }}: <b>{{$full_name}}</b><br>
            {{ trans('labels.email') }}: <b>{{$useremail}}</b><br>
            {{ trans('labels.mobile') }}: <b>{{$usermobile}}</b><br>
            {{ trans('labels.message') }}: <b>{{$usermessage}}</b><br>
        </div>
    </div>
</body>
</html>