<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>@yield('title') - {{$generalsetting->name}}</title>
        <!-- App favicon -->

        <link rel="shortcut icon" href="{{asset($generalsetting->favicon)}}" />
        @stack('seo')
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/bootstrap.min.css')}}" />
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/animate.css')}}" />
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/all.min.css')}}" />
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/owl.carousel.min.css')}}" />
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/owl.theme.default.min.css')}}" />
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/mobile-menu.css')}}" />
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/select2.min.css')}}">
        <!-- toastr css -->
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/assets/css/toastr.min.css" />

        <link rel="stylesheet" href="{{asset('public/frontEnd/css/style.css?v=1.0.7')}}" />
        <link rel="stylesheet" href="{{asset('public/frontEnd/css/responsive.css?v=1.0.6')}}" />
       {{-- @foreach($pixels as $pixel)
        <!-- Facebook Pixel Code -->
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
          'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '{{{$pixel->code}}}');
          fbq('track', 'PageView');
        </script>
        <noscript>
          <img height="1" width="1" style="display:none"
               src="https://www.facebook.com/tr?id={{{$pixel->code}}}&ev=PageView&noscript=1"/>
        </noscript>
        <!-- End Facebook Pixel Code -->
        @endforeach --}}
        <!-- Google Tag Manager -->
        <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-K6LVCF6L');</script>
        <!-- End Google Tag Manager -->
    </head>
    <body>
        @php $subtotal = Cart::instance('shopping')->subtotal(); @endphp
        <header>
            <div class="mobile-header sticky">
                <div class="mobile-logo">
                    <div class="menu-bar">
                        <a class="toggle">
                            <i class="fa-solid fa-bars"></i>
                        </a>
                    </div>
                    <div class="menu-logo">
                        <a href="{{route('home')}}"><img src="{{asset($generalsetting->white_logo)}}" alt="" /></a>
                    </div>
                    <div class="menu-bag">
                        <a class="search_toggle"><i class="fas fa-search"></i></a>
                        <a href="{{route('cart.show')}}" class="margin-shopping"><i class="fas fa-shopping-cart"></i> <span class="mobilecart-qty">{{Cart::instance('shopping')->count()}}</span></a>
                    </div>
                </div>
            </div>
            <div class="mobile-menu">
                <div class="mobile-menu-logo">
                    <div class="logo-image">
                        <img src="{{asset($generalsetting->dark_logo)}}" alt="" />
                    </div>
                    <div class="mobile-menu-close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <ul class="first-nav">
                    <li class="menu-category-list">
                        <a class="menu-category-link" href="{{route('newarrival')}}">New Arrival</a>
                    </li>
                    @foreach($menucategories as $scategory)
                    <li class="parent-category">
                        <a href="{{url('category/'.$scategory->slug)}}" class="menu-category-name">{{$scategory->name}}</a>
                        @if($scategory->subcategories->count() > 0)
                        <span class="menu-category-toggle"><i class="fa fa-chevron-down"></i></span>
                        @endif
                        <ul class="second-nav" style="display: none;">
                        @foreach($scategory->subcategories as $subcategory)
                            <li class="parent-subcategory">
                                <a href="{{url('subcategory/'.$subcategory->slug)}}" class="menu-subcategory-name">{{$subcategory->subcategoryName}}</a>
                                @if($subcategory->childcategories->count() > 0)
                                <span class="menu-subcategory-toggle"><i class="fa fa-chevron-down"></i></span>
                                @endif
                                <ul class="third-nav" style="display: none;">
                                    @foreach($subcategory->childcategories as $childcat)
                                    <li class="childcategory"><a href="{{url('childcategory/'.$childcat->slug)}}" class="menu-childcategory-name">{{$childcat->childcategoryName}}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                        @endforeach
                        </ul>
                    </li>
                    @endforeach
                     <li class="parent-category">
                        <a  class="menu-category-name">Discount Product <span>({{$offer_count}})</span></a>
                        <span class="menu-category-toggle"><i class="fa fa-chevron-down"></i></span>
                        <ul class="second-nav" style="display: none;">
                            <li class="parent-subcategory"><a href="{{route('discount','men')}}" class="menu-subcategory-name">Men</a></li>
                            <li class="parent-subcategory"><a href="{{route('discount','women')}}" class="menu-subcategory-name">Women</a></li>
                            <li class="parent-subcategory"><a href="{{route('discount','kids')}}" class="menu-subcategory-name">Kids</a></li>
                        </ul>
                    </li>
                    <li class="menu-category-list">
                        <a class="menu-category-link" href="{{url('/customer/login')}}">Login</a>
                    </li>
                </ul>
                <ul class="mobile-menu-social">
                    @foreach($socialicons as $value)
                    <li class="mobile-social-list">
                        <a class="mobile-social-link" target="_blank" href="{{$value->link}}"><i class="{{$value->icon}}"></i></a>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="main-header">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-2">
                            <div class="main_logo">
                                <a href="{{route('home')}}">
                                    <img src="{{asset($generalsetting->white_logo)}}" alt="">
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <div class="main_menu">
                                <ul>
                                    <!-- <li><a href="{{route('newarrival')}}">New Arrival</a></li> -->
                                    @foreach($menucategories as $scategory)
                                    <li><a href="{{route('category',$scategory->slug)}}">{{$scategory->name}}</a>
                                        @if($scategory->subcategories->count() > 0)
                                        <ul class="sub_menu">
                                            @foreach ($scategory->subcategories as $subcat)
                                            <li>
                                                <a href="{{route('subcategory',$subcat->slug)}}" class="@if($subcat->childcategories->count() > 0) has-childcategory @endif"><img src="{{asset($subcat->image)}}" alt="" class="side_cat_img" />{{ $subcat->subcategoryName }}</a>
                                                <ul class="child_menu">
                                                    @foreach ($subcat->childcategories as $chidcat)
                                                    <li>
                                                        <a href="{{route('childcategory',$chidcat->slug)}}">{{ $chidcat->childcategoryName }}</a>
                                                    </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                   <!--<li><a href="https://marvelfashionbd.com/campaign/eid-offer-2024-aieq6" style="color:#ffff0b;">EID OFFER 2024</a></li>-->
                                    <!-- <li><a class="discount_cart">Discount Product <span>{{$offer_count}}</span></a>
                                        <ul class="sub_menu">
                                            <li><a href="{{route('discount','men')}}">Men</a> </li>
                                            <li><a href="{{route('discount','women')}}">Women</a> </li>
                                            <li><a href="{{route('discount','kids')}}">Kids</a> </li>
                                        </ul>
                                    </li> -->
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="header_right">
                                <ul>
                                    <li><a class="search_toggle"><i class="fas fa-search"></i></a></li>
                                    <li><a href="{{route('customer.wishlist')}}"><i class="far fa-heart"></i> <span class="wishlist-qty">{{Cart::instance('wishlist')->count()}}</span></li>

                                    @if(Auth::guard('customer')->user())
                                    <li><a href="{{route('customer.account')}}"><i class="fas fa-user"></i></a></li>
                                    @else
                                    <li><a href="{{route('customer.login')}}"><i class="fas fa-user"></i></a></li>
                                    @endif
                                     <li class="shopping__cart"><a href="{{route('cart.show')}}" id="cart-qty"><i class="fas fa-shopping-cart"></i> <span>{{Cart::instance('shopping')->count()}}</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <main>
        <!-- header end -->
            @yield('content')
        <!-- content end -->
        </main>
        <footer >
            <div class="footer-top only-desktop">
                <div class="container">
                    <div class="row">
                        {{-- <div class="col-sm-4 mb-3 mb-sm-0">
                            <div class="footer-contact">
                                <li class="title"><a>contact us</a></li>
                                <ul>
                                    <li><i class="fas fa-map-marker-alt"></i> <a>{{$contact->address}}</a></li>
                                    <li><i class="fas fa-map"></i> <a href="{{$contact->maplink}}" target="_blank"> Google Map</a></li>
                                    <li><i class="fas fa-phone"></i> <a href="tel:{{$contact->phone}}">{{$contact->phone}}</a></li>
                                    <li><i class="fas fa-envelope"></i> <a href="mailto:{{$contact->email}}">{{$contact->email}}</a></li>
                                </ul>
                            </div>
                        </div> --}}
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4  class="title"><a>Information</a></h4>
                                <ul >
                                    <li><a href="{{route('contact')}}">Contact Us</a></li>
                                    @foreach($pages as $page)
                                    <li><a href="{{route('page',['slug'=>$page->slug])}}">{{$page->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                         <!-- col end  -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4 class="title"><a>my account</a></h4>
                                <ul >
                                    <li><a href="{{route('customer.account')}}">My Account</a></li>
                                    <li><a href="{{route('customer.orders')}}">My Order</a></li>
                                    <li><a href="{{route('customer.forgot.password')}}">Forgot Password</a></li>
                                </ul>
                            </div>
                        </div>
                         <!-- col end  -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4 class="title"><a>customer services</a></h4>
                                <ul >
                                    <li><a href="{{route('customer.checkout')}}">My Cart</a></li>
                                    <li><a href="{{route('customer.checkout')}}">Checkout</a></li>
                                    <li><a href="{{route('customer.login')}}">Login</a></li>
                                    <li><a href="{{route('customer.register')}}">Register</a></li>
                                </ul>
                            </div>
                        </div>
                         <!-- col end  -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4  class="title"><a>accepted payment</a></h4>
                                <ul>
                                    <li><img class="footer-payment-image" src="{{asset('public/frontEnd/images/payment-logo.png')}}" /></li>
                                </ul>
                                <h4 class="regular-font font-monospace mt-3">
                                    Hotline:
                                    <a class=" call_now_btn" href="tel:{{$contact->hotline}}">
                                        <i class="fa fa-phone-square"></i>
                                        {{$contact->hotline}}
                                    </a>
                                </h4>
                            </div>
                        </div>
                         <!-- col end  -->
                    </div>
                </div>
            </div>

            <div class="footer-top only-mobile">
                <div class="container">
                    <div class="row">
                        {{-- <div class="col-sm-4 mb-3 mb-sm-0">
                            <div class="footer-contact">
                                <li class="title"><a>contact us</a></li>
                                <ul>
                                    <li><i class="fas fa-map-marker-alt"></i> <a>{{$contact->address}}</a></li>
                                    <li><i class="fas fa-map"></i> <a href="{{$contact->maplink}}" target="_blank"> Google Map</a></li>
                                    <li><i class="fas fa-phone"></i> <a href="tel:{{$contact->phone}}">{{$contact->phone}}</a></li>
                                    <li><i class="fas fa-envelope"></i> <a href="mailto:{{$contact->email}}">{{$contact->email}}</a></li>
                                </ul>
                            </div>
                        </div> --}}
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4 id="toggle-info" data-toggle="collapse" data-target="#toggle-example" class="title"><a>Information</a></h4>
                                <ul id="div-info" class="collapse in">
                                    <li><a href="{{route('contact')}}">Contact Us</a></li>
                                    @foreach($pages as $page)
                                    <li><a href="{{route('page',['slug'=>$page->slug])}}">{{$page->name}}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                         <!-- col end  -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4 id="toggle-account" data-toggle="collapse" data-target="#toggle-example" class="title"><a>my account</a></h4>
                                <ul id="div-account" class="collapse in" >
                                    <li><a href="{{route('customer.account')}}">My Account</a></li>
                                    <li><a href="{{route('customer.orders')}}">My Order</a></li>
                                    <li><a href="{{route('customer.forgot.password')}}">Forgot Password</a></li>
                                </ul>
                            </div>
                        </div>
                         <!-- col end  -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4 id="toggle-customer" class="title" data-toggle="collapse" data-target="#toggle-example"><a>customer services</a></h4>
                                <ul id="div-customer" class="collapse in">
                                    <li><a href="{{route('customer.checkout')}}">My Cart</a></li>
                                    <li><a href="{{route('customer.checkout')}}">Checkout</a></li>
                                    <li><a href="{{route('customer.login')}}">Login</a></li>
                                    <li><a href="{{route('customer.register')}}">Register</a></li>
                                </ul>
                            </div>
                        </div>
                         <!-- col end  -->
                        <div class="col-sm-3 mb-3 mb-sm-0">
                            <div class="footer-menu">
                                <h4 id="toggle-payment" class="title" data-toggle="collapse" data-target="#toggle-example"><a>accepted payment</a></h4>
                                <ul id="div-payment" class="collapse in">
                                    <li><img src="{{asset('public/frontEnd/images/payment-logo.png')}}" /></li>
                                </ul>
                            </div>
                        </div>
                         <!-- col end  -->
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="copyright">
                                <p>Copyright © {{ date('Y') }} {{$generalsetting->name}}. All rights reserved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        <!-- footer bottom start -->
        <div class="footer_nav">
            <ul>

                <li>
                    <a  class="footer-nav-cart-link toggle">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('home')}}">
                        <i class="fa-solid fa-home"></i>
                    </a>
                </li>
                <li>
                    <a href="{{route('customer.wishlist')}}">
                        <i class="far fa-heart"></i>
                        <span class="wishlist-qty">{{Cart::instance('wishlist')->count()}}</span>
                    </a>
                </li>
                @if(Auth::guard('customer')->user())
                <li>
                    <a href="{{route('customer.account')}}">
                        <i class="fa-regular fa-user"></i>
                    </a>
                </li>
                @else
                <li>
                    <a href="{{route('customer.login')}}">
                       <i class="fa-regular fa-user"></i>
                    </a>
                </li>
                @endif
            </ul>
        </div>
        <!-- footer bottom start -->

        <div class="search_inner">
            <div class="search_head">
                <p>Search Product</p>
                <a class="search_close"><i data-feather="x"></i></a>
            </div>
            <div class="search_body">
                <form action="{{route('search')}}">
                    <div class="form-group">
                        <select name="category_id" class="form-control search_click scategory">
                            <option value="">All &#9660; <i class="fa-solid fa-search"></i></option>
                            @foreach($sidecategories as $key=>$value)
                            <option value="{{$value->id}}">{{$value->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group form_inner">
                        <input type="text" class="search_click keyword" name="keyword">
                        <button><i class="fa-solid fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="search_result"></div>
        </div>

        <div id="custom-modal"></div>
        <div id="page-overlay"></div>
        <div id="loading"><div class="custom-loader"></div></div>

        <script src="{{asset('public/frontEnd/js/jquery-3.6.3.min.js')}}"></script>
        <script src="{{asset('public/frontEnd/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('public/frontEnd/js/owl.carousel.min.js')}}"></script>
        <script src="{{asset('public/frontEnd/js/mobile-menu.js')}}"></script>
        <script src="{{asset('public/frontEnd/js/mobile-menu-init.js')}}"></script>
        <script src="{{asset('public/frontEnd/js/wow.min.js')}}"></script>
        <script>
            new WOW().init();
        </script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <!-- feather icon -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js"></script>
        <script>
            feather.replace();
        </script>
        <script src="{{asset('public/backEnd/')}}/assets/js/toastr.min.js"></script>
        {!! Toastr::message() !!}
        @stack('script')
        <script>
            $('.quick_view').on('click',function(){
            var id = $(this).data('id');
            $("#loading").show();
            if(id){
                $.ajax({
                   type:"GET",
                   data:{'id':id},
                   url:"{{route('quickview')}}",
                   success:function(data){
                    if(data){
                           $("#custom-modal").html(data);
                           $("#custom-modal").show();
                           $("#loading").hide();
                           $("#page-overlay").show();
                    }
                   }
                });
            }
           });
        </script>
        <!-- quick view end -->
        <!-- wishlist js start -->
    <script>
        $('.wishlist_store').on('click',function(){
        var id = $(this).data('id');
        var qty = 1;
        $("#loading").show();
        if(id){
            $.ajax({
               type:"GET",
               data:{'id':id,'qty':qty?qty:1},
               url:"{{route('wishlist.store')}}",
               success:function(data){
                if(data){
                    $("#loading").hide();
                    toastr.success('success', 'Product added in wishlist');
                    //return wishlist_count()+mobile_wishlist_count();
                }
               }
            });
         }
       });

        $('.wishlist_remove').on('click',function(){
        var id = $(this).data('id');
        $("#loading").show();
        if(id){
            $.ajax({
               type:"GET",
               data:{'id':id},
               url:"{{route('wishlist.remove')}}",
               success:function(data){
                if(data){
                    $("#wishlist").html(data);
                    $("#loading").hide();
                    //return wishlist_count();
                }
               }
            });
         }
       });
        function wishlist_count(){
            $.ajax({
               type:"GET",
               url:"{{route('wishlist.count')}}",
               success:function(data){
                if(data){
                    $(".wishlist-qty").html(data);
                }else{
                   $(".wishlist-qty").empty();
                }
               }
            });
       };
    </script>
    <!-- wishlist js end -->
        <!-- cart js start -->
        <script>
            $(".cart_store").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id, qty : 1 },
                        url: "{{route('cart.store')}}",
                        success: function (data) {
                            if (data) {
                                $("#loading").hide();
                                $("#custom-modal").hide();
                                $("#page-overlay").hide();
                                //toastr.success('Thanks', 'Product add to cart');
                                toastr.success('success', 'Product added to shopping cart');
                                return cart_count() + mobile_cart();
                            }
                        },
                    });
                }
            });

            $(".cart_remove").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.remove')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                $("#loading").hide();
                                toastr.success('success', 'Product remove from shopping cart');
                                return cart_count() + mobile_cart() + cart_summary();
                            }
                        },
                    });
                }
            });

            $(".cart_increment").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.increment')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                $("#loading").hide();
                                toastr.success('success', 'Product increment to shopping cart');
                                return cart_count() + mobile_cart();
                            }
                        },
                    });
                }
            });

            $(".cart_decrement").on("click", function () {
                var id = $(this).data("id");
                $("#loading").show();
                if (id) {
                    $.ajax({
                        type: "GET",
                        data: { id: id },
                        url: "{{route('cart.decrement')}}",
                        success: function (data) {
                            if (data) {
                                $(".cartlist").html(data);
                                $("#loading").hide();
                                toastr.success('success', 'Product decrement to shopping cart');
                                return cart_count() + mobile_cart();
                            }
                        },
                    });
                }
            });

            function cart_count() {
                $.ajax({
                    type: "GET",
                    url: "{{route('cart.count')}}",
                    success: function (data) {
                        if (data) {
                            $("#cart-qty").html(data);
                        } else {
                            $("#cart-qty").empty();
                        }
                    },
                });
            }
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
            function cart_summary() {
                $.ajax({
                    type: "GET",
                    url: "{{route('shipping.charge')}}",
                    dataType: "html",
                    success: function (response) {
                        $(".cart-summary").html(response);
                    },
                });
            }
        </script>
        <!-- cart js end -->
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
        <script>
            $(".search_click").on("keyup change", function () {
                var category = $(".scategory").val();
                var keyword = $(".keyword").val();
                $.ajax({
                    type: "GET",
                    data: {category:category,keyword: keyword },
                    url: "{{route('livesearch')}}",
                    success: function (products) {
                        if (products) {
                            $("#loading").hide();
                            $(".search_result").html(products);
                        } else {
                            $(".search_result").empty();
                        }
                    },
                });
            });
        </script>
        <!-- search js start -->
        <script>
                $('.district').on('change',function(){
                var id = $(this).val();
                    $.ajax({
                       type:"GET",
                       data:{'id':id},
                       url:"{{route('districts')}}",
                       success:function(res){
                        if(res){
                            $(".area").empty();
                            $(".area").append('<option value="">Select..</option>');
                            $.each(res,function(key,value){
                                $(".area").append('<option value="'+key+'" >'+value+'</option>');
                            });

                        }else{
                           $(".area").empty();
                        }
                       }
                    });
               });
        </script>
        <script>
            $(".toggle").on("click", function () {
                $("#page-overlay").show();
                $(".mobile-menu").addClass("active");
            });
            $(".mobile-menu-close").on("click", function () {
                $("#page-overlay").hide();
                $(".mobile-menu").removeClass("active");
            });

            $(".search_toggle").on("click", function () {
                $("#page-overlay").show();
                $(".search_inner").addClass("active");
            });

            $(".search_close").on("click", function () {
                $("#page-overlay").hide();
                $(".search_inner").removeClass("active");
            });

            $("#page-overlay").on("click", function () {
                $("#page-overlay").hide();
                $(".mobile-menu").removeClass("active");
                $(".search_inner").removeClass("active");
                $(".feature-products").removeClass("active");
                $("#custom-modal").hide();
            });

            $(".mobile-filter-toggle").on("click", function () {
                $("#page-overlay").show();
                $(".feature-products").addClass("active");
            });
        </script>
        <script>
            $(document).ready(function() {
                $(".parent-category").each(function() {
                    const menuCatToggle = $(this).find(".menu-category-toggle");
                    const secondNav = $(this).find(".second-nav");
                    menuCatToggle.on("click", function() {
                        menuCatToggle.toggleClass("active");
                        secondNav.slideToggle("slow");
                        $(this).closest(".parent-category").toggleClass("active");
                    });
                });
                $(".parent-subcategory").each(function() {
                    const menuSubcatToggle = $(this).find(".menu-subcategory-toggle");
                    const thirdNav = $(this).find(".third-nav");

                    menuSubcatToggle.on("click", function() {
                        menuSubcatToggle.toggleClass("active");
                        thirdNav.slideToggle("slow");
                        $(this).closest(".parent-subcategory").toggleClass("active");
                    });
                });
            });
        </script>

        <script>
            $(document).ready(function(){
                $("#toggle-info").click(function(){
                    $('h4.title').removeClass('active');
                    $(this).toggleClass('active');
                    $("#div-info").collapse('toggle');
                });
                $("#toggle-account").click(function(){
                    $('h4.title').removeClass('active');
                    $(this).toggleClass('active');
                    $("#div-account").collapse('toggle');
                });
                $("#toggle-customer").click(function(){
                    $('h4.title').removeClass('active');
                    $(this).toggleClass('active');
                    $("#div-customer").collapse('toggle');
                });
                $("#toggle-payment").click(function(){
                    $('h4.title').removeClass('active');
                    $(this).toggleClass('active');
                    $("#div-payment").collapse('toggle');
                });
            });
        </script>

        <!-- Messenger Chat Plugin Code -->
    <div id="fb-root"></div>

    <!-- Your Chat Plugin code -->
    <div id="fb-customer-chat" class="fb-customerchat">
    </div>

    <script>
      var chatbox = document.getElementById('fb-customer-chat');
      chatbox.setAttribute("page_id", "110674047475565");
      chatbox.setAttribute("attribution", "biz_inbox");
    </script>

    <!-- Your SDK code -->
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          xfbml            : true,
          version          : 'v18.0'
        });
      };

      (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
    </script>

    </body>
</html>
