<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Muestra el primer paso del checkout.
     * Si el usuario no tiene dirección, muestra el formulario para añadirla.
     * Si ya tiene, muestra las opciones de envío.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return redirect()->route('home')->with('info', 'Tu carrito está vacío.');
        }

        $user = Auth::user();

        // Si el usuario no tiene una dirección guardada, lo mandamos al formulario
        if (!$user->address) {
            return view('checkout.address_form');
        }

        // Si ya tiene dirección, le mostramos las opciones de envío
        return view('checkout.shipping_payment', compact('user', 'cart'));
    }

    /**
     * Guarda la dirección del usuario y muestra la página de revisión.
     */
    public function storeAddress(Request $request)
    {
        $validatedData = $request->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',
            'postal_code' => 'required|string|max:10',
            'department' => 'nullable|string|max:255',
            'address_type' => 'required|in:hogar,laboral',
            'delivery_instructions' => 'nullable|string',
        ]);

        $user = Auth::user();
        $user->update($validatedData);

        // Redirigimos de vuelta al checkout, que ahora detectará que ya tiene una dirección.
        return redirect()->route('checkout.index');
    }

    /**
     * Procesa la orden final.
     */
    public function processOrder(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|in:delivery,pickup',
            'payment_method' => 'required|in:card,transfer,cash',
            // Simulación de validación de tarjeta
            'card_number' => 'required_if:payment_method,card|digits:16',
            'card_holder' => 'required_if:payment_method,card|string',
            'card_expiry' => 'required_if:payment_method,card|date_format:m/y',
            'card_cvc' => 'required_if:payment_method,card|digits:3',
            'holder_dni' => 'required_if:payment_method,card|digits_between:7,8',
        ]);

        $user = Auth::user();
        $cart = Session::get('cart', []);

        // --- Cálculo de Subtotal y Total ---
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $shippingCost = 0;
        if ($request->shipping_method == 'delivery') {
            // Lógica de costo de envío por provincia (Ejemplo)
            $provinceCosts = ['Buenos Aires' => 1000, 'Córdoba' => 1500, 'Salta' => 2000];
            $shippingCost = $provinceCosts[$user->province] ?? 2500; // Un costo por defecto si la provincia no está en la lista
        }

        $total = $subtotal + $shippingCost;

        // --- Inicia Transacción ---
        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $total,
                'status' => 'pending',
                'address' => "{$user->address}, {$user->city}, {$user->province} (CP: {$user->postal_code})",
                'shipping_cost' => $shippingCost,
                'payment_method' => $request->payment_method,
            ]);

            foreach ($cart as $id => $details) {
                $product = Product::find($id);
                if ($product->stock < $details['quantity']) {
                    throw new \Exception("No hay stock suficiente para el producto: {$product->name}");
                }
                // CORRECTA
                OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id, // El ID del producto viene de la clave del array del carrito
                'quantity' => $details['quantity'],
                'unit_price' => $details['price'],
                ]);
                $product->decrement('stock', $details['quantity']);
            }
            
            DB::commit();
            Session::forget('cart');
            
            return redirect()->route('order.success', $order->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('checkout.index')->with('error', 'Error al procesar la orden: ' . $e->getMessage());
        }
    }

    // Los métodos success() y downloadTicket() que te di antes funcionan igual.
}