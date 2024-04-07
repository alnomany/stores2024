<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use App\Helpers\helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Config;
class EmailSettingsController extends Controller
{
    public function emailsettings(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settings = Settings::where('vendor_id', $vendor_id)->first();
        $settings->mail_driver = $request->mail_driver;
        $settings->mail_host = $request->mail_host;
        $settings->mail_port = $request->mail_port;
        $settings->mail_username = $request->mail_username;
        $settings->mail_password = $request->mail_password;
        $settings->mail_encryption = $request->mail_encryption;
        $settings->mail_fromaddress = $request->mail_fromaddress;
        $settings->mail_fromname = $request->mail_fromname;
        $settings->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function testmail(Request $request)
    {
        try {
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            $data = ['title' => "Congratulations! Successful SMTP Email Configuration", 'vendor_email' => $request->email_address, 'vendor_name' => Auth::user()->name,'msg' => "I am delighted to inform you that your SMTP email configuration has been successfully set up! Congratulations on this achievement!"];
            $emaildata = helper::emailconfigration($vendor_id);
            Config::set('mail',$emaildata);
            Mail::send('email.testemail', $data, function ($message) use ($data) {
                $message->to($data['vendor_email'])->subject($data['title']);
            });
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.test_mail_fail_message'));
        }
    }
}
