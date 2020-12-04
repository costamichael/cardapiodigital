@extends('admin.layout.estrutura')

@section('conteudo')

@php $success_ordem = request()->s ?? null @endphp

    <div class="page-title-box">
        <div class="row align-items-center">

            <div class="col-lg-6">
                <h4 class="page-title">Insumos Cadastrados</h4>
            </div>

            <div class="col-lg-6">
                <div class="float-right d-none d-md-block">
                    <div class="dropdown">
                        <a href="{{ route('admin.insumos.criar') }}" class="btn btn-primary dropdown-toggle arrow-none waves-effect waves-light">
                            <i class="ti-pencil-alt"></i> Novo Insumo
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div id="buscar">
                <input type="text" name="insumo" id="insumo" class="form-control form-control-lg search my-3 typeahead" placeholder="Buscar Insumo">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            @include('componentes.msg_flash')

            <!-- ALERT - MODAL PARA ORDERNAS INSUMOS -->
            @if($success_ordem == 'true')
                <div class="alert alert-success">Ordens atualizadas com sucesso.</div>
            @elseif($success_ordem == 'false')
                <div class="alert alert-success">Ocoreu um erro, tente novamente.</div>
            @endif
            <!-- ALERT - MODAL PARA ORDERNAS INSUMOS -->

            @php $autorize_id = request()->autorize_id ?? null @endphp
            @if($autorize_id)
                <form method="POST" action="{{ route('admin.insumos.destroy_autorize', $autorize_id) }}">
                    @csrf
                    <button  type="submit" onclick="return confirm('O INSUMO SERÁ REMOVIDO DE TODOS OS PRODUTOS QUE CONTENHA ELE!');" class="btn btn-danger">
                        <i class="ti-trash"></i> Excluír mesmo assim
                    </button>
                </form>
                <hr>
            @endif

            @if($insumos->count() > 0)
            <!-- AQUI EXIBE OS INSUMOS QUE NÃO ESTÁ ATRELADO A NENHUMA CATEGORIA -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table mb-0 table-hover table-sm">
                                <tbody>
                                <tr>
                                    <td colspan="5"><span class="badge badge-danger font-18">INSUMOS SEM CATEGORIA</span></td>
                                </tr>
                                <tr>
                                    <th width="60">Editar</th>
                                    <th width="100">Preço</th>
                                    <th width="100"><small>Em Adicionais</small></th>
                                    <th>Nome</th>
                                    <th width="30">Excluir</th>
                                </tr>
                                @foreach($insumos as $ins)
                                    <tr>
                                        <td class="text-center" id="insumo_{{ $ins->id }}"><a href="{{ route('admin.insumos.editar', $ins->id) }}"><i class="ti-marker-alt"></i></a></td>
                                        <td>R$ {{ $ins->preco }}</td>
                                        <td class="text-center">@if($ins->visivel==1) <span class="badge badge-danger">Não</span> @else <span class="badge badge-success">Sim</span> @endif</td>
                                        <td>{{ $ins->insumo }}</td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.insumos.destroy', $ins->id) }}">
                                                @csrf
                                                <button  type="submit" onclick="return confirm('EXCLUIR ESSE INSUMO {{ $ins->insumo }} ?');" class="btn btn-danger">
                                                    <i class="ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
            <!-- FIM - AQUI EXIBE OS INSUMOS QUE NÃO ESTÁ ATRELADO A NENHUMA CATEGORIA -->

            @foreach($categorias as $cat)
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table mb-0 table-hover table-sm">
                            <thead>
                                <tr>
                                    <td colspan="5">
                                        <span class="badge badge-warning font-24 text-dark">{{ $cat->categoria }}</span>
                                    </td>
                                </tr>
                            </thead>

                            @if($cat->insumos->count() > 0)
                            <tbody>
                                <tr>
                                    <th width="60">Editar</th>
                                    <th width="100">Preço</th>
                                    <th width="100"><small>Em Adicionais</small></th>
                                    <th>Nome</th>
                                    <th width="30">Excluir</th>
                                </tr>
                                @foreach($cat->insumos as $ins)
                                <tr>
                                    <td class="text-center" id="insumo_{{ $ins->id }}"><a href="{{ route('admin.insumos.editar', $ins->id) }}"><i class="ti-marker-alt"></i></a></td>
                                    <td>R$ {{ $ins->preco }}</td>
                                    <td class="text-center">@if($ins->visivel==1) <span class="badge badge-danger">Não</span> @else <span class="badge badge-success">Sim</span> @endif</td>
                                    <td>{{ $ins->insumo }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('admin.insumos.destroy', $ins->id) }}">
                                            @csrf
                                            <button  type="submit" onclick="return confirm('EXCLUIR ESSE INSUMO {{ $ins->insumo }} ?');" class="btn btn-danger">
                                                <i class="ti-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="5">
                                        @if($cat->insumos->count() > 0)
                                            <a class="btn btn-primary clickordem" data-toggle="modal" data-target="#insumo_{{ $cat->id }}">
                                                <i class="typcn typcn-th-list-outline"></i> Ordenar Insumos
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                                <!-- ALERT MODAL PARA ORDERNAS INSUMOS -->
                                <div class="modal fade" id="{{ $cat->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    @foreach($cat->insumos as $insumo)
                                                        <div class="alert alert-primary item" id="{{ $insumo->id }}">
                                                            {{ $insumo->insumo }}
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
                                <!-- FIM DE MODAL PARA ORDENAR INSUMOS -->
                            </tbody>
                            @else
                            <tfooter>
                                <tr>
                                    <td>Nenhum Insumo cadastro nessa categoria</td>
                                </tr>
                            </tfooter>
                            @endif

                        </table>
                    </div>
                </div>
            </div>
            @endforeach

            <!--{ { $insumos->render() }} -->
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
                    url: '{{ route("admin.insumos.ordem") }}',
                    type: 'POST',
                    data: {ordem: ids_ordenados, _token: token},
                    success: function (data) {
                        if(data=='success') {
                            document.location.href='{{ route('admin.insumos.index') }}?s=true';
                        } else {
                            document.location.href='{{ route('admin.insumos.index') }}?s=false';
                        }
                    }
                });
            });

        });

        $(".clickordem").on("click", function () {
            $(".ordem").val('');
        });


        var route = "{{ url('buscarinsumo') }}";
        $('#insumo').typeahead({
            source:  function (term, process) {
                return $.get(route, { term: term }, function (data) {
                    return process(data);
                });
            },
            displayText: function(item) {
                return item.insumo+' - R$'+ item.preco
            },
            afterSelect: function(item) {
                this.$element[0].value = item.insumo;
                window.location.href = '#insumo_'+item.id;
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