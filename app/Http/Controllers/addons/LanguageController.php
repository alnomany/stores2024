<?php
namespace App\Http\Controllers\addons;
use App\Http\Controllers\Controller;
use App\Models\Languages;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use File;
class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $getlanguages = Languages::get();
        if ($request->code == "") {
            foreach ($getlanguages as $firstlang) {
                $currantLang = Languages::where('code', $firstlang->code)->first();
                break;
            }
        } else {
            $currantLang = Languages::where('code', $request->code)->first();
        }
        if ($request->has('lang')) {
            if ($request->lang != "" && $request->lang != null) {
                $settingdata = Settings::where('vendor_id', 1)->first();
                $settingdata->default_language = $request->lang;
                $settingdata->update();
            }
        }
        if (empty($currantLang)) {
            $dir = base_path() . '/resources/lang/' . 'en';
        } else {
            $dir = base_path() . '/resources/lang/' . $currantLang->code;
        }
        if (!is_dir($dir)) {
            $dir = base_path() . '/resources/lang/en';
        }
        $arrLabel   = json_decode(file_get_contents($dir . '/' . 'labels.json'));
        $arrMessage   = json_decode(file_get_contents($dir . '/' . 'messages.json'));
        $arrLanding   = json_decode(file_get_contents($dir . '/' . 'landing.json'));
        return view('admin.language.index', compact('getlanguages', 'currantLang', 'arrLabel', 'arrMessage', 'arrLanding'));
    }
    public function add()
    {
        return view('admin.language.add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'layout' => 'required',
            'name' => 'required_with:code',
            'image.*' => 'mimes:jpeg,png,jpg',
        ], [
            "code.required" => trans('messages.language_required'),
            "layout.required" => trans('messages.layout_required'),
            "name.required_with" => trans('messages.wrong'),
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $path = base_path('resources/lang/' . $request->code);
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            File::copyDirectory(base_path() . '/resources/lang/en', base_path() . '/resources/lang/' . $request->code);
            $language = new Languages();
            $language->code = $request->code;
            $language->name = $request->name;
            $language->layout = $request->layout;
            if ($request->has('image')) {
                $flagimage = 'flag-' . uniqid() . "." . $request->file('image')->getClientOriginalExtension();
                $request->file('image')->move(storage_path('app/public/admin-assets/images/language/'), $flagimage);
                $language->image = $flagimage;
            }
            $language->is_available = 1;
            $language->save();
            return redirect('admin/language-settings')->with('success', trans('messages.success'));
        }
    }
}
