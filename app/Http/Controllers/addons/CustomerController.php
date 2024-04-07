<?php
namespace App\Http\Controllers\addons;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        if (Auth::user()->type == 2 || Auth::user()->type == 4) {
            $getcustomerslist = User::select('users.id','users.name','users.email','users.mobile','users.image','users.created_at','users.updated_at')->join('orders', 'orders.user_id', '=', 'users.id')
            ->where('orders.vendor_id', $vendor_id)
            ->groupBy('orders.user_id')
            ->get();
        } else {
            $getcustomerslist = User::where('type', 3)->orderBydesc('id')->get();
        }
        return view('admin.customers.index', compact('getcustomerslist'));
    }
    public function status(Request $request)
    {
        User::where('id', $request->id)->update(['is_available' => $request->status]);
        return redirect('admin/customers')->with('success', trans('messages.success'));
    }
    public function orders(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        if (Auth::user()->type == 2){
            $totalorders = Order::where('user_id', $request->id)->where('vendor_id', $vendor_id)->count();
            $totalprocessing = Order::whereIn('status_type', array(1,2))->where('user_id', $request->id)->where('vendor_id', $vendor_id)->count();
            $totalrevenue = Order::where('status_type', 3)->where('user_id', $request->id)->where('vendor_id', $vendor_id)->sum('grand_total');
            $totalcompleted = Order::where('status_type', 3)->where('user_id', $request->id)->where('vendor_id', $vendor_id)->count();
            $totalcancelled = Order::where('status_type', 4)->where('user_id', $request->id)->where('vendor_id', $vendor_id)->count();
            $getorders = Order::with('vendorinfo')->where('user_id', $request->id)->where('vendor_id', $vendor_id);
        } else {
            $totalorders = Order::where('user_id', $request->id)->count();
            $totalprocessing = Order::whereIn('status_type', array(1,2))->where('user_id', $request->id)->count();
            $totalrevenue = Order::where('status_type', 3)->where('user_id', $request->id)->sum('grand_total');
            $totalcompleted = Order::where('status_type', 3)->where('user_id', $request->id)->count();
            $totalcancelled = Order::where('status_type', 4)->where('user_id', $request->id)->count();
            $getorders = Order::with('vendorinfo')->where('user_id', $request->id);
        }
        if($request->has('status') && $request->status != "") {
            if ($request->status == "processing") {
                $getorders = $getorders->whereIn('status_type', array(1,2));
            }
            if ($request->status == "cancelled") {
                $getorders = $getorders->where('status_type', 4);
            }
            if ($request->status == "delivered") {
                $getorders = $getorders->where('status_type', 3);
            }
        }
        $getorders = $getorders->orderByDesc('id')->get();
        $userinfo = User::select('id','name')->where('id', $request->id)->first();
        return view('admin.customers.orders', compact('getorders', 'totalorders', 'totalprocessing', 'totalcompleted', 'totalcancelled', 'totalrevenue','userinfo'));
    }
}