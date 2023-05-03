@extends('app')
@section('content')
@if (session('success'))
    <h6 class="alert alert-success">{{ session('success') }}</h6>
@endif

@include('employees/error')


<div id="barrabuscar" class="mx-auto my-3">
    <form method="POST" class="">
        <div class="row">
            <div class="col-2 offset-2">
                <select class="form-select" name="option_search" id="option_search">
                    <option value="" selected disabled>Filtro</option>
                    <option value="id">ID</option>
                    <option value="name">Nombre</option>
                    <option value="document_number">Numero de documento</option>
                </select>
            </div>
            <div class="col-4">
                <input type="text" name="txtbuscar" id="cajabuscar" placeholder="Ingresar empleado" class="form form-control">
            </div>
            <div class="col-2">
                <input type="submit" value="Buscar" class="btn btn-success" name="btnbuscar">
            </div>
        </div>
    </form>
</div>
<table class="table table-sm table-hover text-center border-secondary rounded mx-auto" style="width:95%;">
    <thead class="border table-primary">
        <tr>
            <th colspan="8" class="text-center"><h1>LISTA DE EMPLEADOS</h1></th>
            <th>
                <button class="btn btn-primary my-auto" onclick="abrirform()">Agregar</button> | <a href="{{ route('employees.pdf') }}" class="btn btn-info my-auto">Informe</a>
            </th>
        </tr>
        <tr>
            <th>ID</th>
            <th>TIPO DE DOCUMENTO</th>
            <th>NUMERO DE DOCUMENTO</th>
            <th>NOMBRES</th>
            <th>APELLIDOS</th>
            <th>TELEFONO - CELULAR</th>
            <th>CORREO</th>
            <th>CARGO</th>
            <th>Accion</th>

        </tr>
    </thead>
    <tbody class="border" id="tbody-products">
        @foreach($employees as $employee)
        <tr>
            <td>{{ $employee->id }}</td>
            @foreach($document_types as $document_type)
                @if($employee->document_type_id == $document_type->id)
                    <td>{{ $document_type->document_type }}</td>
                @endif
            @endforeach
            <td>{{ $employee->document_number }}</td>
            <td>{{ $employee->names }}</td>
            <td>{{ $employee->lastnames }}</td>
            <td>{{ $employee->phone }}</td>
            <td>{{ $employee->email }}</td>
            @foreach($jobs as $job)
                @if($employee->job_id == $job->id)
                    <td>{{ $job->job }}</td>
                @endif
            @endforeach
            <td style="width: 20%;">
                <a href="{{ route('employees.show', [$employee->id]) }}"><button class="btn btn-success">Modificar</button></a> | <a href="#" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('delete-form-{{$employee->id}}').submit();">Eliminar</a>
                <form id="delete-form-{{$employee->id}}" action="{{ route('employees.destroy', [$employee->id]) }}" method="POST" style="display: none;">
                    @method('DELETE')
                    @csrf
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="row">
    <div class="col-2 offset-5">
        <nav class="" aria-label="Page navigation">
            <ul class="pagination">
                @if($page > 1)
                    <li class="page-item"><a class="page-link" href="{{ url('employees?num=1') }}">Inicio</a></li>
                    <li class="page-item"><a class="page-link" href="{{ url('employees?num=' . ($page - 1)) }}">{{ $page - 1 }}</a></li>
                @endif

                <li class="page-item"><a class="page-link" href="{{ url('employees?num=' . $page) }}">{{ $page }}</a></li>

                @if($page < $end)
                    <li class="page-item"><a class="page-link" href="{{ url('employees?num=' . ($page + 1)) }}">{{ $page + 1 }}</a></li>
                    <li class="page-item"><a class="page-link" href="{{ url('employees?num=' . $end) }}">Final</a></li>
                @endif

            </ul>
        </nav>
    </div>
</div>
<div class="caja_popup bg-white border rounded position-absolute top-50 start-50 translate-middle" style="width:40%;height:40%" id="formregistrar">
    <form action="{{ route('employees.store') }}" class="contenedor_popup" method="POST">
        @csrf
        <table>
            <tr><th colspan="2">Nuevo Empleado</th></tr>
            <tr>
                <td>
                    <select class="form-select" name="document_type_id" required>
                        <option value="" disabled selected>Tipo de documento</option>
                        @foreach($document_types as $document_type)
                        <option value="{{$document_type->id}}">{{$document_type->document_type}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input class="form-control" type="number" name="document_number" placeholder="Numero de documento" required>
                </td>
            </tr>
            <tr>
                <td>
                    <input class="form-control" type="text" name="names" placeholder="Nombres" required>
                </td>
                <td>
                    <input class="form-control" type="text" name="lastnames" placeholder="Apellidos" required>
                </td>
            </tr>
            <tr>
                <td  colspan="2">
                    <input class="form-control" type="email" name="email" placeholder="Correo" required>
                </td>
            </tr>
            <tr>
                <td>
                    <input class="form-control" type="number" name="phone" placeholder="Telefono" required>
                </td>
                <td>
                    <select class="form-select" name="job_id" required>
                        <option value="" disabled selected>Cargo</option>
                        @foreach($jobs as $job)
                        <option value="{{$job->id}}">{{$job->job}}</option>
                        @endforeach
                    </select>
                </td>
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
    <script src="{{ asset('/js/employees.js') }}"></script>
</div>
@endsection
