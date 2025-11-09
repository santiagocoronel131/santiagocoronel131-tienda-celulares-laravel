@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h4>Paso 1: Ingresa tu Domicilio de Entrega</h4></div>
                <div class="card-body">
                    <form action="{{ route('checkout.address.store') }}" method="POST">
                        @csrf
                        <!-- Campos: address, city, province, postal_code, etc. -->
                        <div class="form-group">
                            <label>Dirección (Calle y Número)</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Ciudad</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Provincia</label>
                                <input type="text" name="province" class="form-control" required>
                            </div>
                        </div>
                         <!-- Más campos como código postal, departamento, etc. -->
                        <div class="form-group">
                            <label>Tipo de Domicilio</label>
                            <select name="address_type" class="form-control">
                                <option value="hogar">Hogar</option>
                                <option value="laboral">Laboral</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Guardar y Continuar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection