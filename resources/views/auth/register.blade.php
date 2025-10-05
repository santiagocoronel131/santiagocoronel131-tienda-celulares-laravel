<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/form-styles.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="form-container">
    <form class="form" method="POST" action="{{ route('register') }}">
        @csrf <!-- Token de seguridad de Laravel -->

        <p class="title">Registrarse</p>
        <p class="message">Empieza a comprar los mejores productos.</p>

        <div class="flex">
            <label>
                <!-- Adaptado para Laravel: name, old, error -->
                <input class="input" type="text" name="name" value="{{ old('name') }}" placeholder="" required>
                <span>Nombre</span>
            </label>
        </div>
        @error('name')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label>
            <input class="input" type="text" name="phone" value="{{ old('phone') }}" placeholder="" required>
            <span>Teléfono</span>
        </label>
        @error('phone')
            <p class="error-message">{{ $message }}</p>
        @enderror
                
        <label>
            <input class="input" type="email" name="email" value="{{ old('email') }}" placeholder="" required>
            <span>Email</span>
        </label> 
        @error('email')
            <p class="error-message">{{ $message }}</p>
        @enderror
            
        <label>
            <input class="input" type="password" name="password" placeholder="" required>
            <span>Contraseña</span>
        </label>
        @error('password')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <label>
            <input class="input" type="password" name="password_confirmation" placeholder="" required>
            <span>Confirma contraseña</span>
        </label>

        <label>
            <input class="input" type="text" name="address" value="{{ old('address') }}" placeholder="" required>
            <span>Dirección</span>
        </label>
        @error('address')
            <p class="error-message">{{ $message }}</p>
        @enderror

        <button type="submit" class="submit">Registrar</button>
        <p class="signin">¿Ya tienes una cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
    </form>
</div>
@endsection