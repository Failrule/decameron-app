<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoHabitacionesAcomodacionesTable extends Migration
{
    /**
     * Ejecutar las migraciones.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_habitaciones_acomodaciones', function (Blueprint $table) {
            $table->id(); // Columna para el ID de la tabla
            $table->foreignId('hotel_id')->constrained('hotel')->onDelete('cascade'); // Clave foránea para la tabla hotels
            $table->string('tipo'); // Columna para el tipo
            $table->string('acomodacion'); // Columna para la acomodación
            $table->integer('cantidad'); // Columna para la cantidad
            $table->timestamps(); // Columnas para fechas de creación y actualización
            $table->unique(['hotel_id', 'tipo', 'acomodacion']);
        });
    }

    /**
     * Revertir las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_habitaciones_acomodaciones');
    }
}
