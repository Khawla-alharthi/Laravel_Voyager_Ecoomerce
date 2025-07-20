<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        try {
            $cartItems = $this->cartService->get();
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

            return view('cart.index', [
                'cart' => $cart,
                'total' => $total
            ]);
        } catch (Exception $e) {
            Log::error('Cart index error: ' . $e->getMessage());
            return view('cart.index', [
                'cart' => [],
                'total' => 0
            ])->with('error', 'Unable to load cart. Please try again.');
        }
    }

    public function add(Request $request)
    {
        try {
            // Check if user is authenticated
            if (!Auth::check()) {
                // Store the intended URL to redirect back after login
                session(['url.intended' => url()->previous()]);
                
                if ($request->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please login to add items to cart',
                        'redirect' => route('login')
                    ], 401);
                }
                
                return redirect()->route('login')
                    ->with('message', 'Please login to add items to your cart.')
                    ->with('alert-type', 'info');
            }

            $request->validate([
                'product_id' => 'required|exists:products,id',
                'quantity' => 'integer|min:1'
            ]);

            $product = Product::findOrFail($request->product_id);
            
            // Check if product is available/in stock if you have inventory management
            // if ($product->stock < $request->quantity) {
            //     return redirect()->back()->with('error', 'Not enough stock available!');
            // }
            
            $this->cartService->add(
                $product->id,
                $request->quantity ?? 1,
                $product->price
            );

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully!',
                    'cart_count' => $this->cartService->count(),
                    'cart_total_quantity' => $this->cartService->totalQuantity()
                ]);
            }

            return redirect()->back()->with('success', 'Item added to cart successfully!');
        } catch (Exception $e) {
            Log::error('Cart add error: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unable to add item to cart. Please try again.'
                ], 500);
            }
            
            return redirect()->back()->with('error', 'Unable to add item to cart. Please try again.');
        }
    }

    public function update(Request $request, $productId)
    {
        try {
            // Require authentication for cart operations
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('message', 'Please login to manage your cart.')
                    ->with('alert-type', 'info');
            }

            $request->validate([
                'quantity' => 'required|integer|min:0'
            ]);

            $this->cartService->update($productId, $request->quantity);
            
            if ($request->quantity == 0) {
                return redirect()->back()->with('success', 'Item removed from cart!');
            } else {
                return redirect()->back()->with('success', 'Cart updated successfully!');
            }
        } catch (Exception $e) {
            Log::error('Cart update error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to update cart. Please try again.');
        }
    }

    public function remove($productId)
    {
        try {
            // Require authentication for cart operations
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('message', 'Please login to manage your cart.')
                    ->with('alert-type', 'info');
            }

            $this->cartService->remove($productId);
            return redirect()->back()->with('success', 'Item removed from cart successfully!');
        } catch (Exception $e) {
            Log::error('Cart remove error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to remove item from cart. Please try again.');
        }
    }

    public function clear()
    {
        try {
            // Require authentication for cart operations
            if (!Auth::check()) {
                return redirect()->route('login')
                    ->with('message', 'Please login to manage your cart.')
                    ->with('alert-type', 'info');
            }

            $this->cartService->clear();
            return redirect()->back()->with('success', 'Cart cleared successfully!');
        } catch (Exception $e) {
            Log::error('Cart clear error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Unable to clear cart. Please try again.');
        }
    }

    /**
     * Get cart count for AJAX requests
     */
    public function count()
    {
        try {
            return response()->json([
                'count' => $this->cartService->count(),
                'totalQuantity' => $this->cartService->totalQuantity()
            ]);
        } catch (Exception $e) {
            Log::error('Cart count error: ' . $e->getMessage());
            return response()->json(['count' => 0, 'totalQuantity' => 0]);
        }
    }
}