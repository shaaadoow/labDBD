<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Listas de reproducción</title>
    <link rel="stylesheet" href="{{asset('assets/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Alice&amp;display=swap">
    <link rel="stylesheet" href="{{asset('assets/fonts/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/styles.css')}}">
    
</head>

<body>
    <section>
        @auth
            @if(Auth::user()->id_tipo_usuario == 3)
                @include('includes.navbarAdmin')
            @else
                @include('includes.navbarLogin')
            @endif
        @else
            @include('includes.navbarNoLogin')
        @endauth
        <div class="row m-1" >
            <div class="col-8">
                <h1 style="color: var(--bs-light);margin: 16px;">Listas de Reproduccion</h1>
            </div>
            @auth
                <a href='{{route('vistaAgregarListaReproduccion')}}' class="col-3 m-3 btn btn-success" type = "submit" >Agregar lista de reproduccion</a>
            @endauth
        </div>
        @foreach ($listas as $lista )
            <section class="mb-5 d-lg-flex d-xl-flex justify-content-lg-center align-items-lg-center justify-content-xl-center align-items-xl-center" style="filter: grayscale(0%) saturate(72%);border-style: none;border-top-style: none;border-bottom-width: 1px;">
                <div class="row container" style="background: rgb(30,40,51);border-radius: 4px;transform-origin: center;">
                    <div class="col-8"  >
                        <h1 style="color: var(--bs-light);margin: 16px;">{{$lista->nombre_playlist}}</h1>
                        <div class="overflow-auto"> 
                            <p style="color: var(--bs-light);margin: 16px;">{{$lista->descripcion_playlist}}</p>
                        </div>
                    </div>
                    <div>
                        <a href="{{route('vistaVideoListaReproduccion',$lista->id)}}" class="col-3 btn btn-primary m-3" type = "submit" >Ver</a>
                    </div>
                </div>
            </section> 
        @endforeach
    </section>
    <script src="{{asset('assets/bootstrap/js/bootstrap.min.js')}}"></script> 
</body>

</html>