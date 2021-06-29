<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoProduct extends Model
{
    protected $fillable = [
        'product_id', 'property', 'feature'
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product','product_id');
    }
}
