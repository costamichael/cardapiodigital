<?php

namespace App\Services\Produtos;

use App\Repositories\Produtos\ProdutoRepository;

class ProdutoServices
{
    private $repository;

    public function __construct(ProdutoRepository $repository)
    {
        $this->repository = $repository;
    }

    public function obterProdutos()
    {
        return $this->repository->obterProdutos();
    }

    public function obterProduto()
    {
        //
    }

    public function criarProduto()
    {
        return $this->repository->criarProduto();
    }
}