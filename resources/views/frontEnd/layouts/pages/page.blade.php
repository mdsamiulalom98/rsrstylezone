@extends('frontEnd.layouts.master')
@section('title','Page')
@section('content')
<div class="bread_section">
    <div class="container">
        <div class="row">
            <div class="breadcrumb_title">
                <h2>{{$page->title}}</h2>
            </div>
        </div>
    </div>
</div>
<section class="createpage-section">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-content">
                    <div class="page-title mb-2">
                        <h5>{{$page->title}}</h5>
                    </div>
                    <div class="page-description">
                        {!! $page->description !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
