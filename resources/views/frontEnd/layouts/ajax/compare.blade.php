<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Cart</th>
                <th>Remove</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $value)
            <tr>
                <td><img src="{{asset($value->options->image)}}" alt=""></td>
                <td><a href="{{route('product',$value->options->slug)}}">{{$value->name}}</a></td>
                <td>{{$value->qty}}</td>
                <td>{{$value->price}} ৳</td>
                <td><button data-id="{{$value->id}}" class="wcart-btn cart_store"><i data-feather="shopping-cart"></i></button></td>
                <td><button class="remove-cart compare_remove" data-id="{{$value->rowId}}"><i class="fas fa-times"></i></button></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="{{asset('public/frontEnd/js/jquery-3.6.3.min.js')}}"></script>
<!-- feather icon -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
<script>
  feather.replace()
</script>
<script>
    $('.compare_store').on('click',function(){
    var id = $(this).data('id'); 
    var qty = 1;  
    $("#loading").show();
    if(id){
        $.ajax({
           type:"GET",
           data:{'id':id,'qty':qty?qty:1},
           url:"{{route('compare.store')}}",
           success:function(data){               
            if(data){
                toastr.success('success', 'Product added in compare');
                $("#loading").hide();
                //return compare_count();
            }
           }
        });
     }  
   });

    $('.compare_remove').on('click',function(){
    var id = $(this).data('id');   
    $("#loading").show();
    if(id){
        $.ajax({
           type:"GET",
           data:{'id':id},
           url:"{{route('compare.remove')}}",
           success:function(data){               
            if(data){
                $("#loading").hide();
                //return compare_count();
            }
           }
        });
     }  
   });
    function compare_count(){
        $.ajax({
           type:"GET",
           url:"{{route('compare.count')}}",
           success:function(data){               
            if(data){
                $(".compare-qty").html(data);
            }else{
               $(".compare-qty").empty();
            }
           }
        }); 
   };
</script>
<!-- compare js end -->