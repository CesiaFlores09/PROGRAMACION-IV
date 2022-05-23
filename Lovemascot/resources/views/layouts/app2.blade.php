<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body style="font-size: 1.2rem;">
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/storage/imagenes/logo.png" alt="Logo" width="70">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre style="background-color: #fafafa; margin: 0 2px; border-radius: 10px;">
                                    Para mi mascota
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" @click="mostrarFormulario('')">Adiestramiento</a>
                                    <a class="dropdown-item" href="#" @click="mostrarFormulario('')">Cuido</a>
                                </div>
                            </li>
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a href="{{ route('login') }}" class="nav-link link" style="background-color: #fafafa; margin: 0 2px; border-radius: 10px;">Iniciar sesión</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link link" style="background-color: #fafafa; margin: 0 2px; border-radius: 10px;" href="{{ route('register') }}">Registrate</a>
                                </li>
                            @endif
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    
    <script src="storage/vendors/ckeditor/ckeditor.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var editor = CKEDITOR.replace( 'editor1' );
            
            let btngetvalue = document.getElementById('getvaluebtn');
            btngetvalue.addEventListener('click', function() {
                console.log(editor.getData());
            });

            let btnsetvalue = document.getElementById('setvaluebtn');
            btnsetvalue.addEventListener('click', function() {
                let value = document.getElementById('editor2').value;
                editor.setData(value);
            });
        });
    </script>
</body>
</html>
