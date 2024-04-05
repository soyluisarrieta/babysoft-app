<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('idReferencia',20);
            $table->string('nombreProducto' ,30);
            $table->string('Talla' ,20);
            $table->integer('Cantidad');
            $table->string('Categoria' ,30);
            $table->bigInteger('Precio');
            $table->string('Foto' ,20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
