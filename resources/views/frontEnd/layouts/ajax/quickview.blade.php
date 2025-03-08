<div class="modal-view quick-product">
	<button class="close-modal">x</button>
	<div class="quick-product-content">
		<section class="product-section">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="details_slider owl-carousel">
                            @foreach($details->images as $value)
                            <div class="dimage_item">
                                <img src="{{asset($value->image)}}" />
                            </div>
                            @endforeach
                        </div>
                        <div class="indicator_thumb @if($details->images->count() > 4) thumb_slider owl-carousel @endif">
                            @foreach($details->images as $key=>$image)
                            <div class="indicator-item" data-id="{{$key}}">
                                <img src="{{asset($image->image)}}"/>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="product">
                            <div class="product-cart">
                                <p class="name">{{$details->name}}</p>
                                <p class="details-price">
                                    @if($details->old_price)
                                    <del>৳{{$details->old_price}}</del>
                                    @endif
                                    ৳{{$details->new_price}}
                                </p>
                                <div class="pro_short_description">
                                   {!! $details->short_description !!} ...<a href="#pro_details">Read More</a>
                                </div>
                                <form action="{{route('dcart.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$details->id}}" />
                                    <div class="row">
                                        <div class="qty-cart col-sm-5">
                                            <div class="quantity">
                                                <span class="minus">-</span>
                                                <input type="text" name="qty" value="1" />
                                                <span class="plus">+</span>
                                            </div>
                                        </div>
                                         @if($details->procolors->count() > 0)
                                          <div class="pro-color" style="width: 100%;">
                                            <div class="color_inner">
                                              <p>Color - </p>
                                              <div class="size-container">
                                                <div class="selector">
                                                  @foreach($details->procolors as $procolor)
                                                  <div class="selector-item">
                                                    <input type="radio" id="fc-option{{$procolor->id}}" value="{{ $procolor->color ? $procolor->color->color : '' }}" name="product_color" class="selector-item_radio emptyalert" />
                                                    <label for="fc-option{{$procolor->id}}" style="background-color: {{ $procolor->color ? $procolor->color->color : '' }}" class="selector-item_label">
                                                      <span>
                                                        <img src="{{ asset('public/frontEnd/images') }}/check-icon.svg" alt="Checked Icon" />
                                                      </span>
                                                    </label>
                                                  </div>
                                                  @endforeach
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          @endif 
                                        @if($details->prosizes->count() > 0)
                                          <div class="pro-size " style="width: 100%;">
                                            <div class="size_inner">
                                                @php
                                                $selectedSize = App\Models\Size::where('id', request()->input('size'))->first();
                                                @endphp
                                              <p>Size  - <span id="sizeText" data-value="{{ $selectedSize ? $selectedSize->sizeName : '' }}" class="attibute-name">{{ $selectedSize ? $selectedSize->sizeName : '' }}</span></p>

                                              <div class="size-container">
                                                <div class="selector">
                                                  @foreach($details->prosizes as $prosize)
                                                  <div class="selector-item">
                                                    <input type="radio" id="f-option{{$prosize->id}}" value="{{ $prosize->size ? $prosize->size->sizeName : '' }}" name="product_size" class="selector-item_radio emptyalert"  @if (request()->input('size') == $prosize->size_id) checked  @endif />
                                                    <label for="f-option{{$prosize->id}}" class="selector-item_label">{{ $prosize->size ? $prosize->size->sizeName : '' }}</label>
                                                  </div>
                                                  @endforeach
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                          @endif
                                        <div class=" d-flex single_product col-sm-12">
                                            <input type="submit" id="submitButton" disabled class="btn px-4 add_cart_btn" name="add_cart" value="Order Now">
                                        </div>
                                    </div>
                                </form>
                                <div class="mt-md-2 mt-2" >
                                    <h4 class="font-weight-bold">
                                        <a class="btn btn-success w-100 call_now_btn" href="tel:{{$contact->hotline}}">
                                            <i class="fa fa-phone-square"></i>
                                            {{$contact->hotline}}
                                        </a>
                                    </h4>
                                </div>
                                <div class="col-12 mt-3 delivery_details">
                                    <table class="table">
                                        <tbody>                                    
                                            <tr>
                                                <td class="potro_font">
                                                   Category: {{ $details->category->name }}
                                                </td>                                        
                                            </tr>
                                            <tr>
                                                <td class="potro_font">
                                                   Brand: {{ $details->brand ? $details->brand->name : '' }}
                                                </td>                                        
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
        
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </section>
	</div>
</div>
<script src="{{asset('public/frontEnd/js/jquery-3.6.3.min.js')}}"></script>
<script>
	$('.close-modal').on('click',function(){
        $("#custom-modal").hide();
        $("#page-overlay").hide();
     });
</script>
<script src="{{asset('public/frontEnd/js/owl.carousel.min.js')}}"></script>
<script>    
    $(document).ready(function () {
        $(".details_slider").owlCarousel({
            margin: 15,
            items: 1,
            loop: true,
            dots: false,
            nav: true,
            autoplay: false,
        });
        $(".indicator-item").on("click",function () {
             var slideIndex = $(this).data('id');
            $('.details_slider').trigger('to.owl.carousel', slideIndex);
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".thumb_slider").owlCarousel({
            margin: 15,
            items: 5,
            loop: true,
            dots: false,
            nav: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
        });
    });
</script>
<script>
    $(document).ready(function () {
        $(".related_slider").owlCarousel({
            margin: 10,
            items: 1,
            loop: true,
            dots: true,
            nav:true,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                    nav: true
                },
                600: {
                    items: 3,
                    nav: false
                },
                1000: {
                    items: 4,
                    nav: true,
                    loop: false
                }
            }
        });
        // $('.owl-nav').remove();
    });
</script>
<script>
    $(document).ready(function () {
        $(".minus").click(function () {
            var $input = $(this).parent().find("input");
            var count = parseInt($input.val()) - 1;
            count = count < 1 ? 1 : count;
            $input.val(count);
            $input.change();
            return false;
        });
        $(".plus").click(function () {
            var $input = $(this).parent().find("input");
            $input.val(parseInt($input.val()) + 1);
            $input.change();
            return false;
        });
    });
</script>
<script>
        function activateSize(element) {
            // Get the parent container of the hovered <a> element
            var container = element.closest('.product__size_selling');
            // Remove the 'active' class from all <a> elements within the container
            container.querySelectorAll('a').forEach(function(item) {
                item.classList.remove('active');
            });
            // Add the 'active' class to the hovered <a> element
            element.classList.add('active');

            var productcontainer = $(element).closest('.product_item');
            productcontainer.find('a.product-href-link').each(function() {
                var currentHref = $(this).attr("href");
                var dataValue = $(this).data('value');
                var elementSize = $(element).data('size');
                // Check if the href already contains a query parameter
                if (currentHref.includes('?size=')) {
                    // Replace the existing query parameter value
                    var newHref = currentHref.replace(/\?size=[^&]*/, '?size=' + elementSize);
                } else {
                    // If no query parameter exists, add it
                    var newHref = currentHref + '?size=' + elementSize;
                }

                // Update the href attribute
                $(this).attr("href", newHref);
             
            });

        }
    </script>
    <script>
$(document).ready(function() {
    // Function to check if any radio button is checked
    function checkRadioButtons() {
        const isChecked = $('input[name="product_size"]:checked').length > 0;
        $('#submitButton').prop('disabled', !isChecked);
    }

    // Attach the event listener to all radio buttons
    $('input[name="product_size"]').on('change', function() {
        checkRadioButtons();
    });

    // Initial check when the page loads (in case one is already checked)
    checkRadioButtons();
});
</script>