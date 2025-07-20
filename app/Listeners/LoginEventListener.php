<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Services\CartService;
use Illuminate\Support\Facades\Log;

class LoginEventListener
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        try {
            // Store the session ID before it potentially changes
            $sessionId = session()->getId();
            
            Log::info('User logged in, migrating cart', [
                'user_id' => $event->user->id,
                'session_id' => $sessionId
            ]);
            
            // Migrate guest cart to user cart
            $this->cartService->migrateGuestCartToUser($sessionId);
            
        } catch (\Exception $e) {
            Log::error('Error migrating cart on login: ' . $e->getMessage());
        }
    }
}