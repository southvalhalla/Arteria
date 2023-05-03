<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <title>Arteria</title>
    <style>
		img {
            width: 100vw;
            height: auto;
        }
        body {
            height: 100%;
            overflow: hidden;
        }
        body {
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1;
            overflow-y: auto;
        }
    </style>
</head>
<body class="bg-black">

    @include('navbar')

    <div class="w-25 h-25 mx-auto">
        <img src="{{ asset('img/logo_negro.jpg') }}" alt="Descripción de la imagen" class="w-100 h-100 mx-auto">
    </div>

    <div class="row my-2">
        <div class="col-10 offset-1">
            <!-- <center><h1 class="display-1 text-danger ">Arteria</h1></center> -->
            <form method="POST" action="" class="text-white" >
                <div class="form-group">
                    <div class="row">
                        <div class="col-2">
                            <label class="text-center" for="doc">BUSQUEDA</label>
                        </div>
                        <div class="col-3">
                            <select name="tipo" class="form-select">
                                <option value="nombre">Nombre/Tipo</option>
                                <option value="documento">Documento/ID</option>
                            </select>
                        </div>
                        <div class="col-2">
                            <select name="selec" class="form-select">
                                <option value="usuario">Usuarios</option>
                                <option value="compras">Compras</option>
                                <option value="categorias">Categorias</option>
                                <option value="productos">Productos</option>
                            </select>
                        </div>
                        <div class="col-3">
                            <input type="text" name="doc" id="doc" class="form-control">
                        </div>
                        <div class="col-1">
                            <input class="btn btn-primary" type="submit" value="Consultar" name="btn_consultar">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
