<!DOCTYPE html>
<html lang="en" translate="no" class="{{ Session()->get('tema') ?? 'grey-theme' }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, viewport-fit=cover, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="Maxartkiller">
    <meta property="og:image" content="{{ asset('frontend/imagens/capa-site-link.png') }}"/>
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">


    <title>Cardápio Didicão</title>

    <!-- Material design icons CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/material-icons.css') }}">

    <!-- Roboto fonts CSS -->
    <link href="{{ asset('frontend/css/fontes.css') }}" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Swiper CSS -->
    <link href="{{ asset('frontend/css/swiper.min.css') }}" rel="stylesheet">

    <!-- Estrutura Style -->
    <link href="{{ asset('frontend/css/estrutura-style.css') }}" rel="stylesheet">

    <!-- Tema Style -->
    <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet">

    @yield('styles')

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">

</head>
<body>

<div class="row no-gutters vh-100 loader-screen">
    <div class="col align-self-center text-white text-center">
        <img src="{{ asset('frontend/imagens/logo.png') }}" alt="logo">
        <h1><span class="font-weight-light" style="font-family:'Arial Black';">CARDÁPIO</span></h1>
        <div class="laoderhorizontal">
        </div>
    </div>
</div>

<div class="wrapper">
    <nav id="sidebar" style="display: none;">
        <ul class="list-unstyled components" style="position: fixed;">
            <li><a class="list-group-item text-center"><b>MENU</b></a></li>
            @foreach($categorias as $cat)
                <!-- SE CATEGORIA EXISTIR PRODUTO, EXIBE A CATEGORIA NO MENU -->
                @if($cat->produtos->count() > 0)
                        <li>
                            <a href="#{{ str_replace(" ", "", $cat->categoria) }}" class="list-group-item list-group-item-action">{{ $cat->categoria }}</a>
                        </li>
                @endif
                <!-- SE A SUBCATEGORIA EXISTIR, VERIFICA SE EXISTE PRODUTO, SE EXISTIR, EXIBE A SUBCATEGORIA NO MENU, E NÃO EXIBE A CATEGORIA PAI -->
                @if($cat->subCategorias->count() > 0)
                    @foreach($cat->subCategorias as $subcat)
                        @if($subcat->produtos->count() > 0)
                            <li>
                                <a href="#{{ str_replace(" ", "", $subcat->categoria) }}" class="list-group-item list-group-item-action">{{ $subcat->categoria }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </ul>
    </nav>

    <div class="header active">
        <div class="row no-gutters">
            <div class="col-auto">
                <button class="btn btn-link text-white sidebarCollapse">
                    <img src="{{ (Session()->get('tema')=='black-theme') ? asset('frontend/imagens/menu-white.png') : asset('frontend/imagens/menu.png')  }}" alt=""><span class="new-notification"></span>
                </button>
            </div>
            <div class="col text-center"><img src="{{ (Session()->get('tema')=='black-theme') ? asset('frontend/imagens/logo-header-white.png') : asset('frontend/imagens/logo-header.png')  }}" alt="" class="header-logo"></div>
            <div class="col-auto">
                @if(Session()->get('tema')=='black-theme')
                <a href="{{ route('home.tema', 'grey-theme') }}" class="btn btn-link text-light"><span class="new-notification"></span><i class="material-icons">color_lens</i></a>
                @else
                <a href="{{ route('home.tema', 'black-theme') }}" class="btn btn-link text-dark"><span class="new-notification"></span><i class="material-icons">color_lens</i></a>
                @endif
            </div>
        </div>
    </div>
    <div class="container">
    <!-- CONTAINER -->
        @yield('conteudo')
    <!-- END CONTEINER -->
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <div class="no-gutters">
            <div class="col-auto mx-auto">
                <div class="row no-gutters justify-content-center">
                    <div class="col-auto">
                        <button class="btn btn-link-default sidebarCollapse">
                            <i class="material-icons">menu</i>
                        </button>
                    </div>
                    <!--
                    <div class="col-auto">
                        <a href="" class="btn { { $url_chave == "imagem" ? "btn-linkdefault shadow" : "" }}">
                            <i class="material-icons">collections</i>
                        </a>
                    </div>
                    <div class="col-auto">
                        <a href="" class="btn btn-link-default { { $url_chave == "texto" ? "btn-link-default shadow" : "" }}">
                            <i class="material-icons">list_alt</i>
                        </a>
                    </div>
                    -->
                    <div class="col-auto">
                        <a onclick="$('html, body').animate({scrollTop:0}, 'slow');" class="btn btn-link-default">
                            <i class="material-icons">keyboard_capslock</i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END FOOTER-->

</div>

<!-- jquery, popper and bootstrap js -->
<script src="{{ asset('frontend/js/jquery-3.3.1.min.js') }}"></script>
<script src="{{ asset('frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('frontend/js/bootstrap.min.js') }}"></script>
<!-- cookie js -->
<script src="{{ asset('frontend/js/jquery.cookie.js') }}"></script>

<!-- swiper js -->
<script src="{{ asset('frontend/js/swiper.min.js') }}"></script>

<!-- template custom js -->
<script src="{{ asset('frontend/js/main.js') }}"></script>

@yield('scripts')

<!-- page level script -->
<script>
    $(window).on('load', function() {
        /* swiper slider carousel */
        var swiper = new Swiper('.small-slide', {
            slidesPerView: 'auto',
            spaceBetween: 0,
        });

        var swiper = new Swiper('.news-slide', {
            slidesPerView: 5,
            spaceBetween: 0,
            pagination: {
                el: '.swiper-pagination',
            },
            breakpoints: {
                1024: {
                    slidesPerView: 4,
                    spaceBetween: 0,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 0,
                },
                640: {
                    slidesPerView: 2,
                    spaceBetween: 0,
                },
                320: {
                    slidesPerView: 2,
                    spaceBetween: 0,
                }
            }
        });

        /* notification view and hide */
        setTimeout(function() {
            $('.notification').addClass('active');
            setTimeout(function() {
                $('.notification').removeClass('active');
            }, 3500);
        }, 500);
        $('.closenotification').on('click', function() {
            $(this).closest('.notification').removeClass('active')
        });
    });
</script>


</body>
</html>