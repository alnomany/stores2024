<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>{{ trans('labels.dear') }} <b>{{$name}}</b>,</p>
            <p>{{ trans('labels.forgot_password_message') }}:<b>{{$password}}</b></p>
        </div>
    </div>
</body>
</html>