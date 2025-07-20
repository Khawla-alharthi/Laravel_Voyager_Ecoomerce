<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Exception;

class OrderController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->middleware('auth');
        $this->cartService = $cartService;
    }

    /**
     * Display the checkout page
     */
    public function checkout()
    {
        try {
            $cartItems = $this->cartService->get();
            
            if (empty($cartItems)) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
            }

            $products = Product::whereIn('id', array_keys($cartItems))->get();
            $cart = [];
            $total = 0;

            foreach ($cartItems as $productId => $item) {
                $product = $products->find($productId);
                if ($product) {
                    $quantity = (int) $item['quantity'];
                    $price = (float) $item['price'];
                    $subtotal = $price * $quantity;
                    
                    $cart[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'price' => $price,
                        'subtotal' => $subtotal
                    ];
                    
                    $total += $subtotal;
                }
            }

            return view('orders.checkout', [
                'cart' => $cart,
                'total' => $total,
                'user' => Auth::user()
            ]);
        } catch (Exception $e) {
            Log::error('Checkout error: ' . $e->getMessage());
            return redirect()->route('cart.index')->with('error', 'Unable to process checkout. Please try again.');
        }
    }

    /**
     * Process the order
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'shipping_address.name' => 'required|string|max:255',
                'shipping_address.address' => 'required|string|max:500',
                'shipping_address.city' => 'required|string|max:255',
                'shipping_address.state' => 'required|string|max:255',
                'shipping_address.zip' => 'required|string|max:20',
                'shipping_address.country' => 'required|string|max:255',
                'payment_method' => 'required|string|in:credit_card,paypal,cash_on_delivery',
                'notes' => 'nullable|string|max:1000'
            ]);

            $cartItems = $this->cartService->get();
            
            if (empty($cartItems)) {
                return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
            }

            DB::beginTransaction();

            // Calculate total
            $products = Product::whereIn('id', array_keys($cartItems))->get();
            $total = 0;
            $orderItems = [];

            foreach ($cartItems as $productId => $item) {
                $product = $products->find($productId);
                if ($product) {
                    $quantity = (int) $item['quantity'];
                    $price = (float) $item['price'];
                    $subtotal = $price * $quantity;
                    
                    $orderItems[] = [
                        'product_id' => $productId,
                        'quantity' => $quantity,
                        'price' => $price
                    ];
                    
                    $total += $subtotal;
                }
            }

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'total_price' => $total,
                'status' => 'pending',
                'shipping_address' => $request->shipping_address,
                'billing_address' => $request->billing_address ?? $request->shipping_address,
                'payment_method' => $request->payment_method,
                'payment_status' => 'pending',
                'notes' => $request->notes
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);
            }

            // Clear cart after successful order
            $this->cartService->clear();

            DB::commit();

            return redirect()->route('orders.confirmation', $order->id)
                ->with('success', 'Order placed successfully!');

        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Order creation error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to process order. Please try again.');
        }
    }

    /**
     * Display order confirmation
     */
    public function confirmation($orderId)
    {
        try {
            $order = Order::with(['orderItems.product', 'user'])
                ->where('id', $orderId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return view('orders.confirmation', compact('order'));
        } catch (Exception $e) {
            Log::error('Order confirmation error: ' . $e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }
    }

    /**
     * Display user's orders
     */
    public function index()
    {
        try {
            $orders = Order::with(['orderItems.product'])
                ->where('user_id', Auth::id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('orders.index', compact('orders'));
        } catch (Exception $e) {
            Log::error('Orders index error: ' . $e->getMessage());
            return view('orders.index', ['orders' => collect()]);
        }
    }

    /**
     * Display specific order details
     */
    public function show($orderId)
    {
        try {
            $order = Order::with(['orderItems.product', 'user'])
                ->where('id', $orderId)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            return view('orders.show', compact('order'));
        } catch (Exception $e) {
            Log::error('Order show error: ' . $e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Order not found.');
        }
    }

    /**
     * Cancel an order (only if pending)
     */
    public function cancel($orderId)
    {
        try {
            $order = Order::where('id', $orderId)
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->firstOrFail();

            $order->update(['status' => 'cancelled']);

            return redirect()->back()->with('success', 'Order cancelled successfully.');
        } catch (Exception $e) {
            Log::error('Order cancel error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to cancel order.');
        }
    }
}
