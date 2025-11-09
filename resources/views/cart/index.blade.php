@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Carrito de Compras</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (!empty($cart))
        <table class="table table-hover align-middle">
            <thead class="thead-light">
                <tr>
                    <th style="width: 50%;">Producto</th>
                    <th class="text-center">Precio</th>
                    <th class="text-center" style="width: 15%;">Cantidad</th>
                    <th class="text-center">Subtotal</th>
                    <th class="text-center">Acción</th>
                </tr>
            </thead>
            <tbody>
                @php $total = 0; @endphp
                @foreach ($cart as $id => $details)
                    @php 
                        $subtotal = $details['price'] * $details['quantity'];
                        $total += $subtotal;
                    @endphp
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ $details['image_url'] ?: asset('img/placeholder.png') }}" alt="{{ $details['name'] }}" class="img-fluid rounded" style="width: 60px; height: 60px; object-fit: cover;">
                                <strong class="ml-3">{{ $details['name'] }}</strong>
                            </div>
                        </td>
                        <td class="text-center">${{ number_format($details['price'], 2) }}</td>
                        <td class="text-center">
                            <form action="{{ route('cart.update', $id) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" value="{{ $details['quantity'] }}" min="1" class="form-control form-control-sm text-center" onchange="this.form.submit()">
                            </form>
                        </td>
                        <td class="text-center">${{ number_format($subtotal, 2) }}</td>
                        <td class="text-center">
                            <form action="{{ route('cart.remove', $id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm" title="Eliminar producto">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row mt-4 justify-content-end">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Total del Carrito</h4>
                        <div class="d-flex justify-content-between">
                            <h5>Total:</h5>
                            <h5 class="font-weight-bold">${{ number_format($total, 2) }}</h5>
                        </div>
                        <hr>
                        <a href="{{ route('checkout.index') }}" class="btn btn-primary btn-block">Proceder al Pago</a>  
                        <form action="{{ route('cart.clear') }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-block">Vaciar Carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="text-center py-5">
            <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
            <h3>Tu carrito está vacío</h3>
            <p>Parece que no has agregado nada a tu carrito todavía.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Ver Productos</a>
        </div>
    @endif
</div>
@endsection