<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnvioRangosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('envio_rangos', function (Blueprint $table) {
            $table->id();
            $table->integer('km_min');
            $table->integer('km_max');
            $table->decimal('precio', 10, 2);

            $table->unsignedBigInteger('clientes_envio_config_id');
            $table->foreign('clientes_envio_config_id')->references('id')->on('clientes_envio_config')->onDelete('cascade');
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
        Schema::dropIfExists('envio_rangos');
    }
}
