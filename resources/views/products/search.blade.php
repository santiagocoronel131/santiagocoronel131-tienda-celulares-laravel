<!-- resources/views/products/search.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Resultados de Búsqueda para: "{{ request('query') }}"</h1>

    @if ($products->count() > 0)
        <div class="row">
            @foreach ($products as $product)
                {{-- Y una vez más, usamos el mismo componente --}}
                @include('products._product_card', ['product' => $product])
            @endforeach
        </div>

        <!-- Paginación -->
        <div class="d-flex justify-content-center">
            {{-- Importante: appends para que la paginación recuerde el término de búsqueda --}}
            {{ $products->appends(request()->query())->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="fas fa-search-minus fa-3x text-muted mb-3"></i>
            <h4>No se encontraron productos que coincidan con tu búsqueda</h4>
            <p>Prueba con otras palabras clave.</p>
        </div>
    @endif
</div>
@endsection