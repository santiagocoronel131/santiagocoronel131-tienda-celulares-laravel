<?php

namespace App\Http\Controllers;

use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(12); // Obtener los productos más recientes
        return view('home', compact('products'));
    }
}
