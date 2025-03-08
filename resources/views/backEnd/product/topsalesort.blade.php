@extends('backEnd.layouts.master')
@section('title', 'Product Manage')
@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <a href="{{ route('products.index') }}" class="btn btn-info rounded-pill"><i class="fe-list"></i>
                            Manage Product</a>
                    </div>
                    <h4 class="page-title">Product Sort</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12">
                <form action="{{ route('topsale.sort') }}" method="POST" id="myForm">
                    @csrf
                    <div class="card">
                        <button class="btn btn-dark" style="display: block;" type="submit">Submit Sorting</button>
                        <div class="card-body">

                            <div class="table-responsive">
                                <table class="table nowrap w-100" id="sortableTable">
                                    <thead>
                                        <tr>
                                            <th style="width: 2%;">SL</th>
                                            <th style="width: 20%;">Name</th>
                                            <th style="width: 10%;">Category</th>
                                            <th style="width: 10%;">Image</th>
                                            <th style="width: 10%;">Price</th>
                                            <th style="width: 14%;">Deal & Feature</th>
                                            <th style="width: 8%;">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($data as $key => $value)
                                            <tr class="handle" style="cursor: grab;" data-id="{{ $loop->iteration }}">
                                                <input type="hidden" value="{{ $loop->iteration }}" name="sort[]" />
                                                <td>{{ $value->sort }}</td>
                                                <td>{{ $value->name }}</td>
                                                <td>{{ $value->category ? $value->category->name : '' }}</td>
                                                <td><img src="{{ asset($value->image ? $value->image->image : '') }}"
                                                        class="backend-image" alt="" /></td>
                                                <td>{{ $value->new_price }}</td>
                                                <td>
                                                    <p class="m-0">Hot Deals : {{ $value->topsale == 1 ? 'Yes' : 'No' }}
                                                    </p>
                                                </td>
                                                <td>
                                                    @if ($value->status == 1)
                                                        <span class="badge bg-soft-success text-success">Active</span>
                                                    @else
                                                        <span class="badge bg-soft-danger text-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card body-->
                    </div>
                    <!-- end card -->
                </form>
            </div>
            <!-- end col-->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new Sortable(document.getElementById("sortableTable").getElementsByTagName("tbody")[0], {
                animation: 150,
                handle: ".handle", // handle's class

            });
        });
    </script>
@endsection
