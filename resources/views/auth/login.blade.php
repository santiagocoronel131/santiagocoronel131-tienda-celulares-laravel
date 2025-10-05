<!-- resources/views/auth/login.blade.php -->
@extends('layouts.app')

@push('styles')
    <link href="{{ asset('css/form-styles.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="form-container">
    <form class="form" method="POST" action="{{ route('login') }}">
        @csrf

        <p class="title">Iniciar Sesión</p>
        <p class="message">Bienvenido de nuevo. Inicia sesión para continuar.</p>
                
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

        <button type="submit" class="submit">Ingresar</button>
        <p class="signin">¿No tienes una cuenta? <a href="{{ route('register') }}">Regístrate</a></p>
    </form>
</div>
@endsection