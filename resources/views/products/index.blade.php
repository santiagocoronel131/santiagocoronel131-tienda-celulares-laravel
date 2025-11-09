<!-- resources/views/products/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Todos los Productos</h1>

    @if ($products->count() > 0)
        <div class="row">
            @foreach ($products as $product)
                {{-- Aquí llamamos a nuestra vista parcial --}}
                @include('products._product_card', ['product' => $product])
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h4>No se encontraron productos</h4>
            <p>Intenta ajustar tu búsqueda o explora nuestras categorías.</p>
        </div>
    @endif
</div>
@endsection