<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // get orders by user_id
    public function show($id)
    {
        $listOrdered =
            DB::table('orders')
            ->join('products', 'product_id=products.id')
            ->select('products.name', 'orders.quantity', 'orders.completed_date', 'orders.quantity' * 'orders.price')
            ->where('user_id', '$id')
            ->orderByDesc('updated_at')
            ->get();
        return $listOrdered;
    }
}
