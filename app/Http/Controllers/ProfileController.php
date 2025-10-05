<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
     public function index()
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Obtener el carrito de la sesión
        $cart = Session::get('cart', []);

        // Pasar los datos del usuario y el carrito a la vista
        return view('profile.index', compact('user', 'cart'));
    }
}
