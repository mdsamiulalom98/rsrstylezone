<?php

namespace App\Http\Controllers\Frontend;
use Illuminate\Support\Facades\Http;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Gloudemans\Shoppingcart\Facades\Cart;
use Intervention\Image\Facades\Image;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\Customer;
use App\Models\District;
use App\Models\Order;
use App\Models\ShippingCharge;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Shipping;
use App\Models\Review;

class CustomerController extends Controller
{
    function __construct()
    {
        $this->middleware('customer', ['except' => ['register', 'store', 'verify', 'resendotp', 'account_verify', 'login', 'signin', 'logout', 'checkout', 'forgot_password', 'forgot_verify', 'forgot_reset', 'forgot_store', 'forgot_resend', 'order_save', 'order_success', 'order_track', 'order_track_result']]);
    }

    public function review(Request $request)
    {
        // return $request->all();
        $this->validate($request, [
            'ratting' => 'required',
            'review' => 'required',
        ]);

        // data save
        $customer = Auth::guard('customer')->user();
        $review = new Review();
        $review->name = $customer->name;
        $review->email = $customer->email;
        $review->customer_id = $customer->id;
        $review->product_id = $request->product_id;
        $review->review = $request->review;
        $review->ratting = $request->ratting;
        $review->status = 'pending';
        $review->save();


        Toastr::success('Thanks, Your review send successfully', 'Success!');
        return redirect()->back();

    }

    public function login()
    {
        return view('frontEnd.layouts.customer.login');
    }
    public function signin(Request $request)
    {
        $auth_check = Customer::where('phone', $request->phone)->first();
        if ($auth_check) {
            if (Auth::guard('customer')->attempt(['phone' => $request->phone, 'password' => $request->password])) {
                Toastr::success('You are login successfully', 'success!');
                if (Cart::instance('shopping')->count() > 0) {
                    return redirect()->route('customer.checkout');
                }
                return redirect()->intended('customer/account');
            }
            Toastr::error('message', 'Opps! your phone or password wrong');
            return redirect()->back();
        } else {
            Toastr::error('message', 'Sorry! You have no account');
            return redirect()->back();
        }
    }
    public function register()
    {
        return view('frontEnd.layouts.customer.register');
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'password' => 'required|min:6'
        ]);

        $last_id = Customer::orderBy('id', 'desc')->first();
        $last_id = $last_id ? $last_id->id + 1 : 1;
        $store = new Customer();
        $store->name = $request->name;
        $store->slug = strtolower(Str::slug($request->name . '-' . $last_id));
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->password = bcrypt($request->password);
        $store->verify = 1;
        $store->status = 'active';
        $store->save();
        Auth::guard('customer')->loginUsingId($store->id);
        if (Cart::instance('shopping')->count() > 0) {
            return redirect()->route('customer.checkout');
        }
        return redirect()->intended('customer/account');
    }
    public function verify()
    {
        return view('frontEnd.layouts.customer.verify');
    }
    public function resendotp(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->verify = rand(1111, 9999);
        $customer_info->save();

        $url = "https://msg.elitbuzz-bd.com/smsapi";
        $data = [
            "api_key" => "C200795560afdc9116bd26.38126411",
            "contacts" => $customer_info->phone,
            "type" => 'text',
            "senderid" => "8809612436177",
            "msg" => "Dear $customer_info->name!\r\nYour account verify OTP is $customer_info->verify \r\nThank you for using Marvel Fashion BD"
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function account_verify(Request $request)
    {
        $this->validate($request, [
            'otp' => 'required',
        ]);
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        if ($customer_info->verify != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $customer_info->verify = 1;
        $customer_info->status = 'active';
        $customer_info->save();
        Auth::guard('customer')->loginUsingId($customer_info->id);
        return redirect()->route('customer.account');
    }
    public function forgot_password()
    {
        return view('frontEnd.layouts.customer.forgot_password');
    }

    public function forgot_verify(Request $request)
    {
        $customer_info = Customer::where('phone', $request->phone)->first();
        if (!$customer_info) {
            Toastr::error('Your phone number not found');
            return back();
        }
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();


        $url = "https://msg.elitbuzz-bd.com/smsapi";
        $data = [
            "api_key" => "C200795560afdc9116bd26.38126411",
            "contacts" => $request->phone,
            "type" => 'text',
            "senderid" => "8809612436177",
            "msg" => "Dear $customer_info->name!\r\nYour forgot password verify OTP is $customer_info->forgot \r\nThank you for using Marvel Fashion BD"
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        session::put('verify_phone', $request->phone);
        Toastr::success('Your account register successfully');
        return redirect()->route('customer.forgot.reset');
    }

    public function forgot_resend(Request $request)
    {
        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();
        $customer_info->forgot = rand(1111, 9999);
        $customer_info->save();

        $url = "https://msg.elitbuzz-bd.com/smsapi";
        $data = [
            "api_key" => "C200795560afdc9116bd26.38126411",
            "contacts" => $customer_info->phone,
            "type" => 'text',
            "senderid" => "8809612436177",
            "msg" => "Dear $customer_info->name!\r\nYour forgot password verify OTP is $customer_info->forgot \r\nThank you for using Marvel Fashion BD"
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        Toastr::success('Success', 'Resend code send successfully');
        return redirect()->back();
    }
    public function forgot_reset()
    {
        if (!Session::get('verify_phone')) {
            Toastr::error('Something wrong please try again');
            return redirect()->route('customer.forgot.password');
        }
        ;
        return view('frontEnd.layouts.customer.forgot_reset');
    }
    public function forgot_store(Request $request)
    {

        $customer_info = Customer::where('phone', session::get('verify_phone'))->first();

        if ($customer_info->forgot != $request->otp) {
            Toastr::error('Success', 'Your OTP not match');
            return redirect()->back();
        }

        $customer_info->forgot = 1;
        $customer_info->password = bcrypt($request->password);
        $customer_info->save();
        if (Auth::guard('customer')->attempt(['phone' => $customer_info->phone, 'password' => $request->password])) {
            Session::forget('verify_phone');
            Toastr::success('You are login successfully', 'success!');
            return redirect()->intended('customer/account');
        }
    }
    public function account()
    {
        return view('frontEnd.layouts.customer.account');
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        Toastr::success('You are logout successfully', 'success!');
        return redirect()->route('customer.login');
    }
    public function checkout()
    {
        $shippingcharge = ShippingCharge::where('status', 1)->get();
        $select_charge = ShippingCharge::where('status', 1)->first();
        Session::put('shipping', $select_charge->amount);
        return view('frontEnd.layouts.customer.checkout', compact('shippingcharge'));
    }
    public function order_save(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'area' => 'required',
        ]);
        if (Cart::instance('shopping')->count() <= 0) {
            Toastr::error('Your shopping empty', 'Failed!');
            return redirect()->back();
        }

        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal = str_replace(',', '', $subtotal);
        $subtotal = str_replace('.00', '', $subtotal);
        $discount = Session::get('discount');
        if (Cart::instance('shopping')->count() > 1) {
            $shippingAmount = 0;
        } else {
            $shippingfee = ShippingCharge::find($request->area);
            $shippingAmount = $shippingfee->amount;
        }

        if (Auth::guard('customer')->user()) {
            $customer_id = Auth::guard('customer')->user()->id;
        } else {
            $exits_customer = Customer::where('phone', $request->phone)->select('phone', 'id')->first();
            if ($exits_customer) {
                $customer_id = $exits_customer->id;
            }
            // $password = rand(111111,999999);
            $store = new Customer();
            $store->name = $request->name;
            $store->slug = $request->name;
            $store->phone = $request->phone;
            $store->password = bcrypt($request->phone);
            $store->verify = 1;
            $store->status = 'active';
            $store->save();
            $customer_id = $store->id;


            $url = "https://msg.elitbuzz-bd.com/smsapi";
            $data = [
                "api_key" => "C200795560afdc9116bd26.38126411",
                "type" => "Text",
                "contacts" => '880' . $request->phone,
                "senderid" => "8809612436177",
                "msg" => "Dear $request->name! \r\nYour order has been successfully submitted, \r\nThank you for using Marvel Fashion BD. Here is your password for next time login. Your password is $request->phone. Keep the message for future confusion.",
            ];
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $response = curl_exec($ch);
            curl_close($ch);


        }

        // order data save
        $order = new Order();
        $order->invoice_id = rand(11111, 99999);
        $order->amount = ($subtotal + $shippingAmount) - $discount;
        $order->discount = $discount ? $discount : 0;
        $order->shipping_charge = $shippingAmount;
        $order->customer_id = $customer_id;
        $order->order_status = 1;
        $order->note = $request->note;
        $order->save();

        // shipping data save
        $shipping = new Shipping();
        $shipping->order_id = $order->id;
        $shipping->customer_id = $customer_id;
        $shipping->name = $request->name;
        $shipping->phone = $request->phone;
        $shipping->address = $request->address;
        $shipping->area = $shippingfee->name ?? 'Free Delivery';
        $shipping->note = $request->note;
        $shipping->save();

        // payment data save
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->customer_id = $customer_id;
        $payment->payment_method = 'Cash On Delivery';
        $payment->amount = $order->amount;
        $payment->payment_status = 'pending';
        $payment->save();

        // order details data save
        foreach (Cart::instance('shopping')->content() as $cart) {
            $order_details = new OrderDetails();
            $order_details->order_id = $order->id;
            $order_details->product_id = $cart->id;
            $order_details->product_name = $cart->name;
            $order_details->purchase_price = $cart->options->purchase_price;
            $order_details->product_size = $cart->options->product_size;
            $order_details->product_color = $cart->options->product_color;
            $order_details->sale_price = $cart->price;
            $order_details->qty = $cart->qty;
            $order_details->save();
        }
        Cart::instance('shopping')->destroy();
        $url = "https://msg.elitbuzz-bd.com/smsapi";
        $data = [
            "api_key" => "C200795560afdc9116bd26.38126411",
            "type" => "text",
            "contacts" => '88' . $request->phone,
            "senderid" => "8809612436177",
            "msg" => "Dear $request->name! \r\nYour order invoice is ($order->invoice_id) successfully placed , \r\nThank you for using Marvel Fashion BD.",
        ];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);


        Session::put('purchase_event', 1);
        Toastr::success('Thanks, Your order place successfully', 'Success!');
        return redirect('customer/order-success/' . $order->id);
    }

    public function orders()
    {
        $orders = Order::where('customer_id', Auth::guard('customer')->user()->id)->with('status')->latest()->get();
        return view('frontEnd.layouts.customer.orders', compact('orders'));
    }
    public function order_success($id)
    {
        $order = Order::where('id', $id)->firstOrFail();
        return view('frontEnd.layouts.customer.order_success', compact('order'));
    }
    public function invoice(Request $request)
    {
        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->with('orderdetails', 'payment', 'shipping', 'customer')->firstOrFail();
        return view('frontEnd.layouts.customer.invoice', compact('order'));
    }
    public function order_note(Request $request)
    {
        $order = Order::where(['id' => $request->id, 'customer_id' => Auth::guard('customer')->user()->id])->firstOrFail();
        return view('frontEnd.layouts.customer.order_note', compact('order'));
    }
    public function profile_edit(Request $request)
    {
        $profile_edit = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();
        $districts = District::distinct()->select('district')->get();
        $areas = District::where(['district' => $profile_edit->district])->select('area_name', 'id')->get();
        return view('frontEnd.layouts.customer.profile_edit', compact('profile_edit', 'districts', 'areas'));
    }
    public function profile_update(Request $request)
    {
        $update_data = Customer::where(['id' => Auth::guard('customer')->user()->id])->firstOrFail();

        $image = $request->file('image');
        if ($image) {
            // image with intervention
            $name = time() . '-' . $image->getClientOriginalName();
            $name = preg_replace('"\.(jpg|jpeg|png|webp)$"', '.webp', $name);
            $name = strtolower(Str::slug($name));
            $uploadpath = 'public/uploads/category/';
            $imageUrl = $uploadpath . $name;
            $img = Image::make($image->getRealPath());
            $img->encode('webp', 90);
            $width = 120;
            $height = 120;
            $img->resize($width, $height);
            $img->save($imageUrl);
        } else {
            $imageUrl = $update_data->image;
        }

        $update_data->name = $request->name;
        $update_data->phone = $request->phone;
        $update_data->email = $request->email;
        $update_data->address = $request->address;
        $update_data->district = $request->district;
        $update_data->area = $request->area;
        $update_data->image = $imageUrl;
        $update_data->save();

        Toastr::success('Your profile update successfully', 'Success!');
        return redirect()->route('customer.account');
    }
    public function change_pass()
    {
        return view('frontEnd.layouts.customer.change_password');
    }

    public function password_update(Request $request)
    {
        $this->validate($request, [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required_with:new_password|same:new_password|'
        ]);

        $customer = Customer::find(Auth::guard('customer')->user()->id);
        $hashPass = $customer->password;

        if (Hash::check($request->old_password, $hashPass)) {

            $customer->fill([
                'password' => Hash::make($request->new_password)
            ])->save();

            Toastr::success('Success', 'Password changed successfully!');
            return redirect()->route('customer.account');
        } else {
            Toastr::error('Failed', 'Old password not match!');
            return redirect()->back();
        }
    }

    public function order_track()
    {
        return view('frontEnd.layouts.customer.order_track');
    }
    public function wishlist()
    {
        $data = Cart::instance('wishlist')->content();
        return view('frontEnd.layouts.customer.wishlist', compact('data'));
    }
    public function compare()
    {
        $data = Cart::instance('compare')->content();
        return view('frontEnd.layouts.customer.compare', compact('data'));
    }

    public function order_track_result(Request $request)
    {
        $order = DB::table('orders')
            ->join('shippings', 'orders.id', '=', 'shippings.order_id')
            ->where(['shippings.phone' => $request->phone, 'orders.invoice_id' => $request->invoice_id])
            ->first();
        return view('frontEnd.layouts.customer.tracking_result', compact('order'));
    }
}
