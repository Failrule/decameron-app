<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $table = 'hotel';

    protected $fillable = [
        'nombre',
        'direccion',
        'ciudad',
        'nit',
        'cant_habitaciones'
    ];

    public function tipoHabitacionesAcomodaciones(): HasMany
    {
        return $this->hasMany(tipoHabitacionAcomodacion::class, 'hotel_id', 'id');
    }
}
