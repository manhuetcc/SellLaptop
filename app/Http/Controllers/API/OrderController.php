<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
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

    public function store(Request $request)
    {
        //
        $order = new Order;
        $order->fill([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'phone_number' => $request->phone_order,
            'address' => $request->address_order,
            'status_order_id' => $request->status_order_id
        ])->save();
        return 'complete';
    }

    public function listOrder()
    {
        $id = Auth()->id();
        $listOrder = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->join('products', 'products.id', '=', 'orders.product_id')
            ->join('status_orders', 'status_orders.id', '=', 'status_order_id')
            ->select('products.name as product_name', 'products.image as image', 'products.thumbnail', 'status_orders.name as status_name', 'orders.*')
            ->where('orders.user_id', '=', $id)
            ->orderByDesc('updated_at')
            ->get();
        $totalCost = DB::table('orders')
            ->selectRaw('sum(quantity * price) AS total')
            ->where('user_id', $id)
            ->groupBy('user_id')
            ->get();
        return response()->json([
            'listOrders' => $listOrder,
            'totalAmount' => $totalCost,
            'totalOrders' => $listOrder->count()
        ]);
    }
    public function manageOrder()
    {
        $id = Auth()->id();
        $myorder = Order::find($id);
        return $myorder;
    }
}
