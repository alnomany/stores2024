<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div style="background:#ffffff;padding:15px">
            <p>{{ trans('labels.dear') }} <b>{{$admin_name}}</b>,</p>

            <p>{{ trans('labels.admin_subscription_message1') }}</p>

            {{ trans('labels.name_of_subscriber') }}: <b>{{$vendor_name}}</b><br><br>
            {{ trans('labels.pricing_plans') }}: <b>{{$plan_name}}</b><br>
            {{ trans('labels.subscription_duration') }}: <b>{{$duration}}</b><br>
            {{ trans('labels.subscription_cost') }}: <b>{{$price}}</b><br><br>

            {{ trans('labels.payment_option') }}: <b>{{$payment_method}}</b><br>
            {{ trans('labels.payment_id') }}: <b>{{$transaction_id}}</b><br>

            <p>{{ trans('labels.admin_subscription_message2') }}</p>

            <p>{{ trans('labels.best_regards') }},</p>

            {{$vendor_name}}<br>
            {{$vendor_email}}
        </div>
    </div>
</body>
</html>
