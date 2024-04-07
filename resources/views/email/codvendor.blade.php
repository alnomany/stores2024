<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div>
            <p>{{ trans('labels.dear') }} <b>{{$vendor_name}}</b>,</p>

            <p>{{ trans('labels.cod_message1') }}</p>

            <p>{{ trans('labels.cod_message2') }}</p>

            <p>{{ trans('labels.cod_message3') }}</p>
            
            <p>{{ trans('labels.cod_message4') }}</p>
            
            <p>{{ trans('labels.sincerely') }},<br>
            {{$admin_name}}<br>
            {{$admin_email}}
            </p>
        </div>
    </div>
</body>
</html>
