<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoHabitacionesAcomodaciones extends Model
{
    use HasFactory;

    protected $table = 'tipo_habitaciones_acomodaciones';

    protected $fillable = [
        'hotel_id',
        'tipo',
        'acomodacion',
        'cantidad',
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id');
    }
}
