<!-- resources/views/products/_product_card.blade.php -->

<div class="col-md-4 col-lg-3 mb-4">
    <div class="card h-100 shadow-sm border-0">
        <!-- Contenedor de la imagen -->
        <div class="product-card-img-container">
            <a href="{{ route('products.show', $product->id) }}">
                <img src="{{ $product->image_url ?: asset('img/placeholder.png') }}" 
                     class="product-card-img" 
                     alt="{{ $product->name }}">
            </a>
        </div>
        <div class="card-body d-flex flex-column">
            <h5 class="card-title">
                <a href="{{ route('products.show', $product->id) }}" class="text-dark">{{ $product->name }}</a>
            </h5>
            <p class="card-text text-muted small">
                {{ Str::limit($product->description, 80) }}
            </p>
            <h4 class="card-text font-weight-bold my-2">${{ number_format($product->price, 2) }}</h4>
            
            <!-- Este div empuja los botones al final de la tarjeta -->
            <div class="mt-auto">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-sm">Agregar al Carrito</button>
                </form>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-outline-secondary btn-sm">Ver Detalles</a>
            </div>
        </div>
    </div>
</div>