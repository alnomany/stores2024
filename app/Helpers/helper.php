<?php

namespace App\Helpers;

use App\Models\Item;
use App\Models\Settings;
use App\Models\User;
use App\Models\Timing;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Transaction;
use App\Models\Payment;
use App\Models\PricingPlan;
use App\Models\SystemAddons;
use App\Models\RoleAccess;
use App\Models\RoleManager;
use App\Models\Variants;
use App\Models\Cart;
use App\Models\Coupons;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Blog;
use App\Models\CustomDomain;
use App\Models\SocialLinks;
use App\Models\CustomStatus;
use App\Models\AppSettings;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Models\Languages;
use App\Models\Tax;
use Illuminate\Support\Str;
use App\Models\Footerfeatures;
use App;
use App\Models\Faq;
use App\Models\LandingSettings;
use App\Models\Pixcel;
use App\Models\Testimonials;
use Config;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use File;

class helper
{
    public static function appdata($vendor_id)
    {
        if (file_exists(storage_path('installed'))) {
            $host = @$_SERVER['HTTP_HOST'];
            if ($host  ==  env('WEBSITE_HOST')) {
                if (!empty($vendor_id)) {
                    $data = Settings::where('vendor_id', $vendor_id)->first();
                } else {
                    $data = Settings::where('vendor_id', 1)->first();
                }
                return $data;
            }
            // if the current host doesn't contain the website domain (meaning, custom domain)
            else {
                $data = Settings::where('custom_domain', $host)->first();
            }

            return $data;
        } else {
            return redirect('install');
            exit;
        }
    }
    public static function image_path($image)
    {
        if ($image == "" && $image == null) {
            $path = asset('storage/app/public/admin-assets/images/about/defaultimages/item-placeholder.png');
        } else {
            $path = asset('storage/app/public/admin-assets/images/about/defaultimages/item-placeholder.png');
        }
        if (Str::contains($image, 'nodata')) {
            if (file_exists(storage_path('app/public/admin-assets/images/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/' . $image);
            }
        }
        if (Str::contains($image, 'authformbgimage')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/' . $image);
            }
        }
        if (Str::contains($image, 'theme-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/theme/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/theme/' . $image);
            }
        }
        if (Str::contains($image, 'feature-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/feature/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/feature/' . $image);
            }
        }
        if (Str::contains($image, 'testimonial-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/testimonials/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/testimonials/' . $image);
            }
        }
        if (Str::contains($image, 'screenshot-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/screenshot/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/screenshot/' . $image);
            }
        }
        if (Str::contains($image, 'banktransfer') || Str::contains($image, 'cod') || Str::contains($image, 'razorpay') || Str::contains($image, 'stripe') || Str::contains($image, 'wallet') || Str::contains($image, 'flutterwave') || Str::contains($image, 'paystack') || Str::contains($image, 'mercadopago') || Str::contains($image, 'paypal') || Str::contains($image, 'myfatoorah') || Str::contains($image, 'toyyibpay') || Str::contains($image, 'payment')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/payment/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/payment/' . $image);
            }
        }
        if (Str::contains($image, 'res')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/' . $image);
            }
        }
        if (Str::contains($image, 'logo')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/logo/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/logo/' . $image);
            }
            if (file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/' . $image);
            }
        }
       
        if (Str::contains($image, 'favicon')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/favicon/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/favicon/' . $image);
            }
            if (file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/' . $image);
            }
        }
        if (Str::contains($image, 'og_image')) {
            if (file_exists(storage_path('app/public/admin-assets/images/about/og_image/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/og_image/' . $image);
            }
            if (file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/about/defaultimages/' . $image);
            }
        }
        if (Str::contains($image, 'item-') || Str::contains($image, 'item')) {
            if (file_exists(storage_path('app/public/item/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'item/' . $image);
            }
            if (file_exists(storage_path('app/public/media/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'media/' . $image);
            }
        }
        if (Str::contains($image, 'banner') || Str::contains($image, 'promotion-')) {
            if (file_exists(storage_path('app/public/admin-assets/images/banners/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/banners/' . $image);
            }
        }
        if (Str::contains($image, 'order')) {
            if (file_exists(storage_path('app/public/front/images/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'front/images/' . $image);
            }
        }
        if (Str::contains($image, 'profile')) {
            if (file_exists(storage_path('app/public/admin-assets/images/profile/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/profile/' . $image);
            }
        }
        if (Str::contains($image, 'blog')) {
            if (file_exists(storage_path('app/public/admin-assets/images/blog/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/blog/' . $image);
            }
        }
        if (Str::contains($image, 'flag')) {
            if (file_exists(storage_path('app/public/admin-assets/images/language/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/language/' . $image);
            }
        }
        if (Str::contains($image, 'cover')) {
            if (file_exists(storage_path('app/public/admin-assets/images/coverimage/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/coverimage/' . $image);
            }
        }
        if (Str::contains($image, 'app') || Str::contains($image, 'work') || Str::contains($image, 'faq') || Str::contains($image, 'subscribe') || Str::contains($image, 'order_detail')) {
            if (file_exists(storage_path('app/public/admin-assets/images/index/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/index/' . $image);
            }
        }
        if (Str::contains($image, 'default')) {
            if (file_exists(storage_path('app/public/admin-assets/images/defaultimages/' . $image))) {
                $path = url(env('ASSETPATHURL') . 'admin-assets/images/defaultimages/' . $image);
            }
        }
        return $path;
    }

    public static function currency_formate($price, $vendor_id)
    {
        if (helper::appdata($vendor_id)->currency_position == "left") {
            if (helper::appdata($vendor_id)->decimal_separator == 1) {
                return helper::appdata($vendor_id)->currency . number_format($price, helper::appdata($vendor_id)->currency_formate, '.', ',');
            } else {
                return helper::appdata($vendor_id)->currency . number_format($price, helper::appdata($vendor_id)->currency_formate, ',', '.');
            }
        }
        if (helper::appdata($vendor_id)->currency_position == "right") {
            if (helper::appdata($vendor_id)->decimal_separator == 1) {
                return number_format($price, helper::appdata($vendor_id)->currency_formate, '.', ',') . helper::appdata($vendor_id)->currency;
            } else {
                return number_format($price, helper::appdata($vendor_id)->currency_formate, ',', '.') . helper::appdata($vendor_id)->currency;
            }
        }
        return $price;
    }
    public static function vendortime($vendor)
    {
        date_default_timezone_set(helper::appdata($vendor)->timezone);
        $t = date('d-m-Y');
        $time = Timing::select('close_time')->where('vendor_id', $vendor)->where('day', date("l", strtotime($t)))->first();
        $txt = "Opened until " . date("D", strtotime($t)) . " " . $time->close_time . "";
        return $txt;
    }
    public static function date_format($date)
    {
        return date("j M Y", strtotime($date));
    }
    public static function time_format($time, $vendor_id)
    {
        if (helper::appdata($vendor_id)->time_format == 1) {
            return $time->format('H:i');
        } else {
            return $time->format('h:i A');
        }
    }
    public static function get_plan_exp_date($duration, $days)
    {
        date_default_timezone_set(helper::appdata('')->timezone);
        $purchasedate = date("Y-m-d h:i:sa");
        $exdate = "";
        if (!empty($duration) && $duration != "") {
            if ($duration == "1") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 30 days'));
            }
            if ($duration == "2") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 90 days'));
            }
            if ($duration == "3") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 180 days'));
            }
            if ($duration == "4") {
                $exdate = date('Y-m-d', strtotime($purchasedate . ' + 365 days'));
            }
            if ($duration == "5") {
                $exdate = "";
            }
        }
        if (!empty($days) && $days != "") {
            $exdate = date('Y-m-d', strtotime($purchasedate . ' + ' . $days . 'days'));
        }
        return $exdate;
    }
    public static function timings($vendor)
    {
        $timings = Timing::where('vendor_id', @$vendor)->get();
        return $timings;
    }
    public static function storeinfo($vendor)
    {
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendorinfo = User::where('slug', $vendor)->first();

            return $vendorinfo;
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendorinfo = User::where('custom_domain', $host)->first();

            if (empty($vendorinfo)) {
                abort('404');
            }
            $domain = CustomDomain::where('vendor_id', $vendorinfo->id)->first();

            if ($domain->status != 1) {
                $checkplan = App\Models\Transaction::where('vendor_id', $vendorinfo->id)
                    ->orderByDesc('id')
                    ->first();
                if ($checkplan->custom_domain == 1) {
                    return $vendorinfo;
                }
                if ($vendorinfo->allow_without_subscription == 1) {
                    return $vendorinfo;
                }
            } else {
                abort(404);
            }
        }
    }
    public static function checkplan($id, $type)
    {
        
        $check = SystemAddons::where('unique_identifier', 'subscription')->first();

        if (@$check->activated != 1) {
            return response()->json(['status' => 1, 'message' => '', 'expdate' => "", 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
        }
        date_default_timezone_set(helper::appdata($id)->timezone);
        $vendorinfo = User::where('id', $id)->first();
        $checkplan = Transaction::where('plan_id', $vendorinfo->plan_id)->where('vendor_id', $vendorinfo->id)->orderByDesc('id')->first();
      
        $totalservice = Item::where('vendor_id', $vendorinfo->id)->count();
        if ($vendorinfo->allow_without_subscription != 1) {
           
            if (!empty($checkplan)) {
                if ($vendorinfo->is_available == 2) {
                    return response()->json(['status' => 2, 'message' => trans('messages.account_blocked_by_admin'), 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
                if ($checkplan->payment_type == 1) {
                    if ($checkplan->status == 1) {
                        return response()->json(['status' => 2, 'message' => trans('messages.cod_pending'), 'showclick' => "0", 'plan_message' => trans('messages.cod_pending'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => '1'], 200);
                    } elseif ($checkplan->status == 3) {
                        return response()->json(['status' => 2, 'message' => trans('messages.cod_rejected'), 'showclick' => "1", 'plan_message' => trans('messages.cod_rejected'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if ($checkplan->payment_type == 6) {
                    if ($checkplan->status == 1) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_pending'), 'showclick' => "0", 'plan_message' => trans('messages.bank_request_pending'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => '1'], 200);
                    } elseif ($checkplan->status == 3) {
                        return response()->json(['status' => 2, 'message' => trans('messages.bank_request_rejected'), 'showclick' => "1", 'plan_message' => trans('messages.bank_request_rejected'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if ($checkplan->expire_date != "") {
                    if (date('Y-m-d') > $checkplan->expire_date) {

                        return response()->json(['status' => 2, 'message' => trans('messages.plan_expired'), 'expdate' => $checkplan->expire_date, 'showclick' => "1", 'plan_message' => trans('messages.plan_expired'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                    }
                }
                if (Str::contains(request()->url(), 'admin')) {
                    if ($checkplan->service_limit != -1) {
                        if ($totalservice >= $checkplan->service_limit) {
                            if (Auth::user()->type == 1) {
                                return response()->json(['status' => 2, 'message' => trans('messages.products_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                            }
                            if (Auth::user()->type == 2 || Auth::user()->type == 4) {
                                if ($checkplan->expire_date != "") {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "2", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_products_limit_message'), 'expdate' => '', 'showclick' => "2", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                }
                            }
                        }
                    }
                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            if (Auth::user()->type == 1) {
                                return response()->json(['status' => 2, 'message' => trans('messages.order_limit_exceeded'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                            }
                            if (Auth::user()->type == 2 || Auth::user()->type == 4) {
                                if ($checkplan->expire_date != "") {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                                } else {
                                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_order_limit_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => 'service', 'bank_transfer' => ''], 200);
                                }
                            }
                        }
                    }
                }
                if ($type == 3) {

                    if ($checkplan->appoinment_limit != -1) {
                        if ($checkplan->appoinment_limit <= 0) {
                            return response()->json(['status' => 2, 'message' => trans('messages.front_store_unavailable'), 'expdate' => '', 'showclick' => "1", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => '', 'checklimit' => 'booking', 'bank_transfer' => ''], 200);
                        }
                    }
                }
                if ($checkplan->expire_date != "") {

                    return response()->json(['status' => 1, 'message' => trans('messages.plan_expires'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.plan_expires'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                } else {

                    return response()->json(['status' => 1, 'message' => trans('messages.lifetime_subscription'), 'expdate' => $checkplan->expire_date, 'showclick' => "0", 'plan_message' => trans('messages.lifetime_subscription'), 'plan_date' => $checkplan->expire_date, 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
            } else {
                if (Auth::user()->type == 1) {
                    return response()->json(['status' => 2, 'message' => trans('messages.doesnot_select_any_plan'), 'expdate' => '', 'showclick' => "0", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
                if (Auth::user()->type == 2 || Auth::user()->type == 4) {
                    return response()->json(['status' => 2, 'message' => trans('messages.vendor_plan_purchase_message'), 'expdate' => '', 'showclick' => "1", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
                }
            }
        } else {
            return response()->json(['status' => 1, 'message' => trans('messages.success'),'expdate' => '', 'showclick' => "1", 'plan_message' => '', 'plan_date' => '', 'checklimit' => '', 'bank_transfer' => ''], 200);
        }
    }

    public static function createorder($vendor, $user_id, $session_id, $payment_type_data, $payment_id, $customer_email, $customer_name, $customer_mobile, $stripeToken, $grand_total, $delivery_charge, $address, $building, $landmark, $postal_code, $discount_amount, $sub_total, $tax, $tax_name, $delivery_time, $delivery_date, $delivery_area, $couponcode, $order_type, $notes, $filename, $table, $tablename)
    {
        try {
            date_default_timezone_set(helper::appdata($vendor)->timezone);
            $vendorinfo = User::where('id', $vendor)->first();
            if ($user_id != "" || $user_id != null) {
                $data = Cart::where('user_id', $user_id)->where('vendor_id', $vendorinfo->id)->get();
            } else {
                $data = Cart::where('session_id', $session_id)->where('vendor_id', $vendorinfo->id)->get();
            }
            if (helper::appdata($vendorinfo->id)->product_type == 1) {
                $defaultsatus = CustomStatus::where('vendor_id', $vendor)->where('type', 1)->where('order_type', $order_type)->where('is_available', 1)->where('is_deleted', 2)->first();
                if (empty($defaultsatus) && $defaultsatus == null) {
                    return $order_number = "1";
                }
            }
           
            if ($data->count() > 0) {
                //payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5, Bank Transfer:6, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10
                if ($order_type == "2") {
                    $delivery_charge = "0.00";
                    $address = "";
                    $building = "";
                    $landmark = "";
                    $postal_code = "";
                } else {
                    $delivery_charge = $delivery_charge;
                    $address = $address;
                    $building = $building;
                    $landmark = $landmark;
                    $postal_code = $postal_code;
                }
                if ($discount_amount == "NaN") {
                    $discount_amount = 0;
                } else {
                    $discount_amount = $discount_amount;
                }
                
                $order_number = substr(str_shuffle(str_repeat("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", 10)), 0, 10);
                $order = new Order;
                $order->vendor_id = $vendor;
                $order->user_id = $user_id;
                $order->order_number = $order_number;
                $order->payment_type = $payment_type_data;
                $order->payment_id = @$payment_id;
                $order->sub_total = $sub_total;
                $order->tax = $tax;
                $order->tax_name = $tax_name;
                $order->grand_total = $grand_total;
                if (helper::appdata($vendorinfo->id)->product_type == 1) {
                    $order->status = $defaultsatus->id;
                    $order->status_type = $defaultsatus->type;
                } else {
                    $order->status_type = 3;
                }
                $order->address = $address;
                $order->delivery_time = $delivery_time;
                $order->delivery_date = $delivery_date;
                $order->delivery_area = $delivery_area;
                $order->delivery_charge = $delivery_charge;
                $order->discount_amount = $discount_amount;
                $order->couponcode = $couponcode;
                $order->order_type = $order_type;
                $order->building = $building;
                $order->landmark = $landmark;
                $order->pincode = $postal_code;
                $order->customer_name = $customer_name;
                $order->customer_email = $customer_email;
                $order->mobile = $customer_mobile;
                $order->order_notes = $notes;
                $order->dinein_table = $table;
                $order->dinein_tablename = $tablename;
                if ($payment_type_data == '1') {
                    $order->payment_status = 1;
                } elseif ($payment_type_data == '6') {
                    $order->screenshot = $filename;
                    $order->payment_status = 1;
                } else {
                    $order->payment_status = 2;
                }
                
                $order->save();
                $order_id = DB::getPdo()->lastInsertId();
               
                foreach ($data as $value) {

                    $OrderPro = new OrderDetails;
                    $OrderPro->order_id = $order_id;
                    $OrderPro->item_id = $value['item_id'];
                    $OrderPro->item_name = $value['item_name'];
                    $OrderPro->item_image = $value['item_image'];
                    $OrderPro->extras_id = $value['extras_id'];
                    $OrderPro->extras_name = $value['extras_name'];
                    $OrderPro->extras_price = $value['extras_price'];
                    if ($value['variants_id'] == "") {
                        $OrderPro->price = $value['item_price'];
                        $product = Item::where('id', $value['item_id'])->first();
                        if ($product->stock_management == 1) {
                            $product->qty = (int)$product->qty - (int)$value['qty'];
                        }
                        $product->update();
                    } else {
                        $variant = Variants::where('item_id', $value['item_id'])->where('id', $value['variants_id'])->first();
                        if ($variant->stock_management == 1) {
                        $variant->qty = (int)$variant->qty - (int)$value['qty'];
                        }
                        $variant->update();
                        $OrderPro->price = $value['price'];
                    }
                    $OrderPro->variants_id = $value['variants_id'];
                    $OrderPro->variants_name = $value['variants_name'];
                    $OrderPro->variants_price = $value['variants_price'];
                    $OrderPro->attribute = $value['attribute'];
                    $OrderPro->qty = $value['qty'];
                    $OrderPro->save();
                }
               
                if ($user_id != "" || $user_id != null) {
                    $data = Cart::where('user_id', $user_id)->delete();
                } else {
                    $data = Cart::where('session_id', $session_id)->delete();
                }
               
                session()->forget(['offer_amount', 'offer_code', 'offer_type']);
                if ($user_id != "" || $user_id != null) {
                    $count = Cart::where('user_id', $user_id)->count();
                } else {
                    $count = Cart::where('session_id', $session_id)->count();
                }
              
                session()->put('cart', $count);

                $trackurl = URL::to(@$vendorinfo->slug . '/find-order/?order=' . $order_number);
                $emaildata = helper::emailconfigration(helper::appdata($vendorinfo->id)->id);
                Config::set('mail', $emaildata);
                helper::create_order_invoice($customer_email, $customer_name, $vendorinfo->email, $vendorinfo->name, $order_number, $order_type, helper::date_format($delivery_date), $delivery_time, helper::currency_formate($grand_total, $vendor), $trackurl);
                $title = trans('labels.order_update');
                $body = "Congratulations! Your store just received a new order " . $order_number;
                helper::push_notification($vendorinfo->token, $title, $body, "order", $order->id);
                $checkplan = Transaction::where('vendor_id', $vendor)->orderByDesc('id')->first();
                if (!empty($checkplan)) {
                    if ($checkplan->appoinment_limit != -1) {
                        $checkplan->appoinment_limit -= 1;
                        $checkplan->save();
                    }
                }
                
                return $order_number;
            } else {
                return $order_number = "";
            }
        } catch (\Throwable $th) {
           
            return $th;
        }
    }

    public static function push_notification($token, $title, $body, $type, $order_id)
    {
        $customdata = array(
            "type" => $type,
            "order_id" => $order_id,
        );

        $msg = array(
            'body' => $body,
            'title' => $title,
            'sound' => 1/*Default sound*/
        );
        $fields = array(
            'to'           => $token,
            'notification' => $msg,
            'data' => $customdata
        );
        $headers = array(
            'Authorization: key=' . @helper::appdata('')->firebase,
            'Content-Type: application/json'
        );
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $firebaseresult = curl_exec($ch);
        curl_close($ch);

        return $firebaseresult;
    }

    public static function vendor_register($vendor_name, $vendor_email, $vendor_mobile, $vendor_password, $firebasetoken, $slug, $google_id, $facebook_id, $country_id, $city_id, $store, $product_type)
    {
        try {
            $check = User::where('slug', Str::slug($vendor_name, '-'))->first();
            if ($check != "") {
                $last = User::select('id')->orderByDesc('id')->first();
                $slug =   Str::slug($vendor_name . " " . ($last->id + 1), '-');
            } else {
                $slug = Str::slug($vendor_name, '-');
            }
            $rec = Settings::where('vendor_id', '1')->first();
            date_default_timezone_set($rec->timezone);
            $logintype = "normal";
            if ($google_id != "") {
                $logintype = "google";
            }
            if ($facebook_id != "") {
                $logintype = "facebook";
            }
            if ($product_type == null) {
                $product_type = 1;
            }
            
            $user = new User;
            $user->name = $vendor_name;
            $user->email = $vendor_email;
            $user->password = $vendor_password;
            $user->google_id = $google_id;
            $user->facebook_id = $facebook_id;
            $user->mobile = $vendor_mobile;
            $user->image = "default.png";
            $user->slug = $slug;
            $user->login_type = $logintype;
            $user->type = 2;
            $user->token = $firebasetoken;
            $user->country_id = $country_id;
            $user->city_id = $city_id;
            $user->is_verified = 2;
            $user->is_available = 1;
            $user->store_id = $store;
            $user->save();
            $vendor_id = \DB::getPdo()->lastInsertId();
           
            $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

            foreach ($days as $day) {

                $timedata = new Timing;
                $timedata->vendor_id = $vendor_id;
                $timedata->day = $day;
                $timedata->open_time = '09:00 AM';
                $timedata->break_start = '01:00 PM';
                $timedata->break_end = '02:00 PM';
                $timedata->close_time = '09:00 PM';
                $timedata->is_always_close = '2';
                $timedata->save();
            }

            $status_name = CustomStatus::where('vendor_id', '1')->get();

            foreach ($status_name as $name) {
                $customstatus = new CustomStatus;
                $customstatus->vendor_id = $vendor_id;
                $customstatus->name = $name->name;
                $customstatus->type = $name->type;
                $customstatus->order_type = $name->order_type;
                $customstatus->is_available = $name->is_available;
                $customstatus->is_deleted = $name->is_deleted;
                $customstatus->save();
            }

            $paymentlist = Payment::select('payment_name', 'currency', 'image', 'is_activate', 'payment_type')->where('vendor_id', '1')->get();
            foreach ($paymentlist as $payment) {
                $gateway = new Payment;
                $gateway->vendor_id = $vendor_id;
                $gateway->payment_name = $payment->payment_name;
                $gateway->currency = $payment->currency;
                $gateway->image = $payment->image;
                $gateway->payment_type = $payment->payment_type;
                $gateway->public_key = '-';
                $gateway->secret_key = '-';
                $gateway->encryption_key = '-';
                $gateway->environment = '1';
                $gateway->payment_description = '-';
                $gateway->is_available = '1';
                $gateway->is_activate = $payment->is_activate;
                $gateway->save();
            }

            $messagenotification = "Hi, 
I would like to place an order 👇
*{delivery_type}* Order No: {order_no}
---------------------------
{item_variable}
---------------------------
👉Subtotal : {sub_total}
{total_tax}
👉Delivery charge : {delivery_charge}
👉Discount : - {discount_amount}
---------------------------
📃 Total : {grand_total}
---------------------------
📄 Comment : {notes}

✅ Customer Info

Customer name : {customer_name}
Customer phone : {customer_mobile}

📍 Delivery Details

Address : {address}, {building}, {landmark}, {postal_code}

---------------------------
Date : {date}
Time : {time}
---------------------------
💳 Payment type :
{payment_type}

{store_name} will confirm your order upon receiving the message.

Track your order 👇
{track_order_url}

Click here for next order 👇
{store_url}";

            $data = new Settings;
            $data->vendor_id = $vendor_id;
            $data->currency = $rec->currency;
            // logo===================================================
            $oldPath =  storage_path('app/public/admin-assets/images/about/defaultimages/' . $rec->logo);
            $fileExtensionlogo = File::extension($oldPath);
            $newname =  'logo-' . uniqid() . "." . $fileExtensionlogo;
            $newPathWithName = storage_path('app/public/admin-assets/images/about/logo/') . $newname;
            File::copy($oldPath, $newPathWithName);
            $data->logo = $newname;

            // favicon=============
            $oldfavicon = storage_path('app/public/admin-assets/images/about/defaultimages/' . $rec->favicon);
            $fileExtensionfavicon = File::extension($oldfavicon);
            $newfavicon =  'favicon-' . uniqid() . "." . $fileExtensionfavicon;
            $newfaviconWithName = storage_path('app/public/admin-assets/images/about/favicon/') . $newfavicon;
            File::copy($oldfavicon, $newfaviconWithName);
            $data->favicon = $newfavicon;
            
            // og_image
            $oldogimage = storage_path('app/public/admin-assets/images/about/defaultimages/' . $rec->og_image);
            $fileExtensionogimage = File::extension($oldogimage);
            $newogimage =  'og_image-' . uniqid() . "." . $fileExtensionogimage;
            $newogimageWithName = storage_path('app/public/admin-assets/images/about/og_image/') . $newogimage;
            File::copy($oldogimage, $newogimageWithName);
            $data->og_image = $newogimage;
            $data->currency_position = $rec->currency_position;
            $data->timezone = $rec->timezone;
            $data->address = $rec->address;
            $data->contact = $rec->contact;
            $data->email = $rec->email;
            $data->description = $rec->description;
            $data->copyright = $rec->copyright;
            $data->website_title = $rec->website_title;
            $data->meta_title = $rec->meta_title;
            $data->meta_description = $rec->meta_description;
            $data->delivery_type = 'delivery';
            $data->item_message = "🔵 {qty} X {item_name} {variantsdata} - {item_price}";
            $data->interval_time = 1;
            $data->interval_type = 2;
            $data->whatsapp_message = $messagenotification;
            $data->telegram_message = $messagenotification;
            $data->product_type = $product_type;
            $data->save();
            $emaildata = helper::emailconfigration(helper::appdata('')->id);
            Config::set('mail', $emaildata);
            helper::send_mail_vendor_register($user);
            return $vendor_id;
        } catch (\Throwable $th) {
            return $th;
        }
    }
    // get plan name
    public static function plandetail($plan_id)
    {
        $planinfo = PricingPlan::select('name')->where('id', $plan_id)->first();
        return $planinfo;
    }
    // display footer features...........
    public static function footer_features($vendor_id)
    {
        return FooterFeatures::select('id', 'icon', 'title', 'description')->where('vendor_id', $vendor_id)->get();
    }

    //Send email 

    public static function send_subscription_email($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {

        $admininfo = User::where('id', '1')->first();

        $data = ['title' => trans('labels.new_subscription_purchase'), 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];

        $adminemail = ['title' => trans('labels.new_subscription_purchase'), 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];

        try {
            Mail::send('email.subscription', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            Mail::send('email.adminsubscription', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function cod_request($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();
        $data = ['title' =>  trans('labels.cod'), 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];
        $adminemail = ['title' =>  trans('labels.cod'), 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];
        try {
            Mail::send('email.codvendor', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.banktransferadmin', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function bank_transfer_request($vendor_email, $vendor_name, $plan_name, $duration, $price, $payment_method, $transaction_id)
    {
        $admininfo = User::where('id', '1')->first();
        $data = ['title' => trans('labels.banktransfer'), 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];
        $adminemail = ['title' => trans('labels.banktransfer'), 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admininfo->email, 'admin_name' => $admininfo->name, 'plan_name' => $plan_name, 'duration' => $duration, 'price' => $price, 'payment_method' => $payment_method, 'transaction_id' => $transaction_id];
        try {
            Mail::send('email.banktransfervendor', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.banktransferadmin', $adminemail, function ($message) use ($adminemail) {
                $message->to($adminemail['admin_email'])->subject($adminemail['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_delete_account($vendor)
    {
        $data = ['title' => trans('labels.account_deleted'), 'vendor_name' => $vendor->name, 'email' => $vendor->email];
        try {
            Mail::send('email.accountdeleted', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_vendor_register($vendor)
    {

        $user = User::where('id', 1)->first();
        $data = ['title' => trans('labels.registration'), 'title1' => 'New Vendor Registration', 'vendor_name' => $vendor->name, 'vendor_email' => $vendor->email, 'admin_email' => $user->email, "vendor_mobile" => $vendor->mobile, 'admin_name' => $user->name];
        try {
            Mail::send('email.vendorregister', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });

            Mail::send('email.newvendorregistration', $data, function ($message) use ($data) {
                $message->to($data['admin_email'])->subject($data['title1']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function send_mail_vendor_block($vendor)
    {
        $data = ['title' => trans('labels.account_deleted'), 'vendor_name' => $vendor->name, 'vendor_email' => $vendor->email];
        try {
            Mail::send('email.vendorbloked', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function subscription_rejected($vendor_email, $vendor_name, $plan_name, $payment_method)
    {
        $admindata = User::select('name', 'email')->where('id', '1')->first();
        $data = ['title' => "Bank transfer rejected", 'vendor_email' => $vendor_email, 'vendor_name' => $vendor_name, 'admin_email' => $admindata->email, 'admin_name' => $admindata->name, 'plan_name' => $plan_name, 'payment_method' => $payment_method];
        try {
            Mail::send('email.banktransferreject', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function vendor_contact_data($vendor_name, $vendor_email, $full_name, $useremail, $usermobile, $usermessage)
    {
        $data = ['title' => trans('labels.inquiry'), 'vendor_name' => $vendor_name, 'vendor_email' => $vendor_email, 'full_name' => $full_name, 'useremail' => $useremail, 'usermobile' => $usermobile, 'usermessage' => $usermessage];
        try {
            Mail::send('email.vendorcontcatform', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function create_order_invoice($customer_email, $customer_name, $companyemail, $companyname, $order_number, $order_type, $delivery_date, $delivery_time, $grand_total, $trackurl)
    {
        $data = ['title' => "Order Invoice", 'order_type' => $order_type, 'customer_email' => $customer_email, 'customer_name' => $customer_name, 'company_email' => $companyemail, 'company_name' => $companyname, 'order_number' => $order_number, 'delivery_date' => $delivery_date, 'delivery_time' => $delivery_time, 'grand_total' => $grand_total, 'trackurl' => $trackurl];

        $vendordata = ['title' => "Order Invoice", 'order_type' => $order_type, 'customer_email' => $customer_email, 'customer_name' => $customer_name, 'company_email' => $companyemail, 'company_name' => $companyname, 'order_number' => $order_number, 'delivery_date' => $delivery_date, 'delivery_time' => $delivery_time, 'grand_total' => $grand_total, 'trackurl' => $trackurl];
        try {
            Mail::send('email.customerorderemail', $data, function ($message) use ($data) {
                $message->to($data['customer_email'])->subject($data['title']);
            });

            Mail::send('email.vendororderemail', $vendordata, function ($companymessage) use ($vendordata) {
                $companymessage->to($vendordata['company_email'])->subject($vendordata['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function order_status_email($email, $name, $title, $message_text, $vendor_id)
    {
        $data = ['email' => $email, 'name' => $name, 'title' => $title, 'message_text' => $message_text, 'logo' => helper::image_path(@helper::appdata($vendor_id)->logo)];
        try {
            Mail::send('email.orderemail', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }

    public static function send_pass($email, $name, $password, $id)
    {
        $data = ['title' => "New Password", 'email' => $email, 'name' => $name, 'password' => $password, 'logo' => @helper::appdata($id)->logo];
        try {

            Mail::send('email.sendpassword', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    public static function cancel_order($email, $name, $title, $message_text, $vendor)
    {
        $data = ['email' => $email, 'name' => $name, 'title' => $title, 'vendor' => $vendor->user_name, 'message_text' => $message_text, 'logo' => Helper::image_path(@Helper::appdata($vendor->id)->logo)];
        try {
            Mail::send('email.orderemail', $data, function ($message) use ($data) {
                $message->to($data['email'])->subject($data['title']);
            });
            return 1;
        } catch (\Throwable $th) {
            return 0;
        }
    }
    // Email end

    public static function language($vendor_id)
    {

        if (session()->get('locale') == null) {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('code', helper::appdata($vendor_id)->default_language)->first();
            App::setLocale($layout->code);
            session()->put('locale', $layout->code);
            session()->put('language', $layout->name);
            session()->put('flag', $layout->image);
            session()->put('direction', $layout->layout);
        } else {
            $layout = Languages::select('name', 'layout', 'image', 'is_default', 'code')->where('code', session()->get('locale'))->first();
            App::setLocale(session()->get('locale'));
            session()->put('locale', @$layout->code);
            session()->put('language', @$layout->name);
            session()->put('flag', @$layout->image);
            session()->put('direction', @$layout->layout);
        }
    }
    // get language list vendor side.
    public static function available_language($vendor_id)
    {
        if ($vendor_id == "") {
            $listoflanguage = Languages::where('is_available', '1')->where('is_deleted', 2)->get();
        } else {
            $listoflanguage = Languages::where('is_deleted', 2)->get();
        }
        return $listoflanguage;
    }

    // get language list in atuh pages.
    public static function listoflanguage()
    {
        $listoflanguage = Languages::get();
        return $listoflanguage;
    }
    public static function whatsappmessage($order_number, $vendor_slug, $vendordata)
    {

        $pagee[] = "";
        $orderdata = Order::where('order_number', $order_number)->first();
        $data = OrderDetails::where('order_id', $orderdata->id)->get();
        foreach ($data as $value) {
            if ($value['variants_id'] != "") {
                $item_p = $value['qty'] * $value['variants_price'];
                $variantsdata = '(' . $value['variants_name'] . ')';
            } else {
                $variantsdata = "";
                $item_p = $value['qty'] * $value['price'];
            }
            $extras_id = explode("|", $value['extras_id']);
            $extras_name = explode("|", $value['extras_name']);
            $extras_price = explode("|", $value['extras_price']);
            $item_message = helper::appdata($vendordata->id)->item_message;
            $itemvar = ["{qty}", "{item_name}", "{variantsdata}", "{item_price}"];
            $newitemvar = [$value['qty'], $value['item_name'], $variantsdata, helper::currency_formate($item_p, $vendordata->id)];
            $pagee[] = str_replace($itemvar, $newitemvar, $item_message);
            if ($value['extras_id'] != "") {
                foreach ($extras_id as $key => $addons) {
                    @$pagee[] .= "👉" . $extras_name[$key] . ':' . helper::currency_formate($extras_price[$key], $vendordata->id) . '%0a';
                }
            }
        }
        $items = implode(",", $pagee);


        $itemlist = str_replace(',', '%0a', $items);
        if ($orderdata->order_type == 1) {
            $order_type = trans('labels.delivery');
        } elseif ($orderdata->order_type == 2) {
            $order_type = trans('labels.pickup');
        } elseif ($orderdata->order_type == 3) {
            $order_type = trans('labels.table');
        } elseif ($orderdata->order_type == 4) {
            $order_type = trans('labels.pos');
        } elseif ($orderdata->order_type == 5) {
            $order_type = trans('labels.digital');
        }
        //payment_type = COD : 1,RazorPay : 2, Stripe : 3, Flutterwave : 4, Paystack : 5,Banktransfer:6, Mercado Pago : 7, PayPal : 8, MyFatoorah : 9, toyyibpay : 10
        if ($orderdata->payment_type == 1) {
            $payment_type = trans('labels.cod');
        }
        if ($orderdata->payment_type == 6) {
            $payment_type = trans('labels.banktransfer');
        }
        if ($orderdata->payment_type == 2) {
            $payment_type = trans('labels.razorpay');
        }
        if ($orderdata->payment_type == 3) {
            $payment_type = trans('labels.stripe');
        }
        if ($orderdata->payment_type == 4) {
            $payment_type = trans('labels.flutterwave');
        }
        if ($orderdata->payment_type == 5) {
            $payment_type = trans('labels.paystack');
        }
        if ($orderdata->payment_type == 7) {
            $payment_type = trans('labels.mercadopago');
        }
        if ($orderdata->payment_type == 8) {
            $payment_type = trans('labels.paypal');
        }
        if ($orderdata->payment_type == 9) {
            $payment_type = trans('labels.myfatoorah');
        }
        if ($orderdata->payment_type == 10) {
            $payment_type = trans('labels.toyyibpay');
        }
       
        $tax = explode("|", $orderdata['tax']);
        $tax_name = explode("|", $orderdata['tax_name']);
       
        $tax_data[] = "";
        if ($tax != "") {
            foreach ($tax as $key => $tax_value) {
                @$tax_data[] .= "👉" . $tax_name[$key] . ' : ' . helper::currency_formate((float)$tax[$key], $vendordata->id) . '%0a';
            }
        } 
        $tdata = implode(",", $tax_data);


        $tax_val = str_replace(',', '%0a', $tdata);

        if (helper::appdata($vendordata->id)->product_type == 1) {
            $var = ["{delivery_type}", "{order_no}", "{item_variable}", "{sub_total}", "{total_tax}", "{delivery_charge}", "{discount_amount}", "{grand_total}", "{notes}", "{customer_name}", "{customer_mobile}", "{address}", "{building}", "{landmark}", "{postal_code}", "{date}", "{time}", "{payment_type}", "{store_name}", "{track_order_url}", "{store_url}"];
            $newvar = [$order_type, $order_number, $itemlist, helper::currency_formate($orderdata->sub_total, $vendordata->id), $tax_val, helper::currency_formate($orderdata->delivery_charge, $vendordata->id), helper::currency_formate($orderdata->discount_amount, $vendordata->id), helper::currency_formate($orderdata->grand_total, $vendordata->id), $orderdata->order_notes, $orderdata->customer_name, $orderdata->mobile, $orderdata->address, $orderdata->building, $orderdata->landmark, $orderdata->postal_code, $orderdata->delivery_date, $orderdata->delivery_time, $payment_type, $vendordata->name, URL::to($vendordata->slug . "/find-order/?order=" . $order_number), URL::to($vendordata->slug)];
        } else {
            $var = ["{delivery_type}", "{order_no}", "{item_variable}", "{sub_total}", "{total_tax}", "{discount_amount}", "{grand_total}", "{notes}", "{customer_name}", "{customer_mobile}", "{payment_type}", "{store_name}", "{track_order_url}", "{store_url}"];
            $newvar = [$order_type, $order_number, $itemlist, helper::currency_formate($orderdata->sub_total, $vendordata->id), $tax_val, helper::currency_formate($orderdata->discount_amount, $vendordata->id), helper::currency_formate($orderdata->grand_total, $vendordata->id), $orderdata->order_notes, $orderdata->customer_name, $orderdata->mobile, $payment_type, $vendordata->name, URL::to($vendordata->slug . "/find-order/?order=" . $order_number), URL::to($vendordata->slug)];
        }
        $whmessage = str_replace($var, $newvar, str_replace("\n", "%0a", helper::appdata($vendordata->id)->whatsapp_message));

        return $whmessage;
    }
    public static function role($id)
    {
        $role = RoleManager::select('role')->where('id', $id)->first();
        return $role;
    }
    public static function check_menu($role_id, $slug)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if ($role_id == "" || $role_id == null || $role_id == 0) {
            return 1;
        } else {
            $module = RoleManager::where('id', $role_id)->where('vendor_id', $vendor_id)->first();
            $module = explode('|', $module->module);
            if (in_array($slug, $module)) {
                return 1;
            } else {

                return 0;
            }
        }
    }
    public static function check_access($module, $role_id, $vendor_id, $action)
    {

        $module = RoleAccess::where('module_name', $module)->where('role_id', $role_id)->where('vendor_id', $vendor_id)->first();
        if (!empty($module) && $module != null) {
            if ($action == 'add' && $module->add == 1) {
                return 1;
            } elseif ($action == 'edit' && $module->edit == 1) {
                return 1;
            } elseif ($action == 'delete' && $module->delete == 1) {
                return 1;
            } elseif ($action == 'manage' && $module->manage == 1) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }
    public static function getplantransaction($vendor_id)
    {
        $plan = Transaction::where('vendor_id', $vendor_id)->orderbyDesc('id')->first();
        return $plan;
    }
    public static function getslug($vendor_id)
    {
        $data = User::where('id', $vendor_id)->first();
        return $data;
    }
    public static function getpixelid($vendor_id)
    {
        $pixcel = Pixcel::where('vendor_id', $vendor_id)->first();
        return $pixcel;
    }
    public static function checkvariantqty($item_id, $vendor_id)
    {
        $item = Item::where('id', $item_id)->where('vendor_id', $vendor_id)->first();
        if ($item->has_variants == 1) {
            $qty = Variants::select('item_id', 'qty')->where('item_id', $item_id)->get();
            $array = [];
            foreach ($qty as $qty) {
                array_push($array, $qty->qty);
            }
            if (count(array_filter($array)) == 0) {
                return 2;
            }
        }
    }
    public static function checklowqty($item_id, $vendor_id)
    {
        $item = Item::where('id', $item_id)->where('vendor_id', $vendor_id)->first();
        if ($item->has_variants == 1) {
            $qty = Variants::select('item_id', 'qty')->where('item_id', $item_id)->get();
            $array = [];

            foreach ($qty as $qty) {
                array_push($array, $qty->qty);
            }
            if (in_array(0, $array)) {
                return 2;
            }
            if (count(array_filter($array)) == 0) {
                return 3;
            }
            foreach ($array as $qty) {
                if ($qty != null && $qty != "") {
                    if ($qty <= $item->low_qty) {
                        return 1;
                    }
                }
            }
        } else {

            if ($item->qty == null && $item->qty == "") {
                return 3;
            }
            if ((string)$item->qty != null && (string)$item->qty != "") {
                if ((string)$item->qty == 0) {
                    return 2;
                }
                if ($item->qty <= $item->low_qty) {
                    return 1;
                }
            }
        }
    }
    // dynamic email configration
    public static function emailconfigration($vendor_id)
    {
        $mailsettings = Settings::where('vendor_id', $vendor_id)->first();
        $emaildata = [];
        if ($mailsettings) {
            $emaildata = [
                'driver' => $mailsettings->mail_driver,
                'host' => $mailsettings->mail_host,
                'port' => $mailsettings->mail_port,
                'encryption' => $mailsettings->mail_encryption,
                'username' => $mailsettings->mail_username,
                'password' => $mailsettings->mail_password,
                'from'     => ['address' => $mailsettings->mail_fromaddress, 'name' => $mailsettings->mail_fromname]
            ];
        }
        return $emaildata;
    }
    // display dynamic paymant name
    public static function getpayment($payment_type, $vendor_id)
    {
        $payment = Payment::select('payment_name')->where('payment_type', $payment_type)->where('vendor_id', $vendor_id)->first();
        return $payment;
    }
    // diplay all paymane images in footer
    public static function getallpayment($vendor_id)
    {
        $payment = Payment::where('is_available', '1')->where('vendor_id', $vendor_id)->where('is_activate', 1)->orderBy('reorder_id')->get();
        return $payment;
    }
    // get category list
    public static function getcategory($vendor_id)
    {
        $getcategory = Category::where('vendor_id', @$vendor_id)->where('is_available', '=', '1')->where('is_deleted', '2')->orderBy('reorder_id', 'ASC')->get();
        return $getcategory;
    }
    // item count category wise mobile modal
    public static function getitems($vendor_id)
    {
        $getitem = Item::with(['variation', 'extras'])->where('vendor_id', @$vendor_id)->where('is_available', '1')->orderBy('reorder_id', 'ASC')->get();
        return $getitem;
    }
    public static function ceckfavorite($product_id, $vendor_id, $user_id)
    {
        $getfavorite = Favorite::where('vendor_id', $vendor_id)->where('user_id', $user_id)->where('product_id', $product_id)->first();
        return $getfavorite;
    }
    public static function getcoupons($vendor_id)
    {
        $coupons = Coupons::where('vendor_id', $vendor_id)->where('is_available', 1)->where('start_date', '<=', date('Y-m-d'))->where('exp_date', '>=', date('Y-m-d'))->orderBy('reorder_id')->get();
        $data = array();
        foreach ($coupons as $prod) {
            $count = helper::getcouponcodecount($vendor_id, $prod->offer_code);
            if ($prod->usage_type == 1) {
                if ($count < $prod->usage_limit) {
                    $data[] = $prod;
                }
            } else {
                $data[] = $prod;
            }
        }
        return $data;
    }
    public static function getratting($item_id, $vendor_id, $type)
    {
        if ($type == "") {
            $ratting = Testimonials::where('item_id', $item_id)->where('vendor_id', $vendor_id)->count();
        } else {
            $ratting = Testimonials::where('item_id', $item_id)->where('vendor_id', $vendor_id)->where('star', $type)->count('star');
        }
        return $ratting;
    }
    public static function averagereview($item_id, $vendor_id)
    {
        $averagerating = Testimonials::where('item_id', $item_id)->where('vendor_id', $vendor_id)->avg('star');
        return $averagerating;
    }
    public static function getuserreviews($item_id, $vendor_id)
    {
        $review = Testimonials::select('testimonials.*', \DB::raw("CONCAT('" . url('/storage/app/public/admin-assets/images/profile') . "/', users.image) AS image_url"))->join('users', 'users.id', 'testimonials.user_id')->where('testimonials.vendor_id', $vendor_id)->where('item_id', $item_id)->get();
        return $review;
    }
    public static function getcouponcodecount($vendor_id, $coupon_code)
    {
        $count = Order::where('vendor_id', $vendor_id)->where('couponcode', $coupon_code)->count();
        return $count;
    }
    public static function getappsetting($vendor_id)
    {
        $appsetting = AppSettings::where('vendor_id', $vendor_id)->first();
        return $appsetting;
    }
    public static function getmin_maxorder($item_id, $vendor_id)
    {
        $item = Item::where('vendor_id', $vendor_id)->where('id', $item_id)->first();
        return $item;
    }
    public static function customstauts($vendor_id, $order_type)
    {
        $status = CustomStatus::where('vendor_id', $vendor_id)->where('order_type', $order_type)->where('is_available', 1)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return $status;
    }
    public static function gettype($status, $type, $order_type, $vendor_id)
    {
        $status = CustomStatus::where('vendor_id', $vendor_id)->where('order_type', $order_type)->where('type', $type)->where('id', $status)->first();
        return $status;
    }
    public static function getblogs($vendor_id)
    {
        $blogs = Blog::where('vendor_id', @$vendor_id)->orderBy('reorder_id')->get();
        return $blogs;
    }
    public static function getfaqs($vendor_id)
    {
        $faqs = Faq::where('vendor_id', @$vendor_id)->orderBy('reorder_id')->get();
        return $faqs;
    }
    public static function getsociallinks($vendor_id)
    {
        $links = SocialLinks::where('vendor_id', $vendor_id)->get();
        return $links;
    }
    public static function imagesize()
    {
        $imagesize = 2048;
        return $imagesize;
    }

    public static function imageresize($file,$directory_name)
    {
        $reimage = 'item-' . uniqid() . "." . $file->getClientOriginalExtension();

        $new_width = 1000;

        // create image manager with desired driver      

        $manager = new ImageManager(new Driver());

        // read image from file system
        $image = $manager->read($file);


        // Get Height & Width
        list($width, $height) = getimagesize("$file");

        // Get Ratio
        $ratio = $width / $height;

        // Create new height & width
        $new_height = $new_width / $ratio;

        // resize image proportionally to 200px width
        $image->scale(width: $new_width, height: $new_height);

        $extension = File::extension($reimage);

        $exif = @exif_read_data("$file");

        $degrees = 0;
        if (isset($exif['Orientation'])) {
            switch ($exif['Orientation']) {
                case 8:
                    $degrees = 90;
                    break;
                case 3:
                    $degrees = 180;
                    break;
                case 6:
                    $degrees = -90;
                    break;
            }
        }

        // $image->rotate($degrees);
        $convert = $image;
        if (Str::endsWith($reimage, '.jpeg')) {
            $convert = $convert->toJpeg();
        } else if (Str::endsWith($reimage, '.jpg')) {
            $convert = $convert->toJpeg();
        } else if (Str::endsWith($reimage, '.webp')) {
            $convert = $convert->toWebp();
        } else if (Str::endsWith($reimage, '.gif')) {
            $convert = $convert->toGif();
        } else if (Str::endsWith($reimage, '.png')) {
            $convert = $convert->toPng();
        } else if (Str::endsWith($reimage, '.avif')) {
            $convert = $convert->toAvif();
        } else if (Str::endsWith($reimage, '.bmp')) {
            $convert = $convert->toBitmap();
        }

        $convertimg = str_replace($extension, 'webp', $reimage);

        $convert->save("$directory_name/$convertimg");

        return $convertimg;
    }
    public static function gettax($tax_id)
    {
        $taxArr = explode('|', $tax_id);
        $taxes = [];
        foreach ($taxArr as $tax) {
            $taxes[] = Tax::find($tax);
        }
        return $taxes;
    }

    public static function taxRate($taxRate, $price, $quantity, $tax_type)
    {
        if ($tax_type == 1) {
            return $taxRate * $quantity;
        }

        if ($tax_type == 2) {
            return ($taxRate / 100) * ($price * $quantity);
        }
    }
    // landing page condition
    public static function storedata()
    {
        $userdata = User::select('users.id','name','slug','settings.description','website_title','cover_image')->where('users.available_on_landing',1)->where('users.id','!=',1)->join('settings','users.id', '=', 'settings.vendor_id')->get();
        return $userdata;
    }

    public static function landingsettings()
    {
        $landigsettings = LandingSettings::where('vendor_id',1)->first();
        return $landigsettings;
    }
}
