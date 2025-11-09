<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
     public function getMapCoordinates(): string
    {
        // Coordenadas [Latitud, Longitud] de las capitales de provincia de Argentina
        $provinceCoordinates = [
            'Buenos Aires' => '-34.6037,-58.3816', // CABA
            'Catamarca' => '-28.4696,-65.7852',
            'Chaco' => '-27.4606,-58.9839',
            'Chubut' => '-43.3002,-65.1023', // Rawson
            'Córdoba' => '-31.4201,-64.1888',
            'Corrientes' => '-27.4692,-58.8306',
            'Entre Ríos' => '-31.7321,-60.5238', // Paraná
            'Formosa' => '-26.1775,-58.1756',
            'Jujuy' => '-24.1858,-65.2995', // San Salvador de Jujuy
            'La Pampa' => '-36.6167,-64.2833', // Santa Rosa
            'La Rioja' => '-29.4131,-66.8557',
            'Mendoza' => '-32.8895,-68.8458',
            'Misiones' => '-27.3671,-55.8961', // Posadas
            'Neuquén' => '-38.9516,-68.0591',
            'Río Negro' => '-40.8135,-63.0008', // Viedma
            'Salta' => '-24.7821,-65.4232',
            'San Juan' => '-31.5375,-68.5364',
            'San Luis' => '-33.2950,-66.3356',
            'Santa Cruz' => '-51.6226,-69.2181', // Río Gallegos
            'Santa Fe' => '-31.6107,-60.6973',
            'Santiago del Estero' => '-27.7951,-64.2612',
            'Tierra del Fuego' => '-54.8019,-68.3030', // Ushuaia
            'Tucumán' => '-26.8083,-65.2176', // San Miguel de Tucumán
        ];

        // Busca las coordenadas para la provincia del usuario.
        // Si no la encuentra, devuelve las coordenadas de CABA como valor por defecto.
        return $provinceCoordinates[$this->province] ?? '-34.6037,-58.3816';
    }
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        // --- ¡AÑADE ESTOS CAMPOS! ---
        'address',
        'city',
        'province',
        'postal_code',
        'department',
        'address_type',
        'delivery_instructions',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
