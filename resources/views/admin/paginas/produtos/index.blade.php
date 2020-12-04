@extends('admin.layout.estrutura')

@section('conteudo')

@php $success_ordem = request()->s ?? null @endphp

    <div class="page-title-box">
        <div class="row align-items-center">

            <div class="col-sm-6">
                <h4 class="page-title">Produtos do Cardápio</h4>
            </div>

            <div class="col-sm-6">
                <div class="float-right d-none d-md-block">
                    <div class="dropdown">
                        <a href="{{ route('admin.produtos.criar') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                            <i class="ti-pencil-alt"></i> Novo Produto
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div id="buscar">
                <input type="text" name="produto" id="produto" class="form-control form-control-lg search my-3 typeahead" placeholder="Buscar Produto">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @include('componentes.msg_flash')

            <!-- MODAL PARA ORDERNAS INSUMOS -->
            @if($success_ordem == 'true')
                <div class="alert alert-success">Ordens atualizadas com sucesso.</div>
            @elseif($success_ordem == 'false')
                <div class="alert alert-success">Ocoreu um erro, tente novamente.</div>
            @endif

            @foreach($resultado['dados'] as $cat)
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <td class="text-center" width="50"></td>
                                        <td>
                                            <span class="badge badge-warning text-dark font-18">
                                                {{ $cat->categoria }}
                                            </span>
                                        </td>
                                        <td width="150"></td>
                                    </tr>
                                </thead>
                                @if($cat->subCategorias)
                                    <tbody>
                                    @foreach($cat->subCategorias as $subcat)
                                        <tr>
                                            <td></td>
                                            <td colspan="2">
                                                <span class="badge badge-success font-18 text-dark">
                                                    {{ $subcat->categoria }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @if($subcat->produtos->count() > 1)
                                                    <a class="btn btn-primary clickordem" data-toggle="modal" data-target="#subcategorias_{{ $subcat->id }}">
                                                        Ordenar Produtos
                                                    </a>
                                                @endif

                                            <!-- DIV PARA ORDENAR TODOS OS PRODUTOS DAS SUBCATEGORIAS-->
                                                @if($subcat)
                                                    <div class="modal fade" id="subcategorias_{{ $subcat->id }}" tabindex="-1" role="dialog" aria-labelledby="subcategorias_{{ $subcat->id }}" aria-hidden="true">
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
                                                                        @foreach($subcat->produtos as $prod)
                                                                            <div class="alert alert-primary item" id="{{ $prod->id }}">
                                                                                {{ $prod->produto }}
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
                                            <!-- FIM - DIV PARA ORDERNAR TODOS OS PRODUTOS -->
                                            </td>
                                            <td colspan="2">
                                                <table class="table mb-0 table-hover table-sm">
                                                    @foreach($subcat->produtos->where('status', '!=', null) as $prod)
                                                        <tr>
                                                            <td class="text-center" width="70" id="prod_{{ $prod->id }}"><a href="{{ route('admin.produtos.editar', $prod->id) }}"><i class="ti-marker-alt"></i></a></td>
                                                            <td class="text-center" width="70">@if($prod->status == 'off' ) <span class="badge badge-danger">OFF</span> @else <span class="badge badge-success">ON</span> @endif</td>
                                                            <td>{{ $prod->produto }} - R$ {{ $prod->preco }}</td>
                                                            <td width="50">
                                                                <form method="POST" action="{{ route('admin.produtos.destroy', $prod->id) }}">
                                                                    @csrf
                                                                    <button  type="submit" onclick="return confirm('EXCLUIR O PRODUTO {{ $prod->produto }} ?');" class="btn btn-danger">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                                <br>
                                            </td>
                                        </tr>
                                    @endforeach
                                        <tr>
                                            <td width="150" class="bg-dark">
                                                @if($cat->produtos->count() > 1)
                                                    <a class="btn btn-primary clickordem" data-toggle="modal" data-target="#subcategorias_{{ $cat->id }}">
                                                        Ordenar Produtos
                                                    </a>
                                                @endif
                                            <!-- DIV PARA ORDENAR TODOS OS PRODUTOS -->
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
                                                                        @foreach($cat->produtos as $prod)
                                                                            <div class="alert alert-primary item" id="{{ $prod->id }}">
                                                                                {{ $prod->produto }}
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
                                            <!-- FIM - DIV PARA ORDERNAR TODOS OS PRODUTOS -->
                                            </td>
                                            <td colspan="2">
                                                <table class="table mb-0 table-hover table-sm">
                                                    @foreach($cat->produtos->where('status', '!=', null) as $prod)
                                                        <tr>
                                                            <td class="text-center" width="70" id="prod_{{ $prod->id }}"><a href="{{ route('admin.produtos.editar', $prod->id) }}"><i class="ti-marker-alt"></i></a></td>
                                                            <td class="text-center" width="70">@if($prod->status == 'off' ) <span class="badge badge-danger">OFF</span> @else <span class="badge badge-success">ON</span> @endif</td>
                                                            <td>{{ $prod->produto }} - R$ {{ $prod->preco }}</td>
                                                            <td width="50">
                                                                <form method="POST" action="{{ route('admin.produtos.destroy', $prod->id) }}">
                                                                    @csrf
                                                                    <button  type="submit" onclick="return confirm('EXCLUIR O PRODUTO {{ $prod->produto }} ?');" class="btn btn-danger">
                                                                        <i class="ti-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </table>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('/assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/typeahead.bundle.js') }}"></script>

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
                    var input_ordenados2  = $(".ordem").val(cad_id_item_list);
                },
                start: function( event, ui ) {

                },
                stop: function( event, ui ) {

                }
            });


            $(".salvar").on("click", function () {
                var ids_ordenados = $(".ordem").val();
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: '{{ route("admin.produtos.ordem") }}',
                    type: 'POST',
                    data: {ordem: ids_ordenados, _token: token},
                    success: function (data) {
                        if(data=='success') {
                            document.location.href='{{ route('admin.produtos.index') }}?s=true';
                        } else {
                            document.location.href='{{ route('admin.produtos.index') }}?s=false';
                        }
                    }
                });
            });

        });

        $(".clickordem").on("click", function () {
            $(".ordem").val('');
        });


        var route = "{{ url('buscar') }}";
        $('#produto').typeahead({
            source:  function (term, process) {
                return $.get(route, { term: term }, function (data) {
                    return process(data);
                });
            },
            displayText: function(item) {
                return item.produto+' - R$'+ item.preco
            },
            afterSelect: function(item) {
                this.$element[0].value = item.produto;
                window.location.href = '#prod_'+item.id;
            }
        });


        (function(document, history, location) {
            var HISTORY_SUPPORT = !!(history && history.pushState);

            var anchorScrolls = {
                ANCHOR_REGEX: /^#[^ ]+$/,
                OFFSET_HEIGHT_PX: 72,

                /**
                 * Establish events, and fix initial scroll position if a hash is provided.
                 */
                init: function() {
                    this.scrollToCurrent();
                    $(window).on('hashchange', $.proxy(this, 'scrollToCurrent'));
                    $('body').on('click', 'a', $.proxy(this, 'delegateAnchors'));
                },

                /**
                 * Return the offset amount to deduct from the normal scroll position.
                 * Modify as appropriate to allow for dynamic calculations
                 */
                getFixedOffset: function() {
                    return this.OFFSET_HEIGHT_PX;
                },

                /**
                 * If the provided href is an anchor which resolves to an element on the
                 * page, scroll to it.
                 * @param  {String} href
                 * @return {Boolean} - Was the href an anchor.
                 */
                scrollIfAnchor: function(href, pushToHistory) {
                    var match, anchorOffset;

                    if(!this.ANCHOR_REGEX.test(href)) {
                        return false;
                    }

                    match = document.getElementById(href.slice(1));

                    if(match) {
                        anchorOffset = $(match).offset().top - this.getFixedOffset();
                        $('html, body').animate({ scrollTop: anchorOffset});
                        setTimeout(function() {
                            $(match).fadeOut('fsat', function() {
                                $(this).fadeIn('fast', function() {
                                    //
                                });
                            });
                        }, 1);


                        // Add the state to history as-per normal anchor links
                        if(HISTORY_SUPPORT && pushToHistory) {
                            history.pushState({}, document.title, location.pathname + href);
                        }
                    }

                    return !!match;
                },

                /**
                 * Attempt to scroll to the current location's hash.
                 */
                scrollToCurrent: function(e) {
                    if(this.scrollIfAnchor(window.location.hash) && e) {
                        e.preventDefault();
                    }
                },

                /**
                 * If the click event's target was an anchor, fix the scroll position.
                 */
                delegateAnchors: function(e) {
                    var elem = e.target;

                    if(this.scrollIfAnchor(elem.getAttribute('href'), true)) {
                        e.preventDefault();
                    }
                }
            };

            $(document).ready($.proxy(anchorScrolls, 'init'));
        })(window.document, window.history, window.location);

    </script>
@endsection