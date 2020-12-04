<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produtos extends Model
{
    public $fillable = ['produto', 'preco', 'status', 'imagem', 'ordem'];

    const RELATIONSHIP_POST_INSUMO = 'produto_insumo';

    const RELATIONSHIP_POST_CATEGORIA = 'produto_categoria';

    public $timestamps = false;

    public function categorias()
    {
        return $this->belongsToMany(Categorias::class, self::RELATIONSHIP_POST_CATEGORIA, 'produto_id', 'categoria_id');
    }

    public function insumos()
    {
        return $this->belongsToMany(Insumos::class, self::RELATIONSHIP_POST_INSUMO, 'produto_id', 'insumo_id')->withPivot('qtd');
    }
}