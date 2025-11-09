<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
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
    public function showCategory($id)
   {
        // Busca la categoría por su ID. Si no la encuentra, muestra un error 404.
        $category = Category::findOrFail($id);
        
        // Busca todos los productos que pertenecen a esa categoría y los pagina.
        $products = Product::where('category_id', $id)->paginate(12);

        // Devuelve la vista de categoría, pasándole los productos y la categoría.
        return view('products.category', compact('products', 'category'));
    }
}