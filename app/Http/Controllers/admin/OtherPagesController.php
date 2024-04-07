<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Privacypolicy;
use App\Models\Terms;
use App\Models\About;
use App\Models\Subscriber;
use App\Models\Country;
use App\Models\Settings;
use App\Models\City;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Faq;
use App\Models\Contact;
use URL;

class OtherPagesController extends Controller
{
    public function share()
    {
        $url = URL::to('/' . Auth::user()->slug);
        $shareComponent = \Share::page(
            $url
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->telegram()
            ->whatsapp()
            ->reddit();
        return view('admin.otherpages.share', compact('shareComponent'));
    }
    // -----------------------------------------------------------------
    // -------------------  Privacy-Policy  ----------------------------
    // -----------------------------------------------------------------
    public function privacypolicy()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getprivacypolicy = Privacypolicy::where('vendor_id', $vendor_id)->first();
        return view('admin.otherpages.privacypolicy', compact('getprivacypolicy'));
    }
    public function privacypolicy_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $validator = Validator::make(
            $request->all(),
            ['privacypolicy' => 'required'],
            ["privacypolicy.required" => trans('messages.content_required')]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $privacypolicy = Privacypolicy::where('vendor_id', $vendor_id)->first();
            if (empty($privacypolicy)) {
                $privacypolicy = new Privacypolicy();
                $privacypolicy->vendor_id = $vendor_id;
            }
            $privacypolicy->privacypolicy_content = $request->privacypolicy;
            $privacypolicy->save();
            return redirect('admin/privacy-policy')->with('success', trans('messages.success'));
        }
    }
    // -----------------------------------------------------------------
    // ------------------- Terms-Condition -----------------------------
    // -----------------------------------------------------------------
    public function termscondition()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $gettermscondition = Terms::where('vendor_id', $vendor_id)->first();
        return view('admin.otherpages.termscondition', compact('gettermscondition'));
    }
    public function termscondition_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $validator = Validator::make(
            $request->all(),
            ['termscondition' => 'required'],
            ["termscondition.required" => trans('messages.content_required')]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $termscondition = Terms::where('vendor_id', $vendor_id)->first();
            if (empty($termscondition)) {
                $termscondition = new Terms();
                $termscondition->vendor_id = $vendor_id;
            }
            $termscondition->terms_content = $request->termscondition;
            $termscondition->save();
            return redirect('admin/terms-conditions')->with('success', trans('messages.success'));
        }
    }
    // -----------------------------------------------------------------
    // ------------------- About us -----------------------------
    // -----------------------------------------------------------------
    public function aboutus()
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getaboutus = About::where('vendor_id', $vendor_id)->first();
        return view('admin.otherpages.aboutus', compact('getaboutus'));
    }
    public function aboutus_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $validator = Validator::make(
            $request->all(),
            ['aboutus' => 'required'],
            ["aboutus.required" => trans('messages.content_required')]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $aboutus = About::where('vendor_id', $vendor_id)->first();
            if (empty($aboutus)) {
                $aboutus = new About();
                $aboutus->vendor_id = $vendor_id;
            }
            $aboutus->about_content = $request->aboutus;
            $aboutus->save();
            return redirect('admin/aboutus')->with('success', trans('messages.success'));
        }
    }
    public function faq_index(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $faqs = Faq::where('vendor_id',$vendor_id)->orderBy('reorder_id')->get();
        return view('admin.faqs.index', compact('faqs'));
    }
    public function faq_add(Request $request)
    {
        return view('admin.faqs.add');
    }
    public function faq_save(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ], [
            'question.required' => trans('messages.question_required'),
            'answer.required' => trans('messages.answer_required'),
        ]);
        $faqs = new Faq();
        $faqs->vendor_id = $vendor_id;
        $faqs->question = $request->question;
        $faqs->answer = $request->answer;
        $faqs->save();
        return redirect('/admin/faqs')->with('success', trans('messages.success'));
    }
    public function faq_edit(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getfaq = Faq::where('vendor_id',$vendor_id)->where('id', $request->id)->first();
        return view('admin.faqs.edit', compact('getfaq'));
    }
    public function faq_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'question' => 'required',
            'answer' => 'required'
        ], [
            'question.required' => trans('messages.question_required'),
            'answer.required' => trans('messages.answer_required'),
        ]);
        $getfaq = Faq::where('id', $request->id)->first();
        $getfaq->vendor_id = $vendor_id;
        $getfaq->question = $request->question;
        $getfaq->answer = $request->answer;
        $getfaq->update();
        return redirect('/admin/faqs')->with('success', trans('messages.success'));
    }
    public function faq_delete(Request $request)
    {
        $deletefaq = Faq::where('id', $request->id)->first();
        $deletefaq->delete();
        return redirect('/admin/faqs')->with('success', trans('messages.success'));
    }

    public function reorder_faq(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getfaqs =  Faq::where('vendor_id',$vendor_id)->get();
        foreach ($getfaqs as $faq) {
            foreach ($request->order as $order) {
                $faq = Faq::where('id', $order['id'])->first();
                $faq->reorder_id = $order['position'];
                $faq->save();
            }
        }
        return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
    }
    public function subscribers(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getsubscribers = Subscriber::where('vendor_id', $vendor_id)->orderByDesc('id')->get();
        return view('admin.subscriber.index', compact('getsubscribers'));
    }
    public function subscribers_delete(Request $request)
    {
        $subscriber = Subscriber::find($request->id);
        if (!empty($subscriber)) {
            $subscriber->delete();
            return redirect('/admin/subscribers')->with('success', trans('messages.success'));
        }
        return redirect('/admin/subscribers')->with('error', trans('messages.wrong'));
    }
    public function inquiries(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $getinquiries = Contact::where('vendor_id', $vendor_id)->orderByDesc('id')->get();
        return view('admin.inquiries.index', compact('getinquiries'));
    }
    public function inquiries_delete(Request $request)
    {
        $inquiry = Contact::find($request->id);
        if (!empty($inquiry)) {
            $inquiry->delete();
            return redirect('/admin/inquiries')->with('success', trans('messages.success'));
        }
        return redirect('/admin/inquiries')->with('error', trans('messages.wrong'));
    }
    public function countries(Request $request)
    {
        $allcontries = Country::where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.country.index', compact('allcontries'));
    }
    public function add_country(Request $request)
    {
        return view('admin.country.add');
    }
    public function save_country(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);
        $country = new Country();
        $country->name = $request->name;
        $country->save();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function edit_country(Request $request)
    {
        $editcountry = Country::where('id', $request->id)->first();
        return view('admin.country.edit', compact('editcountry'));
    }
    public function update_country(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);
        $editcountry = Country::where('id', $request->id)->first();
        $editcountry->name = $request->name;
        $editcountry->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function delete_country(Request $request)
    {
        $country = Country::where('id', $request->id)->first();
        $country->is_deleted = 1;
        $country->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }
    public function statuschange_country(Request $request)
    {
        $country = Country::where('id', $request->id)->first();
        $country->is_available = $request->status;
        $country->update();
        return redirect('/admin/countries')->with('success', trans('messages.success'));
    }

    public function reorder_city(Request $request)
    {
           
            $getcity = Country::where('is_deleted', 2)->get();
            foreach ($getcity as $city) {
                foreach ($request->order as $order) {
                    $city = Country::where('id', $order['id'])->first();
                    $city->reorder_id = $order['position'];
                    $city->save();
                }
            }
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        
    }

    public function reorder_area(Request $request)
    {
           
            $getarea = City::with('country_info')->where('is_deleted', 2)->get();
            foreach ($getarea as $area) {
                foreach ($request->order as $order) {
                    $area = City::where('id', $order['id'])->first();
                    $area->reorder_id = $order['position'];
                    $area->save();
                }
            }
            return response()->json(['status' => 1, 'msg' => trans('messages.success')], 200);
        
    }
    public function cities(Request $request)
    {
        $allcities = City::with('country_info')->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.city.index', compact('allcities'));
    }
    public function add_city(Request $request)
    {
        $allcountry = Country::where('is_deleted', 2)->get();
        return view('admin.city.add', compact('allcountry'));
    }
    public function save_city(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);
        $city = new City();
        $city->country_id = $request->country;
        $city->city = $request->name;
        $city->save();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function edit_city(Request $request)
    {
        $allcountry = Country::where('is_deleted', 2)->get();
        $editcity = City::where('id', $request->id)->first();
        return view('admin.city.edit', compact('editcity', 'allcountry'));
    }
    public function update_city(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => trans('messages.name_required'),
        ]);
        $editcity = City::where('id', $request->id)->first();
        $editcity->country_id = $request->country;
        $editcity->city = $request->name;
        $editcity->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function delete_city(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        $city->is_deleted = 1;
        $city->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function statuschange_city(Request $request)
    {
        $city = City::where('id', $request->id)->first();
        $city->is_available = $request->status;
        $city->update();
        return redirect('/admin/cities')->with('success', trans('messages.success'));
    }
    public function refund_policy(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $policy = Settings::where('vendor_id',$vendor_id)->first();
       return view('admin.otherpages.refundpolicy',compact('policy'));
    }
    public function refund_policy_update(Request $request)
    {
        if (Auth::user()->type == 4) {
            $vendor_id = Auth::user()->vendor_id;
        } else {
            $vendor_id = Auth::user()->id;
        }
        $policy = Settings::where('vendor_id',$vendor_id)->first();
        $policy->refund_policy = $request->refund_policy;
        $policy->update();
        return redirect('/admin/refund_policy')->with('success', trans('messages.success'));
    }
}
