<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use Toastr;
use Image;
use File;
use Str;
use DB;

class SubcategoryController extends Controller
{
    public function getCategory(Request $request){
        $category = DB::table("categories")
        ->where("service_category", $request->service_category)
        ->pluck('name', 'id');
        return response()->json($category);
    }        

    function __construct()
    {
        $this->middleware('permission:subcategory-list|subcategory-create|subcategory-edit|subcategory-delete', ['only' => ['index','store']]);
        $this->middleware('permission:subcategory-create', ['only' => ['create','store']]);
        $this->middleware('permission:subcategory-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:subcategory-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = Subcategory::orderBy('id','DESC')->with('category')->get();
        return view('backEnd.subcategory.index',compact('data'));
    }
    public function create()
    {
        $categories = Category::get();
        return view('backEnd.subcategory.create', compact('categories'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'subcategoryName' => 'required',
            'status' => 'required',
        ]);
        // image with intervention 
        $image = $request->file('image');
        if($image !=NULL){
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/subcategory/';
            $imageUrl = $uploadpath.$name; 
            $img=Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = "";
            $height = "";
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
        }else{
            $imageUrl = NULL;
        }        
      
        $input = $request->all();

        $cat_namespace = Category::where('id', $request->category_id)->select('id', 'namespace', 'name')->first();

        // Get the namespace value
        $namespace = $cat_namespace->namespace;
        
        // Generate the slug from $request->subcategoryName
        $slug = strtolower(Str::slug($request->subcategoryName));
        
        // Concatenate the namespace and slug
        $concatenatedValue = $namespace . '-' . $slug;
        
        // Now you can use $concatenatedValue as needed
        $input['slug'] = $concatenatedValue;
        $input['image'] = $imageUrl;
        Subcategory::create($input);
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('subcategories.index');
    }
    
    public function edit($id)
    {
        $edit_data = Subcategory::find($id);
        $categories = Category::select('id','name')->get();
        return view('backEnd.subcategory.edit',compact('edit_data','categories'));
    }
    
    public function update(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'subcategoryName' => 'required',
            'status' => 'required',
        ]);
        $update_data = Subcategory::find($request->id);
        $input = $request->all();
        $image = $request->file('image');
        
        if($image){
            // image with intervention 
            $name =  time().'-'.$image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/subcategory/';
            $imageUrl = $uploadpath.$name; 
            $img=Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = "";
            $height = "";
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($imageUrl);
            $input['image'] = $imageUrl;
            File::delete($update_data->image);
        }else{
            $input['image'] = $update_data->image;
        }

        $cat_namespace = Category::where('id', $request->category_id)->select('id', 'namespace', 'name')->first();

        // Get the namespace value
        $namespace = $cat_namespace->namespace;
        
        // Generate the slug from $request->subcategoryName
        $slug = strtolower(Str::slug($request->subcategoryName));
        
        // Concatenate the namespace and slug
        $concatenatedValue = $namespace . '-' . $slug;
        
        // Now you can use $concatenatedValue as needed
        $input['slug'] = $concatenatedValue;
        
        $input['status'] = $request->status?1:0;
        
        $update_data->update($input);

        Toastr::success('Success','Data update successfully');
        return redirect()->route('subcategories.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Subcategory::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Subcategory::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Subcategory::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
}

