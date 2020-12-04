@extends('admin.layout.estrutura')

@section('conteudo')

@php $success_ordem = request()->s ?? null @endphp

    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h4 class="page-title">
                    Categorias Cadastradas
                    <a class="btn btn-success clickordem" data-toggle="modal" data-target="#categorias">
                        Ordenar Categorias
                    </a>
                </h4>
            </div>

            <div class="col-lg-6">
                <div class="float-right d-none d-md-block">
                    <div class="dropdown">
                        <a href="{{ route('admin.categorias.criar') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                            <i class="ti-pencil-alt"></i> Nova Categoria
                        </a>
                    </div>
                </div>

                <!-- DIV PARA ORDENAR AS CATEGORIAS -->
                <div class="modal fade" id="categorias" tabindex="-1" role="dialog" aria-labelledby="categorias" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Organizar Categorias</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="col-md-12 sortable">
                                    @foreach($categorias as $cat)
                                        <div class="alert alert-primary item" id="{{ $cat->id }}">
                                            {{ $cat->categoria }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <input type="hidden" id="ordem" value="">
                            @csrf
                            <div class="modal-footer">
                                <button type="button" id="salvar" class="btn btn-primary">Salvar Ordens</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIM - DIV PARA ORDERNAR TODAS CATEGORIAS -->

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @include('componentes.msg_flash')

            @if($success_ordem == 'true')
                <div class="alert alert-success">Ordens atualizadas com sucesso.</div>
            @elseif($success_ordem == 'false')
                <div class="alert alert-success">Ocoreu um erro, tente novamente.</div>
            @endif

            @foreach($categorias as $cat)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover table-sm">
                            <thead>
                            <tr>
                                <td class="text-center" width="50">
                                    <a href="{{ route('admin.categorias.editar', $cat->id) }}"><i class="ti-marker-alt text-success"></i></a>
                                </td>
                                <td>
                                    <span class="badge badge-success font-18">
                                        {{ $cat->categoria }}
                                    </span>
                                </td>
                                <td width="30">
                                    @if($cat->subCategorias->count() <= 0)
                                    <form method="POST" action="{{ route('admin.categorias.destroy', $cat->id) }}">
                                        @csrf
                                        <button  type="submit" onclick="return confirm('EXCLUIR A CATEGORIA {{ $cat->categoria }} ?');" class="btn btn-danger">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </form>
                                    @else
                                        <!-- EXISTE SUBCATEGORIAS - NÃO PODE EXCLUIR A CATEGORIA PRINCIPAL -->
                                    @endif
                                </td>
                            </tr>
                            </thead>
                            @if($cat->subCategorias)
                            <tbody>
                            @foreach($cat->subCategorias as $subcat)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('admin.categorias.editar', $subcat->id) }}"><i class="ti-marker-alt text-warning"></i></a>
                                </td>
                                <td>
                                    <span class="badge badge-warning font-18 text-dark ml-3">
                                        {{ $subcat->categoria }}
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" action="{{ route('admin.categorias.destroy', $subcat->id) }}">
                                        @csrf
                                        <button  type="submit" onclick="return confirm('EXCLUIR A CATEGORIA {{ $subcat->categoria }} ?');" class="btn btn-danger">
                                            <i class="ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3">
                                        @if($cat->subCategorias->count() > 0)
                                            <a class="btn btn-primary clickordem" data-toggle="modal" data-target="#subcategorias_{{ $cat->id }}">
                                                Ordenar Subcategorias
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            </tfoot>
                                <!-- DIV PARA ORDENAR TODAS SUB CATEGORIAS -->
                                @if($cat)
                                    <div class="modal fade" id="subcategorias_{{ $cat->id }}" tabindex="-1" role="dialog" aria-labelledby="subcategorias_{{ $cat->id }}" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Organizar Categorias</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col-md-12 sortable">
                                                        @foreach($cat->subCategorias as $cat)
                                                            <div class="alert alert-primary item" id="{{ $cat->id }}">
                                                                {{ $cat->categoria }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <input type="hidden" class="ordem" value="">
                                                @csrf
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary salvar">Salvar Ordens</button>
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <!-- FIM - DIV PARA ORDERNAR TODAS SUB CATEGORIAS -->
                            @endif
                        </table>
                    </div>
                </div>
            </div>
            @endforeach
        <!-- { { $categorias->render() }} -->
        </div>
        <div class="col-lg-6">

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/assets/js/jquery-ui.min.js') }}"></script>
    <script type="text/javascript">

        $(function(){

            $(".sortable").sortable({
                connectWith: ".sortable",
                placeholder: 'dragHelper',
                scroll: true,
                revert: true,
                cursor: "move",
                update: function(event, ui) {
                    var cad_id_item_list = $(this).sortable('toArray').toString();
                    var input_ordenados  = $("#ordem").val(cad_id_item_list);
                    var input_ordenados2  = $(".ordem").val(cad_id_item_list);
                },
                start: function( event, ui ) {

                },
                stop: function( event, ui ) {

                }
            });


            $("#salvar").on("click", function () {
                var ids_ordenados = $("#ordem").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: '{{ route("admin.categorias.ordem") }}',
                    type: 'POST',
                    data: {ordem: ids_ordenados, _token: token},
                    success: function (data) {
                        if(data=='success') {
                            document.location.href='{{ route('admin.categorias.index') }}?s=true';
                        } else {
                            document.location.href='{{ route('admin.categorias.index') }}?s=false';
                        }
                    }
                });
            });

            $(".salvar").on("click", function () {
                var ids_ordenados = $(".ordem").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: '{{ route("admin.categorias.ordem") }}',
                    type: 'POST',
                    data: {ordem: ids_ordenados, _token: token},
                    success: function (data) {
                        if(data=='success') {
                            document.location.href='{{ route('admin.categorias.index') }}?s=true';
                        } else {
                            document.location.href='{{ route('admin.categorias.index') }}?s=false';
                        }
                    }
                });
            });

            $(".clickordem").on("click", function () {
                $("#ordem").val('');
                $(".ordem").val('');
            });

        });

    </script>
@endsection