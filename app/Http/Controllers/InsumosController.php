<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\ProdutosInsumos;
use Illuminate\Http\Request;
use App\Http\Requests\InsumoRequest;
use App\Models\Insumos;
use DB;

class InsumosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //PEGANDO AS CATEGORIAS, PARA LISTAR OS INSUMOS QUE ESTÃO RELACIONADOS AS CATEGORIAS ESPECIFICAS.
        $categorias = Categorias::where('categoria_id', '=', null)->with('insumos')->get();

        //AQUI MOSTRA OS INSUMOS QUE NÃO ESTÃO RELACIONADOS COM NENHUMA CATEGORIA
        $insumos = Insumos::with('categorias')->get();
        $insumos = $this->insumos_no_cat($insumos);
        return view('admin.paginas.insumos.index', compact('categorias', 'insumos'));
    }

    public function create()
    {
        $insumos    = Insumos::orderBy('id', 'DESC')->take(10)->get();
        $categorias = Categorias::where('categoria_id', '=', null)->get();
        return view('admin.paginas.insumos.criar', compact('insumos', 'categorias'));
    }

    public function store(InsumoRequest $request)
    {
        $imagem = $this->salvar_imagem($request);
        $insumo = new Insumos();
        if($imagem <> false) {
            $insumo->imagem = $imagem;
        }
        $insumo->insumo = $request->insumo;
        $insumo->preco  = str_replace(',', '.', str_replace('.', '', $request->preco));
        $insumo->categoria = $request->categoria;
        ($request->visivel == 'on') ? $insumo->visivel = 0 : $insumo->visivel = 1;
        $insumo->save();
        return redirect()->route('admin.insumos.criar')->with('success', "Insumo $request->insumo cadastrada com sucesso.");
    }

    public function edit($id)
    {
        $insumo = Insumos::find($id);
        $categorias = Categorias::where('categoria_id', '=', null)->get();
        if(isset($insumo)) {
            return view('admin.paginas.insumos.criar', compact('insumo', 'categorias'));
        } else {
            return Redirect()->back()->with('error', 'Insumo não encontrada.');
        }
    }

    public function update(InsumoRequest $request, $id)
    {
        $insumo = Insumos::find($id);
        $insumo->insumo = $request->insumo;
        $insumo->preco  = str_replace(',', '.', str_replace('.', ',', $request->preco));
        $insumo->categoria = $request->categoria;
        ($request->visivel == 'on') ? $insumo->visivel = 0 : $insumo->visivel = 1;
        $imagem = $this->salvar_imagem($request);
        if($request->hasFile('imagem')) {
            $insumo->imagem = $imagem;
        }

        $insumo->save();
        return redirect()->route('admin.insumos.editar', $id)->with('success', "Insumo ($request->insumo) atualizada com sucesso.");
    }

    public function ordem(Request $request)
    {
        $ordem = 1;
        $ids = explode(",", $request->ordem);
        foreach($ids as $id) {
            $insumo = Insumos::find($id);
            $insumo->ordem = $ordem;
            $insumo->save();
            $ordem++;
        }
        return 'success';
    }

    public function destroy($id)
    {
        //NÃO EXCLUÍ, APENAS AVISA QUE TEM RELAÇÃO COM PRODUTOS.
        $insumo = Insumos::find($id);
        $nome_insumo = $insumo->insumo;
        $count = ProdutosInsumos::select('insumo_id')->where('insumo_id', $id)->count();
        if($count > 0) {
            $autorize_id = $id;
            return redirect()->route('admin.insumos.index', compact('autorize_id'))->with('warning', "O insumo $nome_insumo, possui relação com produtos, se você excluír, todos os produtos ficaram sem esse insumo!");
        }
        $this->excluir_imagem($id);
        $insumo->delete($id);

        return redirect()->route('admin.insumos.index')->with('success', "insumo $nome_insumo excluida com sucesso!");
    }

    public function destroy_autorize($id)
    {
        $insumo = Insumos::find($id);
        $nome_insumo = $insumo->insumo;
        $this->excluir_imagem($id);
        $insumo->delete($id);
        return redirect()->route('admin.insumos.index')->with('success', "insumo $nome_insumo excluida com sucesso!");
    }

    public function salvar_imagem($request)
    {
        if ($request->hasFile('imagem') && $request->file('imagem')->isValid()) {

            $name = uniqid(date('HisYmd'));

            $extension = $request->imagem->extension();

            $nameFile = "{$name}.{$extension}";

            $upload = $request->imagem->storeAs('public/insumos', $nameFile);

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
        $imagem = Insumos::find($id);
        if($imagem->imagem <> 'default.png') {
            unlink(public_path('storage/insumos/'.$imagem->imagem));
            $imagem->update(['imagem' => 'default.png']);
        }
        return redirect()->route('admin.insumos.editar', $id)->with('success', 'Imagem Excluída');
    }

    public function ajaxinsumos(Request $request)
    {
        $insumos = Insumos::where('categoria', '=', $request->categoria)->get()->toArray();
        return Response()->json($insumos);
    }

    public function insumos_no_cat($insumos)
    {
        $del = array();
        foreach($insumos as $key => $insumo)
        {
            if(isset($insumo->categorias))
            {
                $del[] = $key;
            }
        }
        $insumos->forget($del);
        return $insumos;
    }
}