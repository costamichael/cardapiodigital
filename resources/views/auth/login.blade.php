<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>Veltrix - Responsive Bootstrap 4 Admin Dashboard</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/metismenu.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/admin-estrutura-style.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">
</head>

<body>

<div class="wrapper-page">

    <div class="card overflow-hidden account-card mx-3">

        <div class="bg-primary p-4 text-white text-center position-relative">
            <h4 class="text-dark font-20 m-b-5">ADMIN DIDICAO !</h4>
            <p class="text-dark mb-4">Faça Login.</p>
            <a class="logo logo-admin"><img src="{{ asset('assets/images/logo-sm.png') }}" height="50" alt="logo"></a>
        </div>
        <div class="account-card-content">

            <form class="form-horizontal m-t-30" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label for="username">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Digite seu email" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="userpassword">Senha</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" id="password" placeholder="Digite sua senha">
                    @error('password')
                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror

                </div>

                <div class="form-group row m-t-20">
                    <div class="col-sm-6">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember" class="custom-control-input" id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="customControlInline">Lembrar Senha</label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-right">
                        <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Entrar</button>
                    </div>
                </div>

                <div class="form-group m-t-10 mb-0 row">
                    <div class="col-12 m-t-20">
                        @if (Route::has('password.request'))
                            <a class="mdi mdi-lock" href="{{ route('password.request') }}">
                                <i class="mdi mdi-lock"></i>Esqueci a Senha
                            </a>
                        @endif
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="m-t-40 text-center">
        <p>© 2020 Didicão. <i class="mdi mdi-emoticon-cool"></i> by MichaelCosta.</p>
    </div>

</div>
<!-- end wrapper-page -->


<!-- jQuery  -->
<script src="assets/js/jquery.min.js') }}"></script>
<script src="assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="assets/js/metisMenu.min.js') }}"></script>
<script src="assets/js/jquery.slimscroll.js') }}"></script>
<script src="assets/js/waves.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>

</body>

</html>