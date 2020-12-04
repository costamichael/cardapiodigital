<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Produtos;
use Facade\FlareClient\Http\Response;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use App\Models\Categorias;
use Illuminate\Support\Facades\Storage;

class CategoriasController extends Controller
{
    private $i = 0;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $categorias = Categorias::where('categoria_id', '=', null)->orderBy('ordem', 'ASC')->with('subCategorias')->get();
        return view('admin.paginas.categorias.index', compact('categorias'));
    }

    public function create()
    {
        $categorias = Categorias::orderBy('ordem', 'ASC')->get();
        $listselect = $categorias->where('categoria_id', '=', null);
        return view('admin.paginas.categorias.criar', compact('categorias', 'listselect'));
    }

    public function store(CategoriaRequest $request)
    {
        $categoria = new Categorias();
        $categoria->fill($request->all());
        $categoria->save();

        return redirect()->route('admin.categorias.criar')->with('success', "Categoria $categoria->categoria cadastrada com sucesso.");
    }

    public function edit($id)
    {
        $categoria = Categorias::find($id);
        if(isset($categoria)) {
            return view('admin.paginas.categorias.criar', compact('categoria'));
        } else {
            return Redirect()->back()->with('error', 'Categoria não encontrada.');
        }
    }

    public function update(CategoriaRequest $request, $id)
    {
        $categoria = Categorias::find($id);
        $categoria->categoria = $request->categoria;

        $categoria->save();
        return redirect()->route('admin.categorias.editar', $id)->with('success', "Categoria $request->categoria atualizada com sucesso.");
    }

    public function ordem(Request $request)
    {
        $ordem = 1;
        $ids = explode(",", $request->ordem);
        foreach($ids as $id) {
            $categoria = Categorias::find($id);
            $categoria->ordem = $ordem;
            $categoria->save();
            $ordem++;
        }
        return 'success';
    }

    public function destroy($id)
    {
        $categoria = Categorias::find($id);
        $nome_categoria = $categoria->categoria;
        $categoria->delete($id);
        return redirect()->route('admin.categorias.index')->with('success', "Categoria $nome_categoria excluida com sucesso!");
    }

    public function ajaxcat(Request $request)
    {
        $categoria = Categorias::where('categoria_id', '=', $request->categoria)->get()->toArray();
        return Response()->json($categoria);
    }
}