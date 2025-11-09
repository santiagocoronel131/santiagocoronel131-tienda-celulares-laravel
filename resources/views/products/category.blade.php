<!-- resources/views/products/category.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    {{-- El título cambiará dinámicamente --}}
    <h1 class="mb-4">Categoría: {{ $category->name ?? 'Resultados' }}</h1>

    @if ($products->count() > 0)
        <div class="row">
            @foreach ($products as $product)
                {{-- Usamos el mismo componente, ¡qué fácil! --}}
                @include('products._product_card', ['product' => $product])
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{-- Importante: appends para que la paginación recuerde la categoría --}}
            {{ $products->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
            <h4>No hay productos en esta categoría todavía</h4>
            <p>Vuelve pronto para ver las novedades.</p>
        </div>
    @endif
</div>
@endsection