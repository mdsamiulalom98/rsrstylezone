@extends('frontEnd.layouts.master')
@section('title', 'Customer Checkout')
@push('css')
    <link rel="stylesheet" href="{{ asset('public/frontEnd/css/select2.min.css') }}">
@endpush
@section('content')
    <div class="bread_section">
        <div class="container-fluid">
            <div class="row">
                <div class="breadcrumb_title">
                    <h2>Customer Checkout</h2>
                </div>
            </div>
        </div>
    </div>
    <section class="chheckout-section">
        @php
            $subtotal = Cart::instance('shopping')->subtotal();
            $subtotal = str_replace(',', '', $subtotal);
            $subtotal = str_replace('.00', '', $subtotal);
            if(Cart::instance('shopping')->count() > 1) {
                Session::put('shipping', 0);
            }
            $shipping = Session::get('shipping') ?? 0;
        @endphp
        <div class="container">
            <div class="row">
                <div class="col-sm-5 cus-order-2">
                    <div class="checkout-shipping">
                        <form action="{{ route('customer.ordersave') }}" method="POST" data-parsley-validate="">
                            @csrf
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="potro_font">অর্ডারটি সম্পূর্ণ করতে আপনার তথ্য লিখুন।</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label for="name">আপনার নাম *</label>
                                                <input type="text" id="name"
                                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                                    value="{{ old('name') }}" placeholder="আপনার নাম" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label for="phone">আপনার মোবাইল *</label>
                                                <input type="text" minlength="11" id="number" maxlength="11"
                                                    pattern="0[0-9]+"
                                                    title="please enter number only and 0 must first character"
                                                    title="Please enter an 11-digit number." id="phone"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    value="{{ old('phone') }}"
                                                    placeholder="+৮৮ লিখবেন না, শুধু ১১ সংখ্যার নম্বর লিখুন।" required>
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label for="address">আপনার ঠিকানা *</label>
                                                <input type="address" id="address"
                                                    class="form-control @error('address') is-invalid @enderror"
                                                    placeholder="জেলা, থানা, গ্রাম" name="address"
                                                    value="{{ old('address') }}" required>
                                                @error('address')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label for="area">আপনার এলাকা নির্বাচন করুন *</label>
                                                <select type="area" id="area"
                                                    class="form-control form-select @error('area') is-invalid @enderror" name="area"
                                                    required>

                                                    @foreach ($shippingcharge as $key => $value)
                                                        <option value="{{ $value->id }}">{{ $value->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('area')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-12">
                                            <div class="form-group mb-3">
                                                <label for="note">নোট </label>
                                                <input type="note" id="note"
                                                    class="form-control @error('note') is-invalid @enderror"
                                                    placeholder="আপনার বিশেষ নোট" name="note"
                                                    value="{{ old('note') }}">
                                                @error('note')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- col-end -->
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <button class="order_place" type="submit"> অর্ডার করুন </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- card end -->
                        </form>
                    </div>
                </div>
                <!-- col end -->
                <div class="col-sm-7 cust-order-1">
                    <div class="cart_details table-responsive-sm">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="potro_font"> অর্ডার তথ্য</h5>
                            </div>
                            <div class="card-body cartlist">
                                <table class="cart_table table  text-center mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 20%;text-align: left;">পণ্য</th>
                                            <th style="width: 20%;">মূল্য</th>
                                            <th style="width: 20%;">পরিমাণ</th>
                                            <th style="width: 20%;">মোট</th>
                                            <th style="width: 20%;">ডিলিট</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach (Cart::instance('shopping')->content() as $value)
                                            <tr>
                                                <td class="text-start">
                                                    <a style="font-size: 16px;"
                                                        href="{{ route('product', $value->options->slug) }}"><img
                                                            src="{{ asset($value->options->image) }}" height="30"
                                                            width="30"> {{ Str::limit($value->name, 20) }}</a>
                                                    <p>
                                                        @if ($value->options->product_size)
                                                            <small>Size: {{ $value->options->product_size }}</small>
                                                            @endif @if ($value->options->product_color)
                                                                <small>Color:{{ $value->options->product_color }}</small>
                                                            @endif
                                                    </p>
                                                </td>
                                                <td><span class="alinur"></span>{{ $value->price }} Tk</td>
                                                <td width="15%" class="cart_qty">
                                                    <div class="qty-cart vcart-qty">
                                                        <div class="quantity">
                                                            <button class="minus cart_decrement"
                                                                data-id="{{ $value->rowId }}">-</button>
                                                            <input type="text" value="{{ $value->qty }}" readonly />
                                                            <button class="plus  cart_increment"
                                                                data-id="{{ $value->rowId }}">+</button>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="alinur"></span>{{ $value->price * $value->qty }} Tk</td>
                                                <td>
                                                    <button class="remove-cart cart_remove"
                                                        data-id="{{ $value->rowId }}"><i
                                                            class="fas fa-times text-danger"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tr>
                                        <td colspan="4" class="text-end"><strong>সাবটোটাল :</strong></td>
                                        <td class="text-center"><strong> {{ $subtotal }} Tk</strong></td>
                                    </tr>
                                    <tr class="cart_hide">
                                        <td colspan="4" class="text-end"><strong>ডেলিভারি চার্জ :</strong></td>
                                        <td class="text-center"><strong> {{ $shipping }} Tk</strong></td>
                                    </tr>
                                    <tr class="cart_hide">
                                        <td colspan="4" class="text-end"><strong>মোট :</strong></td>
                                        <td class="text-center"><strong> {{ $subtotal + $shipping }} Tk</strong></td>
                                    </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- col end -->
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script src="{{ asset('public/frontEnd/') }}/js/parsley.min.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/form-validation.init.js"></script>
    <script src="{{ asset('public/frontEnd/') }}/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        $("#area").on("change", function() {
            var id = $(this).val();
            $.ajax({
                type: "GET",
                data: {
                    id: id
                },
                url: "{{ route('shipping.charge') }}",
                dataType: "html",
                success: function(response) {
                    $('.cartlist').html(response);
                }
            });
        });


        // Data Layer Purchase


        @php
            $i = 0;
        @endphp


        dataLayer.push({
            ecommerce: null
        });
        dataLayer.push({
            event: "begin_checkout",
            ecommerce: {
                currency: "BDT",
                value: {{ $subtotal }},
                tax: 0.00,
                shipping: {{ $shipping }},
                items: [
                    @foreach (Cart::instance('shopping')->content() as $key => $value)
                        @php
                            $i++;
                        @endphp {
                            item_id: "{{ $value->id }}",
                            item_name: "{{ $value->name ?? '' }}",
                            index: {{ $i }},
                            item_variant: "{{ isset($value->options) ? $value->options->product_size ?? '' : '' }} {{ isset($value->options) ? $value->options->product_color ?? '' : '' }}",
                            price: {{ $value->price }},
                            quantity: {{ $value->qty }}
                        },
                    @endforeach
                ]
            }
        });
    </script>
@endpush
