<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoBidding extends Model
{
    protected $fillable = ['id', 'user_id', 'product_id'];
}
