@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Panel de Administración</h1>
        <p>Bienvenido al panel de administración de tu tienda online.</p>

        <h2>Productos</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Crear Producto</a>
    </div>
@endsection