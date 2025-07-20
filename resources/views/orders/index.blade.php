@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">📦 My Orders</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if ($orders->count() > 0)
        <div class="row">
            @foreach ($orders as $order)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h6 class="mb-0">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h6>
                            <span class="badge bg-{{ $order->status_badge_color }}">{{ ucfirst($order->status) }}</span>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-2">
                                <small>{{ $order->created_at->format('M j, Y \a\t g:i A') }}</small>
                            </p>
                            
                            <div class="mb-3">
                                <strong>Items:</strong>
                                <ul class="list-unstyled mb-0">
                                    @foreach ($order->orderItems->take(3) as $item)
                                        <li class="d-flex justify-content-between align-items-center py-1">
                                            <span>{{ $item->product->name }} ({{ $item->quantity }})</span>
                                            <small>${{ number_format($item->subtotal, 2) }}</small>
                                        </li>
                                    @endforeach
                                    @if ($order->orderItems->count() > 3)
                                        <li class="text-muted">
                                            <small>... and {{ $order->orderItems->count() - 3 }} more items</small>
                                        </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <strong>Total:</strong>
                                <strong>${{ number_format($order->total_price, 2) }}</strong>
                            </div>

                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">{{ $order->total_quantity }} items</small>
                                <small class="text-muted">{{ ucwords(str_replace('_', ' ', $order->payment_method)) }}</small>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('orders.show', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    View Details
                                </a>
                                @if ($order->status === 'pending')
                                    <form action="{{ route('orders.cancel', $order->id) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">Cancel</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-shopping-bag text-muted" style="font-size: 4rem;"></i>
            </div>
            <h4 class="text-muted">No Orders Yet</h4>
            <p class="text-muted">You haven't placed any orders yet. Start shopping to see your orders here!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection