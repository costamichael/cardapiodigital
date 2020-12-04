<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutoRequest;
use App\Models\Categorias;
use App\Models\Insumos;
use App\Models\Produtos;
use App\Models\ProdutosCategorias;
use App\Models\ProdutosInsumos;
use App\Models\SubCategorias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


use App\Services\Produtos\ProdutoServices;
use League\Flysystem\Exception;

class ProdutosController extends Controller
{
    private $prodServices;

    public $nameFile = null;

    public function __construct(ProdutoServices $services)
    {
        $this->middleware('auth');
        $this->prodServices = $services;
    }

    public function index()
    {
        $resultado = ['status' => 200];
        try {
            $resultado['dados'] = $this->prodServices->obterProdutos();
        } catch (Exception $e) {
            $resultado = [
                'dados'   => [],
                'status' => 500,
                'errors' => $e->getMessage()
            ];
        }

        return view('admin.paginas.produtos.index', compact('resultado'));
    }

    public function create()
    {
        $resultado = ['status' => 200];
        try {
            $resultado['dados'] = $this->prodServices->criarProduto();
        } catch(Exception $e) {
            $resultado = [
                'dados'      => [],
                'status'    => 500,
                'errors'    => $e->getMessage()
            ];
        }

        return view('admin.paginas.produtos.criar', compact('resultado'));
    }

    public function store(ProdutoRequest $request)
    {
        $imagem = $this->salvar_imagem($request);
        $produto = new Produtos();
        if($imagem <> false) {
            $produto->imagem = $imagem;
        }
        $produto->produto   = $request->produto;
        $produto->preco     = str_replace(',', '.', str_replace('.', '', $request->preco));
        $produto->status    = $request->status ?? 'off';
        $produto->save();

        $categoria = $this->salvar_categoria($request, $produto->id);
        $insumo = $this->salvar_insumos($request, $produto->id);
        return redirect()->route('admin.produtos.criar')->with('success', "Produto ($request->produto) cadastrado com sucesso.");
    }

    public function edit($id)
    {
        $produto                = Produtos::where('id', $id)->first();
        $categorias             = Categorias::get();
        $insumos                = Insumos::orderBy('ordem', 'ASC')->get();
        if(isset($produto)) {
            return view('admin.paginas.produtos.criar', compact('categorias', 'insumos', 'produto'));
        } else {
            return Redirect()->route('admin.produtos.index')->with('error', 'Produto não encontrada.');
        }
    }

    public function update(ProdutoRequest $request, $id)
    {
        $produto = Produtos::find($id);
        $produto->produto   = $request->produto;
        $produto->preco     = str_replace('R$ ', '', str_replace(',', '.', $request->preco));
        $produto->status    = $request->status ?? 'off';
        $imagem             = $this->salvar_imagem($request);
        if($request->hasFile('imagem')) {
            $produto->imagem = $imagem;
        }
        $produto->save();

        $insumos    = $this->salvar_insumos($request, $produto->id);
        return redirect()->route('admin.produtos.editar', $id)->with('success', "Produto ($request->produto) atualizada com sucesso.");
    }

    public function ordem(Request $request)
    {
        $ordem = 1;
        $ids = explode(",", $request->ordem);
        foreach($ids as $id) {
            $produto = Produtos::find($id);
            $produto->ordem = $ordem;
            $produto->save();
            $ordem++;
        }
        return 'success';
    }

    public function destroy($id)
    {
        $produto = Produtos::find($id);
        $nome_produto = $produto->insumo;
        $this->excluir_imagem($id);

        $produto->delete($id);
        return redirect()->route('admin.produtos.index')->with('success', "Produto $nome_produto excluído com sucesso!");
    }

    public function salvar_imagem($request)
    {
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {

            $name = uniqid(date('HisYmd'));

            $extension = $request->imagem->extension();

            $nameFile = "{$name}.{$extension}";

            $upload = $request->imagem->storeAs('public/produtos', $nameFile);

            if (!$upload) {
                return redirect()
                    ->back()
                    ->with('error', 'Falha ao fazer upload')
                    ->withInput();
            } else {
                return $nameFile;
            }
            return false;
        }
    }

    public function excluir_imagem($id)
    {
        $imagem = Produtos::find($id);
        if($imagem->imagem <> 'default.png') {
            unlink(public_path('storage/produtos/'.$imagem->imagem));
            $imagem->update(['imagem' => 'default.png']);
        }
        return redirect()->route('admin.produtos.editar', $id)->with('success', 'Imagem Excluída');
    }

    public function salvar_insumos($request, $id)
    {
        if($request->insumos == null) {
            //VERIFICAR SE FOI ENVIADO INSUMOS PARA CADASTRAR NO PRODUTO;
            return false;
        }

        $clear_insumos = ProdutosInsumos::where('produto_id', $id);
        if($clear_insumos) {
            //SE VIER DO UPDATE, APAGAR OS CADASTRADOS, E GRAVAR OS NOVOS.
            $clear_insumos->delete();
        }
        foreach($request->insumos as $id_insumo => $qtd){
            $insumos = new ProdutosInsumos();
            $insumos->produto_id = $id;
            $insumos->insumo_id  = $id_insumo;
            $insumos->qtd        = $qtd;
            $insumos->save();
        }
        return $insumos;
    }

    public function salvar_categoria($dados, $id)
    {
        $categoria = new ProdutosCategorias();
        $categoria->produto_id = $id;
        $categoria->categoria_id = $dados->categoria;
        $categoria->save();
        return $categoria;
    }

    public function editcat($id)
    {
        $produto                = Produtos::where('id', $id)->first();
        $categorias             = Categorias::get();
        if(isset($produto)) {
            return view('admin.paginas.produtos.criar', compact('categorias', 'produto'));
        } else {
            return Redirect()->route('admin.produtos.index')->with('error', 'Produto não encontrada.');
        }
    }

    public function updcat(Request $request, $id)
    {
        $produtos = Produtos::find($id);
        if(isset($produtos) AND $request->categoria > 0) {
            $produtos->categorias()->sync([$request->categoria]);
            return Redirect()->route('admin.produtos.editar', $id)->with('success', 'Categoria do produto atualizado.');
        } else {
            return Redirect()->route('admin.produtos.index')->with('error', 'Produto não encontrada.');
        }
    }
}
