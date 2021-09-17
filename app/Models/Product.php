<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'close_at'];
    protected $appends = ['last_bid'];

    public function getLastBidAttribute()
    {
        $bid = Bid::where('product_id', $this->id)->orderBy('price', 'desc')->first();
        return $bid->price ?? $this->price;
    }
}
