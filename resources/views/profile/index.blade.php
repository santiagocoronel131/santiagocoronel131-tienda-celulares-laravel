@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Columna de Datos del Usuario -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Mis Datos</h4>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Nombre:</strong> {{ $user->name }}</li>
                        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
                        <li class="list-group-item"><strong>Teléfono:</strong> {{ $user->phone ?: 'No especificado' }}</li>
                        <li class="list-group-item"><strong>Dirección:</strong> {{ $user->address ?: 'No especificada' }}</li>
                        <li class="list-group-item"><strong>Rol:</strong> <span class="text-capitalize">{{ $user->role }}</span></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Columna del Resumen del Carrito -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4>Resumen del Carrito</h4>
                </div>
                <div class="card-body">
                    @if (empty($cart))
                        <p class="text-center">Tu carrito está vacío.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $total = 0; @endphp
                                @foreach ($cart as $id => $item)
                                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                    <tr>
                                        <td>{{ $item['name'] }}</td>
                                        <td>{{ $item['quantity'] }}</td>
                                        <td>${{ number_format($subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" class="text-right">Total:</th>
                                    <th>${{ number_format($total, 2) }}</th>
                                </tr>
                            </tfoot>
                        </table>
                        <a href="{{ route('cart.index') }}" class="btn btn-primary btn-block">Ver Carrito Completo</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection