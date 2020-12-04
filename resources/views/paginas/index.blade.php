@extends('layouts.estrutura')

@section('styles')

@endsection

@section('conteudo')

    @php $url_chave = Session()->get('modo_imagem_texto') ? Session()->get('modo_imagem_texto') : null @endphp

    <div class="row">
        <div class="col-12">
            <div id="buscar">
                <input type="text" name="produto" id="produto" class="form-control form-control-lg search my-3 typeahead" placeholder="Buscar">
            </div>
        </div>
    </div>

    <h6 class="subtitle">Adicionais</h6>
    <div class="row">
        <!-- Swiper -->
        <div class="swiper-container small-slide swiper-container-horizontal">
            <div class="swiper-wrapper" style="transform: translate3d(0px, 0px, 0px);">
                @foreach($insumos as $insumo)
                <div class="swiper-slide swiper-slide-active">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <div class="row no-gutters h-100">
                                <img src="{{ asset("storage/insumos/".$insumo->imagem) }}" alt="" class="small-slide-right">
                                <div class="col-12">
                                    <a class="text-dark mb-1 mt-2 h6 d-block">{{ $insumo->insumo }} </a>
                                    <p class="text-secondary small"><div class="badge badge-warning float-left mt-1">R$ {{ $insumo->preco }}</div></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <span class="swiper-notification" aria-live="assertive" aria-atomic="true"></span>
        </div>
    </div>

    @foreach($categorias as $cat)
        <div id="{{ str_replace(" ", "", $cat->categoria) }}">

            @if($cat->produtos->count() > 0)
                <h6 class="subtitle" id="{{ str_replace(" ", "", $cat->categoria) }}">{{ $cat->categoria }}</h6>
            @endif

            @if($cat->subCategorias->count() > 0)
                @foreach($cat->subCategorias as $subcat)
                    @if($subcat->produtos->count() > 0)
                        <h6 class="subtitle" id="{{ str_replace(" ", "", $subcat->categoria) }}">{{ $subcat->categoria }}</h6>
                    @endif
                    <div class="row">
                        @foreach($subcat->produtos->where('status', '=', 'on') as $prod)
                            <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                                <div class="card shadow-sm border-0 mb-4">
                                    @if($url_chave == "imagem")
                                    <!-- LISTA DE LANCHES COM IMAGENS -->
                                    <div class="card-body" id="{{ $prod->id }}">
                                        @if($subcat->categoria == 'Lanches Gourmet')
                                            <div class="badge badge-warning float-right mt-1">
                                                ACOMPANHA FRITAS OU ONIONS
                                            </div>
                                        @endif
                                        <figure class="product-image"><img src="{{ asset('storage/produtos/'.$prod->imagem) }}" alt="" class=""></figure>
                                        <a class="text-dark mb-1 mt-2 h6 d-block">{{ $prod->produto }}</a>
                                        <p class="text-secondary small mb-2">
                                            @foreach ($prod->insumos()->orderBy('ordem', 'ASC')->get() as $insumo)
                                                {{ ($insumo->pivot->qtd > 1) ? $insumo->pivot->qtd : '' }}
                                                {{ $insumo->insumo }}
                                            @endforeach
                                        </p>
                                        <div class="row">
                                            <div class="col-6">
                                                <h5 class="text-success font-weight-normal mb-0">R$ {{ $prod->preco }}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif($url_chave == "texto" OR $url_chave == null)
                                        <!-- LISTA DE LANCHES EM TEXTO -->
                                        <div class="card-body" id="{{ $prod->id }}">
                                            @if($subcat->categoria == 'Lanches Gourmet')
                                                <div class="badge badge-warning float-left mt-1">ACOMPANHA FRITAS OU ONIONS</div><br>
                                            @endif
                                            <h5 class="text-dark font-weight-normal mb-0">{{ $prod->produto }} <div class="badge badge-dark float-right mt-1">R$ {{ $prod->preco }}</div></h5>
                                            <p class="text-secondary small mb-2">
                                                @foreach ($prod->insumos()->orderBy('ordem', 'ASC')->get() as $insumo)
                                                    @php $allinsumos[] = ($insumo->pivot->qtd > 1) ? $insumo->pivot->qtd. ' ' .$insumo->insumo : $insumo->insumo @endphp
                                                @endforeach
                                                {{ implode(', ', $allinsumos).'.' }}
                                                @php $allinsumos = [] @endphp
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @endif

            <div class="row">
                @foreach($cat->produtos->where('status', '=', 'on') as $prod)
                    <div class="col-12 col-md-6 col-lg-4 col-xl-3">
                        <div class="card shadow-sm border-0 mb-4">
                        @if($url_chave == "imagem")
                            <!-- LISTA DE LANCHES COM IMAGENS -->
                                <div class="card-body" id="{{ $prod->id }}">
                                    @if($subcat->categoria == 'Lanches Gourmet')
                                        <div class="badge badge-warning float-right mt-1">
                                            ACOMPANHA FRITAS OU ONIONS
                                        </div>
                                    @endif
                                    <figure class="product-image"><img src="{{ asset('storage/produtos/'.$prod->imagem) }}" alt="" class=""></figure>
                                    <a class="text-dark mb-1 mt-2 h6 d-block">{{ $prod->produto }}</a>
                                    <p class="text-secondary small mb-2">{{ $prod->allinsumos }}.</p>
                                    <div class="row">
                                        <div class="col-6">
                                            <h5 class="text-success font-weight-normal mb-0">R$ {{ $prod->preco }}</h5>
                                        </div>
                                    </div>
                                </div>
                        @elseif($url_chave == "texto" OR $url_chave == null)
                            <!-- LISTA DE LANCHES EM TEXTO -->
                                <div class="card-body" id="{{ $prod->id }}">
                                    @if($subcat->categoria == 'Lanches Gourmet')
                                        <div class="badge badge-warning float-left mt-1">ACOMPANHA FRITAS OU ONIONS</div><br>
                                    @endif
                                    <h5 class="text-dark font-weight-normal mb-0">{{ $prod->produto }} <div class="badge badge-dark float-right mt-1">R$ {{ $prod->preco }}</div></h5>
                                    <p class="text-secondary small mb-2">
                                        @foreach ($prod->insumos()->orderBy('ordem', 'ASC')->get() as $insumo)
                                            @php $allinsumos[] = ($insumo->pivot->qtd > 1) ? $insumo->pivot->qtd. ' ' .$insumo->insumo : $insumo->insumo @endphp
                                        @endforeach
                                        {{ implode(', ', $allinsumos).'.' }}
                                        @php $allinsumos = [] @endphp
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    @endforeach
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/typeahead.bundle.js') }}"></script>
    <script>
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
                window.location.href = '#'+item.id;
            }
        });
    </script>
@endsection