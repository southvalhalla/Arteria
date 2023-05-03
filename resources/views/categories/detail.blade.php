@extends('show')

@include('categories/error')

@section('content')
<form action="{{ route('updateCategory', ['id' => $category->id]) }}" class="" method="POST">
    @method('PATCH')
    @csrf
    <table class="table table-dark table-striped table-hover d-flex justify-content-center border-secondary rounded mt-5">
        <tr>
        <th colspan="2">Categoria</th></tr>
        <tr>
            <td>id</td>
            <td><input class="form-control ms-2" type="text" name="" value="{{ $category->id }}" disabled></td>
        </tr>
        <tr>
            <td>categoria</td>
            <td><input class="form-control ms-2" type="text" name="category" value="{{ $category->category }}" required></td>
        </tr>
        <tr>
            <td>caracteristicas</td>
            <td><input class="form-control ms-2" type="text" name="characteristics" value="{{ $category->characteristics }}" required></td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="/categories" class="btn btn-danger" type="button">Cancelar</a>
                <input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registraresta categoria?');">
            </td>
        </tr>

    </table>
</form>
@endsection


