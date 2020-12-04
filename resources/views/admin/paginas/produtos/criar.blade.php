 @extends('admin.layout.estrutura')

@section('styles')
    <link href="{{ asset('plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('conteudo')

@php $rota_atual = Route::current()->getName() @endphp

@if($rota_atual == 'admin.produtos.update')
    <form action="{{ route('admin.produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
@elseif($rota_atual == 'admin.produtos.criar')
    <form action="{{ route('admin.produtos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
@elseif($rota_atual == 'admin.produtos.editar')
    <form action="{{ route('admin.produtos.update', $produto->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
@elseif($rota_atual == 'admin.produtos.editcat')
    <form action="{{ route('admin.produtos.updcat', $produto->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
@endif

    <div class="page-title-box">
        <div class="row align-items-center">
            <div class="col-lg-6">
                @if($rota_atual=='admin.produtos.editar')
                    <h4 class="page-title">Editando o Produto: <span class="text-warning">{{ $produto->produto }}</span></h4>
                @elseif($rota_atual=='admin.produtos.criar')
                    <h4 class="page-title">Cadastrar Produto</h4>
                @elseif($rota_atual=='admin.produtos.editcat')
                    <h4 class="page-title">Trocar Categoria do Produto: <span class="text-warning">{{ $produto->produto }}</span></h4>
                    <h6>Categoria Atual: <span class="text-info">{{ $produto->categorias()->first()->categoria ?? 'Produto sem categoria' }}</span></h6>
                @endif
            </div>
        </div>
        @include('componentes.msg_flash')
        <br>
    </div>

    @if($rota_atual == 'admin.produtos.criar' or $rota_atual == 'admin.produtos.editcat')
    <div class="row">
        <div class="col-4">
            <select name="categoria" class="form-control select2 selectcategoria" id="categoria_id" onchange="$('.addcategoria').html('');">
                <option disabled selected value=""></option>
                @foreach($resultado['dados']['categorias'] as $categoria)
                    @if($categoria->categoria_id == null)
                        <option value="{{ $categoria->id }}">{{ $categoria->categoria }}</option>
                    @endif
                @endforeach
            </select>
            <div class="row">
                <div class="col-12 addcategoria">

                </div>
            </div>
        </div>
    </div>

    <hr>
    @endif

    <!-- ESCONDE TUDO PARA EDITAR A CATEGORIA -->
    @if($rota_atual != 'admin.produtos.editcat')
    <div class="row showcadastrar" @if($rota_atual=='admin.produtos.criar') style="display:none;" @endif>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Nome</label>
                        <input name="produto" type="text" class="form-control" id="produto" value="{{ $produto->produto ?? '' }}" required=""  autofocus>
                    </div>

                    <div class="form-group showinsumos">
                        <label>Insumos</label>
                        <select class="form-control select2-insumos select2" id="insumos" data-placeholder="">
                            <option disabled selected value=""></option>
                            @if(isset($produto))
                                @php $filtrainsumos = $insumos->where('categoria', '=', $produto->categorias()->first()->categoria_id ?? ''); @endphp
                                @foreach($filtrainsumos as $insumo)
                                    <option value="{{ $insumo->id }}">{{ $insumo->insumo }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Preço</label>
                        <input name="preco" id="preco" maxlength="7" type="text" class="form-control" required="" placeholder="" value="{{ $produto->preco ?? '' }}">
                    </div>

                    @if($rota_atual == 'admin.produtos.editar')
                    <div class="form-group font-24">
                        <label>
                            Categoria:
                        </label><br>
                        <a href="{{ route('admin.produtos.editcat', $produto->id) }}" class="btn-link"><i class="typcn typcn-edit font-24"></i></a>
                        <span class="text-warning">{{ $produto->categorias()->first()->categoria ?? 'Sem Categoria' }} </span>
                    </div>
                    @endif

                    <!--
                    <div class="form-group showdetalhes" style="display: none;">
                        <label>Detalhes</label>
                        <textarea name="" rows="10" id="detalhes" placeholder="Separe os detalhes com virgula!" class="form-control detalhes"></textarea>
                    </div>
                    -->

                    <hr>
                    @if($rota_atual=='admin.produtos.editar' AND $produto->imagem != 'default.png')
                            <img src="{{ url("storage/produtos/{$produto->imagem}") }}" width="100" alt="{{ $produto->produto }}">
                            <a href="{{ route('admin.produtos.del_img', $produto->id) }}" class="btn btn-danger" onclick="return confirm('Excluír Imagem ?');">Excluir Imagem</a>
                    @else
                        <div class="form-group mb-0">
                            <label>(opcional) Selecione uma imagem para esse produto.</label>
                            <input name="imagem" type="file" id="imagem" class="filestyle" accept="image/png, image/jpeg" data-input="false" data-buttonname="btn-secondary">
                        </div>
                    @endif

                    <hr>

                    <div class="form-group">
                        <input name="status" type="checkbox" id="status" switch="success" @if(isset($produto)) {{ $produto->status == 'on' ? 'checked="checked"' : '' }} @else checked @endif>
                        <label for="status" data-on-label="ON" data-off-label="OFF"></label>
                    </div>

                    <div class="form-group mb-0">
                        <div>
                            @if($rota_atual=='admin.produtos.editar')
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    ATUALIZAR
                                </button>
                            @elseif($rota_atual=='admin.produtos.criar')
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    CADASTRAR
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div> <!-- end col -->
        <div class="col-lg-4 showinsumos">
            <table class="table table-bordered table-striped" id="table_insumo_qtd">
                <thead>
                <tr>
                    <th>Insumo</th>
                    <th width="100">Qtd</th>
                </tr>
                </thead>
                <tbody>
                    <!--OPÇÕES DE QUANTIDADE-->
                    @if(isset($produto))
                        @foreach($produto->insumos()->get() as $insumo)
                            <tr>
                                <td>
                                    <a onclick="RemoveTableRow(this)" type="button"><i class="far fa-trash-alt fa-1x text-danger"></i>
                                        {{ $insumo->insumo }}
                                    </a>
                                </td>
                                <td>
                                    <select id="{{ $insumo->id }}" name="insumos[{{ $insumo->id }}]" class="form-control" required>
                                        <option value="1" {{ ($insumo->pivot->qtd  == 1)  ? 'selected' : '' }} >1</option>
                                        <option value="2" {{ ($insumo->pivot->qtd  == 2)  ? 'selected' : '' }} >2</option>
                                        <option value="3" {{ ($insumo->pivot->qtd  == 3)  ? 'selected' : '' }} >3</option>
                                        <option value="4" {{ ($insumo->pivot->qtd  == 4)  ? 'selected' : '' }} >4</option>
                                        <option value="5" {{ ($insumo->pivot->qtd  == 5)  ? 'selected' : '' }} >5</option>
                                        <option value="6" {{ ($insumo->pivot->qtd  == 6)  ? 'selected' : '' }} >6</option>
                                        <option value="7" {{ ($insumo->pivot->qtd  == 7)  ? 'selected' : '' }} >7</option>
                                        <option value="8" {{ ($insumo->pivot->qtd  == 8)  ? 'selected' : '' }} >8</option>
                                        <option value="9" {{ ($insumo->pivot->qtd  == 9)  ? 'selected' : '' }} >9</option>
                                        <option value="10"{{ ($insumo->pivot->qtd  == 10) ? 'selected' : '' }} >10</option>
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    <!-- JQUERY ADD TAMBÉM -->
                </tbody>
            </table>
        </div>
        @if($rota_atual=='admin.produtos.criar')
        <div class="col-lg-4 mt-4">
            <div class="list-group">
                <a href="#" class="list-group-item list-group-item-action active">
                    Últimos 5 produtos cadastrados
                </a>
                @foreach($resultado['dados']['produtos'] as $prod)
                    <a href="{{ route('admin.produtos.editar', $prod->id) }}" class="list-group-item list-group-item-action">R$ {{ $prod->preco. ' - ' .$prod->produto }}</a>
                @endforeach
            </div>
        </div> <!-- end col -->
        @endif

    </div>
    @endif

    @if($rota_atual=='admin.produtos.editcat')
        <button type="submit" class="btn btn-primary waves-effect waves-light mr-1 btneditcat" disabled="disabled">
            ATUALIZAR
        </button>
    @endif
    <!-- END - ESCONDE TUDO PARA EDITAR A CATEGORIA -->

    </form>
@endsection

@section('scripts')
    <script src="{{ asset('plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
    <script>
//        $.ajaxSetup({
//            headers: {
//                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//            }
//        });

        $(".select2").select2();

        $('#preco').mask('#.##0,00', {reverse: true});

        var token = $("input[name='_token']").val();

        // SELECIONAR CATEGORIA
        $(document).on("select2:select", ".selectcategoria", function() {
            var valor = $(this).val();

            if(valor > 0) {
                //////////////////////////////////////////////////////////////////////////
                /////// VERIFICA SE EXISTE SUBCATEGORIAS E CRIA SELECT COM ELAS. /////////
                //////////////////////////////////////////////////////////////////////////
                $(".showcadastrar").hide();
                $.ajax({
                    url: '{{ route("admin.categorias.ajaxcat") }}',
                    type: 'POST',
                    data: {categoria: valor, _token: token},
                    success: function (data) {
                        if(data.length > 0) {
                            var selectlist = '<hr>';
                            selectlist += '<select name="categoria" class="form-control selectcategoria selectindividual">';
                            selectlist += '<option selected>Selecione uma subcategoria</option>';
                            for(var i = 0; i < data.length; i++) {
                                selectlist += '<option value="'+data[i].id+'">'+data[i].categoria+'</option>';
                            }
                            selectlist += '</select>';
                            $('.addcategoria').html(selectlist);
                            $('.selectindividual').select2();
                            $(".btneditcat").attr("disabled", true);
                        } else {
                            $(".showcadastrar").show();
                            $(".btneditcat").removeAttr("disabled");
                        }
                    }
                });
                //////////////////////////////////////////////////////////////////////////
                /////// FIM - VERIFICA SE EXISTE SUBCATEGORIAS E CRIA SELECT COM ELAS. ///
                //////////////////////////////////////////////////////////////////////////
            } else {
                $(".showcadastrar").hide();
            }
        });

        //////////////////////////////////////////////
        // CARREGAR INSUMOS LIGADOS A CATEGORIA SELECIONADA
        $(document).on("select2:select", "#categoria_id", function() {
            $('#insumos').empty().trigger('change').select2();
            $('#table_insumo_qtd tbody').empty();
            $('#produto, #preco').val('');
            //('#detalhes').val('');
            $('#imagem').filestyle('clear');
            $.ajax({
                url: '{{ route("admin.insumos.ajaxinsumos") }}',
                type: 'POST',
                data: {categoria: $(this).val(), _token: token},
                success: function (data) {
                    if(data.length > 0) {
                        var selectinsumos = '<option selected value="">Selecione os detalhes</option>';
                        for(var i = 0; i < data.length; i++) {
                            selectinsumos += '<option value="'+data[i].id+'">'+data[i].insumo+'</option>';
                        }
                        $('#insumos').append(selectinsumos).trigger('change');
                        //$(".showdetalhes").hide();
                    } else {
                        //$(".showdetalhes").show();
                    }
                }
            });
        });
        //// FIM CARREGAR INSUMOS SE EXISTIR CATEGORIA ///////
        //////////////////////////////////////////////////////

        $(".select2-insumos").on("select2:select", function (e) {
            var select_val  = $(e.currentTarget).val();
            var select_text = $(".select2-insumos option:selected").text();

            var qtd = prompt("Quantidade", 1);
            var exist_select= $("#"+select_val).length;
            if(exist_select <= 0) {
                create_insumo(select_val, select_text, qtd);
            } else {
                $("#"+select_val).val(qtd);
            }
            $('.select2-insumos').val("").trigger('change').focus();

        });

        function create_insumo(id, select_text, qtd) {
            var newRow = $("<tr>");
            var quantidade_de_insumos = 10;
            var cols = "";
            cols += '<td><a onclick="RemoveTableRow(this)" type="button"><i class="far fa-trash-alt fa-1x text-danger"></i> &nbsp; &nbsp;</a> '+select_text+'</td>';
            cols += '<td>';
            cols += '<select id="'+id+'" name="insumos['+id+']" class="form-control" required>';
            var i;
            for(i=1; i <= quantidade_de_insumos; i++) {
                cols += '<option value="'+ i +'"';
                if(i==qtd) { cols += 'selected'; }
                cols += '>'+ i +'</option>';
            }
            cols += '</select>';
            cols += '</td>';
            newRow.append(cols);
            $("#table_insumo_qtd").append(newRow);
            return false;
        }

        RemoveTableRow = function (handler) {
            var tr = $(handler).closest('tr');

            tr.fadeOut(400, function () {
                tr.remove();
            });

            return false;
        };

    </script>
@endsection