<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
</head>

<body>
    <div>
        <div>
            <p>{{ trans('labels.dear') }} <b>{{ $admin_name }}</b>,</p>

            <p>{{ trans('labels.recevied_new_subscription_request') }} {{ $vendor_name }}
                {{ trans('labels.email_is') }} {{ $vendor_email }}</p>

            <p>{{ trans('labels.check_email_message') }}</p>

            <p>{{ trans('labels.here_are_the_details') }}</p><br>
            {{ trans('labels.pricing_plan') }}: <b>{{ $plan_name }}</b><br>
            {{ trans('labels.subscription_duration') }}: <b>{{ $duration }}</b><br>
            {{ trans('labels.subscription_cost') }}: <b>{{ $price }}</b><br><br>
            {{ trans('labels.payment_type') }}: <b>{{ $payment_method }}</b><br>
            {{ trans('labels.payment_id') }}: <b>{{ $transaction_id }}</b><br>
        </div>
    </div>
</body>

</html>
