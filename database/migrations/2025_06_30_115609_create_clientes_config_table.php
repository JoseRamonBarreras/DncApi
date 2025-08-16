<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_config', function (Blueprint $table) {
            $table->id();
            $table->string('logo_url')->nullable();
            $table->string('portada_url')->nullable();
            $table->text('direccion')->nullable();
            $table->decimal('ubicacion_lat', 10, 7)->nullable();
            $table->decimal('ubicacion_lng', 10, 7)->nullable();
            $table->string('whatsapp')->nullable();

            $table->unsignedBigInteger('cliente_id')->unique();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes_config');
    }
}
