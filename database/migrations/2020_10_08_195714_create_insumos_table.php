<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsumosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('insumo')->index();
            $table->integer('categoria')->unsigned()->index();
            $table->decimal('preco', 7,2)->unsigned();
            $table->integer('ordem')->unsigned()->default(0);
            $table->integer('visivel')->unsigned()->default(0);
            $table->string('imagem')->default('default.png');
        });
    }

    public $timestamps = false;

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumos');
    }
}
