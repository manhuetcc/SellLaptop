<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name', 'category_id', 'image', 'thumbnail', 'price', 'status_product_id', 'short_desc', 'short_desc',
    ];
    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
    public function info_products()
    {
        return $this->hasMany('App\Models\InfoProduct');
    }
    public function status_product()
    {
        return $this->belongsTo('App\Models\StatusProduct', 'status_product_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
}
