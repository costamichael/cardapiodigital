<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutosCategorias extends Model
{
    public $table = 'produto_categoria';

    public $fillable = ['produto_id', 'categoria_id'];

    public $timestamps = false;

}