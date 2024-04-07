<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Helpers\helper;
use App\Models\User;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\SystemAddons;
use Lunaweb\RecaptchaV3\Facades\RecaptchaV3;
use Config;
use Illuminate\Support\Facades\DB;
class UserController extends Controller
{
    public function user_login(Request $request)
    {

        $storeinfo = helper::storeinfo($request->vendor);
        $slug = $request->vendor;
        if (empty($storeinfo)) {
            abort(404);
        }

        if (
            SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
            SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1
        ) {
            if (helper::appdata($storeinfo->id)->checkout_login_required == 1) {
                return view('front.auth.login', compact('slug', 'storeinfo'));
            } else {
                abort(404);
            }
        }
    }

    public function user_register(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $slug = $request->vendor;
        if (empty($storeinfo)) {
            abort(404);
        }
        if (
            SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
            SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1
        ) {
            if (helper::appdata($storeinfo->id)->checkout_login_required == 1) {
                return view('front.auth.register', compact('slug', 'storeinfo'));
            } else {
                abort(404);
            }
        }
    }

    public function userforgotpassword(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        $slug = $request->vendor;
        if (empty($storeinfo)) {
            abort(404);
        }
        if (
            SystemAddons::where('unique_identifier', 'customer_login')->first() != null &&
            SystemAddons::where('unique_identifier', 'customer_login')->first()->activated == 1
        ) {
            if (helper::appdata($storeinfo->id)->checkout_login_required == 1) {
                return view('front.auth.forgotpassword', compact('slug', 'storeinfo'));
            } else {
                abort(404);
            }
        }
    }
    public function send_password(Request $request)
    {
       
        try {
            $request->validate([
                'email' => 'required|email',
            ], [
                'email.required' => trans('messages.email_required'),
                'email.email' => trans('messages.invalid_email'),
            ]);
            $checkuser = User::where('email', $request->email)->where('is_available', 1)->where('type', 3)->first();
           
            if (!empty($checkuser)) {
                $password = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 6);
                $emaildata = helper::emailconfigration(1);
                Config::set('mail', $emaildata);
                $pass = Helper::send_pass($request->email, $checkuser->name, $password, '1');
                if ($pass == 1) {
                    $checkuser->password = Hash::make($password);
                    $checkuser->save();
                    return redirect('/' . $request->vendor)->with('success', trans('messages.success'));
                } else {
                    return redirect('/' . $request->vendor)->with('error', trans('messages.wrong'));
                }
            } else {
                return redirect()->back()->with('error', trans('messages.invalid_user'));
            }
        } catch (\Throwable $th) {
            return redirect('/' . $request->vendor)->with('error', trans('messages.wrong'));
        }
      
    }
    public function register_customer(Request $request)
    {
        try {
            
            $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'mobile' => 'required|unique:users,mobile',
            ], [
                'name.required' => trans('messages.name_required'),
                'email.required' => trans('messages.email_required'),
                'email.email' =>  trans('messages.invalid_email'),
                'email.unique' => trans('messages.unique_email'),
                'password.required' => trans('messages.password_required'),
                'mobile.required' => trans('messages.unique_mobile_required'),
                'mobile.unique' => trans('messages.unique_mobile_required'),
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
                        return redirect()->back()->with('error', 'You are most likely a bot');
                    }
                }
            }
            $newuser = new User();
            $newuser->name = $request->name;
            $newuser->email = $request->email;
            $newuser->password = hash::make($request->password);
            $newuser->mobile = $request->mobile;
            $newuser->type = "3";
            $newuser->login_type = "email";
            $newuser->image = "default.png";
            $newuser->is_available = "1";
            $newuser->is_verified = "1";
            $newuser->save();

            Auth::login($newuser);
            $host = $_SERVER['HTTP_HOST'];
            if ($host  ==  env('WEBSITE_HOST')) {
                return redirect($request->vendor)->with('success', trans('messages.success'));
            }
            // if the current host doesn't contain the website domain (meaning, custom domain)
            else {
                return redirect('/')->with('sucess', trans('messages.success'));
            }
        } catch (\Throwable $th) {
            return redirect('/')->with('error', trans('messages.wrong'));
        }
    }

    public function check_login(Request $request)
    {
        if ($request->vendor == null) {
            $vendor = User::where('slug', session()->get('slug'))->first();
        } else {
            $vendor = User::where('slug', $request->vendor)->first();
        }

        try {
            if ($request->logintype == "normal") {
                $request->validate([
                    'email' => 'required|email',
                    'password' => 'required',
                ], [
                    'email.required' => trans('messages.email_required'),
                    'email.email' =>  trans('messages.invalid_email'),
                    'password.required' => trans('messages.password_required'),
                ]);
                $old_sid = session()->getId();
                session()->put('user_login', 1);
                if (Auth::attempt($request->only('email', 'password'))) {
                    if (Auth::user()->type == 3) {
                        if (Auth::user()->is_available == 1) {
                            session()->put('old_sid', $old_sid);

                            Cart::where('session_id', $old_sid)->update(['user_id' => Auth::user()->id, 'session_id' => NULL]);

                            $count = Cart::where('user_id', Auth::user()->id)->count();

                            session()->put('cart', $count);

                            session()->put('vendor_id', $vendor->id);

                            $host = $_SERVER['HTTP_HOST'];
                            if ($host  ==  env('WEBSITE_HOST')) {
                                return redirect('/' . $request->vendor)->with('sucess', trans('messages.success'));
                            }
                            // if the current host doesn't contain the website domain (meaning, custom domain)
                            else {
                                return redirect('/')->with('sucess', trans('messages.success'));
                            }
                        } else {
                            Auth::logout();
                            return redirect()->back()->with('error', trans('messages.account_blocked_by_admin'));
                        }
                    } else {
                        Auth::logout();
                        return redirect()->back()->with('error', trans('messages.email_password_not_match'));
                    }
                } else {
                    return redirect()->back()->with('error', trans('messages.email_password_not_match'));
                }
            }
        } catch (Exception $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
    public function send_userpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => trans('messages.email_required'),
            'email.email' =>  trans('messages.invalid_email'),
        ]);
        $checkuser = User::where('email', $request->email)->where('is_available', 1)->first();
        if (!empty($checkuser)) {
            $password = substr(str_shuffle($checkuser->password), 1, 6);
            $check_send_mail = helper::send_pass($request->email,$checkuser->name,$password, helper::appdata('')->logo);
            if ($check_send_mail == 1) {
                $checkuser->password = Hash::make($password);
                $checkuser->save();
                return redirect('/' . $request->vendor . '/login')->with('success', trans('messages.success'));
            } else {
                return redirect('/' . $request->vendor . '/forgot_password')->with('error', trans('messages.wrong'));
            }
        } else {
            return redirect()->back()->with('error', trans('messages.invalid_user'));
        }
    }
    public function logout(Request $request)
    {
        session()->flush();
        Auth::logout();
        $host = $_SERVER['HTTP_HOST'];
        if ($host  ==  env('WEBSITE_HOST')) {
            return redirect($request->vendor);
        }
        // if the current host doesn't contain the website domain (meaning, custom domain)
        else {
            return redirect('/')->with('sucess', trans('messages.success'));
        }
    }

    public function profile(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        return view('front.profile', compact('storeinfo'));
    }

    public function updateprofile(Request $request)
    {
        $edituser = User::where('id', $request->id)->first();
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $edituser->id,
            'mobile' => 'required|numeric|unique:users,mobile,' . $edituser->id,
        ], [
            'name.required' => trans('messages.name_required'),
            'email.required' => trans('messages.email_required'),
            'mobile.required' => trans('messages.unique_mobile_required'),
            'email.email' => trans('messages.invalid_email'),
            'email.unique' => trans('messages.unique_email_required'),
            'mobile.unique' => trans('messages.unique_mobile'),
        ]);
        $edituser->name = $request->name;
        $edituser->email = $request->email;
        $edituser->mobile = $request->mobile;
        if ($request->has('profile')) {
            if ($edituser->image != "" && file_exists(storage_path('app/public/admin-assets/images/profile/' . $edituser->image))) {
                unlink(storage_path('app/public/admin-assets/images/profile/' . $edituser->image));
            }
            $edit_image = $request->file('profile');
            $profileImage = 'profile-' . uniqid() . "." . $edit_image->getClientOriginalExtension();
            $edit_image->move(storage_path('app/public/admin-assets/images/profile/'), $profileImage);
            $edituser->image = $profileImage;
        }
        $edituser->update();
        if ($edituser) {
            return redirect($request->vendor . '/profile')->with('success', trans('messages.success'));
        } else {
            return redirect($request->vendor . '/profile')->with('error', trans('messages.wrong'));
        }
    }

    public function changepassword(Request $request)
    {
        $storeinfo = helper::storeinfo($request->vendor);
        return view('front.change-password', compact('storeinfo'));
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required',
        ], [
            'current_password.required' => trans('messages.cuurent_password_required'),
            'new_password.required' => trans('messages.new_password_required'),
            'confirm_password.required' => trans('messages.confirm_password_required'),
        ]);
        if (Hash::check($request->current_password, Auth::user()->password)) {
            if ($request->current_password == $request->new_password) {
                return redirect()->back()->with('error', trans('messages.new_old_password_diffrent'));
            } else {
                if ($request->new_password == $request->confirm_password) {
                    $changepassword = User::where('id', Auth::user()->id)->first();
                    $changepassword->password = Hash::make($request->new_password);
                    $changepassword->update();
                    return redirect()->back()->with('success', trans('messages.success'));
                } else {
                    return redirect()->back()->with('error', trans('messages.new_confirm_password_inccorect'));
                }
            }
        } else {
            return redirect()->back()->with('error', trans('messages.old_password_incorect'));
        }
    }

    public function orders(Request $request)
    {
        $storeinfo = User::where('slug', $request->vendor)->first();
        $getorders = Order::where('vendor_id',$storeinfo->id)->where('user_id', Auth::user()->id);

        if (!empty($request->type)) {
            if ($request->type == "rejected") {
                $getorders = $getorders->where('status_type', 4);
            }
            if ($request->type == "processing") {
                $getorders = $getorders->whereIn('status_type', [1, 2]);
            }
            if ($request->type == "completed") {
                $getorders = $getorders->where('status_type', 3);
            }
        }
        $storeinfo = helper::storeinfo($request->vendor);
        $vendordata = User::where('slug', $request->vendor)->first();
        $getorders = $getorders->orderByDesc('id')->get();
        $totalprocessing = Order::where('vendor_id',$storeinfo->id)->where('user_id', Auth::user()->id)->whereIn('status_type', [1, 2])->count();
        $totalrejected = Order::where('vendor_id',$storeinfo->id)->where('user_id', Auth::user()->id)->where('status_type', 4)->count();
        $totalcompleted = Order::where('vendor_id',$storeinfo->id)->where('user_id', Auth::user()->id)->where('status_type', 3)->count();
        return view('front.orders', compact('storeinfo', 'vendordata', 'getorders', 'totalprocessing', 'totalrejected', 'totalcompleted'));
    }
    public function deleteaccount(Request $request)
    {
        $storeinfo = User::where('slug', $request->vendor)->first();
        if (Auth::user() && Auth::user()->type == 3) {
            $user  = User::where('id', Auth::user()->id)->first();
            $user->is_available = 2;
            $user->update();
            $emaildata = helper::emailconfigration('');
            Config::set('mail', $emaildata);
            helper::send_mail_delete_account($user);
            session()->flush();
            Auth::logout();
            $host = $_SERVER['HTTP_HOST'];
            if ($host  ==  env('WEBSITE_HOST')) {
                return redirect($request->vendor);
            }
            // if the current host doesn't contain the website domain (meaning, custom domain)
            else {
                return redirect('/')->with('sucess', trans('messages.success'));
            }
        }
    }
    public function wishlist(Request $request)
    {
        $storeinfo = User::where('slug', $request->vendor)->first();
        $getitem = Item::with(['variation', 'extras', 'product_image', 'multi_image'])->select('items.*', DB::raw('ROUND(AVG(testimonials.star),1) as ratings_average'))->leftjoin('favorite', 'favorite.product_id', '=', 'items.id')
        ->leftJoin('testimonials', 'testimonials.item_id', '=', 'items.id')
        ->groupBy('items.id')->where('favorite.vendor_id', $storeinfo->id)
        ->where('items.vendor_id', $storeinfo->id)
        ->where('favorite.user_id', Auth::user()->id)->orderBy('items.reorder_id', 'ASC')
        ->where('items.is_available', 1)->paginate(8);
        return view('front.wishlist',compact('storeinfo','getitem'));
    }
}
