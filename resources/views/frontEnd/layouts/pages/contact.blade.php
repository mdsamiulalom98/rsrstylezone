@extends('frontEnd.layouts.master')
@section('title','Contact Us')
@section('content')
<div class="bread_section">
    <div class="container">
        <div class="row">
            <div class="breadcrumb_title">
                <h2>Contact Us</h2>
            </div>
        </div>
    </div>
</div>
<section class="contact-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="contact-form">
                    <h5 class="account-title">Send A Message</h5>
                    <form action="{{route('home')}}" method="POST" class="row" enctype="multipart/form-data" data-parsley-validate="">
                        @csrf
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="name">Full Name *</label>
                                <input type="text" id="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{old('name')}}" required>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-6">
                            <div class="form-group mb-3">
                                <label for="phone">Phone Number *</label>
                                <input type="number" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}"  required>
                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="email">Email Address *</label>
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}"  required>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="subject">Subject *</label>
                                <input type="text" id="subject" class="form-control @error('subject') is-invalid @enderror" name="subject" value="{{old('subject')}}"  required>
                                @error('subject')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <label for="message">Message *</label>
                                <textarea type="text" id="message" class="form-control @error('message') is-invalid @enderror" name="message" value="{{old('message')}}"  required></textarea>
                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <!-- col-end -->
                        <div class="col-sm-12">
                            <div class="form-group mb-3">
                                <button type="submit" class="submit-btn">send now</button>
                            </div>
                        </div>
                        <!-- col-end -->
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                               <h6> <i data-feather="phone"></i> Phone</h6>
                            </div>
                            <div class="card-body">
                                <p>Call At : 09.00 am - 06.00 pm</p>
                                <p>Hotline : {{$contact->hotline}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-header">
                                <h6> <i data-feather="mail"></i> Email</h6>
                            </div>
                            <div class="card-body">
                                <p>Hotmail : {{$contact->hotmail}}</p>
                                <p>{{$contact->email}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 mt-1">
                        <div class="card mt-4">
                            <div class="card-header">
                                <h6> <i data-feather="map-pin"></i> Address</h6>
                            </div>
                            <div class="card-body">
                                <p>Address : {{$contact->address}}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-sm-12">
                       <div class="mt-2">
                           <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.3624604238144!2d90.3502816!3d23.7701039!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c118f12296db%3A0xb0b71ebe4356be02!2sAbu%20bakar%20Masjid!5e0!3m2!1sen!2sbd!4v1703408053898!5m2!1sen!2sbd" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                           </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="social-media footer-about">
                            <h6>SOCIAL MEDIA</h6>
                            <ul>
                                @foreach($socialicons as $value)
                                <li><a href="{{$value->link}}" style="background:{{$value->color}}"><i class="{{$value->icon}}"></i></a></li>
                                @endforeach
                            </ul>
                        </div>
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