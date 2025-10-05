@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $product->name }}</h1>
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="img-fluid">
        <p>{{ $product->description }}</p>
        <p>Precio: ${{ $product->price }}</p>
        <p>Stock: {{ $product->stock }}</p>
        <p class="card-text">Categoría: {{ $product->category ? $product->category->name : 'Sin Categoría' }}</p>
       <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success">Agregar al Carrito</button>
    </form>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Volver a Productos</a>
    </div>
@endsection