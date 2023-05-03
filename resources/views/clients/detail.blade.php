@extends('show')
@section('content')
@include('clients/error')
<form action="{{ route('clients.update', [$client->id]) }}" class="contenedor_popup" method="POST">
    @method('PATCH')
    @csrf
    <table class="table table-dark table-striped table-hover justify-content-center border-secondary rounded w-auto">
        <tr><th colspan="2">Editar Cliente</th></tr>
        <tr>
            <td>
                <select class="form-select" name="document_type" required>
                    @foreach ($document_types as $document_type)
                        @if ($document_type->id == $client->document_type_id)
                            <option value="{{$document_type->id}}" selected>{{$document_type->document_type}}</option>
                        @else
                            <option value="{{$document_type->id}}">{{$document_type->document_type}}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td>
                <input class="form-control" type="number" name="document_number" value="{{ $client->document_number }}" placeholder="Numero de documento" required>
            </td>
        </tr>
        <tr>
            <td>
                <input class="form-control" type="text" name="names" value="{{ $client->names }}" placeholder="Nombres" required>
            </td>
            <td>
                <input class="form-control" type="text" name="lastnames" value="{{ $client->lastnames }}" placeholder="Apellidos" required>
            </td>
        </tr>
        <tr>
            <td  colspan="2">
                <input class="form-control" type="email" name="email" value="{{ $client->email }}" placeholder="Correo" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input class="form-control" type="number" name="phone" placeholder="Telefono" value="{{ $client->phone }}" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input class="form-control" type="text" name="address" placeholder="Direccion" value="{{ $client->address }}" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input class="form-control" type="text" name="city" placeholder="Ciudad" value="{{ $client->city }}" required>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="{{ url('clients') }}"><button  class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                <a href=""><input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registrar a este producto?');"></a>
            </td>
        </tr>
    </table>
</form>
@endsection
