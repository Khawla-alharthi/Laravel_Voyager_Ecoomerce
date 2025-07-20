@extends('layouts.app')

@section('title', $product->name . ' - Kaly')

@section('content')
<div class="container py-4">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}" class="text-decoration-none">Products</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Image -->
        <div class="col-md-6 mb-4">
            <div class="product-image-container">
                @if ($product->image)
                    <img src="{{ asset($product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="product-main-image img-fluid rounded shadow-sm"
                         id="mainImage">
                @else
                    <img src="{{ asset('images/default.jpg') }}" 
                         alt="No Image" 
                         class="product-main-image img-fluid rounded shadow-sm"
                         id="mainImage">
                @endif
                
                <!-- Image Zoom Overlay -->
                <div class="image-zoom-overlay" onclick="openImageModal()">
                    <i class="fas fa-search-plus"></i>
                </div>
            </div>
            
            <!-- Additional Images (if you have multiple images) -->
            @if(isset($product->images) && count($product->images) > 0)
                <div class="product-thumbnails mt-3">
                    <div class="row">
                        @foreach($product->images as $image)
                            <div class="col-3 mb-2">
                                <img src="{{ asset($image) }}" 
                                     alt="{{ $product->name }}" 
                                     class="img-thumbnail thumbnail-image"
                                     onclick="changeMainImage(this.src)">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <div class="product-details">
                <h1 class="product-title mb-3">{{ $product->name }}</h1>
                
                <!-- Rating -->
                @if(isset($product->rating))
                    <div class="product-rating mb-3">
                        <div class="d-flex align-items-center">
                            <div class="stars me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $product->rating ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                            <span class="text-muted">({{ $product->reviews_count ?? 0 }} reviews)</span>
                        </div>
                    </div>
                @endif
                
                <!-- Price -->
                <div class="product-price mb-4">
                    @if(isset($product->original_price) && $product->original_price > $product->price)
                        <span class="original-price text-muted text-decoration-line-through me-2">
                            OMR {{ number_format($product->original_price, 2) }}
                        </span>
                        <span class="current-price text-success fw-bold fs-3">
                            OMR {{ number_format($product->price, 2) }}
                        </span>
                        <span class="discount-badge badge bg-danger ms-2">
                            {{ round((($product->original_price - $product->price) / $product->original_price) * 100) }}% OFF
                        </span>
                    @else
                        <span class="current-price text-primary fw-bold fs-3">
                            OMR {{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>

                <!-- Stock Status -->
                <div class="stock-status mb-3">
                    @if($product->stock > 0)
                        <span class="badge bg-success">
                            <i class="fas fa-check-circle me-1"></i>
                            In Stock ({{ $product->stock }} available)
                        </span>
                    @else
                        <span class="badge bg-danger">
                            <i class="fas fa-times-circle me-1"></i>
                            Out of Stock
                        </span>
                    @endif
                </div>

                <!-- Description -->
                <div class="product-description mb-4">
                    <h5>Description</h5>
                    <p class="text-muted">{{ $product->description }}</p>
                </div>

                <!-- Product Specifications -->
                @if(isset($product->specifications))
                    <div class="product-specifications mb-4">
                        <h5>Specifications</h5>
                        <ul class="list-unstyled">
                            @foreach($product->specifications as $spec => $value)
                                <li><strong>{{ $spec }}:</strong> {{ $value }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Quantity and Add to Cart -->
                <form action="" method="POST" class="add-to-cart-form">
                    @csrf
                    <div class="row align-items-center mb-4">
                        <div class="col-md-4">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <div class="input-group">
                                <button type="button" class="btn btn-outline-secondary" onclick="decreaseQuantity()">-</button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       class="form-control text-center" 
                                       value="1" 
                                       min="1" 
                                       max="{{ $product->stock }}">
                                <button type="button" class="btn btn-outline-secondary" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <button type="submit" 
                                    class="btn btn-primary btn-lg w-100 add-to-cart-btn"
                                    {{ $product->stock == 0 ? 'disabled' : '' }}>
                                <i class="fas fa-shopping-cart me-2"></i>
                                {{ $product->stock == 0 ? 'Out of Stock' : 'Add to Cart' }}
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Action Buttons -->
                <div class="product-actions">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <button type="button" class="btn btn-outline-danger w-100" onclick="toggleWishlist()">
                                <i class="fas fa-heart me-2"></i>
                                Add to Wishlist
                            </button>
                        </div>
                        <div class="col-md-6 mb-2">
                            <button type="button" class="btn btn-outline-info w-100" onclick="shareProduct()">
                                <i class="fas fa-share-alt me-2"></i>
                                Share
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Tags -->
                @if(isset($product->tags) && count($product->tags) > 0)
                    <div class="product-tags mt-4">
                        <h6>Tags:</h6>
                        @foreach($product->tags as $tag)
                            <span class="badge bg-secondary me-1">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="related-products mt-5">
            <h3 class="mb-4">Related Products</h3>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="card-img-container">
                                <img src="{{ asset($relatedProduct->image ?? 'images/default.jpg') }}" 
                                     class="card-img-top" 
                                     alt="{{ $relatedProduct->name }}">
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">{{ $relatedProduct->name }}</h6>
                                <p class="text-muted fw-bold">OMR {{ number_format($relatedProduct->price, 2) }}</p>
                                <a href="{{ route('products.show', $relatedProduct->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $product->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="{{ $product->name }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<style>
    .product-image-container {
        position: relative;
        overflow: hidden;
        border-radius: 12px;
    }
    
    .product-main-image {
        width: 100%;
        height: 400px;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    
    .product-main-image:hover {
        transform: scale(1.05);
    }
    
    .image-zoom-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }
    
    .image-zoom-overlay:hover {
        opacity: 1;
    }
    
    .image-zoom-overlay i {
        color: white;
        font-size: 2rem;
    }
    
    .thumbnail-image {
        height: 80px;
        object-fit: cover;
        cursor: pointer;
        transition: transform 0.3s ease;
    }
    
    .thumbnail-image:hover {
        transform: scale(1.1);
    }
    
    .product-title {
        font-size: 2rem;
        font-weight: 600;
        color: #333;
    }
    
    .current-price {
        font-size: 1.8rem;
    }
    
    .original-price {
        font-size: 1.2rem;
    }
    
    .discount-badge {
        font-size: 0.8rem;
    }
    
    .add-to-cart-btn {
        padding: 12px 24px;
        font-weight: 600;
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .add-to-cart-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
    
    .card-img-container {
        height: 200px;
        overflow: hidden;
    }
    
    .card-img-top {
        height: 100%;
        object-fit: cover;
    }
    
    .input-group .btn {
        border-color: #dee2e6;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #6c757d;
    }
    
    @media (max-width: 768px) {
        .product-main-image {
            height: 300px;
        }
        
        .product-title {
            font-size: 1.5rem;
        }
        
        .current-price {
            font-size: 1.5rem;
        }
    }
</style>

<script>
    function changeMainImage(src) {
        document.getElementById('mainImage').src = src;
    }
    
    function openImageModal() {
        const mainImage = document.getElementById('mainImage');
        const modalImage = document.getElementById('modalImage');
        modalImage.src = mainImage.src;
        
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        modal.show();
    }
    
    function increaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const max = parseInt(quantityInput.getAttribute('max'));
        const currentValue = parseInt(quantityInput.value);
        
        if (currentValue < max) {
            quantityInput.value = currentValue + 1;
        }
    }
    
    function decreaseQuantity() {
        const quantityInput = document.getElementById('quantity');
        const currentValue = parseInt(quantityInput.value);
        
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    }
    
    function toggleWishlist(productId) {
        // Add your wishlist functionality here
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update button text/icon based on response
                const btn = event.target;
                if (data.added) {
                    btn.innerHTML = '<i class="fas fa-heart me-2"></i>Remove from Wishlist';
                    btn.classList.remove('btn-outline-danger');
                    btn.classList.add('btn-danger');
                } else {
                    btn.innerHTML = '<i class="fas fa-heart me-2"></i>Add to Wishlist';
                    btn.classList.remove('btn-danger');
                    btn.classList.add('btn-outline-danger');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
    
    function shareProduct() {
        if (navigator.share) {
            navigator.share({
                title: '{{ $product->name }}',
                text: '{{ $product->description }}',
                url: window.location.href
            });
        } else {
            // Fallback: copy URL to clipboard
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Product link copied to clipboard!');
            });
        }
    }
    
    // Add to cart form handling
    document.querySelector('.add-to-cart-form').addEventListener('submit', function(e) {
        const button = this.querySelector('.add-to-cart-btn');
        const originalText = button.innerHTML;
        
        button.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Adding...';
        button.disabled = true;
        
        // Re-enable button after 2 seconds (you can remove this in production)
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    });
</script>
@endsection