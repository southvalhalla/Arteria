@extends('app')
@section('content')
@if (session('success'))
    <h6 class="alert alert-success">{{ session('success') }}</h6>
@endif
@include('products/error')

<div id="barrabuscar" class="mx-auto my-3">
    <form method="POST" class="">
        <div class="row">
            <div class="col-2 offset-2">
                <select class="form-select" name="option_search" id="option_search">
                    <option value="" selected disabled>Filtro</option>
                    <option value="id">ID</option>
                    <option value="name">Nombre</option>
                </select>
            </div>
            <div class="col-4">
                <input type="text" name="txtbuscar" id="cajabuscar" placeholder="Ingresar producto" class="form form-control">
            </div>
            <div class="col-2">
                <input type="submit" value="Buscar" class="btn btn-success" name="btnbuscar">
            </div>
        </div>
    </form>
</div>
<table class="table table-sm table-hover text-center border-secondary rounded mx-auto" style="width:75%;">

    <thead class="border table-primary">
        <tr><th colspan="8" class="text-center"><h1>LISTA DE PRODUCTOS</h1><th><a class="btn btn-primary mt-2" onclick="abrirform()">Agregar</a></th></tr>
        <tr>
            <th>ID</th>
            <th>Codigo</th>
            <th>Cant.</th>
            <th>Nombre producto</th>
            <th>Marca</th>
            <th>Categoria</th>
            <th>Descripcion</th>
            <th>precio</th>
            <th>Accion</th>

        </tr>
    </thead>
    <tbody class="border" id="tbody-products">
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->cod }}</td>
            <td>{{ $product->in_inventary }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->trademark }}</td>
            <td>{{ $product->category->category }}</td>
            <td>{{ $product->description }}</td>
            <td>{{ $product->price }}</td>
            <td class='w-auto'>
                <a href="{{ route('products.show', [$product->id]) }}"><button class="btn btn-success">Modificar</button></a> | <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$product->id}}').submit();">Eliminar</a>
            </td>
            <form id="delete-form-{{$product->id}}" action="{{ route('products.destroy', [$product->id]) }}" method="POST" style="display: none;">
                @method('DELETE')
                @csrf
            </form>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="caja_popup bg-body-secondary border border-4 border-primary-subtle rounded position-absolute top-50 start-50 translate-middle w-50 h-75" id="formregistrar">
    <form action="{{ route('products.store') }}" class="contenedor_popup" method="POST">
        @csrf
        <table>
            <tr><th colspan="2">Nuevo Producto</th></tr>
            <tr>
                <td>Producto</td>
                <td><input class="form-control" type="text" name="name" required></td>
            </tr>
            <tr>
                <td>Cantidad</td>
                <td><input class="form-control" type="number" name="in_inventary" required></td>
            </tr>
            <tr>
                <td>Marca</td>
                <td><input class="form-control" type="text" name="trademark" required></td>
            </tr>
            <tr>
                <td>Categoria</td>
                <td>
                    <select class="form-select" name="category" required>
                        <option value="" disabled selected>--SELECCIONE UNA CATEGORIA--</option>

                        @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->category}}</option>
                        @endforeach

                    </select>
                </td>
            </tr>
            <tr>
                <td>Descripcion</td>
                <td><textarea class="form-control"name="description" required></textarea></td>
            </tr>
            <tr>
                <td>Precio</td>
                <td><input class="form-control" type="number" name="price" required></td>
            </tr>
            <tr>
                <td colspan="2">
                    <a href=""><button  class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                    <input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registrar a este producto?');">
                </td>
            </tr>
        </table>
    </form>
    <script src="{{ asset('/js/main.js') }}"></script>
    <script src="{{ asset('/js/products.js') }}"></script>
</div>
@endsection
