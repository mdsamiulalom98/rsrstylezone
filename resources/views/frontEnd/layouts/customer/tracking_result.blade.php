@extends('frontEnd.layouts.master')
@section('title','Order Track Result')
@section('content')
<section class="auth-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-sm-5">
                <div class="form-content">
                    <p class="auth-title">Order Track Result</p>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td>Invoice ID</td>
                                <td>{{$order->invoice_id}}</td>
                            </tr>
                            <tr>
                                <td>Date</td>
                                <td>{{$order->created_at}}</td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td>{{App\Models\Orderstatus::where('id',$order->order_status)->first()->name}}</td>
                            </tr>
                        </tbody>
                    </table>
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