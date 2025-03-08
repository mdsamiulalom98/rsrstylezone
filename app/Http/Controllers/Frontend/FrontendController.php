<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Childcategory;
use App\Models\Product;
use App\Models\District;
use App\Models\CreatePage;
use App\Models\Campaign;
use App\Models\CampaignProduct;
use App\Models\Banner;
use App\Models\ShippingCharge;
use App\Models\Productcolor;
use App\Models\Productsize;
use App\Models\Brand;
use App\Models\Review;
use Session;
use Toastr;
use Cart;

class FrontendController extends Controller
{
    public function index(){

        $sliders = Banner::where(['status' => 1, 'category_id' => 1])
            ->select('id', 'image', 'link')->limit(10)
            ->get();

        $hotdeal_top = Product::where(['status' => 1, 'topsale' => 1])
            ->select('id', 'name', 'slug','new_price','old_price')
            ->with('prosizes','twoimages')
            ->orderBy('sort', 'ASC')
            ->limit(8)
            ->get();

        $lathers = Product::where(['status' => 1, 'subcategory_id' => 26])
            ->select('id', 'name', 'slug','new_price','old_price')
            ->with('prosizes','twoimages')
            ->latest()
            ->get();
        // return $hotdeal_top;
        $newarrival = Product::where(['status' => 1, 'feature_product' => 1])
            ->select('id', 'name', 'slug','new_price','old_price')
            ->with('prosizes','twoimages')
            ->orderBy('sort', 'ASC')
            ->limit(8)
            ->get();
        // return $hotdeal_top;
        
        $slider_right = Banner::where(['status' => 1, 'category_id' => 3])
            ->limit(3)
            ->get();
        
        $slider_rights = Banner::where(['status' => 1, 'category_id' => 3])
            ->limit(4)
            ->get();
        
        $brand_items = Brand::where('status',1)
            ->get();
            // return $brand_items;

        $homeproducts = Category::where(['front_view' => 1, 'status' => 1])
            ->orderBy('id', 'ASC')
            ->with(['products', 'products.image'])
            ->get()
            ->map(function ($query) {
                $query->setRelation('products', $query->products->take(10));
                return $query;
            });


        return view('frontEnd.layouts.pages.index', compact('sliders','slider_rights','hotdeal_top','slider_right','brand_items','newarrival','lathers','homeproducts'));
    }

    public function newarrival(Request $request){
        $products = Product::where(['status' => 1, 'topsale' => 1])
            ->select('id', 'name', 'slug','new_price','old_price','category_id','topsale', 'short_description')->with('twoimages','prosizes');
            
        // return $request->sort;
        if($request->sort == 1){
            $products = $products->orderBy('created_at','desc');
        }elseif($request->sort == 2){
            $products = $products->orderBy('created_at','asc');
        }elseif($request->sort == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($request->sort == 4){
            $products = $products->orderBy('new_price','asc');
        }elseif($request->sort == 5){
            $products = $products->orderBy('name','asc');
        }elseif($request->sort == 6){
            $products = $products->orderBy('name','desc');
        }else{
            $products = $products->latest();
        }
         
        $products = $products->paginate(24);
       
        return view('frontEnd.layouts.pages.hotdeals', compact('products'));
    }

    public function discount(Request $request){
        $category = Category::where('slug',$request->slug)->first();
        $products = Product::where(['status' => 1,'category_id'=>$category->id])
        ->where('old_price','>','new_price')
        ->select('id', 'name', 'slug','new_price','old_price','category_id','topsale');
            
        // return $request->sort;
        if($request->sort == 1){
            $products = $products->orderBy('created_at','desc');
        }elseif($request->sort == 2){
            $products = $products->orderBy('created_at','asc');
        }elseif($request->sort == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($request->sort == 4){
            $products = $products->orderBy('new_price','asc');
        }elseif($request->sort == 5){
            $products = $products->orderBy('name','asc');
        }elseif($request->sort == 6){
            $products = $products->orderBy('name','desc');
        }else{
            $products = $products->latest();
        }
         
        $products = $products->paginate(24);
         $impproducts = Product::where(['status' => 1, 'topsale' => 1])
        ->with('image')
        ->limit(6)
        ->select('id', 'name', 'slug')
        ->get();
        return view('frontEnd.layouts.pages.offers', compact('products','impproducts','category'));
    }
    public function category($slug, Request $request)
    {
        $category = Category::where(['slug'=>$slug,'status'=>1])->first();
        $products = Product::where(['status' => 1, 'category_id' => $category->id])
            ->select('id', 'name', 'slug','new_price','old_price','category_id', 'short_description');
            
        // return $request->sort;
        if($request->sort == 1){
            $products = $products->orderBy('created_at','desc');
        }elseif($request->sort == 2){
            $products = $products->orderBy('created_at','asc');
        }elseif($request->sort == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($request->sort == 4){
            $products = $products->orderBy('new_price','asc');
        }elseif($request->sort == 5){
            $products = $products->orderBy('name','asc');
        }elseif($request->sort == 6){
            $products = $products->orderBy('name','desc');
        }else{
            $products = $products->latest();
        }
         
        $products = $products->paginate(24);
        // return $products;
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image','twoimages')
            ->limit(6)
            ->select('id', 'name', 'slug')
            ->get();
        
        return view('frontEnd.layouts.pages.category', compact('category','products', 'impproducts'));
    }
    public function subcategory($slug, Request $request)
    {
        $category = Subcategory::where(['slug'=>$slug,'status'=>1])->first();
        $products = Product::where(['status' => 1, 'subcategory_id' => $category->id])
            ->select('id', 'name', 'slug','new_price','old_price','subcategory_id', 'short_description');
            
        // return $request->sort;
        if($request->sort == 1){
            $products = $products->orderBy('created_at','desc');
        }elseif($request->sort == 2){
            $products = $products->orderBy('created_at','asc');
        }elseif($request->sort == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($request->sort == 4){
            $products = $products->orderBy('new_price','asc');
        }elseif($request->sort == 5){
            $products = $products->orderBy('name','asc');
        }elseif($request->sort == 6){
            $products = $products->orderBy('name','desc');
        }else{
            $products = $products->latest();
        }
         
        $products = $products->paginate(24);
        // return $products;
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image','twoimages')
            ->limit(6)
            ->select('id', 'name', 'slug')
            ->get();
        
        return view('frontEnd.layouts.pages.subcategory', compact('category','products', 'impproducts'));
    }

    public function childcategory($slug, Request $request)
    {
        $category = Childcategory::where(['slug'=>$slug,'status'=>1])->first();
        $products = Product::where(['status' => 1, 'childcategory_id' => $category->id])
            ->select('id', 'name', 'slug','new_price','old_price','childcategory_id', 'short_description');
            
        // return $request->sort;
        if($request->sort == 1){
            $products = $products->orderBy('created_at','desc');
        }elseif($request->sort == 2){
            $products = $products->orderBy('created_at','asc');
        }elseif($request->sort == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($request->sort == 4){
            $products = $products->orderBy('new_price','asc');
        }elseif($request->sort == 5){
            $products = $products->orderBy('name','asc');
        }elseif($request->sort == 6){
            $products = $products->orderBy('name','desc');
        }else{
            $products = $products->latest();
        }
         
        $products = $products->paginate(24);
        // return $products;
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
            ->with('image','twoimages')
            ->limit(6)
            ->select('id', 'name', 'slug')
            ->get();
        
        return view('frontEnd.layouts.pages.childcategory', compact('category','products', 'impproducts'));
    }

    public function details($slug){
        $details = Product::where(['slug' => $slug, 'status' => 1])
            ->with('image', 'images', 'category', 'subcategory', 'childcategory')
            ->firstOrFail();
        // return $details;
        $products = Product::where(['category_id' => $details->category_id, 'status' => 1])
            ->with('image','twoimages')
            ->select('id', 'name', 'slug', 'new_price', 'old_price')
            ->get();
        
        $shippingcharge = ShippingCharge::where('status',1)->get();

        $productcolors = Productcolor::where('product_id', $details->id)
            ->with('color')
            ->get();
            // return $productcolors;
        $productsizes = Productsize::where('product_id', $details->id)
            ->with('size')
            ->get();
        $productreviews = Review::where('product_id', $details->id)->get();
        // return $productreviews;
        return view('frontEnd.layouts.pages.details', compact('details', 'products','shippingcharge','productcolors','productsizes', 'productreviews'));
    }
    public function quickview(Request $request){
        $details['details'] = Product::where(['id'=>$request->id,'status'=>1])->with('images','prosizes','procolors')->withCount('reviews')->first();
        $details = view('frontEnd.layouts.ajax.quickview', $details)->render();
        if ($details != '') 
        {
            echo $details;
        }
    }
    public function livesearch(Request $request){
        $products = Product::select('id', 'name', 'slug','new_price','old_price')
            ->where('status', 1)
            ->with('image');
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        $product_count = $products->count();
        $products = $products->limit(3)->get();
        if (empty($request->category) && empty($request->keyword)) {
            $products = [];
        }
        $category = $request->category;
        $keyword = $request->keyword;
        return view('frontEnd.layouts.ajax.search', compact('products','product_count','category','keyword'));
    }
    public function search(Request $request){
        $products = Product::where(['status' => 1])
        ->where('old_price','>','new_price')
        ->select('id', 'name', 'slug','new_price','old_price','category_id','topsale');
            
        // return $request->sort;
        if($request->sort == 1){
            $products = $products->orderBy('created_at','desc');
        }elseif($request->sort == 2){
            $products = $products->orderBy('created_at','asc');
        }elseif($request->sort == 3){
            $products = $products->orderBy('new_price','desc');
        }elseif($request->sort == 4){
            $products = $products->orderBy('new_price','asc');
        }elseif($request->sort == 5){
            $products = $products->orderBy('name','asc');
        }elseif($request->sort == 6){
            $products = $products->orderBy('name','desc');
        }else{
            $products = $products->latest();
        }
        if ($request->keyword) {
            $products = $products->where('name', 'LIKE', '%' . $request->keyword . "%");
        }
        if ($request->category) {
            $products = $products->where('category_id', $request->category);
        }
        $products = $products->paginate(36);
        $impproducts = Product::where(['status' => 1, 'topsale' => 1])
        ->with('image')
        ->limit(6)
        ->select('id', 'name', 'slug')
        ->get();
        $keyword = $request->keyword;
        return view('frontEnd.layouts.pages.search', compact('products','keyword','impproducts'));
    }

    public function shipping_charge(Request $request){
        $shipping = ShippingCharge::where(['id' => $request->id])->first();
        Session::put('shipping', $shipping->amount);
        return view('frontEnd.layouts.ajax.cart');
    }

    public function contact(Request $request){
        return view('frontEnd.layouts.pages.contact');
    }

    public function page($slug){
        $page = CreatePage::where('slug', $slug)->firstOrFail();
        return view('frontEnd.layouts.pages.page', compact('page'));
    }
     public function districts(Request $request){
        $areas = District::where(['district'=>$request->id])->pluck('area_name','id');
        return response()->json($areas);
    }
    public function campaign($slug)
    {
        $campaign_data = Campaign::where('slug', $slug)->with('images')->first();
        $product = Product::where('id', $campaign_data->product_id)
            ->where('status', 1)
            ->with('image')
            ->first();
        Cart::instance('shopping')->destroy();
        $cart_count = Cart::instance('shopping')->count();
        if ($cart_count == 0) {
            Cart::instance('shopping')->add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->new_price,
                'options' => [
                    'slug' => $product->slug,
                    'image' => $product->image->image,
                    'old_price' => $product->old_price,
                    'purchase_price' => $product->purchase_price,
                ],
            ]);
        }
        $shippingcharge = ShippingCharge::where(['status'=>1,])->get();
        $select_charge = ShippingCharge::where(['status'=>1,])->first();
        Session::put('shipping', $select_charge->amount);
        return view('frontEnd.layouts.pages.campaign.campaign', compact('campaign_data', 'product', 'shippingcharge'));
    }
    
    public function productCampaign($slug, Request $request){
         $campaign_id = $request->query('campaign_id');
         $product_id = $request->query('pro_id');
        $details = Product::where('id', $product_id)->with(['campaignproduct' => function ($query) use ($campaign_id){
            $query->where('campaign_id', $campaign_id);
        }, 'image', 'images'])->first();
      
        $productcolors = Productcolor::where('product_id', $details->id)
            ->with('color')
            ->get();
        $productsizes = Productsize::where('product_id', $details->id)
            ->with('size')
            ->get();
            
        
        return view('frontEnd.layouts.pages.campaign.productDetails', compact('details','productcolors', 'productsizes'));
    }
}
