<style> 
.cartlist img {
    width: 30px;
    height:30px;
}
.cart_name {
    max-width: 185px;
}
</style>
@php
    $subtotal = Cart::instance('shopping')->subtotal();
    $subtotal=str_replace(',','',$subtotal);
    $subtotal=str_replace('.00', '',$subtotal);
    $shipping = Session::get('shipping')?Session::get('shipping'):0;
    $discount = Session::get('discount')?Session::get('discount'):0;
@endphp
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
                                    @foreach(Cart::instance('shopping')->content() as $value)
                                    <tr>
                                        <td class="text-start">
                                            <a style="font-size: 16px;" href="{{route('product',$value->options->slug)}}"><img src="{{asset($value->options->image)}}" height="30" width="30"> {{Str::limit($value->name,20)}}</a>
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
                                <tr >
                                    <td colspan="4" class="text-end"><strong>সাবটোটাল :</strong></td>
                                    <td  class="text-center"><strong> {{$subtotal}} Tk</strong></td>
                                </tr>
                                <tr class="cart_hide">
                                    <td colspan="4" class="text-end"><strong>ডেলিভারি চার্জ :</strong></td>
                                    <td  class="text-center"><strong> {{$shipping}} Tk</strong></td>
                                </tr>
                                <tr class="cart_hide">
                                    <td colspan="4" class="text-end"><strong>মোট :</strong></td>
                                    <td  class="text-center"><strong> {{$subtotal+$shipping}} Tk</strong></td>
                                </tr>
                            </tfoot>
                            </table>

<script src="{{asset('public/frontEnd/js/jquery-3.6.3.min.js')}}"></script>
<!-- cart js start -->
<script>
    
    $('.cart_remove').on('click',function(){
    var id = $(this).data('id');   
    $("#loading").show();
    if(id){
        $.ajax({
           type:"GET",
           data:{'id':id},
           url:"{{route('cart.remove')}}",
           success:function(data){               
            if(data){
                $(".cartlist").html(data);
                $("#loading").hide();
                 toastr.success('success', 'Product remove from shopping cart');
                return cart_count() + mobile_cart();
            }
           }
        });
     }  
   });

    $('.cart_increment').on('click',function(){
    var id = $(this).data('id');  
    $("#loading").show();
    if(id){
        $.ajax({
          type:"GET",
          data:{'id':id},
          url:"{{route('cart.increment')}}",
          success:function(data){               
            if(data){
                $(".cartlist").html(data);
                $("#loading").hide();
                 toastr.success('success', 'Product increment to shopping cart');
                return cart_count() + mobile_cart();
            }
          }
        });
     }  
  });

    $('.cart_decrement').on('click',function(){
    var id = $(this).data('id');  
    $("#loading").show();
    if(id){
        $.ajax({
          type:"GET",
          data:{'id':id},
          url:"{{route('cart.decrement')}}",
          success:function(data){               
            if(data){
                $(".cartlist").html(data);
                $("#loading").hide();
                 toastr.success('success', 'Product increment from shopping cart');
                return cart_count() + mobile_cart();
            }
          }
        });
     }  
  });

    function cart_count(){
        $.ajax({
           type:"GET",
           url:"{{route('cart.count')}}",
           success:function(data){               
            if(data){
                $("#cart-qty").html(data);
            }else{
               $("#cart-qty").empty();
            }
           }
        }); 
   };
   function mobile_cart() {
        $.ajax({
            type: "GET",
            url: "{{route('mobile.cart.count')}}",
            success: function (data) {
                if (data) {
                    $(".mobilecart-qty").html(data);
                } else {
                    $(".mobilecart-qty").empty();
                }
            },
        });
    }
</script>
<!-- cart js end -->