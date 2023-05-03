@extends('app')

@section('content')

@if (session('success'))
    <h6 class="alert alert-success">{{ session('success') }}</h6>
@endif

@include('categories/error')

<div id="barrabuscar" class="mx-auto my-3">
    <form method="POST" class="">
        <div class="row">
            <div class="col-4 offset-3">
                <input type="text" name="txtbuscar" id="cajabuscar" placeholder="Ingresar categoria" class="form form-control">
            </div>
            <div class="col-2">
                <input type="submit" value="Buscar" class="btn btn-success" name="btnbuscar">
            </div>
        </div>
    </form>
</div>
<table class="table table-sm table-hover text-center border-secondary rounded mx-auto" style="width:75%;">
    <thead class="border table-primary">
        <tr>
            <th colspan="3" class="text-center w-auto">
                <h1>LISTA DE CATEGORIAS</h1>
            </th>
            <th><a class="btn btn-primary mt-2" onclick="abrirform()">Agregar</a></th>
        </tr>
        <tr>
            <th>ID</th>
            <th>Nombre Categoria</th>
            <th>caracteristicas</th>
            <th>Accion</th>

        </tr>
    </thead>
    <tbody class="border" id="tbody-categories">
        @foreach ($categories as $category)
        <tr>
            <td>{{ $category->id }}</td>
            <td>{{ $category->category }}</td>
            <td>{{ $category->characteristics }}</td>
            <td class='w-auto'>
                <a href="{{ route('showCategory', [$category->id]) }}"><button class="btn btn-success">Modificar</button></a> | <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$category->id}}').submit();">Eliminar</a>
            </td>
            <form id="delete-form-{{$category->id}}" action="{{ route('destroyCategory', [$category->id]) }}" method="POST" style="display: none;">
                @method('DELETE')
                @csrf
            </form>
        </tr>
        @endforeach
    </tbody>

</table>
<script src="{{ asset('js/main.js') }}"></script>
<div class="caja_popup bg-body-secondary border border-4 border-primary-subtle rounded position-absolute top-50 start-50 translate-middle" style="width:35%; height:35%;" id="formregistrar">
    <form action="{{ route('newCategory') }}" class="contenedor_popup" method="POST">
        @csrf
        <table>
            <tr>
            <th colspan="2">Categoria</th>
            </tr>
            <tr>
                <td>categoria</td>
                <td><input class="form-control ms-2" type="text" id="category" name="category" required></td>
            </tr>
            <tr>
                <td>caracteristicas</td>
                <td><input class="form-control ms-2" type="text" id="characteristics" name="characteristics" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <button class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button>
                    <input class="btn btn-success" id="submitBtn" type="submit" name="btnregistrar" value="Registrar">
                </td>
            </tr>

        </table>
    </form>
</div>
<script src="{{ asset('js/categories.js') }}"></script>

@endsection
