@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="text-center mb-5">
                <div class="mb-4">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h1 class="text-success">Order Confirmed!</h1>
                <p class="lead">Thank you for your order. We've received your order and will process it shortly.</p>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">📋 Order Details</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Order Number:</strong></div>
                        <div class="col-sm-9">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Order Date:</strong></div>
                        <div class="col-sm-9">{{ $order->created_at->format('F j, Y \a\t g:i A') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Status:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-{{ $order->status_badge_color }}">{{ ucfirst($order->status) }}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Payment Method:</strong></div>
                        <div class="col-sm-9">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3"><strong>Total Amount:</strong></div>
                        <div class="col-sm-9"><strong>${{ number_format($order->total_price, 2) }}</strong></div>
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">🛍️ Order Items</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->orderItems as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $item->product->image_url ?? 'https://via.placeholder.com/50' }}" 
                                                     alt="{{ $item->product->name }}" width="50" class="me-3 rounded">
                                                <div>
                                                    <strong>{{ $item->product->name }}</strong><br>
                                                    <small class="text-muted">{{ $item->product->description }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>${{ number_format($item->price, 2) }}</td>
                                        <td>{{ $item->quantity }}</td>
                                        <td>${{ number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" class="text-end">Total:</th>
                                    <th>${{ number_format($order->total_price, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">📍 Shipping Address</h6>
                        </div>
                        <div class="card-body">
                            <address class="mb-0">
                                <strong>{{ $order->shipping_address['name'] }}</strong><br>
                                {{ $order->shipping_address['address'] }}<br>
                                {{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['zip'] }}<br>
                                {{ $order->shipping_address['country'] }}
                                @if(isset($order->shipping_address['phone']))
                                    <br>Phone: {{ $order->shipping_address['phone'] }}
                                @endif
                            </address>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0">💳 Payment Information</h6>
                        </div>
                        <div class="card-body">
                            <p><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</p>
                            <p><strong>Payment Status:</strong> 
                                <span class="badge bg-warning">{{ ucfirst($order->payment_status ?? 'Pending') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            @if($order->notes)
                <div class="card mt-4">
                    <div class="card-header">
                        <h6 class="mb-0">📝 Order Notes</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $order->notes }}</p>
                    </div>
                </div>
            @endif

            <div class="text-center mt-5">
                <a href="{{ route('orders.index') }}" class="btn btn-primary me-3">View All Orders</a>
                <a href="{{ route('products.index') }}" class="btn btn-outline-primary">Continue Shopping</a>
            </div>
        </div>
    </div>
</div>
@endsection