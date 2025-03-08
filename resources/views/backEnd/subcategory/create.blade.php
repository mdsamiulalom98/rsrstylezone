@extends('backEnd.layouts.master')
@section('title', 'Subategory Create')
@section('css')
    <link href="{{ asset('public/backEnd') }}/assets/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/css/switchery.min.css" rel="stylesheet" type="text/css" />
    <link href="{{ asset('public/backEnd') }}/assets/libs/summernote/summernote-lite.min.css" rel="stylesheet"
        type="text/css" />
@endsection
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('subcategories.index') }}" class="btn btn-primary rounded-pill">Manage</a>
                    </div>
                    <h4 class="page-title">Subategory Create</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('subcategories.store') }}" method="POST" class=row data-parsley-validate=""
                            enctype="multipart/form-data">
                            @csrf

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="category_id" class="form-label">Category *</label>
                                    <select class="form-control select2-multiple @error('category_id') is-invalid @enderror"
                                        id="category_id" name="category_id" value="{{ old('category_id') }}"
                                        data-toggle="select2" data-placeholder="Choose ..."required>
                                        <optgroup>

                                            <option value="">Choose..</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
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

                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="subcategoryName" class="form-label">SubcategoryName *</label>
                                    <input type="text" id="subcategoryName"
                                        class="form-control @error('subcategoryName') is-invalid @enderror"
                                        name="subcategoryName" value="{{ old('subcategoryName') }}" id="subcategoryName"
                                        required="">
                                    @error('subcategoryName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col-end -->
                            <!-- col end -->

                            <!--<div class="col-sm-12">-->
                            <!--    <div class="form-group mb-3">-->
                            <!--        <label for="namespace" class="form-label">Namespace (like men or women for avoid conflict between childcategories) *</label>-->
                            <!--        <input type="text" id="namespace" class="form-control @error('namespace') is-invalid @enderror" name="namespace" value="{{ old('namespace') }}" id="namespace" required="">-->
                            <!--        @error('namespace')
        -->
                                <!--            <span class="invalid-feedback" role="alert">-->
                                <!--                <strong>{{ $message }}</strong>-->
                                <!--            </span>-->
                                <!--
    @enderror-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!-- col-end -->

                            <div class="col-sm-12 mb-3">
                                <div class="form-group">
                                    <label for="image" class="form-label">Image (Optional)</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror "
                                        name="image" value="{{ old('image') }}" id="image">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->
                            <div class="col-sm-12">
                                <div class="form-group mb-3">
                                    <label for="category_video" class="form-label">Category Video *</label>
                                    <input type="text" class="form-control @error('category_video') is-invalid @enderror"
                                        name="category_video" value="{{ old('category_video') }}" id="category_video"
                                        required="">
                                    @error('category_video')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <!-- col end -->

                            <!-- col end -->
                            <div class="col mb-3">
                                <div class="form-group">
                                    <label for="status" class="d-block">Status</label>
                                    <label class="switch">
                                        <input type="checkbox" value="1" name="status" checked>
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


                            <div>
                                <input type="submit" class="btn btn-success" value="Submit">
                            </div>

                        </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
    </div>
@endsection


@section('script')
    <script src="{{ asset('public/backEnd/') }}/assets/libs/parsleyjs/parsley.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-validation.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs/select2/js/select2.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/pages/form-advanced.init.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/js/switchery.min.js"></script>
    <script src="{{ asset('public/backEnd/') }}/assets/libs//summernote/summernote-lite.min.js"></script>
    <script>
        $(document).ready(function() {
            var elem = document.querySelector('.js-switch');
            var init = new Switchery(elem);
        });
    </script>
    <script>
        $(".summernote").summernote({
            placeholder: "Enter Your Text Here",
        });
    </script>



@endsection
