<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\helper;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Variants;
use App\Models\Item;
use App\Models\CustomStatus;
use Illuminate\Support\Facades\Auth;
use PDF;
use Config;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getorders = Order::where('vendor_id',  $vendor_id);


        if ($request->has('status') && $request->status != "") {
            if ($request->status == "processing") {
                $getorders = $getorders->whereIn('status_type', array(1, 2));
            }
            if ($request->status == "cancelled") {
                $getorders = $getorders->whereIn('status_type', array(4));
            }

            if ($request->status == "delivered") {
                $getorders = $getorders->where('status_type', 3);
            }
        }
        $totalorders = Order::where('vendor_id',  $vendor_id)->count();
        $totalprocessing = Order::whereIn('status_type', array(1, 2))->where('vendor_id',  $vendor_id)->count();
        $totalrevenue = Order::where('vendor_id',  $vendor_id)->where('status_type', 3)->sum('grand_total');
        $totalcompleted = Order::where('status_type', 3)->where('vendor_id',  $vendor_id)->count();
        $totalcancelled = Order::where('status_type',  4)->where('vendor_id',  $vendor_id)->count();
        if (!empty($request->startdate) && !empty($request->enddate)) {
            $totalorders = Order::where('vendor_id',  $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $getorders = $getorders->whereBetween('created_at', [$request->startdate, $request->enddate]);
            $totalprocessing = Order::whereIn('status_type', array(1, 2))->where('vendor_id',  $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalrevenue = Order::where('status_type', 3)->where('vendor_id',  $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->sum('grand_total');
            $totalcompleted = Order::where('status_type', 3)->where('vendor_id',  $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
            $totalcancelled = Order::where('status_type', 4)->where('vendor_id',  $vendor_id)->whereBetween('created_at', [$request->startdate, $request->enddate])->count();
        }
        $getorders = $getorders->orderByDesc('id')->get();
        return view('admin.orders.index', compact('getorders', 'totalorders', 'totalprocessing', 'totalcompleted', 'totalcancelled', 'totalrevenue'));
    }
    public function update(Request $request)
    {
       
        try {
            $orderdata = Order::where('id', $request->id)->first();
            $orderdetail = OrderDetails::where('order_id', $orderdata->id)->get();
            if (empty($orderdata) || !in_array($request->type, [2, 3, 4])) {
                abort(404);
            }
            $title = "";
            $message_text = "";
            if ($request->type == "2") {
                $title = @helper::gettype($request->status, $request->type, $orderdata->order_type, $orderdata->vendor_id)->name;
                $message_text = 'Your Order ' . $orderdata->order_number . ' has been accepted by Admin';
            }
            if ($request->type == "3") {
                $title = @helper::gettype($request->status, $request->type, $orderdata->order_type, $orderdata->vendor_id)->name;
                $message_text = 'Your Order ' . $orderdata->order_number . ' has been successfully delivered.';
            }
            if ($request->type == "4") {
                $title = @helper::gettype($request->status, $request->type, $orderdata->order_type, $orderdata->vendor_id)->name;
                $message_text = 'Order ' . $orderdata->order_number . ' has been cancelled by Admin.';
            }

            $defaultsatus = CustomStatus::where('vendor_id', $orderdata->vendor_id )->where('order_type', $orderdata->order_type)->where('type',$request->type)->where('is_available', 1)->where('is_deleted', 2)->first();
            if (helper::appdata($orderdata->vendor_id)->product_type == 1) {
                if (empty($defaultsatus) && $defaultsatus == null) {
                    return redirect()->back()->with('error', trans('messages.wrong'));
                }
                else {
                    $emaildata = helper::emailconfigration($orderdata->vendor_id);
                    Config::set('mail', $emaildata);
                    helper::order_status_email($orderdata->customer_email, $orderdata->customer_name, $title, $message_text, $orderdata->vendor_id);
                    if ($orderdata->payment_type == 6 && $request->type == 3) {
                        $orderdata->payment_status = 2;
                    }
    
                    $orderdata->status = $defaultsatus->id;
                    $orderdata->status_type = $defaultsatus->type;
                    $orderdata->save();
        
                    if ($request->type == "4") {
                        foreach ($orderdetail as $order) {
                            if ($order->variants_id != null && $order->variants_id != "") {
                                $item = Variants::where('id', $order->variants_id)->where('item_id', $order->item_id)->first();
                            } else {
                                $item = Item::where('id', $order->item_id)->where('vendor_id', $orderdata->vendor_id)->first();
                            }
                            $item->qty = $item->qty + $order->qty;
                            $item->update();
                        }
                    }
                    return redirect()->back()->with('success', trans('messages.success'));
                }
            } 
            
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function invoice(Request $request)
    {

        $getorderdata = Order::where('order_number', $request->order_number)->first();
        if (empty($getorderdata)) {
            abort(404);
        }
        $ordersdetails = OrderDetails::where('order_id', $getorderdata->id)->get();
        return view('admin.orders.invoice', compact('getorderdata', 'ordersdetails'));
    }
    public function print(Request $request)
    {
        $getorderdata = Order::where('order_number', $request->order_number)->first();
        if (empty($getorderdata)) {
            abort(404);
        }
        $ordersdetails = OrderDetails::where('order_id', $getorderdata->id)->get();
        return view('admin.orders.print', compact('getorderdata', 'ordersdetails'));
    }
    public function generatepdf(Request $request)
    {
        $getorderdata = Order::where('order_number', $request->order_number)->first();
        $ordersdetails = OrderDetails::where('order_id', $getorderdata->id)->get();
        $pdf = PDF::loadView('admin.orders.invoicepdf', ['getorderdata' => $getorderdata, 'ordersdetails' => $ordersdetails]);
        return $pdf->download('orderinvoice.pdf');
    }
    public function payment_status(Request $request)
    {
        if ($request->ramin_amount > 0) {
            return redirect()->back()->with('error', trans('messages.amount_validation_msg'));
        }
        $order = Order::where('order_number', $request->booking_number)->first();
        $order->payment_status = 2;
        $order->update();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
