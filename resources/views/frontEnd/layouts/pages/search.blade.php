@extends('frontEnd.layouts.master') 
@section('title',$keyword)
@section('content')
<div class="bread_section">
    <div class="container">
        <div class="row">
            <div class="breadcrumb_title">
                <h2>{{$keyword}}</h2>
            </div>
        </div>
    </div>
</div>
<section class="product-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="category-breadcrumb d-flex align-items-center">
                    <a href="{{ route('home') }}">Search By</a>
                    <span>/</span>
                    <strong>{{ $keyword }}</strong>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="showing-data">
                            <span>Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} Results</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="page-sort">
                            <form action="" class="sort-form">
                                <select name="sort" class="form-control form-select sort">
                                    <option value="1" @if(request()->get('sort')==1)selected @endif>Product: Latest</option>
                                    <option value="2" @if(request()->get('sort')==2)selected @endif>Product: Oldest</option>
                                    <option value="3" @if(request()->get('sort')==3)selected @endif>Price: High To Low</option>
                                    <option value="4" @if(request()->get('sort')==4)selected @endif>Price: Low To High</option>
                                    <option value="5" @if(request()->get('sort')==5)selected @endif>Name: A-Z</option>
                                    <option value="6" @if(request()->get('sort')==6)selected @endif>Name: Z-A</option>
                                </select>
                                <input type="hidden" name="min_price" value="{{request()->get('min_price')}}" />
                                <input type="hidden" name="max_price" value="{{request()->get('max_price')}}" />
                            </form>
                        </div>
                        
                    </div>
                </div>
                
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="product_inner">
                    @foreach($products as $key=>$value)
                        <div class="product_item wist_item wow zoomIn" data-wow-duration="1.5s" data-wow-delay="0.5s">
                            <div class="product_item_inner">
                                @if($value->old_price)
                                <div class="discount">@php $discount=(((($value->old_price)-($value->new_price))*100) / ($value->old_price)) @endphp -{{number_format($discount,0)}}%
                                </div>
                                @endif
                                <div class="pro_img">
                                    <a href="{{ route('product',$value->slug) }}">
                                        <img src="{{ asset($value->image ? $value->image->image : '') }}" alt="{{$value->name}}" />
                                    </a>
                                    <div class="quick_view_btn">
                                        <button data-id="{{$value->id}}" class="hover-zoom quick_view" title="Wishlist"><i class="fa-solid fa-magnifying-glass"></i></button>
                                        <button type="button" class="cart_store" data-id="{{$value->id}}"><i class="fas fa-shopping-basket"></i></button>
                                    </div>
                                </div>
                                <div class="action_two">
                                    <button data-id="{{$value->id}}" class="hover-zoom wishlist_store" title="Wishlist"><i class="fa-regular fa-heart"></i></button>
                                    <!-- <button data-id="{{$value->id}}" class="hover-zoom compare_store" title="Compare"><i class="fa-solid fa-sync"></i></button> -->
                                </div>
                                <div class="pro_des">
                                    <div class="product__size sort_single third-single four-single five-single six-single one-single two-single">
                                            @foreach($value->prosizes as $sizes)                                
                                            <a class="size__item" data-size="{{ $sizes->size_id}}" onmouseover="activateSize(this)" href="{{ route('product',$value->slug) }}?size={{ $sizes->size_id }}">{{ $sizes->size ? $sizes->size->sizeName : '' }}</a>
                                            @endforeach
                                    </div>
                                    <div class="pro_name">
                                        <a href="{{ route('product',$value->slug) }}">{{Str::limit($value->name,60)}}</a>
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
        <div class="row">
            <div class="col-sm-12">
                <div class="custom_paginate">
                    {{$products->links('pagination::bootstrap-4')}}
                   
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script>
    $(".sort").change(function(){
       $('#loading').show();
       $(".sort-form").submit();
    })
</script>
@endpush