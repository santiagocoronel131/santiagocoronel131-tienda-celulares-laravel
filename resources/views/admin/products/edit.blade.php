@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Editar Producto</h1>
        <form method="POST" action="{{ route('admin.products.update', $product->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ $product->name }}" required>
            </div>
            <div class="form-group">
                <label for="description">Descripción</label>
                <textarea name="description" id="description" class="form-control" required>{{ $product->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="price">Precio</label>
                <input type="number" step="0.01" name="price" id="price" class="form-control" value="{{ $product->price }}" required>
            </div>
            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" name="stock" id="stock" class="form-control" value="{{ $product->stock }}" required>
            </div>
            <div class="form-group">
                <label for="category_id">Categoría</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @if ($product->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <!-- SECCIÓN DE GESTIÓN DE IMÁGENES -->
<div class="form-group">
    <label>Imágenes Actuales</label>
    @if ($product->images->isNotEmpty())
        <div class="row">
            @foreach ($product->images as $image)
                <div class="col-md-3 mb-3 text-center">
                    <img src="{{ $image->image_url }}" alt="Imagen de producto" class="img-fluid rounded mb-2" style="height: 100px; object-fit: cover;">
                    <!-- Formulario para eliminar la imagen -->
                    <form action="{{ route('admin.products.images.destroy', [$product->id, $image->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar esta imagen?')">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted">Este producto no tiene imágenes secundarias.</p>
    @endif
</div>

<div class="form-group">
    <label for="new_image_urls">Añadir Nuevas URLs de Imágenes (una por línea)</label>
    <textarea name="new_image_urls" id="new_image_urls" class="form-control" rows="4"></textarea>
    <small class="form-text text-muted">Pega aquí las URLs de las nuevas imágenes que quieras añadir. La primera URL que añadas aquí se convertirá en la nueva imagen principal si no quedan otras imágenes.</small>
</div>
            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
        </form>
    </div>
@endsection