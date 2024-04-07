<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    public function index(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $allcategories = Category::where('vendor_id', $vendor_id)->where('is_deleted', 2)->orderBy('reorder_id')->get();
        return view('admin.category.category', compact("allcategories"));
    }
    public function add_category(Request $request)
    {
        return view('admin.category.add');
    }
    public function save_category(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $request->validate([
            'category_name' => 'required',
            
        ], [
            'category_name.required' => trans('messages.category_name_required'),
        ]);
        $check_slug = Category::where('slug', Str::slug($request->category_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Category::select('id')->orderByDesc('id')->first()->id;
            $slug = Str::slug($request->category_name . ' ' . $last_id, '-');
        } else {
            $slug = Str::slug($request->category_name, '-');
        }
        $savecategory = new Category();
        $savecategory->vendor_id = $vendor_id;
        $savecategory->name = $request->category_name;
        $savecategory->slug = $slug;
        $savecategory->save();
        return redirect('admin/categories/')->with('success', trans('messages.success'));
    }
    public function edit_category(Request $request)
    {
        $editcategory = category::where('slug', $request->slug)->first();
        return view('admin.category.edit', compact("editcategory"));
    }
    public function update_category(Request $request)
    {
        $request->validate([
            'category_name' => 'required',
        ], [
                'category_name.required' => trans('messages.category_name_required'),
            ]);
        $check_slug = Category::where('slug', Str::slug($request->category_name, '-'))->first();
        if (!empty($check_slug)) {
            $last_id = Category::select('id')->orderByDesc('id')->first()->id;
            $slug = Str::slug($request->category_name . ' ' . $last_id, '-');
        } else {
            $slug = Str::slug($request->category_name, '-');
        }
        $editcategory = Category::where('slug', $request->slug)->first();
        $editcategory->name = $request->category_name;
        $editcategory->slug = $slug;
        $editcategory->update();
        return redirect('admin/categories')->with('success', trans('messages.success'));
    }
    public function change_status(Request $request)
    {
        Category::where('slug', $request->slug)->update(['is_available' => $request->status]);
        return redirect('admin/categories')->with('success', trans('messages.success'));
    }
    public function delete_category(Request $request)
    {
        $checkcategory = Category::where('slug', $request->slug)->first();
        if (!empty($checkcategory)) {
            Item::where('cat_id', $checkcategory->id)->update(['is_available' => 2]);
            $checkcategory->is_deleted = 1;
            $checkcategory->save();
            return redirect('admin/categories')->with('success', trans('messages.success'));
        } else {
            return redirect()->back()->with('error', trans('messages.wrong'));
        }
    }
    public function reorder_category(Request $request)
    {
        if(Auth::user()->type == 4)
        {
            $vendor_id = Auth::user()->vendor_id;
        }else{
            $vendor_id = Auth::user()->id;
        }
        $getcategory = Category::where('vendor_id',$vendor_id )->get();
        foreach ($getcategory as $category) {
            foreach ($request->order as $order) {
               $category = Category::where('id',$order['id'])->first();
               $category->reorder_id = $order['position'];
               $category->save();
            }
        }
        return response()->json(['status' => 1,'msg' => trans('messages.success')], 200);
    }
}