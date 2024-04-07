<!DOCTYPE html>
<html>
<head>
    <title>{{$title}}</title>
</head>
<body>
    <div>
        <div>
            <p>{{ trans('labels.dear') }} <b>{{$customer_name}}</b>,</p>

            <p>{{ trans('labels.customer_order_email_message') }}</p>

            <p><b>{{ trans('labels.orderdetails') }}</b></p>

            {{ trans('labels.order_number') }}: <b>#{{$order_number}}</b><br>
            {{ trans('labels.date') }} : <b>{{$delivery_date}}</b><br>
            {{ trans('labels.time') }} : <b>{{$delivery_time}}</b><br>
            {{ trans('labels.total_amount') }} : <b>{{$grand_total}}</b><br>

            <p>{{ trans('labels.click_here') }} : <a href="{{ $trackurl }}">Track Order</a></p>
            
            <p>{{ trans('labels.thanks_message') }} <b>{{$company_name}}</b>.</p>
            
            <p>{{ trans('labels.sincerely') }},<br>
            {{$company_name}}
            </p>
        </div>
    </div>
</body>
</html>
