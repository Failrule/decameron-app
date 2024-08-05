<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueConstraintToTipoHabitacionesAcomodacionesTable extends Migration
{
    public function up()
    {
        Schema::table('tipo_habitaciones_acomodaciones', function (Blueprint $table) {
            $table->unique(['hotel_id', 'tipo', 'acomodacion']);
        });
    }

    public function down()
    {
        Schema::table('tipo_habitaciones_acomodaciones', function (Blueprint $table) {
            $table->dropUnique(['hotel_id', 'tipo', 'acomodacion']);
        });
    }
}
