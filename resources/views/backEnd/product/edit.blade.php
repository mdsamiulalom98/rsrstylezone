@extends('backEnd.layouts.master') 
@section('title','Product Edit') 
@section('css')
<style>
    .increment_btn,
    .remove_btn,
    .btn-warning {
        margin-top: -17px;
        margin-bottom: 10px;
    }
</style>
<link href="{{asset('public/backEnd')}}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
<link href="{{asset('public/backEnd')}}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet" type="text/css" />
@endsection 
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{route('products.index')}}" class="btn btn-primary rounded-pill">Manage</a>
                </div>
                <h4 class="page-title">Product Edit</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{route('products.update')}}" method="POST" class="row" data-parsley-validate="" enctype="multipart/form-data" name="editForm">
                        @csrf
                        <input type="hidden" value="{{$edit_data->id}}" name="id" />
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Product Name *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$edit_data->name }}" id="name" required="" />
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="youtube_link" class="form-label">Youtube Link (Optional)</label>
                                <input type="text" class="form-control @error('youtube_link') is-invalid @enderror" name="youtube_link" value="{{$edit_data->youtube_link }}" id="youtube_link" />
                                @error('youtube_link')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="pro_video" class="form-label">Product Video (Optional)</label>
                                <input type="text" class="form-control @error('pro_video') is-invalid @enderror" name="pro_video" value="{{$edit_data->pro_video }}" id="pro_video" />
                                @error('pro_video')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="category_id" class="form-label">Categories *</label>
                                <select class="form-control form-select select2 @error('category_id') is-invalid @enderror" name="category_id" value="{{ old('category_id') }}" required>
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" @if($edit_data->category_id==$category->id) selected @endif>{{$category->name}}</option>
                                        @foreach ($category->childrenCategories as $childCategory)<option value="{{$childCategory->id}}" @if($edit_data->category_id==$childCategory->id) selected @endif>- {{$childCategory->name}}</option>
                                        } @endforeach @endforeach
                                    </optgroup>
                                </select>
                                @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="subcategory_id" class="form-label">SubCategories (Optional)</label>
                                <select
                                    class="form-control form-select select2-multiple @error('subcategory_id') is-invalid @enderror"
                                    id="subcategory_id"
                                    name="subcategory_id"
                                    data-placeholder="Choose ..."
                                >
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach($subcategory as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->subcategoryName}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('subcategory_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="childcategory_id" class="form-label">Child Categories (Optional)</label>
                                <select
                                    class="form-control form-select select2-multiple @error('childcategory_id') is-invalid @enderror"
                                    id="childcategory_id"
                                    name="childcategory_id"
                                    data-placeholder="Choose ..."
                                >
                                    <optgroup>
                                        <option value="">Select..</option>
                                        @foreach($childcategory as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->childcategoryName}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                                @error('childcategory_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="brand_id" class="form-label">Brands</label>
                                <select class="form-control select2 @error('brand_id') is-invalid @enderror" value="{{ old('brand_id') }}" name="brand_id">
                                        <option value="">Select..</option>
                                        @foreach($brands as $value)
                                        <option value="{{$value->id}}" @if($edit_data->brand_id==$value->id) selected @endif>{{$value->name}}</option>
                                        @endforeach
                                </select>
                                @error('brand_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="purchase_price" class="form-label">Purchase Price *</label>
                                <input type="text" class="form-control @error('purchase_price') is-invalid @enderror" name="purchase_price" value="{{ $edit_data->purchase_price}}" id="purchase_price" required />
                                @error('purchase_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                         <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="old_price" class="form-label">Old Price </label>
                                <input type="text" class="form-control @error('old_price') is-invalid @enderror" name="old_price" value="{{ $edit_data->old_price }}" id="old_price" />
                                @error('old_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="new_price" class="form-label">New Price *</label>
                                <input type="text" class="form-control @error('new_price') is-invalid @enderror" name="new_price" value="{{ $edit_data->new_price }}" id="new_price" required />
                                @error('new_price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="stock" class="form-label">Stock *</label>
                                <input type="text" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ $edit_data->stock }}" id="stock" />
                                @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end --> 

                        <div class="col-sm-4 mb-3">
                            <label for="image">Image *</label>
                            <div class="input-group control-group increment">
                                <input type="file" name="image[]" class="form-control @error('image') is-invalid @enderror" />
                                <div class="input-group-btn">
                                    <button class="btn btn-success btn-increment" type="button"><i class="fa fa-plus"></i></button>
                                </div>
                                @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>

                            <div class="clone hide" style="display: none;">
                                <div class="control-group input-group">
                                    <input type="file" name="image[]" class="form-control" />
                                    <div class="input-group-btn">
                                        <button class="btn btn-danger" type="button"><i class="fa fa-trash"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="product_img">
                                @foreach($edit_data->images as $image)
                                <img src="{{asset($image->image)}}" class="edit-image border" alt="" />
                                <a href="{{route('products.image.destroy',['id'=>$image->id])}}" class="btn btn-xs btn-danger waves-effect waves-light"><i class="mdi mdi-close"></i></a>
                                @endforeach
                            </div>
                        </div>
                        <!-- col end -->
                         <!-- col-end -->
                    <div class="col-sm-4 mb-3">
                        <div class="form-group">
                            <label for="size_chart" class="form-label">Size Chart</label>
                            <input type="file" class="form-control @error('size_chart') is-invalid @enderror" name="size_chart" value="{{ $edit_data->size_chart }}"  id="size_chart" >
                            <img src="{{asset($edit_data->size_chart)}}" alt="" class="edit-image border">
                            @error('size_chart')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="roles" class="form-label">Size (Optional)</label>
                                 <select class="form-control select2" name="proSize[]"  multiple="multiple">
                                        <option value="">Select</option>
                                        @foreach($totalsizes as $totalsize)
                                        <option value="{{$totalsize->id}}" @foreach($selectsizes as $selectsize) @if($totalsize->id == $selectsize->size_id)selected="selected"@endif @endforeach>{{$totalsize->sizeName}}</option>
                                        @endforeach
                                </select>
                                
                                @error('sizes')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="color" class="form-label">Color (Optional)</label>
                                 <select class="form-control select2" name="proColor[]"  multiple="multiple">
                                        <option value="">Select..</option>
                                        @foreach($totalcolors as $totalcolor)
                                        <option value="{{$totalcolor->id}}" @foreach($selectcolors as $selectcolor) @if($totalcolor->id == $selectcolor->color_id) selected="selected" @endif @endforeach>{{$totalcolor->colorName}}
                                        </option>
                                        @endforeach
                                </select>
                                @error('colors')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea name="short_description" rows="6" class="summernote form-control @error('short_description') is-invalid @enderror">{{$edit_data->short_description}}</textarea>
                                @error('short_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" rows="6" class="summernote form-control @error('description') is-invalid @enderror">{{$edit_data->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-12 mb-3">
                            <div class="form-group">
                                <label for="meta_description" class="form-label">Meta Description</label>
                                <textarea name="meta_description" rows="6" class="form-control @error('meta_description') is-invalid @enderror">{{$edit_data->meta_description}}</textarea>
                                @error('meta_description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-4">
                            <div class="form-group mb-3">
                                <label for="sort" class="form-label">Sort (Optional)</label>
                                <input type="number" class="form-control @error('sort') is-invalid @enderror" name="sort" value="{{ $edit_data->sort }}" id="sort" />
                                @error('sort')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end --> 
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label for="status" class="d-block">Status</label>
                                <label class="switch">
                                    <input type="checkbox" value="1" name="status" @if($edit_data->status==1)checked @endif>
                                    <span class="slider round"></span>
                                </label>
                                @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-2 mb-2">
                            <div class="form-group">
                                <label for="topsale" class="d-block">Best Sell</label>
                                <label class="switch">
                                    <input type="checkbox" value="1" name="topsale" @if($edit_data->topsale==1)checked @endif>
                                    <span class="slider round"></span>
                                </label>
                                @error('topsale')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->
                        <div class="col-sm-2 mb-2">
                            <div class="form-group">
                                <label for="feature_product" class="d-block">New Arrival</label>
                                <label class="switch">
                                    <input type="checkbox" value="1" name="feature_product" @if($edit_data->feature_product==1)checked @endif>
                                    <span class="slider round"></span>
                                </label>
                                @error('feature_product')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col end -->

                        <!-- col end -->
                        <div>
                            <input type="submit" class="btn btn-success" value="Submit" />
                        </div>
                    </form>
                </div>
                <!-- end card-body-->
            </div>
            <!-- end card-->
        </div>
        <!-- end col-->
    </div>
</div>
@endsection 
@section('script')
<script src="{{asset('public/backEnd/')}}/assets/libs/parsleyjs/parsley.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-validation.init.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/libs/select2/js/select2.min.js"></script>
<script src="{{asset('public/backEnd/')}}/assets/js/pages/form-advanced.init.js"></script>
<!-- Plugins js -->
<script src="{{asset('public/backEnd/')}}/assets/libs//summernote/summernote-lite.min.js"></script>
<script>
    $(".summernote").summernote({
        placeholder: "Enter Your Text Here",
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".btn-increment").click(function () {
            var html = $(".clone").html();
            $(".increment").after(html);
        });
        $("body").on("click", ".btn-danger", function () {
            $(this).parents(".control-group").remove();
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".increment_btn").click(function () {
            var html = $(".clone_price").html();
            $(".increment_price").after(html);
        });
        $("body").on("click", ".remove_btn", function () {
            $(this).parents(".increment_control").remove();
        });
        $('.select2').select2();
    });
    
    // category to sub
    $("#category_id").on("change", function () {
        var ajaxId = $(this).val();
        if (ajaxId) {
            $.ajax({
                type: "GET",
                url: "{{url('ajax-product-subcategory')}}?category_id=" + ajaxId,
                success: function (res) {
                    if (res) {
                        $("#subcategory_id").empty();
                        $("#subcategory_id").append('<option value="0">Choose...</option>');
                        $.each(res, function (key, value) {
                            $("#subcategory_id").append('<option value="' + key + '">' + value + "</option>");
                        });
                    } else {
                        $("#subcategory_id").empty();
                    }
                },
            });
        } else {
            $("#subcategory_id").empty();
        }
    });

    // subcategory to childcategory
    $("#subcategory_id").on("change", function () {
        var ajaxId = $(this).val();
        if (ajaxId) {
            $.ajax({
                type: "GET",
                url: "{{url('ajax-product-childcategory')}}?subcategory_id=" + ajaxId,
                success: function (res) {
                    if (res) {
                        $("#childcategory_id").empty();
                        $("#childcategory_id").append('<option value="0">Choose...</option>');
                        $.each(res, function (key, value) {
                            $("#childcategory_id").append('<option value="' + key + '">' + value + "</option>");
                        });
                    } else {
                        $("#childcategory_id").empty();
                    }
                },
            });
        } else {
            $("#childcategory_id").empty();
        }
    });
</script>
 <script type="text/javascript">
    document.forms["editForm"].elements["category_id"].value = "{{$edit_data->category_id}}";
    document.forms["editForm"].elements["subcategory_id"].value = "{{$edit_data->subcategory_id}}";
    document.forms["editForm"].elements["childcategory_id"].value = "{{$edit_data->childcategory_id}}";
</script>
@endsection
