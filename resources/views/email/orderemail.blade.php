<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>{{ trans('labels.dear') }} <b>{{$name}}</b>,</p>

            <p>{{ trans('labels.inform_message') }} {{$message_text}}</p>

            <p style="margin:0px">{{ trans('labels.sincerely') }},</p>
            {{$name}}
        </div>
    </div>
</body>
</html>