<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\Models\AppSettings;
use App\Models\Transaction;
use App\Helpers\helper;
use App\Models\SocialLinks;
use App\Models\LandingSettings;
use App\Models\Footerfeatures;
use App\Models\FunFact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class WebSettingsController extends Controller
{
    public function basic_settings()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingdata =  Settings::where('vendor_id', $vendor_id)->first();
        $theme = Transaction::select('themes_id')->where('vendor_id', $vendor_id)->orderByDesc('id')->first();
        $app = AppSettings::where('vendor_id', $vendor_id)->first();
        $getfooterfeatures = Footerfeatures::where('vendor_id', $vendor_id)->get();
        $getsociallinks = SocialLinks::where('vendor_id', $vendor_id)->get();
        $landingdata = LandingSettings::where('vendor_id', $vendor_id)->first();
        $funfacts = FunFact::where('vendor_id', $vendor_id)->get();
        return view('admin.landing.index', compact('settingdata', 'theme', 'app', 'getfooterfeatures', 'landingdata', 'funfacts', 'getsociallinks'));
    }
    public function theme_settings(Request $request)
    {
        try {
            if (Auth::user()->type == 4) {
                $vendor_id = Auth::user()->vendor_id;
            } else {
                $vendor_id = Auth::user()->id;
            }
            $settingdata = Settings::where('vendor_id', $vendor_id)->first();
            if (empty($settingdata)) {
                $settingdata = new Settings();
            }
            if ($request->hasfile('logo')) {
                if(Auth::user()->type == 1)
                {
                    if ($settingdata->logo != "default-logo.png" && $settingdata->logo != "" && file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $settingdata->logo))) {
                        unlink(storage_path('app/public/admin-assets/images/about/defaultimages/' . $settingdata->logo));
                    }
                    $logo_name = 'logo-' . uniqid() . '.' . $request->logo->getClientOriginalExtension();
                    $request->file('logo')->move(storage_path('app/public/admin-assets/images/about/defaultimages/'), $logo_name);
                }else{
                    if ($settingdata->logo != "default-logo.png" && $settingdata->logo != "" && file_exists(storage_path('app/public/admin-assets/images/about/logo/' . $settingdata->logo))) {
                        unlink(storage_path('app/public/admin-assets/images/about/logo/' . $settingdata->logo));
                    }
                    $logo_name = 'logo-' . uniqid() . '.' . $request->logo->getClientOriginalExtension();
                    $request->file('logo')->move(storage_path('app/public/admin-assets/images/about/logo/'), $logo_name);
                }
               
                $settingdata->logo = $logo_name;
            }
            if ($request->hasfile('favicon')) {
                if(Auth::user()->type == 1)
                {
                    if ($settingdata->favicon != "defaultlogo.png" && $settingdata->favicon != "" && file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $settingdata->favicon))) {
                        unlink(storage_path('app/public/admin-assets/images/about/defaultimages/' . $settingdata->favicon));
                    }
                    $favicon_name = 'favicon-' . uniqid() . '.' . $request->favicon->getClientOriginalExtension();
                    $request->favicon->move(storage_path('app/public/admin-assets/images/about/defaultimages/'), $favicon_name);
                }else{
                    if ($settingdata->favicon != "defaultlogo.png" && $settingdata->favicon != "" && file_exists(storage_path('app/public/admin-assets/images/about/favicon/' . $settingdata->favicon))) {
                        unlink(storage_path('app/public/admin-assets/images/about/favicon/' . $settingdata->favicon));
                    }
                    $favicon_name = 'favicon-' . uniqid() . '.' . $request->favicon->getClientOriginalExtension();
                    $request->favicon->move(storage_path('app/public/admin-assets/images/about/favicon/'), $favicon_name);
                }
                
                $settingdata->favicon = $favicon_name;
            }
            $settingdata->primary_color = $request->landing_primary_color;
            $settingdata->secondary_color = $request->landing_secondary_color;
            $settingdata->website_title = $request->website_title;
            $settingdata->landing_page =  isset($request->landing) ? 1 : 2;
            $settingdata->copyright = $request->copyright;
            $settingdata->template = !empty($request->template) ? $request->template : 1;
            $settingdata->save();
            return redirect()->back()->with('success', trans('messages.success'));
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function contact_settings(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $settingdata = Settings::where('vendor_id', $vendor_id)->first();
        if (empty($settingdata)) {
            $settingdata = new Settings();
        }
        $settingdata->email = $request->landing_email;
        $settingdata->contact = $request->landing_mobile;
        $settingdata->address = $request->landing_address;
        $settingdata->whatsapp_number = $request->contact;
        $settingdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function seo_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
       
        $settingsdata = Settings::where('vendor_id', $vendor_id)->first();
        $settingsdata->meta_title = $request->meta_title;
        $settingsdata->meta_description = $request->meta_description;
        if ($request->hasfile('og_image')) {
            if(Auth::user()->type == 1)
            {
                
                if ($settingsdata->og_image != "" && file_exists(storage_path('app/public/admin-assets/images/about/defaultimages/' . $settingsdata->og_image))) {
                    unlink(storage_path('app/public/admin-assets/images/about/defaultimages/' . $settingsdata->og_image));
                }
                $image = 'og_image-' . uniqid() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(storage_path('app/public/admin-assets/images/about/defaultimages/'), $image);
            }else{
                if ($settingsdata->og_image != "" && file_exists(storage_path('app/public/admin-assets/images/about/og_image/' . $settingsdata->og_image))) {
                    unlink(storage_path('app/public/admin-assets/images/about/og_image/' . $settingsdata->og_image));
                }
                $image = 'og_image-' . uniqid() . '.' . $request->og_image->getClientOriginalExtension();
                $request->og_image->move(storage_path('app/public/admin-assets/images/about/og_image/'), $image);
            }
          
            $settingsdata->og_image = $image;
        }
        $settingsdata->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function app_section(Request $request)
    {

        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $appsection = AppSettings::where('vendor_id', $vendor_id)->first();
        if (empty($appsection)) {
            $appsection = new AppSettings();
        }
       
        $appsection->vendor_id = $vendor_id;
        $appsection->android_link = $request->android_link;
        $appsection->ios_link = $request->ios_link;
        $appsection->mobile_app_on_off = isset($request->mobile_app_on_off) ? 1 : 2;
        if ($request->has('image')) {
            if (!empty($appsection->image)) {
                if (file_exists(storage_path('app/public/admin-assets/images/index/' .  $appsection->image))) {
                    unlink(storage_path('app/public/admin-assets/images/index/' .  $appsection->image));
                }
            }
            $image = 'appsection-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(storage_path('app/public/admin-assets/images/index/'), $image);
            $appsection->image = $image;
        }
        $appsection->save();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function footer_features_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (!empty($request->feature_icon)) {
            foreach ($request->feature_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->feature_title[$key]) && !empty($request->feature_description[$key])) {
                    $feature = new Footerfeatures;
                    $feature->vendor_id = $vendor_id;
                    $feature->icon = $icon;
                    $feature->title = $request->feature_title[$key];
                    $feature->description = $request->feature_description[$key];
                    $feature->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $feature = Footerfeatures::find($id);
                $feature->icon = $request->edi_feature_icon[$id];
                $feature->title = $request->edi_feature_title[$id];
                $feature->description = $request->edi_feature_description[$id];
                $feature->save();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete_feature(Request $request)
    {
        Footerfeatures::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function other_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (Auth::user()->type == 1) {
            $landingsettings = LandingSettings::where('vendor_id', $vendor_id)->first();

            if (empty($landingsettings)) {

                $landingsettings = new LandingSettings();
            }
            if ($request->hasfile('landing_home_banner')) {                
                if (file_exists(storage_path('app/public/admin-assets/images/banners/' . $landingsettings->landing_home_banner))) {
                    @unlink(storage_path('app/public/admin-assets/images/banners/' . $landingsettings->landing_home_banner));
                }
                $bannerimage = 'banner-' . uniqid() . '.' . $request->landing_home_banner->getClientOriginalExtension();
                $request->landing_home_banner->move(storage_path('app/public/admin-assets/images/banners/'), $bannerimage);
                $landingsettings->landing_home_banner = $bannerimage;
            }
            if ($request->hasfile('testimonial_image')) {                
                if (file_exists(storage_path('app/public/admin-assets/images/testimonials/' . $landingsettings->testimonial_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/testimonials/' . $landingsettings->testimonial_image));
                }
                $bannerimage = 'testimonial-' . uniqid() . '.' . $request->testimonial_image->getClientOriginalExtension();
                $request->testimonial_image->move(storage_path('app/public/admin-assets/images/testimonials/'), $bannerimage);
                $landingsettings->testimonial_image = $bannerimage;
            }
            if ($request->hasfile('subscribe_image')) {
               
                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $landingsettings->subscribe_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $landingsettings->subscribe_image));
                }
                $bannerimage = 'subscribe-' . uniqid() . '.' . $request->subscribe_image->getClientOriginalExtension();
                $request->subscribe_image->move(storage_path('app/public/admin-assets/images/index/'), $bannerimage);
                $landingsettings->subscribe_image = $bannerimage;
            }
            if ($request->hasfile('faq_image')) {
                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $landingsettings->faq_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $landingsettings->faq_image));
                }
                $bannerimage = 'faq-' . uniqid() . '.' . $request->faq_image->getClientOriginalExtension();
                $request->faq_image->move(storage_path('app/public/admin-assets/images/index/'), $bannerimage);
                $landingsettings->faq_image = $bannerimage;
            }
            $landingsettings->vendor_id = $vendor_id;
            $landingsettings->save();
        }
        if (Auth::user()->type == 2) {
            $settingdata = Settings::where('vendor_id', $vendor_id)->first();

            if ($request->hasfile('landin_page_cover_image')) {
                
                if ($settingdata->cover_image != "cover.png" && file_exists(storage_path('app/public/admin-assets/images/coverimage/' . $settingdata->cover_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/coverimage/' . $settingdata->cover_image));
                }
                $coverimage = 'cover-' . uniqid() . '.' . $request->landin_page_cover_image->getClientOriginalExtension();
                $request->landin_page_cover_image->move(storage_path('app/public/admin-assets/images/coverimage/'), $coverimage);
                $settingdata->cover_image = $coverimage;
            }
            if ($request->hasfile('subscribe_image')) {
                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $settingdata->subscribe_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $settingdata->subscribe_image));
                }
                $bannerimage = 'subscribe-' . uniqid() . '.' . $request->subscribe_image->getClientOriginalExtension();
                $request->subscribe_image->move(storage_path('app/public/admin-assets/images/index/'), $bannerimage);
                $settingdata->subscribe_image = $bannerimage;
            }
            if ($request->hasfile('order_detail_image')) {              
                if (file_exists(storage_path('app/public/admin-assets/images/index/' . $settingdata->order_detail_image))) {
                    @unlink(storage_path('app/public/admin-assets/images/index/' . $settingdata->order_detail_image));
                }
                $bannerimage = 'order_detail-' . uniqid() . '.' . $request->order_detail_image->getClientOriginalExtension();
                $request->order_detail_image->move(storage_path('app/public/admin-assets/images/index/'), $bannerimage);
                $settingdata->order_detail_image = $bannerimage;
            }
            $settingdata->product_ratting_switch = isset($request->product_ratting_switch) ? 1 : 2;
            $settingdata->online_order = isset($request->online_order_switch) ? 1 : 2;
            $settingdata->google_review = $request->google_review_url;
            $settingdata->min_order_amount = $request->min_order_amount;
            $settingdata->save();
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function fun_fact_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (!empty($request->funfact_icon)) {
            foreach ($request->funfact_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->funfact_title[$key]) && !empty($request->funfact_subtitle[$key])) {
                    $funfact = new FunFact;
                    $funfact->vendor_id = $vendor_id;
                    $funfact->icon = $icon;
                    $funfact->title = $request->funfact_title[$key];
                    $funfact->description = $request->funfact_subtitle[$key];
                    $funfact->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $funfact = FunFact::find($id);
                $funfact->icon = $request->edi_funfact_icon[$id];
                $funfact->title = $request->edi_funfact_title[$id];
                $funfact->description = $request->edi_funfact_subtitle[$id];
                $funfact->save();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function fun_fact_delete(Request $request)
    {
        FunFact::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function social_links_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        if (!empty($request->social_icon)) {
            foreach ($request->social_icon as $key => $icon) {
                if (!empty($icon) && !empty($request->social_link[$key])) {
                    $sociallink = new SocialLinks;
                    $sociallink->vendor_id = $vendor_id;
                    $sociallink->icon = $icon;
                    $sociallink->link = $request->social_link[$key];
                    $sociallink->save();
                }
            }
        }
        if (!empty($request->edit_icon_key)) {
            foreach ($request->edit_icon_key as $key => $id) {
                $sociallink = SocialLinks::find($id);
                $sociallink->icon = $request->edi_sociallink_icon[$id];
                $sociallink->link = $request->edi_sociallink_link[$id];
                $sociallink->save();
            }
        }
        return redirect()->back()->with('success', trans('messages.success'));
    }
    public function delete_sociallinks(Request $request)
    {
        SocialLinks::where('id', $request->id)->delete();
        return redirect()->back()->with('success', trans('messages.success'));
    }
}
