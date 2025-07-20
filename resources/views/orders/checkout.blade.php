@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <h2 class="mb-4">🛒 Checkout</h2>

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('orders.store') }}" method="POST">
                @csrf

                <!-- Shipping Address -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">📍 Shipping Address</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_name" class="form-label">Full Name *</label>
                                <input type="text" class="form-control @error('shipping_address.name') is-invalid @enderror" 
                                       id="shipping_name" name="shipping_address[name]" 
                                       value="{{ old('shipping_address.name', $user->name) }}" required>
                                @error('shipping_address.name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="shipping_phone" 
                                       name="shipping_address[phone]" value="{{ old('shipping_address.phone') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="shipping_address" class="form-label">Address *</label>
                            <input type="text" class="form-control @error('shipping_address.address') is-invalid @enderror" 
                                   id="shipping_address" name="shipping_address[address]" 
                                   value="{{ old('shipping_address.address') }}" required>
                            @error('shipping_address.address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_city" class="form-label">City *</label>
                                <input type="text" class="form-control @error('shipping_address.city') is-invalid @enderror" 
                                       id="shipping_city" name="shipping_address[city]" 
                                       value="{{ old('shipping_address.city') }}" required>
                                @error('shipping_address.city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_state" class="form-label">State/Province *</label>
                                <input type="text" class="form-control @error('shipping_address.state') is-invalid @enderror" 
                                       id="shipping_state" name="shipping_address[state]" 
                                       value="{{ old('shipping_address.state') }}" required>
                                @error('shipping_address.state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="shipping_zip" class="form-label">ZIP/Postal Code *</label>
                                <input type="text" class="form-control @error('shipping_address.zip') is-invalid @enderror" 
                                       id="shipping_zip" name="shipping_address[zip]" 
                                       value="{{ old('shipping_address.zip') }}" required>
                                @error('shipping_address.zip')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="shipping_country" class="form-label">Country *</label>
                                <input type="text" class="form-control @error('shipping_address.country') is-invalid @enderror" 
                                       id="shipping_country" name="shipping_address[country]" 
                                       value="{{ old('shipping_address.country', 'United States') }}" required>
                                @error('shipping_address.country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">💳 Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="credit_card" 
                                   value="credit_card" {{ old('payment_method', 'credit_card') == 'credit_card' ? 'checked' : '' }}>
                            <label class="form-check-label" for="credit_card">
                                💳 Credit Card
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="paypal" 
                                   value="paypal" {{ old('payment_method') == 'paypal' ? 'checked' : '' }}>
                            <label class="form-check-label" for="paypal">
                                🅿️ PayPal
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" 
                                   value="cash_on_delivery" {{ old('payment_method') == 'cash_on_delivery' ? 'checked' : '' }}>
                            <label class="form-check-label" for="cash_on_delivery">
                                💵 Cash on Delivery
                            </label>
                        </div>
                        @error('payment_method')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">📝 Order Notes (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" name="notes" rows="3" 
                                  placeholder="Any special instructions for your order...">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('cart.index') }}" class="btn btn-secondary">← Back to Cart</a>
                    <button type="submit" class="btn btn-primary btn-lg">Place Order 🛍️</button>
                </div>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">📋 Order Summary</h5>
                </div>
                <div class="card-body">
                    @foreach ($cart as $item)
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="d-flex align-items-center">
                                <img src="{{ $item['product']->image_url ?? 'https://via.placeholder.com/50' }}" 
                                     alt="{{ $item['product']->name }}" width="50" class="me-3 rounded">
                                <div>
                                    <strong>{{ $item['product']->name }}</strong><br>
                                    <small>Qty: {{ $item['quantity'] }}</small>
                                </div>
                            </div>
                            <span>${{ number_format($item['subtotal'], 2) }}</span>
                        </div>
                    @endforeach
                    
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total:</strong>
                        <strong>${{ number_format($total, 2) }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
