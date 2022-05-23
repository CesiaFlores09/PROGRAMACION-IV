<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Lovemascot</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <style>
            h5 {
                font-size: 2.25rem;
            }
            body, html {
                height: 100vh;
                width: 100%;
            }
        </style>
    </head>
    <body class="d-flex align-items-center justify-content-center">
        <div class="container container-fluid text-center fs-1 p-5 pl-10 pr-10" style="background-color: rgba(255,255,255,.5); border-radius: 10px;">
            <div class="row justify-content-center gap-4">
                <a href="{{ url('/home') }}" class="navbar-brand">
                    <img src="/storage/imagenes/logo.png" alt="Logo" width="100">
                </a>
                <a href="{{ route('login') }}" class="col-md-8 btn btn-primary">
                    <h5 class="card-title">Iniciar sesión</h5>
                </a>
                <a href="{{ route('register') }}" class="col-md-8 btn btn-primary">
                    <h5 class="card-title">Registrarse</h5>
                </a>
                <hr>
                <p class="fs-6">O</p>
                <a href="{{ route('facebook.login', 'facebook') }}" class="col-md-8 btn btn-primary flex-row justify-content-center">
                    <img src="https://www.facebook.com/images/fb_icon_325x325.png" alt="Facebook logo" class="img-fluid" style="width: 50px; float: left; border: 2px solid #ccc; border-radius: 50%;">
                    <h5 class="card-title">Iniciar sesión con Facebook</h5>
                </a>
                <hr>
                <a href="{{ route('mimascota') }}" class="col-md-8 btn btn-primary">
                    <h5 class="card-title">Para mi mascota</h5>
                </a>
            </div>
        </div>
    </body>
</html>
