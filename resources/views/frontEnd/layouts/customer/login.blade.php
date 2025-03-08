@extends('frontEnd.layouts.master')
@section('title','Customer Login')
@section('content')
<div class="bread_section">
    <div class="container-fluid">
        <div class="row">
            <div class="breadcrumb_title">
                <h2>Customer Login</h2>
            </div>
        </div>
    </div>
</div>
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="form-content">
                    <form action="{{route('customer.signin')}}" method="POST"  data-parsley-validate="">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="phone">Phone Number</label>
                            <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Enter Phone Number" required>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <div class="form-group mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Enter Your Password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <!-- col-end -->
                        <a href="{{route('customer.forgot.password')}}" class="forget-link">Forgot your password?</a>
                        <div class="form-group mb-3 text-center">
                            <button class="submit-btn">submit</button>
                        </div>
                     <!-- col-end -->
                     </form>
                     <div class="register-now no-account">
                        <a href="{{route('customer.register')}}"> New Customer? Create Your Account</a>
                    </div>
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