@extends('layout.base')

@section('title', 'Products - Kaly')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">All Products</h2>
    <div class="row">
        @forelse ($products as $product)
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                        <p class="text-muted">OMR {{ number_format($product->price, 2) }}</p>
                        <a href="#" class="btn btn-primary">View</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning text-center">
                    There are no products available.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
