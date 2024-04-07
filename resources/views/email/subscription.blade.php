<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>{{ trans('labels.dear') }} <b>{{$vendor_name}}</b>,</p>

            <p>{{ trans('labels.subscription_message1') }}</p>

            <p>{{ trans('labels.subscription_message2') }}</p>

            <p>{{ trans('labels.subscription_message3') }}</p>

            {{ trans('labels.pricing_plans') }}: <b>{{$plan_name}}</b><br>
            {{ trans('labels.subscription_duration') }}: <b>{{$duration}}</b><br>
            {{ trans('labels.subscription_cost') }}: <b>{{$price}}</b><br><br>

            {{ trans('labels.payment_options') }}: <b>{{$payment_method}}</b><br>
            {{ trans('labels.payment_id') }}: <b>{{$transaction_id}}</b><br>

            <p>{{ trans('labels.subscription_message4') }}</p>

            <p>{{ trans('labels.subscription_message5') }}</p>

            <p>{{ trans('labels.subscription_message6') }}</p>

            <p>{{ trans('labels.sincerely') }},</p>

            {{$admin_name}}<br>
            {{$admin_email}}
        </div>
    </div>
</body>
</html>
