<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function updateStatus(Request $request, Order $order)
{
    $request->validate(['status' => 'required|in:pending,processing,shipped,completed,cancelled']);
    $order->update(['status' => $request->status]);
    return back()->with('success', 'Estado de la orden actualizado.');
}
    public function index()
    {
        $orders = Order::all();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }
}
