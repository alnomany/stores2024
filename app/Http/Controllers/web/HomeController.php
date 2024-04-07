<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Item;
use App\Models\Cart;
use App\Models\DeliveryArea;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Settings;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Timing;
use App\Models\Payment;
use App\Models\Contact;
use App\Models\Coupons;
use App\Models\Terms;
use App\Models\About;
use App\Models\Privacypolicy;
use App\Models\Banner;
use App\Models\Favorite;
use App\Models\Variants;
use App\Helpers\helper;
use App\Models\DineIn;
use App\Models\CustomStatus;
use Session;
use DateTime;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;
use DateInterval;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SystemAddons;
use App\Models\Testimonials;
use Validator;
use Carbon\CarbonPeriod;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Config;

class HomeController extends Controller
{
    /**3
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $getitem = Item::with(['variation', 'extras', 'product_image', 'multi_image'])->select('items.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))->leftjoin('testimonials', 'testimonials.item_id', 'items.id')->where('items.vendor_id', @$storeinfo->id)->where('items.is_available', '1')->groupBy('items.id')->orderBy('items.reorder_id', 'ASC')->get();
        $settingdata = Settings::where('vendor_id', @$storeinfo->id)->select('template')->first();

        $bannerimage = Banner::with('category_info', 'product_info')->where('vendor_id', @$storeinfo->id)->where('section', 1)->orderBy('reorder_id')->get();
        $cartitems = Cart::select('id', 'item_id', 'item_name', 'item_image', 'item_price', 'extras_id', 'extras_name', 'extras_price', 'qty', 'price', 'tax', 'variants_id', 'variants_name', 'variants_price', 'attribute')
            ->where('vendor_id', @$storeinfo->id);
        if (Auth::user() && Auth::user()->type == 3) {
            $cartitems->where('user_id', @Auth::user()->id);
        } else {
            $cartitems->where('session_id', Session::getId());
        }
        $cartdata = $cartitems->get();
        if (empty($storeinfo)) {
            abort(404);
        }
        if (Auth::user() && Auth::user()->type == 3) {
            $count = Cart::where('user_id', Auth::user()->id)->where('vendor_id', @$storeinfo->id)->count();
        } else {
            $count = Cart::where('session_id', Session::getId())->where('vendor_id', @$storeinfo->id)->count();
        }
        $sliders = Banner::with('category_info', 'product_info')->where('vendor_id', $storeinfo->id)->where('section', 0)->orderBy('reorder_id')->get();
        $testimonials = Testimonials::where('vendor_id', $storeinfo->id)->where('item_id', null)->where('user_id', null)->orderBy('reorder_id')->get();
        session()->put('cart', $count);
        return view('front.template-' . $settingdata->template . '.home', compact('getitem', 'storeinfo', 'bannerimage', 'cartdata', 'sliders', 'testimonials'));
    }
    public function privacyshow(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $privacy = Privacypolicy::where('vendor_id', @$storeinfo->id)->orderBy('id', 'ASC')->first();
        return view('front.privacy', compact('storeinfo', 'privacy'));
    }
    public function terms_condition(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $terms = terms::where('vendor_id', @$storeinfo->id)->orderBy('id', 'ASC')->first();
        return view('front.terms', compact('storeinfo', 'terms'));
    }
    public function aboutus(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $about = About::where('vendor_id', @$storeinfo->id)->orderBy('id', 'ASC')->first();
        return view('front.about', compact('storeinfo', 'about'));
    }
    public function show(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $getitem = Item::where('cat_id', '=', $request->id)->where('is_available', '1')->where('vendor_id', @$storeinfo->id)->orderBy('reorder_id', 'ASC')->paginate(9);
        $settingdata = Settings::where('vendor_id', $storeinfo->id)->select('template')->first();
        $cartitems = Cart::select('id', 'item_id', 'item_name', 'item_image', 'item_price', 'extras_name', 'extras_price', 'qty', 'price', 'tax', 'variants_id', 'variants_name', 'variants_price')
            ->where('vendor_id', @$storeinfo->id);
        if (Auth::user() && Auth::user()->type == 3) {
            $cartitems->where('user_id', @Auth::user()->id);
        } else {
            $cartitems->where('session_id', Session::getId());
        }
        $cartdata = $cartitems->get();
        return view('front.template-' . $settingdata->template . '.home', compact('getitem', 'storeinfo', 'bannerimage', 'cartdata'));
    }
    public function details(Request $request)
    {
        $getitem = Item::with(['variation', 'extras', 'product_image', 'multi_image'])->select('items.vendor_id', 'items.id', 'items.attribute', \DB::raw("CONCAT('" . asset('/storage/app/public/item/') . "/', items.image) AS image"), 'items.image as image_name', 'items.item_name', 'items.sku', 'items.item_price', 'items.video_url', 'items.qty', 'items.item_original_price', 'items.tax', 'items.description', 'categories.name', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'), 'attchment_name', \DB::raw("CONCAT('" . url('/storage/app/public/admin-assets/images/product') . "/', attchment_file) AS attchment_url"), 'items.view_count', 'items.has_variants', 'items.variants_json', 'items.stock_management')
            ->join('categories', 'items.cat_id', '=', 'categories.id')
            ->leftjoin('testimonials', 'testimonials.item_id', 'items.id')
            ->where('items.id', $request->id)->first();
        $getitem->view_count = $getitem->view_count + 1;
        $getitem->update();
        if (count($getitem['variation']) <= 0) {
            $getitem->item_p = helper::currency_formate($getitem->item_price, $getitem->vendor_id);
            $getitem->item_original_p = helper::currency_formate($getitem->item_original_price, $getitem->vendor_id);
            $getitem->item_original_price = $getitem->item_original_price;
        }

        $getitem->variants_json = json_decode($getitem->variants_json, true);

        return response()->json(['ResponseCode' => 1, 'ResponseText' => 'Success', 'ResponseData' => $getitem], 200);
    }

    public function getProductsVariantQuantity(Request $request)
    {

        $status = false;
        $quantity = $variant_id = 0;
        $product = Item::find($request->item_id);
        $price = 0;
        $status = false;

        if ($product && $request->name != '') {

            $variant = Variants::where('item_id', $request->item_id)->where('name', $request->name)->first();

            $status = true;
            $quantity = @$variant->qty - (isset($cart[@$variant->id]['qty']) ? $cart[@$variant->id]['qty'] : 0);
            $price = @$variant->price;
            $original_price = @$variant->original_price;
            $variant_id = @$variant->id;
            $min_order = @$variant->min_order;
            $max_order = @$variant->max_order;
            $stock_management = @$variant->stock_management;
            $variants_name = @$request->name;
            $is_available = @$variant->is_available;
        }

        return response()->json(
            [
                'status' => $status,
                'price' => $price,
                'original_price' => $original_price,
                'quantity' => $quantity,
                'variant_id' => $variant_id,
                'min_order' => $min_order,
                'max_order' => $max_order,
                'stock_management' => $stock_management,
                'variants_name' => $variants_name,
                'is_available' => $is_available,

            ]
        );
    }

    public function addtocart(Request $request)
    {
        try {
            $storeinfo = User::where('id', $request->vendor_id)->first();
            $cart = new Cart;
            $variation = Variants::where('name', $request->variants_name)->first();
            $item = Item::where('id', $request->item_id)->first();
            if (Auth::user() && Auth::user()->type == 3) {
                $cart->user_id = Auth::user()->id;
            } else {
                $cart->session_id = Session::getId();
            }
            if ($request->variants_name != null && $request->variants_name != "") {
                if (Auth::user() && Auth::user()->type == 3) {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('variants_id', $variation->id)->where('user_id', Auth::user()->id)->first();
                } else {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('variants_id', $variation->id)->where('session_id', Session::getId())->first();
                }
            } else {
                if (Auth::user() && Auth::user()->type == 3) {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('item_id', $request->item_id)->where('user_id', Auth::user()->id)->first();
                } else {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('item_id', $request->item_id)->where('session_id', Session::getId())->first();
                }
            }

            if ($cartqty->totalqty != null && $cartqty->totalqty != "") {
                $qty = $cartqty->totalqty + $request->qty;
            } else {
                $qty = $request->qty;
            }

            if ($request->stock_management == 1) {
                if ($request->min_order != null && $request->min_order != ""  && $request->min_order != 0) {
                    if ($qty < $request->min_order) {
                        return response()->json(['status' => 0, 'message' => trans('messages.min_qty_message') . $request->min_order], 200);
                    }
                }
                if ($request->max_order != null && $request->max_order != "" && $request->max_order != 0) {
                    if ($qty > $request->max_order) {
                        if ($cartqty->totalqty == null) {
                            return response()->json(['status' => 0, 'message' => trans('messages.max_qty_message') . $request->max_order], 200);
                        } else {
                            return response()->json(['status' => 0, 'message' => trans('messages.cart_qty_msg') . ' ' . trans('messages.max_qty_message') . $request->max_order], 200);
                        }
                    }
                }
                if ($request->variants_name == "" && $request->variants_name == null) {
                    if ($qty > $item->qty) {
                        return response()->json(['status' => 0, 'message' => trans('labels.out_of_stock_msg') . ' ' . $item->item_name], 200);
                    }
                } else {
                    if ($qty > $variation->qty) {
                        return response()->json(['status' => 0, 'message' => trans('labels.out_of_stock_msg') . ' ' . $item->item_name . '(' . $variation->name . ')'], 200);
                    }
                }
            }
            if (!empty($variation)) {
                $cartprice = $variation->price;
            } else {
                $cartprice = $request->item_price;
            }

            $extra_price = explode('|', $request->extras_price);
            if ($request->extras_price != null || $request->extras_price != "") {
                foreach ($extra_price as $price) {
                    $cartprice  = $cartprice +  $price;
                }
            }

            $cart->vendor_id = $request->vendor_id;
            $cart->item_id = $request->item_id;
            $cart->item_name = $request->item_name;
            $cart->item_image = $request->item_image;
            $cart->item_price = $cartprice;
            $cart->tax = $request->tax;
            $cart->extras_name = $request->extras_name;
            $cart->extras_price = $request->extras_price;
            $cart->extras_id = $request->extras_id;
            $cart->qty = $request->qty;
            $cart->price = (float)$cartprice * (float)$request->qty;
            if (!empty($variation)) {
                $cart->variants_id = $variation->id;
                $cart->variants_name = $request->variants_name;
            }
            $cart->variants_price = $request->item_price;
            $cart->save();
            if (Auth::user() && Auth::user()->type == 3) {
                $count = Cart::where('user_id', Auth::user()->id)->where('vendor_id', @$storeinfo->id)->count();
            } else {
                $count = Cart::where('session_id', Session::getId())->where('vendor_id', @$storeinfo->id)->count();
            }
            session()->put('cart', $count);
            session()->put('vendor_id', $request->vendor_id);
            return response()->json(['status' => 1, 'message' => trans('messages.add_to_cart_msg')], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 0, 'message' => $e], 400);
        }
    }
    public function cart(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $cartitems = Cart::select('id', 'item_id', 'attribute', 'item_name', 'item_image', 'item_price', 'extras_name', 'extras_id', 'extras_price', 'qty', 'price', 'tax', 'variants_id', 'variants_name', 'variants_price')
            ->where('vendor_id', @$storeinfo->id);
        if (Auth::user() && Auth::user()->type == 3) {
            $cartitems->where('user_id', @Auth::user()->id);
        } else {
            $cartitems->where('session_id', Session::getId());
        }
        $cartdata = $cartitems->get();
        return view('front.cart', compact('cartdata', 'storeinfo'));
    }
    public function checkout(Request $request)
    {
       
        $storeinfo = helper::storeinfo($request->vendor);
        $cartitems = Cart::select('carts.id', 'carts.item_id', 'carts.item_name', 'carts.item_image', 'carts.item_price', 'carts.extras_name', 'carts.extras_price', 'carts.qty', 'carts.price', 'carts.tax', 'carts.variants_id', 'carts.variants_name', 'carts.variants_price', \DB::raw("GROUP_CONCAT(tax.name) as name"))
            ->leftjoin("tax", \DB::raw("FIND_IN_SET(tax.id,carts.tax)"), ">", \DB::raw("'0'"))
            ->where('carts.vendor_id', @$storeinfo->id);
        if (Auth::user() && Auth::user()->type == 3) {
            $cartitems->where('carts.user_id', @Auth::user()->id);
        } else {
            $cartitems->where('carts.session_id', Session::getId());
        }
        $cartdata = $cartitems->groupBy("carts.id")->get();
        //  product count tax
        $itemtaxes = [];
        $producttax = 0;
        $tax_name = [];
        $tax_price = [];
        foreach ($cartdata as $cart) {
            if ($cart->variants_id != "" && $cart->variants_id != null) {
              
                $variant = Variants::where('id', $cart->variants_id)->first();
                $item_name = Item::select('item_name')->where('id', $cart->item_id)->first();
                if ($variant->stock_management == 1) {
                    if ($cart->qty > $variant->qty) {
                        return redirect()->back()->with('error', trans('messages.cart_qty_msg') . ' ' . trans('labels.out_of_stock_msg') . ' ' . $item_name->item_name . '(' . $variant->name . ')');
                    }
                }
            } else {
                $item = Item::where('id', $cart->item_id)->first();
                if ($item->stock_management == 1) {
                   
                    if ($cart->qty > $item->qty) {
                        return redirect()->back()->with('error',  trans('messages.cart_qty_msg') . ' ' . trans('labels.out_of_stock_msg') . ' ' . $item->item_name);
                    }
                }
            }
        }
        foreach ($cartdata as $cart) {
            $taxlist =  helper::gettax($cart->tax);
            if (!empty($taxlist)) {
                foreach ($taxlist as $tax) {
                    if (!empty($tax)) {
                        $producttax = helper::taxRate($tax->tax, $cart->price, $cart->qty, $tax->type);
                        $itemTax['tax_name'] = $tax->name;
                        $itemTax['tax'] = $tax->tax;
                        $itemTax['tax_rate'] = $producttax;
                        $itemtaxes[] = $itemTax;

                        if (!in_array($tax->name, $tax_name)) {
                            $tax_name[] = $tax->name;

                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->price);
                            }
                            $tax_price[] = $price;
                        } else {
                            if ($tax->type == 1) {
                                $price = $tax->tax * $cart->qty;
                            }

                            if ($tax->type == 2) {
                                $price = ($tax->tax / 100) * ($cart->price);
                            }
                            $tax_price[array_search($tax->name, $tax_name)] += $price;
                        }
                    }
                }
            }
        }

        $taxArr['tax'] = $tax_name;
        $taxArr['rate'] = $tax_price;

        $deliveryarea = DeliveryArea::where('vendor_id', @$storeinfo->id)->orderBy('reorder_id')->get();
        $paymentlist = Payment::where('is_available', '1')->where('vendor_id', @$storeinfo->id)->where('is_activate', 1)->orderBy('reorder_id')->get();
        $tables = DineIn::where('vendor_id', $storeinfo->id)->where('is_available', 1)->orderBy('reorder_id')->get();

        return view('front.checkout', compact('cartdata', 'deliveryarea', 'storeinfo', 'paymentlist', 'tables', 'itemtaxes', 'taxArr'));
    }
    public function qtycheckurl(Request $request)
    {
        try {
            $cartitems = Cart::select('carts.id', 'carts.item_id', 'carts.item_name', 'carts.item_image', 'carts.item_price', 'carts.extras_name', 'carts.extras_price', 'carts.qty', 'carts.price', 'carts.tax', 'carts.variants_id', 'carts.variants_name', 'carts.variants_price', \DB::raw("GROUP_CONCAT(tax.name) as name"))
                ->leftjoin("tax", \DB::raw("FIND_IN_SET(tax.id,carts.tax)"), ">", \DB::raw("'0'"))
                ->where('carts.vendor_id', @$request->vendor_id);
            if (Auth::user() && Auth::user()->type == 3) {
                $cartitems->where('carts.user_id', @Auth::user()->id);
            } else {
                $cartitems->where('carts.session_id', Session::getId());
            }
            $cartdata = $cartitems->groupBy("carts.id")->get();
            $qtyexist = 0;
            foreach ($cartdata as $cart) {
                if ($cart->variants_id != "" && $cart->variants_id != null) {
                    $item = Item::where('id', $cart->item_id)->first();
                    $variant = Variants::where('id', $cart->variants_id)->first();
                    if ($variant->stock_management == 1) {
                        if ($cart->qty > $variant->qty) {
                            $qtyexist = 1;
                            return response()->json(['status' => 0, 'message' => trans('messages.cart_qty_msg') . ' ' . trans('labels.out_of_stock_msg') . ' ' . $item->item_name . '' . '(' . $variant->name . ')'], 200);
                        }
                    } else {
                        $qtyexist = 0;
                    }
                } else {
                    $item = Item::where('id', $cart->item_id)->first();
                    if ($item->stock_management == 1) {
                        if ($cart->qty > $item->qty) {
                            $qtyexist = 1;
                            return response()->json(['status' => 0, 'message' => trans('messages.cart_qty_msg') . ' ' . trans('labels.out_of_stock_msg') . ' ' . $item->item_name], 200);
                        }
                    } else {
                        $qtyexist = 0;
                    }
                }
            }
            if ($qtyexist == 0) {
                return response()->json(['status' => 1, 'message' => ''], 200);
            } 
        } catch (\Throwable $th) {

            return response()->json(['status' => 0, 'message' => $th], 400);
        }
    }
    public function qtyupdate(Request $request)
    {

        try {
            $item = Item::where('id', $request->item_id)->first();
            if ($request->variants_id != null) {
                $variant = Variants::where('id', $request->variants_id)->where('item_id', $request->item_id)->first();
                if (Auth::user() && Auth::user()->type == 3) {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('variants_id', $variant->id)->where('id', '!=', $request['cart_id'])->where('user_id', Auth::user()->id)->first();
                } else {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('variants_id', $variant->id)->where('id', '!=', $request['cart_id'])->where('session_id', Session::getId())->first();
                }
                if ($cartqty->totalqty != null && $cartqty->totalqty != "") {
                    $qty = $cartqty->totalqty + $request->qty;
                } else {
                    $qty = $request->qty;
                }
                if ($variant->stock_management == 1) {
                    if ($variant->min_order != null && $variant->min_order != "" && $variant->min_order != 0) {
                        if ($variant->min_order > $qty) {
                            return response()->json(['status' => 0, 'message' => trans('messages.min_qty_message') . $variant->min_order, 'qty' => $request->qty], 200);
                        }
                    }
                    if ($variant->max_order != null && $variant->max_order != "" && $variant->max_order != 0) {
                        if ($variant->max_order < $qty) {
                            return response()->json(['status' => 0, 'message' => trans('messages.max_qty_message') . $variant->max_order, 'qty' => $request->qty - 1], 200);
                        }
                    }
                    if ($request->qty == $variant->qty) {
                        Cart::where('id', $request['cart_id'])->update(['qty' => $request->qty, 'price' => $request->price]);
                        return response()->json(['status' => 1, 'message' => trans('messages.qty_update_msg')], 200);
                    }
                    if ($variant->qty < $request->qty) {
                        return response()->json(['status' => 0, 'message' => trans('labels.out_of_stock_msg') . ' ' . $item->item_name . '(' . $variant->name . ')', 'qty' => $request->qty - 1], 200);
                    } else {
                        Cart::where('id', $request['cart_id'])->update(['qty' => $request->qty, 'price' => $request->price]);
                        return response()->json(['status' => 1, 'message' => trans('messages.qty_update_msg')], 200);
                    }
                } else {
                    Cart::where('id', $request['cart_id'])->update(['qty' => $request->qty, 'price' => $request->price]);
                    return response()->json(['status' => 1, 'message' => trans('messages.qty_update_msg')], 200);
                }
            } elseif ($request->variants_id == null) {


                if (Auth::user() && Auth::user()->type == 3) {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('item_id', $item->id)->where('id', '!=', $request['cart_id'])->where('user_id', Auth::user()->id)->first();
                } else {
                    $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('item_id', $item->id)->where('id', '!=', $request['cart_id'])->where('session_id', Session::getId())->first();
                }

                if ($cartqty->totalqty != null && $cartqty->totalqty != "") {
                    $qty = $cartqty->totalqty + $request->qty;
                } else {
                    $qty = $request->qty;
                }
                if ($item->stock_management == 1) {
                    if ($item->min_order != null && $item->min_order != "" && $item->min_order != 0) {
                        if ($item->min_order > $qty) {
                            return response()->json(['status' => 0, 'message' => trans('messages.min_qty_message') . $item->min_order, 'qty' => $request->qty], 200);
                        }
                    }
                    if ($item->max_order != null && $item->max_order != "" && $item->max_order != 0) {
                        if ($item->max_order < $qty) {
                            return response()->json(['status' => 0, 'message' => trans('messages.max_qty_message') . $item->max_order, 'qty' => $request->qty - 1], 200);
                        }
                    }

                    if ($request->qty == $item->qty) {
                        Cart::where('id', $request['cart_id'])->update(['qty' => $request->qty, 'price' => $request->price]);
                        return response()->json(['status' => 1, 'message' => trans('messages.qty_update_msg')], 200);
                    }
                    if ($item->qty < $request->qty) {
                        return response()->json(['status' => 0, 'message' => trans('labels.out_of_stock_msg') . ' ' . $item->item_name, 'qty' => $request->qty - 1], 200);
                    } else {
                        Cart::where('id', $request['cart_id'])->update(['qty' => $request->qty, 'price' => $request->price]);
                        return response()->json(['status' => 1, 'message' => trans('messages.qty_update_msg')], 200);
                    }
                } else {
                    Cart::where('id', $request['cart_id'])->update(['qty' => $request->qty, 'price' => $request->price]);
                    return response()->json(['status' => 1, 'message' => trans('messages.qty_update_msg')], 200);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function deletecartitem(Request $request)
    {
        if ($request->cart_id == "") {
            return response()->json(["status" => 0, "message" => trans('messages.cart_required_msg')], 200);
        }
        $cart = Cart::where('id', $request->cart_id)->delete();
        if (Auth::user() && Auth::user()->type == 3) {
            $count = Cart::where('user_id', Auth::user()->id)->where('vendor_id', $request->vendor_id)->count();
        } else {
            $count = Cart::where('session_id', Session::getId())->where('vendor_id', $request->vendor_id)->count();
        }
        session()->put('cart', $count);
        session()->forget(['offer_amount', 'offer_code', 'offer_type']);
        if ($cart) {
            return response()->json(['status' => 1, 'message' => 'Success', 'cartcnt' => $count], 200);
        } else {
            return response()->json(['status' => 0], 200);
        }
    }
    public function applypromocode(Request $request)
    {

        if ($request->promocode == "") {
            return response()->json(["status" => 0, "message" => trans('messages.enter_promocode')], 200);
        }
        $promocode = Coupons::select('offer_amount', 'offer_type', 'offer_code')->where('offer_code', $request->promocode)->where('vendor_id', $request->vendor_id)->first();
        if ($request->sub_total < @$promocode->price) {
            return response()->json(["status" => 0, "message" => trans('messages.not_eligible')], 200);
        }

        $offer_amount = $promocode->offer_amount;
        if ($promocode->offer_type == 2) {
            $offer_amount = $request->sub_total * $promocode->offer_amount / 100;
        }
        session([
            'offer_amount' => @$offer_amount,
            'offer_code' => @$promocode->offer_code,
            'offer_type' => @$promocode->offer_type,
        ]);
        if (@$promocode->offer_code == $request->promocode) {

            return response()->json(['status' => 1, 'message' => trans('messages.promocode_applied'), 'data' => $promocode], 200);
        } else {

            return response()->json(['status' => 0, 'message' => trans('messages.wrong_promocode')], 200);
        }
    }
    public function removepromocode(Request $request)
    {
        $remove = session()->forget(['offer_amount', 'offer_code', 'offer_type']);
        if (!$remove) {
            return response()->json(['status' => 1, 'message' => trans('messages.promocode_removed')], 200);
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function checkplan(Request $request)
    {
        $checkplan = helper::checkplan($request->vendor_id, '3');
        return $checkplan;
    }
    public function paymentmethod(Request $request)
    {

        $payment_id = "";
        $user_id = "";
        $session_id = "";
        $filename = "";
        $storeinfo = helper::storeinfo($request->vendor);
        if (Auth::user() && Auth::user()->type == 3) {
            $user_id = Auth::user()->id;
        } else {
            $session_id = session()->getId();
        }
        $cartitems = Cart::select('carts.id', 'carts.item_id', 'carts.item_name', 'carts.item_image', 'carts.item_price', 'carts.extras_name', 'carts.extras_price', 'carts.qty', 'carts.price', 'carts.tax', 'carts.variants_id', 'carts.variants_name', 'carts.variants_price', \DB::raw("GROUP_CONCAT(tax.name) as name"))
            ->leftjoin("tax", \DB::raw("FIND_IN_SET(tax.id,carts.tax)"), ">", \DB::raw("'0'"))
            ->where('carts.vendor_id', $request->vendor_id);
        if (Auth::user() && Auth::user()->type == 3) {
            $cartitems->where('carts.user_id', @$user_id);
        } else {
            $cartitems->where('carts.session_id', $session_id);
        }
        $cartdata = $cartitems->groupBy("carts.id")->get();

        foreach ($cartdata as $cart) {
            if ($cart->variants_id != "" && $cart->variants_id != null) {
                $variant = Variants::where('id', $cart->variants_id)->first();
                if ($variant->stock_management == 1) {
                    if ($cart->qty > $variant->qty) {
                        return response()->json(['status' => 0, 'message' => trans($variant->name . 'qty not enough for order !!')], 200);
                    }
                }
            } else {
                $item = Item::where('id', $cart->item_id)->first();
                if ($item->stock_management == 1) {
                    if ($cart->qty > $item->qty) {
                        return response()->json(['status' => 0, 'message' => trans($item->name . 'qty not enough for order !!')], 200);
                    }
                }
            }
        }

        if ($request->payment_type == "3") {
            $getstripe = Payment::select('environment', 'secret_key', 'currency')->where('payment_type', 3)->where('vendor_id', $request->vendor_id)->first();
            $skey = $getstripe->secret_key;
            Stripe::setApiKey($skey);
            $customer = Customer::create(
                array(
                    'email' => $request->customer_email,
                    'source' =>  $request->stripeToken,
                    'name' => $request->customer_name,
                )
            );
            $charge = Charge::create(
                array(
                    'customer' => $customer->id,
                    'amount' => $request->grand_total * 100,
                    'currency' => $getstripe->currency,
                    'description' => 'Store-Mart',
                )
            );

            if ($request->payment_id == "") {
                $payment_id = $charge['id'];
            } else {
                $payment_id = $request->payment_id;
            }
        }
        $payment_id = $request->payment_id;
        if ($request->payment_type == '6') {
            if ($request->hasFile('screenshot')) {
                $validator = Validator::make($request->all(), [
                    'screenshot' => 'image|mimes:jpg,jpeg,png',
                ], [
                    'screenshot.mage' => trans('messages.enter_image_file'),
                    'screenshot.mimes' => trans('messages.valid_image'),
                ]);
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                    $filename = 'screenshot-' . uniqid() . "." . $request->file('screenshot')->getClientOriginalExtension();
                    $request->file('screenshot')->move(env('ASSETPATHURL') . 'admin-assets/images/screenshot/', $filename);
                }
            }
            $payment_id = "";
            $orderresponse = helper::createorder($request->modal_vendor_id, $user_id, $session_id, $request->payment_type, $payment_id, $request->modal_customer_email, $request->modal_customer_name, $request->modal_customer_mobile, $request->stripeToken, $request->modal_grand_total, $request->modal_delivery_charge, $request->modal_address, $request->modal_building, $request->modal_landmark, $request->modal_postal_code, $request->modal_discount_amount, $request->modal_subtotal, $request->modal_tax, $request->modal_tax_name, $request->modal_delivery_time, $request->modal_delivery_date, $request->modal_delivery_area, $request->modal_couponcode, $request->modal_order_type, $request->modal_notes, $filename, $request->modal_table, $request->modal_tablename);
            $vendor = User::where('id', $request->modal_vendor_id)->first();
            return redirect($vendor->slug . '/success/' . $orderresponse)->with('success', trans('messages.order_placed'));
        } else {

            $orderresponse = helper::createorder($request->vendor_id, $user_id, $session_id, $request->payment_type, $payment_id, $request->customer_email, $request->customer_name, $request->customer_mobile, $request->stripeToken, $request->grand_total, $request->delivery_charge, $request->address, $request->building, $request->landmark, $request->postal_code, $request->discount_amount, $request->sub_total, $request->tax, $request->tax_name, $request->delivery_time, $request->delivery_date, $request->delivery_area, $request->couponcode, $request->order_type, $request->notes, $filename, $request->table, $request->tablename);
        }
        if ($orderresponse == 1) {
            return response()->json(['status' => 0, 'message' => trans('order not placed without default status !!')], 200);
        } else {
            return response()->json(['status' => 1, 'message' => trans('messages.order_placed'), "order_number" => $orderresponse], 200);
        }
    }

    public function terms(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $terms = Terms::select('terms_content')
            ->where('vendor_id', @$storeinfo->id)
            ->first();

        return view('front.terms', compact('storeinfo', 'terms'));
    }
    public function privacy(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $privacypolicy = Privacypolicy::select('privacypolicy_content')
            ->where('vendor_id', @$storeinfo->id)
            ->first();
        return view('front.privacy', compact('storeinfo', 'privacypolicy'));
    }
    public function book(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);

        return view('front.book', compact('storeinfo'));
    }

    public function ordersuccess(Request $request)
    {

        $storeinfo = helper::storeinfo($request->vendor);
        $order_number = $request->order_number;
        $whmessage = helper::whatsappmessage($request->order_number, $storeinfo->slug, $storeinfo);
        return view('front.ordersuccess', compact('storeinfo', 'order_number', 'whmessage'));
    }

    public function ordercreate(Request $request)
    {

        if (@$request->paymentId != "") {
            $paymentid = $request->paymentId;
        }
        if (@$request->payment_id != "") {
            $paymentid = $request->payment_id;
        }
        if (@$request->transaction_id != "") {
            $paymentid = $request->transaction_id;
        }
        $user_id = "";
        $session_id = "";
        if (Auth::user() && Auth::user()->type == 3) {
            $user_id = Auth::user()->id;
        } else {
            $session_id = session()->getId();
        }
        $orderresponse = helper::createorder(Session::get('vendor_id'), $user_id, $session_id, Session::get('payment_type'), @$paymentid, Session::get('customer_email'), Session::get('customer_name'), Session::get('customer_mobile'), Session::get('stripeToken'), Session::get('grand_total'), Session::get('delivery_charge'), Session::get('address'), Session::get('building'), Session::get('landmark'), Session::get('postal_code'), Session::get('discount_amount'), Session::get('sub_total'), Session::get('tax'), Session::get('tax_name'), Session::get('delivery_time'), Session::get('delivery_date'), Session::get('delivery_area'), Session::get('couponcode'), Session::get('order_type'), Session::get('notes'), '', Session::get('table'), Session::get('tablename'));
        $slug = Session::get('slug');
        return redirect($slug . '/success/' . $orderresponse)->with('success', trans('messages.order_placed'));
    }

    public function timeslot(Request $request)
    {
        try {
            $timezone = helper::appdata($request->vendor_id);
            $slots = [];
            date_default_timezone_set($timezone->timezone);

            if ($request->inputDate != "" || $request->inputDate != null) {
                $day = date('l', strtotime($request->inputDate));
                $minute = "";
                $time = Timing::where('vendor_id', $request->vendor_id)->where('day', $day)->first();
                if ($time->is_always_close == 1) {
                    $slots = "1";
                } else {
                    if (helper::appdata($request->vendor_id)->interval_type == 2) {
                        $minute = (float)helper::appdata($request->vendor_id)->interval_time * 60;
                    }
                    if (helper::appdata($request->vendor_id)->interval_type == 1) {
                        $minute = helper::appdata($request->vendor_id)->interval_time;
                    }
                    $firsthalf = new CarbonPeriod(date("H:i", strtotime($time->open_time)), $minute . ' minutes', date("H:i", strtotime($time->break_start))); // for create use 24 hours format later change format 
                    $secondhalf =  new CarbonPeriod(date("H:i", strtotime($time->break_end)), $minute . ' minutes', date("H:i", strtotime($time->close_time)));
                    if (helper::appdata($request->vendor_id)->time_format == 1) {
                        foreach ($firsthalf as $item) {
                            $starttime[] = $item->format("H:i");
                        }
                        foreach ($secondhalf as $item) {
                            $endtime[] = $item->format("H:i");
                        }
                    } else {
                        foreach ($firsthalf as $item) {
                            $starttime[] = $item->format("h:i A");
                        }
                        foreach ($secondhalf as $item) {
                            $endtime[] = $item->format("h:i A");
                        }
                    }

                    for ($i = 0; $i < count($starttime) - 1; $i++) {
                        $temparray[] = $starttime[$i] . ' ' . '-' . ' ' . next($starttime);
                    }
                    for ($i = 0; $i < count($endtime) - 1; $i++) {
                        $temparray[] = $endtime[$i] . ' ' . '-' . ' ' . next($endtime);
                    }
                    $currenttime = Carbon::now()->format('h:i a');
                    $current_date = Carbon::now()->format('Y-m-d');

                    foreach ($temparray as $item) {
                        $ordercount = Order::where('delivery_date', $request->inputDate)->where('delivery_time', $item)->count();
                        if ($ordercount < helper::appdata($request->vendor_id)->per_slot_limit) {
                            if ($request->inputDate == $current_date) {
                                $slottime = explode('-', $item);
                                if (strtotime($slottime[0]) <= strtotime($currenttime)) {
                                    $status = "";
                                } else {
                                    $status = "active";
                                }
                            } else {
                                $status = "active";
                            }
                            $slots[] = array(
                                'slot' =>  $item,
                                'status' => $status,
                            );
                        }
                    }
                }
            }
            return $slots;
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }

    function firsthalf($duration, $cleanup, $start, $break_start)
    {
        $start = new DateTime($start);
        $break_start  = new DateTime($break_start);
        $interval = new DateInterval('PT' . $duration . 'M');
        $cleanupinterval = new DateInterval('PT' . $cleanup . 'M');
        $slots = array();

        for ($intStart = $start; $intStart < $break_start; $intStart->add($interval)->add($cleanupinterval)) {
            $endperiod = clone $intStart;
            $endperiod->add($interval);
            if (strtotime($break_start->format('h:i A')) < strtotime($endperiod->format('h:i A')) && strtotime($endperiod->format('h:i A')) < strtotime($break_start->format('h:i A'))) {
                $endperiod = $break_start;
                $slots[] = $intStart->format('h:i A') . ' - ' . $endperiod->format('h:i A');
                $intStart = $break_start;
                $endperiod = $break_start;
                $intStart->sub($interval);
            }
            $slots[] = $intStart->format('h:i A') . ' - ' . $endperiod->format('h:i A');
        }
        return $slots;
    }

    function secondhalf($duration, $cleanup, $break_end, $end)
    {
        $break_end = new DateTime($break_end);
        $end  = new DateTime($end);
        $interval = new DateInterval('PT' . $duration . 'M');
        $cleanupinterval = new DateInterval('PT' . $cleanup . 'M');
        $slots = array();

        for ($intStart = $break_end; $intStart < $end; $intStart->add($interval)->add($cleanupinterval)) {
            $endperiod = clone $intStart;
            $endperiod->add($interval);
            if (strtotime($end->format('h:i A')) < strtotime($endperiod->format('h:i A')) && strtotime($endperiod->format('h:i A')) < strtotime($break_end->format('h:i A'))) {
                $endperiod = $end;
                $slots[] = $intStart->format('h:i A') . ' - ' . $endperiod->format('h:i A');
                $intStart = $end;
                $endperiod = $end;
                $intStart->sub($interval);
            }
            $slots[] = $intStart->format('h:i A') . ' - ' . $endperiod->format('h:i A');
        }
        return $slots;
    }

    public function user_subscribe(Request $request)
    {
        try {
            $storeinfo = helper::storeinfo($request->vendor);
            $request->validate([
                'email' => 'required',
            ], [

                'email.required' => trans('messages.email_required'),
            ]);

            $subscribe = new Subscriber();
            $subscribe->vendor_id = $storeinfo->id;
            $subscribe->email = $request->email;
            $subscribe->save();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }

    public function contact(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        return view('front.contact', compact('storeinfo'));
    }
    public function save_contact(Request $request)
    {
        try {
            $request->validate([
                'fname' => 'required',
                'lname' => 'required',
                'email' => 'required|email',
                'mobile' => 'required',
                'message' => 'required',
            ], [
                'fname.required' => trans('message.first_name_required'),
                'lname.required' => trans('message.last_name_required'),
                'email.required' => trans('message.email_required'),
                'email.email' => trans('message.invalid_email'),
                'mobile.required' => trans('message.mobile_required'),
                'message.required' => trans('messages.message_required'),
            ]);

            if (
                SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first() != null &&
                SystemAddons::where('unique_identifier', 'cookie_recaptcha')->first()->activated == 1
            ) {

                if (helper::appdata('')->recaptcha_version == 'v2') {
                    $request->validate([
                        'g-recaptcha-response' => 'required'
                    ], [
                        'g-recaptcha-response.required' => 'The g-recaptcha-response field is required.'
                    ]);
                }

                if (helper::appdata('')->recaptcha_version == 'v3') {
                    $score = RecaptchaV3::verify($request->get('g-recaptcha-response'), 'contact');
                    if ($score <= helper::appdata('')->score_threshold) {
                        return redirect()->back()->with('error', trans('messages.recaptcha_msg'));
                    }
                }
            }

            $newcontact = new Contact();
            $newcontact->vendor_id = $request->vendor_id;
            $newcontact->name = $request->fname . $request->lname;
            $newcontact->email = $request->email;
            $newcontact->mobile = $request->mobile;
            $newcontact->message = $request->message;
            $newcontact->save();
            $vendordata = User::where('id', $request->vendor_id)->first();
            $emaildata = helper::emailconfigration($vendordata->id);
            Config::set('mail', $emaildata);
            helper::vendor_contact_data($vendordata->name, $vendordata->email, $request->fname . $request->lname, $request->email, $request->mobile, $request->message);
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
        }
    }

    public function cancelorder($order_number)
    {
        $orderdata = Order::where('order_number', $order_number)->first();
        $orderdetail = OrderDetails::where('order_id', $orderdata->id)->get();
        $storeinfo = User::where('id', $orderdata->vendor_id)->first();
        if ($orderdata->status_type == 4) {
            return redirect()->back()->with('error', trans('messages.already_rejected'));
        }
        if (helper::appdata($storeinfo->id)->product_type == 1) {
            if ($orderdata->status_type == 2) {
                return redirect()->back()->with('error', trans('messages.already_accepted'));
            } else if ($orderdata->status_type == 4) {
                return redirect()->back()->with('error', trans('messages.already_rejected'));
            } else if ($orderdata->status_type == 3) {
                return redirect()->back()->with('error', trans('messages.already_delivered'));
            }
        }
        $defaultsatus = CustomStatus::where('vendor_id', $storeinfo->id)->where('order_type', $orderdata->order_type)->where('type', 4)->where('is_available', 1)->where('is_deleted', 2)->first();
        if (helper::appdata($storeinfo->id)->product_type == 1) {
            if (empty($defaultsatus) && $defaultsatus == null) {
                return redirect()->back()->with('error', trans('messages.wrong'));
            } else {
                $orderdata->status_type = 4;
                if (helper::appdata($storeinfo->id)->product_type == 1) {
                    $orderdata->status = $defaultsatus->id;
                }
                $orderdata->update();
                foreach ($orderdetail as $order) {
                    if ($order->variants_id != null && $order->variants_id != "") {
                        $item = Variants::where('id', $order->variants_id)->where('item_id', $order->item_id)->first();
                    } else {
                        $item = Item::where('id', $order->item_id)->where('vendor_id', $storeinfo->id)->first();
                    }
                    $item->qty = $item->qty + $order->qty;
                    $item->update();
                }
                if (helper::appdata($storeinfo->id)->product_type == 1) {
                    $title = helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type, $orderdata->vendor_id)->name;
                } else {
                    $title = "{{trans('labels.order_cancelled')}}";
                }
                $message_text = 'Order ' . $orderdata->order_number . ' has been cancelled by' . $orderdata->user_name;
                $emaildata = helper::emailconfigration($storeinfo->id);
                Config::set('mail', $emaildata);
                $checkmail = helper::cancel_order($storeinfo->email, $storeinfo->name, $title, $message_text, $orderdata);
                $emaildata = User::select('id', 'name', 'slug', 'email', 'mobile', 'token')->where('id', $orderdata->vendor_id)->first();
                $body = "#" . $order_number . " has been cancelled";
                helper::push_notification($emaildata->token, $title, $body, "order", $orderdata->id);
                return redirect()->back()->with('success', trans('messages.success'));
            }
        } else {
            $orderdata->status_type = 4;
            $orderdata->update();
            if (helper::appdata($storeinfo->id)->product_type == 1) {
                $title = helper::gettype($orderdata->status, $orderdata->status_type, $orderdata->order_type, $orderdata->vendor_id)->name;
            } else {
                $title = "{{trans('labels.order_cancelled')}}";
            }
            $message_text = 'Order ' . $orderdata->order_number . ' has been cancelled by' . $orderdata->user_name;
            $emaildata = helper::emailconfigration($storeinfo->id);
            Config::set('mail', $emaildata);
            $checkmail = helper::cancel_order($storeinfo->email, $storeinfo->name, $title, $message_text, $orderdata);
            $emaildata = User::select('id', 'name', 'slug', 'email', 'mobile', 'token')->where('id', $orderdata->vendor_id)->first();
            $body = "#" . $order_number . " has been cancelled";
            helper::push_notification($emaildata->token, $title, $body, "order", $orderdata->id);
            return redirect()->back()->with('success', trans('messages.success'));
        }
    }

    public function invoice(Request $request)
    {
        $getorderdata = Order::where('order_number', $request->order_number)->first();
        if (empty($getorderdata)) {
            abort(404);
        }
        $ordersdetails = OrderDetails::where('order_id', $getorderdata->id)->get();
        return view('front.invoice', compact('getorderdata', 'ordersdetails'));
    }
    public function changeqty(Request $request)
    {

        if ($request->variants_name == null) {

            $item = item::where('id', $request->item_id)->where('vendor_id', $request->vendor_id)->first();
            if (Auth::user() && Auth::user()->type == 3) {
                $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('item_id', $item->id)->where('user_id', Auth::user()->id)->first();
            } else {

                $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('item_id', $item->id)->where('session_id', Session::getId())->first();
            }
            if ($cartqty->totalqty != null && $cartqty->totalqty != "") {
                $qty = $cartqty->totalqty + $request->qty;
            } else {
                $qty = $request->qty;
            }

            if ($item->stock_management == 1) {
                if ($item->min_order != null && $item->min_order != "" && $item->min_order != 0) {
                    if ($item->min_order > $qty) {
                        return response()->json(['status' => 0, 'message' => trans('messages.min_qty_message') . $item->min_order, 'qty' => $request->qty], 200);
                    }
                }
                if ($item->max_order != null && $item->max_order != "" && $item->max_order != 0) {
                    if ($item->max_order < $qty) {
                        if ($cartqty->totalqty == null) {
                            return response()->json(['status' => 0, 'message' => trans('messages.max_qty_message') . $item->max_order, 'qty' => $request->qty - 1], 200);
                        } else {
                            return response()->json(['status' => 0, 'message' => trans('messages.cart_qty_msg') . ' ' . trans('messages.max_qty_message') . $item->max_order, 'qty' => $request->qty - 1], 200);
                        }
                    }
                }
                if ($qty == $item->qty) {
                    return response()->json(['status' => 1, 'message' => 'success', 'qty' => $qty], 200);
                }
                if ($qty > $item->qty && ($item->qty != null && $item->qty != "")) {
                    return response()->json(['status' => 0, 'message' => trans('labels.out_of_stock_msg') . ' ' . $item->item_name, 'qty' => $request->qty - 1], 200);
                } else {
                    return response()->json(['status' => 1, 'message' => 'success', 'qty' => $request->qty], 200);
                }
            } else {
                return response()->json(['status' => 1, 'message' => 'success', 'qty' => $request->qty], 200);
            }
        } else {
            $item = Variants::where('name', $request->variants_name)->where('item_id', $request->item_id)->first();
            $item_name = Item::select('item_name')->where('id', $request->item_id)->first();
            if (Auth::user() && Auth::user()->type == 3) {
                $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('variants_id', $item->id)->where('user_id', Auth::user()->id)->first();
            } else {

                $cartqty = Cart::select(DB::raw("SUM(qty) as totalqty"))->where('variants_id', $item->id)->where('session_id', Session::getId())->first();
            }

            if ($cartqty->totalqty != null && $cartqty->totalqty != "") {
                $qty = $cartqty->totalqty + $request->qty;
            } else {
                $qty = $request->qty;
            }

            if ($item->stock_management == 1) {
                if ($item->min_order != null && $item->min_order != "" && $item->min_order != 0) {
                    if ($item->min_order > $qty && $item->min_order != $qty) {
                        return response()->json(['status' => 0, 'message' => trans('messages.min_qty_message') . $item->min_order, 'qty' => $request->qty], 200);
                    }
                }
                if ($item->max_order != null && $item->max_order != "" && $item->max_order != 0) {
                    if ($item->max_order < $qty && $item->max_order != $qty) {
                        if ($cartqty->totalqty == null) {
                            return response()->json(['status' => 0, 'message' => trans('messages.max_qty_message') . $item->max_order, 'qty' => $request->qty - 1], 200);
                        } else {
                            return response()->json(['status' => 0, 'message' => trans('messages.cart_qty_msg') . ' ' . trans('messages.max_qty_message') . $item->max_order, 'qty' => $request->qty - 1], 200);
                        }
                    }
                }
                if ($qty == $item->qty) {
                    return response()->json(['status' => 1, 'message' => 'success', 'qty' => $qty], 200);
                }
                if ($qty > $item->qty  && ($item->qty != null && $item->qty != "")) {
                    return response()->json(['status' => 0, 'message' => trans('labels.out_of_stock_msg') . ' ' . $item_name->item_name . '(' . $item->name . ')', 'qty' => $request->qty - 1], 200);
                } else {
                    return response()->json(['status' => 1, 'message' => 'success', 'qty' => $request->qty], 200);
                }
            } else {
                return response()->json(['status' => 1, 'message' => 'success', 'qty' => $request->qty], 200);
            }
        }
    }
    public function refund_policy(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $policy = Settings::where('vendor_id', $storeinfo->id)->first();
        return view('front.refund_policy', compact('policy', 'storeinfo'));
    }
    public function faqs(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        return view('front.faq', compact('storeinfo'));
    }
    public function find_order(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $order_number = $request->order;
        $getorderdata = Order::select('*', DB::raw('DATE_FORMAT(created_at, "%d %M %Y") as date'))->where('order_number', $request->order)->first();
        $getorderitemlist = OrderDetails::where('order_id', @$getorderdata->id)->get();
        return view('front.order_find', compact('storeinfo', 'getorderdata', 'order_number', 'getorderitemlist'));
    }

    public function productseacrh(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $category = Category::where('vendor_id', @$storeinfo->id)->where('is_available', '1')->where('is_deleted', '2')->orderBy('reorder_id')->get();
        $itemlist = Item::with(['variation', 'extras', 'product_image', 'multi_image'])->select('items.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))->join('categories', 'categories.id', 'items.cat_id')->leftjoin('testimonials', 'testimonials.item_id', 'items.id')->where('items.vendor_id', @$storeinfo->id)->where('items.is_available', '1')->where('categories.is_available', '1');
        if ($request->has('category') && $request->category != null) {
            $categoryinfo = Category::where('slug', $request->category)->first();
            $itemlist =  $itemlist->where(DB::Raw("FIND_IN_SET($categoryinfo->id, replace(items.cat_id, '|', ','))"), '>', 0);
        }
        if ($request->has('search_input') && $request->search_input != null) {
            $itemlist =  $itemlist->where('item_name', 'LIKE', "%{$request->search_input}%");
        }
        $itemlist = $itemlist->groupBy('items.id')->orderBy('items.reorder_id', 'ASC')->paginate(15);
        return view('front.search', compact('storeinfo', 'category', 'itemlist'));
    }

    public function deletepassword(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        return view('front.delete', compact('storeinfo'));
    }
    public function managefavorite(Request $request)
    {

        try {
            $favorite = Favorite::where('product_id', $request->product_id)->where('vendor_id', $request->vendor_id)->where('user_id', Auth::user()->id)->first();
            if (!empty($favorite)) {
                $favorite->delete();
            } else {
                $favorite = new Favorite();
                $favorite->vendor_id = $request->vendor_id;
                $favorite->user_id = Auth::user()->id;
                $favorite->product_id = $request->product_id;
                $favorite->save();
            }
            return response()->json(['status' => 1, 'message' => trans('messages.success')], 200);
        } catch (\Throwable $th) {

            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function postreview(Request $request)
    {

        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            $vendordata = helper::storeinfo($request->vendor);
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            $vendordata = Settings::where('custom_domain', $host)->first();
        }
        if (empty($vendordata)) {
            abort(404);
        }
        $product = Item::where('id', $request->item_id)->first();

        if (Auth::user() && Auth::user()->type == 3) {
            $orders = Order::where('orders.user_id', Auth::user()->id)->where('orders.vendor_id', $vendordata->id)->join('order_details', 'orders.id', 'order_details.order_id')->where('order_details.item_id', $request->item_id)->where('orders.status_type', '3')->count();
            $rattingcount = Testimonials::where('user_id', Auth::user()->id)->where('item_id', $request->item_id)->where('vendor_id', $vendordata->id)->count();
            if ($orders > 0 && $rattingcount == 0) {
                $user = User::where('id', Auth::user()->id)->first();
                $review = new Testimonials();
                $review->vendor_id = $vendordata->id;
                $review->user_id = Auth::user()->id;
                $review->item_id = $request->item_id;
                $review->star = $request->ratting;
                $review->description = $request->review;
                $review->name = $user->name;
                $review->image = $user->image;
                $review->save();
                return redirect()->back()->with('success', trans('messages.success'));
            } else {
                return redirect()->back()->with('error', trans('messages.post_review_message'));
            }
        } else {
            session()->put('previous_url', URL::to($vendordata->slug . '/products/' . $product->slug));
            return redirect($vendordata->slug . '/login');
        }
    }
    public function copycode(Request $request)
    {
        $remove = session()->forget(['offer_amount', 'offer_code', 'offer_type']);
        if (!$remove) {
            return response()->json(['status' => 1, 'message' => 'success', 'element' => $request->code], 200);
        } else {
            return response()->json(['status' => 0, 'message' => trans('messages.wrong')], 200);
        }
    }
    public function rattingmodal(Request $request)
    {

        try {
            $averagerating = number_format(Testimonials::where('item_id', $request->item_id)->where('vendor_id', $request->vendor_id)->avg('star'), 1);
            $totalreview = Testimonials::where('item_id', $request->item_id)->where('vendor_id', $request->vendor_id)->count();
            $avgfive = Testimonials::where('item_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 5)->count();
            $avgfour = Testimonials::where('item_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 4)->count();
            $avgthree = Testimonials::where('item_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 3)->count();
            $avgtwo = Testimonials::where('item_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 2)->count();
            $avgone = Testimonials::where('item_id', $request->item_id)->where('vendor_id', $request->vendor_id)->where('star', 1)->count();
            $userreviews = helper::getuserreviews($request->item_id, $request->vendor_id);
            return response()->json(['status' => 1, 'message' => 'success', 'totalreview' => $totalreview, 'avgfive' => $avgfive, 'avgfour' => $avgfour, 'avgthree' => $avgthree, 'avgtwo' => $avgtwo, 'avgone' => $avgone, 'userreviews' => $userreviews, 'averagerating' => $averagerating], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' =>  trans('messages.wrong')], 200);
        }
    }
}
