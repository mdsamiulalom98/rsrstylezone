@extends('frontEnd.layouts.master')
@section('title','Customer Register')
@section('content')
<div class="bread_section">
    <div class="container-fluid">
        <div class="row">
            <div class="breadcrumb_title">
                <h2>Customer Register</h2>
            </div>
        </div>
    </div>
</div>
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="form-content">
                    <form action="{{route('customer.store')}}" method="POST"  data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name">Name</label>
                            <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter Your Name" required>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number</label>
                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Enter Your Phone Number" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Your Email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter Your Password" name="password" value="{{ old('password') }}" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <div class="form-group text-center">
                            <button class="submit-btn">submit</button>
                        </div>
                        </div>
                     <!-- col-end -->
                     
                     <div class="register-now no-account">
                        <a href="{{route('customer.login')}}">Aready Have an account? Login Now</a>
                    </div>
                     </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script')
<script src="{{asset('public/frontEnd/')}}/js/parsley.min.js"></script>
<script src="{{asset('public/frontEnd/')}}/js/form-validation.init.js"></script>
@endpush