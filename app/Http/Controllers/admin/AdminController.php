<?php

namespace App\Http\Controllers\admin;

use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\PricingPlan;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use App\Helpers\helper;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $user = User::where('id', $vendor_id)->first();
        // Admin
        $totalplans = PricingPlan::count();
        // Vendor-Admin
        $currentplanname = PricingPlan::select('name')->where('id',  $user->plan_id)->orderByDesc('id')->first();
        // ----------------------- chart -----------------------
        $doughnutyear = $request->doughnutyear != "" ? $request->doughnutyear : date('Y');
        $revenueyear = $request->revenueyear != "" ? $request->revenueyear : date('Y');
        if (Auth::user()->type == 1) {
            $totalvendors = User::where('type', 2)->count();
            $totalrevenue = Transaction::where('status', 2)->sum('amount');
            $totalorders = Transaction::count('id');
            // DOUGHNUT-CHART-START
            $doughnut_years = User::select(DB::raw("YEAR(created_at) as year"))->where('type', 2)->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            $vendorlist = User::select(DB::raw("YEAR(created_at) as year"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("COUNT(id) as total_user"))->whereYear('created_at', $doughnutyear)->where('type', 2)->orderBy('created_at')->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_user', 'month_name');
            $doughnutlabels = $vendorlist->keys();
            $doughnutdata = $vendorlist->values();
            // DOUGHNUT-CHART-END
            // revenue-CHART-START
            $revenue_years = Transaction::select(DB::raw("YEAR(purchase_date) as year"))->groupBy(DB::raw("YEAR(purchase_date)"))->orderByDesc('purchase_date')->get();
            $revenue_list = Transaction::select(DB::raw("YEAR(purchase_date) as year"), DB::raw("MONTHNAME(purchase_date) as month_name"), DB::raw("SUM(amount) as total_amount"))->whereYear('purchase_date', $revenueyear)->where('status', 2)->orderby('purchase_date')->groupBy(DB::raw("MONTHNAME(purchase_date)"))->pluck('total_amount', 'month_name');
            $revenuelabels = $revenue_list->keys();
            $revenuedata = $revenue_list->values();
            // revenue-CHART-END
            $transaction = Transaction::with('vendor_info')->whereDate('created_at', Carbon::today())->get();
            $getorders = array();
        } else {
            $totalvendors = Item::where('vendor_id', $vendor_id)->count();
            $totalrevenue = Order::where('vendor_id', $vendor_id)->where('status', 5)->sum('grand_total');
            $totalorders = Order::where('vendor_id',  $vendor_id)->count();
            // DOUGHNUT-CHART-START
            $doughnut_years = $revenue_years = Order::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->orderByDesc('created_at')->get();
            $orderlist = Order::select(DB::raw("YEAR(created_at) as year"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("COUNT(id) as total_orders"))->whereYear('created_at', $doughnutyear)->orderBy('created_at')->where('vendor_id',  $vendor_id)->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_orders', 'month_name');
            $doughnutlabels = $orderlist->keys();
            $doughnutdata = $orderlist->values();
            // DOUGHNUT-CHART-END
            // revenue-CHART-START
            $revenue_list = Order::select(DB::raw("YEAR(created_at) as year"), DB::raw("MONTHNAME(created_at) as month_name"), DB::raw("SUM(grand_total) as total_amount"))->whereYear('created_at', $revenueyear)->orderBy('created_at')->where('vendor_id', $vendor_id)->groupBy(DB::raw("MONTHNAME(created_at)"))->pluck('total_amount', 'month_name');
            $revenuelabels = $revenue_list->keys();
            $revenuedata = $revenue_list->values();
            // revenue-CHART-END
            $transaction = array();
            $getorders = order::select("id", "order_number", "grand_total", "order_type", "payment_type", "payment_id", "delivery_date", "delivery_time", "status","status_type", "screenshot", DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as order_date'),'created_at','updated_at','payment_status','dinein_table','dinein_tablename')->where('vendor_id', $vendor_id)->whereIn('status_type', [1, 2])->orderByDesc('id')->get();
        }
        if (env('Environment') == 'sendbox') {
            $doughnutlabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $doughnutdata = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
            $revenuelabels = ['January', 'February', 'March', 'April', 'May', 'June', 'July ', 'August', 'September', 'October', 'November', 'December'];
            $revenuedata = [636, 1269, 2810, 2843, 3637, 467, 902, 1296, 402, 1173, 1509, 413];
        }
        if ($request->ajax()) {
            return response()->json([
                'doughnutlabels' => $doughnutlabels,
                'doughnutdata' => $doughnutdata,
                'revenuelabels' => $revenuelabels,
                'revenuedata' => $revenuedata
            ], 200);
        } else {
            if (Auth::user()->type == 4) {
                if (helper::check_access('role_dashboard', Auth::user()->role_id, Auth::user()->vendor_id, 'manage') == 1) {
                    return view(
                        'admin.dashboard.index',
                        compact(
                            'totalvendors',
                            'totalplans',
                            'totalorders',
                            'totalrevenue',
                            'currentplanname',
                            'doughnut_years',
                            'doughnutlabels',
                            'doughnutdata',
                            'revenue_years',
                            'revenuelabels',
                            'revenuedata',
                            'transaction',
                            'getorders',
                        )
                    );
                } else {
                    return view('admin.dashboard.access_denied');
                }
            } else {

                return view(
                    'admin.dashboard.index',
                    compact(
                        'totalvendors',
                        'totalplans',
                        'totalorders',
                        'totalrevenue',
                        'currentplanname',
                        'doughnut_years',
                        'doughnutlabels',
                        'doughnutdata',
                        'revenue_years',
                        'revenuelabels',
                        'revenuedata',
                        'transaction',
                        'getorders'
                    )
                );
            }
        }
    }

    public function login()
    {
        if(!file_exists(storage_path() . "/installed")) {
            return redirect('install');
            exit;
        }
        helper::language(1);
        return view('admin.auth.login');
    }

    public function check_admin_login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => trans('messages.email_required'),
            'email.email' => trans('messages.invalid_email'),
            'password.required' => trans('messages.password_required'),
        ]);
        session()->put('admin_login', 1);
        if (Auth::attempt($request->only('email', 'password'))) {
            if (!Auth::user()) {
                return Redirect::to('/admin/verification')->with('error', Session()->get('from_message'));
            }
            if (Auth::user()->type == 1) {
                return redirect('/admin/dashboard');
            } else {
                if (Auth::user()->type == 2) {
                    if (Auth::user()->is_available == 1) {
                        return redirect('/admin/dashboard');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.account_blocked_by_admin'));
                    }
                } elseif (Auth::user()->type == 4) {
                    if (Auth::user()->is_available == 1) {
                        return redirect('/admin/dashboard');
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.account_blocked_by_admin'));
                    }
                } else {
                    Auth::logout();
                    return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
                }
            }
        } else {
            return redirect()->back()->with('error', trans('messages.email_pass_invalid'));
        }
    }
    public function logout()
    {
        session()->flush();
        Auth::logout();
        if (helper::appdata('')->landing_page == 2) {
            return redirect('/');
        }else{
            return redirect('admin');
        }
      
    }
    public function systemverification(Request $request)
    {
        $username = str_replace(' ', '', $request->username);

		User::where('id', 1)->update(['license_type' => 'Extended']);
		return Redirect::to('/admin')->with('success', 'Success');
    }
}
