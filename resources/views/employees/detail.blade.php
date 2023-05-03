@extends('show')
@section('content')
@include('employees/error')
<form action="{{route('employees.update', [$employee->id])}}" class="contenedor_popup" method="POST">
    @method('PATCH')
    @csrf
    <table class="table table-dark table-striped table-hover justify-content-center border-secondary rounded w-auto">
        <tr><th colspan="2">Editar Empleado</th></tr>
        <tr>
            <td>
                <select class="form-select" name="document_type_id" required>
                    <option value="" disabled>Tipo de documento</option>
                    @foreach ($document_types as $document_type)
                        @if ($document_type->id == $employee->document_type_id)
                            <option value="{{$document_type->id}}" selected>{{$document_type->document_type}}</option>
                        @else
                            <option value="{{$document_type->id}}">{{$document_type->document_type}}</option>
                        @endif
                    @endforeach
                </select>
            </td>
            <td>
                <input class="form-control" type="number" name="document_number" value="{{ $employee->document_number }}" placeholder="Numero de documento" required>
            </td>
        </tr>
        <tr>
            <td>
                <input class="form-control" type="text" name="names" value="{{ $employee->names }}" placeholder="Nombres" required>
            </td>
            <td>
                <input class="form-control" type="text" name="lastnames" value="{{ $employee->lastnames }}" placeholder="Apellidos" required>
            </td>
        </tr>
        <tr>
            <td  colspan="2">
                <input class="form-control" type="email" name="email" value="{{ $employee->email }}" placeholder="Correo" required>
            </td>
        </tr>
        <tr>
            <td>
                <input class="form-control" type="number" name="phone" value="{{ $employee->phone }}" placeholder="Telefono" required>
            </td>
            <td>
                <select class="form-select" name="job_id" required>
                    <option value="" disabled>Cargo</option>

                    @foreach ($jobs as $job)
                        @if ($job->id == $employee->job_id)
                            <option value="{{$job->id}}" selected>{{$job->job}}</option>
                        @else
                            <option value="{{$job->id}}">{{$job->job}}</option>
                        @endif
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <a href="{{ url('employees') }}"><button  class="btn btn-danger" type="button" onclick="cancelarform()">Cancelar</button></a>
                <a href=""><input class="btn btn-success" type="submit" name="btnregistrar" value="Registrar" onClick="javascript: return confirm ('¿Deseas registrar a este producto?');"></a>
            </td>
        </tr>
    </table>
</form>
@endsection
