<?php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Brian2694\Toastr\Facades\Toastr;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Models\Product;
use App\Models\ShippingCharge;
class ShoppingController extends Controller
{
    public function cart_store(Request $request)
    {
        $product = Product::select('id', 'name', 'slug', 'old_price', 'new_price', 'purchase_price')->where(['id' => $request->id])->first();
        Cart::instance('shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $product->old_price,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'purchase_price' => $product->purchase_price,
            ],
        ]);
        $data = Cart::instance('shopping')->content();
        return response()->json(['data' => $data]);
    }
    public function dcart_store(Request $request)
    {

        $product = Product::select('id', 'name', 'slug', 'old_price', 'new_price', 'purchase_price')->where(['id' => $request->id])->first();
        Cart::instance('shopping')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $request->cam_pro_price ? $request->cam_pro_price : $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $product->old_price,
                'product_size' => $request->product_size,
                'product_color' => $request->product_color,
                'purchase_price' => $product->purchase_price,
            ],
        ]);

        Toastr::success('Product successfully add to cart', 'Success!');
        if ($request->order_now) {
            return redirect()->route('customer.checkout');
        }
        return back();
    }
    public function cart_show(Request $request)
    {
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.pages.cart', compact('data'));
    }

    public function cart_remove(Request $request)
    {
        $remove = Cart::instance('shopping')->update($request->id, 0);
        $data = Cart::instance('shopping')->content();
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_increment(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty + 1;
        $increment = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        if (Cart::instance('shopping')->count() > 1) {
            Session::put('shipping', 0);
        } else {
            $shipping_id = Session::get('shipping_id');
            $shipping = ShippingCharge::where(['id' => $shipping_id])->first();
            Session::put('shipping', $shipping->amount);
        }
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_decrement(Request $request)
    {
        $item = Cart::instance('shopping')->get($request->id);
        $qty = $item->qty - 1;
        $decrement = Cart::instance('shopping')->update($request->id, $qty);
        $data = Cart::instance('shopping')->content();
        if (Cart::instance('shopping')->count() > 1) {
            Session::put('shipping', 0);
        } else {
            $shipping_id = Session::get('shipping_id');
            $shipping = ShippingCharge::where(['id' => $shipping_id])->first();
            Session::put('shipping', $shipping->amount);
        }
        return view('frontEnd.layouts.ajax.cart', compact('data'));
    }
    public function cart_count(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.cart_count', compact('data'));
    }
    public function mobilecart_qty(Request $request)
    {
        $data = Cart::instance('shopping')->count();
        return view('frontEnd.layouts.ajax.mobilecart_qty', compact('data'));
    }

    // wishlist script
    public function wishlist_store(Request $request)
    {
        $product = Product::select('id', 'name', 'slug', 'old_price', 'new_price', 'purchase_price')->where(['id' => $request->id])->first();
        Cart::instance('wishlist')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $product->new_price,
                'purchase_price' => $product->purchase_price,
            ],
        ]);
        $data = Cart::instance('wishlist')->content();
        return response()->json('data');

    }
    public function wishlist_show()
    {
        $data = Cart::instance('wishlist')->content();
        return view('frontEnd.layouts.pages.wishlist', compact('data'));
    }
    public function wishlist_remove(Request $request)
    {
        $remove = Cart::instance('wishlist')->update($request->id, 0);
        $data = Cart::instance('wishlist')->content();
        return view('frontEnd.layouts.ajax.wishlist', compact('data'));
    }
    public function wishlist_count(Request $request)
    {
        $data = Cart::instance('wishlist')->count();
        return view('frontEnd.layouts.ajax.wishlist_count', compact('data'));
    }
    // compare script
    public function compare_store(Request $request)
    {
        $product = Product::select('id', 'name', 'slug', 'old_price', 'new_price', 'purchase_price')->where(['id' => $request->id])->first();
        Cart::instance('compare')->add([
            'id' => $product->id,
            'name' => $product->name,
            'qty' => $request->qty,
            'price' => $product->new_price,
            'options' => [
                'slug' => $product->slug,
                'image' => $product->image->image,
                'old_price' => $product->new_price,
                'purchase_price' => $product->purchase_price,
            ],
        ]);
        $data = Cart::instance('compare')->content();
        return response()->json('data');

    }
    public function compare_show()
    {
        $data = Cart::instance('compare')->content();
        return view('frontEnd.layouts.pages.compare', compact('data'));
    }
    public function compare_remove(Request $request)
    {
        $remove = Cart::instance('compare')->update($request->id, 0);
        $data = Cart::instance('compare')->content();
        return view('frontEnd.layouts.ajax.compare', compact('data'));
    }
    public function compare_count(Request $request)
    {
        $data = Cart::instance('compare')->count();
        return view('frontEnd.layouts.ajax.compare_count', compact('data'));
    }

}
