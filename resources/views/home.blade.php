@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Nuestros Productos</h1>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-md-4">
                    <div class="card">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text">Precio: ${{ $product->price }}</p>
                            <p class="card-text">Categoría: {{ $product->category ? $product->category->name : 'Sin Categoría' }}</p>
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{ $products->links() }}
    </div>
@endsection