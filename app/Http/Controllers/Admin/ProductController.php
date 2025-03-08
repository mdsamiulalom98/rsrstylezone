<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Productimage;
use App\Models\Productprice;
use App\Models\Productcolor;
use App\Models\Productsize;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Toastr;
use File;
use Str;
use Image;
use DB;

class ProductController extends Controller
{
    public function getSubcategory(Request $request)
    {
        $subcategory = DB::table("subcategories")
        ->where("category_id", $request->category_id)
        ->pluck('subcategoryName', 'id');
        return response()->json($subcategory);
    }
    
    public function getChildcategory(Request $request)
    {
        $childcategory = DB::table("childcategories")
        ->where("subcategory_id", $request->subcategory_id)
        ->pluck('childcategoryName', 'id');
        return response()->json($childcategory);
    }
    
    function __construct()
    {
         $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
         $this->middleware('permission:product-create', ['only' => ['create','store']]);
         $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }
    
    public function index(Request $request)
    {
        if($request->keyword){
            $data = Product::orderBy('id','DESC')->where('name', 'LIKE', '%' . $request->keyword . "%")->with('image','category')->paginate(50);
        }else{
            $data = Product::orderBy('id','DESC')->with('image','category')->paginate(50);
        }
        return view('backEnd.product.index',compact('data'));
    }
    
    public function topsalesort()
    {
        // return 'ok';
        $data = Product::orderBy('sort','ASC')->with('image','category')->select('id', 'name', 'category_id', 'new_price', 'topsale','sort', 'status')->get();
        // return $data;
        return view('backEnd.product.topsalesort', compact('data'));
    }
    
    public function sort(Request $request)
    {
        // Validate the input to ensure it is an array
        $orderArray = $request->validate([
            'sort' => 'array|required',
        ])['sort'];
        // return $orderArray;
        // Fetch all categories from the database
        $products = Product::all();
    
        // Loop through the order array and update the sort field for each category
        foreach ($products as $product) {
            // Find the category's new sort order from the submitted array
            $newSortOrder = array_search($product->sort, $orderArray);
    
            // Update the sort field only if the category exists in the order array
            if ($newSortOrder !== false) {
                $product->update(['sort' => $newSortOrder + 1]);
            }
        }
        
        // foreach ($products as $index => $product) {
        //     // Update the sort field with the index + 1
        //     $product->update(['sort' => $index + 1]);
        // }
        Toastr::success('Your products are sorted');
        return redirect()->back();
    }
    
    public function create()
    {
        $categories = Category::where('parent_id','=','0')->where('status',1)->select('id','name','status')->with('childrenCategories')->get();
        $brands = Brand::where('status','1')->select('id','name','status')->get();
        $colors = Color::where('status','1')->get();
        $sizes = Size::where('status','1')->get();
        return view('backEnd.product.create',compact('categories','brands','colors','sizes'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required',
            'purchase_price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
        ]);
        $last_id = Product::orderBy('id', 'desc')->select('id')->first();
        $last_id = $last_id?$last_id->id+1:1;
        
        $size_chart = $request->file('size_chart');
        if($size_chart){
            // $size_chart = $request->file('size_chart');
            $name2 =  time().'-'.$size_chart->getClientOriginalName();
            $name2 = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name2);
            $name2 = strtolower(preg_replace('/\s+/', '-', $name2));
            $uploadpath2 = 'public/uploads/size_chart/';
            $size_chartUrl = $uploadpath2.$name2; 
            // return $size_chartUrl;
            $img2=Image::make($size_chart->getRealPath());
            $img2->encode('webp', 90);
            $width ='';
            $height = '';
            $img2->height() > $img2->width() ? $width=null : $height=null;
            $img2->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img2->save($size_chartUrl);
        }
        else{
            $size_chartUrl='';
        }

        $input = $request->except(['image','files','proSize','proColor']);
        $input['slug'] = strtolower(Str::slug($request->name.'-'.$last_id));
        $input['size_chart'] = $size_chartUrl;
        $input['status'] = $request->status?1:0;
        $input['topsale'] = $request->topsale?1:0;
        $input['feature_product'] = $request->feature_product?1:0;
        $input['product_code'] = 'MV' . str_pad($last_id, 4, '0', STR_PAD_LEFT);
        $save_data = Product::create($input);
        $save_data->sizes()->attach($request->proSize);
        $save_data->colors()->attach($request->proColor);
        
        // image with intervention 
        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
            	$uploadPath = 'public/uploads/product/';
            	$image->move($uploadPath,$name);
            	$imageUrl =$uploadPath.$name;

                $pimage             = new Productimage();
                $pimage->product_id = $save_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        }
        // image with intervention 
        
        Toastr::success('Success','Data insert successfully');
        return redirect()->route('products.index');
    }
    
    protected function findAvailableNumber($number)
    {
        $i = 1;
    
        // Loop until finding a unique number
        while (Product::where('sort', $number)->exists()) {
            $number = $number . ++$i;
        }
    
        return $number;
    }
    
    public function edit($id)
    {
        $edit_data = Product::with('images')->find($id);
        $categories = Category::where('parent_id','=','0')->where('status',1)->select('id','name','status')->get();
        $categoryId = Product::find($id)->category_id;
        $subcategoryId = Product::find($id)->subcategory_id;
        $subcategory = Subcategory::where('category_id', '=', $categoryId)->select('id','subcategoryName','status')->get();
        $childcategory = Childcategory::where('subcategory_id', '=', $subcategoryId)->select('id', 'childcategoryName', 'status')->get();
        $brands = Brand::where('status','1')->select('id','name','status')->get();
        $totalsizes = Size::where('status',1)->get();
        $totalcolors = Color::where('status',1)->get();
        $selectcolors = Productcolor::where('product_id',$id)->get();
        $selectsizes = Productsize::where('product_id',$id)->get();
        return view('backEnd.product.edit',compact('edit_data','categories', 'subcategory', 'childcategory', 'brands', 'selectcolors', 'selectsizes','totalsizes', 'totalcolors'));
    }
    
    public function update(Request $request)
    {
       $this->validate($request, [
            'name' => 'required',
            'category_id' => 'required',
            'new_price' => 'required',
            'purchase_price' => 'required',
            'stock' => 'required',
            'category_id' => 'required',
        ]);
        
        $update_data = Product::find($request->id);
        $input = $request->except(['image','files','proSize','proColor']);
        
        $size_chart = $request->file('size_chart');
        if($size_chart){
            // size_chart with intervention 
            $name =  time().'-'.$size_chart->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp',$name);
            $name = strtolower(preg_replace('/\s+/', '-', $name));
            $uploadpath = 'public/uploads/size_chart/';
            $size_chartUrl = $uploadpath.$name; 
            $img=Image::make($size_chart->getRealPath());
            $img->encode('webp', 90);
            $width ='';
            $height = '';
            $img->height() > $img->width() ? $width=null : $height=null;
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($size_chartUrl);
            $input['size_chart'] = $size_chartUrl;
            File::delete($update_data->size_chart);
        }else{
            $input['size_chart'] = $update_data->size_chart;
        }

        $input['slug'] = strtolower(Str::slug($request->name.'-'.$update_data->id));
        $input['status'] = $request->status?1:0;
        $input['topsale'] = $request->topsale?1:0;
        $input['feature_product'] = $request->feature_product?1:0;
        $update_data->update($input);
        $update_data->sizes()->sync($request->proSize);
        $update_data->colors()->sync($request->proColor);

        // image with intervention 
        $images = $request->file('image');
        if($images){
            foreach ($images as $key => $image) {
                $name =  time().'-'.$image->getClientOriginalName();
                $name = strtolower(preg_replace('/\s+/', '-', $name));
            	$uploadPath = 'public/uploads/product/';
            	$image->move($uploadPath,$name);
            	$imageUrl =$uploadPath.$name;

                $pimage             = new Productimage();
                $pimage->product_id = $update_data->id;
                $pimage->image      = $imageUrl;
                $pimage->save();
            }
        }
        
        

        Toastr::success('Success','Data update successfully');
        return redirect()->route('products.index');
    }
 
    public function inactive(Request $request)
    {
        $inactive = Product::find($request->hidden_id);
        $inactive->status = 0;
        $inactive->save();
        Toastr::success('Success','Data inactive successfully');
        return redirect()->back();
    }
    public function active(Request $request)
    {
        $active = Product::find($request->hidden_id);
        $active->status = 1;
        $active->save();
        Toastr::success('Success','Data active successfully');
        return redirect()->back();
    }
    public function destroy(Request $request)
    {
        $delete_data = Product::find($request->hidden_id);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    }
    public function imgdestroy(Request $request)
    { 
        $delete_data = Productimage::find($request->id);
        File::delete($delete_data->image);
        $delete_data->delete();
        Toastr::success('Success','Data delete successfully');
        return redirect()->back();
    } 
    public function pricedestroy(Request $request)
    { 
        $delete_data = Productprice::find($request->id);
        $delete_data->delete();
        Toastr::success('Success','Product price delete successfully');
        return redirect()->back();
    }
    public function update_deals(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['topsale' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Hot deals product status change']);
    }
    public function update_feature(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['feature_product' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Feature product status change']);
    }
    public function update_status(Request $request){
        $products = Product::whereIn('id', $request->input('product_ids'))->update(['status' => $request->status]);
        return response()->json(['status'=>'success','message'=>'Product status change successfully']);
    }
}
