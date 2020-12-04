@extends('admin.layout.estrutura')

@section('styles')
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('conteudo')

@if(isset($insumo))
    <form action="{{ route('admin.insumos.update', $insumo->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
@else
    <form action="{{ route('admin.insumos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
@endif
@php $rota_atual = Route::current()->getName() @endphp

    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-lg-6">
                @if($rota_atual=='admin.insumos.editar')
                    <h4 class="page-title">Atualizar Insumo</h4>
                @elseif($rota_atual=='admin.insumos.criar')
                    <h4 class="page-title">Cadastrar Insumo</h4>
                @endif
            </div>

            <div class="col-lg-6">
                <div class="float-left d-none d-md-block">
                    <div class="dropdown">
                        @if($rota_atual=='admin.insumos.index')
                            <a href="{{ route('admin.insumos.criar') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                                <i class="ti-pencil-alt"></i> Novo Insumo
                            </a>
                        @elseif($rota_atual=='admin.insumos.criar')
                            <a href="{{ route('admin.insumos.index') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                                <i class="dripicons-checklist"></i> Todos Insumos
                            </a>
                        @elseif($rota_atual=='admin.insumos.editar')
                            <a href="{{ route('admin.insumos.index') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                                <i class="dripicons-backspace"></i> Voltar
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            @include('componentes.msg_flash')
            <br>
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nome da insumo</label>
                        <input name="insumo" type="text" id="insumo" class="form-control" required="" value="{{ $insumo->insumo ?? '' }}" autofocus>
                    </div>

                    <div class="form-group">
                        <label>Preço do insumo</label>
                        <input name="preco" id="preco" maxlength="7" type="text" class="form-control" required="" value="{{ $insumo->preco ?? '' }}">
                    </div>

                    <hr>

                    @if($rota_atual=='admin.insumos.editar' AND $insumo->imagem != 'default.png')
                        <img src="{{ url("storage/insumos/{$insumo->imagem}") }}" width="100" alt="{{ $insumo->insumo }}">
                        <a href="{{ route('admin.insumos.del_img', $insumo->id) }}" class="btn btn-danger" onclick="return confirm('Excluír Imagem ?');">Excluir Imagem</a>
                    @else
                        <div class="form-group mb-0">
                            <label>(opcional) Selecione uma imagem para esse insumo.</label>
                            <input name="imagem" type="file" class="filestyle" accept="image/png, image/jpeg" data-input="false" data-buttonname="btn-secondary">
                        </div>
                    @endif

                    <hr>

                    <div class="form-group">
                        @if($categorias->count() <= 0) <div class="alert alert-warning"><i class="typcn typcn-warning"></i> Você precisa cadastrar as categorias</div> @endif
                        <label>Selecione a Categoria deste Insumo</label>
                        <select name="categoria" id="categoria" class="form-control select2" required>
                            <option disabled selected value=""></option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}" @if(isset($insumo->categoria) AND $cat->id == $insumo->categoria) selected  @endif>{{ $cat->categoria }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        Mostrar em Adicionais:
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input name="visivel" type="checkbox" id="switch1" switch="success" @if(isset($insumo)) {{ $insumo->visivel == 0 ? 'checked="checked"' : '' }} @endif>
                            <label for="switch1" data-on-label="ON" data-off-label="OFF"></label>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <div>
                            @if($rota_atual=='admin.insumos.editar')
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    ATUALIZAR
                                </button>
                            @elseif($rota_atual=='admin.insumos.criar')
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    CADASTRAR
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
        @if($rota_atual=='admin.insumos.criar')
            <div class="col-lg-6 mt-4">
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action active">
                        Últimos 10 insumos cadastrados
                    </a>
                    @foreach($insumos as $ins)
                        <a href="{{ route('admin.insumos.editar', $ins->id) }}" class="list-group-item list-group-item-action">R$ {{ $ins->preco. ' - '. $ins->insumo ?? '' }}</a>
                    @endforeach
                </div>
            </div> <!-- end col -->
        @endif
    </div>

    </form>
@endsection


@section('scripts')
    <script src="{{ asset('plugins/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
    <script>
        $('#preco').mask('#.##0,00', {reverse: true});
        $("#categoria").select2();
    </script>
@endsection