<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorias extends Model
{
    public $fillable = ['categoria', 'categoria_id', 'status', 'ordem'];

    public $timestamps = false;

    public function subCategorias()
    {
        return $this->hasMany(Categorias::class, 'categoria_id', 'id')->orderBy('ordem', 'ASC')->with('produtos');
    }

    public function insumos()
    {
        return $this->hasMany(Insumos::class, 'categoria', 'id')->orderBy('ordem', 'ASC');
    }

    public function produtos()
    {
        return $this->belongsToMany(Produtos::class, Produtos::RELATIONSHIP_POST_CATEGORIA, 'categoria_id', 'produto_id')->orderBy('ordem', 'ASC');
    }

    /*
     * SCOPEs
     */
    public function scopeCategoriaNull($query)
    {
        return $query->where('categoria_id', '=', null);
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('ordem', 'ASC');
    }

    public function scopeSubCategoria($query)
    {
        return $query->with('subCategorias','produtos');
    }
    /*
     * END SCOPEs
     */

}