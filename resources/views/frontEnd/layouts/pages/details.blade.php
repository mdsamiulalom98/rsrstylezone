@extends('frontEnd.layouts.master') 
@section('title',$details->name) 
@push('seo')
<meta name="app-url" content="{{route('product',$details->slug)}}" />
<meta name="robots" content="index, follow" />
<meta name="description" content="{{ $details->meta_description}}" />
<meta name="keywords" content="{{ $details->slug }}" />

<!-- Twitter Card data -->
<meta name="twitter:card" content="product" />
<meta name="twitter:site" content="{{$details->name}}" />
<meta name="twitter:title" content="{{$details->name}}" />
<meta name="twitter:description" content="{{ $details->meta_description}}" />
<meta name="twitter:creator" content="rsrstylezone.xyz" />
<meta property="og:url" content="{{route('product',$details->slug)}}" />
<meta name="twitter:image" content="{{asset($details->image->image)}}" />

<!-- Open Graph data -->
<meta property="og:title" content="{{$details->name}}" />
<meta property="og:type" content="product" />
<meta property="og:url" content="{{route('product',$details->slug)}}" />
<meta property="og:image" content="{{asset($details->image->image)}}" />
<meta property="og:description" content="{{ $details->meta_description}}" />
<meta property="og:site_name" content="{{$details->name}}" />
@endpush 
@section('content')
<section class="details_bread">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="breadcrumb">
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><span>/</span></li>
                        <li><a href="{{ url('/category/' . $details->category->slug) }}">{{ $details->category->name }}</a></li>
                        @if ($details->subcategory)
                        <li><span>/</span></li>
                        <li><a href="#">{{ $details->subcategory ? $details->subcategory->subcategoryName : '' }}</a></li>
                        @endif
                        @if ($details->childcategory)                            
                        <li><span>/</span></li>
                        <li><a href="#">{{ $details->childcategory->childcategoryName }}</a></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="main-details-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
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
                                    @php
                                        preg_match("/(?:\/|v=)([a-zA-Z0-9_-]{11})/", $details->pro_video, $matches);
                                        $videoID = $matches[1] ?? '';
                                    @endphp
                                    @if($details->pro_video)
                                    <div class="dimage_item">
                                        <div class="item-video">
                                            <a class="owl-video" href="https://www.youtube.com/watch?v={{ $videoID }}"></a>
                                            @if($videoID)
                                                <img class="owl-lazy" data-src="https://img.youtube.com/vi/{{ $videoID }}/hqdefault.jpg" alt="Video Thumbnail" />
                                            @endif
                                        </div>

                                    </div>
                                    @endif                                    
                                </div>
                                <div class="indicator_thumb @if($details->images->count() > 4) thumb_slider owl-carousel @endif">
                                    @foreach($details->images as $key=>$image)
                                    <div class="indicator-item" data-id="{{$key}}">
                                        <img src="{{asset($image->image)}}"/>
                                    </div>
                                    @endforeach

                                    @if($details->pro_video)
                                     <div class="indicator-item" data-id="{{$details->images->count()}}"><img src="{{ asset('public/frontEnd/images/owl.video.play.png') }}" /></a></div>
                                    @endif


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
                                        <form action="{{route('dcart.store')}}" method="POST" name="formName">
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
                                                 @if($productcolors->count() > 0)
                                                  <div class="pro-color" style="width: 100%;">
                                                    <div class="color_inner">
                                                      <p>Color - </p>
                                                      <div class="size-container">
                                                        <div class="selector">
                                                          @foreach($productcolors as $procolor)
                                                          <div class="selector-item flex-column">
                                                            <input type="radio" id="fc-option{{$procolor->id}}" value="{{ $procolor->color ? $procolor->color->color : '' }}" name="product_color" class="selector-item_radio emptyalert"  />
                                                            <label data-color="{{ $procolor->color ? $procolor->color->colorName : '' }}" for="fc-option{{$procolor->id}}" style="background-color: {{ $procolor->color ? $procolor->color->color : '' }}" class="selector-item_label">
                                                              <span>
                                                                <img src="{{ asset('public/frontEnd/images') }}/check-icon.svg" alt="Checked Icon" />
                                                              </span>
                                                            </label>
                                                            <h3>{{ $procolor->color ? $procolor->color->colorName : '' }}</h3>
                                                          </div>
                                                          @endforeach
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  @endif 
                                                @if($productsizes->count() > 0)
                                                <div class="pro-size" style="width: 100%;">
                                                    <div class="size_inner">
                                                        @php $selectedSize = App\Models\Size::where('id', request()->input('size'))->first(); @endphp
                                                        <p>Size - <span id="sizeText" data-value="{{ $selectedSize ? $selectedSize->sizeName : '' }}" class="attibute-name"></span></p>
                                                        <div class="size-container">
                                                            <div class="selector">
                                                                @foreach($productsizes as $prosize)
                                                                <div class="selector-item">
                                                                    <input type="radio" id="f-option{{$prosize->id}}" value="{{ $prosize->size ? $prosize->size->sizeName : '' }}" name="product_size" class="selector-item_radio emptyalert" required @if (request()->input('size') ==$prosize->size_id) checked @endif />
                                                                    <label for="f-option{{$prosize->id}}" class="selector-item_label" data-value="{{ $prosize->size->sizeName }}">{{ $prosize->size ? $prosize->size->sizeName : '' }}</label>
                                                                </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif

                                                <div class=" d-flex single_product col-sm-6">
                                                    <input type="submit" class="btn px-4 add_cart_btn" id="submitButton" disabled onclick="return sendSuccess()" name="add_cart" value="Order Now">
                                                </div>
                                            

                                        <!-- Button trigger modal -->
                                                <div class="col-sm-6">
                                                    <button type="button" class="size_btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    Product Size
                                                   </button>
                                                </div>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                    <div class="modal-content">
                                                      <div class="modal-header">
                                                        <h5>Product Size</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                      </div>
                                                      <div class="modal-body">
                                                        <div class="size_chart">
                                                          <img src="{{asset($details->size_chart)}}" alt="">
                                                        </div>
                                                      </div>
                                                     
                                                    </div>
                                                  </div>
                                                </div>
                                            </div>
                                        </form>
                                        <div class="mt-md-2 mt-2" >
                                            <h4 class="font-weight-bold">
                                                <a class="btn btn-success w-100 " href="tel:{{$contact->hotline}}">
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

                <div id="pro_details" class="description">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active potro_font" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab">Product Description</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link  potro_font" id="review-tab" data-bs-toggle="tab" data-bs-target="#review" type="button" role="tab">Review</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link  potro_font" id="youtube-tab" data-bs-toggle="tab" data-bs-target="#youtube" type="button" role="tab">Youtube Video</button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                                        <div class="tab-description">
                                            {!! $details->description !!}
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="review" role="tabpanel">
                                        <div class="tab-review">
                                            <div class="details-reviews-wrapper">
                                                    <div class="customer-review">
                                                      <div class="row">
                                                        @foreach($productreviews as $key=>$review)
                                                          <div class="col-sm-4 col-6">
                                                              <div class="review-card">
                                                                  <p class="reviewer_name"><i data-feather="message-square"></i> {{$review->name}}</p>
                                                                  <p class="review_data">{{$review->created_at->format('d-m-Y')}}</p>
                                                                  <p class="review_star">{!! str_repeat('<i class="fa-solid fa-star"></i>', $review->ratting) !!}</p>
                                                                  <p class="review_content">{{$review->review}}</p>
                                                              </div>
                                                          </div>
                                                        @endforeach
                                                      </div>
                                                  </div>
                                            </div>
                                            @if(Auth::guard('customer')->user())
                                            
                                          <form action="{{ route('customer.review') }}" id="review-form" method="POST">
                                            @csrf
                                             <input type="hidden" name="product_id" value="{{ $details->id }}" />
                                            <div class="fz-12 mb-2">
                                                <div class="rating">
                                                    <label title="Excelent">
                                                        ☆
                                                        <input required="" type="radio" name="ratting" value="5" />
                                                    </label>
                                                    <label title="Best">
                                                        ☆
                                                        <input required="" type="radio" name="ratting" value="4" />
                                                    </label>
                                                    <label title="Better">
                                                        ☆
                                                        <input required="" type="radio" name="ratting" value="3" />
                                                    </label>
                                                    <label title="Very Good">
                                                        ☆
                                                        <input required="" type="radio" name="ratting" value="2" />
                                                    </label>
                                                    <label title="Good">
                                                        ☆
                                                        <input required="" type="radio" name="ratting" value="1" />
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label">Message:</label>
                                                <textarea required="" class="form-control radius-lg" name="review" id="message-text"></textarea>
                                                <span id="validation-message" style="color: red;"></span>
                                            </div>
                                            <div class="mt-3">
                                                <button type="submit" class="details-review-btn btn btn-success text-white">Submit</button>
                                            </div>
                                        </form>

                                        @else
                                        <a class="details-login-button" href="{{route('customer.login') }}">Your Review </a>
                                        @endif

                                        </div>
                                    </div>
                                    <div class="tab-pane" id="youtube" role="tabpanel">
                                        <div class="tab-youtube">
                                            @if($details->youtube_link)
                                            <iframe width="560" height="315" src="https://www.youtube.com/embed/{{ $details->youtube_link }}" frameborder="0" allowfullscreen></iframe>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="related-product-section">
                    <div class="container">
                        <div class="row">
                            <div class="related-title">
                                <h5 class="potro_font">Related Product</h5>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                 <div class="product_inner owl-carousel related_slider">
                                    @foreach($products as $key=>$value)
                                        <div class="product_item wist_item wow zoomIn" data-wow-duration="1.5s" data-wow-delay="0.5s">
                                            <div class="product_item_inner">
                                                @if($value->old_price)
                                                <div class="discount">@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp -{{number_format($discount,0)}}%
                                                </div>
                                                @endif
                                                <div class="pro_img">
                                                    @foreach($value->twoimages as $index =>$image)
                                                    @if($index < 2)
                                                    <a 
                                                    @if($value->twoimages->count() > 1)
                                                    @if($index == 0) 
                                                    class="default__img product-href-link" 
                                                    @else
                                                    class="hover__img product-href-link" 
                                                    @endif
                                                    @else 
                                                    class="product-href-link"
                                                    @endif 
                                                     href="{{ route('product',$value->slug) }}">
                                                        <img src="{{ asset($image->image) }}" alt="{{$value->name}}" />
                                                    </a>
                                                    @endif
                                                    @endforeach 
                                                    <div class="quick_view_btn">
                                                        <button data-id="{{$value->id}}" class="hover-zoom quick_view" title="Wishlist"><i class="fa-solid fa-magnifying-glass"></i></button>
                                                        <button type="button" class="cart_store" data-id="{{$value->id}}"><i class="fas fa-shopping-basket"></i></button>
                                                    </div>
                                                </div>
                                                <div class="action_two">
                                                    <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i></button>
                                                    <!-- <button data-id="{{$value->id}}" class="hover-zoom compare_store" title="Compare"><i class="fa-solid fa-sync"></i></button> -->
                                                </div>
                                                <div class="product__size_selling">
                                                    @foreach($value->prosizes as $sizes)                                
                                                    <a class="size__item" data-size="{{ $sizes->size_id}}" onmouseover="activateSize(this)" href="{{ route('product',$value->slug) }}?size={{ $sizes->size_id }}">{{ $sizes->size ? $sizes->size->sizeName : '' }}</a>
                                                    @endforeach
                                                </div>
                                                <div class="pro_des">
                                                    <div class="pro_name">
                                                        <a class="product-href-link" href="{{ route('product',$value->slug) }}">{{Str::limit($value->name,60)}}</a>
                                                    </div>
                                                    <div class="pro_price">
                                                        <p>
                                                            @if($value->old_price)
                                                            <del>৳ {{ $value->old_price}}</del>
                                                            @endif
                                                            ৳ {{ $value->new_price}} @if($value->old_price) @endif
                                                        </p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
    </div>
</div>
@endsection 

@push('script')
<script src="{{asset('public/frontEnd/js/owl.carousel.min.js')}}"></script>
<script>    
    $(".item-video").on("click", function() {
        $('.owl-lazy').hide();
    });
    $(document).ready(function () {
        $(".details_slider").owlCarousel({
            margin: 15,
            items: 1,
            loop: true,
            dots: false,
        video: true,
        lazyLoad: true,  // Lazy load চালু রাখুন
        lazyLoadEager: 1, // প্রথম ১টি ভিডিও আগে লোড হবে
            nav: true,
            autoplay: false,
        });
        $(".indicator-item").on("click",function () {
             var slideIndex = $(this).data('id');
            $('.details_slider').trigger('to.owl.carousel', slideIndex);
        });

            // Hide thumbnail when video starts playing
    $(".item-video").on("click", function() {
        $('.owl-lazy').fadeOut(300);
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
    $(document).ready(function() {
        // Add a click event handler to all labels with the class 'size-label'
        // $('.selector-item_label').on('mouseover', function() {
        //     // Remove the 'active' class from all labels
        //     // $('.selector-item_label').removeClass('active');

        //     // Add the 'active' class to the clicked label
        //     // $(this).addClass('active');

        //     // Check the corresponding radio button
        //     // $(this).find('input[type="radio"]').prop('checked', true);
        //     var dataValue = $(this).data('value');
        //     $('#sizeText').text(dataValue);
        // });
        var checkedLabel = $('.selector-item input:checked').siblings('.selector-item_label').text();
        var defaultValue = checkedLabel || $('#sizeText').data('value');
        $('#sizeText').text(defaultValue);
        
        $('.selector-item_label').on('mouseover', function() {
            var dataValue = $(this).data('value');
            $('#sizeText').text(dataValue);
        }).on('mouseout', function() {
            // Set the default value when the mouse is removed
            var checkedLabel = $('.selector-item input:checked').siblings('.selector-item_label').text();
            var defaultValue = checkedLabel || $('#sizeText').data('value');
            $('#sizeText').text(defaultValue);
        });

        


    });
</script>
<script>
   
</script>
<script>
    $(document).ready(function () {
        $(".rating label").click(function () {
            $(".rating label").removeClass("active");
            $(this).addClass("active");
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
<script>
    function sendSuccess() {
        // size validation
        size = document.forms["formName"]["product_size"].value;
        if (size != "") {
            // access
        } else {
            toastr.warning("Please select size");
            return false;
        }
        color = document.forms["formName"]["product_color"].value;
        if (color != "") {
            // access
        } else {
            toastr.error("Please select color");
            return false;
        }
    }
    
    
    
// Data Layer
     
// Function to update item_variant
function viewItemDataLayer() {
  var selectedColor = $('input[name="product_color"]:checked').val() || '';
  var selectedSize = $('input[name="product_size"]:checked').val() || '';

  // Update the gtag event
  
       dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
         dataLayer.push({
            event    : "view_item",
            visitorIp: "{{ request()->ip() }}",
            ecommerce: {
                currency: "BDT",
                value: {{$details->new_price}},
                items: [{
                    item_id       : {{$details->id}},
                    item_name     : "{{$details->name}}", // Name or ID is required.
                    price         : "{{$details->new_price}}",
                    discount      : "{{$details->old_price>$details->new_price? $details->old_price - $details->new_price:'' }}",
                    item_brand    : "{{$details->brand->name ?? ""}}",
                    item_category : "{{$details->category->name ?? ""}}",
                    item_category2: "{{$details->subcategory ? $details->subcategory->subcategoryName:''}}",
                    item_variant: selectedColor + " " + selectedSize,
                    item_list_name: "",  // If associated with a list selection.
                    item_list_id  : "",  // If associated with a list selection.
                    index         : 0,  // If associated with a list selection.
                    quantity      : {{$details->stock}},
                }]
            }
        });

}

// Attach event listeners to color and size elements
$('input[name="product_color"], input[name="product_size"]').on('change', function() {
  viewItemDataLayer();
});

// Initial update on page load
viewItemDataLayer();
    
</script>
@endpush