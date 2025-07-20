@extends('layouts.app')

@section('title', 'Your Shopping Cart')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">🛒 Your Cart</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (count($cart) > 0)
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Product</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Subtotal</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $item)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ $item['product']->image_url ?? 'https://via.placeholder.com/60' }}" alt="{{ $item['product']->name }}" width="60" class="me-3 rounded">
                                    <div>
                                        <strong>{{ $item['product']->name }}</strong><br>
                                        <small>{{ $item['product']->description }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>${{ number_format($item['price'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.update', $item['product']->id) }}" method="POST" class="d-flex align-items-center">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="0" class="form-control form-control-sm me-2" style="width: 70px;">
                                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                </form>
                            </td>
                            <td>${{ number_format($item['subtotal'], 2) }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" onsubmit="return confirm('Remove this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-light">
                    <tr>
                        <td colspan="3" class="text-end fw-bold">Total:</td>
                        <td class="fw-bold">${{ number_format($total, 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">← Continue Shopping</a>
            <div>
                @auth
                    <a href="{{ route('orders.checkout') }}" class="btn btn-success btn-lg me-3">
                        🛒 Proceed to Checkout
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-success btn-lg me-3">
                        🔐 Login to Checkout
                    </a>
                @endauth
                <form action="{{ route('cart.clear') }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to clear the cart?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">🗑️ Clear Cart</button>
                </form>
            </div>
        </div>
    @else
        <div class="alert alert-info">
            Your cart is empty. <a href="{{ route('products.index') }}">Browse products</a>.
        </div>
    @endif
</div>
@endsection
