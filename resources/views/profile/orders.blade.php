<!-- resources/views/profile/orders.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Mis Órdenes</h1>

    @if($orders->isEmpty())
        <div class="text-center py-5">
            <i class="fas fa-history fa-3x text-muted mb-3"></i>
            <h4>No has realizado ninguna orden todavía.</h4>
            <p>Explora nuestros productos y empieza a comprar.</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Ver Productos</a>
        </div>
    @else
        <div class="accordion" id="ordersAccordion">
            @foreach($orders as $order)
                <div class="card">
                    <div class="card-header" id="heading{{ $order->id }}">
                        <h2 class="mb-0 d-flex justify-content-between align-items-center">
                            <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapse{{ $order->id }}" aria-expanded="true" aria-controls="collapse{{ $order->id }}">
                                <span class="font-weight-bold">Orden #{{ $order->id }}</span> - {{ $order->created_at->format('d/m/Y') }}
                            </button>
                            <span class="badge badge-info p-2">{{ ucfirst($order->status) }}</span>
                            <span class="font-weight-bold">${{ number_format($order->total_amount, 2) }}</span>
                        </h2>
                    </div>

                    <div id="collapse{{ $order->id }}" class="collapse @if($loop->first) show @endif" aria-labelledby="heading{{ $order->id }}" data-parent="#ordersAccordion">
                        <div class="card-body">
                            <p><strong>Fecha de la Orden:</strong> {{ $order->created_at->format('d \d\e F \d\e Y, H:i') }}</p>
                            <p><strong>Dirección de Envío:</strong> {{ $order->address }}</p>
                            <p><strong>Método de Pago:</strong> {{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</p>
                            
                            <h5 class="mt-4">Productos en esta orden:</h5>
                            <ul class="list-group">
                                @foreach($order->items as $item)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            {{ $item->product->name ?? 'Producto no disponible' }}
                                            <br>
                                            <small class="text-muted">Cantidad: {{ $item->quantity }} x ${{ number_format($item->unit_price, 2) }}</small>
                                        </div>
                                        <span class="font-weight-bold">${{ number_format($item->quantity * $item->unit_price, 2) }}</span>
                                    </li>
                                @endforeach
                            </ul>
                            <div class="text-right mt-3">
                                <a href="{{ route('orders.ticket', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-download mr-1"></i> Descargar Ticket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection