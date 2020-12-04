<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\Insumos;
use App\Models\Produtos;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        //ESTA LISTANDO CATEGORIAS, PARA DENTRO DE CATEGORIAS LISTAR OS PRODUTOS, USANDO RELACIONAMENTOS
        $categorias = Categorias::where('categoria_id', '=', null)->orderBy('ordem', 'ASC')->with('subCategorias','produtos')->get();
        $insumos  = Insumos::where('visivel', '=', 0)->get();
        return view('paginas.index', compact('categorias', 'insumos'));
    }

    public function buscar(Request $request)
    {
        $produtos = Produtos::select('id', 'produto', 'preco')->where('produto', 'LIKE', "%{$request->term}%")->get();
        return response()->json($produtos);
    }

    public function buscarinsumo(Request $request)
    {
        $insumos = Insumos::select('id', 'insumo', 'preco')->where('insumo', 'LIKE', "%{$request->term}%")->get();
        return response()->json($insumos);
    }

    public function tema($nome_tema)
    {
        Session::forget('tema');
        Session::put('tema', $nome_tema);
        return redirect()->route('home');
    }

    public function modo_imagem_texto($modo_imagem_texto)
    {
        Session::forget('modo_imagem_texto');
        Session::put('modo_imagem_texto', $modo_imagem_texto);
        return redirect()->route('home');
    }
}