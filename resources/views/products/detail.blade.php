@extends('show')

@section('content')

@include('products/error')

<form action="{{ route('products.update', ['id' => $product->id]) }}" class="" method="POST">
    @method('PATCH')
    @csrf
    <table class="table table-dark table-striped table-hover d-flex justify-content-center border-secondary rounded w-auto">
        <tr><th colspan="2">Editar Producto</th></tr>
        <tr>
            <td>Producto</td>
            <td><input class="form-control" type="text" name="name" value="{{ $product->name }}" required></td>
        </tr>
        <tr>
            <td>Marca</td>
            <td><input class="form-control" type="text" name="trademark" value="{{ $product->trademark }}" required></td>
        </tr>
        <tr>
            <td>Cantidad</td>
            <td><input class="form-control" type="number" name="in_inventary" value="{{ $product->in_inventary }}" required></td>
        </tr>
        <tr>
            <td>Categoria</td>
            <td>
                <select class="form-select" name="category" required>
                    <option value="" disabled>--SELECCIONE UNA CATEGORIA--</option>
                    {{-- <option value="{{ $product->category }}" selected>{{ $product->category }}</option> --}}

                    @foreach($categories as $category)
                        <option value="{{$category->id}}" {{$category->id == $product->category_id ? 'selected' : ''}}>{{$category->category}}</option>
                    @endforeach

                </select>
            </td>
        </tr>
        <tr>
            <td>Descripcion</td>
            <td><textarea class="form-control"name="description" required>{{ $product->description }}</textarea></td>
        </tr>
        <tr>
            <td>Precio</td>
            <td><input class="form-control" type="number" name="price" value="{{ $product->price }}" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="{{route('products.index')}}"><button  class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                <input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registrar a este producto?');">
            </td>
        </tr>
    </table>
</form>
@endsection

