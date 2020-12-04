<?php

namespace App\Repositories\Produtos;

use App\Models\Produtos;
use App\Models\Categorias;
use App\Models\Insumos;

class ProdutoRepository
{
    private $model;

    public function __construct(Categorias $model)
    {
        $this->model = $model;
    }

    public function obterProdutos()
    {
        $categorias = $this->model
            ->query()
                ->CategoriaNull()
                ->Order()
                ->SubCategoria();
        return $categorias->get();
    }

    public function obterProduto($id)
    {
        $produtos = Produtos::find($id)->get();
        return $produtos;
    }

    public function criarProduto()
    {
        $produtos   = Produtos::orderBy('id', 'DESC')->take(10)->get();
        $categorias = Categorias::get();
        $insumos    = Insumos::get();

        return array(
                        'produtos'      => $produtos,
                        'categorias'    => $categorias,
                        'insumos'       => $insumos,
                );
    }

}