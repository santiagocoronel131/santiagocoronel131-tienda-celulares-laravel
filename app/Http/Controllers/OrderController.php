<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function create()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index');
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->total_amount = collect($cart)->sum('price') * collect($cart)->sum('quantity');
        $order->address = 'Dirección del usuario'; // Obtener la dirección del usuario
        $order->status = 'pending';
        $order->save();

        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
            ]);
        }

        Session::forget('cart');
        return view('orders.success');
    }
}
