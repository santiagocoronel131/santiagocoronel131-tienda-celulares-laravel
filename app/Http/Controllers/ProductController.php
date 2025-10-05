<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(12);
        return view('products.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }
public function VerAcesorios()
{
    $categoryId = 2; // ID de la categoría "Accesorios"
    $products = Product::where('category_id', $categoryId)->paginate(12);
    return view('products.accesorios', compact('products'));
}

public function VerCelulares()
{
    $categoryId = 1; // ID de la categoría "Celulares"
    $products = Product::where('category_id', $categoryId)->paginate(12);
    return view('products.celulares', compact('products'));
}
    public function search(Request $request)
    {
        $query = $request->input('query');
        $products = Product::where('name', 'like', '%' . $query . '%')->paginate(12);
        return view('products.index', compact('products'));
    }
}