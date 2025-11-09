@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Finalizar Compra</h1>

    <div class="row">
        <div class="col-md-7">
            <!-- REVISIÓN DE DIRECCIÓN CON MAPA INCRUSTADO -->
            <div class="card mb-4">
                <div class="card-header"><h4>Revisá tu Ubicación</h4></div>
                <div class="card-body">
                    <p><strong>Dirección Guardada:</strong> {{ $user->address }}, {{ $user->city }}, {{ $user->province }}.</p>
                    <a href="#">Editar Dirección</a>
                    <div class="mt-3" style="height: 300px; width: 100%;">
    @php
        // Se construye la URL para el mapa, usando las coordenadas del método que creamos
        $mapQuery = urlencode("{$user->address}, {$user->city}, {$user->province}, Argentina");
        $coordinates = $user->getMapCoordinates();
    @endphp
    <iframe
        width="100%"
        height="100%"
        frameborder="0" style="border:0"
        {{-- La parte clave es el &marker={{ $coordinates }} --}}
        src="https://www.openstreetmap.org/export/embed.html?bbox=-74,-55,-53,-21&layer=mapnik&marker={{ $coordinates }}"
        allowfullscreen>
    </iframe>
</div>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <!-- Opciones de Envío -->
                <div class="card mb-4">
                    <div class="card-header"><h4>Método de Envío</h4></div>
                    <div class="card-body">
                        <!-- Radio buttons para 'delivery' y 'pickup' -->
                    </div>
                </div>

                <!-- Opciones de Pago y Formulario de Tarjeta (simulado) -->
                <div class="card">
                     <div class="card-header"><h4>Método de Pago</h4></div>
                     <div class="card-body">
                        <!-- Radio buttons para 'card', 'transfer', 'cash' -->
                        <!-- Div oculto con los inputs para la tarjeta que se muestra con JS -->
                     </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Finalizar Compra</button>
            </form>
        </div>

        <div class="col-md-5">
            <!-- Resumen de la orden (como en la respuesta anterior) -->
        </div>
    </div>
</div>
@endsection 