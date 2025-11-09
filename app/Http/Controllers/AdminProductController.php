<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required',
            'image_url' => 'nullable|url',
        ]);

// Crea el producto
    $product = Product::create($request->except('image_urls'));

    // Guarda las imágenes
    if ($request->has('image_urls')) {
        $urls = preg_split('/\\r\\n|\\r|\\n/', $request->image_urls);
        foreach ($urls as $index => $url) {
            if (!empty(trim($url))) {
                $product->images()->create(['image_url' => trim($url)]);
                // La primera imagen se guarda también como la principal en la tabla de productos
                if ($index == 0) {
                    $product->image_url = trim($url);
                    $product->save();
                }
            }
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Producto creado exitosamente.');
}

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Actualiza los datos principales del producto
        $product->update($request->except('new_image_urls'));

        // Añade las nuevas imágenes si se proporcionaron
        if ($request->filled('new_image_urls')) {
            $urls = preg_split('/\\r\\n|\\r|\\n/', $request->new_image_urls);
            
            foreach ($urls as $url) {
                if (!empty(trim($url))) {
                    $product->images()->create(['image_url' => trim($url)]);
                }
            }
        }
    
 $this->updateMainImage($product);

        return redirect()->route('admin.products.edit', $product->id)->with('success', 'Producto actualizado exitosamente.');
    }

     public function destroyImage(Product $product, ProductImage $image)
    {
        // Verifica que la imagen pertenezca al producto (medida de seguridad)
        if ($image->product_id !== $product->id) {
            return back()->with('error', 'Acción no autorizada.');
        }

        // Elimina el archivo de la imagen (si lo tuvieras guardado localmente, aquí iría la lógica)
        // Storage::delete($image->path);

        // Elimina el registro de la base de datos
        $image->delete();

        // Después de eliminar, comprueba si la imagen principal necesita ser actualizada
        $this->updateMainImage($product);

        return back()->with('success', 'Imagen eliminada exitosamente.');
    }

    /**
     * Función de ayuda para asegurar que el producto siempre tenga una imagen principal.
     */
    private function updateMainImage(Product $product)
    {
        // Recarga la relación de imágenes para tener la información más actualizada
        $product->load('images');

        // Si la imagen principal actual fue eliminada o no existe...
        $currentMainImageUrl = $product->image_url;
        $mainImageExists = $product->images()->where('image_url', $currentMainImageUrl)->exists();

        if (!$mainImageExists) {
            // ... asigna la primera imagen disponible como la nueva principal.
            $firstImage = $product->images()->first();
            $product->image_url = $firstImage ? $firstImage->image_url : null; // Si no quedan imágenes, la pone a null
            $product->save();
        }
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index');
    }
}
