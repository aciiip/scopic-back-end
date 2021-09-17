<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutoBidSetting extends Model
{
    protected $fillable = ['id', 'user_id', 'max_amount'];
}
