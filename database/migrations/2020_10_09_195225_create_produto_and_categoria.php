<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutoAndCategoria extends Migration
{

    public function up()
    {
        Schema::create('produto_categoria', function (Blueprint $table) {
            $table->integer('produto_id')->unsigned();
            $table->integer('categoria_id')->unsigned();

            $table->foreign('produto_id')
                ->references('id')
                ->on('produtos')
                ->onDelete('cascade');

            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('produto_categoria');
    }
}
