<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use App\Models\Footerfeatures;
use App\Models\Country;
use App\Models\Pixcel;
use Illuminate\Support\Facades\Auth;
use App\Helpers\helper;
use Config;

class SettingsController extends Controller
{

    public function settings_index(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingdata = Settings::where('vendor_id', $vendor_id)->first();
        $getfooterfeatures = Footerfeatures::where('vendor_id', $vendor_id)->get();
        $countries = Country::where('Is_deleted', 2)->where('is_available', 1)->orderBy('reorder_id')->get();
        $pixelsettings = Pixcel::where('vendor_id',Auth::user()->id)->first();
        return view('admin.otherpages.settings', compact('settingdata', 'getfooterfeatures', 'countries','pixelsettings'));
    }
    public function settings_update(Request $request)
    {
      
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'currency' => 'required',
            'timezone' => 'required',
        ], [
            "currency.required" => trans('messages.currency_required'),
            "timezone.required" => trans('messages.timezone_required'),
            'slug.required_if' => trans('messages.slug_required'),
            'slug.unique' => trans('messages.unique_slug'),
        ]);
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
       
        if ($request->hasfile('notification_sound')) {
            $request->validate([
                'notification_sound' => 'mimes:mp3',

            ]);
            if (file_exists(storage_path('app/public/admin-assets/notification/' . $settingsdata->notification_sound))) {
                @unlink(storage_path('app/public/admin-assets/notification/' . $settingsdata->notification_sound));
            }
            $sound = 'audio-' . uniqid() . '.' . $request->notification_sound->getClientOriginalExtension();
            $request->notification_sound->move(storage_path('app/public/admin-assets/notification/'), $sound);
            $settingsdata->notification_sound = $sound;
        }
        $settingsdata->currency = $request->currency;
        $settingsdata->currency_position = $request->currency_position == 1 ? 'left' : 'right';
        $settingsdata->decimal_separator = $request->decimal_separator;
        $settingsdata->currency_formate = $request->currency_formate;
        $settingsdata->maintenance_mode = isset($request->maintenance_mode) ? 1 : 2;
        $settingsdata->vendor_register = isset($request->vendor_register) ? 1 : 2;
        $settingsdata->timezone = $request->timezone;
        $settingsdata->firebase = $request->firebase_server_key;
        $settingsdata->delivery_type = $request->delivery_type !=null ? implode('|',$request->delivery_type): '';
        if($request->delivery_type == null )
        {
            $settingsdata->online_order =  2;
        }else{
            $settingsdata->online_order =  1;
        }
        $settingsdata->ordertype_date_time = isset($request->ordertypedatetime) ? 1 : 2;
        $settingsdata->time_format = isset($request->time_format) ? 1 : 2;

        if (Auth::user()->type == 2 || Auth::user()->type == 4) {
            $settingsdata->checkout_login_required = isset($request->checkout_login_required) ? 1 : 2;
           
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function settings_updateanalytics(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'tracking_id' => 'required',
            'view_id' => 'required',
        ], [
            'tracking_id.required' => trans('messages.tracking_id_required'),
            'view_id.required' => trans('messages.view_id_required'),
        ]);
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        $settingsdata->tracking_id = $request->tracking_id;
        $settingsdata->view_id = $request->view_id;
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function settings_updatecustomedomain(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'cname_title' => 'required',
            'cname_text' => 'required',
        ], [
            'cname_title.required' => trans('messages.cname_title_required'),
            'cname_text.required' => trans('messages.cname_text_required'),
        ]);
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        $settingsdata->cname_title = $request->cname_title;
        $settingsdata->cname_text = $request->cname_text;
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
  
    public function delete_viewall_page_image(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        if (!empty($settingsdata)) {
            if (!empty($settingsdata->viewallpage_banner) && file_exists(storage_path('app/public/admin-assets/images/about/viewallpage_banner/' . $settingsdata->viewallpage_banner))) {
                unlink(storage_path('app/public/admin-assets/images/about/viewallpage_banner/' . $settingsdata->viewallpage_banner));
            }
            $settingsdata->viewallpage_banner = "";
            $settingsdata->update();
            return redirect('admin/settings')->with('success', trans('messages.success'));
        }
        return redirect('admin/settings');
    }

    public function shopify_settings(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'shopify_store_url' => 'required',
            'shopify_access_token' => 'required',
        ], [
            'shopify_store_url.required' => trans('messages.shopify_store_url_required'),
            'shopify_access_token.required' => trans('messages.shopify_access_token_required'),
        ]);
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        $settingsdata->shopify_store_url = $request->shopify_store_url;
        $settingsdata->shopify_access_token = $request->shopify_access_token;
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
  
    public function deleteaccount(Request $request)
    {
        try {
            $user = User::where('id', $request->id)->first();
            if($user->is_available == 2)
            {
                return redirect('admin/settings')->with('error', trans('messages.account_blocked_by_admin'));
            }
            $user->is_available = 2;
            $user->update();
            $emaildata = helper::emailconfigration(helper::appdata("")->id);
            Config::set('mail', $emaildata);
            helper::send_mail_delete_account($user);
            session()->flush();
            Auth::logout();
            return redirect('admin');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error',trans('messages.wrong'));
        }
       
    }
   
}
