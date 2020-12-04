<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Insumos extends Model
{
    public $fillable = ['insumo', 'preco', 'imagem', 'visivel', 'ordem'];

    public $timestamps = false;

    public function produtos()
    {
        return $this->belongsToMany(Produtos::class, Produtos::RELATIONSHIP_POST_INSUMO, 'insumo_id', 'produto_id');
    }

    public function categorias()
    {
        return $this->belongsto(Categorias::class, 'categoria', 'id')->orderBy('ordem', 'ASC');
    }
}