<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProdutosInsumos extends Model
{
    public $table = 'produto_insumo';

    public $fillable = ['produto_id', 'insumo_id', 'qtd'];

    public $timestamps = false;
}
