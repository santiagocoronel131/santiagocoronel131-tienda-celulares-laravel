<div class="card mt-4">
    <div class="card-header">Actualizar Estado de la Orden</div>
    <div class="card-body">
        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="status">Estado</label>
                <select name="status" id="status" class="form-control">
                    <option value="pending" @if($order->status == 'pending') selected @endif>Pendiente</option>
                    <option value="processing" @if($order->status == 'processing') selected @endif>Procesando</option>
                    <option value="shipped" @if($order->status == 'shipped') selected @endif>Enviado</option>
                    <option value="completed" @if($order->status == 'completed') selected @endif>Completado</option>
                    <option value="cancelled" @if($order->status == 'cancelled') selected @endif>Cancelado</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</div>