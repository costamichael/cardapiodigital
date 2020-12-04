<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('produto');
            $table->decimal('preco', 6, 2);
            $table->string('obs')->nullable();
            $table->string('status');
            $table->integer('ordem')->unsigned()->default(0)->nullable();
            $table->string('imagem')->nullable()->default('default.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
