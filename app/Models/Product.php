<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'category_id', 'image', 'price', 'status_product_id', 'short_desc', 'short_desc',
    ];
    public function category()
    {
        return $this->belongsTo('App\Models\Category','category_id');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function status_products()
    {
        return $this->hasMany('App\Models\StatusProduct');
    }
    public function status_order()
    {
        return $this->belongsTo('App\Models\StatusOrder','status_order_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
