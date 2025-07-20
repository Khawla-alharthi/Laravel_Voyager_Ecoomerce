@extends('layouts.app')

@section('title', 'Products - Kaly')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">All Products</h2>

    {{-- Flash success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @forelse ($products as $product)
            <div class="col-sm-6 col-md-3 mb-4">
                <div class="card h-100 shadow-sm product-card">
                    <div class="card-img-container">
                        @if ($product->image)
                            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="No Image">
                        @endif
                    </div>
                    <div class="card-body d-flex flex-column p-3">
                        <h6 class="card-title mb-2">{{ $product->name }}</h6>
                        <p class="card-text flex-grow-1 small">{{ Str::limit($product->description, 80) }}</p>
                        <p class="text-muted fw-bold mb-2 small">OMR {{ number_format($product->price, 2) }}</p>
                        <div class="mt-auto d-flex gap-2">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-primary btn-enhanced flex-fill">
                                <i class="fas fa-eye me-1"></i>
                                View
                            </a>
                            
                            <form action="{{ route('cart.add') }}" method="POST" class="m-0 flex-fill d-flex">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success btn-enhanced w-100">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Add to Cart
                                </button>
                            </form>
                        </div>
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

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>

<style>
    .card {
        height: 100%;
        transition: box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .product-card:hover {
        box-shadow: 0 0 15px rgba(0, 123, 255, 0.4);
        transform: translateY(-2px);
    }

    .card-img-container {
        height: 250px;
        overflow: hidden;
        position: relative;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        transition: transform 0.3s ease;
    }

    .product-card:hover .card-img-top {
        transform: scale(1.05);
    }

    .card-body {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-text {
        min-height: 60px;
        line-height: 1.4;
    }

    .card-title {
        font-weight: 600;
        color: #333;
        line-height: 1.2;
        min-height: 40px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .btn-enhanced {
        font-size: 0.85rem;
        padding: 0.5rem 0.75rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 38px;
    }

    .btn-enhanced:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .btn-outline-primary.btn-enhanced {
        border: 2px solid #0d6efd;
        color: #0d6efd;
        background: transparent;
    }

    .btn-outline-primary.btn-enhanced:hover {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    .btn-success.btn-enhanced {
        background: linear-gradient(135deg, #198754, #20c997);
        border: none;
        color: white;
    }

    .btn-success.btn-enhanced:hover {
        background: linear-gradient(135deg, #157347, #1a9c7d);
    }

    .btn-enhanced i {
        font-size: 0.8rem;
    }

    /* Responsive adjustments */
    @media (max-width: 576px) {
        .card-img-container {
            height: 220px;
        }

        .card-text {
            min-height: 50px;
        }

        .card-title {
            min-height: 35px;
        }

        .btn-enhanced {
            font-size: 0.8rem;
            padding: 0.4rem 0.6rem;
            min-height: 35px;
        }
    }

    @media (min-width: 768px) {
        .card-img-container {
            height: 270px;
        }

        .card-text {
            min-height: 70px;
        }

        .card-title {
            min-height: 45px;
        }

        .btn-enhanced {
            font-size: 0.9rem;
            padding: 0.6rem 0.8rem;
            min-height: 40px;
        }
    }
</style>
@endsection
