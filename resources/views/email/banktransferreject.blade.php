<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>{{ trans('labels.dear') }} <b>{{$vendor_name}}</b>,</p>

            <p>{{ trans('labels.banktransfer_reject_message1') }}</p>

            <p>{{ trans('labels.subscription_message3') }}</p>

            {{ trans('labels.pricing_plans') }}: <b>{{$plan_name}}</b><br>
            {{ trans('labels.payment_options') }}: <b>{{$payment_method}}</b><br>

            <p>{{ trans('labels.banktransfer_reject_message2') }}</p>

            <p>{{ trans('labels.subscription_message5') }}</p>

            <p>{{ trans('labels.subscription_message6') }}</p>

            <p>{{ trans('labels.sincerely') }},</p>

            {{$admin_name}}<br>
            {{$admin_email}}
        </div>
    </div>
</body>
</html>
