<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Exception;

class CartService
{
    protected $cartKey;
    protected $ttl = 86400; // 24 hours in seconds

    public function __construct()
    {
        $this->generateCartKey();
    }

    /**
     * Generate cart key based on authentication status
     */
    protected function generateCartKey()
    {
        try {
            // Always use user ID for authenticated users
            if (Auth::check()) {
                $this->cartKey = 'cart:user_' . Auth::id();
            } else {
                // For guests, use session ID
                $this->cartKey = 'cart:session_' . session()->getId();
            }
        } catch (Exception $e) {
            Log::error('CartService key generation error: ' . $e->getMessage());
            // Fallback to session-based cart key
            $this->cartKey = 'cart:session_' . session()->getId();
        }
    }

    /**
     * Regenerate cart key (useful after login/logout)
     */
    public function regenerateKey()
    {
        $this->generateCartKey();
    }

    /**
     * Add item to cart
     */
    public function add($productId, $quantity = 1, $price = null, $attributes = [])
    {
        try {
            $cart = $this->get();
            
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] += $quantity;
            } else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'attributes' => $attributes,
                    'added_at' => now()->timestamp
                ];
            }
            
            $this->save($cart);
            Log::info('Item added to cart', [
                'product_id' => $productId, 
                'quantity' => $quantity, 
                'cart_key' => $this->cartKey,
                'user_id' => Auth::id()
            ]);
            
            return $cart[$productId];
        } catch (Exception $e) {
            Log::error('CartService add error: ' . $e->getMessage(), [
                'product_id' => $productId,
                'cart_key' => $this->cartKey
            ]);
            throw $e;
        }
    }

    /**
     * Update item quantity
     */
    public function update($productId, $quantity)
    {
        try {
            $cart = $this->get();

            if (isset($cart[$productId])) {
                if ($quantity <= 0) {
                    unset($cart[$productId]);
                } else {
                    $cart[$productId]['quantity'] = $quantity;
                }
                $this->save($cart);
            }
            
            return $cart;
        } catch (Exception $e) {
            Log::error('CartService update error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($productId)
    {
        try {
            $cart = $this->get();
            unset($cart[$productId]);
            $this->save($cart);
            return $cart;
        } catch (Exception $e) {
            Log::error('CartService remove error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get all cart items
     */
    public function get()
    {
        try {
            // Try Redis first, fallback to session if Redis fails
            if ($this->isRedisAvailable()) {
                $cart = Redis::get($this->cartKey);
                $redisCart = $cart ? json_decode($cart, true) : [];
                
                // Also check session as fallback and merge if needed
                $sessionCart = session()->get('cart', []);
                
                // If Redis is empty but session has data, use session data
                if (empty($redisCart) && !empty($sessionCart)) {
                    $this->save($sessionCart); // Sync to Redis
                    return $sessionCart;
                }
                
                return $redisCart;
            } else {
                // Fallback to session storage
                return session()->get('cart', []);
            }
        } catch (Exception $e) {
            Log::error('CartService get error: ' . $e->getMessage());
            // Fallback to session storage
            return session()->get('cart', []);
        }
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        try {
            if ($this->isRedisAvailable()) {
                Redis::del($this->cartKey);
            }
            // Also clear from session as fallback
            session()->forget('cart');
            
            Log::info('Cart cleared', ['cart_key' => $this->cartKey, 'user_id' => Auth::id()]);
        } catch (Exception $e) {
            Log::error('CartService clear error: ' . $e->getMessage());
            // Fallback to session storage
            session()->forget('cart');
        }
    }

    /**
     * Save cart to Redis with session fallback
     */
    protected function save($cart)
    {
        try {
            if ($this->isRedisAvailable()) {
                Redis::setex($this->cartKey, $this->ttl, json_encode($cart));
                Log::debug('Cart saved to Redis', ['cart_key' => $this->cartKey, 'items_count' => count($cart)]);
            }
            // Also save to session as fallback
            session()->put('cart', $cart);
        } catch (Exception $e) {
            Log::error('CartService save error: ' . $e->getMessage());
            // Fallback to session storage only
            session()->put('cart', $cart);
        }
    }

    /**
     * Check if Redis is available
     */
    protected function isRedisAvailable()
    {
        try {
            Redis::ping();
            return true;
        } catch (Exception $e) {
            Log::warning('Redis not available, using session storage');
            return false;
        }
    }

    /**
     * Get cart count
     */
    public function count()
    {
        return count($this->get());
    }

    /**
     * Get cart total quantity
     */
    public function totalQuantity()
    {
        $cart = $this->get();
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Get cart subtotal
     */
    public function subtotal()
    {
        $cart = $this->get();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    /**
     * Check if cart has specific item
     */
    public function has($productId)
    {
        $cart = $this->get();
        return isset($cart[$productId]);
    }

    /**
     * Migrate guest cart to user cart after login
     */
    public function migrateGuestCartToUser($sessionId = null)
    {
        try {
            if (!Auth::check()) {
                return false;
            }

            $userId = Auth::id();
            $sessionId = $sessionId ?? session()->getId();
            
            $guestKey = 'cart:session_' . $sessionId;
            $userKey = 'cart:user_' . $userId;
            
            Log::info('Migrating cart from guest to user', [
                'guest_key' => $guestKey,
                'user_key' => $userKey,
                'user_id' => $userId
            ]);
            
            if ($this->isRedisAvailable()) {
                // Get guest cart from Redis
                $guestCart = Redis::get($guestKey);
                if ($guestCart) {
                    $guestCartData = json_decode($guestCart, true);
                    
                    // Get existing user cart
                    $existingUserCart = Redis::get($userKey);
                    $userCartData = $existingUserCart ? json_decode($existingUserCart, true) : [];
                    
                    // Merge carts - user cart takes precedence for existing items
                    foreach ($guestCartData as $productId => $guestItem) {
                        if (isset($userCartData[$productId])) {
                            // Keep user cart item but add guest quantity
                            $userCartData[$productId]['quantity'] += $guestItem['quantity'];
                        } else {
                            // Add guest item to user cart
                            $userCartData[$productId] = $guestItem;
                        }
                    }
                    
                    // Save merged cart to user key
                    Redis::setex($userKey, $this->ttl, json_encode($userCartData));
                    // Remove guest cart
                    Redis::del($guestKey);
                    
                    Log::info('Cart migration completed', [
                        'merged_items' => count($userCartData),
                        'user_id' => $userId
                    ]);
                }
            }
            
            // Also handle session-based cart migration
            $sessionCart = session()->get('cart', []);
            if (!empty($sessionCart)) {
                // Update cart key to user-based
                $this->cartKey = $userKey;
                
                // Get existing user cart and merge
                $existingCart = $this->get();
                foreach ($sessionCart as $productId => $sessionItem) {
                    if (isset($existingCart[$productId])) {
                        $existingCart[$productId]['quantity'] += $sessionItem['quantity'];
                    } else {
                        $existingCart[$productId] = $sessionItem;
                    }
                }
                
                $this->save($existingCart);
                session()->forget('cart');
            }
            
            // Update current cart key
            $this->cartKey = $userKey;
            return true;
            
        } catch (Exception $e) {
            Log::error('CartService migrateGuestCartToUser error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get current cart key for debugging
     */
    public function getCurrentCartKey()
    {
        return $this->cartKey;
    }
}