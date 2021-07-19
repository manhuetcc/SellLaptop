<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class AdminOrderController extends Controller
{
    public function listOrdered()
    {
        return view(
            'admin.order.Ordered',
            [
                'listOrdered' => Order::where('status_order_id', '1')
                    ->orderBy('created_at', 'desc')
                    ->get()
            ]
        );
    }

    public function listConfirmed()
    {
        return view(
            'admin.order.confirmedOrder',
            [
                'listConfirmedOrder' => Order::where('status_order_id', '2')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10)
            ]
        );
    }
    public function listCompleted()
    {
        return view(
            'admin.order.completedOrder',
            [
                'listCompletedOrder' => Order::where('status_order_id', '3')
                    ->orderBy('created_at', 'desc')
                    ->get()
            ]
        );
    }
    //xoa order
    public function delete($order_id)
    {
        Order::where('id', $order_id)->update(['status_order_id' => 4]);
        return redirect()->route('listOrdered');
    }

    public function confirmOrder($order_id)
    {
        Order::where('id', $order_id)->update(['status_order_id' => 2]);
        return redirect()->route('listOrdered');
    }
    //xac nhan da giao hang
    public function shipped($order_id)
    {
        Order::where(
            'id',
            $order_id
        )->update(['status_order_id' => 3]);
        return redirect()->route('listConfirmed');
    }
}
