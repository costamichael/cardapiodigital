<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoAndInsumo extends Migration
{

    public function up()
    {
        Schema::create('produto_insumo', function (Blueprint $table) {
            $table->integer('produto_id')->unsigned();
            $table->integer('insumo_id')->unsigned();
            $table->integer('qtd')->unsigned()->default(1);

            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos')
                ->onDelete('cascade');

            $table->foreign('insumo_id')
                ->references('id')
                ->on('insumos')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto_insumo');
    }
}
