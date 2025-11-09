@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Finalizar Compra</h1>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-lg-7">
            <!-- REVISIÓN DE DIRECCIÓN CON MAPA -->
            <div class="card mb-4">
                <div class="card-header"><h4><i class="fas fa-map-marker-alt mr-2"></i>Revisá tu Ubicación</h4></div>
                <div class="card-body">
                    <p><strong>Dirección Guardada:</strong> {{ $user->address }}, {{ $user->city }}, {{ $user->province }}.</p>
                    <a href="#">Editar Dirección</a>
                    <div class="mt-3" style="height: 300px; width: 100%; border-radius: 5px;">
                        @php $coordinates = $user->getMapCoordinates(); @endphp
                        <iframe width="100%" height="100%" frameborder="0" style="border:0; border-radius: 5px;"
                            src="https://www.openstreetmap.org/export/embed.html?bbox=-74,-55,-53,-21&layer=mapnik&marker={{ $coordinates }}" allowfullscreen>
                        </iframe>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO PRINCIPAL DE CHECKOUT -->
            <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                @csrf
                <!-- OPCIONES DE ENVÍO -->
                <div class="card mb-4">
                    <div class="card-header"><h4><i class="fas fa-truck mr-2"></i>Método de Envío</h4></div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping-pickup" value="pickup" checked>
                            <label class="form-check-label" for="shipping-pickup">Retiro en el local (Gratis)</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="shipping_method" id="shipping-delivery" value="delivery">
                            <label class="form-check-label" for="shipping-delivery">Envío a domicilio</label>
                        </div>
                    </div>
                </div>

                <!-- OPCIONES DE PAGO -->
                <div class="card">
                     <div class="card-header"><h4><i class="fas fa-credit-card mr-2"></i>Método de Pago</h4></div>
                     <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment-card" value="card" checked>
                            <label class="form-check-label" for="payment-card">Tarjeta de Crédito / Débito</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment-transfer" value="transfer">
                            <label class="form-check-label" for="payment-transfer">Transferencia Bancaria</label>
                        </div>
                        <div id="payment-cash-container" class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" id="payment-cash" value="cash">
                            <label class="form-check-label" for="payment-cash">Efectivo (solo para retiro en local)</label>
                        </div>
                        
                        <!-- Formulario de Tarjeta (Oculto por defecto) -->
                        <div id="card-payment-form" class="mt-4 border-top pt-3">
                            <h5>Datos de la Tarjeta (Simulación)</h5>
                            <div class="form-group"><input type="text" name="card_number" class="form-control" placeholder="Número de Tarjeta (16 dígitos)"></div>
                            <div class="form-group"><input type="text" name="card_holder" class="form-control" placeholder="Nombre del Titular"></div>
                            <div class="form-row">
                                <div class="form-group col-md-6"><input type="text" name="card_expiry" class="form-control" placeholder="Vencimiento (MM/AA)"></div>
                                <div class="form-group col-md-6"><input type="text" name="card_cvc" class="form-control" placeholder="CVC (3 dígitos)"></div>
                            </div>
                            <div class="form-group"><input type="text" name="holder_dni" class="form-control" placeholder="DNI del Titular (7 u 8 dígitos)"></div>
                        </div>
                     </div>
                </div>

                <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Finalizar Compra</button>
            </form>
        </div>

        <div class="col-lg-5">
            <!-- RESUMEN DE LA ORDEN -->
            <div class="card sticky-top">
                <div class="card-header"><h4>Resumen de tu Orden</h4></div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @php $subtotal = 0; @endphp
                        @foreach($cart as $id => $details)
                            @php $subtotal += $details['price'] * $details['quantity']; @endphp
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    {{ $details['name'] }} <small class="text-muted">x{{ $details['quantity'] }}</small>
                                </div>
                                <span>${{ number_format($details['price'] * $details['quantity'], 2) }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <hr>
                    <p class="d-flex justify-content-between">
                        <span>Subtotal:</span>
                        <span id="subtotal">${{ number_format($subtotal, 2) }}</span>
                    </p>
                    <p class="d-flex justify-content-between">
                        <span>Costo de Envío:</span>
                        <span id="shipping-cost">$0.00</span>
                    </p>
                    <hr>
                    <h4 class="d-flex justify-content-between font-weight-bold">
                        <span>Total:</span>
                        <span id="total-cost">${{ number_format($subtotal, 2) }}</span>
                    </h4>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Referencias a los elementos del DOM
    const shippingRadios = document.querySelectorAll('input[name="shipping_method"]');
    const paymentRadios = document.querySelectorAll('input[name="payment_method"]');
    const paymentCashContainer = document.getElementById('payment-cash-container');
    const cardPaymentForm = document.getElementById('card-payment-form');

    const subtotal = {{ $subtotal }};
    const provinceCosts = {!! json_encode(['Buenos Aires' => 1000, 'Córdoba' => 1500, 'Salta' => 2000]) !!};
    const userProvince = "{{ $user->province }}";
    const defaultShippingCost = 2500;

    const shippingCostEl = document.getElementById('shipping-cost');
    const totalCostEl = document.getElementById('total-cost');

    // Función para actualizar los costos
    function updateCosts() {
        let shippingCost = 0;
        if (document.getElementById('shipping-delivery').checked) {
            shippingCost = provinceCosts[userProvince] || defaultShippingCost;
        }
        
        const total = subtotal + shippingCost;
        shippingCostEl.textContent = '$' + shippingCost.toFixed(2);
        totalCostEl.textContent = '$' + total.toFixed(2);
    }

    // Lógica para el método de envío
    shippingRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'pickup') {
                paymentCashContainer.style.display = 'block';
            } else {
                paymentCashContainer.style.display = 'none';
                if (document.getElementById('payment-cash').checked) {
                    document.getElementById('payment-card').checked = true;
                }
            }
            updateCosts();
        });
    });

    // Lógica para el método de pago
    paymentRadios.forEach(radio => {
        radio.addEventListener('change', function () {
            if (this.value === 'card') {
                cardPaymentForm.style.display = 'block';
            } else {
                cardPaymentForm.style.display = 'none';
            }
        });
    });

    // Inicializar costos al cargar la página
    updateCosts();
});
</script>
@endpush
@endsection