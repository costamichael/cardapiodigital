<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriasTable extends Migration
{

    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->increments('id');
            $table->string('categoria')->index();
            $table->integer('categoria_id')->unsigned()->nullable();
            $table->integer('status')->unsigned()->default(0);
            $table->integer('ordem')->unsigned()->default(0);
        });
    }

    public function down()
    {
        Schema::dropIfExists('categorias');
    }
}
