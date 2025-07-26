<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesEnvioConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_envio_config', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_envio_id');
            $table->decimal('precio_fijo', 10, 2)->nullable();
            $table->boolean('permite_entrega_domicilio')->default(false);
            $table->boolean('permite_recoger_sucursal')->default(false);

            $table->unsignedBigInteger('cliente_id')->unique();
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->foreign('tipo_envio_id')->references('id')->on('tipo_envios');
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
        Schema::dropIfExists('clientes_envio_config');
    }
}
