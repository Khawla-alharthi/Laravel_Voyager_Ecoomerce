<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    // stored in cashed memory because it is not requiered to stay in database. this is why we used redis.
    // once the order is done no need to save the cart items.
    
}
