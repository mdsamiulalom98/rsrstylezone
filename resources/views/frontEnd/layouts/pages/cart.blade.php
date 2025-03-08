@extends('frontEnd.layouts.master')
@section('title','Shopping Cart')
@section('content')
<div class="bread_section">
    <div class="container">
        <div class="row">
            <div class="breadcrumb_title">
                <h2>Shopping Cart</h2>
            </div>
        </div>
    </div>
</div>
<section class="vcart-section">
    @php
        $subtotal = Cart::instance('shopping')->subtotal();
        $subtotal=str_replace(',','',$subtotal);
        $subtotal=str_replace('.00', '',$subtotal);
        view()->share('subtotal',$subtotal);
        $shipping = Session::get('shipping')?Session::get('shipping'):0;
        $discount = Session::get('discount')?Session::get('discount'):0;
    @endphp
    <div class="container-fluid">
        <div class="row" id="cartlist">
            <div class="col-sm-12">
                <div class="vcart-inner">
                    <div class="vcart-content">
                        <div class="cartlist table-responsive">
                            <table class="table text-center mb-0">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;text-align: left;">PRODUCT</th>
                                        <th style="width: 20%;">PRICE</th>
                                        <th style="width: 20%;">QUANTITY</th>
                                        <th style="width: 20%;">TOTAL</th>
                                        <th style="width: 20%;">REMOVE</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach(Cart::instance('shopping')->content() as $value)
                                    <tr>
                                        <td class="text-start">
                                            <a style="font-size: 16px;" href="{{route('product',$value->options->slug)}}"><img src="{{asset($value->options->image)}}" height="30" width="30"> {{Str::limit($value->name,20)}}</a><br>
                                            <p>@if($value->options->product_size) <small>Size: {{$value->options->product_size}}</small> @endif @if($value->options->product_color) <small>Color:{{$value->options->product_color}}</small> @endif</p>
            
                                        </td>
                                        <td><span class="alinur"></span>{{$value->price}} Tk</td>
                                        <td width="15%" class="cart_qty">
                                            <div class="qty-cart vcart-qty">
                                                <div class="quantity">
                                                    <button class="minus cart_decrement"  data-id="{{$value->rowId}}">-</button>
                                                    <input type="text" value="{{$value->qty}}" readonly />
                                                    <button class="plus  cart_increment" data-id="{{$value->rowId}}">+</button>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="alinur"></span>{{$value->price*$value->qty}} Tk</td>
                                        <td>
                                            <button class="remove-cart cart_remove" data-id="{{$value->rowId}}"><i class="fas fa-times text-danger"></i></button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr >
                                        <td colspan="4" class="text-end"><strong>SUBTOTAL :</strong></td>
                                        <td  class="text-center"><strong> {{$subtotal}} Tk</strong></td>
                                    </tr>
                                    <tr class="cart_hide">
                                        <td colspan="4" class="text-end"><strong>SHIPPING :</strong></td>
                                        <td  class="text-center"><strong> {{$shipping}} Tk</strong></td>
                                    </tr>
                                    <tr class="cart_hide">
                                        <td colspan="4" class="text-end"><strong>TOTAL :</strong></td>
                                        <td  class="text-center"><strong> {{$subtotal-$shipping}} Tk</strong></td>
                                    </tr>
                                </tfoot>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="process_to_pay">
                    <a href="{{route('customer.checkout')}}">Process To Payment</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
