@extends('frontEnd.layouts.master') 
@section('title','Welcome to RSR Style Zone') 
@push('seo')
<meta name="app-url" content="" />
<meta name="robots" content="index, follow" />
<meta name="description" content="" />
<meta name="keywords" content="" />

<!-- Twitter Card data -->
<meta name="twitter:card" content="product" />
<meta name="twitter:site" content="" />
<meta name="twitter:title" content="" />
<meta name="twitter:description" content="" />
<meta name="twitter:creator" content="" />
<meta name="twitter:image" content="" />

<!-- Open Graph data -->
<meta property="og:title" content="" />
<meta property="og:type" content="website" />
<meta property="og:url" content="" />
<meta property="og:image" content="" />
<meta property="og:description" content="" />
<meta property="og:site_name" content="" />
<meta property="fb:app_id" content="" />

@endpush
@push('css')
<link rel="stylesheet" href="{{asset('public/frontEnd/css/owl.carousel.min.css')}}" />
<link rel="stylesheet" href="{{asset('public/frontEnd/css/owl.theme.default.min.css')}}" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css" rel="stylesheet" />
@endpush 
@section('content')
<section class="slider-section">
  <div class="containers">
    <div class="main-slider owl-carousel">
        @foreach($sliders as $key=>$value)
        <div class="slider-item ">
            <a href="{{$value->link}}">
                <img src="{{asset($value->image)}}" alt="" />
            </a>
        </div>
         @endforeach
    </div>
   </div> 
</section>
<!-- ============== -->
<section class="about__box">
    <div class="container small-container">
        <div class="middle-banner">
            @foreach($slider_right as $key=>$value)
            <div class="mid-banner-item">
                <div class="box__top">
                    <div class="box_top_img">
                        <a href="{{$value->link}}">
                            <img src="{{asset($value->image)}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="middle-banners">
            @foreach($slider_rights as $key=>$value)
            <div class="mid-banner-item">
                <div class="box__top">
                    <div class="box_top_img">
                        <a href="{{$value->link}}">
                            <img src="{{asset($value->image)}}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<!-- ===========pro========= -->
<section class="product-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="arrival_title">
                    <p>New Arrival</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="arrival_slider">
                    @foreach($newarrival->take(8) as $key=>$value)
                    <div class="product_item wist_item wow zoomIn" data-wow-duration="1.5s" data-wow-delay="0.5s">
                        <div class="product_item_inner">
                            @if($value->old_price)
                            <div class="discount">@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp -{{number_format($discount,0)}}%</div>
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
                                        @endif ৳ {{ $value->new_price}} @if($value->old_price) @endif
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
</section>
<!-- ===========Lather ==pro========= -->

<!-- ==========best selling product=========== -->
<section class="best_selling_product">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="best_sellin_pro">
                    <h3>BEST SELLING</h3>
                    <p>Best selling product nominated by you</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="arrival_slide owl-carousel">
                    @foreach($hotdeal_top as $key=>$value)
                    <div class="product_item wist_item wow zoomIn" data-wow-duration="1.5s" data-wow-delay="0.5s">
                        <div class="product_item_inner">
                            @if($value->old_price)
                            <div class="discount">@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp -{{number_format($discount,0)}}%</div>
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
                                        @endif ৳ {{ $value->new_price}} @if($value->old_price) @endif
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
</section>
<!-- ======== -->
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="best_selling_btn">
                    <a href="{{route('newarrival')}}">Shop All <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ======== -->
<!-- ==========best selling product=========== -->
@foreach ($homeproducts as $homecat)
<section class="best_selling_product">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="best_sellin_p">
                    <h3>{{ $homecat->name }}</h3>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="arrival_slide owl-carousel">
                    @foreach ($homecat->products as $key => $value)
                    <div class="product_item wist_item wow zoomIn" data-wow-duration="1.5s" data-wow-delay="0.5s">
                        <div class="product_item_inner">
                            @if($value->old_price)
                            <div class="discount">@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp -{{number_format($discount,0)}}%</div>
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
                                        @endif ৳ {{ $value->new_price}} @if($value->old_price) @endif
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
</section>
<section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="best_selling_btn">
                    <a href="{{ route('category', $homecat->slug) }}">Shop All <i class="fa-solid fa-angle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>
@endforeach
<!-- ======== -->



<!-- <section class="dack_banner_section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="dark_banner">
                    <div class="banner__text">
                        <h3>Get the best look today</h3>
                        <p>Premium Quality Shoes and Accessories</p>
                    </div>
                    
                    <div class="banner__btn">
                        <div class="shop_dark_btn">
                            <a href="#">Shop Now</a>
                        </div>
                        <div class="about_dark_btn">
                            <a href="#">About</a>
                        </div>
                    </div>
                  </div>
               </div>
            </div>
        </div>
</section> -->
<!-- brand section============ -->
<!-- <section>
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="brand__title">
                    <h2>Our Brand</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="brand__slider owl-carousel">
                    @foreach($brand_items as $key=>$value)
                    <div class="brand_img">
                        <img src="{{asset($value->image)}}" alt="">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section> -->





@endsection 
@push('script')
<script src="{{asset('public/frontEnd/js/owl.carousel.min.js')}}"></script>
<script>
    $(".main-slider").owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        autoplay: true,
        nav: false,
        autoplayHoverPause: false,
        margin: 0,
        mouseDrag: true
    });
</script>
<script>
    $(".mobaile__slider").owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        autoplay: true,
        nav: false,
        autoplayHoverPause: false,
        margin: 0,
        mouseDrag: true
    });
</script>
<script>
    $(document).ready(function () {
        $(".arrival_slide").owlCarousel({
            margin: 10,
            loop: true,
            dots: false,
            nav: true,
            autoplay: true,
            autoplayTimeout: 6000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 4,
                },
            },
        });

        $(".owl-nav").remove();
    });
</script>
<script>
    $(document).ready(function () {
        $(".brand__slider").owlCarousel({
            margin: 10,
            loop: true,
            dots: false,
            nav: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            responsiveClass: true,
            responsive: {
                0: {
                    items: 2,
                },
                600: {
                    items: 3,
                },
                1000: {
                    items: 6,
                },
            },
        });

        $(".owl-nav").remove();
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
    
@endpush
