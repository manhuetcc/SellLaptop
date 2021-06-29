<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusOrder extends Model
{
    public function orders()
    {
        return $this->hasMany('App\Models\Order','order_id');
    }
}
