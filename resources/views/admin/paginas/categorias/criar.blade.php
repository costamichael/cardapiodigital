@extends('admin.layout.estrutura')

@section('styles')
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('conteudo')

@if(isset($categoria))
    <form action="{{ route('admin.categorias.update', $categoria->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
@else
    <form action="{{ route('admin.categorias.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
@endif

@php $rota_atual = Route::current()->getName() @endphp

    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-lg-6">
                @if($rota_atual=='admin.categorias.editar')
                    <h4 class="page-title">Atualizar Categoria</h4>
                @elseif($rota_atual=='admin.categorias.criar')
                    <h4 class="page-title">Cadastrar Categoria</h4>
                @endif
            </div>
            <!--END COOL -->
            <div class="col-lg-6">
                <div class="float-left d-none d-md-block">
                    <div class="dropdown">
                        @if($rota_atual=='admin.categorias.index')
                            <a href="{{ route('admin.categorias.criar') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                                <i class="ti-pencil-alt"></i> Nova Categoria
                            </a>
                        @elseif($rota_atual=='admin.categorias.criar')
                            <a href="{{ route('admin.categorias.index') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                                <i class="dripicons-checklist"></i> Todas Categorias
                            </a>
                        @elseif($rota_atual=='admin.categorias.editar')
                            <a href="{{ route('admin.categorias.index') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                                <i class="dripicons-backspace"></i> Voltar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            <!--END COOL -->
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            @include('componentes.msg_flash')
            <br>
            <div class="card">
                <div class="card-body">
                    @if(isset($listselect) AND $listselect->count() > 0)
                    <div class="form-group showforlanches">
                        <label>Nome da categoria existente</label>
                        <select name="categoria_id" class="form-control select2 selectsubcategoria">
                            <option selected value="">Categoria Principal</option>
                            @foreach($listselect as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->categoria }}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="form-group">
                        @if($rota_atual=='admin.categorias.criar')
                            <label>Como vai se chamar a nova categoria</label>
                        @elseif($rota_atual=='admin.categorias.editar')
                            <label>Alterando nome da categoria</label>
                        @endif
                        <input name="categoria" type="text" class="form-control" required="" placeholder="" value="{{ $categoria->categoria ?? '' }}" autofocus>
                    </div>

                    <div class="form-group mb-0">
                        <div>
                            @if($rota_atual=='admin.categorias.editar')
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    ATUALIZAR
                                </button>
                            @elseif($rota_atual=='admin.categorias.criar')
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    CADASTRAR
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
        @if($rota_atual=='admin.categorias.criar')
        <div class="col-lg-6 mt-4">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    Últimas 10 categorias cadastradas
                </a>
                @foreach($categorias->take(10) as $categoria)
                    <a href="{{ route('admin.categorias.editar', $categoria->id) }}" class="list-group-item list-group-item-action">
                        @if($categoria->categoria_id != null)
                            @foreach($categorias as $cat)
                                @if($categoria->categoria_id == $cat->id) {{ $cat->categoria }} -> {{ $categoria->categoria }} @endif
                            @endforeach
                        @else
                            {{ $categoria->categoria }}
                        @endif
                    </a>
                @endforeach
            </div>
        </div> <!-- end col -->
        @endif
    </div>

    </form>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.js') }}"></script>
    <script>

        $(".selectsubcategoria").select2();

    </script>
@endsection