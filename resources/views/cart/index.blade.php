@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Carrito de Compras</h1>
        @if (empty($cart))
            <p>El carrito está vacío.</p>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cart as $id => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>${{ $item['price'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>${{ $item['price'] * $item['quantity'] }}</td>
                            <td>
                                <form action="{{ route('cart.remove', $id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3">Total:</td>
                        <td>${{ collect($cart)->sum('price') * collect($cart)->sum('quantity') }}</td>
                    </tr>
                </tfoot>
            </table>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">Realizar Pedido</a>
        @endif
    </div>
@endsection