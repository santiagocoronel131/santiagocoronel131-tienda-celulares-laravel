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
        // Cargamos la categoría para poder mostrar su nombre en el título
        $category = Category::findOrFail($id);
        
        // Obtenemos los productos de esa categoría
        $products = Product::where('category_id', $id)->paginate(12); // Usar 12 para 4 columnas

        // Devolvemos la nueva vista y pasamos ambas variables
        return view('products.category', compact('products', 'category'));
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
        
        // Buscamos en el nombre o en la descripción
        $products = Product::where('name', 'LIKE', "%{$query}%")
                           ->orWhere('description', 'LIKE', "%{$query}%")
                           ->paginate(12);

        // Devolvemos la nueva vista de búsqueda
        return view('products.search', compact('products'));
    }
}